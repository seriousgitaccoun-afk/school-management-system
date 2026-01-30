<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Admin extends CI_Controller { 

    function __construct() {
        parent::__construct();
        		$this->load->database();                                //Load Databse Class
                $this->load->library('session');					    //Load library for session
                $this->load->helper('avatar');                          //Load avatar helper
                $this->load->model('academic_model');                   // Load Apllication Model Here
                $this->load->model('student_model');                    // Load Apllication Model Here
                $this->load->model('exam_question_model');              // Load Apllication Model Here
                $this->load->model('student_payment_model');            // Load Apllication Model Here
                $this->load->model('event_model');                      // Load Apllication Model Here
                $this->load->model('language_model');                      // Load Apllication Model Here
                $this->load->model('admin_model');                      // Load Apllication Model Here
                $this->load->model('teacher_model');                    // Load Teacher Model Here
                $this->load->model('Academic_year_model');             // Academic year helper
                $this->load->model('Academic_term_model');             // Academic term helper
                $this->load->model('Term_milestone_model');            // Term milestones helper
                $this->load->model('accountant_model');                 // Load Accountant Model Here
    }

    /**
     * Admin: manage academic years (CRUD)
     */
    function academic_years($param1 = null, $param2 = null)
    {
        if ($this->session->userdata('admin_login') != 1) redirect(base_url(), 'refresh');

        if ($param1 == 'create') {
            $year_name = $this->input->post('year_name');
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $is_current = $this->input->post('is_current') ? 1 : 0;
            $data = [
                'year_name' => $year_name, 
                'start_date' => $start_date, 
                'end_date' => $end_date, 
                'is_current' => $is_current,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('academic_years', $data);
            if ($is_current) { $this->db->where('year_name !=', $year_name)->update('academic_years', ['is_current' => 0, 'updated_at' => date('Y-m-d H:i:s')]); }
            $this->session->set_flashdata('flash_message', get_phrase('Academic year created') . ' - ' . $year_name);
            redirect(base_url() . 'admin/academic_years', 'refresh');
        }

        if ($param1 == 'update') {
            $academic_year_id = $param2;
            $data = [
                'year_name' => $this->input->post('year_name'),
                'start_date' => $this->input->post('start_date'),
                'end_date' => $this->input->post('end_date'),
                'is_current' => $this->input->post('is_current') ? 1 : 0,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $this->db->where('academic_year_id', $academic_year_id)->update('academic_years', $data);
            if ($data['is_current']) { 
                $this->db->where('academic_year_id !=', $academic_year_id)->update('academic_years', ['is_current' => 0, 'updated_at' => date('Y-m-d H:i:s')]); 
            }
            $this->session->set_flashdata('flash_message', get_phrase('Academic year updated'));
            redirect(base_url() . 'admin/academic_years', 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('academic_year_id', $param2)->delete('academic_years');
            $this->session->set_flashdata('flash_message', get_phrase('Academic year deleted'));
            redirect(base_url() . 'admin/academic_years', 'refresh');
        }

        $page_data['page_name'] = 'academic_years';
        $page_data['page_title'] = get_phrase('Academic Years');
        $page_data['academic_years'] = $this->Academic_year_model->get_all_years();
        $this->load->view('backend/index', $page_data);
    }

    /**
     * Admin: Manage terms for an academic year
     */
    function academic_terms($param1 = null, $param2 = null)
    {
        if ($this->session->userdata('admin_login') != 1) redirect(base_url(), 'refresh');
        if ($param1 == 'create') {
            $academic_year_id = $this->input->post('academic_year_id');
            $term_name = $this->input->post('term_name');
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $vacation_date = $this->input->post('vacation_date');
            $resumption_date = $this->input->post('resumption_date');
            $is_active = $this->input->post('is_active') ? 1 : 0;
            $this->Academic_term_model->create_term($academic_year_id, $term_name, $vacation_date, $resumption_date, $start_date, $end_date);
            // Ensure is_active flag set if needed
            if ($is_active) {
                $this->Academic_term_model->set_active_term($this->db->where('academic_year_id', $academic_year_id)->where('term_name', $term_name)->get('academic_terms')->row()->academic_term_id);
            }
            $this->session->set_flashdata('flash_message', get_phrase('Academic term added'));
            redirect(base_url() . 'admin/academic_terms/' . $academic_year_id, 'refresh');
        }

        if ($param1 == 'update') {
            $term_id = $param2;
            $data = [
                'term_name' => $this->input->post('term_name'),
                'start_date' => $this->input->post('start_date'),
                'end_date' => $this->input->post('end_date'),
                'vacation_date' => $this->input->post('vacation_date'),
                'resumption_date' => $this->input->post('resumption_date'),
                'is_active' => $this->input->post('is_active') ? 1 : 0
            ];
            $this->db->where('academic_term_id', $term_id)->update('academic_terms', $data);
            if ($data['is_active']) {
                $this->Academic_term_model->set_active_term($term_id);
            }
            $this->session->set_flashdata('flash_message', get_phrase('Academic term updated'));
            // redirect back to the parent year page
            $year_id = $this->db->where('academic_term_id', $term_id)->get('academic_terms')->row()->academic_year_id;
            redirect(base_url() . 'admin/academic_terms/' . $year_id, 'refresh');
        }

        if ($param1 == 'delete') {
            $term_id = $param2;
            $this->db->where('academic_term_id', $term_id)->delete('academic_terms');
            $this->session->set_flashdata('flash_message', get_phrase('Academic term deleted'));
            redirect(base_url() . 'admin/academic_years', 'refresh');
        }

        // Default: view terms for a year (param1 is year_id when no action)
        $academic_year_id = $param1 ?: $param2;
        if (!$academic_year_id) redirect(base_url() . 'admin/academic_years', 'refresh');
        $page_data['page_name'] = 'academic_terms';
        $page_data['page_title'] = get_phrase('Academic Terms');
        $page_data['academic_year'] = $this->Academic_year_model->get_year($academic_year_id);
        $page_data['terms'] = $this->Academic_term_model->get_terms_by_year($academic_year_id);
        $page_data['milestones'] = [];
        foreach ($page_data['terms'] as $t) {
            $page_data['milestones'][$t['academic_term_id']] = $this->Term_milestone_model->get_by_term($t['academic_term_id']);
        }
        $this->load->view('backend/index', $page_data);
    }

    /**
     * AJAX: add milestone (midterm) to a term
     */
    public function add_term_milestone()
    {
        if ($this->session->userdata('admin_login') != 1) { echo json_encode(['success' => false, 'message' => 'Unauthorized']); return; }
        $term_id = $this->input->post('academic_term_id');
        $name = $this->input->post('name');
        $start = $this->input->post('start_date');
        $end = $this->input->post('end_date');
        $desc = $this->input->post('description');
        $ok = $this->Term_milestone_model->create($term_id, $name, $start, $end, $desc);
        echo json_encode(['success' => $ok, 'message' => $ok ? 'Milestone added' : 'Failed to add']);
    }

    /**
     * AJAX: delete milestone
     */
    public function delete_term_milestone($milestone_id = null)
    {
        if ($this->session->userdata('admin_login') != 1) { echo json_encode(['success' => false, 'message' => 'Unauthorized']); return; }
        if (!$milestone_id) { echo json_encode(['success' => false, 'message' => 'Missing id']); return; }
        $ok = $this->Term_milestone_model->delete($milestone_id);
        echo json_encode(['success' => $ok, 'message' => $ok ? 'Milestone removed' : 'Failed to remove']);
    }

    /**default functin, redirects to login page if no admin logged in yet***/
    public function index() 
	{
    if ($this->session->userdata('admin_login') != 1) redirect(base_url() . 'login', 'refresh');
    if ($this->session->userdata('admin_login') == 1) redirect(base_url() . 'admin/dashboard', 'refresh');
    }
	  /************* / default functin, redirects to login page if no admin logged in yet***/

    /*Admin dashboard code to redirect to admin page if successfull login** */
    function dashboard() {
        if ($this->session->userdata('admin_login') != 1) redirect(base_url(), 'refresh');
       	$page_data['page_name'] = 'dashboard';
        $page_data['page_title'] = get_phrase('admin_dashboard');
        $this->load->view('backend/index', $page_data);
    }
	/******************* / Admin dashboard code to redirect to admin page if successfull login** */


    function manage_profile($param1 = null, $param2 = null, $param3 = null){
    if ($this->session->userdata('admin_login') != 1) redirect(base_url(), 'refresh');
    if ($param1 == 'update') {


        $data['name']   =   $this->input->post('name');
        $data['email']  =   $this->input->post('email');

        $this->db->where('admin_id', $this->session->userdata('admin_id'));
        $this->db->update('admin', $data);
        
        // Handle profile picture upload if file was provided
        if (isset($_FILES['userfile']) && $_FILES['userfile']['error'] === UPLOAD_ERR_OK) {
            $tmpFile = $_FILES['userfile']['tmp_name'];
            $fileName = $_FILES['userfile']['name'];
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowed = array('jpg', 'jpeg', 'png', 'gif');
            
            if (in_array($fileExt, $allowed)) {
                $uploadDir = 'uploads/admin_image/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                $targetPath = $uploadDir . $this->session->userdata('admin_id') . '.jpg';
                
                // Delete old image if exists
                if (file_exists($targetPath)) {
                    unlink($targetPath);
                }
                
                // If file is PNG, convert to JPG (TCPDF compatibility)
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
        
        $this->session->set_flashdata('flash_message', get_phrase('Info Updated'));
        redirect(base_url() . 'admin/manage_profile', 'refresh');
       
    }

    if ($param1 == 'change_password') {
        $data['new_password']           =   sha1($this->input->post('new_password'));
        $data['confirm_new_password']   =   sha1($this->input->post('confirm_new_password'));

        if ($data['new_password'] == $data['confirm_new_password']) {
           
           $this->db->where('admin_id', $this->session->userdata('admin_id'));
           $this->db->update('admin', array('password' => $data['new_password']));
           $this->session->set_flashdata('flash_message', get_phrase('Password Changed'));
        }

        else{
            $this->session->set_flashdata('error_message', get_phrase('Type the same password'));
        }
        redirect(base_url() . 'admin/manage_profile', 'refresh');
    }

        $page_data['page_name']     = 'manage_profile';
        $page_data['page_title']    = get_phrase('Manage Profile');
        $page_data['edit_profile']  = $this->db->get_where('admin', array('admin_id' => $this->session->userdata('admin_id')))->result_array();
        $this->load->view('backend/index', $page_data);
    }


    function enquiry_category($param1 = null, $param2 = null, $param3 = null){

    if($param1 == 'insert'){
   
        $this->crud_model->enquiry_category();

        $this->session->set_flashdata('flash_message', get_phrase('Data saved successfully'));
        redirect(base_url(). 'admin/enquiry_category', 'refresh');
    }

    if($param1 == 'update'){

       $this->crud_model->update_category($param2);


        $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
        redirect(base_url(). 'admin/enquiry_category', 'refresh');

        }

    if($param1 == 'delete'){

       $this->crud_model->delete_category($param2);
        $this->session->set_flashdata('flash_message', get_phrase('Data deleted successfully'));
        redirect(base_url(). 'admin/enquiry_category', 'refresh');

        }

        $page_data['page_name']     = 'enquiry_category';
        $page_data['page_title']    = get_phrase('Manage Category');
        $page_data['enquiry_category']  = $this->db->get('enquiry_category')->result_array();
        $this->load->view('backend/index', $page_data);

    }


    function list_enquiry ($param1 = null, $param2 = null, $param3 = null){


        if($param1 == 'delete')
        {
            $this->crud_model->delete_enquiry($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data deleted successfully'));
            redirect(base_url(). 'admin/list_enquiry', 'refresh');
    
        }

        $page_data['page_name']     = 'list_enquiry';
        $page_data['page_title']    = get_phrase('All Enquiries');
        $page_data['select_enquiry']  = $this->db->get('enquiry')->result_array();
        $this->load->view('backend/index', $page_data);

    }



    function club ($param1 = null, $param2 = null, $param3 = null){

        if($param1 == 'insert'){
            $this->crud_model->insert_club();
            $this->session->set_flashdata('flash_message', get_phrase('Data saved successfully'));
            redirect(base_url(). 'admin/club', 'refresh');
        }

        if($param1 == 'update'){
            $this->crud_model->update_club($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
            redirect(base_url(). 'admin/club', 'refresh');
        }


        if($param1 == 'delete'){
            $this->crud_model->delete_club($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data deleted successfully'));
            redirect(base_url(). 'admin/club', 'refresh');
    
            }


        $page_data['page_name']     = 'club';
        $page_data['page_title']    = get_phrase('Manage Club');
        $page_data['select_club']  = $this->db->get('club')->result_array();
        $this->load->view('backend/index', $page_data);

    }


    function circular($param1 = null, $param2 = null, $param3 = null){

        if ($param1 == 'insert'){

            $this->crud_model->insert_circular();
            $this->session->set_flashdata('flash_message', get_phrase('Data successfully saved'));
            redirect(base_url(). 'admin/circular', 'refresh');
        }


        if($param1 == 'update'){

            $this->crud_model->update_circular($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data successfully updated'));
            redirect(base_url(). 'admin/circular', 'refresh');

        }


        if($param1 == 'delete'){
            $this->crud_model->delete_circular($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data successfully deleted'));
            redirect(base_url(). 'admin/circular', 'refresh');


        }

        $page_data['page_name']         = 'circular';
        $page_data['page_title']        = get_phrase('Manage Circular');
        $page_data['select_circular']   = $this->db->get('circular')->result_array();
        $this->load->view('backend/index', $page_data);

    }


    function parent($param1 = null, $param2 = null, $param3 = null){

        if ($param1 == 'insert'){

            $this->crud_model->insert_parent();
            $this->session->set_flashdata('flash_message', get_phrase('Data successfully saved'));
            redirect(base_url(). 'admin/parent', 'refresh');
        }


        if($param1 == 'update'){

            $this->crud_model->update_parent($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data successfully updated'));
            redirect(base_url(). 'admin/parent', 'refresh');

        }

        if($param1 == 'delete'){
            $this->crud_model->delete_parent($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data successfully deleted'));
            redirect(base_url(). 'admin/parent', 'refresh');

        }

        $page_data['page_name']         = 'parent';
        $page_data['page_title']        = get_phrase('Manage Parent');
        $page_data['select_parent']   = $this->db->get('parent')->result_array();
        $this->load->view('backend/index', $page_data);
    }


 





  


    function teacher ($param1 = null, $param2 = null, $param3 = null){

        if($param1 == 'insert'){
            $this->teacher_model->insetTeacherFunction();
            $this->session->set_flashdata('flash_message', get_phrase('Data saved successfully'));
            redirect(base_url(). 'admin/teacher', 'refresh');
        }

        if($param1 == 'update'){
            $this->teacher_model->updateTeacherFunction($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
            redirect(base_url(). 'admin/teacher', 'refresh');
        }


        if($param1 == 'delete'){
            $this->teacher_model->deleteTeacherFunction($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data deleted successfully'));
            redirect(base_url(). 'admin/teacher', 'refresh');
    
        }

        $page_data['page_name']     = 'teacher';
        $page_data['page_title']    = get_phrase('Manage Teacher');
        $page_data['select_teacher']  = $this->db->get('teacher')->result_array();
        $this->load->view('backend/index', $page_data);

    }

 


    /***********  The function manages Class Information  ***********************/
      function classes ($param1 = null, $param2 = null, $param3 = null){

        if($param1 == 'create'){
            $this->class_model->createClassFunction();
            $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
            redirect(base_url(). 'admin/classes', 'refresh');
        }

        if($param1 == 'update'){
            $this->class_model->updateClassFunction($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
            redirect(base_url(). 'admin/classes', 'refresh');
        }


        if($param1 == 'delete'){
            $this->class_model->deleteClassFunction($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data deleted successfully'));
            redirect(base_url(). 'admin/classes', 'refresh');
    
        }

        $page_data['page_name']     = 'class';
        $page_data['page_title']    = get_phrase('Manage Class');
        $this->load->view('backend/index', $page_data);

    }


    /***********  The function manages Section  ***********************/
    function section ($param1 = null, $param2 = null, $param3 = null){

        if($param1 == 'create'){
        $this->section_model->createSectionFunction();
        $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
        redirect(base_url(). 'admin/section', 'refresh');
        }

        if($param1 == 'update'){
        $this->section_model->updateSectionFunction($param2);
        $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
        redirect(base_url(). 'admin/section', 'refresh');
        }

        if($param1 == 'delete'){
        $this->section_model->deleteSectionFunction($param2);
        $this->session->set_flashdata('flash_message', get_phrase('Data deleted successfully'));
        redirect(base_url(). 'admin/section', 'refresh');
        }

        $page_data['page_name']     = 'section';
        $page_data['page_title']    = get_phrase('Manage Section');
        $this->load->view('backend/index', $page_data);
    }

        function sections ($class_id = null){

            if($class_id == '')
            $class_id = $this->db->get('class')->first_row()->class_id;
            
            $page_data['page_name']     = 'section';
            $page_data['class_id']      = $class_id;
            $page_data['page_title']    = get_phrase('Manage Section');
            $this->load->view('backend/index', $page_data);

        }
    



    function get_class_section_subject($class_id){
        $page_data['class_id']  =   $class_id;
        $this->load->view('backend/admin/class_routine_section_subject_selector', $page_data);

    }



    function section_subject_edit($class_id, $class_routine_id){

    $page_data['class_id']          =   $class_id;
    $page_data['class_routine_id']  =   $class_routine_id;
    $this->load->view('backend/admin/class_routine_section_subject_edit', $page_data);

    }


    /***********  The function manages school dormitory  ***********************/
    function dormitory ($param1 = null, $param2 = null, $param3 = null){

    if($param1 == 'create'){
        $this->dormitory_model->createDormitoryFunction();
        $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
        redirect(base_url(). 'admin/dormitory', 'refresh');
    }

    if($param1 == 'update'){
        $this->dormitory_model->updateDormitoryFunction($param2);
        $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
        redirect(base_url(). 'admin/dormitory', 'refresh');
    }


    if($param1 == 'delete'){
        $this->dormitory_model->deleteDormitoryFunction($param2);
        $this->session->set_flashdata('flash_message', get_phrase('Data deleted successfully'));
        redirect(base_url(). 'admin/dormitory', 'refresh');

    }

    $page_data['page_name']     = 'dormitory';
    $page_data['page_title']    = get_phrase('Manage Dormitory');
    $this->load->view('backend/index', $page_data);

    }


    /***********  The function manages hostel room  ***********************/
    function hostel_room ($param1 = null, $param2 = null, $param3 = null){

    if($param1 == 'create'){
        $this->dormitory_model->createHostelRoomFunction();
        $this->session->set_flashdata('flash_message', get_phrase('Data saved successfully'));
        redirect(base_url(). 'admin/hostel_room', 'refresh');
    }

    if($param1 == 'update'){
        $this->dormitory_model->updateHostelRoomFunction($param2);
        $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
        redirect(base_url(). 'admin/hostel_room', 'refresh');
    }


    if($param1 == 'delete'){
        $this->dormitory_model->deleteHostelRoomFunction($param2);
        $this->session->set_flashdata('flash_message', get_phrase('Data deleted successfully'));
        redirect(base_url(). 'admin/hostel_room', 'refresh');

    }

    $page_data['page_name']     = 'hostel_room';
    $page_data['page_title']    = get_phrase('Hostel Room');
    $this->load->view('backend/index', $page_data);

    }


    /***********  The function manages hostel category  ***********************/
    function hostel_category ($param1 = null, $param2 = null, $param3 = null){

    if($param1 == 'create'){
        $this->dormitory_model->createHostelCategoryFunction();
        $this->session->set_flashdata('flash_message', get_phrase('Data saved successfully'));
        redirect(base_url(). 'admin/hostel_category', 'refresh');
    }

    if($param1 == 'update'){
        $this->dormitory_model->updateHostelCategoryFunction($param2);
        $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
        redirect(base_url(). 'admin/hostel_category', 'refresh');
    }


    if($param1 == 'delete'){
        $this->dormitory_model->deleteHostelCategoryFunction($param2);
        $this->session->set_flashdata('flash_message', get_phrase('Data deleted successfully'));
        redirect(base_url(). 'admin/hostel_category', 'refresh');

    }

    $page_data['page_name']     = 'hostel_category';
    $page_data['page_title']    = get_phrase('Hostel Category');
    $this->load->view('backend/index', $page_data);
    }



    /***********  The function manages academic syllabus ***********************/
    function academic_syllabus ($param1 = null, $param2 = null, $param3 = null){

        if($param1 == 'create'){
        $this->academic_model->createAcademicSyllabus();
        $this->session->set_flashdata('flash_message', get_phrase('Data saved successfully'));
        redirect(base_url(). 'admin/academic_syllabus', 'refresh');
    }

    if($param1 == 'update'){
        $this->academic_model->updateAcademicSyllabus($param2);
        $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
        redirect(base_url(). 'admin/academic_syllabus', 'refresh');
    }


    if($param1 == 'delete'){
        $this->academic_model->deleteAcademicSyllabus($param2);
        $this->session->set_flashdata('flash_message', get_phrase('Data deleted successfully'));
        redirect(base_url(). 'admin/academic_syllabus', 'refresh');

        }

        $page_data['page_name']     = 'academic_syllabus';
        $page_data['page_title']    = get_phrase('Academic Syllabus');
        $this->load->view('backend/index', $page_data);

    }

    function get_class_subject($class_id){
        $subjects = $this->db->get_where('subject', array('class_id' => $class_id))->result_array();
            foreach($subjects as $key => $subject)
            {
                echo '<option value="'.$subject['subject_id'].'">'.$subject['name'].'</option>';
            }
    }

    /**
     * AJAX: Create parent quickly from student admission form
     */
    function create_parent_ajax() {
        if (!$this->session->userdata('admin_login')) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }

        $name = html_escape($this->input->post('name'));
        $email = html_escape($this->input->post('email'));
        $phone = html_escape($this->input->post('phone'));
        $address = html_escape($this->input->post('address'));
        $profession = html_escape($this->input->post('profession'));

        // Validate required fields
        if (empty($name) || empty($email) || empty($phone)) {
            echo json_encode(['success' => false, 'message' => 'Missing required fields']);
            return;
        }

        // Check if email already exists
        $existing = $this->db->get_where('parent', array('email' => $email))->num_rows();
        if ($existing > 0) {
            echo json_encode(['success' => false, 'message' => 'Email already exists']);
            return;
        }

        // Generate random password
        $password = substr(md5(uniqid(rand(), true)), 0, 8);

        $parent_data = array(
            'name'         => $name,
            'email'        => $email,
            'phone'        => $phone,
            'address'      => $address,
            'profession'   => $profession,
            'password'     => sha1($password),
            'login_status' => '0'
        );

        $this->db->insert('parent', $parent_data);
        $parent_id = $this->db->insert_id();

        if ($parent_id) {
            log_message('info', 'Quick parent created via AJAX: ' . $email . ' (ID: ' . $parent_id . ')');
            echo json_encode([
                'success' => true,
                'parent_id' => $parent_id,
                'message' => 'Parent created successfully'
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to create parent']);
        }
    }

    function download_academic_syllabus($academic_syllabus_code){
        $get_file_name = $this->db->get_where('academic_syllabus', array('academic_syllabus_code' => $academic_syllabus_code))->row()->file_name;
        // Loading download from helper.
        $this->load->helper('download');
        $get_download_content = file_get_contents('uploads/syllabus' . $get_file_name);
        $name = $file_name;
        force_download($name, $get_download_content);
    }

    function get_academic_syllabus ($class_id = null){

        if($class_id == '')
        $class_id = $this->db->get('class')->first_row()->class_id;
        
        $page_data['page_name']     = 'academic_syllabus';
        $page_data['class_id']      = $class_id;
        $page_data['page_title']    = get_phrase('Academic Syllabus');
        $this->load->view('backend/index', $page_data);

    }

    /***********  The function below add, update and delete student from students' table ***********************/
    function new_student ($param1 = null, $param2 = null, $param3 = null){

        if($param1 == 'create'){
            $this->student_model->createNewStudent();
            $this->session->set_flashdata('flash_message', get_phrase('Data saved successfully'));
            redirect(base_url(). 'admin/student_information', 'refresh');
        }

        if($param1 == 'update'){
            $this->student_model->updateNewStudent($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
            redirect(base_url(). 'admin/student_information', 'refresh');
        }

        if($param1 == 'delete'){
            $this->student_model->deleteNewStudent($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data deleted successfully'));
            redirect(base_url(). 'admin/student_information', 'refresh');

        }

        $page_data['page_name']     = 'new_student';
        $page_data['page_title']    = get_phrase('Manage Student');
        $this->load->view('backend/index', $page_data);

    }


    function student_information(){
        $page_data['class_id']      = '';
        $page_data['page_name']     = 'student_information';
        $page_data['page_title']    = get_phrase('List Student');
        $this->load->view('backend/index', $page_data);
    }


    /**************************  search student function with ajax starts here   ***********************************/
    function getStudentClasswise($class_id = ''){
        if(empty($class_id)) {
            echo json_encode(['success' => false, 'message' => 'No class selected']);
            return;
        }
        $page_data['class_id'] = $class_id;
        $this->load->view('backend/admin/showStudentClasswise', $page_data);
    }
    /**************************  search student function with ajax ends here   ***********************************/


    function edit_student($student_id){

        $page_data['student_id']      = $student_id;
        $page_data['page_name']     = 'edit_student';
        $page_data['page_title']    = get_phrase('Edit Student');
        $this->load->view('backend/index', $page_data);
    }


    function resetStudentPassword ($student_id) {
        $password['password']               =   sha1($this->input->post('new_password'));
        $confirm_password['confirm_new_password']   =   sha1($this->input->post('confirm_new_password'));
        if ($password['password'] == $confirm_password['confirm_new_password']) {
           $this->db->where('student_id', $student_id);
           $this->db->update('student', $password);
           $this->session->set_flashdata('flash_message', get_phrase('Password Changed'));
        }
        else{
            $this->session->set_flashdata('error_message', get_phrase('Type the same password'));
        }
        redirect(base_url() . 'admin/student_information', 'refresh');
    }

    function manage_attendance($date = null, $month= null, $year = null, $class_id = null ){
        $active_sms_gateway = $this->db->get_where('sms_settings', array('type' => 'active_sms_gateway'))->row()->info;
        
        if ($_POST) {
	
            // Loop all the students of $class_id
            $students = $this->db->get_where('student', array('class_id' => $class_id))->result_array();
            foreach ($students as $key => $student) {
            $attendance_status = $this->input->post('status_' . $student['student_id']);
            $full_date = $year . "-" . $month . "-" . $date;
            $this->db->where('student_id', $student['student_id']);
            $this->db->where('date', $full_date);
    
            $this->db->update('attendance', array('status' => $attendance_status));
    
                   if ($attendance_status == 2) 
            {
                     if ($active_sms_gateway != '' || $active_sms_gateway != 'disabled') {
                        $student_name   = $this->db->get_where('student' , array('student_id' => $student['student_id']))->row()->name;
                        $parent_id      = $this->db->get_where('student' , array('student_id' => $student['student_id']))->row()->parent_id;
                        $message        = 'Your child' . ' ' . $student_name . 'is absent today.';
                        if($parent_id != null && $parent_id != 0){
                            $recieverPhoneNumber = $this->db->get_where('parent' , array('parent_id' => $parent_id))->row()->phone;
                            if($recieverPhoneNumber != '' || $recieverPhoneNumber != null){
                                $this->sms_model->send_sms($message, $recieverPhoneNumber);
                            }
                            else{
                                $this->session->set_flashdata('error_message' , get_phrase('Parent Phone Not Found'));
                            }
                        }
                        else{
                            $this->session->set_flashdata('error_message' , get_phrase('SMS Gateway Not Found'));
                        }
                    }
           }
        }
    
            $this->session->set_flashdata('flash_message', get_phrase('Updated Successfully'));
            redirect(base_url() . 'admin/manage_attendance/' . $date . '/' . $month . '/' . $year . '/' . $class_id, 'refresh');
        }

        $page_data['date'] = $date;
        $page_data['month'] = $month;
        $page_data['year'] = $year;
        $page_data['class_id'] = $class_id;
        $page_data['page_name'] = 'manage_attendance';
        $page_data['page_title'] = get_phrase('Manage Attendance');
        $this->load->view('backend/index', $page_data);

    }

    function attendance_selector(){
        $date = $this->input->post('timestamp');
        $date = date_create($date);
        $date = date_format($date, "d/m/Y");
        redirect(base_url(). 'admin/manage_attendance/' .$date. '/' . $this->input->post('class_id'), 'refresh');
    }


    function attendance_report($class_id = NULL, $month = NULL, $year = NULL) {
        
        $active_sms_gateway = $this->db->get_where('sms_settings', array('type' => 'active_sms_gateway'))->row()->info;
        
        
        if ($_POST) {
        redirect(base_url() . 'admin/attendance_report/' . $class_id . '/' . $month . '/' . $year, 'refresh');
        }
        
        $classes = $this->db->get('class')->result_array();
        foreach ($classes as $key => $class) {
            if (isset($class_id) && $class_id == $class['class_id'])
                $class_name = $class['name'];
            }
        
        $page_data['month'] = $month;
        $page_data['year'] = $year;
        $page_data['class_id'] = $class_id;
        $page_data['page_name'] = 'attendance_report';
        $page_data['page_title'] = "Attendance Report: " . $class_name;
        $this->load->view('backend/index', $page_data);
    }


    /******************** Load attendance with ajax code starts from here **********************/
	function loadAttendanceReport($class_id, $month, $year)
    {
        $page_data['class_id'] 		= $class_id;					// get all class_id
		$page_data['month'] 		= $month;						// get all month
		$page_data['year'] 			= $year;						// get all class year
		
        $this->load->view('backend/admin/loadAttendanceReport' , $page_data);
    }
    /******************** Load attendance with ajax code ends from here **********************/
    

    /******************** print attendance report **********************/
	function printAttendanceReport($class_id=NULL, $month=NULL, $year=NULL)
    {
        $page_data['class_id'] 		= $class_id;					// get all class_id
		$page_data['month'] 		= $month;						// get all month
		$page_data['year'] 			= $year;						// get all class year
		
        $page_data['page_name'] = 'printAttendanceReport';
        $page_data['page_title'] = "Attendance Report";
        $this->load->view('backend/index', $page_data);
    }
    /******************** /Ends here **********************/
    


     /***********  The function below add, update and delete exam question table ***********************/
    function examQuestion ($param1 = null, $param2 = null, $param3 = null){

        if($param1 == 'create'){
            $this->exam_question_model->createexamQuestion();
            $this->session->set_flashdata('flash_message', get_phrase('Data saved successfully'));
            redirect(base_url(). 'admin/examQuestion', 'refresh');
        }

        if($param1 == 'update'){
            $this->exam_question_model->updateexamQuestion($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
            redirect(base_url(). 'admin/examQuestion', 'refresh');
        }

        if($param1 == 'delete'){
            $this->exam_question_model->deleteexamQuestion($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data deleted successfully'));
            redirect(base_url(). 'admin/examQuestion', 'refresh');
        }

        $page_data['page_name']     = 'examQuestion';
        $page_data['page_title']    = get_phrase('Exam Question');
        $this->load->view('backend/index', $page_data);
    }
     /***********  The function below add, update and delete exam question table ends here ***********************/


    /***********  The function below add, update and delete examination table ***********************/
    function createExamination ($param1 = null, $param2 = null, $param3 = null){

        if($param1 == 'create'){
            $this->exam_model->createExamination();
            $this->session->set_flashdata('flash_message', get_phrase('Data saved successfully'));
            redirect(base_url(). 'admin/createExamination', 'refresh');
        }

        if($param1 == 'update'){
            $this->exam_model->updateExamination($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
            redirect(base_url(). 'admin/createExamination', 'refresh');
        }

        if($param1 == 'delete'){
            $this->exam_model->deleteExamination($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data deleted successfully'));
            redirect(base_url(). 'admin/createExamination', 'refresh');
        }

        $page_data['page_name']     = 'createExamination';
        $page_data['page_title']    = get_phrase('Create Exam');
        $this->load->view('backend/index', $page_data);
    }
    /***********  The function below add, update and delete examination table ends here ***********************/

    /***********  The function below add, update and delete student payment table ***********************/
    function student_payment ($param1 = null, $param2 = null, $param3 = null){

        if($param1 == 'single_invoice'){
            $this->student_payment_model->createStudentSinglePaymentFunction();
            $this->session->set_flashdata('flash_message', get_phrase('Data saved successfully'));
            redirect(base_url(). 'admin/student_invoice', 'refresh');
        }

        if($param1 == 'mass_invoice'){
            $this->student_payment_model->createStudentMassPaymentFunction();
            $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
            redirect(base_url(). 'admin/student_invoice', 'refresh');
        }

        if($param1 == 'update_invoice'){
            $this->student_payment_model->updateStudentPaymentFunction($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
            redirect(base_url(). 'admin/student_invoice', 'refresh');
        }

        if($param1 == 'take_payment'){
            $this->student_payment_model->takeNewPaymentFromStudent($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
            redirect(base_url(). 'admin/student_invoice', 'refresh');
        }


        if($param1 == 'delete_invoice'){
            $this->student_payment_model->deleteStudentPaymentFunction($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data deleted successfully'));
            redirect(base_url(). 'admin/student_invoice', 'refresh');
        }

        $page_data['page_name']     = 'student_payment';
        $page_data['page_title']    = get_phrase('Student Payment');
        $this->load->view('backend/index', $page_data);
    }   
    /***********  / Student payment ends here ***********************/
    
    function get_class_student($class_id){
        $students = $this->db->get_where('student', array('class_id' => $class_id))->result_array();
            foreach($students as $key => $student)
            {
                echo '<option value="'.$student['student_id'].'">'.$student['name'].'</option>';
            }
    }


    function get_class_mass_student($class_id){

        $students = $this->db->get_where('student', array('class_id' => $class_id))->result_array();
        foreach($students as $key => $student)
        {
            echo '<div class="">
            <label><input type="checkbox" class="check" name="student_id[]" value="' . $student['student_id'] . '">' . '&nbsp;'. $student['name'] .'</label></div>';
        }

        echo '<br><button type ="button" class="btn btn-success btn-sm btn-rounded" onClick="select()">'.get_phrase('Select All').'</button>';
        echo '<button type ="button" class="btn btn-primary btn-sm btn-rounded" onClick="unselect()">'.get_phrase('Unselect All').'</button>';
    }

    function student_invoice(){

        $page_data['page_name']     = 'student_invoice';
        $page_data['page_title']    = get_phrase('Manage Invoice');
        $this->load->view('backend/index', $page_data);

    }



    /***********  The function below manages school event ***********************/
    function noticeboard ($param1 = null, $param2 = null, $param3 = null){

        if($param1 == 'create'){
            $this->event_model->createNoticeboardFunction();
            $this->session->set_flashdata('flash_message', get_phrase('Data saved successfully'));
            redirect(base_url(). 'admin/noticeboard', 'refresh');
        }

        if($param1 == 'update'){
            $this->event_model->updateNoticeboardFunction($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
            redirect(base_url(). 'admin/noticeboard', 'refresh');
        }

        if($param1 == 'delete'){
            $this->event_model->deleteNoticeboardFunction($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data deleted successfully'));
            redirect(base_url(). 'admin/noticeboard', 'refresh');
        }

        $page_data['page_name']     = 'noticeboard';
        $page_data['page_title']    = get_phrase('School Event');
        $this->load->view('backend/index', $page_data);
    }
    /***********  The function that manages school events ends here ***********************/

     /***********  The function below manages school language ***********************/
     function manage_language ($param1 = null, $param2 = null, $param3 = null){

        if($param1 == 'edit_phrase'){
            $page_data['edit_profile']  =   $param2;
        }

        if($param1 == 'add_language'){
            $this->language_model->createNewLanguage();
            $this->session->set_flashdata('flash_message', get_phrase('Data saved successfully'));
            redirect(base_url(). 'admin/manage_language', 'refresh');
        }

        if($param1 == 'add_phrase'){
            $this->language_model->createNewLanguagePhrase();
            $this->session->set_flashdata('flash_message', get_phrase('Data saved successfully'));
            redirect(base_url(). 'admin/manage_language', 'refresh');
        }

        if($param1 == 'delete_language'){
            $this->language_model->deleteLanguage($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data deleted successfully'));
            redirect(base_url(). 'admin/manage_language', 'refresh');
        }

        $page_data['page_name']     = 'manage_language';
        $page_data['page_title']    = get_phrase('Manage Language');
        $this->load->view('backend/index', $page_data);
    }
    /***********  The function that manages school language ends here ***********************/

    function updatePhraseWithAjax(){

        $checker['phrase_id']   =   $this->input->post('phraseId');
        $updater[$this->input->post('currentEditingLanguage')]  =   $this->input->post('updatedValue');

        $this->db->where('phrase_id', $checker['phrase_id'] );
        $this->db->update('language', $updater);

        echo $checker['phrase_id']. ' '. $this->input->post('currentEditingLanguage'). ' '. $this->input->post('updatedValue');

    }


    /***********  The function below manages school marks ***********************/
    function marks ($exam_id = null, $class_id = null, $student_id = null){

            if($this->input->post('operation') == 'selection'){

                $page_data['exam_id']       =  $this->input->post('exam_id'); 
                $page_data['class_id']      =  $this->input->post('class_id');
                $page_data['student_id']    =  $this->input->post('student_id');

                if($page_data['exam_id'] > 0 && $page_data['class_id'] > 0 && $page_data['student_id'] > 0){

                    redirect(base_url(). 'admin/marks/'. $page_data['exam_id'] .'/' . $page_data['class_id'] . '/' . $page_data['student_id'], 'refresh');
                }
                else{
                    $this->session->set_flashdata('error_message', get_phrase('Pleasen select something'));
                    redirect(base_url(). 'admin/marks', 'refresh');
                }
            }

            if($this->input->post('operation') == 'update_student_subject_score'){

                $select_subject_first = $this->db->get_where('subject', array('class_id' => $class_id ))->result_array();
                    foreach ($select_subject_first as $key => $dispay_subject_from_subject_table){

                        $page_data['class_score1']  =   $this->input->post('class_score1_' . $dispay_subject_from_subject_table['subject_id']);
                        $page_data['class_score2']  =   $this->input->post('class_score2_' . $dispay_subject_from_subject_table['subject_id']);
                        $page_data['class_score3']  =   $this->input->post('class_score3_' . $dispay_subject_from_subject_table['subject_id']);
                        $page_data['exam_score']    =   $this->input->post('exam_score_' . $dispay_subject_from_subject_table['subject_id']);
                        $page_data['comment']       =   $this->input->post('comment_' . $dispay_subject_from_subject_table['subject_id']);

                        $this->db->where('mark_id', $this->input->post('mark_id_' . $dispay_subject_from_subject_table['subject_id']));
                        $this->db->update('mark', $page_data);  
                    }

                    $this->session->set_flashdata('flash_message', get_phrase('Data Updated Successfully'));
                    redirect(base_url(). 'admin/marks/'. $this->input->post('exam_id') .'/' . $this->input->post('class_id') . '/' . $this->input->post('student_id'), 'refresh');
            }

        $page_data['exam_id']       =   $exam_id;
        $page_data['class_id']      =   $class_id;
        $page_data['student_id']    =   $student_id;
        $page_data['subject_id']   =    $subject_id;
        $page_data['page_name']     =   'marks';
        $page_data['page_title']    = get_phrase('Student Marks');
        $this->load->view('backend/index', $page_data);
    }
    /***********  The function that manages school marks ends here ***********************/



    /***********  The function below manages school marks ***********************/
     function student_marksheet_subject ($exam_id = null, $class_id = null, $subject_id = null){

        if($this->input->post('operation') == 'selection'){

            $page_data['exam_id']       =  $this->input->post('exam_id'); 
            $page_data['class_id']      =  $this->input->post('class_id');
            $page_data['subject_id']    =  $this->input->post('subject_id');

            if($page_data['exam_id'] > 0 && $page_data['class_id'] > 0 && $page_data['subject_id'] > 0){

                redirect(base_url(). 'admin/student_marksheet_subject/'. $page_data['exam_id'] .'/' . $page_data['class_id'] . '/' . $page_data['subject_id'], 'refresh');
            }
            else{
                $this->session->set_flashdata('error_message', get_phrase('Pleasen select something'));
                redirect(base_url(). 'admin/student_marksheet_subject', 'refresh');
            }
        }

        if($this->input->post('operation') == 'update_student_subject_score'){

            $select_student_first = $this->db->get_where('student', array('class_id' => $class_id ))->result_array();
                foreach ($select_student_first as $key => $dispay_student_from_student_table){

                    $page_data['class_score1']  =   $this->input->post('class_score1_' . $dispay_student_from_student_table['student_id']);
                    $page_data['class_score2']  =   $this->input->post('class_score2_' . $dispay_student_from_student_table['student_id']);
                    $page_data['class_score3']  =   $this->input->post('class_score3_' . $dispay_student_from_student_table['student_id']);
                    $page_data['exam_score']    =   $this->input->post('exam_score_' . $dispay_student_from_student_table['student_id']);
                    $page_data['comment']       =   $this->input->post('comment_' . $dispay_student_from_student_table['student_id']);

                    $this->db->where('mark_id', $this->input->post('mark_id_' . $dispay_student_from_student_table['student_id']));
                    $this->db->update('mark', $page_data);  
                }

                $this->session->set_flashdata('flash_message', get_phrase('Data Updated Successfully'));
                redirect(base_url(). 'admin/student_marksheet_subject/'. $this->input->post('exam_id') .'/' . $this->input->post('class_id') . '/' . $this->input->post('subject_id'), 'refresh');
        }

    $page_data['exam_id']       =   $exam_id;
    $page_data['class_id']      =   $class_id;
    $page_data['student_id']    =   $student_id;
    $page_data['subject_id']   =    $subject_id;
    $page_data['page_name']     =   'student_marksheet_subject';
    $page_data['page_title']    = get_phrase('Student Marks');
    $this->load->view('backend/index', $page_data);
    }
    /***********  The function that manages school marks ends here ***********************/



    
    /***********  The function below manages new admin ***********************/
    function newAdministrator ($param1 = null, $param2 = null, $param3 = null){

        if($param1 == 'create'){
            $this->admin_model->createNewAdministrator();
            $this->session->set_flashdata('flash_message', get_phrase('Data saved successfully'));
            redirect(base_url(). 'admin/newAdministrator', 'refresh');
        }

        if($param1 == 'update'){
            $this->admin_model->updateAdministrator($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
            redirect(base_url(). 'admin/newAdministrator', 'refresh');
        }

        if($param1 == 'delete'){
            $this->admin_model->deleteAdministrator($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data deleted successfully'));
            redirect(base_url(). 'admin/newAdministrator', 'refresh');
        }

        $page_data['page_name']     = 'newAdministrator';
        $page_data['page_title']    = get_phrase('New Administrator');
        $this->load->view('backend/index', $page_data);
    }
    /***********  The function that manages administrator ends here ***********************/

    /**
     * Manage Accountants
     */
    function accountant($param1 = null, $param2 = null) {
        if ($param1 == 'insert') {
            $this->accountant_model->insertAccountantFunction();
            $this->session->set_flashdata('flash_message', get_phrase('Data saved successfully'));
            redirect(base_url() . 'admin/accountant', 'refresh');
        }

        if ($param1 == 'update') {
            $this->accountant_model->updateAccountantFunction($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
            redirect(base_url() . 'admin/accountant', 'refresh');
        }

        if ($param1 == 'delete') {
            $this->accountant_model->deleteAccountantFunction($param2);
            $this->session->set_flashdata('flash_message', get_phrase('Data deleted successfully'));
            redirect(base_url() . 'admin/accountant', 'refresh');
        }
        $page_data['page_name'] = 'accountant';
        $page_data['page_title'] = get_phrase('Manage Accountants');
        $page_data['select_accountant'] = $this->db->get('accountant')->result_array();
        $this->load->view('backend/index', $page_data);
    }

    function updateAdminRole($param2){
        $this->admin_model->updateAllDetailsForAdminRole($param2);
        $this->session->set_flashdata('flash_message', get_phrase('Data updated successfully'));
        redirect(base_url(). 'admin/newAdministrator', 'refresh');
    }

    /**
     * SIMPLE: Manage Teacher-Subject Assignments
     * Admin assigns teachers to subjects in classes
     */
    function assign_teachers_to_subjects($action = null)
    {
        if ($this->session->userdata('admin_login') != 1) redirect(base_url(), 'refresh');

        // AJAX: Save assignment
        if ($action == 'save_assignment' && $this->input->is_ajax_request()) {
            $this->output->set_content_type('application/json');
            
            $class_id = $this->input->post('class_id');
            $subject_id = $this->input->post('subject_id');
            $teacher_id = $this->input->post('teacher_id');
            
            $this->db->where(['class_id' => $class_id, 'subject_id' => $subject_id])
                     ->update('class_subjects', ['teacher_id' => $teacher_id]);
            
            echo json_encode([
                'success' => true,
                'message' => 'Teacher assigned successfully'
            ]);
            return;
        }

        // Page: Show assignment interface
        $page_data['classes'] = $this->db->get('class')->result_array();
        $page_data['subjects'] = $this->db->get('subject')->result_array();
        $page_data['teachers'] = $this->db->get('teacher')->result_array();
        
        // Get current assignments
        $page_data['assignments'] = $this->db->select('cs.class_id, cs.subject_id, cs.teacher_id, c.name as class_name, s.name as subject_name, t.name as teacher_name')
                                             ->from('class_subjects cs')
                                             ->join('class c', 'cs.class_id = c.class_id', 'left')
                                             ->join('subject s', 'cs.subject_id = s.subject_id', 'left')
                                             ->join('teacher t', 'cs.teacher_id = t.teacher_id', 'left')
                                             ->order_by('c.name, s.name')
                                             ->get()
                                             ->result_array();
        
        $page_data['page_name'] = 'assign_teachers_to_subjects';
        $page_data['page_title'] = get_phrase('Assign Teachers to Subjects');
        $this->load->view('backend/index', $page_data);
    }

    /**
     * AJAX: Save academic settings (current year and term)
     * Admin can set which term teachers see pre-selected
     */
    public function save_academic_settings()
    {
        $this->output->set_content_type('application/json');
        
        if ($this->session->userdata('admin_login') != 1) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }
        
        $year_id = $this->input->post('year_id');
        $term_id = $this->input->post('term_id');
        
        if (!$year_id || !$term_id) {
            echo json_encode(['success' => false, 'message' => 'Missing required parameters']);
            return;
        }
        
        // Verify the year and term exist
        $year = $this->db->get_where('academic_years', ['academic_year_id' => $year_id])->row();
        $term = $this->db->get_where('academic_terms', ['academic_term_id' => $term_id, 'academic_year_id' => $year_id])->row();
        
        if (!$year || !$term) {
            echo json_encode(['success' => false, 'message' => 'Invalid year or term']);
            return;
        }
        
        try {
            // Set all terms to inactive first
            $this->db->update('academic_terms', ['is_active' => 0]);
            
            // Set the selected term as active
            $this->db->where('academic_term_id', $term_id)->update('academic_terms', ['is_active' => 1]);
            
            echo json_encode([
                'success' => true,
                'message' => 'Academic settings saved successfully. Teachers will see ' . $term->term_name . ' pre-selected.'
            ]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error saving settings: ' . $e->getMessage()]);
        }
    }

    /**
     * Simple Subject Teacher Assignment
     * Assigns a teacher to a subject in ALL classes
     * One teacher can teach one subject across multiple classes
     */
    public function assign_subject_teacher_simple()
    {
        if (!$this->input->is_ajax_request()) {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
            return;
        }

        $this->output->set_content_type('application/json');

        $teacher_id = $this->input->post('teacher_id');
        $subject_id = $this->input->post('subject_id');
        $class_ids_str = $this->input->post('class_ids');

        // DEBUG: Log received data
        error_log("AJAX assign_subject_teacher_simple - teacher_id: $teacher_id, subject_id: $subject_id, class_ids: $class_ids_str");

        if (!$teacher_id || !$subject_id || !$class_ids_str) {
            echo json_encode(['success' => false, 'message' => 'Missing teacher, subject, or classes']);
            return;
        }

        // Verify teacher is a subject teacher (role = 2)
        $is_subject_teacher = $this->db->where('teacher_id', $teacher_id)
                                        ->where('role', 2)
                                        ->get('teacher')
                                        ->num_rows();

        if (!$is_subject_teacher) {
            echo json_encode(['success' => false, 'message' => 'Selected teacher must be a subject teacher (role=2)']);
            return;
        }

        // Parse class IDs
        $class_ids = array_map('intval', explode(',', $class_ids_str));

        // DEBUG: Log before update
        error_log("About to update class_subjects for subject_id: $subject_id with teacher_id: $teacher_id in classes: " . implode(',', $class_ids));

        // Assign this teacher to the subject in SELECTED classes only
        foreach($class_ids as $class_id) {
            $this->db->where('class_id', $class_id)
                     ->where('subject_id', $subject_id)
                     ->update('class_subjects', ['teacher_id' => $teacher_id]);
        }

        // Get the subject name for the success message
        $subject = $this->db->where('subject_id', $subject_id)->get('subject')->row();
        $teacher = $this->db->where('teacher_id', $teacher_id)->get('teacher')->row();

        echo json_encode([
            'success' => true,
            'message' => $teacher->name . ' is now assigned to teach ' . $subject->name . ' in ' . count($class_ids) . ' class(es)'
        ]);
    }

    /**
     * Unassign subject teacher from a subject
     */
    public function unassign_subject_teacher_simple()
    {
        if (!$this->input->is_ajax_request()) {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
            return;
        }

        $this->output->set_content_type('application/json');

        $subject_id = $this->input->post('subject_id');

        if (!$subject_id) {
            echo json_encode(['success' => false, 'message' => 'Missing subject']);
            return;
        }

        // Get subject name before unassigning
        $subject = $this->db->where('subject_id', $subject_id)->get('subject')->row();

        // Unassign: Set teacher_id to NULL for this subject in ALL classes
        $this->db->where('subject_id', $subject_id)
                 ->update('class_subjects', ['teacher_id' => NULL]);

        echo json_encode([
            'success' => true,
            'message' => 'Teacher unassigned from ' . $subject->name . ' in all classes'
        ]);
    }

    /**
     * Load simple subject teacher assignment page
     */
    public function assign_subject_teacher_simple_page()
    {
        // Get subject teachers and subjects for dropdowns
        $page_data['subject_teachers'] = $this->db->where('role', 2)->get('teacher')->result_array();
        $page_data['subjects'] = $this->db->get('subject')->result_array();
        $page_data['classes'] = $this->db->get('class')->result_array();
        
        // Get current assignments - simplified approach
        $sql = "SELECT DISTINCT cs.teacher_id, cs.subject_id, t.name as teacher_name, s.name as subject_name
                FROM class_subjects cs
                LEFT JOIN teacher t ON cs.teacher_id = t.teacher_id
                LEFT JOIN subject s ON cs.subject_id = s.subject_id
                WHERE cs.teacher_id > 0
                ORDER BY t.name, s.name";
        
        $assignments_raw = $this->db->query($sql)->result_array();
        
        // For each assignment, get the classes
        $assignments = array();
        foreach($assignments_raw as $assign) {
            $classes = $this->db->select('c.name')
                               ->from('class_subjects cs')
                               ->join('class c', 'cs.class_id = c.class_id')
                               ->where('cs.teacher_id', $assign['teacher_id'])
                               ->where('cs.subject_id', $assign['subject_id'])
                               ->get()
                               ->result_array();
            
            $class_names = array();
            foreach($classes as $class) {
                $class_names[] = $class['name'];
            }
            
            $assign['classes'] = implode(', ', $class_names);
            $assignments[] = $assign;
        }
        
        $page_data['assignments'] = $assignments;
        
        $page_data['page_name'] = 'assign_subject_teacher_simple';
        $page_data['page_title'] = 'Assign Subject Teachers';
        $this->load->view('backend/index', $page_data);
    }

    /**
     * View all user credentials (Students, Parents, Teachers, Admins, Others)
     */
    public function credentials()
    {
        // Get Admins
        $page_data['admins'] = $this->db->select('admin_id, name, email, plaintext_password, login_status')
                                        ->from('admin')
                                        ->get()
                                        ->result_array();

        // Get Students
        $page_data['students'] = $this->db->select('s.student_id, s.name, s.email, s.plaintext_password, c.name as class_name, s.login_status')
                                          ->from('student s')
                                          ->join('class c', 's.class_id = c.class_id', 'left')
                                          ->get()
                                          ->result_array();

        // Get Parents - simple query, just show all parents with email/password
        $page_data['parents'] = $this->db->select('parent_id, name, email, plaintext_password, login_status')
                                         ->from('parent')
                                         ->get()
                                         ->result_array();

        // Get Teachers
        $page_data['teachers'] = $this->db->select('teacher_id, name, email, plaintext_password, role, status, login_status')
                                          ->from('teacher')
                                          ->get()
                                          ->result_array();

        // Get Others (Users from users table or other user types)
        // Adjust this query based on your actual "others" table structure
        $page_data['others'] = array(); // Placeholder - adjust based on your database structure

        $page_data['page_name'] = 'credentials';
        $page_data['page_title'] = 'User Credentials';
        $this->load->view('backend/index', $page_data);
    }

    /**
     * Wipe all data from database (for testing) - Admin only
     */
    public function wipe_database() {
        // Check if user is admin
        if ($this->session->userdata('admin_login') != 1) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }

        // Only allow POST requests
        if ($this->input->method() !== 'post') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        // Verify admin password
        $password = $this->input->post('admin_password');
        $admin_id = $this->session->userdata('admin_id');
        
        $admin = $this->db->get_where('admin', ['admin_id' => $admin_id])->row_array();
        
        if (!$admin) {
            echo json_encode(['success' => false, 'message' => 'Admin not found']);
            return;
        }

        // Try multiple password verification methods
        $password_valid = false;
        
        // Method 1: password_verify (bcrypt/argon2)
        if (password_verify($password, $admin['password'])) {
            $password_valid = true;
        }
        // Method 2: Direct plaintext comparison
        else if ($password === $admin['password']) {
            $password_valid = true;
        }
        // Method 3: MD5 hash comparison
        else if (md5($password) === $admin['password']) {
            $password_valid = true;
        }
        // Method 4: Check plaintext_password field if it exists
        else if (isset($admin['plaintext_password']) && $password === $admin['plaintext_password']) {
            $password_valid = true;
        }
        
        if (!$password_valid) {
            echo json_encode(['success' => false, 'message' => 'Incorrect password']);
            return;
        }

        try {
            // List of tables to truncate (keeps structure, deletes all data)
            $tables_to_truncate = [
                'student',
                'class',
                'class_fee',
                'fee_type',
                'teacher',
                'parent',
                'teacher_class',
                'teacher_subject',
                'marks_entry',
                'attendance',
                'invoice',
                'tuition_payment',
                'daily_fee_tracking',
                'payment'
            ];

            foreach ($tables_to_truncate as $table) {
                // Check if table exists
                $result = $this->db->query("SHOW TABLES LIKE '$table'")->result_array();
                if (!empty($result)) {
                    $this->db->query("TRUNCATE TABLE $table");
                }
            }

            // Log the action
            log_message('info', 'Database wiped by admin: ' . $admin['email'] . ' at ' . date('Y-m-d H:i:s'));

            $this->session->set_flashdata('success', 'Database wiped successfully! All data removed, structure preserved.');
            
            echo json_encode([
                'success' => true, 
                'message' => 'Database wiped successfully! All data has been removed while preserving table structure.'
            ]);
        } catch (Exception $e) {
            log_message('error', 'Database wipe failed: ' . $e->getMessage());
            
            echo json_encode([
                'success' => false, 
                'message' => 'Error wiping database: ' . $e->getMessage()
            ]);
        }
    }

}

