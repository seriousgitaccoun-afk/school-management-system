<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Accountant_model extends CI_Model { 
	
	function __construct()
    {
        parent::__construct();
    }


/**************************** The function below insert into accountant table   **************************** */
    function insertAccountantFunction (){

        $accountant_array = array(
            'name'                  => $this->input->post('name'),
            'accountant_number'     => $this->input->post('accountant_number'),
            'address'               => $this->input->post('address'),
			'phone'                 => $this->input->post('phone'),
			'password'              => sha1($this->input->post('password')),
            'designation_id'        => $this->input->post('designation_id'),
            'date_of_joining'       => $this->input->post('date_of_joining'),
            'joining_salary'        => $this->input->post('joining_salary'),
			'status'                => $this->input->post('status')
            );
        
            // Only add file_name if a file was uploaded
            if(!empty($_FILES['userfile']['name'])) {
                $accountant_array['file_name'] = $_FILES["userfile"]["name"];
            }
            $accountant_array['email'] = $this->input->post('email');
            $check_email = $this->db->get_where('accountant', array('email' => $accountant_array['email']))->row()->email;	// checking if email exists in database
            if($check_email != null) 
            {
            $this->session->set_flashdata('error_message', get_phrase('email_already_exist'));
            redirect(base_url() . 'admin/accountant/', 'refresh');
            }
            else
            {
            $this->db->insert('accountant', $accountant_array);
            $accountant_id = $this->db->insert_id();
            
                // Upload image file only if provided
                if(!empty($_FILES['userfile']['name'])) {
                    move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/accountant_image/' . $accountant_id . '.jpg');
                }
            }

    }


    function updateAccountantFunction($param2){

        $accountant_data = array(
            'name'                  => $this->input->post('name'),
			'birthday'              => $this->input->post('birthday'),
        	'sex'                   => $this->input->post('sex'),
            'religion'              => $this->input->post('religion'),
            'blood_group'           => $this->input->post('blood_group'),
            'address'               => $this->input->post('address'),
            'phone'                 => $this->input->post('phone'),
            'email'                 => $this->input->post('email'),
			'facebook'              => $this->input->post('facebook'),
        	'twitter'               => $this->input->post('twitter'),
            'googleplus'            => $this->input->post('googleplus'),
            'linkedin'              => $this->input->post('linkedin'),
            'qualification'         => $this->input->post('qualification'),
			'marital_status'        => $this->input->post('marital_status')
            );

            $this->db->where('accountant_id', $param2);
            $this->db->update('accountant', $accountant_data);
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/accountant_image/' . $param2 . '.jpg'); 			// image with user ID
    }


    function deleteAccountantFunction($param2){

        $this->db->where('accountant_id', $param2);
        $this->db->delete('accountant');
    }
	


	
	
}
