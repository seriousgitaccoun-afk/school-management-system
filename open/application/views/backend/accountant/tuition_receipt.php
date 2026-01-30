<?php
/**
 * Tuition Receipt - Display payment receipt with deduction details
 */
?>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="white-box">
            <div class="receipt-container" id="receiptContent">
                <!-- School Header -->
                <div class="text-center mb-3">
                    <?php 
                    $school_logo = get_school_logo();
                    // Always add cache busting and use current logo
                    $school_logo_with_cache = $school_logo . (strpos($school_logo, '?') !== false ? '&' : '?') . 'nocache=' . microtime(true);
                    
                    // Show logo (now guaranteed to be JPG if uploaded via system)
                    if ($school_logo): 
                    ?>
                        <div style="margin-bottom: 10px;">
                            <img src="<?php echo htmlspecialchars($school_logo_with_cache); ?>" style="max-width: 100px; height: auto;" />
                        </div>
                    <?php endif; ?>
                    <h4><?php echo get_school_name(); ?></h4>
                    <p class="text-muted"><?php echo isset($settings['institute_address']) ? $settings['institute_address'] : ''; ?></p>
                </div>

                <hr>

                <!-- Receipt Details -->
                <div class="receipt-details">
                    <div class="row mb-2">
                        <div class="col-xs-6">
                            <strong><?php echo get_phrase('Receipt Date:'); ?></strong>
                        </div>
                        <div class="col-xs-6 text-right">
                            <?php echo date('M d, Y - h:i A', strtotime($payment['payment_timestamp'])); ?>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-xs-6">
                            <strong><?php echo get_phrase('Receipt No:'); ?></strong>
                        </div>
                        <div class="col-xs-6 text-right">
                            <?php echo 'TUI-' . str_pad($payment['tuition_payment_id'], 6, '0', STR_PAD_LEFT); ?>
                        </div>
                    </div>
                </div>

                <hr>

                <!-- Student Information -->
                <div class="receipt-section">
                    <h5><strong><?php echo get_phrase('Student Information'); ?></strong></h5>
                    
                    <div class="row mb-1">
                        <div class="col-xs-6"><?php echo get_phrase('Name:'); ?></div>
                        <div class="col-xs-6 text-right"><strong><?php echo $student['name']; ?></strong></div>
                    </div>

                    <div class="row mb-1">
                        <div class="col-xs-6"><?php echo get_phrase('Student ID:'); ?></div>
                        <div class="col-xs-6 text-right"><?php echo $student['student_id']; ?></div>
                    </div>

                    <div class="row mb-1">
                        <div class="col-xs-6"><?php echo get_phrase('Class:'); ?></div>
                        <div class="col-xs-6 text-right">
                            <?php 
                            $class = $this->db->get_where('class', ['class_id' => $student['class_id']])->row_array();
                            echo isset($class['name']) ? $class['name'] : 'N/A';
                            ?>
                        </div>
                    </div>
                </div>

                <hr>

                <!-- Payment Breakdown -->
                <div class="receipt-section">
                    <h5><strong><?php echo get_phrase('Payment Breakdown'); ?></strong></h5>
                    
                    <table class="table table-bordered table-condensed payment-breakdown-table">
                        <tr>
                            <td><?php echo get_phrase('Configured Tuition Amount:'); ?></td>
                            <td class="text-right"><strong><?php echo get_currency_symbol() . ' ' . number_format($tuition_amount, 2); ?></strong></td>
                        </tr>
                        <tr>
                            <td><?php echo get_phrase('Amount Paid Today:'); ?></td>
                            <td class="text-right"><span class="text-success"><strong>- <?php echo get_currency_symbol() . ' ' . number_format($payment['amount_paid'], 2); ?></strong></span></td>
                        </tr>
                        <tr style="background-color: #f5f5f5;">
                            <td><strong><?php echo get_phrase('Outstanding Balance:'); ?></strong></td>
                            <td class="text-right">
                                <strong>
                                    <?php 
                                    if ($outstanding <= 0) {
                                        echo '<span class="text-success">' . get_currency_symbol() . ' 0.00 (FULLY PAID)</span>';
                                    } else {
                                        echo '<span class="text-danger">' . get_currency_symbol() . ' ' . number_format($outstanding, 2) . '</span>';
                                    }
                                    ?>
                                </strong>
                            </td>
                        </tr>
                    </table>
                </div>

                <hr>

                <!-- Payment Details -->
                <div class="receipt-section">
                    <h5><strong><?php echo get_phrase('Payment Method'); ?></strong></h5>
                    <p><?php echo ucfirst($payment['payment_method']); ?></p>

                    <?php if ($payment['notes']): ?>
                    <h5><strong><?php echo get_phrase('Notes'); ?></strong></h5>
                    <p><?php echo $payment['notes']; ?></p>
                    <?php endif; ?>
                </div>

                <hr>

                <!-- Footer -->
                <div class="text-center receipt-footer">
                    <p class="text-muted"><small><?php echo get_phrase('Thank you for your payment'); ?></small></p>
                    <p class="text-muted"><small><?php echo get_phrase('Please keep this receipt for your records'); ?></small></p>
                </div>
            </div>

            <!-- Print, Download and Back Buttons (hidden when printing) -->
            <div class="text-center mt-3 no-print">
                <button class="btn btn-primary" onclick="window.print()">
                    <i class="fa fa-print"></i> <?php echo get_phrase('Print Receipt'); ?>
                </button>
                <a href="<?php echo base_url('accountant/tuition_receipt_pdf/' . $student['student_id'] . '/' . $payment['tuition_payment_id']); ?>" class="btn btn-success">
                    <i class="fa fa-download"></i> <?php echo get_phrase('Download PDF'); ?>
                </a>
                <a href="<?php echo base_url('accountant/tuition_payment'); ?>" class="btn btn-default">
                    <i class="fa fa-arrow-left"></i> <?php echo get_phrase('Back'); ?>
                </a>
            </div>
        </div>
    </div>
</div>



<style>
/* Receipt Print Styling */
@media print {
    * {
        margin: 0;
        padding: 0;
    }
    
    body {
        margin: 0;
        padding: 0;
        background: white;
    }
    
    .no-print {
        display: none !important;
    }
    
    .row,
    .col-md-8,
    .col-md-offset-2 {
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
    }
    
    .white-box {
        margin: 0 !important;
        padding: 0 !important;
        border: none !important;
        box-shadow: none !important;
    }
    
    .panel-heading {
        background: white !important;
        border: none !important;
        padding: 0 !important;
    }
    
    .receipt-container {
        width: 140mm;
        height: 210mm;
        padding: 10mm;
        margin: 0 auto;
        page-break-after: avoid;
        border: 1px solid #000;
        background: white;
        font-size: 11pt;
        line-height: 1.3;
        font-family: Arial, sans-serif;
    }
    
    .receipt-container h4 {
        margin: 0 0 2mm 0;
        font-size: 14pt;
        text-align: center;
    }
    
    .receipt-container p {
        margin: 0 0 2mm 0;
        font-size: 9pt;
    }
    
    .receipt-container hr {
        border: none;
        border-top: 1px solid #000;
        margin: 2mm 0;
    }
    
    .receipt-details,
    .receipt-section {
        margin-bottom: 4mm;
    }
    
    .receipt-section h5 {
        font-size: 10pt;
        margin: 2mm 0 1mm 0;
    }
    
    .row {
        display: block;
        margin: 1mm 0 !important;
    }
    
    .col-xs-6 {
        display: inline-block;
        width: 48%;
        margin: 0;
        padding: 0;
    }
    
    .text-right {
        text-align: right;
    }
    
    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 9pt;
        margin: 2mm 0;
    }
    
    .table th,
    .table td {
        border: 1px solid #000;
        padding: 1mm;
        text-align: left;
    }
    
    .table th {
        background: #f5f5f5;
        font-weight: bold;
    }
    
    .text-success {
        color: #28a745;
    }
    
    .text-danger {
        color: #dc3545;
    }
    
    .receipt-footer {
        text-align: center;
        font-size: 8pt;
        margin-top: 3mm;
    }
    
    .receipt-footer p {
        margin: 1mm 0;
    }
}

@media screen {
    .receipt-container {
        padding: 20px;
        background: #fff;
        max-width: 600px;
        margin: 20px auto;
        border: 1px solid #ddd;
    }
    
    .print-only {
        display: none;
    }
}

.receipt-container {
    padding: 20px;
    background: #fff;
}

.receipt-details,
.receipt-section {
    margin-bottom: 15px;
}

/* Payment Breakdown Table Styling */
.payment-breakdown-table {
    margin: 15px 0 !important;
    font-size: 15px !important;
}

.payment-breakdown-table td {
    padding: 12px 15px !important;
    font-size: 14px !important;
}

.payment-breakdown-table tr:last-child td {
    padding: 14px 15px !important;
}

.receipt-footer {
    margin-top: 20px;
}

.no-print {
    margin-top: 20px;
}
</style>
