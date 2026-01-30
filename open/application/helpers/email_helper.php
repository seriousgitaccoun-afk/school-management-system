<?php
/**
 * Email Helper - Send payment receipts and notifications to parents
 * Handles email generation and sending for student payments
 */

if (!function_exists('send_payment_receipt_email')) {
    /**
     * Send payment receipt email to parent
     * 
     * @param int $student_id Student ID
     * @param int $payment_id Payment ID (tuition_payment_id or daily_fee_id)
     * @param string $payment_type 'tuition' or 'daily'
     * @return bool Success or failure
     */
    function send_payment_receipt_email($student_id, $payment_id, $payment_type = 'tuition') {
        $CI = &get_instance();
        
        // Check if email is enabled
        if (school_setting('email_enabled', 'no') != 'yes') {
            log_message('info', 'Email notifications disabled - receipt not sent for student ' . $student_id);
            return false;
        }
        
        // Get student and parent info
        $student = $CI->db->get_where('student', ['student_id' => $student_id])->row_array();
        if (!$student || !$student['parent_id']) {
            log_message('warning', 'Student ' . $student_id . ' has no linked parent - email not sent');
            return false;
        }
        
        $parent = $CI->db->get_where('parent', ['parent_id' => $student['parent_id']])->row_array();
        if (!$parent || !$parent['email']) {
            log_message('warning', 'Parent ' . $student['parent_id'] . ' has no email address');
            return false;
        }
        
        // Get payment details
        if ($payment_type == 'tuition') {
            $payment = $CI->db->get_where('tuition_payment', ['tuition_payment_id' => $payment_id])->row_array();
            if (!$payment) {
                log_message('error', 'Tuition payment ' . $payment_id . ' not found');
                return false;
            }
            $amount = $payment['amount_paid'];
            $payment_date = $payment['payment_date'] ?? $payment['payment_timestamp'];
        } else {
            $payment = $CI->db->get_where('daily_fee_tracking', ['daily_fee_id' => $payment_id])->row_array();
            if (!$payment) {
                log_message('error', 'Daily fee ' . $payment_id . ' not found');
                return false;
            }
            $amount = $payment['amount'];
            $payment_date = $payment['payment_date'] ?? $payment['created_at'];
        }
        
        // Build receipt HTML
        $html_body = build_receipt_email_html($student, $parent, $payment, $amount, $payment_type, $payment_date);
        
        // Send email
        return send_email_receipt(
            $parent['email'],
            $parent['name'],
            $student['name'],
            $amount,
            $html_body
        );
    }
}

if (!function_exists('build_receipt_email_html')) {
    /**
     * Build HTML email body for receipt
     */
    function build_receipt_email_html($student, $parent, $payment, $amount, $payment_type, $payment_date) {
        $school_name = get_school_name();
        $currency = get_currency_symbol();
        $logo_url = get_school_logo();
        
        $payment_type_label = ($payment_type == 'tuition') ? 'Tuition Payment' : 'Daily Fee';
        $date_formatted = date('M d, Y - h:i A', strtotime($payment_date));
        
        $html = '<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; background-color: #f5f5f5;">';
        
        // Header
        $html .= '<div style="background-color: #f5f5f5; padding: 20px; text-align: center;">';
        if ($logo_url) {
            $html .= '<div style="margin-bottom: 10px;"><img src="' . htmlspecialchars($logo_url) . '" style="max-width: 60px; height: auto;" /></div>';
        }
        $html .= '<h2 style="margin: 0; color: #2b2b2b;">' . htmlspecialchars($school_name) . '</h2>';
        $html .= '</div>';
        
        // Body
        $html .= '<div style="background-color: #ffffff; padding: 30px; border-bottom: 3px solid #0066cc;">';
        
        // Title
        $html .= '<h3 style="color: #2b2b2b; margin-bottom: 20px;">' . htmlspecialchars($payment_type_label) . '</h3>';
        
        // Dear Parent
        $html .= '<p style="color: #686868; font-size: 14px;">Dear ' . htmlspecialchars($parent['name']) . ',</p>';
        
        // Message
        $html .= '<p style="color: #686868; font-size: 14px;">A payment has been recorded for your child, ' . htmlspecialchars($student['name']) . '. Below are the details:</p>';
        
        // Details Table
        $html .= '<table style="width: 100%; border-collapse: collapse; margin: 20px 0;">';
        
        $html .= '<tr style="border-bottom: 1px solid #ddd;">';
        $html .= '<td style="padding: 10px; color: #2b2b2b; font-weight: bold;">Student Name:</td>';
        $html .= '<td style="padding: 10px; color: #0066cc;">' . htmlspecialchars($student['name']) . '</td>';
        $html .= '</tr>';
        
        $html .= '<tr style="border-bottom: 1px solid #ddd;">';
        $html .= '<td style="padding: 10px; color: #2b2b2b; font-weight: bold;">Student ID:</td>';
        $html .= '<td style="padding: 10px; color: #686868;">' . htmlspecialchars($student['student_id']) . '</td>';
        $html .= '</tr>';
        
        $html .= '<tr style="border-bottom: 1px solid #ddd;">';
        $html .= '<td style="padding: 10px; color: #2b2b2b; font-weight: bold;">Payment Type:</td>';
        $html .= '<td style="padding: 10px; color: #686868;">' . htmlspecialchars($payment_type_label) . '</td>';
        $html .= '</tr>';
        
        $html .= '<tr style="border-bottom: 1px solid #ddd;">';
        $html .= '<td style="padding: 10px; color: #2b2b2b; font-weight: bold;">Amount Paid:</td>';
        $html .= '<td style="padding: 10px; color: #0066cc; font-weight: bold; font-size: 16px;">' . htmlspecialchars($currency) . ' ' . number_format($amount, 2) . '</td>';
        $html .= '</tr>';
        
        $html .= '<tr style="border-bottom: 1px solid #ddd;">';
        $html .= '<td style="padding: 10px; color: #2b2b2b; font-weight: bold;">Payment Date:</td>';
        $html .= '<td style="padding: 10px; color: #686868;">' . htmlspecialchars($date_formatted) . '</td>';
        $html .= '</tr>';
        
        $html .= '</table>';
        
        // Thank you message
        $html .= '<p style="color: #686868; font-size: 14px;">Thank you for your payment. If you have any questions, please contact the accounting department.</p>';
        
        $html .= '</div>';
        
        // Footer
        $html .= '<div style="background-color: #f5f5f5; padding: 15px; text-align: center; font-size: 12px; color: #686868;">';
        $html .= '<p style="margin: 0;">This is an automated receipt notification.</p>';
        $html .= '<p style="margin: 5px 0 0 0;">&copy; ' . date('Y') . ' ' . htmlspecialchars($school_name) . ' - All Rights Reserved</p>';
        $html .= '</div>';
        
        $html .= '</div>';
        
        return $html;
    }
}

if (!function_exists('send_email_receipt')) {
    /**
     * Send email with receipt
     */
    function send_email_receipt($to_email, $parent_name, $student_name, $amount, $html_body) {
        $CI = &get_instance();
        
        // Check email configuration
        $email_address = school_setting('email_address', '');
        $email_password = school_setting('email_password', '');
        $email_from_name = school_setting('email_from_name', get_school_name());
        $email_from_address = school_setting('email_from_address', '');
        
        if (empty($email_address) || empty($email_password)) {
            log_message('error', 'Email configuration incomplete - missing Gmail credentials');
            return false;
        }
        
        $from_email = !empty($email_from_address) ? $email_from_address : $email_address;
        
        // Load email library
        $CI->load->library('email');
        
        // Configure SMTP
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
        
        $CI->email->initialize($config);
        
        // Build subject line with placeholders
        $school_name = get_school_name();
        $subject_template = school_setting('email_subject_receipt', 'Payment Receipt - {SCHOOL_NAME}');
        $subject = str_replace(
            ['{SCHOOL_NAME}', '{STUDENT_NAME}'],
            [$school_name, $student_name],
            $subject_template
        );
        
        // Send email
        $CI->email->from($from_email, $email_from_name);
        $CI->email->to($to_email);
        $CI->email->subject($subject);
        $CI->email->message($html_body);
        
        if ($CI->email->send()) {
            log_message('info', 'Receipt email sent to ' . $to_email . ' for student ' . $student_name . ' - Amount: ' . $amount);
            return true;
        } else {
            log_message('error', 'Failed to send receipt email to ' . $to_email . ': ' . $CI->email->print_debugger());
            return false;
        }
    }
}

if (!function_exists('log_email_sent')) {
    /**
     * Log email send event (for future audit trail)
     */
    function log_email_sent($student_id, $parent_id, $amount, $payment_type, $status = 'sent') {
        $CI = &get_instance();
        
        $log_data = [
            'student_id' => $student_id,
            'parent_id' => $parent_id,
            'amount' => $amount,
            'payment_type' => $payment_type,
            'status' => $status,
            'sent_at' => date('Y-m-d H:i:s')
        ];
        
        // Could be stored in email_log table if needed
        log_message('info', 'Email logged: ' . json_encode($log_data));
    }
}
?>
