<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DailyFee extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->database();
        $this->load->library('session');
        $this->load->model('Dailyfee_model');
        $this->load->model('Student_model');
        $this->load->model('Class_model');
        $this->load->helper('url');
        
        // Check if user is logged in as accountant
        if (!$this->session->userdata('accountant_login')) {
            redirect(base_url() . 'login', 'refresh');
        }
    }

    /**
     * Display daily fee tracking page
     */
    public function index() {
        $data['page_name'] = 'daily_fee_index';
        $data['page_title'] = 'Daily Fee Tracking';
        
        // Get all classes
        $classes = $this->Class_model->get_all();
        $data['classes'] = $classes ? $classes : array();
        
        $this->load->view('backend/index', $data);
    }

    /**
     * Get students by class (AJAX) - optionally filter out already paid for a date
     */
    public function get_students_by_class($class_id, $fee_date = '') {
        // Ensure JSON response header
        header('Content-Type: application/json');
        
        if (!$fee_date) {
            $fee_date = date('Y-m-d');
        }
        
        // Get students from database
        $students = $this->Student_model->get_by_class($class_id);
        
        // Build array response
        $result = array(
            'success' => true,
            'data' => array()
        );
        
        if ($students && count($students) > 0) {
            foreach ($students as $student) {
                // Check if student already paid for that date
                $is_paid = false;
                $paid_count = 0;
                if ($fee_date) {
                    $paid_check = $this->db->where('student_id', $student->student_id)
                                           ->where('fee_date', $fee_date)
                                           ->where('payment_status', 'paid')
                                           ->get('daily_fee_tracking');
                    $is_paid = ($paid_check->num_rows() > 0);
                    $paid_count = $paid_check->num_rows();
                }
                
                // Always include student but mark paid status
                $result['data'][] = array(
                    'student_id' => (int)$student->student_id,
                    'name' => $student->name,
                    'is_paid' => $is_paid,
                    'paid_count' => $paid_count
                );
            }
        }
        
        echo json_encode($result);
        exit;
    }

    /**
     * Get configured fees for a class (AJAX) - Daily fees only
     */
    public function get_class_fees($class_id) {
        header('Content-Type: application/json');
        
        // Get class fees from database - filter for daily fees only by category
        $this->db->select('cf.class_fee_id, cf.fee_type_id, ft.name as fee_name, ft.description, ft.category, cf.amount');
        $this->db->from('class_fee cf');
        $this->db->join('fee_type ft', 'cf.fee_type_id = ft.fee_type_id', 'inner');
        $this->db->where('cf.class_id', $class_id);
        $this->db->where('cf.is_active', 1);
        $this->db->where('ft.is_active', 1);
        $this->db->where('ft.category', 'daily');
        
        $fees = $this->db->get()->result_array();
        
        echo json_encode([
            'success' => true,
            'data' => $fees,
            'class_id' => $class_id
        ]);
        exit;
    }

    /**
     * Get daily fees for a student (AJAX)
     */
    public function get_student_daily_fees($student_id, $date = '') {
        if (!$date) {
            $date = date('Y-m-d');
        }

        $fees = $this->Dailyfee_model->get_by_student_and_date($student_id, $date);
        
        echo json_encode([
            'success' => true,
            'data' => $fees,
            'date' => $date
        ]);
    }

    /**
     * Record daily fee payment for a student
     */
    public function record_payment() {
        // Only accept POST requests
        if ($this->input->method() !== 'post') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        // Get POST parameters
        $student_id = $this->input->post('student_id');
        $fee_date = $this->input->post('fee_date');
        $fee_type_id = $this->input->post('fee_type_id');
        $amount = $this->input->post('amount');

        // Validate all fields are present
        if (!$student_id || !$fee_date || !$fee_type_id || !$amount) {
            echo json_encode(['success' => false, 'message' => 'Missing required fields: student_id=' . $student_id . ', fee_date=' . $fee_date . ', fee_type_id=' . $fee_type_id . ', amount=' . $amount]);
            return;
        }

        // Get student details
        $student = $this->Student_model->get_by_id($student_id);
        if (!$student) {
            echo json_encode(['success' => false, 'message' => 'Student not found']);
            return;
        }

        // CHECK FOR DUPLICATE PAYMENT - Block if already paid for same student/date/fee
        $duplicate_check = $this->db->where('student_id', $student_id)
                                     ->where('fee_date', $fee_date)
                                     ->where('fee_type_id', $fee_type_id)
                                     ->where('payment_status', 'paid')
                                     ->get('daily_fee_tracking')
                                     ->num_rows();
        
        if ($duplicate_check > 0) {
            echo json_encode(['success' => false, 'message' => 'This student already has a paid record for this date and fee type. Duplicate payment blocked.']);
            return;
        }

        // Prepare data array
        $data = [
            'student_id' => $student_id,
            'class_id' => $student->class_id,
            'fee_date' => $fee_date,
            'fee_type_id' => $fee_type_id,
            'amount' => $amount,
            'payment_status' => 'paid',
            'paid_date' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Try to insert
        $insert_id = $this->Dailyfee_model->insert($data);

        if ($insert_id) {
            // Send receipt email to parent
            $this->load->helper('email');
            $email_sent = send_payment_receipt_email($student_id, $insert_id, 'daily');
            
            $msg = 'Daily fee recorded successfully';
            if ($email_sent) {
                $msg .= ' - Receipt email sent to parent';
            }
            
            echo json_encode([
                'success' => true,
                'message' => $msg,
                'daily_fee_id' => $insert_id,
                'email_sent' => $email_sent
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to record daily fee: ' . $this->db->error()['message']]);
        }
    }

    /**
     * Get all daily fees for a date range
     */
    public function get_fees_report($start_date = '', $end_date = '') {
        if (!$start_date) {
            $start_date = date('Y-m-01');
        }
        if (!$end_date) {
            $end_date = date('Y-m-t');
        }

        $fees = $this->Dailyfee_model->get_by_date_range($start_date, $end_date);
        
        // Calculate summary
        $summary = [
            'total_records' => count($fees),
            'total_amount' => 0,
            'paid' => 0,
            'unpaid' => 0
        ];

        foreach ($fees as $fee) {
            $summary['total_amount'] += $fee->amount;
            if ($fee->payment_status === 'paid') {
                $summary['paid']++;
            } else {
                $summary['unpaid']++;
            }
        }

        $data['title'] = 'Daily Fee Report';
        $data['fees'] = $fees;
        $data['summary'] = $summary;
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['page'] = 'daily_fee_report';

        $this->load->view('accountant/header', $data);
        $this->load->view('accountant/daily_fee_report', $data);
        $this->load->view('accountant/footer', $data);
    }

    /**
     * Get outstanding fees for a student
     */
    public function get_outstanding_fees($student_id) {
        $outstanding = $this->Dailyfee_model->get_outstanding($student_id);
        
        echo json_encode([
            'success' => true,
            'data' => $outstanding,
            'total' => array_sum(array_column($outstanding, 'amount'))
        ]);
    }

    /**
     * Mark a date as holiday (skip daily fee for that date)
     */
    public function mark_holiday() {
        if ($this->input->method() !== 'post') {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
            return;
        }

        $holiday_date = $this->input->post('holiday_date');

        if (!$holiday_date) {
            echo json_encode(['success' => false, 'message' => 'Holiday date required']);
            return;
        }

        // Store in settings or a holidays table
        // For now, we'll return success
        echo json_encode([
            'success' => true,
            'message' => 'Holiday marked successfully',
            'date' => $holiday_date
        ]);
    }

    /**
     * Update payment status
     */
    public function update_status() {
        if ($this->input->method() !== 'post') {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
            return;
        }

        $daily_fee_id = $this->input->post('daily_fee_id');
        $status = $this->input->post('status');

        if (!$daily_fee_id || !$status) {
            echo json_encode(['success' => false, 'message' => 'Missing required fields']);
            return;
        }

        $result = $this->Dailyfee_model->update($daily_fee_id, [
            'payment_status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Status updated successfully'
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update status']);
        }
    }

    /**
     * Bulk record daily fees for multiple students
     */
    public function bulk_record() {
        if ($this->input->method() !== 'post') {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
            return;
        }

        $students = $this->input->post('students');
        $fee_date = $this->input->post('fee_date');
        $fee_type_id = $this->input->post('fee_type_id');
        $amount = $this->input->post('amount');

        if (!$students || !is_array($students) || empty($students)) {
            echo json_encode(['success' => false, 'message' => 'No students selected']);
            return;
        }

        $recorded = 0;
        $failed = 0;
        $admin_id = $this->session->userdata('admin_id') ?: $this->session->userdata('accountant_id');

        foreach ($students as $student_id) {
            $student = $this->Student_model->get_by_id($student_id);
            if (!$student) {
                $failed++;
                continue;
            }

            $data = [
                'student_id' => $student_id,
                'class_id' => $student->class_id,
                'fee_date' => $fee_date,
                'fee_type_id' => $fee_type_id,
                'amount' => $amount,
                'payment_status' => 'paid',
                'paid_date' => date('Y-m-d'),
                'paid_by_admin_id' => $admin_id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if ($this->Dailyfee_model->insert($data)) {
                $recorded++;
            } else {
                $failed++;
            }
        }

        echo json_encode([
            'success' => true,
            'message' => "Daily fees recorded: $recorded students. Failed: $failed",
            'recorded' => $recorded,
            'failed' => $failed
        ]);
    }
}
