<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Academic_management extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Academic_term_model');
		$this->load->model('Academic_year_model');
	}

	/**
	 * Display term schedule management page
	 */
	public function term_schedule()
	{
		// Get all academic years with their terms
		$data['academic_years'] = $this->Academic_year_model->get_all_years();
		$data['current_year'] = $this->Academic_year_model->get_current_year();
		$data['term_schedules'] = $this->Academic_term_model->get_all_terms_with_dates();
		
		$this->load->view('academic/term_schedule', $data);
	}

	/**
	 * Get terms for a specific academic year (AJAX)
	 */
	public function get_year_terms()
	{
		$academic_year_id = $this->input->post('academic_year_id');
		
		if (!$academic_year_id) {
			echo json_encode(['error' => 'Year ID required']);
			return;
		}

		$terms = $this->Academic_term_model->get_terms_by_year($academic_year_id);
		echo json_encode($terms);
	}

	/**
	 * Update term vacation and resumption dates
	 */
	public function update_term_dates()
	{
		$this->output->set_content_type('application/json');

		$academic_term_id = $this->input->post('academic_term_id');
		$vacation_date = $this->input->post('vacation_date');
		$resumption_date = $this->input->post('resumption_date');

		// Validate input
		if (!$academic_term_id || !$vacation_date || !$resumption_date) {
			echo json_encode(['success' => false, 'message' => 'Missing required fields']);
			return;
		}

		// Validate date format (YYYY-MM-DD)
		if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $vacation_date) || 
		    !preg_match('/^\d{4}-\d{2}-\d{2}$/', $resumption_date)) {
			echo json_encode(['success' => false, 'message' => 'Invalid date format. Use YYYY-MM-DD']);
			return;
		}

		// Validate resumption is after vacation
		if (strtotime($resumption_date) <= strtotime($vacation_date)) {
			echo json_encode(['success' => false, 'message' => 'Resumption date must be after vacation date']);
			return;
		}

		// Update in database
		$result = $this->Academic_term_model->update_term_dates(
			$academic_term_id,
			$vacation_date,
			$resumption_date
		);

		if ($result) {
			echo json_encode([
				'success' => true,
				'message' => 'Term dates updated successfully',
				'data' => [
					'vacation_date' => date('d M Y', strtotime($vacation_date)),
					'resumption_date' => date('d M Y', strtotime($resumption_date)),
					'days' => (strtotime($resumption_date) - strtotime($vacation_date)) / 86400
				]
			]);
		} else {
			echo json_encode(['success' => false, 'message' => 'Failed to update dates']);
		}
	}

	/**
	 * Set active term for current academic year
	 */
	public function set_active_term()
	{
		$this->output->set_content_type('application/json');

		$academic_term_id = $this->input->post('academic_term_id');

		if (!$academic_term_id) {
			echo json_encode(['success' => false, 'message' => 'Term ID required']);
			return;
		}

		$result = $this->Academic_term_model->set_active_term($academic_term_id);

		if ($result) {
			echo json_encode(['success' => true, 'message' => 'Active term updated']);
		} else {
			echo json_encode(['success' => false, 'message' => 'Failed to update active term']);
		}
	}

	/**
	 * Get current school session info (for display)
	 */
	public function get_current_session()
	{
		$this->output->set_content_type('application/json');

		$current = $this->Academic_term_model->get_current_active_term();

		if ($current) {
			echo json_encode([
				'success' => true,
				'data' => [
					'academic_year' => $current->year_name,
					'term' => $current->term_name,
					'end_date' => date('F d, Y', strtotime($current->vacation_date)),
					'next_start_date' => date('F d, Y', strtotime($current->resumption_date))
				]
			]);
		} else {
			echo json_encode(['success' => false, 'message' => 'No active term found']);
		}
	}
}
?>
