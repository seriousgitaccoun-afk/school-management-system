<?php
/**
 * Invoice Detail View
 * Displays complete invoice with payment history
 * Can be printed or converted to PDF
 */
?>

<div class="page-wrapper" style="padding: 20px;">
    <div class="container-fluid">
        <?php
        // Get system settings for school info
        $setting = $this->crud_model->get_settings();
        ?>

        <!-- Invoice Container -->
        <div class="invoice-container" style="max-width: 900px; margin: 0 auto; background: white; padding: 40px; border: 1px solid #ddd;">
            
            <!-- Header -->
            <div class="invoice-header" style="text-align: center; border-bottom: 2px solid #333; padding-bottom: 20px; margin-bottom: 30px;">
                <h2 style="margin: 0 0 5px 0; color: #333;"><?php echo $setting['school_name']; ?></h2>
                <p style="margin: 5px 0; color: #666; font-size: 12px;">
                    <?php echo $setting['school_address']; ?><br>
                    <?php echo get_phrase('Phone:'); ?> <?php echo $setting['phone']; ?> | 
                    <?php echo get_phrase('Email:'); ?> <?php echo $setting['email']; ?>
                </p>
                <h3 style="margin: 10px 0 0 0; color: #0066cc;"><?php echo get_phrase('Invoice'); ?></h3>
            </div>

            <!-- Invoice Details -->
            <div class="invoice-details" style="margin-bottom: 30px;">
                
                <!-- Invoice Info & Student Info Side by Side -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px;">
                    
                    <!-- Invoice Information -->
                    <div style="background: #f8f9fa; padding: 15px; border-radius: 5px;">
                        <h4 style="margin: 0 0 15px 0; color: #333;">
                            <i class="fa fa-file-text"></i> <?php echo get_phrase('Invoice Information'); ?>
                        </h4>
                        <p style="margin: 8px 0;">
                            <strong><?php echo get_phrase('Invoice Number:'); ?></strong><br>
                            <span style="font-family: monospace; font-size: 14px; font-weight: bold;">
                                <?php echo $invoice['invoice_number']; ?>
                            </span>
                        </p>
                        <p style="margin: 8px 0;">
                            <strong><?php echo get_phrase('Invoice Date:'); ?></strong><br>
                            <?php echo date('d M Y', strtotime($invoice['creation_timestamp'])); ?>
                        </p>
                        <p style="margin: 8px 0;">
                            <strong><?php echo get_phrase('Year:'); ?></strong><br>
                            <?php echo $invoice['year']; ?>
                        </p>
                        <p style="margin: 8px 0;">
                            <strong><?php echo get_phrase('Status:'); ?></strong><br>
                            <span style="display: inline-block; padding: 3px 8px; background: <?php echo ($invoice['status'] == 2) ? '#28a745' : '#ffc107'; ?>; color: <?php echo ($invoice['status'] == 2) ? 'white' : 'black'; ?>; border-radius: 3px; font-weight: bold;">
                                <?php echo ($invoice['status'] == 2) ? get_phrase('Paid') : get_phrase('Unpaid'); ?>
                            </span>
                        </p>
                    </div>

                    <!-- Student Information -->
                    <div style="background: #f8f9fa; padding: 15px; border-radius: 5px;">
                        <h4 style="margin: 0 0 15px 0; color: #333;">
                            <i class="fa fa-user"></i> <?php echo get_phrase('Student Information'); ?>
                        </h4>
                        <p style="margin: 8px 0;">
                            <strong><?php echo get_phrase('Student Name:'); ?></strong><br>
                            <?php echo isset($student['student_name']) ? $student['student_name'] : '-'; ?>
                        </p>
                        <p style="margin: 8px 0;">
                            <strong><?php echo get_phrase('Student ID:'); ?></strong><br>
                            <?php echo isset($student['student_id']) ? $student['student_id'] : '-'; ?>
                        </p>
                        <p style="margin: 8px 0;">
                            <strong><?php echo get_phrase('Email:'); ?></strong><br>
                            <?php echo isset($student['email']) ? $student['email'] : '-'; ?>
                        </p>
                        <p style="margin: 8px 0;">
                            <strong><?php echo get_phrase('Class:'); ?></strong><br>
                            <?php 
                                if (isset($student['class_id'])) {
                                    $class = $this->db->get_where('class', array('class_id' => $student['class_id']))->row_array();
                                    echo isset($class['name']) ? $class['name'] : '-';
                                } else {
                                    echo '-';
                                }
                            ?>
                        </p>
                    </div>
                </div>

                <!-- Invoice Item Details -->
                <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                    <h4 style="margin: 0 0 15px 0; color: #333;">
                        <i class="fa fa-list"></i> <?php echo get_phrase('Invoice Details'); ?>
                    </h4>
                    
                    <p style="margin: 8px 0;">
                        <strong><?php echo get_phrase('Title:'); ?></strong> 
                        <br><?php echo $invoice['title']; ?>
                    </p>

                    <p style="margin: 8px 0;">
                        <strong><?php echo get_phrase('Description:'); ?></strong>
                        <br><?php echo !empty($invoice['description']) ? $invoice['description'] : '-'; ?>
                    </p>

                    <p style="margin: 8px 0;">
                        <strong><?php echo get_phrase('Payment Method:'); ?></strong>
                        <br><?php echo $invoice['payment_method']; ?>
                    </p>
                </div>

                <!-- Amount Summary -->
                <div style="border: 2px solid #0066cc; border-radius: 5px; padding: 20px; margin-bottom: 20px;">
                    <h4 style="margin: 0 0 15px 0; color: #333;">
                        <?php echo get_phrase('Amount Summary'); ?>
                    </h4>

                    <div style="display: grid; grid-template-columns: 1fr auto; gap: 20px; margin-bottom: 10px;">
                        <span><?php echo get_phrase('Original Amount:'); ?></span>
                        <span style="text-align: right; font-weight: bold;">
                            <?php echo $setting['currency_symbol']; ?><?php echo number_format($invoice['amount'], 2); ?>
                        </span>
                    </div>
                    
                    <?php if (!empty($invoice['discount'])): ?>
                        <div style="display: grid; grid-template-columns: 1fr auto; gap: 20px; margin-bottom: 10px; color: #dc3545;">
                            <span><?php echo get_phrase('Discount:'); ?></span>
                            <span style="text-align: right;">
                                -<?php echo $setting['currency_symbol']; ?><?php echo number_format($invoice['discount'], 2); ?>
                            </span>
                        </div>
                    <?php endif; ?>

                    <div style="display: grid; grid-template-columns: 1fr auto; gap: 20px; margin-bottom: 15px; border-bottom: 1px solid #ddd; padding-bottom: 10px;">
                        <span><?php echo get_phrase('Total Due:'); ?></span>
                        <span style="text-align: right; font-weight: bold;">
                            <?php echo $setting['currency_symbol']; ?><?php echo number_format(($invoice['amount'] - $invoice['discount']), 2); ?>
                        </span>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr auto; gap: 20px; margin-bottom: 10px;">
                        <span><?php echo get_phrase('Amount Paid:'); ?></span>
                        <span style="text-align: right; font-weight: bold; color: #28a745;">
                            <?php echo $setting['currency_symbol']; ?><?php echo number_format($invoice['amount_paid'], 2); ?>
                        </span>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr auto; gap: 20px; border-top: 2px solid #0066cc; padding-top: 10px;">
                        <span style="font-weight: bold; font-size: 16px;"><?php echo get_phrase('Balance Due:'); ?></span>
                        <span style="text-align: right; font-weight: bold; font-size: 18px; color: <?php echo ($invoice['due'] > 0) ? '#dc3545' : '#28a745'; ?>;">
                            <?php echo $setting['currency_symbol']; ?><?php echo number_format($invoice['due'], 2); ?>
                        </span>
                    </div>
                </div>

                <!-- Payment History -->
                <?php
                $payments = $this->db->get_where('payment', array('invoice_id' => $invoice['invoice_id']))->result_array();
                if (!empty($payments)):
                ?>
                <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                    <h4 style="margin: 0 0 15px 0; color: #333;">
                        <i class="fa fa-history"></i> <?php echo get_phrase('Payment History'); ?>
                    </h4>
                    
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: #e8f0fe;">
                                <th style="border: 1px solid #ddd; padding: 10px; text-align: left;"><?php echo get_phrase('Date'); ?></th>
                                <th style="border: 1px solid #ddd; padding: 10px; text-align: left;"><?php echo get_phrase('Amount'); ?></th>
                                <th style="border: 1px solid #ddd; padding: 10px; text-align: left;"><?php echo get_phrase('Method'); ?></th>
                                <th style="border: 1px solid #ddd; padding: 10px; text-align: left;"><?php echo get_phrase('Description'); ?></th>
                                <th style="border: 1px solid #ddd; padding: 10px; text-align: center;"><?php echo get_phrase('Receipt'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($payments as $payment): ?>
                            <tr>
                                <td style="border: 1px solid #ddd; padding: 10px;">
                                    <?php echo date('d M Y', $payment['timestamp']); ?>
                                </td>
                                <td style="border: 1px solid #ddd; padding: 10px; font-weight: bold; color: #28a745;">
                                    <?php echo $setting['currency_symbol']; ?><?php echo number_format($payment['amount'], 2); ?>
                                </td>
                                <td style="border: 1px solid #ddd; padding: 10px;">
                                    <?php echo $payment['method']; ?>
                                </td>
                                <td style="border: 1px solid #ddd; padding: 10px;">
                                    <?php echo !empty($payment['description']) ? substr($payment['description'], 0, 30) . '...' : '-'; ?>
                                </td>
                                <td style="border: 1px solid #ddd; padding: 10px; text-align: center;">
                                    <a href="<?php echo base_url('accountant/receipt/' . $payment['payment_id']); ?>" class="btn btn-xs btn-info" target="_blank" title="<?php echo get_phrase('View Receipt'); ?>">
                                        <i class="fa fa-receipt"></i> <?php echo get_phrase('View'); ?>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>

                <!-- Accountant Info -->
                <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                    <h4 style="margin: 0 0 10px 0; color: #333;"><?php echo get_phrase('Issued By'); ?></h4>
                    <p style="margin: 5px 0;">
                        <strong><?php echo get_phrase('Accountant:'); ?></strong> 
                        <?php echo $current_accountant['name']; ?>
                    </p>
                </div>

            </div>

            <!-- Footer -->
            <div class="invoice-footer" style="text-align: center; border-top: 2px solid #333; padding-top: 20px; color: #666; font-size: 12px;">
                <p style="margin: 5px 0;">
                    <?php echo get_phrase('This is a computer generated invoice.'); ?>
                </p>
                <p style="margin: 5px 0;">
                    <?php echo $setting['school_name']; ?> © <?php echo date('Y'); ?>
                </p>
            </div>

        </div>

        <!-- Print and Back Buttons -->
        <div style="text-align: center; margin-top: 30px;">
            <button class="btn btn-primary" onclick="window.print();">
                <i class="fa fa-print"></i> <?php echo get_phrase('Print Invoice'); ?>
            </button>
            <button class="btn btn-secondary" onclick="window.history.back();">
                <i class="fa fa-arrow-left"></i> <?php echo get_phrase('Back'); ?>
            </button>
        </div>
    </div>
</div>

<style>
    @media print {
        .invoice-container {
            border: none;
            padding: 0;
            margin: 0;
        }
        
        button {
            display: none;
        }
        
        .page-wrapper {
            padding: 0;
        }
        
        body {
            background: white;
        }
    }

    .invoice-container {
        font-family: 'Arial', sans-serif;
        color: #333;
        line-height: 1.6;
    }

    .invoice-header h2 {
        font-weight: bold;
    }

    .invoice-header p {
        line-height: 1.4;
    }
</style>


