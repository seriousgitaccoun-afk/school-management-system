<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Accountant extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->database();
        $this->load->library('session');
        $this->load->helper('avatar');                          //Load avatar helper
        
        // Check if user is logged in as accountant
        if (!$this->session->userdata('accountant_login')) {
            redirect(base_url() . 'login', 'refresh');
        }
    }

    /**
     * Dashboard - Financial Overview
     */
    public function dashboard() {
        $page_data['page_name'] = 'dashboard';
        $page_data['page_title'] = get_phrase('Dashboard');
        
        // Get invoice statistics
        $page_data['total_invoices'] = $this->db->count_all('invoice');
        $page_data['paid_invoices'] = $this->db->get_where('invoice', array('status' => 2))->num_rows();
        $page_data['unpaid_invoices'] = $this->db->get_where('invoice', array('status' => 1))->num_rows();
        
        // Get payment statistics using existing payment table
        $this->db->select_sum('amount');
        $this->db->where('payment_type', 'income');
        $total_income = $this->db->get('payment')->row();
        $page_data['total_received'] = ($total_income && $total_income->amount) ? $total_income->amount : 0;
        
        // Get expense statistics
        $this->db->reset_query();
        $this->db->select_sum('amount');
        $this->db->where('payment_type', 'expense');
        $total_expense = $this->db->get('payment')->row();
        $page_data['total_expenses'] = ($total_expense && $total_expense->amount) ? $total_expense->amount : 0;
        
        // Get net balance
        $page_data['net_balance'] = $page_data['total_received'] - $page_data['total_expenses'];
        
        // Get recent transactions
        $this->db->reset_query();
        $this->db->order_by('timestamp', 'DESC');
        $this->db->limit(10);
        $page_data['recent_transactions'] = $this->db->get('payment')->result_array();
        
        $this->load->view('backend/index', $page_data);
    }

    /**
     * Invoice Management
     */
    public function invoices() {
        // Handle invoice creation
        if ($this->input->post('add_invoice')) {
            $data = array(
                'invoice_number' => 'INV-' . time(),
                'student_id' => $this->input->post('student_id'),
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'amount' => $this->input->post('amount'),
                'discount' => $this->input->post('discount') ? $this->input->post('discount') : 0,
                'amount_paid' => 0,
                'due' => $this->input->post('amount') - ($this->input->post('discount') ? $this->input->post('discount') : 0),
                'creation_timestamp' => date('Y-m-d H:i:s'),
                'payment_method' => $this->input->post('payment_method'),
                'status' => 1,
                'year' => $this->input->post('year')
            );
            
            $this->db->insert('invoice', $data);
            $this->session->set_flashdata('success', get_phrase('Invoice created successfully'));
            redirect(base_url() . 'accountant/invoices');
        }
        
        // Handle invoice deletion
        if ($this->input->post('delete_invoice')) {
            $invoice_id = $this->input->post('invoice_id');
            $this->db->delete('invoice', array('invoice_id' => $invoice_id));
            $this->session->set_flashdata('success', get_phrase('Invoice deleted'));
            redirect(base_url() . 'accountant/invoices');
        }
        
        // Handle invoice update
        if ($this->input->post('edit_invoice')) {
            $invoice_id = $this->input->post('invoice_id');
            $data = array(
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'amount' => $this->input->post('amount'),
                'discount' => $this->input->post('discount') ? $this->input->post('discount') : 0,
                'due' => $this->input->post('amount') - ($this->input->post('discount') ? $this->input->post('discount') : 0)
            );
            $this->db->update('invoice', $data, array('invoice_id' => $invoice_id));
            $this->session->set_flashdata('success', get_phrase('Invoice updated'));
            redirect(base_url() . 'accountant/invoices');
        }
        
        $page_data['page_name'] = 'invoices';
        $page_data['page_title'] = get_phrase('Invoices');
        
        $this->db->order_by('invoice_id', 'DESC');
        $page_data['invoices'] = $this->db->get('invoice')->result_array();
        
        // Get students for dropdown
        $page_data['students'] = $this->db->get('student')->result_array();
        
        // Fetch daily fees with student and class details
        $this->db->select('df.*, s.name as student_name, c.name as class_name, ft.name as fee_type_name');
        $this->db->from('daily_fee_tracking df');
        $this->db->join('student s', 'df.student_id = s.student_id', 'left');
        $this->db->join('class c', 'df.class_id = c.class_id', 'left');
        $this->db->join('fee_type ft', 'df.fee_type_id = ft.fee_type_id', 'left');
        $this->db->order_by('df.fee_date', 'DESC');
        $page_data['daily_fees'] = $this->db->get()->result_array();
        
        // Fetch tuition payments with student and class details
        $this->db->select('tp.*, s.name as student_name, c.name as class_name');
        $this->db->from('tuition_payment tp');
        $this->db->join('student s', 'tp.student_id = s.student_id', 'left');
        $this->db->join('class c', 'tp.class_id = c.class_id', 'left');
        $this->db->order_by('tp.payment_date', 'DESC');
        $page_data['tuition_payments'] = $this->db->get()->result_array();
        
        $this->load->view('backend/index', $page_data);
    }

    /**
     * View Invoice Detail
     */
    public function invoice_detail($invoice_id = null) {
        if (!$invoice_id) {
            $this->session->set_flashdata('error', get_phrase('Invalid invoice'));
            redirect(base_url() . 'accountant/invoices');
        }

        // Get invoice details
        $invoice = $this->db->get_where('invoice', array('invoice_id' => $invoice_id))->row_array();
        
        if (!$invoice) {
            $this->session->set_flashdata('error', get_phrase('Invoice not found'));
            redirect(base_url() . 'accountant/invoices');
        }

        // Get student details
        $student = $this->db->get_where('student', array('student_id' => $invoice['student_id']))->row_array();
        
        // Get current logged-in accountant info
        $current_accountant = $this->db->get_where('accountant', array('accountant_id' => $this->session->userdata('user_id')))->row_array();
        
        $page_data['invoice'] = $invoice;
        $page_data['student'] = $student;
        $page_data['current_accountant'] = $current_accountant;
        $page_data['page_name'] = 'invoice_detail';
        $page_data['page_title'] = get_phrase('Invoice Detail');
        
        $this->load->view('backend/accountant/invoice_detail', $page_data);
    }

    /**
     * Payment Recording - Using existing payment table
     */
    public function payments() {
        // Handle payment recording
        if ($this->input->post('add_payment')) {
            $data = array(
                'title' => $this->input->post('title'),
                'payment_type' => $this->input->post('payment_type'),
                'invoice_id' => $this->input->post('invoice_id') ? $this->input->post('invoice_id') : '',
                'student_id' => $this->input->post('student_id') ? $this->input->post('student_id') : '',
                'amount' => $this->input->post('amount'),
                'method' => $this->input->post('method'),
                'description' => $this->input->post('description'),
                'timestamp' => time(),
                'year' => date('Y') . '-' . (date('Y') + 1)
            );
            
            $this->db->insert('payment', $data);
            $payment_id = $this->db->insert_id();
            
            // If payment is for a student and has a fee type, record in daily_fee_tracking
            if (!empty($this->input->post('student_id')) && $this->input->post('payment_type') == 'income') {
                $student_id = $this->input->post('student_id');
                $fee_type_id = $this->input->post('fee_type_id');
                
                if ($fee_type_id) {
                    // Get student's class
                    $student = $this->db->get_where('student', ['student_id' => $student_id])->row_array();
                    
                    if ($student) {
                        $daily_fee_data = array(
                            'student_id' => $student_id,
                            'class_id' => $student['class_id'],
                            'fee_type_id' => $fee_type_id,
                            'fee_date' => date('Y-m-d'),
                            'amount' => $this->input->post('amount'),
                            'payment_status' => 'paid',
                            'paid_date' => date('Y-m-d H:i:s'),
                            'payment_id' => $payment_id,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        );
                        $this->db->insert('daily_fee_tracking', $daily_fee_data);
                    }
                }
            }
            
            // Update invoice if payment is for an invoice
            if (!empty($this->input->post('invoice_id')) && $this->input->post('payment_type') == 'income') {
                $invoice_id = $this->input->post('invoice_id');
                $amount = $this->input->post('amount');
                
                $invoice = $this->db->get_where('invoice', array('invoice_id' => $invoice_id))->row_array();
                $new_amount_paid = $invoice['amount_paid'] + $amount;
                $new_due = $invoice['due'] - $amount;
                $status = ($new_due <= 0) ? 2 : 1; // 2 = paid, 1 = unpaid
                
                $this->db->update('invoice', array(
                    'amount_paid' => $new_amount_paid,
                    'due' => max(0, $new_due),
                    'status' => $status
                ), array('invoice_id' => $invoice_id));
            }
            
            $this->session->set_flashdata('success', get_phrase('Payment recorded successfully'));
            redirect(base_url() . 'accountant/payments');
        }
        
        $page_data['page_name'] = 'payments';
        $page_data['page_title'] = get_phrase('Payments');
        
        $this->db->order_by('timestamp', 'DESC');
        $page_data['payments'] = $this->db->get('payment')->result_array();
        
        // Get daily fee tracking status for each payment
        $daily_fee_statuses = array();
        $this->db->select('payment_id, payment_status');
        $daily_fees = $this->db->get('daily_fee_tracking')->result_array();
        foreach ($daily_fees as $fee) {
            $daily_fee_statuses[$fee['payment_id']] = $fee['payment_status'];
        }
        $page_data['daily_fee_statuses'] = $daily_fee_statuses;
        
        // Get unpaid invoices for dropdown
        $this->db->reset_query();
        $this->db->where('status', 1);
        $page_data['unpaid_invoices'] = $this->db->get('invoice')->result_array();
        
        // Get students
        $this->db->reset_query();
        $page_data['students'] = $this->db->get('student')->result_array();

        // Get fee types for the dropdown
        $this->db->reset_query();
        $this->db->where('is_active', 1);
        $page_data['fee_types'] = $this->db->get('fee_type')->result_array();
        
        $this->load->view('backend/index', $page_data);
    }

    /**
     * View Payment Receipt
     */
    public function receipt($payment_id = null) {
        if (!$payment_id) {
            $this->session->set_flashdata('error', get_phrase('Invalid receipt'));
            redirect(base_url() . 'accountant/payments');
        }

        // Get payment details
        $payment = $this->db->get_where('payment', array('payment_id' => $payment_id))->row_array();
        
        if (!$payment) {
            $this->session->set_flashdata('error', get_phrase('Receipt not found'));
            redirect(base_url() . 'accountant/payments');
        }

        // Get current logged-in accountant info
        $current_accountant = $this->db->get_where('accountant', array('accountant_id' => $this->session->userdata('user_id')))->row_array();
        
        $page_data['payment'] = $payment;
        $page_data['current_accountant'] = $current_accountant;
        $page_data['page_name'] = 'receipt';
        $page_data['page_title'] = get_phrase('Payment Receipt');
        
        $this->load->view('backend/accountant/receipt', $page_data);
    }

    /**
     * Reports - Financial Analysis
     */
    public function reports() {
        $page_data['page_name'] = 'reports';
        $page_data['page_title'] = get_phrase('Financial Reports');
        
        // Invoice statistics
        $page_data['total_invoices'] = $this->db->count_all('invoice');
        $page_data['paid_invoices'] = $this->db->get_where('invoice', array('status' => 2))->num_rows();
        $page_data['unpaid_invoices'] = $this->db->count_all('invoice') - $page_data['paid_invoices'];
        
        // Income
        $this->db->select_sum('amount');
        $this->db->where('payment_type', 'income');
        $income = $this->db->get('payment')->row();
        $page_data['total_income'] = ($income && $income->amount) ? $income->amount : 0;
        
        // Expenses
        $this->db->reset_query();
        $this->db->select_sum('amount');
        $this->db->where('payment_type', 'expense');
        $expenses = $this->db->get('payment')->row();
        $page_data['total_expenses'] = ($expenses && $expenses->amount) ? $expenses->amount : 0;
        
        // Net profit
        $page_data['net_profit'] = $page_data['total_income'] - $page_data['total_expenses'];
        
        // Payment rate
        $page_data['payment_rate'] = ($page_data['total_invoices'] > 0) ? 
            round(($page_data['paid_invoices'] / $page_data['total_invoices']) * 100, 2) : 0;
        
        // Get expense breakdown
        $this->db->reset_query();
        $this->db->select('ec.name, SUM(p.amount) as total');
        $this->db->from('payment p');
        $this->db->join('expense_category ec', 'p.expense_category_id = ec.expense_category_id', 'left');
        $this->db->where('p.payment_type', 'expense');
        $this->db->group_by('ec.expense_category_id');
        $page_data['expense_breakdown'] = $this->db->get()->result_array();
        
        $this->load->view('backend/index', $page_data);
    }

    /**
     * Manage Accountant Profile
     */
    public function manage_profile() {
        if ($this->input->post()) {
            $data = array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone')
            );
            
            // Handle password change
            if (!empty($this->input->post('password'))) {
                if ($this->input->post('password') === $this->input->post('confirm_password')) {
                    $data['password'] = sha1($this->input->post('password'));
                } else {
                    $this->session->set_flashdata('error', get_phrase('Passwords do not match'));
                    redirect(base_url() . 'accountant/manage_profile');
                }
            }
            
            $this->db->update('accountant', $data, array('accountant_id' => $this->session->userdata('accountant_id')));
            
            // Handle profile picture upload if file was provided
            if (isset($_FILES['userfile']) && $_FILES['userfile']['error'] === UPLOAD_ERR_OK) {
                $tmpFile = $_FILES['userfile']['tmp_name'];
                $fileName = $_FILES['userfile']['name'];
                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                $allowed = array('jpg', 'jpeg', 'png', 'gif');
                
                if (in_array($fileExt, $allowed)) {
                    $uploadDir = 'uploads/accountant_image/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                    
                    $targetPath = $uploadDir . $this->session->userdata('accountant_id') . '.jpg';
                    
                    // Delete old image if exists
                    if (file_exists($targetPath)) {
                        unlink($targetPath);
                    }
                    
                    // If file is PNG, convert to JPG
                    if ($fileExt === 'png' && extension_loaded('gd')) {
                        $img = @imagecreatefrompng($tmpFile);
                        if ($img) {
                            $bgColor = imagecolorallocate($img, 255, 255, 255);
                            imagefill($img, 0, 0, $bgColor);
                            imagealphablending($img, true);
                            imagejpeg($img, $targetPath, 90);
                            imagedestroy($img);
                        } else {
                            move_uploaded_file($tmpFile, $targetPath);
                        }
                    } else {
                        move_uploaded_file($tmpFile, $targetPath);
                    }
                }
            }
            
            $this->session->set_flashdata('success', get_phrase('Profile updated'));
            redirect(base_url() . 'accountant/manage_profile');
        }
        
        $page_data['page_name'] = 'manage_profile';
        $page_data['page_title'] = get_phrase('Manage Profile');
        
        $accountant = $this->db->get_where('accountant', array('accountant_id' => $this->session->userdata('accountant_id')))->row_array();
        $page_data['accountant'] = $accountant;
        
        $this->load->view('backend/index', $page_data);
    }

    /**
     * Accountants List - Admin view
     */
    public function accountants() {
        $page_data['page_name'] = 'accountants_list';
        $page_data['page_title'] = get_phrase('Accountants');
        
        $this->db->order_by('accountant_id', 'DESC');
        $page_data['accountants'] = $this->db->get('accountant')->result_array();
        
        $this->load->view('backend/index', $page_data);
    }

    /**
     * Get class fees for a student (AJAX endpoint)
     */
    public function get_student_class_fees() {
        if (!$this->input->post('student_id')) {
            echo json_encode(['success' => false, 'message' => 'Student ID required']);
            return;
        }

        $student_id = $this->input->post('student_id');
        
        // Get student's class
        $student = $this->db->get_where('student', ['student_id' => $student_id])->row_array();
        
        if (!$student) {
            echo json_encode(['success' => false, 'message' => 'Student not found']);
            return;
        }

        $class_id = $student['class_id'];

        // Get class fees
        $this->db->select('cf.class_fee_id, cf.fee_type_id, ft.name, ft.description, cf.amount');
        $this->db->from('class_fee cf');
        $this->db->join('fee_type ft', 'cf.fee_type_id = ft.fee_type_id', 'inner');
        $this->db->where('cf.class_id', $class_id);
        $this->db->where('cf.is_active', 1);
        $this->db->where('ft.is_active', 1);
        
        $fees = $this->db->get()->result_array();
        
        echo json_encode([
            'success' => true,
            'fees' => $fees,
            'class_id' => $class_id
        ]);
    }

    /**
     * Tuition Fee Payment - Display page
     */
    public function tuition_payment() {
        $page_data['page_name'] = 'tuition_payment';
        $page_data['page_title'] = get_phrase('Tuition Fee Payments');
        
        // Get all classes
        $page_data['classes'] = $this->db->get('class')->result_array();
        
        // Get all students
        $page_data['students'] = $this->db->get('student')->result_array();
        
        // Get tuition records with payment tracking
        $tuition_records = $this->db->query("
            SELECT 
                s.student_id,
                s.name as student_name,
                c.class_id,
                c.name as class_name,
                COALESCE(cf.amount, 0) as tuition_amount,
                COALESCE(SUM(tp.amount_paid), 0) as amount_paid,
                CASE 
                    WHEN COALESCE(cf.amount, 0) = 0 THEN 'unpaid'
                    WHEN COALESCE(SUM(tp.amount_paid), 0) = 0 THEN 'unpaid'
                    WHEN COALESCE(SUM(tp.amount_paid), 0) >= COALESCE(cf.amount, 0) THEN 'paid'
                    ELSE 'partial'
                END as payment_status
            FROM student s
            LEFT JOIN class c ON s.class_id = c.class_id
            LEFT JOIN class_fee cf ON c.class_id = cf.class_id AND cf.fee_type_id IN (
                SELECT fee_type_id FROM fee_type WHERE category = 'tuition'
            )
            LEFT JOIN tuition_payment tp ON s.student_id = tp.student_id AND tp.is_active = 1
            GROUP BY s.student_id, c.class_id, c.name, s.name, cf.amount
            ORDER BY c.name, s.name
        ")->result_array();
        
        $page_data['tuition_records'] = $tuition_records;
        
        $this->load->view('backend/index', $page_data);
    }

    /**
     * Get tuition info for a student (AJAX endpoint)
     */
    public function get_tuition_info($student_id) {
        if (!$student_id) {
            echo json_encode(['success' => false, 'message' => 'Student ID required']);
            return;
        }

        // Get student
        $student = $this->db->get_where('student', ['student_id' => $student_id])->row_array();
        
        if (!$student) {
            echo json_encode(['success' => false, 'message' => 'Student not found']);
            return;
        }

        // Get tuition fee for student's class
        $tuition_fee = $this->db->query("
            SELECT cf.amount
            FROM class_fee cf
            JOIN fee_type ft ON cf.fee_type_id = ft.fee_type_id
            WHERE cf.class_id = ? AND ft.category = 'tuition'
            LIMIT 1
        ", [$student['class_id']])->row_array();

        $tuition_amount = $tuition_fee ? $tuition_fee['amount'] : 0;

        // Get total amount paid from tuition_payment table
        $paid_result = $this->db->query("
            SELECT COALESCE(SUM(amount_paid), 0) as total_paid
            FROM tuition_payment
            WHERE student_id = ? AND is_active = 1
        ", [$student_id])->row_array();

        $amount_paid = $paid_result['total_paid'];
        $outstanding = $tuition_amount - $amount_paid;

        echo json_encode([
            'success' => true,
            'tuition_amount' => $tuition_amount,
            'amount_paid' => $amount_paid,
            'outstanding' => max(0, $outstanding)
        ]);
    }

    /**
     * Record tuition payment
     */
    public function record_tuition_payment() {
        if ($this->input->method() !== 'post') {
            redirect('accountant/tuition_payment');
        }

        $student_id = $this->input->post('student_id');
        $payment_amount = $this->input->post('payment_amount');
        $payment_method = $this->input->post('payment_method');
        $notes = $this->input->post('notes');

        // Validate
        if (!$student_id || !$payment_amount || !$payment_method) {
            $this->session->set_flashdata('error', get_phrase('Please fill all required fields'));
            redirect('accountant/tuition_payment');
        }

        if ($payment_amount <= 0) {
            $this->session->set_flashdata('error', get_phrase('Payment amount must be greater than 0'));
            redirect('accountant/tuition_payment');
        }

        // Get student
        $student = $this->db->get_where('student', ['student_id' => $student_id])->row_array();
        if (!$student) {
            $this->session->set_flashdata('error', get_phrase('Student not found'));
            redirect('accountant/tuition_payment');
        }

        // Record tuition payment
        $tuition_payment_data = [
            'student_id' => $student_id,
            'class_id' => $student['class_id'],
            'amount_paid' => $payment_amount,
            'payment_method' => $payment_method,
            'payment_date' => date('Y-m-d'),
            'notes' => $notes ?: 'Tuition payment for ' . $student['name'],
            'created_by' => $this->session->userdata('accountant_id') ?: $this->session->userdata('user_id'),
            'is_active' => 1
        ];

        if (!$this->db->insert('tuition_payment', $tuition_payment_data)) {
            $this->session->set_flashdata('error', get_phrase('Failed to record payment'));
            redirect('accountant/tuition_payment');
        }

        $payment_id = $this->db->insert_id();

        // Send receipt email to parent
        $this->load->helper('email');
        $email_sent = send_payment_receipt_email($student_id, $payment_id, 'tuition');
        
        $success_msg = get_phrase('Tuition payment recorded successfully');
        if ($email_sent) {
            $success_msg .= ' - Receipt email sent to parent';
        }
        
        $this->session->set_flashdata('success', $success_msg);
        
        // Redirect to receipt
        redirect('accountant/tuition_receipt/' . $student_id . '/' . $payment_id);
    }

    /**
     * Tuition Receipt - Display receipt for payment
     */
    public function tuition_receipt($student_id, $payment_id = null) {
        // Get student
        $student = $this->db->get_where('student', ['student_id' => $student_id])->row_array();
        if (!$student) {
            show_404();
        }

        $page_data['student'] = $student;

        if ($payment_id) {
            // Get specific payment
            $payment = $this->db->get_where('tuition_payment', ['tuition_payment_id' => $payment_id])->row_array();
            if (!$payment) {
                show_404();
            }
            $page_data['payment'] = $payment;
        } else {
            // Get latest payment for student
            $payment = $this->db->query("
                SELECT * FROM tuition_payment
                WHERE student_id = ?
                ORDER BY payment_timestamp DESC
                LIMIT 1
            ", [$student_id])->row_array();

            if (!$payment) {
                show_404();
            }
            $page_data['payment'] = $payment;
        }

        // Get tuition amount and total paid
        $tuition_fee = $this->db->query("
            SELECT cf.amount
            FROM class_fee cf
            JOIN fee_type ft ON cf.fee_type_id = ft.fee_type_id
            WHERE cf.class_id = ? AND ft.category = 'tuition'
            LIMIT 1
        ", [$student['class_id']])->row_array();

        $tuition_amount = $tuition_fee ? $tuition_fee['amount'] : 0;

        // Get total paid
        $paid_result = $this->db->query("
            SELECT COALESCE(SUM(amount_paid), 0) as total_paid
            FROM tuition_payment
            WHERE student_id = ? AND is_active = 1
        ", [$student_id])->row_array();

        $page_data['tuition_amount'] = $tuition_amount;
        $page_data['total_paid'] = $paid_result['total_paid'];
        $page_data['outstanding'] = max(0, $tuition_amount - $paid_result['total_paid']);

        $page_data['page_name'] = 'tuition_receipt';
        $page_data['page_title'] = get_phrase('Tuition Receipt');
        
        $this->load->view('backend/index', $page_data);
    }

    /**
     * Download Tuition Receipt as PDF
     */
    public function tuition_receipt_pdf($student_id, $payment_id = null) {
        // Get student
        $student = $this->db->get_where('student', ['student_id' => $student_id])->row_array();
        if (!$student) {
            show_404();
        }

        if ($payment_id) {
            // Get specific payment
            $payment = $this->db->get_where('tuition_payment', ['tuition_payment_id' => $payment_id])->row_array();
            if (!$payment) {
                show_404();
            }
        } else {
            // Get latest payment for student
            $payment = $this->db->query("
                SELECT * FROM tuition_payment
                WHERE student_id = ?
                ORDER BY payment_timestamp DESC
                LIMIT 1
            ", [$student_id])->row_array();

            if (!$payment) {
                show_404();
            }
        }

        // Decide PDF behavior based on configuration (`pdf_engine`)
        // If set to 'disabled' (default) we redirect to the HTML/print view
        $pdf_engine = $this->config->item('pdf_engine');
        if (empty($pdf_engine) || $pdf_engine === 'disabled') {
            redirect('accountant/tuition_receipt/' . $student_id . '/' . $payment['tuition_payment_id']);
            return;
        }
        // If pdf_engine == 'tcpdf', continue with in-place TCPDF generation below (used for layout testing)

        // Get tuition amount and total paid
        $tuition_fee = $this->db->query("
            SELECT cf.amount
            FROM class_fee cf
            JOIN fee_type ft ON cf.fee_type_id = ft.fee_type_id
            WHERE cf.class_id = ? AND ft.category = 'tuition'
            LIMIT 1
        ", [$student['class_id']])->row_array();

        $tuition_amount = $tuition_fee ? $tuition_fee['amount'] : 0;

        // Get total paid
        $paid_result = $this->db->query("
            SELECT COALESCE(SUM(amount_paid), 0) as total_paid
            FROM tuition_payment
            WHERE student_id = ? AND is_active = 1
        ", [$student_id])->row_array();

        $outstanding = max(0, $tuition_amount - $paid_result['total_paid']);

        // Get class info
        $class = $this->db->get_where('class', ['class_id' => $student['class_id']])->row_array();

        // Build and generate PDF using TCPDF for layout testing (A5)
        // Prepare school info and logo path
        $school_name = get_school_name();
        $school_logo = get_school_logo();
        $school_address = school_setting('institute_address');

        $logo_path = '';
        if ($school_logo) {
            $base_url = base_url();
            if (strpos($school_logo, $base_url) === 0) {
                $relative_path = substr($school_logo, strlen($base_url));
            } else {
                $relative_path = ltrim($school_logo, '/');
            }
            $candidates = [FCPATH . $relative_path, FCPATH . 'uploads/' . basename($relative_path)];
            foreach ($candidates as $p) {
                if (file_exists($p) && in_array(strtolower(pathinfo($p, PATHINFO_EXTENSION)), ['jpg','jpeg','png','gif'])) {
                    $logo_path = $p;
                    break;
                }
            }
        }

        // Initialize TCPDF (A5) with professional spacing
        require_once(APPPATH . 'libraries/vendor/autoload.php');
        $pdf = new \TCPDF('P', 'mm', 'A5');
        $pdf->SetMargins(8, 8, 8);
        $pdf->SetAutoPageBreak(false);
        $pdf->AddPage();
        $pdf->SetFont('dejavusans', '', 12);

        // Professional styling with modern DejaVu Sans font and section dividers
        $styles = '<style>
            * { margin: 0; padding: 0; }
            body { font-family: DejaVu Sans, Arial, sans-serif; color: #333; line-height: 1.4; }
            .receipt-wrapper { width: 100%; }
            .header { text-align: center; padding-bottom: 6px; border-bottom: 1px solid #ddd; margin-bottom: 8px; }
            .logo-img { width: 4.5cm; height: 4.5cm; display: block; margin: 0 auto 4px auto; }
            .school-title { font-size: 15px; font-weight: bold; margin: 0 0 3px 0; line-height: 1.2; color: #1a1a1a; font-family: DejaVu Sans, Arial, sans-serif; }
            .meta { font-size: 8px; color: #888; margin: 0; }
            .receipt-info { width: 100%; font-size: 10px; margin-bottom: 8px; padding-bottom: 6px; border-bottom: 1px solid #f0f0f0; }
            .receipt-info td { padding: 2px 0; line-height: 1.4; }
            .receipt-info td:first-child { width: 50%; color: #666; font-weight: normal; }
            .receipt-info td:last-child { text-align: left; color: #1a1a1a; }
            .section-heading { font-weight: bold; font-size: 11px; margin-top: 6px; margin-bottom: 4px; color: #1a1a1a; font-family: DejaVu Sans, Arial, sans-serif; padding-top: 4px; border-top: 1px solid #f0f0f0; }
            .student-info { width: 100%; font-size: 10px; margin-bottom: 8px; padding-bottom: 6px; border-bottom: 1px solid #f0f0f0; }
            .student-info td { padding: 3px 0; line-height: 1.4; }
            .student-info td:first-child { width: 30%; color: #888; font-weight: normal; }
            .student-info td:last-child { color: #333; }
            .financial-table { width: 100%; border-collapse: collapse; font-size: 10px; margin-bottom: 8px; padding-bottom: 6px; border-bottom: 1px solid #f0f0f0; border: 1px solid #d0d0d0; }
            .financial-table td { padding: 6px 8px; line-height: 1.4; border: 1px solid #e8e8e8; }
            .financial-table tr:nth-child(1) { background-color: #ffffff; }
            .financial-table tr:nth-child(2) { background-color: #f9f9f9; }
            .financial-table tr:last-child { background-color: #f0f0f0; border-top: 2px solid #d0d0d0; font-weight: bold; }
            .financial-table td:first-child { color: #666; width: 60%; }
            .financial-table td:last-child { text-align: right; color: #1a1a1a; font-weight: bold; }
            .amount-paid { color: #27ae60; }
            .amount-outstanding { color: #e74c3c; }
            .payment-method { width: 100%; font-size: 10px; margin-bottom: 6px; padding-bottom: 6px; border-bottom: 1px solid #f0f0f0; }
            .payment-method td { padding: 3px 0; }
            .payment-method td:first-child { width: 30%; color: #888; font-weight: normal; }
            .payment-method td:last-child { color: #333; }
            .notes-label { font-weight: bold; font-size: 10px; color: #1a1a1a; margin-top: 4px; margin-bottom: 2px; }
            .notes-text { font-size: 9px; color: #666; line-height: 1.3; }
            .footer { text-align: center; font-size: 8px; color: #aaa; margin-top: 8px; line-height: 1.3; border-top: 1px solid #eee; padding-top: 4px; }
        </style>';

        $html = $styles;
        $html .= '<div class="receipt-wrapper">';
        $html .= '<div class="header">';
        
        // Logo: constrained to exactly 4.5cm x 4.5cm
        if ($logo_path) {
            $html .= '<img class="logo-img" src="' . htmlspecialchars($logo_path) . '" />';
        }
        
        $html .= '<div class="school-title">' . htmlspecialchars($school_name) . '</div>';
        if (!empty($school_address)) {
            $html .= '<div class="meta">' . htmlspecialchars($school_address) . '</div>';
        }
        $html .= '</div>';

        $receipt_date = date('M d, Y - h:i A', strtotime($payment['payment_timestamp']));
        $receipt_no = 'TUI-' . str_pad($payment['tuition_payment_id'], 6, '0', STR_PAD_LEFT);

        // Receipt metadata
        $html .= '<table class="receipt-info">';
        $html .= '<tr><td>Receipt Date:</td><td>' . $receipt_date . '</td></tr>';
        $html .= '<tr><td>Receipt No:</td><td>' . $receipt_no . '</td></tr>';
        $html .= '</table>';

        // Student Information section
        $html .= '<div class="section-heading">Student Information</div>';
        $html .= '<table class="student-info">';
        $html .= '<tr><td>Name:</td><td><strong>' . htmlspecialchars($student['name']) . '</strong></td></tr>';
        $html .= '<tr><td>Student ID:</td><td>' . htmlspecialchars($student['student_id']) . '</td></tr>';
        $html .= '<tr><td>Class:</td><td>' . htmlspecialchars($class['name'] ?? 'N/A') . '</td></tr>';
        $html .= '</table>';

        // Payment Breakdown section
        $html .= '<div class="section-heading">Payment Breakdown</div>';
        $html .= '<table class="financial-table">';
        $html .= '<tr><td>Tuition Amount:</td><td>' . get_currency_symbol() . ' ' . number_format($tuition_amount, 2) . '</td></tr>';
        $html .= '<tr><td>Amount Paid Today:</td><td class="amount-paid">- ' . get_currency_symbol() . ' ' . number_format($payment['amount_paid'], 2) . '</td></tr>';
        $html .= '<tr><td>Outstanding Balance:</td><td class="amount-outstanding">' . get_currency_symbol() . ' ' . number_format($outstanding, 2) . '</td></tr>';
        $html .= '</table>';

        // Payment Method section
        $html .= '<div class="section-heading">Payment Method</div>';
        $html .= '<table class="payment-method">';
        $html .= '<tr><td>Method:</td><td><strong>' . htmlspecialchars(ucfirst($payment['payment_method'])) . '</strong></td></tr>';
        $html .= '</table>';

        // Notes section (if present)
        if ($payment['notes']) {
            $html .= '<div class="section-heading">Notes</div>';
            $html .= '<div class="notes-text">' . htmlspecialchars($payment['notes']) . '</div>';
        }

        $html .= '<div class="footer">Thank You For Your Payment<br/>Please Keep This Receipt For Your Records</div>';
        $html .= '</div>';

        $pdf->writeHTML($html, true, false, true, false, '');

        // Output PDF to file in test mode or stream to browser for download
        $filename = 'Receipt_' . $student['student_id'] . '_' . $payment['tuition_payment_id'] . '_' . date('Ymd_His') . '.pdf';
        if ($this->input->get('test') == '1') {
            $out_file = FCPATH . 'tmp/test_receipt_' . $payment['tuition_payment_id'] . '.pdf';
            $pdf->Output($out_file, 'F');
            echo 'Saved test receipt to: ' . base_url('tmp/' . basename($out_file));
            return;
        } else {
            $pdf->Output($filename, 'D'); // 'D' for download
            return;
        }
    }

    /**
     * Delete Payment Record (Daily or Tuition)
     * Requires administrator password verification
     */
    public function delete_payment_record() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $type = $this->input->post('type');
        $id = $this->input->post('id');
        $password = $this->input->post('password');

        // Verify password (use a configured admin password or from database)
        // For now, using a simple comparison with a hardcoded password
        // TODO: Store admin password securely in config or database
        $admin_password = 'Admin123'; // Should be configurable

        if ($password !== $admin_password) {
            echo json_encode(['success' => false, 'message' => get_phrase('Invalid password')]);
            return;
        }

        try {
            if ($type === 'daily') {
                // Delete from daily_fee_tracking
                $this->db->delete('daily_fee_tracking', ['daily_fee_id' => $id]);
            } elseif ($type === 'tuition') {
                // Delete from tuition_payment
                $this->db->delete('tuition_payment', ['tuition_payment_id' => $id]);
            } else {
                throw new Exception('Invalid type');
            }

            echo json_encode(['success' => true, 'message' => get_phrase('Record deleted successfully')]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => get_phrase('Error deleting record')]);
        }
    }
}
