<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Academic_year_model extends CI_Model {

	protected $table = 'academic_years';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Get all academic years
	 */
	public function get_all_years()
	{
		return $this->db->order_by('year_name', 'DESC')
			->get($this->table)
			->result();
	}

	/**
	 * Get current academic year
	 */
	public function get_current_year()
	{
		return $this->db->where('is_current', 1)
			->get($this->table)
			->row();
	}

	/**
	 * Get academic year by ID
	 */
	public function get_year($academic_year_id)
	{
		return $this->db->where('academic_year_id', $academic_year_id)
			->get($this->table)
			->row();
	}

	/**
	 * Create new academic year
	 */
	public function create_year($year_name)
	{
		$data = [
			'year_name' => $year_name,
			'is_current' => 0,
			'created_at' => date('Y-m-d H:i:s')
		];

		return $this->db->insert($this->table, $data);
	}

	/**
	 * Update academic year details
	 */
	public function update_year($academic_year_id, $data)
	{
		$data['updated_at'] = date('Y-m-d H:i:s');
		$this->db->where('academic_year_id', $academic_year_id);
		return $this->db->update($this->table, $data);
	}

	/**
	 * Delete year
	 */
	public function delete_year($academic_year_id)
	{
		return $this->db->where('academic_year_id', $academic_year_id)->delete($this->table);
	}

	/**
	 * Set as current year (deactivate others)
	 */
	public function set_current_year($academic_year_id)
	{
		$this->db->update($this->table, ['is_current' => 0]);
		$this->db->where('academic_year_id', $academic_year_id);
		return $this->db->update($this->table, ['is_current' => 1]);
	}
}
?>
