<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Teacher_model extends CI_Model { 
	
	function __construct()
    {
        parent::__construct();
    }


/**************************** The function below insert into teacher table   **************************** */
    function insetTeacherFunction (){

        $teacher_array = array(
            'name'                  => $this->input->post('name'),
            'role'                  => $this->input->post('role'),
			'teacher_number'        => $this->input->post('teacher_number'),
            'address'               => $this->input->post('address'),
			'phone'                 => $this->input->post('phone'),
            'qualification'         => $this->input->post('qualification'),
			'password'              => sha1($this->input->post('password')),
            'designation_id'        => $this->input->post('designation_id') ?: null,
            'date_of_joining'       => $this->input->post('date_of_joining'),
            'joining_salary'        => $this->input->post('joining_salary') ?: null,
			'status'                => $this->input->post('status'),
            'email'                 => $this->input->post('email')
            );
        
            // Handle file upload if file is provided
            if(!empty($_FILES["userfile"]["name"])){
                $teacher_array['file_name'] = $_FILES["userfile"]["name"];
            }
            
            // Check if email exists in database
            $check_email = $this->db->get_where('teacher', array('email' => $teacher_array['email']))->row();	
            if($check_email != null) 
            {
                $this->session->set_flashdata('error_message', get_phrase('email_already_exist'));
                redirect(base_url() . 'admin/teacher/', 'refresh');
            }
            else
            {
                $this->db->insert('teacher', $teacher_array);
                $teacher_id = $this->db->insert_id();
                
                // Upload image if file is provided
                if(!empty($_FILES['userfile']['tmp_name'])){
                    move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/teacher_image/' . $teacher_id . '.jpg');
                }
            }
    }


    function updateTeacherFunction($param2){

        $teacher_data = array(
            'name'                  => $this->input->post('name'),
            'role'                  => $this->input->post('role'),
            'address'               => $this->input->post('address'),
            'phone'                 => $this->input->post('phone'),
            'email'                 => $this->input->post('email'),
            'qualification'         => $this->input->post('qualification'),
            'designation_id'        => $this->input->post('designation_id') ?: null,
            'date_of_joining'       => $this->input->post('date_of_joining'),
            'joining_salary'        => $this->input->post('joining_salary') ?: null,
			'status'                => $this->input->post('status')
            );

            $this->db->where('teacher_id', $param2);
            $this->db->update('teacher', $teacher_data);
            
            // Upload image if file is provided
            if(!empty($_FILES['userfile']['tmp_name'])){
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/teacher_image/' . $param2 . '.jpg');
            }
    }


    function deleteTeacherFunction($param2){

        $this->db->where('teacher_id', $param2);
        $this->db->delete('teacher');
    }
	


	
	
}
