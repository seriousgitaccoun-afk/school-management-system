<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Term_milestone_model extends CI_Model {

    protected $table = 'term_milestones';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_by_term($academic_term_id)
    {
        return $this->db->where('academic_term_id', $academic_term_id)
                        ->order_by('start_date', 'ASC')
                        ->get($this->table)->result_array();
    }

    public function create($term_id, $name, $start_date, $end_date, $description = null)
    {
        $data = [
            'academic_term_id' => $term_id,
            'name' => $name,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'description' => $description,
            'created_at' => date('Y-m-d H:i:s')
        ];
        return $this->db->insert($this->table, $data);
    }

    public function update($milestone_id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('milestone_id', $milestone_id);
        return $this->db->update($this->table, $data);
    }

    public function delete($milestone_id)
    {
        $this->db->where('milestone_id', $milestone_id);
        return $this->db->delete($this->table);
    }
}



