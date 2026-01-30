<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// PDF generation engine control
// Possible values: 'disabled', 'tcpdf', 'dompdf', 'mpdf'
$config['pdf_engine'] = 'tcpdf';

// Optional: temp dir for PDF libraries (ensure writable)
$config['pdf_temp_dir'] = sys_get_temp_dir();
