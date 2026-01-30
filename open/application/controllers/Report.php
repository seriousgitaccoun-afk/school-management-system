<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Controller {

    function __construct() {
        parent::__construct();
        		$this->load->database();
        		$this->load->library('session');					//Load library for session
        		$this->load->helper('avatar');
        		$this->load->model('Score_entry_model');
        		$this->load->model('Academic_term_model');
        		$this->load->model('Academic_year_model');
    }


    function studentPaymentReport ($param1 = null, $param2 = null, $param3 = null){

    $page_data['page_name']     = 'studentPaymentReport';
    $page_data['page_title']    = get_phrase('Payment Report');
    $this->load->view('backend/index', $page_data);

    }


    function classAttendanceReport($class_id = NULL, $month = NULL, $year = NULL) {
        
        $active_sms_gateway = $this->db->get_where('sms_settings', array('type' => 'active_sms_gateway'))->row()->info;
        
        
        if ($_POST) {
            redirect(base_url() . 'admin/classAttendanceReport/' . $class_id . '/' . $month . '/' . $year, 'refresh');
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




    /***********  The function below manages school marks - NEW SYSTEM with Academic Terms ***********************/
    function examMarkReport ($academic_year_id = null, $academic_term_id = null, $class_id = null, $student_id = null){

        // Handle form submission
        if($this->input->post('operation') == 'selection'){
            $page_data['academic_year_id']   =  $this->input->post('academic_year_id'); 
            $page_data['academic_term_id']   =  $this->input->post('academic_term_id');
            $page_data['class_id']           =  $this->input->post('class_id');
            $page_data['student_id']         =  $this->input->post('student_id');

            if($page_data['academic_year_id'] > 0 && $page_data['academic_term_id'] > 0 && $page_data['class_id'] > 0 && $page_data['student_id'] > 0){
                redirect(base_url(). 'report/examMarkReport/'. $page_data['academic_year_id'] .'/' . $page_data['academic_term_id'] . '/' . $page_data['class_id'] . '/' . $page_data['student_id'], 'refresh');
            }
            else{
                $this->session->set_flashdata('error_message', get_phrase('Please select something'));
                redirect(base_url(). 'report/examMarkReport', 'refresh');
            }
        }

        // Auto-detect current academic year and term
        $current_year = $this->Score_entry_model->get_current_academic_year();
        $current_term = $this->Score_entry_model->get_current_term();

        $page_data['academic_year_id']   = $academic_year_id ?? ($current_year ? $current_year->academic_year_id : null);
        $page_data['academic_term_id']   = $academic_term_id ?? ($current_term ? $current_term->academic_term_id : null);
        $page_data['class_id']           = $class_id;
        $page_data['student_id']         = $student_id;
        
        // Pass data for populating dropdowns
        $page_data['all_academic_years'] = $this->Academic_year_model->get_all_years();
        $page_data['current_year']       = $current_year;
        $page_data['current_term']       = $current_term;
        
        $page_data['page_name']          = 'examMarkReport';
        $page_data['page_title']         = get_phrase('Student Marks - New System');
        $this->load->view('backend/index', $page_data);
    }

    /**
     * AJAX endpoint to get terms for a selected academic year
     * Returns all terms (Term 1, 2, 3) for the selected year
     * URL: report/get_academic_terms/year_id
     */
    public function get_academic_terms($academic_year_id = null)
    {
        // Accept either URI parameter or POST parameter
        if (!$academic_year_id) {
            $academic_year_id = $this->input->post('academic_year_id');
        }
        
        if (!$academic_year_id) {
            echo '<option value="">Select Academic Term</option>';
            return;
        }

        // Get all terms for this academic year
        $terms = $this->db->where('academic_year_id', $academic_year_id)
                          ->order_by('academic_term_id', 'ASC')
                          ->get('academic_terms')
                          ->result_array();
        
        // Build HTML options
        $html = '<option value="">Select Academic Term</option>';
        foreach ($terms as $term) {
            $html .= '<option value="' . $term['academic_term_id'] . '">' . $term['term_name'] . '</option>';
        }
        
        echo $html;
    }

    /**
     * Handle score entry updates
     */
    public function update_student_scores()
    {
        $this->output->set_content_type('application/json');

        $student_id = $this->input->post('student_id');
        $academic_term_id = $this->input->post('academic_term_id');
        $class_id = $this->input->post('class_id');

        // Get all subjects for this class
        $subjects = $this->Score_entry_model->get_class_subjects($class_id);
        $success_count = 0;
        $errors = [];

        foreach ($subjects as $subject) {
            $subject_id = $subject['subject_id'];
            $emt1 = $this->input->post("emt1_{$subject_id}");
            $emt2 = $this->input->post("emt2_{$subject_id}");
            $emt3 = $this->input->post("emt3_{$subject_id}");
            $sba = $this->input->post("sba_{$subject_id}");
            $project = $this->input->post("project_{$subject_id}");
            $exam = $this->input->post("exam_{$subject_id}");
            $comment = $this->input->post("comment_{$subject_id}");

            // Validate scores
            if (!$this->validate_scores($emt1, $emt2, $emt3, $sba, $project, $exam)) {
                $errors[] = "Invalid scores for {$subject['subject_name']}";
                continue;
            }

            // Calculate scores
            $class_score = $this->Score_entry_model->calculate_class_score($emt1, $emt2, $emt3);
            $total_score = $this->Score_entry_model->calculate_total_score($class_score, $exam);
            $grade_info = $this->Score_entry_model->get_grade_and_proficiency($total_score);

            // Prepare data
            $data = [
                'student_id' => $student_id,
                'academic_term_id' => $academic_term_id,
                'subject_id' => $subject_id,
                'emt1_score' => $emt1,
                'emt2_score' => $emt2,
                'emt3_score' => $emt3,
                'sba_assessment_score' => $sba,
                'project_score' => $project,
                'exam_score' => $exam,
                'class_score_report' => $class_score,
                'exams_score_report' => $exam,
                'total_score' => $total_score,
                'equivalent_numerical_grade' => $grade_info ? $grade_info->grade_letter : null,
                'level_of_proficiency' => $grade_info ? $grade_info->proficiency_level : null,
                'meaning' => $grade_info ? $grade_info->meaning : null,
                'teacher_comment' => $comment,
                'entered_by' => $this->session->userdata('login_id')
            ];

            // Save
            if ($this->Score_entry_model->save_score_entry($data)) {
                $success_count++;
            } else {
                $errors[] = "Failed to save scores for {$subject['subject_name']}";
            }
        }

        echo json_encode([
            'success' => count($errors) == 0,
            'message' => "$success_count scores updated successfully",
            'errors' => $errors
        ]);
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
/***********  The function that manages school marks ends here ***********************/

    /**
     * Student Terminal Report - Individual student report for a given term
     * Shows all subjects and their marks for a student
     */
    public function student_terminal_report($academic_year_id = null, $academic_term_id = null, $student_id = null)
    {
        // Auto-detect current academic year and term
        $current_year = $this->Score_entry_model->get_current_academic_year();
        $current_term = $this->Score_entry_model->get_current_term();

        $page_data['academic_year_id']   = $academic_year_id ?? ($current_year ? $current_year->academic_year_id : null);
        $page_data['academic_term_id']   = $academic_term_id ?? ($current_term ? $current_term->academic_term_id : null);
        $page_data['student_id']         = $student_id;
        
        // Pass data for populating dropdowns
        $page_data['all_academic_years'] = $this->Academic_year_model->get_all_years();
        $page_data['current_year']       = $current_year;
        $page_data['current_term']       = $current_term;
        
        $page_data['page_name']          = 'student_terminal_report';
        $page_data['page_title']         = get_phrase('Student Terminal Report');
        $this->load->view('backend/index', $page_data);
    }

    /**
     * Display student terminal report(s) in a new window
     * Handles both single student and bulk class reports
     * URL: report/student_terminal_report_view (POST)
     */
    public function student_terminal_report_view()
    {
        // Get form data
        $academic_year_id = $this->input->post('academic_year_id');
        $academic_term_id = $this->input->post('academic_term_id');
        $class_id = $this->input->post('class_id');
        $student_id = $this->input->post('student_id');
        $generate_bulk = $this->input->post('generate_bulk');

        // Validate required fields
        if (!$academic_year_id || !$academic_term_id || !$class_id) {
            redirect(base_url() . 'report/student_terminal_report', 'refresh');
        }

        // Get academic year and term details
        $year = $this->db->get_where('academic_years', array('academic_year_id' => $academic_year_id))->row_array();
        $term = $this->db->get_where('academic_terms', array('academic_term_id' => $academic_term_id))->row_array();

        // Prepare page data
        $page_data['academic_year_id'] = $academic_year_id;
        $page_data['academic_term_id'] = $academic_term_id;
        $page_data['class_id'] = $class_id;
        $page_data['student_id'] = $student_id;
        $page_data['year'] = $year;
        $page_data['term'] = $term;

        if ($generate_bulk) {
            // Get all students in the class
            $students = $this->db->where('class_id', $class_id)
                                 ->order_by('roll', 'ASC')
                                 ->get('student')
                                 ->result_array();
            $page_data['students'] = $students;
            $page_data['page_title'] = get_phrase('Class Terminal Reports') . ' - ' . $term['term_name'];
            $this->load->view('backend/admin/student_terminal_report_view_bulk', $page_data);
        } else {
            // Single student report
            if (!$student_id) {
                redirect(base_url() . 'report/student_terminal_report', 'refresh');
            }
            $page_data['page_title'] = get_phrase('Student Terminal Report');
            $this->load->view('backend/admin/student_terminal_report_view_single', $page_data);
        }
    }

    /**
     * AJAX endpoint to get students for a selected class
     * URL: report/get_class_students/class_id
     */
    public function get_class_students($class_id = null)
    {
        if (!$class_id) {
            $class_id = $this->input->post('class_id');
        }
        
        if (!$class_id) {
            echo '<option value="">Select Student</option>';
            return;
        }

        // Get all students in this class
        $students = $this->db->where('class_id', $class_id)
                             ->order_by('roll', 'ASC')
                             ->get('student')
                             ->result_array();
        
        // Build HTML options
        $html = '<option value="">Select Student</option>';
        foreach ($students as $student) {
            $html .= '<option value="' . $student['student_id'] . '">' . $student['name'] . ' (Roll: ' . $student['roll'] . ')</option>';
        }
        
        echo $html;
    }

    /**
     * Class Performance Report - Shows all students and their marks in a class for a given term
     * Allows admin to review all mark entries and see class-wide performance
     */
    public function class_performance_report($academic_year_id = null, $academic_term_id = null, $class_id = null)
    {
        // Auto-detect current academic year and term
        $current_year = $this->Score_entry_model->get_current_academic_year();
        $current_term = $this->Score_entry_model->get_current_term();

        // Handle form submission
        if($this->input->post('operation') == 'selection'){
            $academic_year_id = $this->input->post('academic_year_id'); 
            $academic_term_id = $this->input->post('academic_term_id');
            $class_id = $this->input->post('class_id');

            if($academic_year_id > 0 && $academic_term_id > 0 && $class_id > 0){
                redirect(base_url(). 'report/class_performance_report/'. $academic_year_id .'/' . $academic_term_id . '/' . $class_id, 'refresh');
            }
            else{
                $this->session->set_flashdata('error_message', get_phrase('Please select all required fields'));
                redirect(base_url(). 'report/class_performance_report', 'refresh');
            }
        }

        $page_data['academic_year_id']   = $academic_year_id ?? ($current_year ? $current_year->academic_year_id : null);
        $page_data['academic_term_id']   = $academic_term_id ?? ($current_term ? $current_term->academic_term_id : null);
        $page_data['class_id']           = $class_id;
        
        // Pass data for populating dropdowns
        $page_data['all_academic_years'] = $this->Academic_year_model->get_all_years();
        $page_data['current_year']       = $current_year;
        $page_data['current_term']       = $current_term;
        
        $page_data['page_name']          = 'class_performance_report';
        $page_data['page_title']         = get_phrase('Class Performance Report');
        $this->load->view('backend/index', $page_data);
    }
}