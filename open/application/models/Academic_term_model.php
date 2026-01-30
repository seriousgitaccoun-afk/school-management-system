<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Academic_term_model extends CI_Model {

	protected $table = 'academic_terms';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Get all terms with their academic year info and dates
	 */
	public function get_all_terms_with_dates()
	{
		$this->db->select('
			at.academic_term_id,
			ay.academic_year_id,
			ay.year_name,
			at.term_name,
			at.vacation_date,
			at.resumption_date,
			DATEDIFF(at.resumption_date, at.vacation_date) as days_vacation,
			at.is_active
		');
		$this->db->from('academic_terms at');
		$this->db->join('academic_years ay', 'at.academic_year_id = ay.academic_year_id');
		$this->db->order_by('ay.year_name DESC, at.academic_term_id ASC');
		
		return $this->db->get()->result();
	}

	/**
	 * Get terms for specific academic year
	 */
	public function get_terms_by_year($academic_year_id)
	{
		$this->db->select('
			academic_term_id,
			term_name,
			vacation_date,
			resumption_date,
			is_active,
			DATEDIFF(resumption_date, vacation_date) as days_vacation
		');
		$this->db->where('academic_year_id', $academic_year_id);
		$this->db->order_by('academic_term_id', 'ASC');
		
		return $this->db->get($this->table)->result();
	}

	/**
	 * Get currently active term
	 */
	public function get_current_active_term()
	{
		$this->db->select('
			at.academic_term_id,
			at.term_name,
			at.vacation_date,
			at.resumption_date,
			ay.year_name
		');
		$this->db->from('academic_terms at');
		$this->db->join('academic_years ay', 'at.academic_year_id = ay.academic_year_id');
		$this->db->where('at.is_active', 1);
		$this->db->limit(1);
		
		return $this->db->get()->row();
	}

	/**
	 * Update vacation and resumption dates for a term
	 */
	public function update_term_dates($academic_term_id, $vacation_date, $resumption_date)
	{
		$data = [
			'vacation_date' => $vacation_date,
			'resumption_date' => $resumption_date,
			'updated_at' => date('Y-m-d H:i:s')
		];

		$this->db->where('academic_term_id', $academic_term_id);
		return $this->db->update($this->table, $data);
	}

	/**
	 * Set a term as active (deactivate others in same year)
	 */
	public function set_active_term($academic_term_id)
	{
		// First, get the academic year of this term
		$term = $this->db->where('academic_term_id', $academic_term_id)->get($this->table)->row();
		
		if (!$term) {
			return false;
		}

		// Deactivate all terms in this academic year
		$this->db->where('academic_year_id', $term->academic_year_id);
		$this->db->update($this->table, ['is_active' => 0]);

		// Activate the selected term
		$this->db->where('academic_term_id', $academic_term_id);
		return $this->db->update($this->table, ['is_active' => 1]);
	}

	/**
	 * Create a new term (used by auto-creation procedure)
	 */
	public function create_term($academic_year_id, $term_name, $vacation_date = null, $resumption_date = null, $start_date = null, $end_date = null)
	{
		$data = [
			'academic_year_id' => $academic_year_id,
			'term_name' => $term_name,
			'vacation_date' => $vacation_date,
			'resumption_date' => $resumption_date,
			'is_active' => 0,
			'created_at' => date('Y-m-d H:i:s')
		];

		if ($start_date) $data['start_date'] = $start_date;
		if ($end_date) $data['end_date'] = $end_date;

		return $this->db->insert($this->table, $data);
	}

	/**
	 * Get term by ID
	 */
	public function get_term($academic_term_id)
	{
		return $this->db->where('academic_term_id', $academic_term_id)
			->get($this->table)
			->row();
	}
}
?>
