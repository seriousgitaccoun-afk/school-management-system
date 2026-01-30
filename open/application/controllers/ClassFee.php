<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ClassFee extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->database();
        $this->load->library('session');
        $this->load->model('Classfee_model');
        $this->load->model('Class_model');
        $this->load->helper('url');
        
        // Check if user is logged in as accountant
        if (!$this->session->userdata('accountant_login')) {
            redirect(base_url() . 'login', 'refresh');
        }
    }

    /**
     * Display fee configuration page
     */
    public function index() {
        $data['page_name'] = 'class_fee_config';
        $data['page_title'] = 'Fee Configuration by Class';
        
        // Get all classes
        $data['classes'] = $this->Class_model->get_all();
        
        // Get all active fee types with categories
        $this->db->select('fee_type_id, name, category');
        $this->db->where('is_active', 1);
        $this->db->order_by('category, name');
        $fee_types_query = $this->db->get('fee_type');
        $data['fee_types'] = $fee_types_query ? $fee_types_query->result_array() : array();
        
        // If no active fee types, get all fee types for debugging
        if (empty($data['fee_types'])) {
            $all_types = $this->db->get('fee_type')->result_array();
            error_log('Warning: No active fee types found. Total fee types in DB: ' . count($all_types));
        }
        
        // Get all class fees
        $data['class_fees'] = $this->Classfee_model->get_all();
        
        $this->load->view('backend/index', $data);
    }

    /**
     * Get fees for a specific class (AJAX)
     */
    public function get_class_fees($class_id) {
        try {
            $fees = $this->Classfee_model->get_by_class($class_id);
            
            echo json_encode([
                'success' => true,
                'data' => $fees ? $fees : array()
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error loading fees: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Save or update class fee
     */
    public function save_fee() {
        if ($this->input->method() !== 'post') {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
            return;
        }

        $class_fee_id = $this->input->post('class_fee_id');
        $class_id = $this->input->post('class_id');
        $fee_type_id = $this->input->post('fee_type_id');
        $amount = $this->input->post('amount');

        if (!$class_id || !$fee_type_id || $amount === '') {
            echo json_encode(['success' => false, 'message' => 'All fields required']);
            return;
        }

        $data = [
            'class_id' => $class_id,
            'fee_type_id' => $fee_type_id,
            'amount' => floatval($amount),
            'is_active' => 1,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        try {
            if ($class_fee_id) {
                // Update existing
                $this->Classfee_model->update($class_fee_id, $data);
                $insert_id = $class_fee_id;
            } else {
                // Insert new
                $data['created_at'] = date('Y-m-d H:i:s');
                $insert_id = $this->Classfee_model->insert($data);
            }

            echo json_encode([
                'success' => true,
                'message' => 'Fee configuration saved successfully',
                'class_fee_id' => $insert_id
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error saving fee: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get fee amount for a class and fee type
     */
    public function get_fee_amount($class_id, $fee_type_id) {
        try {
            $fee = $this->Classfee_model->get_by_class_and_type($class_id, $fee_type_id);
            
            if ($fee) {
                echo json_encode([
                    'success' => true,
                    'amount' => $fee->amount
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Fee not configured for this class'
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Delete a fee configuration
     */
    public function delete_fee() {
        if ($this->input->method() !== 'post') {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
            return;
        }

        $class_fee_id = $this->input->post('class_fee_id');

        if (!$class_fee_id) {
            echo json_encode(['success' => false, 'message' => 'Fee ID required']);
            return;
        }

        try {
            $this->Classfee_model->delete($class_fee_id);
            echo json_encode(['success' => true, 'message' => 'Fee configuration deleted']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error deleting fee']);
        }
    }
}
