<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Teacher extends CI_Controller { 

    function __construct() {
        parent::__construct();
        		$this->load->database();                                //Load Databse Class
                $this->load->library('session');					    //Load library for session
                $this->load->helper('avatar');                          //Load avatar helper
                $this->load->model('Score_entry_model');
                $this->load->model('Academic_term_model');
                $this->load->model('Academic_year_model');
        		// $this->load->model('vacancy_model');

    }

     /*teacher dashboard code to redirect to teacher page if successfull login** */
     function dashboard() {
        if ($this->session->userdata('teacher_login') != 1) redirect(base_url(), 'refresh');
       	$page_data['page_name'] = 'dashboard';
        $page_data['page_title'] = get_phrase('Teacher Dashboard');
        $page_data['all_academic_years'] = $this->Academic_year_model->get_all_years();
        $this->load->view('backend/index', $page_data);
    }
	/******************* / teacher dashboard code to redirect to teacher page if successfull login** */

    function manage_profile($param1 = null, $param2 = null, $param3 = null){
        if ($this->session->userdata('teacher_login') != 1) redirect(base_url(), 'refresh');
        if ($param1 == 'update') {
    
    
            $data['name']   =   $this->input->post('name');
            $data['email']  =   $this->input->post('email');
    
            $this->db->where('teacher_id', $this->session->userdata('teacher_id'));
            $this->db->update('teacher', $data);
            
            // Handle profile picture upload if file was provided
            if (isset($_FILES['userfile']) && $_FILES['userfile']['error'] === UPLOAD_ERR_OK) {
                $tmpFile = $_FILES['userfile']['tmp_name'];
                $fileName = $_FILES['userfile']['name'];
                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                $allowed = array('jpg', 'jpeg', 'png', 'gif');
                
                if (in_array($fileExt, $allowed)) {
                    $uploadDir = 'uploads/teacher_image/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                    
                    $targetPath = $uploadDir . $this->session->userdata('teacher_id') . '.jpg';
                    
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
            
            $this->session->set_flashdata('flash_message', get_phrase('Info Updated'));
            redirect(base_url() . 'teacher/manage_profile', 'refresh');
           
        }
    
        if ($param1 == 'change_password') {
            $data['new_password']           =   sha1($this->input->post('new_password'));
            $data['confirm_new_password']   =   sha1($this->input->post('confirm_new_password'));
    
            if ($data['new_password'] == $data['confirm_new_password']) {
               
               $this->db->where('teacher_id', $this->session->userdata('teacher_id'));
               $this->db->update('teacher', array('password' => $data['new_password']));
               $this->session->set_flashdata('flash_message', get_phrase('Password Changed'));
            }
    
            else{
                $this->session->set_flashdata('error_message', get_phrase('Type the same password'));
            }
            redirect(base_url() . 'teacher/manage_profile', 'refresh');
        }
    
            $page_data['page_name']     = 'manage_profile';
            $page_data['page_title']    = get_phrase('Manage Profile');
            $page_data['edit_profile']  = $this->db->get_where('teacher', array('teacher_id' => $this->session->userdata('teacher_id')))->result_array();
            $this->load->view('backend/index', $page_data);
        }



        function manage_attendance($date = null, $month= null, $year = null, $class_id = null ){
            $active_sms_gateway = $this->db->get_where('sms_settings', array('type' => 'active_sms_gateway'))->row()->info;
            
            if ($_POST) {
        
                // Get current academic term
                $current_term = $this->db->where('is_active', 1)->get('academic_terms')->row();
                $academic_term_id = $current_term ? $current_term->academic_term_id : 1;
                
                // Loop all the students of $class_id
                $students = $this->db->get_where('student', array('class_id' => $class_id))->result_array();
                foreach ($students as $key => $student) {
                $attendance_status = $this->input->post('status_' . $student['student_id']);
                $full_date = $year . "-" . $month . "-" . $date;
                $this->db->where('student_id', $student['student_id']);
                $this->db->where('date', $full_date);
        
                $this->db->update('attendance', array('status' => $attendance_status, 'academic_term_id' => $academic_term_id));
        
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
                redirect(base_url() . 'teacher/manage_attendance/' . $date . '/' . $month . '/' . $year . '/' . $class_id, 'refresh');
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
            redirect(base_url(). 'teacher/manage_attendance/' .$date. '/' . $this->input->post('class_id'), 'refresh');
        }
    
    
        function attendance_report($class_id = NULL, $month = NULL, $year = NULL) {
            
            $active_sms_gateway = $this->db->get_where('sms_settings', array('type' => 'active_sms_gateway'))->row()->info;
            
            
            if ($_POST) {
            redirect(base_url() . 'teacher/attendance_report/' . $class_id . '/' . $month . '/' . $year, 'refresh');
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
            $page_data['year'] 			= $year;							// get all class year
            
            $this->load->view('backend/teacher/loadAttendanceReport' , $page_data);
        }
        /******************** Load attendance with ajax code ends from here **********************/
        
    
        /******************** print attendance report **********************/
        function printAttendanceReport($class_id=NULL, $month=NULL, $year=NULL)
        {
            $page_data['class_id'] 		= $class_id;					// get all class_id
            $page_data['month'] 		= $month;						// get all month
            $page_data['year'] 			= $year;							// get all class year
            
            $page_data['page_name'] = 'printAttendanceReport';
            $page_data['page_title'] = "Attendance Report";
            $this->load->view('backend/index', $page_data);
        }
        /******************** /Ends here **********************/
     /***********  The function below manages school marks - NEW SYSTEM ***********************/
     function marks ($academic_year_id = null, $academic_term_id = null, $class_id = null, $student_id = null){

        // Check if teacher is logged in
        if ($this->session->userdata('teacher_login') != 1) redirect(base_url(), 'refresh');

        $teacher_id = $this->session->userdata('teacher_id');

        // Load required models
        $this->load->model('Score_entry_model');

        if($this->input->post('operation') == 'selection'){
            $page_data['academic_year_id']   =  $this->input->post('academic_year_id'); 
            $page_data['academic_term_id']   =  $this->input->post('academic_term_id');
            $page_data['class_id']           =  $this->input->post('class_id');
            $page_data['student_id']         =  $this->input->post('student_id');

            if($page_data['academic_year_id'] > 0 && $page_data['academic_term_id'] > 0 && $page_data['class_id'] > 0 && $page_data['student_id'] > 0){
                redirect(base_url(). 'teacher/marks/'. $page_data['academic_year_id'] .'/' . $page_data['academic_term_id'] . '/' . $page_data['class_id'] . '/' . $page_data['student_id'], 'refresh');
            }
            else{
                $this->session->set_flashdata('error_message', get_phrase('Please select something'));
                redirect(base_url(). 'teacher/marks', 'refresh');
            }
        }

        // Check if this teacher is a CLASS TEACHER (assigned to a specific class)
        $assigned_class = $this->db->where('teacher_id', $teacher_id)->get('class')->row();
        
        if ($assigned_class) {
            // CLASS TEACHER: Only show their assigned class
            // Convert object to array
            $assigned_class_array = [
                'class_id' => $assigned_class->class_id,
                'name' => $assigned_class->name
            ];
            $page_data['teacher_classes'] = array($assigned_class_array);
            $page_data['is_class_teacher'] = true;
            $page_data['assigned_class_id'] = $assigned_class->class_id;
            
            // Auto-select their class
            if (!$class_id) {
                $class_id = $assigned_class->class_id;
            }
        } else {
            // SUBJECT TEACHER: Show all classes they teach
            $page_data['teacher_classes'] = $this->get_teacher_classes($teacher_id);
            $page_data['is_class_teacher'] = false;
        }

        // Auto-detect current academic year and term
        $current_year = $this->Score_entry_model->get_current_academic_year();
        $current_term = $this->Score_entry_model->get_current_term();

        $page_data['academic_year_id']   = $academic_year_id ?? ($current_year ? $current_year->academic_year_id : null);
        $page_data['academic_term_id']   = $academic_term_id ?? ($current_term ? $current_term->academic_term_id : null);
        $page_data['class_id']           = $class_id;
        $page_data['student_id']         = $student_id;
        
        // Get teacher's subjects
        $page_data['teacher_subjects']   = $this->get_teacher_subjects($teacher_id);
        
        $page_data['page_name']          = 'marks';
        $page_data['page_title']         = get_phrase('Enter Student Marks');
        $this->load->view('backend/index', $page_data);
    }

    /**
     * Get all classes taught by this teacher
     */
    private function get_teacher_classes($teacher_id)
    {
        // First check if teacher is assigned subjects via class_subjects
        $sql = "SELECT DISTINCT c.class_id, c.name FROM class c 
                INNER JOIN class_subjects cs ON c.class_id = cs.class_id 
                WHERE cs.teacher_id = ? AND cs.is_active = 1 ORDER BY c.name";
        $result = $this->db->query($sql, array($teacher_id));
        $classes = $result->result_array();
        
        // If no classes found via class_subjects, get all classes (fallback)
        if (empty($classes)) {
            $fallback = $this->db->order_by('name')->get('class')->result_array();
            return $fallback;
        }
        
        return $classes;
    }

    /**
     * Get all subjects taught by this teacher
     */
    private function get_teacher_subjects($teacher_id)
    {
        $sql = "SELECT DISTINCT s.subject_id, s.name FROM subject s 
                INNER JOIN class_subjects cs ON s.subject_id = cs.subject_id 
                WHERE cs.teacher_id = ? ORDER BY s.name";
        $result = $this->db->query($sql, array($teacher_id));
        return $result->result_array();
    }

    /**
     * Debug method: returns the SQL query used to fetch teacher classes
     */
    public function get_teacher_classes_debug($teacher_id = null)
    {
        if ($this->session->userdata('teacher_login') != 1) redirect(base_url(), 'refresh');
        if (!$teacher_id) $teacher_id = $this->session->userdata('teacher_id');
        $this->db->select('DISTINCT c.class_id, c.name');
        $this->db->from('class c');
        $this->db->join('class_subjects cs', 'c.class_id = cs.class_id');
        $this->db->where('cs.teacher_id', $teacher_id);
        $this->db->where('cs.is_active', 1);
        $sql = $this->db->get_compiled_select();
        echo '<pre>' . $sql . '</pre>';
    }

    /**
     * AJAX endpoint to get terms for a selected academic year
     */
    public function get_academic_terms()
    {
        $this->output->set_content_type('application/json');
        $academic_year_id = $this->input->post('academic_year_id');
        
        if (!$academic_year_id) {
            echo json_encode(['error' => 'Year ID required']);
            return;
        }

        $terms = $this->Score_entry_model->get_terms_by_year($academic_year_id);
        echo json_encode($terms);
    }

    /**
     * Handle score entry updates from teachers
     */
    public function update_student_scores()
    {
        $this->output->set_content_type('application/json');

        // Check if teacher is logged in
        if ($this->session->userdata('teacher_login') != 1) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }

        $teacher_id = $this->session->userdata('teacher_id');
        $student_id = $this->input->post('student_id');
        $academic_term_id = $this->input->post('academic_term_id');
        $class_id = $this->input->post('class_id');

        // Verify teacher teaches this class and has access
        // Allow if: teacher_id matches OR teacher_id = 0 (unassigned, available to all)
        $this->db->where('class_id', $class_id);
        $this->db->where('is_active', 1);
        $this->db->where_in('teacher_id', array($teacher_id, 0));
        $has_access = $this->db->get('class_subjects')->num_rows();

        if (!$has_access) {
            echo json_encode(['success' => false, 'message' => 'You do not have permission to enter marks for this class']);
            return;
        }

        // Get teacher's subjects for this class (both assigned and unassigned)
        $this->db->where('class_id', $class_id);
        $this->db->where('is_active', 1);
        $this->db->where_in('teacher_id', array($teacher_id, 0));
        $teacher_subjects = $this->db->get('class_subjects')->result_array();

        $success_count = 0;
        $errors = [];

        foreach ($teacher_subjects as $class_subject) {
            $subject_id = $class_subject['subject_id'];
            $emt1 = $this->input->post("emt1_{$subject_id}");
            $emt2 = $this->input->post("emt2_{$subject_id}");
            $emt3 = $this->input->post("emt3_{$subject_id}");
            $sba = $this->input->post("sba_{$subject_id}");
            $project = $this->input->post("project_{$subject_id}");
            $exam = $this->input->post("exam_{$subject_id}");
            $comment = $this->input->post("comment_{$subject_id}");

            // Only save if at least one field has data
            if ($emt1 === '' && $emt2 === '' && $emt3 === '' && $sba === '' && $project === '' && $exam === '') {
                continue;
            }

            // Validate scores
            if (!$this->validate_scores($emt1, $emt2, $emt3, $sba, $project, $exam)) {
                $subject = $this->db->where('subject_id', $subject_id)->get('subject')->row();
                $errors[] = "Invalid scores for {$subject->name}";
                continue;
            }

            // Calculate scores
            $class_score = $this->Score_entry_model->calculate_class_score($emt1 ?? 0, $emt2 ?? 0, $emt3 ?? 0);
            $total_score = $this->Score_entry_model->calculate_total_score($class_score, $exam ?? 0);
            $grade_info = $this->Score_entry_model->get_grade_and_proficiency($total_score);

            // Prepare data
            $data = [
                'student_id' => $student_id,
                'academic_term_id' => $academic_term_id,
                'subject_id' => $subject_id,
                'emt1_score' => $emt1 ?? null,
                'emt2_score' => $emt2 ?? null,
                'emt3_score' => $emt3 ?? null,
                'sba_assessment_score' => $sba ?? null,
                'project_score' => $project ?? null,
                'exam_score' => $exam ?? null,
                'class_score_report' => $class_score,
                'exams_score_report' => $exam ?? null,
                'total_score' => $total_score,
                'equivalent_numerical_grade' => $grade_info ? $grade_info->grade_letter : null,
                'level_of_proficiency' => $grade_info ? $grade_info->proficiency_level : null,
                'meaning' => $grade_info ? $grade_info->meaning : null,
                'teacher_comment' => $comment,
                'entered_by' => $teacher_id
            ];

            // Save
            if ($this->Score_entry_model->save_score_entry($data)) {
                $success_count++;
            } else {
                $subject = $this->db->where('subject_id', $subject_id)->get('subject')->row();
                $errors[] = "Failed to save scores for {$subject->name}";
            }
        }

        echo json_encode([
            'success' => count($errors) == 0,
            'message' => "$success_count scores updated successfully",
            'errors' => $errors
        ]);
    }

    /**
     * AJAX: load a simple marks entry partial for a class / subject / term
     */
    public function load_marks_entry($class_id = null, $subject_id = null, $term_id = null)
    {
        if ($this->session->userdata('teacher_login') != 1) {
            echo "<div class='alert alert-danger'>Unauthorized</div>";
            return;
        }
        
        // Debug: log the parameters
        log_message('info', 'load_marks_entry called with class_id=' . $class_id . ', subject_id=' . $subject_id . ', term_id=' . $term_id);
        
        $page_data['class_id'] = $class_id;
        $page_data['subject_id'] = $subject_id;
        $page_data['academic_term_id'] = $term_id;
        $page_data['students'] = $this->crud_model->get_students($class_id);
        
        // Debug: log the students found
        log_message('info', 'Students found: ' . count($page_data['students']));
        
        $this->load->view('backend/teacher/load_marks_entry', $page_data);
    }

    /**
     * AJAX: return <option> elements for students in a class
     */
    public function get_class_students($class_id = null)
    {
        if ($this->session->userdata('teacher_login') != 1) { echo '<option value="">Unauthorized</option>'; return; }
        $students = $this->crud_model->get_students($class_id);
        if (empty($students)) { echo '<option value="">No students</option>'; return; }
        echo '<option value="">Select Student</option>';
        foreach ($students as $s) {
            echo '<option value="' . $s['student_id'] . '">' . htmlspecialchars($s['name']) . '</option>';
        }
    }

    /**
     * AJAX: Get all subjects (12 Ghana curriculum) for a class
     */
    public function get_class_subjects($class_id = null)
    {
        if ($this->session->userdata('teacher_login') != 1) { echo '<option value="">Unauthorized</option>'; return; }
        if (!$class_id) { echo '<option value="">Select Subject</option>'; return; }
        
        // Get all subjects for this class ordered by subject_id
        $subjects = $this->db->where('class_id', $class_id)
                              ->order_by('subject_id', 'ASC')
                              ->get('subject')
                              ->result_array();
        
        if (empty($subjects)) { echo '<option value="">No subjects</option>'; return; }
        
        echo '<option value="">Select Subject</option>';
        foreach ($subjects as $subj) {
            echo '<option value="' . $subj['subject_id'] . '">' . htmlspecialchars($subj['name']) . '</option>';
        }
    }

    /**
     * AJAX: load student's subjects marks (class teacher flow - student across multiple subjects)
     */
    public function load_student_marks($student_id = null, $academic_term_id = null, $class_id = null)
    {
        if ($this->session->userdata('teacher_login') != 1) { echo '<div class="alert alert-danger">Unauthorized</div>'; return; }
        // ensure scores exist
        $this->Score_entry_model->initialize_student_scores($student_id, $academic_term_id, $class_id);
        $page_data['student_id'] = $student_id;
        $page_data['academic_term_id'] = $academic_term_id;
        $page_data['class_id'] = $class_id;
        $page_data['subjects'] = $this->Score_entry_model->get_class_subjects($class_id);
        $page_data['scores'] = $this->Score_entry_model->get_student_term_scores($student_id, $academic_term_id);
        $this->load->view('backend/teacher/load_student_marks', $page_data);
    }

    /**
     * Validate score ranges
     */
    private function validate_scores($emt1, $emt2, $emt3, $sba, $project, $exam)
    {
        // Only validate if provided
        if ($emt1 !== '' && ($emt1 < 0 || $emt1 > 10)) return false;
        if ($emt2 !== '' && ($emt2 < 0 || $emt2 > 10)) return false;
        if ($emt3 !== '' && ($emt3 < 0 || $emt3 > 10)) return false;
        if ($sba !== '' && ($sba < 0 || $sba > 10)) return false;
        if ($project !== '' && ($project < 0 || $project > 10)) return false;
        if ($exam !== '' && ($exam < 0 || $exam > 70)) return false;
        
        return true;
    }

    /**
     * Validate scores with detailed error messages
     * Returns: true if valid, error message string if invalid
     */
    private function validate_scores_detailed($emt1, $emt2, $emt3, $sba, $project, $exam)
    {
        if ($emt1 !== '' && ($emt1 < 0 || $emt1 > 10)) return "EMT1 must be 0-10 (got {$emt1})";
        if ($emt2 !== '' && ($emt2 < 0 || $emt2 > 10)) return "EMT2 must be 0-10 (got {$emt2})";
        if ($emt3 !== '' && ($emt3 < 0 || $emt3 > 10)) return "EMT3 must be 0-10 (got {$emt3})";
        if ($sba !== '' && ($sba < 0 || $sba > 10)) return "SBA must be 0-10 (got {$sba})";
        if ($project !== '' && ($project < 0 || $project > 10)) return "Project must be 0-10 (got {$project})";
        if ($exam !== '' && ($exam < 0 || $exam > 70)) return "Exam must be 0-70 (got {$exam})";
        
        return true;
    }
    /***********  The function that manages school marks ends here ***********************/



    /***********  The function below manages school marks ***********************/
    function student_marksheet_subject ($academic_year_id = null, $academic_term_id = null, $class_id = null, $subject_id = null){
        
        try {
            // Check if teacher is logged in
            if ($this->session->userdata('teacher_login') != 1) redirect(base_url(), 'refresh');

            $teacher_id = $this->session->userdata('teacher_id');

            // Get academic years
            $page_data['all_academic_years'] = $this->db->get('academic_years')->result_array();
            
            // Get current year/term
            $current_year = $this->db->select('academic_year_id, year_name')->from('academic_years')->order_by('academic_year_id', 'DESC')->limit(1)->get()->row_array();
            $page_data['current_year'] = $current_year;
            
            $current_term = $this->db->select('academic_term_id, term_name')->from('academic_terms')->where('is_active', 1)->limit(1)->get()->row_array();
            $page_data['current_term'] = $current_term;

            // Check if CLASS TEACHER
            $assigned_class = $this->db->where('teacher_id', $teacher_id)->get('class')->row();
            
            if ($assigned_class) {
                $page_data['teacher_classes'] = array((array)$assigned_class);
                $page_data['is_class_teacher'] = true;
                $page_data['assigned_class_id'] = $assigned_class->class_id;
            } else {
                // SUBJECT TEACHER
                $page_data['teacher_classes'] = $this->get_teacher_classes($teacher_id);
                $page_data['is_class_teacher'] = false;
                $page_data['assigned_class_id'] = null;
            }

            // Get teacher's subjects
            $page_data['teacher_subjects'] = $this->get_teacher_subjects($teacher_id);

            // Set defaults
            if (!$academic_year_id && isset($current_year['academic_year_id'])) {
                $academic_year_id = $current_year['academic_year_id'];
            }
            if (!$academic_term_id && isset($current_term['academic_term_id'])) {
                $academic_term_id = $current_term['academic_term_id'];
            }
            
            $page_data['academic_year_id'] = $academic_year_id;
            $page_data['academic_term_id'] = $academic_term_id;
            $page_data['class_id'] = $class_id;
            $page_data['subject_id'] = $subject_id;
            
            // If all parameters provided, fetch students for the marksheet
            if ($class_id && $subject_id && $academic_term_id) {
                $page_data['students'] = $this->crud_model->get_students($class_id);
            } else {
                $page_data['students'] = array();
            }
            
            $page_data['page_name'] = 'student_marksheet_subject';
            $page_data['page_title'] = get_phrase('Student Marks');

            $this->load->view('backend/index', $page_data);
            
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            log_message('error', 'student_marksheet_subject error: ' . $e->getMessage());
        }
    }

    /**
     * AJAX: Save marks for multiple students in a subject (subject teacher flow)
     */
    public function save_subject_marks()
    {
        $this->output->set_content_type('application/json');

        try {
            // Check if teacher is logged in
            if ($this->session->userdata('teacher_login') != 1) {
                echo json_encode(['success' => false, 'message' => 'Unauthorized']);
                return;
            }

            $teacher_id = $this->session->userdata('teacher_id');
            $class_id = $this->input->post('class_id');
            $subject_id = $this->input->post('subject_id');
            $academic_term_id = $this->input->post('academic_term_id');

            log_message('debug', "save_subject_marks - teacher_id: {$teacher_id}, class_id: {$class_id}, subject_id: {$subject_id}, term_id: {$academic_term_id}");

            // Check if teacher is the CLASS TEACHER (no permission check needed)
            $is_class_teacher = $this->db->where('class_id', $class_id)
                                         ->where('teacher_id', $teacher_id)
                                         ->get('class')
                                         ->num_rows();
            
            if ($is_class_teacher) {
                // Class teacher can enter marks for any subject in their class
                log_message('debug', "Teacher is class teacher for class {$class_id} - full access");
            } else {
                // Subject teacher: verify subject is configured in the class
                $this->db->where('class_id', $class_id);
                $this->db->where('subject_id', $subject_id);
                $this->db->where('is_active', 1);
                $subject_configured = $this->db->get('class_subjects')->num_rows();
                
                if (!$subject_configured) {
                    log_message('error', "Subject {$subject_id} not configured for class {$class_id}");
                    echo json_encode(['success' => false, 'message' => 'Subject not configured for this class']);
                    return;
                }
                
                log_message('debug', "Teacher is subject teacher - subject is configured");
            }

            // Get all students in the class
            $students = $this->crud_model->get_students($class_id);
            log_message('debug', "Found " . count($students) . " students in class {$class_id}");
            
            if (empty($students)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'No students found in class ' . $class_id,
                    'errors' => ['No students found. Check if students are enrolled in this class.']
                ]);
                return;
            }
            
            $success_count = 0;
            $errors = [];

            foreach ($students as $student) {
                $student_id = $student['student_id'];
                $emt1 = $this->input->post("emt1_{$student_id}");
                $emt2 = $this->input->post("emt2_{$student_id}");
                $emt3 = $this->input->post("emt3_{$student_id}");
                $exam = $this->input->post("exam_{$student_id}");

                log_message('debug', "Processing student {$student_id}: emt1={$emt1}, emt2={$emt2}, emt3={$emt3}, exam={$exam}");

                // Skip if no data entered
                if ($emt1 === '' && $emt2 === '' && $emt3 === '' && $exam === '') {
                    log_message('debug', "Skipping student {$student_id} - no data entered");
                    continue;
                }

                // Validate scores
                $validation_result = $this->validate_scores_detailed($emt1, $emt2, $emt3, '', '', $exam);
                if ($validation_result !== true) {
                    $errors[] = "Student {$student_id}: " . $validation_result;
                    log_message('debug', "Validation failed for student {$student_id}: {$validation_result}");
                    continue;
                }

                // Calculate scores
                $class_score = $this->Score_entry_model->calculate_class_score($emt1 ?? 0, $emt2 ?? 0, $emt3 ?? 0);
                $total_score = $this->Score_entry_model->calculate_total_score($class_score, $exam ?? 0);
                $grade_info = $this->Score_entry_model->get_grade_and_proficiency($total_score);

                // Prepare data with correct column names for mark table
                $data = [
                    'student_id' => $student_id,
                    'subject_id' => $subject_id,
                    'class_id' => $class_id,
                    'exam_id' => $academic_term_id,
                    'class_score1' => $emt1 ?? 0,
                    'class_score2' => $emt2 ?? 0,
                    'class_score3' => $emt3 ?? 0,
                    'exam_score' => $exam ?? 0,
                    'comment' => $this->input->post("teacher_comment_{$student_id}") ?? ''
                ];

                // Save
                if ($this->Score_entry_model->save_score_entry($data)) {
                    $success_count++;
                    log_message('debug', "Successfully saved score for student {$student_id}");
                } else {
                    $errors[] = "Failed to save scores for student ID {$student_id}";
                    log_message('error', "Failed to save score for student {$student_id}. Last DB error: " . $this->db->error()['message']);
                }
            }

            echo json_encode([
                'success' => count($errors) == 0,
                'message' => "$success_count scores updated successfully",
                'errors' => $errors
            ]);
        } catch (Exception $e) {
            log_message('error', 'Error in save_subject_marks: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());
            echo json_encode([
                'success' => false,
                'message' => 'Internal Server Error: ' . $e->getMessage(),
                'errors' => [$e->getMessage()]
            ]);
        }
    }
    /***********  The function that manages school marks ends here ***********************/    





    public function get_grading_structure()
    {
        $this->output->set_content_type('application/json');
        if ($this->session->userdata('teacher_login') != 1) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }
        $teacher_id = $this->session->userdata('teacher_id');
        $subject_id = $this->input->post('subject_id');
        if (!$subject_id) {
            echo json_encode(['success' => false, 'message' => 'Subject ID required']);
            return;
        }
        $structure = $this->Score_entry_model->get_grading_structure($teacher_id, $subject_id);
        echo json_encode(['success' => true, 'structure' => $structure ?: []]);
    }

    public function save_grading_structure()
    {
        $this->output->set_content_type('application/json');
        if ($this->session->userdata('teacher_login') != 1) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }
        $teacher_id = $this->session->userdata('teacher_id');
        $subject_id = $this->input->post('subject_id');
        $columns_json = $this->input->post('columns');
        if (!$subject_id || !$columns_json) {
            echo json_encode(['success' => false, 'message' => 'Missing required fields']);
            return;
        }
        try {
            $columns = json_decode($columns_json, true);
            if (empty($columns)) {
                echo json_encode(['success' => false, 'message' => 'No columns provided']);
                return;
            }
            $hasExam = false;
            foreach ($columns as $col) {
                if (isset($col['is_exam']) && $col['is_exam']) {
                    if ($hasExam) {
                        echo json_encode(['success' => false, 'message' => 'Only one column can be marked as exam']);
                        return;
                    }
                    $hasExam = true;
                }
            }
            if (!$hasExam) {
                echo json_encode(['success' => false, 'message' => 'One column must be marked as exam']);
                return;
            }
            $data = ['grading_components_json' => json_encode($columns), 'updated_at' => date('Y-m-d H:i:s')];
            $this->db->where('subject_id', $subject_id);
            $this->db->where('entered_by', $teacher_id);
            $this->db->update('mark', $data);
            $existing = $this->db->where('subject_id', $subject_id)->where('entered_by', $teacher_id)->get('mark')->row();
            if (!$existing) {
                $data['subject_id'] = $subject_id;
                $data['entered_by'] = $teacher_id;
                $data['created_at'] = date('Y-m-d H:i:s');
                $this->db->insert('mark', $data);
            }
            echo json_encode(['success' => true, 'message' => 'Grading structure saved successfully']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function delete_subject_scores()
    {
        $this->output->set_content_type('application/json');
        if ($this->session->userdata('teacher_login') != 1) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }
        $teacher_id = $this->session->userdata('teacher_id');
        $subject_id = $this->input->post('subject_id');
        if (!$subject_id) {
            echo json_encode(['success' => false, 'message' => 'Subject ID required']);
            return;
        }
        try {
            $result = $this->Score_entry_model->delete_subject_scores($teacher_id, $subject_id);
            echo json_encode(['success' => true, 'message' => 'All scores deleted successfully']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

}
