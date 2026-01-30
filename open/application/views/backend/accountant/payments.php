<?php
/**
 * Payments - Record income and expenses
 */
?>

<!-- Row -->
<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <div class="panel-heading">
                <div class="d-flex align-items-center">
                    <h3 class="panel-title flex-grow-1"><?php echo get_phrase('Payments & Expenses'); ?></h3>
                    <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#addPaymentModal">
                        <i class="fa fa-plus"></i> <?php echo get_phrase('Record Payment'); ?>
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <?php if (isset($payments) && !empty($payments)): ?>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th><?php echo get_phrase('Title'); ?></th>
                            <th><?php echo get_phrase('Type'); ?></th>
                            <th><?php echo get_phrase('Amount'); ?></th>
                            <th><?php echo get_phrase('Method'); ?></th>
                            <th><?php echo get_phrase('Status'); ?></th>
                            <th><?php echo get_phrase('Date'); ?></th>
                            <th><?php echo get_phrase('Actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($payments as $payment): ?>
                        <tr>
                            <td><?php echo isset($payment['title']) ? $payment['title'] : '-'; ?></td>
                            <td>
                                <span class="badge" style="background-color: <?php echo ($payment['payment_type'] == 'income') ? '#28a745' : '#dc3545'; ?>">
                                    <?php echo $payment['payment_type']; ?>
                                </span>
                            </td>
                            <td><?php echo get_currency_symbol() . ' ' . number_format($payment['amount'], 2); ?></td>
                            <td><?php echo isset($payment['method']) ? $payment['method'] : '-'; ?></td>
                            <td>
                                <?php
                                    $status = isset($daily_fee_statuses[$payment['payment_id']]) ? $daily_fee_statuses[$payment['payment_id']] : null;
                                    if ($status === 'paid') {
                                        echo '<span class="badge badge-success"><i class="fa fa-check"></i> ' . get_phrase('Paid') . '</span>';
                                    } elseif ($status === 'unpaid') {
                                        echo '<span class="badge badge-danger"><i class="fa fa-times"></i> ' . get_phrase('Unpaid') . '</span>';
                                    } else {
                                        echo '<span class="badge badge-secondary">' . get_phrase('N/A') . '</span>';
                                    }
                                ?>
                            </td>
                            <td><?php echo date('Y-m-d', $payment['timestamp']); ?></td>
                            <td>
                                <a href="<?php echo base_url('accountant/receipt/' . $payment['payment_id']); ?>" class="btn btn-xs btn-info" target="_blank" title="<?php echo get_phrase('View Receipt'); ?>">
                                    <i class="fa fa-receipt"></i> <?php echo get_phrase('Receipt'); ?>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p class="text-center text-muted"><?php echo get_phrase('No payments recorded'); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Add Payment Modal -->
<div class="modal fade" id="addPaymentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo get_phrase('Record Payment'); ?></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label><?php echo get_phrase('Payment Type'); ?> *</label>
                        <select name="payment_type" class="form-control" required onchange="toggleStudentInvoice(this.value)">
                            <option value="">-- Select Type --</option>
                            <option value="income"><?php echo get_phrase('Income (Student Payment)'); ?></option>
                            <option value="expense"><?php echo get_phrase('Expense (School Expense)'); ?></option>
                        </select>
                    </div>

                    <div class="form-group" id="studentGroup">
                        <label id="studentLabel"><?php echo get_phrase('Student'); ?></label>
                        <select name="student_id" class="form-control" id="studentSelect" onchange="loadStudentClassAndFees(this.value)">
                            <option value="">-- Select Student --</option>
                            <?php if (isset($students)): ?>
                                <?php foreach ($students as $student): ?>
                                <option value="<?php echo $student['student_id']; ?>"><?php echo $student['student_name']; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="form-group" id="feeTypeGroup" style="display:none;">
                        <label><?php echo get_phrase('Fee Type'); ?></label>
                        <select name="fee_type_id" class="form-control" id="feeTypeSelect" onchange="updateAmountFromFee()">
                            <option value="">-- Select Fee Type --</option>
                            <?php if (isset($fee_types)): ?>
                                <?php foreach ($fee_types as $fee): ?>
                                <option value="<?php echo $fee['fee_type_id']; ?>" data-amount="<?php echo $fee['amount']; ?>"><?php echo $fee['name']; ?> (<?php echo get_currency_symbol(); ?> <?php echo number_format($fee['amount'], 2); ?>)</option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="form-group" id="invoiceGroup" style="display:none;">
                        <label><?php echo get_phrase('Invoice (Optional)'); ?></label>
                        <select name="invoice_id" class="form-control">
                            <option value="">-- Select Invoice --</option>
                            <?php if (isset($unpaid_invoices)): ?>
                                <?php foreach ($unpaid_invoices as $invoice): ?>
                                <option value="<?php echo $invoice['invoice_id']; ?>"><?php echo $invoice['invoice_number']; ?> - <?php echo $invoice['title']; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><?php echo get_phrase('Title'); ?> *</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label><?php echo get_phrase('Amount'); ?> *</label>
                        <input type="number" name="amount" class="form-control" step="0.01" id="amountInput" placeholder="Auto-filled when fee type selected" required>
                    </div>
                    <div class="form-group">
                        <label><?php echo get_phrase('Payment Method'); ?></label>
                        <select name="method" class="form-control">
                            <option value="1">Cash</option>
                            <option value="2">Check</option>
                            <option value="3">Bank Transfer</option>
                            <option value="4">Credit Card</option>
                            <option value="5">Mobile Money</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><?php echo get_phrase('Description'); ?></label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo get_phrase('Close'); ?></button>
                    <button type="submit" name="add_payment" value="1" class="btn btn-primary"><?php echo get_phrase('Record Payment'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Ensure form fields in modal are editable when modal opens
$(document).on('show.bs.modal', '#addPaymentModal', function() {
    // Remove readonly and disabled attributes from all form inputs
    $(this).find('input, textarea, select').each(function() {
        $(this).removeAttr('readonly').prop('disabled', false);
    });
});

function toggleStudentInvoice(type) {
    var invoiceGroup = document.getElementById('invoiceGroup');
    var studentGroup = document.getElementById('studentGroup');
    var feeTypeGroup = document.getElementById('feeTypeGroup');
    var studentSelect = document.getElementById('studentSelect');
    var studentLabel = document.getElementById('studentLabel');
    
    if (type === 'income') {
        studentGroup.style.display = 'block';
        invoiceGroup.style.display = 'block';
        feeTypeGroup.style.display = 'block';
        studentSelect.required = true;
        studentLabel.innerHTML = '<?php echo get_phrase('Student'); ?> *';
    } else if (type === 'expense') {
        studentGroup.style.display = 'block';
        invoiceGroup.style.display = 'none';
        feeTypeGroup.style.display = 'none';
        studentSelect.required = false;
        studentLabel.innerHTML = '<?php echo get_phrase('Student (Optional)'); ?>';
    } else {
        studentGroup.style.display = 'block';
        invoiceGroup.style.display = 'none';
        feeTypeGroup.style.display = 'none';
        studentSelect.required = false;
        studentLabel.innerHTML = '<?php echo get_phrase('Student'); ?>';
    }
}

function loadStudentClassAndFees(studentId) {
    var feeTypeGroup = document.getElementById('feeTypeGroup');
    var feeTypeSelect = document.getElementById('feeTypeSelect');
    var amountInput = document.querySelector('input[name="amount"]');
    
    if (!studentId) {
        feeTypeGroup.style.display = 'none';
        feeTypeSelect.innerHTML = '<option value="">-- Select Fee Type --</option>';
        amountInput.value = '';
        return;
    }
    
    // Fetch class fees for this student
    $.ajax({
        url: '<?php echo site_url('Accountant/get_student_class_fees'); ?>',
        type: 'POST',
        data: { student_id: studentId },
        dataType: 'json',
        success: function(response) {
            if (response.success && response.fees.length > 0) {
                feeTypeGroup.style.display = 'block';
                var options = '<option value="">-- Select Fee Type --</option>';
                $.each(response.fees, function(index, fee) {
                    options += '<option value="' + fee.fee_type_id + '" data-amount="' + fee.amount + '">' 
                        + fee.name + ' (<?php echo get_currency_symbol(); ?> ' + parseFloat(fee.amount).toFixed(2) + ')</option>';
                });
                feeTypeSelect.innerHTML = options;
                amountInput.value = '';
            } else {
                feeTypeGroup.style.display = 'none';
                feeTypeSelect.innerHTML = '<option value="">-- No fees configured --</option>';
                amountInput.value = '';
            }
        },
        error: function() {
            console.log('Error loading fees');
            feeTypeGroup.style.display = 'none';
            amountInput.value = '';
        }
    });
}

function updateAmountFromFee() {
    var feeTypeSelect = document.getElementById('feeTypeSelect');
    var amountInput = document.querySelector('input[name="amount"]');
    var selectedOption = feeTypeSelect.options[feeTypeSelect.selectedIndex];
    
    // Ensure the amount field is not readonly
    amountInput.removeAttribute('readonly');
    amountInput.disabled = false;
    
    if (selectedOption.value) {
        amountInput.value = selectedOption.getAttribute('data-amount');
    } else {
        amountInput.value = '';
    }
}
</script>
