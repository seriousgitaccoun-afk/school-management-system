<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Classfee_model extends CI_Model {

    private $table = 'class_fee';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Insert a new class fee
     */
    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Get all class fees
     */
    public function get_all() {
        $this->db->select('cf.*, c.name as class_name, ft.name as fee_type_name');
        $this->db->from($this->table . ' cf');
        $this->db->join('class c', 'c.class_id = cf.class_id', 'left');
        $this->db->join('fee_type ft', 'ft.fee_type_id = cf.fee_type_id', 'left');
        $this->db->where('cf.is_active', 1);
        $this->db->order_by('c.name', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get class fee by ID
     */
    public function get_by_id($class_fee_id) {
        $this->db->where('class_fee_id', $class_fee_id);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    /**
     * Get fees for a specific class
     */
    public function get_by_class($class_id) {
        $this->db->select('cf.*, ft.name as fee_type_name');
        $this->db->from($this->table . ' cf');
        $this->db->join('fee_type ft', 'ft.fee_type_id = cf.fee_type_id', 'left');
        $this->db->where('cf.class_id', $class_id);
        $this->db->where('cf.is_active', 1);
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get fee by class and fee type
     */
    public function get_by_class_and_type($class_id, $fee_type_id) {
        $this->db->where('class_id', $class_id);
        $this->db->where('fee_type_id', $fee_type_id);
        $this->db->where('is_active', 1);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    /**
     * Update class fee
     */
    public function update($class_fee_id, $data) {
        $this->db->where('class_fee_id', $class_fee_id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Delete class fee
     */
    public function delete($class_fee_id) {
        $this->db->where('class_fee_id', $class_fee_id);
        return $this->db->update($this->table, ['is_active' => 0]);
    }

    /**
     * Get fees by class with details
     */
    public function get_by_class_with_details($class_id) {
        $this->db->select('cf.*, ft.name as fee_type_name, ft.description');
        $this->db->from($this->table . ' cf');
        $this->db->join('fee_type ft', 'ft.fee_type_id = cf.fee_type_id', 'left');
        $this->db->where('cf.class_id', $class_id);
        $this->db->where('cf.is_active', 1);
        $query = $this->db->get();
        return $query->result();
    }
}
