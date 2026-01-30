<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dailyfee_model extends CI_Model {

    private $table = 'daily_fee_tracking';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Insert a new daily fee record
     */
    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Get all daily fees
     */
    public function get_all() {
        $query = $this->db->get($this->table);
        return $query->result();
    }

    /**
     * Get daily fee by ID
     */
    public function get_by_id($daily_fee_id) {
        $this->db->where('daily_fee_id', $daily_fee_id);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    /**
     * Get daily fees by student ID and date
     */
    public function get_by_student_and_date($student_id, $date) {
        $this->db->where('student_id', $student_id);
        $this->db->where('fee_date', $date);
        $query = $this->db->get($this->table);
        return $query->result();
    }

    /**
     * Get daily fees by date range
     */
    public function get_by_date_range($start_date, $end_date) {
        $this->db->where('fee_date >=', $start_date);
        $this->db->where('fee_date <=', $end_date);
        $this->db->order_by('fee_date', 'DESC');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    /**
     * Get outstanding fees for a student
     */
    public function get_outstanding($student_id) {
        $this->db->select('*');
        $this->db->where('student_id', $student_id);
        $this->db->where('payment_status', 'unpaid');
        $this->db->order_by('fee_date', 'DESC');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    /**
     * Get outstanding fees with student and class details
     */
    public function get_outstanding_with_details($student_id = null) {
        $this->db->select('dft.*, s.name as student_name, c.name as class_name, ft.name as fee_type_name');
        $this->db->from($this->table . ' dft');
        $this->db->join('student s', 's.student_id = dft.student_id', 'left');
        $this->db->join('class c', 'c.class_id = dft.class_id', 'left');
        $this->db->join('fee_type ft', 'ft.fee_type_id = dft.fee_type_id', 'left');
        $this->db->where('dft.payment_status', 'unpaid');
        
        if ($student_id) {
            $this->db->where('dft.student_id', $student_id);
        }
        
        $this->db->order_by('dft.fee_date', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get daily fees by class and date
     */
    public function get_by_class_and_date($class_id, $date) {
        $this->db->select('dft.*, s.name as student_name, ft.name as fee_type_name');
        $this->db->from($this->table . ' dft');
        $this->db->join('student s', 's.student_id = dft.student_id', 'left');
        $this->db->join('fee_type ft', 'ft.fee_type_id = dft.fee_type_id', 'left');
        $this->db->where('dft.class_id', $class_id);
        $this->db->where('dft.fee_date', $date);
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Update daily fee record
     */
    public function update($daily_fee_id, $data) {
        $this->db->where('daily_fee_id', $daily_fee_id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Delete daily fee record
     */
    public function delete($daily_fee_id) {
        $this->db->where('daily_fee_id', $daily_fee_id);
        return $this->db->delete($this->table);
    }

    /**
     * Get summary statistics
     */
    public function get_summary($start_date, $end_date) {
        $this->db->select('COUNT(*) as total_records, SUM(amount) as total_amount, 
                          SUM(CASE WHEN payment_status = "paid" THEN 1 ELSE 0 END) as paid_count,
                          SUM(CASE WHEN payment_status = "unpaid" THEN 1 ELSE 0 END) as unpaid_count');
        $this->db->where('fee_date >=', $start_date);
        $this->db->where('fee_date <=', $end_date);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    /**
     * Get daily fees by payment status
     */
    public function get_by_status($status, $start_date = null, $end_date = null) {
        $this->db->where('payment_status', $status);
        
        if ($start_date && $end_date) {
            $this->db->where('fee_date >=', $start_date);
            $this->db->where('fee_date <=', $end_date);
        }
        
        $this->db->order_by('fee_date', 'DESC');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    /**
     * Check if a fee already exists for a student on a date
     */
    public function exists($student_id, $fee_date, $fee_type_id = null) {
        $this->db->where('student_id', $student_id);
        $this->db->where('fee_date', $fee_date);
        
        if ($fee_type_id) {
            $this->db->where('fee_type_id', $fee_type_id);
        }
        
        $query = $this->db->get($this->table);
        return $query->num_rows() > 0;
    }
}
