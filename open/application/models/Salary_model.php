<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salary_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all salary payments with full teacher and bank details
     */
    public function get_all() {
        $this->db->select('sp.*, t.name as teacher_name, t.joining_salary, t.email, t.phone, dsg.name as designation_name, b.bank_name, b.branch, a.name as approved_by_name');
        $this->db->from('salary_payment sp');
        $this->db->join('teacher t', 't.teacher_id = sp.teacher_id', 'left');
        $this->db->join('designation dsg', 'dsg.designation_id = t.designation_id', 'left');
        $this->db->join('bank b', 'b.bank_id = sp.bank_id', 'left');
        $this->db->join('admin a', 'a.admin_id = sp.approved_by', 'left');
        $this->db->order_by('sp.payment_year', 'DESC');
        $this->db->order_by('sp.payment_month', 'DESC');
        $this->db->order_by('t.name', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get pending salaries (awaiting approval)
     */
    public function get_pending() {
        $this->db->select('sp.*, t.name as teacher_name, t.email, t.phone, t.joining_salary, dsg.name as designation_name');
        $this->db->from('salary_payment sp');
        $this->db->join('teacher t', 't.teacher_id = sp.teacher_id', 'left');
        $this->db->join('designation dsg', 'dsg.designation_id = t.designation_id', 'left');
        $this->db->where('sp.status', 'pending');
        $this->db->order_by('sp.payment_year', 'DESC');
        $this->db->order_by('sp.payment_month', 'DESC');
        $this->db->order_by('t.name', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get approved salaries (ready to pay)
     */
    public function get_approved() {
        $this->db->select('sp.*, t.name as teacher_name, t.email, t.phone, t.joining_salary, b.bank_name, b.account_number');
        $this->db->from('salary_payment sp');
        $this->db->join('teacher t', 't.teacher_id = sp.teacher_id', 'left');
        $this->db->join('bank b', 'b.bank_id = sp.bank_id', 'left');
        $this->db->where('sp.status', 'approved');
        $this->db->order_by('sp.payment_year', 'DESC');
        $this->db->order_by('sp.payment_month', 'DESC');
        $this->db->order_by('t.name', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get paid salaries
     */
    public function get_paid() {
        $this->db->select('sp.*, t.name as teacher_name, t.phone, b.bank_name, b.account_number, a.name as approved_by_name');
        $this->db->from('salary_payment sp');
        $this->db->join('teacher t', 't.teacher_id = sp.teacher_id', 'left');
        $this->db->join('bank b', 'b.bank_id = sp.bank_id', 'left');
        $this->db->join('admin a', 'a.admin_id = sp.approved_by', 'left');
        $this->db->where('sp.status', 'paid');
        $this->db->order_by('sp.payment_year', 'DESC');
        $this->db->order_by('sp.payment_month', 'DESC');
        $this->db->order_by('t.name', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get salary by ID with all related data
     */
    public function get_by_id($salary_payment_id) {
        $this->db->select('sp.*, t.name as teacher_name, t.email, t.phone, t.joining_salary, t.date_of_joining, dsg.name as designation_name, b.bank_name, b.account_number, b.branch, a.name as approved_by_name');
        $this->db->from('salary_payment sp');
        $this->db->join('teacher t', 't.teacher_id = sp.teacher_id', 'left');
        $this->db->join('designation dsg', 'dsg.designation_id = t.designation_id', 'left');
        $this->db->join('bank b', 'b.bank_id = sp.bank_id', 'left');
        $this->db->join('admin a', 'a.admin_id = sp.approved_by', 'left');
        $this->db->where('sp.salary_payment_id', $salary_payment_id);
        $query = $this->db->get();
        return $query->row();
    }

    /**
     * Check if salary already exists for teacher in month/year
     */
    public function salary_exists($teacher_id, $month, $year) {
        $this->db->where('teacher_id', $teacher_id);
        $this->db->where('payment_month', $month);
        $this->db->where('payment_year', $year);
        $query = $this->db->get('salary_payment');
        return $query->num_rows() > 0;
    }

    /**
     * Generate salaries for all active teachers for a specific month/year
     * Uses teacher.joining_salary as the salary amount
     */
    public function generate_monthly_salaries($month, $year) {
        // Get all active teachers (status = 1)
        $this->db->where('status', 1);
        $teachers = $this->db->get('teacher')->result();
        
        $created = 0;
        foreach ($teachers as $teacher) {
            // Only create if doesn't already exist
            if (!$this->salary_exists($teacher->teacher_id, $month, $year)) {
                $data = array(
                    'teacher_id' => $teacher->teacher_id,
                    'amount' => $teacher->joining_salary ? floatval($teacher->joining_salary) : 0,
                    'payment_month' => intval($month),
                    'payment_year' => intval($year),
                    'status' => 'pending',
                    'created_at' => date('Y-m-d H:i:s')
                );
                $this->db->insert('salary_payment', $data);
                $created++;
            }
        }
        
        return $created;
    }

    /**
     * Approve a salary (mark as ready to pay)
     */
    public function approve($salary_payment_id) {
        $data = array(
            'status' => 'approved',
            'approved_by' => $this->session->userdata('accountant_id'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        $this->db->where('salary_payment_id', $salary_payment_id);
        return $this->db->update('salary_payment', $data);
    }

    /**
     * Mark salary as paid
     */
    public function mark_paid($salary_payment_id, $payment_method = null, $bank_id = null, $payment_date = null) {
        $data = array(
            'status' => 'paid',
            'payment_date' => $payment_date ? $payment_date : date('Y-m-d'),
            'payment_method' => $payment_method,
            'bank_id' => $bank_id,
            'updated_at' => date('Y-m-d H:i:s')
        );
        $this->db->where('salary_payment_id', $salary_payment_id);
        return $this->db->update('salary_payment', $data);
    }

    /**
     * Reject a salary with notes
     */
    public function reject($salary_payment_id, $notes = '') {
        $data = array(
            'status' => 'rejected',
            'notes' => $notes,
            'updated_at' => date('Y-m-d H:i:s')
        );
        $this->db->where('salary_payment_id', $salary_payment_id);
        return $this->db->update('salary_payment', $data);
    }

    /**
     * Get summary statistics
     */
    public function get_summary() {
        $summary = array(
            'pending' => 0,
            'approved' => 0,
            'paid' => 0,
            'pending_amount' => 0,
            'approved_amount' => 0
        );
        
        try {
            // Get summary with single query
            $query = "SELECT 
                        COUNT(CASE WHEN status='pending' THEN 1 END) as pending_count,
                        COUNT(CASE WHEN status='approved' THEN 1 END) as approved_count,
                        COUNT(CASE WHEN status='paid' THEN 1 END) as paid_count,
                        SUM(CASE WHEN status='pending' THEN amount ELSE 0 END) as pending_amount,
                        SUM(CASE WHEN status='approved' THEN amount ELSE 0 END) as approved_amount
                     FROM salary_payment";
            
            $result = $this->db->query($query)->row();
            
            if ($result) {
                $summary['pending'] = intval($result->pending_count);
                $summary['approved'] = intval($result->approved_count);
                $summary['paid'] = intval($result->paid_count);
                $summary['pending_amount'] = floatval($result->pending_amount ?? 0);
                $summary['approved_amount'] = floatval($result->approved_amount ?? 0);
            }
        } catch (Exception $e) {
            log_message('error', 'Error in get_summary: ' . $e->getMessage());
        }
        
        return $summary;
    }
}
?>
