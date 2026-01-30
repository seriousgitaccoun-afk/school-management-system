<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salary extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->database();
        $this->load->library('session');
        $this->load->model('Salary_model');
        $this->load->helper('url');
        
        // Check if user is logged in as accountant
        if (!$this->session->userdata('accountant_login')) {
            redirect(base_url() . 'login', 'refresh');
        }
    }

    /**
     * Main salary dashboard
     */
    public function index() {
        $data['page_name'] = 'salary_index';
        $data['page_title'] = 'Salary Management';
        $data['salaries'] = $this->Salary_model->get_all();
        $data['summary'] = $this->Salary_model->get_summary();
        
        $this->load->view('backend/index', $data);
    }

    /**
     * Generate salaries for a month
     */
    public function generate_monthly() {
        $month = $this->input->post('month');
        $year = $this->input->post('year');
        
        if (!$month || !$year) {
            $this->session->set_flashdata('error', 'Please select month and year');
            redirect('salary');
        }
        
        // Check if salaries already exist for this month
        $this->db->where('payment_month', $month);
        $this->db->where('payment_year', $year);
        $existing = $this->db->get('salary_payment')->num_rows();
        
        if ($existing > 0) {
            $this->session->set_flashdata('warning', 'Salaries already exist for this month');
            redirect('salary');
        }
        
        $created = $this->Salary_model->generate_monthly_salaries($month, $year);
        
        if ($created > 0) {
            $this->session->set_flashdata('success', $created . ' salary records generated for ' . $this->_month_name($month) . ' ' . $year);
        } else {
            $this->session->set_flashdata('info', 'No active teachers found to generate salaries');
        }
        
        redirect('salary');
    }

    /**
     * View pending salaries
     */
    public function pending() {
        $data['page_name'] = 'salary_pending';
        $data['page_title'] = 'Pending Salaries';
        $data['salaries'] = $this->Salary_model->get_pending();
        $data['summary'] = $this->Salary_model->get_summary();
        
        $this->load->view('backend/index', $data);
    }

    /**
     * View approved salaries (ready to pay)
     */
    public function approved() {
        $data['page_name'] = 'salary_approved';
        $data['page_title'] = 'Approved Salaries';
        $data['salaries'] = $this->Salary_model->get_approved();
        $data['summary'] = $this->Salary_model->get_summary();
        
        $this->load->view('backend/index', $data);
    }

    /**
     * View paid salaries
     */
    public function paid() {
        $data['page_name'] = 'salary_paid';
        $data['page_title'] = 'Paid Salaries';
        $data['salaries'] = $this->Salary_model->get_paid();
        $data['summary'] = $this->Salary_model->get_summary();
        
        $this->load->view('backend/index', $data);
    }

    /**
     * Approve a salary
     */
    public function approve($salary_payment_id = null) {
        if (!$salary_payment_id) {
            $this->session->set_flashdata('error', 'Invalid salary ID');
            redirect('salary/pending');
        }
        
        if ($this->Salary_model->approve($salary_payment_id)) {
            $this->session->set_flashdata('success', 'Salary approved successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to approve salary');
        }
        
        redirect('salary/pending');
    }

    /**
     * Mark salary as paid
     */
    public function mark_paid($salary_payment_id = null) {
        if (!$salary_payment_id) {
            $this->session->set_flashdata('error', 'Invalid salary ID');
            redirect('salary/approved');
        }
        
        $payment_method = $this->input->post('payment_method');
        $bank_id = $this->input->post('bank_id');
        
        if ($this->Salary_model->mark_paid($salary_payment_id, $payment_method, $bank_id)) {
            $this->session->set_flashdata('success', 'Salary marked as paid');
        } else {
            $this->session->set_flashdata('error', 'Failed to mark salary as paid');
        }
        
        redirect('salary/approved');
    }

    /**
     * Reject a salary
     */
    public function reject($salary_payment_id = null) {
        if (!$salary_payment_id) {
            $this->session->set_flashdata('error', 'Invalid salary ID');
            redirect('salary/pending');
        }
        
        $notes = $this->input->post('notes');
        
        if ($this->Salary_model->reject($salary_payment_id, $notes)) {
            $this->session->set_flashdata('success', 'Salary rejected');
        } else {
            $this->session->set_flashdata('error', 'Failed to reject salary');
        }
        
        redirect('salary/pending');
    }

    /**
     * Convert month number to name
     */
    private function _month_name($month) {
        $months = array(
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
        );
        return isset($months[$month]) ? $months[$month] : 'Unknown';
    }
}
?>
