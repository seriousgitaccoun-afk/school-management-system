<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * School Settings Helper
 * 
 * Provides functions to retrieve school customization settings from database
 * Simplifies access to system configuration throughout the application
 * 
 * @package		CodeIgniter
 * @author		School Management System
 * @version		1.0
 * @filesource
 */

if ( ! function_exists('school_setting'))
{
	/**
	 * Retrieve a school setting from the settings table
	 * 
	 * @param string $key The setting type/key to retrieve
	 * @param string $default Default value if setting not found
	 * @return string The setting value or default
	 */
	function school_setting($key = '', $default = null) {
		$CI = &get_instance();
		$CI->load->database();
		
		if (empty($key)) {
			return $default;
		}
		
		$setting = $CI->db->get_where('settings', array('type' => $key))->row();
		
		if ($setting && !empty($setting->description)) {
			return $setting->description;
		}
		
		return $default;
	}
}

if ( ! function_exists('is_feature_enabled'))
{
	/**
	 * Check if a feature is enabled
	 * 
	 * @param string $feature_name The feature to check (e.g., 'hostel', 'transportation')
	 * @return boolean True if feature is enabled, false otherwise
	 */
	function is_feature_enabled($feature_name = '') {
		if (empty($feature_name)) {
			return false;
		}
		
		$setting = school_setting('features_' . $feature_name, 'no');
		return (strtolower($setting) === 'yes' || strtolower($setting) === 'true' || $setting === '1');
	}
}

if ( ! function_exists('get_school_name'))
{
	/**
	 * Get the school/system name
	 * 
	 * @return string School name
	 */
	function get_school_name() {
		return school_setting('system_title', 'School Management System');
	}
}

if ( ! function_exists('get_school_logo'))
{
	/**
	 * Get the school logo URL
	 * Dynamically checks for logo file with any extension
	 * 
	 * @return string Complete URL to school logo
	 */
	function get_school_logo() {
		$CI = &get_instance();
		
		// Get the stored logo setting (might be logo.jpg, logo.png, etc.)
		$logo_setting = school_setting('logo', 'uploads/logo.jpg');
		
		// If setting has extension, use it directly
		if (!empty($logo_setting)) {
			// Check if file exists with the stored path
			$file_path = FCPATH . $logo_setting;
			if (file_exists($file_path)) {
				return base_url() . $logo_setting;
			}
		}
		
		// Otherwise, search for any logo file in uploads directory
		$uploads_path = FCPATH . 'uploads/';
		$allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
		
		foreach ($allowed_extensions as $ext) {
			$logo_file = $uploads_path . 'logo.' . $ext;
			if (file_exists($logo_file)) {
				return base_url() . 'uploads/logo.' . $ext;
			}
		}
		
		// Return default if no logo found
		return base_url() . 'uploads/logo.jpg';
	}
}

if ( ! function_exists('get_school_principal'))
{
	/**
	 * Get the principal's name and title
	 * 
	 * @return array Array with 'name' and 'title' keys
	 */
	function get_school_principal() {
		return array(
			'name' => school_setting('principal_name', 'Principal'),
			'title' => school_setting('principal_title', 'Principal')
		);
	}
}

if ( ! function_exists('get_currency_symbol'))
{
	/**
	 * Get the currency symbol for the school
	 * 
	 * @return string Currency symbol
	 */
	function get_currency_symbol() {
		return school_setting('currency', '₵');
	}
}

if ( ! function_exists('get_school_contact'))
{
	/**
	 * Get school contact information
	 * 
	 * @return array Array with phone, email, address, website
	 */
	function get_school_contact() {
		return array(
			'phone' => school_setting('phone', 'N/A'),
			'email' => school_setting('system_email', 'N/A'),
			'address' => school_setting('address', 'N/A'),
			'website' => school_setting('website', 'N/A')
		);
	}
}

if ( ! function_exists('get_school_info'))
{
	/**
	 * Get complete school information
	 * 
	 * @return array Complete school information array
	 */
	function get_school_info() {
		return array(
			'name' => school_setting('system_title', 'School'),
			'motto' => school_setting('school_motto', ''),
			'phone' => school_setting('phone', 'N/A'),
			'email' => school_setting('system_email', 'N/A'),
			'address' => school_setting('address', 'N/A'),
			'website' => school_setting('website', 'N/A'),
			'logo' => school_setting('logo', 'uploads/logo.png'),
			'principal_name' => school_setting('principal_name', ''),
			'principal_title' => school_setting('principal_title', 'Principal'),
			'board_affiliation' => school_setting('board_affiliation', ''),
			'accreditation_no' => school_setting('accreditation_no', ''),
			'registration_no' => school_setting('registration_no', ''),
			'year_established' => school_setting('year_established', ''),
			'currency' => school_setting('currency', '₵')
		);
	}
}

if ( ! function_exists('get_all_academic_years'))
{
	/**
	 * Get all academic years available in the system
	 * Available to all roles (Admin, Teacher, Student, Parent)
	 * 
	 * @return array Array of academic year objects
	 */
	function get_all_academic_years() {
		$CI = &get_instance();
		$CI->load->database();
		$CI->load->model('Academic_year_model');
		return $CI->Academic_year_model->get_all_years();
	}
}

/* End of file settings_helper.php */
/* Location: ./application/helpers/settings_helper.php */
