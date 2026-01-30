<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Score_entry_model extends CI_Model {

	protected $table = 'mark';  // Use existing mark table instead of score_entry

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Get current academic year (most recent or marked as current)
	 */
	public function get_current_academic_year()
	{
		// Try to get an explicitly marked current year first
		$this->db->select('academic_year_id, year_name, is_current');
		$this->db->from('academic_years');
		$this->db->where('is_current', 1);
		$result = $this->db->get()->row();

		if ($result) {
			return $result;
		}

		// If no year is marked current, attempt to auto-create based on today's date
		$created = $this->ensure_academic_year_exists_by_date();
		if ($created) {
			return $this->db->where('academic_year_id', $created->academic_year_id)
							->get('academic_years')->row();
		}

		// Fallback: get the most recent one
		$this->db->select('academic_year_id, year_name, is_current');
		$this->db->from('academic_years');
		$this->db->order_by('academic_year_id', 'DESC');
		$this->db->limit(1);
		return $this->db->get()->row();
	}

	/**
	 * Get current active term
	 */
	public function get_current_term()
	{
		$this->db->select('at.academic_term_id, at.academic_year_id, at.term_name, at.is_active, at.start_date, at.end_date');
		$this->db->from('academic_terms at');
		$this->db->where('at.is_active', 1);
		$this->db->limit(1);

		$result = $this->db->get()->row();
		// If we found an active term, return it
		if ($result) {
			return $result;
		}

		// No active term set - ensure academic year exists (may create defaults)
		$current_year = $this->get_current_academic_year();
		if ($current_year) {
			// Ensure default terms exist for the current year
			$this->create_default_terms_for_year($current_year->academic_year_id);

			// Try to find a term that contains today's date
			$today = date('Y-m-d');
			$this->db->select('academic_term_id, academic_year_id, term_name, is_active, start_date, end_date');
			$this->db->from('academic_terms');
			$this->db->where('academic_year_id', $current_year->academic_year_id);
			$this->db->where('start_date <=', $today);
			$this->db->where('end_date >=', $today);
			$this->db->limit(1);
			$term = $this->db->get()->row();

			if ($term) {
				// Mark this term as active and return
				$this->db->where('academic_term_id', $term->academic_term_id)->update('academic_terms', ['is_active' => 1]);
				// Deactivate others
				$this->db->where('academic_year_id', $current_year->academic_year_id);
				$this->db->where('academic_term_id !=', $term->academic_term_id);
				$this->db->update('academic_terms', ['is_active' => 0]);
				return $term;
			}

			// If a term is not found based on dates, pick the first term of the year
			$this->db->select('academic_term_id, academic_year_id, term_name, is_active, start_date, end_date');
			$this->db->from('academic_terms');
			$this->db->where('academic_year_id', $current_year->academic_year_id);
			$this->db->order_by('academic_term_id', 'ASC');
			$this->db->limit(1);
			$result = $this->db->get()->row();
			if ($result) {
				// mark first term active
				$this->db->where('academic_term_id', $result->academic_term_id)->update('academic_terms', ['is_active' => 1]);
				// Deactivate others for the year
				$this->db->where('academic_year_id', $current_year->academic_year_id);
				$this->db->where('academic_term_id !=', $result->academic_term_id);
				$this->db->update('academic_terms', ['is_active' => 0]);
			}
		}

		return $result;
	}

	/**
	 * Compute start year for an academic year based on a date
	 * If the date is in Jul-Dec we treat it as start year of the same year, else previous
	 */
	private function compute_academic_year_start_year($date = null)
	{
		if (!$date) $date = date('Y-m-d');
		$ts = strtotime($date);
		$month = intval(date('n', $ts));
		$year = intval(date('Y', $ts));
		// If month >= 7 (July), we treat start year = current year
		if ($month >= 7) {
			return $year;
		}
		// Otherwise, the year belongs to previous start year (e.g., Jan-Jun -> academic start last year)
		return $year - 1;
	}

	/**
	 * Build year label string from start year
	 * e.g., 2025 -> "2025/2026"
	 */
	private function build_year_label_from_start($start_year)
	{
		return sprintf('%d/%d', $start_year, $start_year + 1);
	}

	/**
	 * Ensure an academic year exists for a given date (default: today)
	 * Will create the academic year and default terms if missing
	 */
	public function ensure_academic_year_exists_by_date($date = null)
	{
		$start_year = $this->compute_academic_year_start_year($date);
		$year_label = $this->build_year_label_from_start($start_year);

		$existing = $this->db->where('year_name', $year_label)->get('academic_years')->row();
		if ($existing) {
			// Ensure only this is marked current
			$this->db->where('year_name !=', $year_label)->update('academic_years', ['is_current' => 0]);
			$this->db->where('year_name', $year_label)->update('academic_years', ['is_current' => 1]);
			// Ensure terms for the year exist
			$this->create_default_terms_for_year($existing->academic_year_id, $start_year);
			return $existing;
		}

		// Insert new academic year
		$start_date = sprintf('%d-09-01', $start_year);
		$end_date = sprintf('%d-08-31', $start_year + 1);
		$data = [
			'year_name' => $year_label,
			'start_date' => $start_date,
			'end_date' => $end_date,
			'is_current' => 1
		];

		// Mark other years as not current
		$this->db->update('academic_years', ['is_current' => 0]);
		$this->db->insert('academic_years', $data);
		$insert_id = $this->db->insert_id();
		$new_row = $this->db->where('academic_year_id', $insert_id)->get('academic_years')->row();

		// Create default 3 terms for this academic year
		if ($new_row) {
			$this->create_default_terms_for_year($new_row->academic_year_id, $start_year);
		}
		return $new_row;
	}

	/**
	 * Create default terms for an academic year (does nothing if terms already exist)
	 * Term definitions may be provided, else defaults are used
	 */
	public function create_default_terms_for_year($academic_year_id, $start_year = null, $terms = null)
	{
		if (!$start_year) {
			$ay = $this->db->where('academic_year_id', $academic_year_id)->get('academic_years')->row();
			if ($ay) {
				// parse start year from label
				$parts = explode('/', $ay->year_name);
				$start_year = intval($parts[0]);
			}
		}
		if (!$start_year) return false;

		// Determine how many terms exist; we will ensure there are at least 3 terms
		$count = $this->db->where('academic_year_id', $academic_year_id)->count_all_results('academic_terms');
		if ($count >= 3) return true; // Already have 3+ terms; do nothing

		// default 3 terms with sensible dates
		$default_terms = [
			[
				'term_name' => 'Term 1',
				'start_date' => sprintf('%d-09-01', $start_year),
				'end_date' => sprintf('%d-12-31', $start_year),
				'vacation_date' => sprintf('%d-12-24', $start_year),
				'resumption_date' => sprintf('%d-01-06', $start_year + 1),
				'is_active' => 0
			],
			[
				'term_name' => 'Term 2',
				'start_date' => sprintf('%d-01-01', $start_year + 1),
				'end_date' => sprintf('%d-04-30', $start_year + 1),
				'vacation_date' => sprintf('%d-04-30', $start_year + 1),
				'resumption_date' => sprintf('%d-05-10', $start_year + 1),
				'is_active' => 0
			],
			[
				'term_name' => 'Term 3',
				'start_date' => sprintf('%d-05-01', $start_year + 1),
				'end_date' => sprintf('%d-07-31', $start_year + 1),
				'vacation_date' => sprintf('%d-07-31', $start_year + 1),
				'resumption_date' => sprintf('%d-09-01', $start_year + 1),
				'is_active' => 0
			]
		];

		// Use the provided terms if any
		if (is_array($terms) && count($terms) > 0) {
			$default_terms = $terms;
		}

		// Only create as many default terms as needed to get to 3
		$to_create = max(0, 3 - $count);
		$created = 0;
		foreach ($default_terms as $t) {
			if ($created >= $to_create) break;
			$insert = [
				'academic_year_id' => $academic_year_id,
				'term_name' => $t['term_name'],
				'start_date' => $t['start_date'],
				'end_date' => $t['end_date'],
				'vacation_date' => $t['vacation_date'] ?? null,
				'resumption_date' => $t['resumption_date'] ?? null,
				'is_active' => $t['is_active'] ?? 0
			];
			$this->db->insert('academic_terms', $insert);
			$created++;
		}

		// After creating the terms, determine which term should be active based on today's date
		$today = date('Y-m-d');
		$this->db->select('academic_term_id');
		$this->db->from('academic_terms');
		$this->db->where('academic_year_id', $academic_year_id);
		$this->db->where('start_date <=', $today);
		$this->db->where('end_date >=', $today);
		$row = $this->db->get()->row();
		if ($row) {
			// Set this as active
			$this->db->where('academic_year_id', $academic_year_id)->update('academic_terms', ['is_active' => 0]);
			$this->db->where('academic_term_id', $row->academic_term_id)->update('academic_terms', ['is_active' => 1]);
		}

		return true;
	}

	/**
	 * Get all terms for a specific academic year
	 */
	public function get_terms_by_year($academic_year_id)
	{
		$this->db->select('academic_term_id, term_name, is_active, vacation_date, resumption_date');
		$this->db->where('academic_year_id', $academic_year_id);
		$this->db->order_by('academic_term_id', 'ASC');
		
		return $this->db->get('academic_terms')->result_array();
	}

	/**
	 * Insert or update score entry
	 */
	public function save_score_entry($data)
	{
		// For mark table: check if record already exists (student, subject, exam_id)
		$existing = $this->db->where([
			'student_id' => $data['student_id'],
			'subject_id' => $data['subject_id'],
			'exam_id' => $data['exam_id'],
			'class_id' => $data['class_id']
		])->get($this->table)->row();

		if ($existing) {
			// Update existing record
			$this->db->where('mark_id', $existing->mark_id);
			return $this->db->update($this->table, $data);
		} else {
			// Insert new record
			return $this->db->insert($this->table, $data);
		}
	}

	/**
	 * Get score entry for a student, term, and subject
	 */
	public function get_score_entry($student_id, $academic_term_id, $subject_id)
	{
		return $this->db->where([
			'student_id' => $student_id,
			'academic_term_id' => $academic_term_id,
			'subject_id' => $subject_id
		])->get($this->table)->row();
	}

	/**
	 * Get all scores for a student in a term
	 */
	public function get_student_term_scores($student_id, $academic_term_id)
	{
		$this->db->select('
			se.score_entry_id,
			se.student_id,
			se.academic_term_id,
			se.subject_id,
			se.emt1_score,
			se.emt2_score,
			se.emt3_score,
			se.sba_assessment_score,
			se.project_score,
			se.exam_score,
			se.class_score_report,
			se.exams_score_report,
			se.total_score,
			se.equivalent_numerical_grade,
			se.level_of_proficiency,
			se.teacher_comment,
			s.name as subject_name
		');
		$this->db->from($this->table . ' se');
		$this->db->join('subject s', 'se.subject_id = s.subject_id');
		$this->db->where('se.student_id', $student_id);
		$this->db->where('se.academic_term_id', $academic_term_id);
		$this->db->order_by('s.name', 'ASC');
		
		return $this->db->get()->result_array();
	}

	/**
	 * Calculate class score (average of EMT1, EMT2, EMT3)
	 * Formula: (EMT1 + EMT2 + EMT3) / 3
	 */
	public function calculate_class_score($emt1, $emt2, $emt3)
	{
		$emt1 = floatval($emt1 ?? 0);
		$emt2 = floatval($emt2 ?? 0);
		$emt3 = floatval($emt3 ?? 0);
		return ($emt1 + $emt2 + $emt3) / 3;
	}

	/**
	 * Calculate total score
	 * Formula: (class_score * 0.5) + (exam_score * 0.5)
	 */
	public function calculate_total_score($class_score, $exam_score)
	{
		$class_score = floatval($class_score ?? 0);
		$exam_score = floatval($exam_score ?? 0);
		return ($class_score * 0.5) + ($exam_score * 0.5);
	}

	/**
	 * Get grade and proficiency from total score
	 */
	public function get_grade_and_proficiency($total_score)
	{
		$this->db->select('grade_letter, proficiency_level, meaning');
		$this->db->from('proficiency_levels');
		$this->db->where('min_score <=', $total_score);
		$this->db->where('max_score >=', $total_score);
		$this->db->limit(1);
		
		return $this->db->get()->row();
	}

	/**
	 * Bulk get subjects for a class (with teacher info)
	 */
	public function get_class_subjects($class_id)
	{
		$this->db->select('
			cs.subject_id,
			cs.class_id,
			s.name as subject_name,
			cs.teacher_id
		');
		$this->db->from('class_subjects cs');
		$this->db->join('subject s', 'cs.subject_id = s.subject_id');
		$this->db->where('cs.class_id', $class_id);
		$this->db->where('cs.is_active', 1);
		$this->db->order_by('s.name', 'ASC');
		
		return $this->db->get()->result_array();
	}

	/**
	 * Initialize score entries for a student in a term
	 * Creates empty records if they don't exist yet
	 */
	public function initialize_student_scores($student_id, $academic_term_id, $class_id)
	{
		$subjects = $this->get_class_subjects($class_id);
		
		foreach ($subjects as $subject) {
			$existing = $this->db->where([
				'student_id' => $student_id,
				'academic_term_id' => $academic_term_id,
				'subject_id' => $subject['subject_id']
			])->get($this->table)->num_rows();

			if ($existing == 0) {
				$data = [
					'student_id' => $student_id,
					'academic_term_id' => $academic_term_id,
					'subject_id' => $subject['subject_id'],
					'entered_by' => $this->session->userdata('login_id'),
					'entered_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
				];
				$this->db->insert($this->table, $data);
			}
		}
	}

	/**
	 * Get teacher's custom grading structure for a subject
	 * Returns grading_components_json if exists, null otherwise
	 * 
	 * @param int $teacher_id - Teacher ID
	 * @param int $subject_id - Subject ID
	 * @return array|null - Array of components or null if using default
	 */
	public function get_grading_structure($teacher_id, $subject_id)
	{
		// Get the latest score entry for this teacher's subject with custom grading
		$this->db->select('grading_components_json');
		$this->db->from($this->table);
		$this->db->where('subject_id', $subject_id);
		$this->db->where('entered_by', $teacher_id);
		$this->db->where('grading_components_json IS NOT NULL', null, false);
		$this->db->order_by('created_at', 'DESC');
		$this->db->limit(1);
		
		$result = $this->db->get()->row();
		
		if ($result && !empty($result->grading_components_json)) {
			return json_decode($result->grading_components_json, true);
		}
		
		return null;
	}

	/**
	 * Scale a value to 50 based on max value
	 * Helper function for class score scaling
	 * 
	 * @param float $value - The value to scale
	 * @param float $max_value - The maximum value for this component
	 * @param float $target - Target scale (default 50)
	 * @return float - Scaled value
	 */
	public function scale_class_score($value, $max_value, $target = 50)
	{
		if ($max_value == 0 || $value == 0) {
			return 0;
		}
		
		$ratio = floatval($value) / floatval($max_value);
		return round($ratio * $target, 2);
	}

	/**
	 * Calculate total score using custom grading components
	 * 
	 * Class scores: Sum all non-exam components, scale to 50
	 * Exam score: Divide by 2 to get 50 points
	 * Total: Always 100
	 * 
	 * @param array $custom_scores - {component_name: value, ...}
	 * @param array $grading_components - [{name, max_value, is_exam}, ...]
	 * @return float - Total score (0-100)
	 */
	public function calculate_custom_total_score($custom_scores, $grading_components)
	{
		if (empty($custom_scores) || empty($grading_components)) {
			return 0;
		}

		$class_score_sum = 0;
		$class_score_max_sum = 0;
		$exam_score = 0;

		// Iterate through components and categorize
		foreach ($grading_components as $component) {
			$component_name = strtolower(str_replace(' ', '_', trim($component['name'])));
			$value = isset($custom_scores[$component_name]) ? floatval($custom_scores[$component_name]) : 0;
			$max_value = floatval($component['max_value']);

			if (isset($component['is_exam']) && $component['is_exam']) {
				// This is exam score - divide by 2
				$exam_score = $value / 2;
			} else {
				// This is class score - add to sum
				$class_score_sum += $value;
				$class_score_max_sum += $max_value;
			}
		}

		// Scale class score sum to 50
		$scaled_class_score = 0;
		if ($class_score_max_sum > 0) {
			$scaled_class_score = $this->scale_class_score($class_score_sum, $class_score_max_sum, 50);
		}

		// Total = scaled class (50) + exam/2 (50) = 100
		$total = $scaled_class_score + $exam_score;

		return round(min($total, 100), 2); // Cap at 100
	}

	/**
	 * Sanitize column name for database consistency
	 * Converts spaces to underscores, lowercase
	 * 
	 * @param string $name - Column name
	 * @return string - Sanitized name
	 */
	public function sanitize_column_name($name)
	{
		// Convert to lowercase
		$name = strtolower(trim($name));
		// Replace spaces with underscores
		$name = str_replace(' ', '_', $name);
		// Remove special characters except underscore
		$name = preg_replace('/[^a-z0-9_]/', '', $name);
		// Remove leading/trailing underscores
		$name = trim($name, '_');
		
		return $name;
	}

	/**
	 * Delete all scores for a teacher's subject
	 * Used when switching grading structures
	 * 
	 * @param int $teacher_id - Teacher ID
	 * @param int $subject_id - Subject ID
	 * @return bool - Success
	 */
	public function delete_subject_scores($teacher_id, $subject_id)
	{
		$this->db->where('subject_id', $subject_id);
		$this->db->where('entered_by', $teacher_id);
		return $this->db->delete($this->table);
	}
}
?>
