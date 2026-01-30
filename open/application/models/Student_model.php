<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Student_model extends CI_Model { 
	
	function __construct()
    {
        parent::__construct();
    }



    // The function below insert into student house //
    function createStudentHouse(){

        $page_data = array(
            'name'          => html_escape($this->input->post('name')),
            'description'      => html_escape($this->input->post('description'))
	    );

        $this->db->insert('house', $page_data);
    }

// The function below update student house //
    function updateStudentHouse($param2){
        $page_data = array(
            'name'         => html_escape($this->input->post('name')),
            'description'  => html_escape($this->input->post('description'))
	    );

        $this->db->where('house_id', $param2);
        $this->db->update('house', $page_data);
    }

    // The function below delete from student house table //
    function deleteStudentHouse($param2){
        $this->db->where('house_id', $param2);
        $this->db->delete('house');
    }



    // The function below insert into student category //
    function createstudentCategory(){

        $page_data = array(
            'name'        => html_escape($this->input->post('name')),
            'description' => html_escape($this->input->post('description'))
	    );
        $this->db->insert('student_category', $page_data);
    }

// The function below update student category //
    function updatestudentCategory($param2){
        $page_data = array(
            'name'        => html_escape($this->input->post('name')),
            'description' => html_escape($this->input->post('description'))
	    );

        $this->db->where('student_category_id', $param2);
        $this->db->update('student_category', $page_data);
    }

    // The function below delete from student category table //
    function deletestudentCategory($param2){
        $this->db->where('student_category_id', $param2);
        $this->db->delete('student_category');
    }




    //  the function below insert into student table
    function createNewStudent(){

        // First, create parent record if parent information is provided
        $parent_id = null;
        if(!empty($this->input->post('parent_name'))) {
            // Validate that new parent email doesn't already exist
            $this->db->where('email', $this->input->post('parent_email'));
            $existing_parent = $this->db->get('parent')->num_rows();
            if($existing_parent > 0) {
                $this->session->set_flashdata('error', 'Parent email already exists in system');
                redirect('admin/new_student');
                return;
            }
            
            $parent_password = substr(md5(uniqid(rand(), true)), 0, 8); // Generate random password
            
            $parent_data = array(
                'name'       => html_escape($this->input->post('parent_name')),
                'email'      => html_escape($this->input->post('parent_email')),
                'phone'      => html_escape($this->input->post('parent_phone')),
                'address'    => html_escape($this->input->post('parent_address')),
                'profession' => html_escape($this->input->post('parent_profession')),
                'password'   => sha1($parent_password),
                'login_status' => '0'
            );
            
            $this->db->insert('parent', $parent_data);
            $parent_id = $this->db->insert_id();
            
            // Log that new parent was created
            log_message('info', 'New parent created: ' . $parent_data['email'] . ' (ID: ' . $parent_id . ')');
        } else {
            // Use selected parent if no new parent data provided
            $parent_id = html_escape($this->input->post('parent_id'));
        }

        // Get random house
        $all_houses = $this->db->get('house')->result_array();
        $random_house_id = (count($all_houses) > 0) ? $all_houses[array_rand($all_houses)]['house_id'] : 0;

        $page_data = array(
            'name'          => html_escape($this->input->post('name')),
            'birthday'      => html_escape($this->input->post('birthday')),
            'age'           => html_escape($this->input->post('age')),
            'place_birth'   => html_escape($this->input->post('place_birth')),
            'sex'           => html_escape($this->input->post('sex')),
            'm_tongue'      => html_escape($this->input->post('m_tongue')) ? html_escape($this->input->post('m_tongue')) : 'Not specified',
            'religion'      => html_escape($this->input->post('religion')),
            'blood_group'   => html_escape($this->input->post('blood_group')),
            'address'       => html_escape($this->input->post('address')),
            'city'          => html_escape($this->input->post('city')),
            'state'         => html_escape($this->input->post('state')),
            'nationality'   => html_escape($this->input->post('nationality')),
            'phone'         => html_escape($this->input->post('phone')),
            'email'         => html_escape($this->input->post('email')),
            'ps_attended'   => html_escape($this->input->post('ps_attended')) ? html_escape($this->input->post('ps_attended')) : 'Not specified',
            'ps_address'    => html_escape($this->input->post('ps_address')) ? html_escape($this->input->post('ps_address')) : '',
            'ps_purpose'    => html_escape($this->input->post('ps_purpose')) ? html_escape($this->input->post('ps_purpose')) : '',
            'class_study'   => html_escape($this->input->post('class_study')) ? html_escape($this->input->post('class_study')) : '',
            'date_of_leaving' => html_escape($this->input->post('date_of_leaving')) ? html_escape($this->input->post('date_of_leaving')) : '',
            'am_date'         => html_escape($this->input->post('am_date')) ? html_escape($this->input->post('am_date')) : '',
            'tran_cert'       => html_escape($this->input->post('tran_cert')) ? html_escape($this->input->post('tran_cert')) : '',
            'dob_cert'        => html_escape($this->input->post('dob_cert')) ? html_escape($this->input->post('dob_cert')) : '',
            'mark_join'        => html_escape($this->input->post('mark_join')) ? html_escape($this->input->post('mark_join')) : '',
            'physical_h'      => html_escape($this->input->post('physical_h')) ? html_escape($this->input->post('physical_h')) : '',
            'password'        => sha1($this->input->post('password')),
            'father_name'     => html_escape($this->input->post('father_name')) ? html_escape($this->input->post('father_name')) : '',
            'mother_name'     => html_escape($this->input->post('mother_name')) ? html_escape($this->input->post('mother_name')) : '',
            'class_id'        => html_escape($this->input->post('class_id')),
            'section_id'      => html_escape($this->input->post('section_id')) ? html_escape($this->input->post('section_id')) : 0,
            'parent_id'       => $parent_id,
            'roll'            => html_escape($this->input->post('roll')),
            'transport_id'    => html_escape($this->input->post('transport_id')) ? html_escape($this->input->post('transport_id')) : 0,
            'dormitory_id'    => html_escape($this->input->post('dormitory_id')) ? html_escape($this->input->post('dormitory_id')) : 0,
            'house_id'        => $random_house_id,
            'student_category_id' => html_escape($this->input->post('student_category_id')) ? html_escape($this->input->post('student_category_id')) : 0,
            'club_id'         => html_escape($this->input->post('club_id')) ? html_escape($this->input->post('club_id')) : 0,
            'session'         => html_escape($this->input->post('academic_year_id')) ? html_escape($this->input->post('academic_year_id')) : 1,
            'card_number'     => html_escape($this->input->post('card_number')) ? html_escape($this->input->post('card_number')) : '',
            'issue_date'      => html_escape($this->input->post('issue_date')) ? html_escape($this->input->post('issue_date')) : '',
            'expire_date'     => html_escape($this->input->post('expire_date')) ? html_escape($this->input->post('expire_date')) : '',
            'dormitory_room_number' => html_escape($this->input->post('dormitory_room_number')) ? html_escape($this->input->post('dormitory_room_number')) : '',
            'more_entries'    => html_escape($this->input->post('more_entries')) ? html_escape($this->input->post('more_entries')) : '0',
            'login_status'    => '1'
        );
        
  
        
    $this->db->insert('student', $page_data);
    $student_id = $this->db->insert_id();
    
    // Automatically enroll student in student_enrollment table (NEW SYSTEM)
    // Get the current academic year (default to 1 if not available)
    $current_year = $this->db->where('is_current', 1)->get('academic_years')->row();
    $academic_year_id = $current_year ? $current_year->academic_year_id : 1;
    
    $class_id = html_escape($this->input->post('class_id'));
    if (!empty($class_id)) {
        $enrollment_data = array(
            'student_id' => $student_id,
            'academic_year_id' => $academic_year_id,
            'class_id' => $class_id,
            'promotion_status' => 'enrolled',
            'is_current' => 1,
            'enrollment_date' => date('Y-m-d H:i:s')
        );
        $this->db->insert('student_enrollment', $enrollment_data);
        log_message('info', 'Student enrolled in student_enrollment: Student ID ' . $student_id . ' in Class ' . $class_id);
    }
    
    move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $student_id . '.jpg');			// image with user ID

    }

    //the function below update student
    function updateNewStudent($param2){
        $page_data = array(
            'name'          => html_escape($this->input->post('name')),
            'birthday'      => html_escape($this->input->post('birthday')),
            'age'           => html_escape($this->input->post('age')),
            'place_birth'   => html_escape($this->input->post('place_birth')),
            'sex'           => html_escape($this->input->post('sex')),
            'm_tongue'      => html_escape($this->input->post('m_tongue')),
            'religion'      => html_escape($this->input->post('religion')),
            'blood_group'   => html_escape($this->input->post('blood_group')),
            'address'       => html_escape($this->input->post('address')),
            'city'          => html_escape($this->input->post('city')),
            'state'         => html_escape($this->input->post('state')),
            'nationality'   => html_escape($this->input->post('nationality')),
            'phone'         => html_escape($this->input->post('phone')),
            'email'         => html_escape($this->input->post('email')),
            'ps_attended'   => html_escape($this->input->post('ps_attended')),
            'ps_address'    => html_escape($this->input->post('ps_address')),
            'ps_purpose'    => html_escape($this->input->post('ps_purpose')),
            'class_study'   => html_escape($this->input->post('class_study')),
            'date_of_leaving' => html_escape($this->input->post('date_of_leaving')),
            'am_date'         => html_escape($this->input->post('am_date')),
            'tran_cert'       => html_escape($this->input->post('tran_cert')),
            'dob_cert'        => html_escape($this->input->post('dob_cert')),
            'mark_join'        => html_escape($this->input->post('mark_join')),
            'physical_h'      => html_escape($this->input->post('physical_h')),
            'class_id'        => html_escape($this->input->post('class_id')),
            'parent_id'       => html_escape($this->input->post('parent_id')),
            'transport_id'    => html_escape($this->input->post('transport_id')),
            'dormitory_id'    => html_escape($this->input->post('dormitory_id')),
            'club_id'         => html_escape($this->input->post('club_id'))
	    );
        $this->db->where('student_id', $param2);
        $this->db->update('student', $page_data);
        move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $param2 . '.jpg');

    }

    // the function below deletes from student table
    function deleteNewStudent($param2){
        $this->db->where('student_id', $param2);
        $this->db->delete('student');
    }

	// Get student by ID
	function get_by_id($student_id) {
		$this->db->where('student_id', $student_id);
		$query = $this->db->get('student');
		return $query->row();
	}

	// Get all students in a class
	function get_by_class($class_id) {
		$this->db->select('student_id, name');
		$this->db->where('class_id', $class_id);
		$this->db->order_by('name', 'ASC');
		$query = $this->db->get('student');
		return $query->result();
	}

	// Get all students
	function get_all() {
		$this->db->order_by('name', 'ASC');
		$query = $this->db->get('student');
		return $query->result();
	}
	
}


