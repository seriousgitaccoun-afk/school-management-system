<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



class Systemsetting extends CI_Controller { 

    function __construct() {
        parent::__construct();
        		$this->load->database();							// load database library
        		$this->load->library('session');					//Load library for session
    }


/**default functin, redirects to login page if no admin logged in yet***/
    public function index() {
        	if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'login', 'refresh');
        	if ($this->session->userdata('admin_login') == 1)
            redirect(base_url() . 'admin/dashboard', 'refresh');
    }

   

   /************** Manage system setings  ********************/
	function system_settings($param1 = '', $param2 = '', $param3 = '') 
	{
    if ($this->session->userdata('admin_login') != 1)
    redirect(base_url() . 'login', 'refresh');


        if ($param1 == 'do_update') {
           
        $this->crud_model->update_settings();

        $this->session->set_flashdata('flash_message', get_phrase('Data Updated'));
        redirect(base_url(). 'systemsetting/system_settings', 'refresh');
    }

    if ($param1 == 'upload_logo') 
	{
       $this->crud_model->system_logo();
       $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
       redirect(base_url() . 'systemsetting/system_settings', 'refresh');
    }


    if ($param1 == 'themeSettings') 
	{
        $this->crud_model->update_theme();
        $this->session->set_flashdata('flash_message', get_phrase('Theme Selected'));
        redirect(base_url() . 'systemsetting/system_settings', 'refresh');
    }


    $page_data['page_name'] = 'system_settings';
    $page_data['page_title'] = get_phrase('system_settings');
    $page_data['settings'] = $this->db->get('settings')->result_array();
    
    // Load academic years and current settings for academic settings section
    $this->load->model('Score_entry_model');
    $page_data['academic_years'] = $this->db->order_by('academic_year_id', 'DESC')->get('academic_years')->result_array();
    $page_data['current_year'] = $this->Score_entry_model->get_current_academic_year();
    $page_data['current_term'] = $this->Score_entry_model->get_current_term();
    
    $this->load->view('backend/index', $page_data);
    }
	
	/**
	 * Send test email to verify email configuration
	 */
	function send_test_email() {
		if ($this->session->userdata('admin_login') != 1) {
			echo json_encode(['success' => false, 'message' => 'Unauthorized']);
			return;
		}
		
		$test_email = $this->input->post('test_email');
		
		if (!filter_var($test_email, FILTER_VALIDATE_EMAIL)) {
			echo json_encode(['success' => false, 'message' => 'Invalid email address']);
			return;
		}
		
		// Get email configuration from settings
		$email_enabled = school_setting('email_enabled', 'no');
		$email_address = school_setting('email_address', '');
		$email_password = school_setting('email_password', '');
		$email_from_name = school_setting('email_from_name', get_school_name());
		$email_from_address = school_setting('email_from_address', '');
		
		// Validate configuration
		if ($email_enabled != 'yes') {
			echo json_encode(['success' => false, 'message' => 'Email notifications are disabled']);
			return;
		}
		
		if (empty($email_address) || empty($email_password)) {
			echo json_encode(['success' => false, 'message' => 'Gmail address and password are required']);
			return;
		}
		
		// Load email library
		$this->load->library('email');
		
		// Configure email
		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 465,
			'smtp_timeout' => 30,
			'smtp_user' => $email_address,
			'smtp_pass' => $email_password,
			'charset' => 'utf-8',
			'newline' => "\r\n",
			'mailtype' => 'html',
			'crlf' => "\r\n"
		);
		
		$this->email->initialize($config);
		
		// Build test email
		$school_name = get_school_name();
		$from_email = !empty($email_from_address) ? $email_from_address : $email_address;
		
		$this->email->from($from_email, $email_from_name);
		$this->email->to($test_email);
		$this->email->subject('Test Email - ' . $school_name);
		
		$html_body = '<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">';
		$html_body .= '<div style="background-color: #f5f5f5; padding: 20px; text-align: center; border-radius: 5px 5px 0 0;">';
		$html_body .= '<h2 style="margin: 0; color: #2b2b2b;">' . htmlspecialchars($school_name) . '</h2>';
		$html_body .= '</div>';
		$html_body .= '<div style="background-color: #fff; padding: 30px; border: 1px solid #ddd; border-radius: 0 0 5px 5px;">';
		$html_body .= '<h3 style="color: #2b2b2b;">Email Configuration Test</h3>';
		$html_body .= '<p>This is a test email to verify your email configuration is working correctly.</p>';
		$html_body .= '<hr style="border: none; border-top: 1px solid #ddd; margin: 20px 0;">';
		$html_body .= '<p><strong>Sender:</strong> ' . htmlspecialchars($email_from_name) . ' &lt;' . htmlspecialchars($from_email) . '&gt;</p>';
		$html_body .= '<p><strong>Test Sent At:</strong> ' . date('M d, Y - h:i A') . '</p>';
		$html_body .= '<p style="color: #0066cc; font-weight: bold;">✓ Email system is configured correctly!</p>';
		$html_body .= '</div>';
		$html_body .= '</div>';
		
		$this->email->message($html_body);
		
		// Send email
		if ($this->email->send()) {
			echo json_encode(['success' => true, 'message' => 'Test email sent successfully to ' . htmlspecialchars($test_email)]);
		} else {
			echo json_encode(['success' => false, 'message' => 'Failed to send email: ' . $this->email->print_debugger()]);
		}
	}


	
	
}
