<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Subject extends CI_Controller { 

    function __construct() {
        parent::__construct();
        		$this->load->database();
        		$this->load->library('session');		
    }




    /***********  The function manages subject  ***********************/
    function subject ($param1 = null, $param2 = null, $param3 = null){

        if($param1 == 'create'){
        $this->subject_model->createSubjectFunction();
        $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
        redirect(base_url(). 'subject/subject', 'refresh');
        }

        if($param1 == 'update'){
        $this->subject_model->updateSubjectFunction($param2);
        $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
        redirect(base_url(). 'subject/subject', 'refresh');
        }

        if($param1 == 'delete'){
        $this->subject_model->deleteSubjectFunction($param2);
        $this->session->set_flashdata('flash_message', get_phrase('Data deleted successfully'));
        redirect(base_url(). 'subject/subject', 'refresh');
        }

        $page_data['page_name']     = 'subject';
        $page_data['page_title']    = get_phrase('Manage Subject');
        $this->load->view('backend/index', $page_data);
    }


/**************************  search subject function with ajax starts here   ***********************************/
    function getSubjectByClasswise($class_id){

        $page_data['class_id'] = $class_id;
        $this->load->view('backend/admin/displaySubjectClasswise', $page_data);
    }
/**************************  search subject function with ajax ends here   ***********************************/

/**************************  bulk link all subjects to a class   ***********************************/
    function bulk_link_subjects() {
        $this->output->set_content_type('application/json');
        
        $class_id = $this->input->post('class_id');
        
        if (!$class_id) {
            echo json_encode(['success' => false, 'message' => 'No class selected']);
            return;
        }
        
        // Get all unique subjects (the base subjects with class_id = 0)
        $subjects = $this->db->where('class_id', 0)
                             ->distinct()
                             ->select('name, subject_id')
                             ->get('subject')
                             ->result_array();
        
        if (empty($subjects)) {
            echo json_encode(['success' => false, 'message' => 'No base subjects found in database']);
            return;
        }
        
        $count = 0;
        $errors = [];
        
        // Link each unique subject to the selected class
        foreach ($subjects as $subject) {
            // Check if already linked in class_subjects
            $already_linked = $this->db->where('subject_id', $subject['subject_id'])
                                      ->where('class_id', $class_id)
                                      ->get('class_subjects')
                                      ->num_rows();
            
            if ($already_linked == 0) {
                // This subject needs to be added to class_subjects for this class
                $data = [
                    'class_id' => $class_id,
                    'subject_id' => $subject['subject_id'],
                    'teacher_id' => NULL,
                    'is_active' => 1
                ];
                
                if ($this->db->insert('class_subjects', $data)) {
                    $count++;
                } else {
                    $errors[] = "Failed to link " . $subject['name'];
                }
            }
        }
        
        if ($count > 0) {
            echo json_encode([
                'success' => true,
                'message' => $count . ' subjects linked to class successfully'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'All subjects were already linked to this class'
            ]);
        }
    }
/**************************  bulk link all subjects to a class ends  ***********************************/


/**************************  link single subject to a class   ***********************************/
    function link_single_subject() {
        $this->output->set_content_type('application/json');
        
        $subject_id = $this->input->post('subject_id');
        $class_id = $this->input->post('class_id');
        
        if (!$subject_id || !$class_id) {
            echo json_encode(['success' => false, 'message' => 'Missing subject or class']);
            return;
        }
        
        // Get the subject details
        $existing = $this->db->where('subject_id', $subject_id)
                             ->get('subject')
                             ->row_array();
        
        if (!$existing) {
            echo json_encode(['success' => false, 'message' => 'Subject not found']);
            return;
        }
        
        // Check if already linked
        $already_linked = $this->db->where('subject_id', $existing['subject_id'])
                                  ->where('class_id', $class_id)
                                  ->get('class_subjects')
                                  ->num_rows();
        
        if ($already_linked > 0) {
            echo json_encode(['success' => false, 'message' => 'Subject already linked to this class']);
            return;
        }
        
        // Link the subject in class_subjects table
        $data = [
            'subject_id' => $existing['subject_id'],
            'class_id' => $class_id,
            'teacher_id' => NULL,
            'is_active' => 1
        ];
        
        if ($this->db->insert('class_subjects', $data)) {
            echo json_encode(['success' => true, 'message' => $existing['name'] . ' linked to class successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to link subject']);
        }
    }
/**************************  link single subject to a class ends  ***********************************/


/**************************  unlink subject from a class   ***********************************/
    function unlink_subject() {
        $this->output->set_content_type('application/json');
        
        $subject_id = $this->input->post('subject_id');
        
        if (!$subject_id) {
            echo json_encode(['success' => false, 'message' => 'No subject selected']);
            return;
        }
        
        // Check if subject exists in class_subjects
        $class_subject = $this->db->where('subject_id', $subject_id)->get('class_subjects')->row_array();
        
        if (!$class_subject) {
            echo json_encode(['success' => false, 'message' => 'Subject link not found']);
            return;
        }
        
        // Get subject name for response message
        $subject = $this->db->where('subject_id', $subject_id)->get('subject')->row_array();
        $subject_name = $subject ? $subject['name'] : 'Subject';
        
        // Delete the subject link from class_subjects
        if ($this->db->where('subject_id', $subject_id)->delete('class_subjects')) {
            echo json_encode(['success' => true, 'message' => $subject_name . ' unlinked from class successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to unlink subject']);
        }
    }
/**************************  unlink subject from a class ends  ***********************************/


/**************************  get unlinked subjects for a class   ***********************************/
    function get_unlinked_subjects() {
        $this->output->set_content_type('application/json');
        
        $class_id = $this->input->post('class_id');
        
        if (!$class_id) {
            echo json_encode(['success' => false, 'subjects' => []]);
            return;
        }
        
        // Get all subjects that ARE linked to this class (from class_subjects table)
        $linked_subjects = $this->db->where('class_id', $class_id)
                                    ->select('subject_id')
                                    ->get('class_subjects')
                                    ->result_array();
        
        $linked_ids = array_column($linked_subjects, 'subject_id');
        
        // Get all subjects NOT linked to this class
        $unlinked = $this->db->select('subject_id, name')
                             ->from('subject');
        
        if (!empty($linked_ids)) {
            $unlinked = $unlinked->where_not_in('subject_id', $linked_ids);
        }
        
        $unlinked = $unlinked->get()->result_array();
        
        echo json_encode(['success' => true, 'subjects' => $unlinked]);
    }
/**************************  get unlinked subjects for a class ends  ***********************************/

}
