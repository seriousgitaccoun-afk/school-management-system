<?php
/**
 * Receipt/Voucher View for Accountant Module
 * Displays transaction receipt with all relevant payment details
 * Designed to be printable and email-friendly
 */
?>

<div class="page-wrapper" style="padding: 20px;">
    <div class="container-fluid">
        <?php
        // Get system settings for school info
        $setting = $this->crud_model->get_settings();
        ?>

        <!-- Receipt Container -->
        <div id="receipt-container" class="receipt-container" style="max-width: 420px; margin: 0 auto; background: white; padding: 10mm; border: 1px solid #ddd;">
            
            <!-- Header -->
            <div class="receipt-header" style="text-align: center; border-bottom: 1px solid #eeeeee; padding-bottom: 5mm; margin-bottom: 5mm;">
                <div style="margin-bottom:3mm;">
                    <img src="<?php echo get_school_logo(); ?>" alt="logo" class="receipt-logo" style="width:35mm; height:35mm; object-fit:contain; display:block; margin:0 auto 3mm;">
                </div>
                <h2 style="margin: 0 0 2mm 0; color: #333; font-size:16pt; font-weight:700;"><?php echo $setting['school_name']; ?></h2>
                <div class="receipt-meta" style="margin-top:5mm; display:grid; grid-template-columns:1fr 1fr; gap:5mm; font-size:10pt;">
                    <div><strong><?php echo get_phrase('Receipt Date:'); ?></strong> <?php echo date('d M, Y - h:i A', $payment['timestamp']); ?></div>
                    <div style="text-align:right;"><strong><?php echo get_phrase('Receipt No:'); ?></strong> RCP-<?php echo $payment['payment_id']; ?></div>
                </div>
            </div>
            
            <!-- Receipt Details -->

            <!-- Receipt Details -->
            <div class="receipt-details" style="margin-bottom: 30px;">
                
                <!-- Transaction Info -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 20px;">
                    <div>
                        <p style="margin: 5px 0; font-weight: bold;">
                            <?php echo get_phrase('Receipt Number:'); ?> 
                            <span style="font-family: monospace; font-weight: normal;">RCP-<?php echo $payment['payment_id']; ?>-<?php echo date('Ymd', $payment['timestamp']); ?></span>
                        </p>
                        <p style="margin: 5px 0;">
                            <?php echo get_phrase('Receipt Date:'); ?> 
                            <span><?php echo date('d M Y', $payment['timestamp']); ?></span>
                        </p>
                        <p style="margin: 5px 0;">
                            <?php echo get_phrase('Receipt Time:'); ?> 
                            <span><?php echo date('h:i A', $payment['timestamp']); ?></span>
                        </p>
                    </div>
                    <div style="text-align: right;">
                        <p style="margin: 5px 0;">
                            <?php echo get_phrase('Payment Type:'); ?>
                            <span style="display: inline-block; padding: 3px 8px; background: <?php echo ($payment['payment_type'] == 'income') ? '#28a745' : '#dc3545'; ?>; color: white; border-radius: 3px; font-weight: bold;">
                                <?php echo ucfirst($payment['payment_type']); ?>
                            </span>
                        </p>
                        <p style="margin: 5px 0;">
                            <?php echo get_phrase('Payment Method:'); ?> 
                            <span><?php echo $payment['method']; ?></span>
                        </p>
                        <p style="margin: 5px 0;">
                            <?php echo get_phrase('Year:'); ?> 
                            <span><?php echo $payment['year']; ?></span>
                        </p>
                    </div>
                </div>

                <!-- Invoice/Student Info -->
                <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                    <h4 style="margin: 0 0 10px 0; color: #333;"><?php echo get_phrase('Payment Details'); ?></h4>
                    
                    <p style="margin: 8px 0;">
                        <strong><?php echo get_phrase('Title:'); ?></strong> 
                        <?php echo $payment['title']; ?>
                    </p>

                    <?php if (!empty($payment['invoice_id'])): 
                        $invoice = $this->db->get_where('invoice', array('invoice_id' => $payment['invoice_id']))->row_array();
                    ?>
                        <p style="margin: 8px 0;">
                            <strong><?php echo get_phrase('Invoice Number:'); ?></strong> 
                            <?php echo $invoice['invoice_number']; ?>
                        </p>
                        <p style="margin: 8px 0;">
                            <strong><?php echo get_phrase('Invoice Amount:'); ?></strong> 
                            <?php echo $setting['currency_symbol']; ?><?php echo number_format($invoice['amount'], 2); ?>
                        </p>
                    <?php endif; ?>

                    <?php if (!empty($payment['student_id'])):
                        $student = $this->db->get_where('student', array('student_id' => $payment['student_id']))->row_array();
                    ?>
                        <p style="margin: 8px 0;">
                            <strong><?php echo get_phrase('Student Name:'); ?></strong> 
                            <?php echo $student['student_name']; ?>
                        </p>
                        <p style="margin: 8px 0;">
                            <strong><?php echo get_phrase('Student ID:'); ?></strong> 
                            <?php echo $student['student_id']; ?>
                        </p>
                    <?php endif; ?>

                    <?php if (!empty($payment['description'])): ?>
                        <p style="margin: 8px 0;">
                            <strong><?php echo get_phrase('Description:'); ?></strong> 
                            <?php echo $payment['description']; ?>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Payment Breakdown -->
                <div style="margin-bottom:20px;">
                  <table style="width:100%; border-collapse:collapse; border:1px solid #dddddd; font-size:10pt;">
                    <tbody>
                      <tr>
                        <td style="padding:6px;">Configured Tuition Amount:</td>
                        <td style="padding:6px; text-align:right;"><?php echo (!empty($invoice['amount'])) ? $setting['currency_symbol'].' '.number_format($invoice['amount'],2) : '-'; ?></td>
                      </tr>
                      <tr>
                        <td style="padding:6px;">Amount Paid Today:</td>
                        <td style="padding:6px; text-align:right; color:#008c7a;">- <?php echo $setting['currency_symbol']; ?> <?php echo number_format($payment['amount'],2); ?></td>
                      </tr>
                      <?php 
                        $outstanding = (!empty($invoice['amount'])) ? ($invoice['amount'] - $payment['amount']) : null;
                      ?>
                      <tr class="outstanding-balance-row">
                        <td style="padding:8px; font-weight:700; background:#f9f9f9;">Outstanding Balance:</td>
                        <td style="padding:8px; text-align:right; font-weight:700; background:#f9f9f9; color:#e67e22;"><?php echo (!is_null($outstanding)) ? $setting['currency_symbol'].' '.number_format($outstanding,2) : '-'; ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <!-- Accountant Info -->
                <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                    <h4 style="margin: 0 0 10px 0; color: #333;"><?php echo get_phrase('Received By'); ?></h4>
                    <p style="margin: 5px 0;">
                        <strong><?php echo get_phrase('Accountant:'); ?></strong> 
                        <?php echo $current_accountant['name']; ?>
                    </p>
                    <p style="margin: 5px 0;">
                        <strong><?php echo get_phrase('Employee ID:'); ?></strong> 
                        <?php echo $current_accountant['accountant_id']; ?>
                    </p>
                </div>

                <!-- Payment Status -->
                <div style="text-align: center; margin-bottom: 30px;">
                    <div style="display: inline-block; padding: 10px 20px; background: #28a745; color: white; border-radius: 5px; font-weight: bold;">
                        <?php echo get_phrase('Payment Confirmed'); ?>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="receipt-footer" style="text-align: center; border-top: 2px solid #333; padding-top: 20px; color: #666; font-size: 12px;">
                <p style="margin: 5px 0;">
                    <?php echo get_phrase('This is a computer generated receipt. No signature required.'); ?>
                </p>
                <p style="margin: 5px 0;">
                    <?php echo get_phrase('Receipt Generated:'); ?> <?php echo date('d M Y h:i A'); ?>
                </p>
                <p style="margin: 5px 0;">
                    <?php echo $setting['school_name']; ?> © <?php echo date('Y'); ?>
                </p>
            </div>

        </div>

        <!-- Print and Back Buttons -->
        <div style="text-align: center; margin-top: 30px;">
            <button class="btn btn-primary" onclick="window.print();">
                <i class="fa fa-print"></i> <?php echo get_phrase('Print Receipt'); ?>
            </button>
            <button class="btn btn-secondary" onclick="window.history.back();">
                <i class="fa fa-arrow-left"></i> <?php echo get_phrase('Back'); ?>
            </button>
        </div>
    </div>
</div>

<style>
  /* Base (screen) */
  .receipt-container { font-family: 'Arial', sans-serif; color:#333; font-size:9pt; line-height:1.35; max-width:420px; }
  .receipt-header h2{ margin:0; font-weight:700; font-size:15pt; }
  .receipt-meta{ font-size:9pt; color:#666; }
  table{ font-size:9pt; }
  img.receipt-logo{ width:35mm !important; height:35mm !important; object-fit:contain; display:block; margin:0 auto 2mm; }

  /* Print rules for A5 portrait (half-A4) - force single page */
  @media print {
    html, body { height: 100%; margin: 0; }
    * { box-sizing: border-box; }
    /* Hide everything except the receipt */
    body * { visibility: hidden; }
    #receipt-container, #receipt-container * { visibility: visible; }

    #receipt-container {
      position: absolute;
      left: 0;
      top: 0;
      width: 148.5mm; /* A5 width */
      height: 210mm;  /* A5 height */
      margin: 0;
      padding: 4mm; /* tightened margins to fit a single page */
      box-shadow: none;
      overflow: hidden;
      font-size: 8pt;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
      page-break-inside: avoid;
      break-inside: avoid;
      max-height: calc(210mm - 8mm); /* keep within printable area */
    }

    /* Reduce spacings for print */
    #receipt-container .receipt-header { padding-bottom:2mm; margin-bottom:2mm; }
    #receipt-container .receipt-header img { width:35mm !important; height:35mm !important; margin-bottom:2mm; }
    #receipt-container .receipt-details > div, #receipt-container table { margin-bottom: 2mm; }

    .outstanding-balance-row { background-color: #f9f9f9 !important; }

    /* Footer safe zone: keep 15mm from bottom */
    .receipt-footer { position: absolute; bottom: 8mm; left: 4mm; right: 4mm; text-align:center; font-size:8pt; }

    button, .no-print { display: none !important; }

    /* Page size */
    @page { size: A5 portrait; margin: 0; }
  }
</style>


