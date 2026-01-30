<?php
/**
 * Financial Dashboard - Tabbed Interface
 * Tabs: Payment History | Daily Fees | Tuition | Summary | Expenditure
 */
?>

<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo get_phrase('Financial Dashboard'); ?></h3>
            </div>

            <!-- Tabs Navigation -->
            <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 20px;">
                <li role="presentation" class="active">
                    <a href="#payment-history" aria-controls="payment-history" role="tab" data-toggle="tab">
                        <i class="fa fa-history"></i> Payment History
                    </a>
                </li>
                <li role="presentation">
                    <a href="#daily-fees" aria-controls="daily-fees" role="tab" data-toggle="tab">
                        <i class="fa fa-calendar"></i> Daily Fees
                    </a>
                </li>
                <li role="presentation">
                    <a href="#tuition-fees" aria-controls="tuition-fees" role="tab" data-toggle="tab">
                        <i class="fa fa-graduation-cap"></i> Tuition Fees
                    </a>
                </li>
                <li role="presentation">
                    <a href="#financial-summary" aria-controls="financial-summary" role="tab" data-toggle="tab">
                        <i class="fa fa-bar-chart"></i> Summary
                    </a>
                </li>
                <li role="presentation">
                    <a href="#expenditure" aria-controls="expenditure" role="tab" data-toggle="tab">
                        <i class="fa fa-money"></i> Expenditure
                    </a>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content">

                <!-- TAB 1: Payment History -->
                <div role="tabpanel" class="tab-pane active" id="payment-history">
                    <h4><?php echo get_phrase('All Payment Records'); ?></h4>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label><?php echo get_phrase('Filter by Type'); ?></label>
                            <select class="form-control" id="historyTypeFilter" onchange="filterPaymentHistory()">
                                <option value="">-- All Types --</option>
                                <option value="daily">Daily Fees</option>
                                <option value="tuition">Tuition Fees</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label><?php echo get_phrase('Filter by Date'); ?></label>
                            <input type="date" class="form-control" id="historyDateFilter" onchange="filterPaymentHistory()">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="paymentHistoryTable">
                            <thead>
                                <tr>
                                    <th><?php echo get_phrase('Date'); ?></th>
                                    <th><?php echo get_phrase('Student'); ?></th>
                                    <th><?php echo get_phrase('Class'); ?></th>
                                    <th><?php echo get_phrase('Type'); ?></th>
                                    <th><?php echo get_phrase('Amount'); ?></th>
                                    <th><?php echo get_phrase('Method'); ?></th>
                                    <th><?php echo get_phrase('Actions'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Merge and display all payments
                                $all_payments = array();
                                
                                // Add daily fees
                                if (!empty($daily_fees)) {
                                    foreach ($daily_fees as $fee) {
                                        $all_payments[] = array(
                                            'date' => $fee['fee_date'],
                                            'timestamp' => strtotime($fee['fee_date']),
                                            'student_name' => $fee['student_name'] ?? 'Unknown',
                                            'class_name' => $fee['class_name'] ?? 'Unknown',
                                            'type' => 'daily',
                                            'type_display' => 'Daily Fee',
                                            'amount' => $fee['amount'],
                                            'method' => 'N/A',
                                            'id' => $fee['daily_fee_id'],
                                            'fee_type_name' => $fee['fee_type_name'] ?? 'General',
                                            'status' => $fee['payment_status'] ?? 'paid'
                                        );
                                    }
                                }
                                
                                // Add tuition payments
                                if (!empty($tuition_payments)) {
                                    foreach ($tuition_payments as $payment) {
                                        $all_payments[] = array(
                                            'date' => $payment['payment_date'],
                                            'timestamp' => strtotime($payment['payment_date']),
                                            'student_name' => $payment['student_name'] ?? 'Unknown',
                                            'class_name' => $payment['class_name'] ?? 'Unknown',
                                            'student_id' => $payment['student_id'],
                                            'type' => 'tuition',
                                            'type_display' => 'Tuition Fee',
                                            'amount' => $payment['amount_paid'],
                                            'method' => $payment['payment_method'] ?? 'N/A',
                                            'id' => $payment['tuition_payment_id'],
                                            'receipt_no' => 'TUI-' . str_pad($payment['tuition_payment_id'], 6, '0', STR_PAD_LEFT)
                                        );
                                    }
                                }
                                
                                // Sort by date (newest first)
                                usort($all_payments, function($a, $b) {
                                    return $b['timestamp'] - $a['timestamp'];
                                });
                                
                                // Display payments
                                if (!empty($all_payments)):
                                    foreach ($all_payments as $payment):
                                ?>
                                <tr data-type="<?php echo $payment['type']; ?>" data-date="<?php echo $payment['date']; ?>">
                                    <td><?php echo date('M d, Y', $payment['timestamp']); ?></td>
                                    <td><?php echo $payment['student_name']; ?></td>
                                    <td><?php echo $payment['class_name']; ?></td>
                                    <td>
                                        <?php if ($payment['type'] === 'daily'): ?>
                                            <span class="badge" style="background-color: #17a2b8;"><?php echo $payment['type_display']; ?></span>
                                            <br><small class="text-muted"><?php echo $payment['fee_type_name']; ?></small>
                                        <?php else: ?>
                                            <span class="badge" style="background-color: #ffc107;"><?php echo $payment['type_display']; ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td><strong><?php echo get_currency_symbol() . ' ' . number_format($payment['amount'], 2); ?></strong></td>
                                    <td><?php echo $payment['method']; ?></td>
                                    <td>
                                        <?php if ($payment['type'] === 'tuition'): ?>
                                            <a href="<?php echo base_url('accountant/tuition_receipt/' . $payment['student_id'] . '/' . $payment['id']); ?>" class="btn btn-xs btn-info" title="<?php echo get_phrase('View Receipt'); ?>">
                                                <i class="fa fa-file-text-o"></i> Receipt
                                            </a>
                                        <?php endif; ?>
                                        <button class="btn btn-xs btn-danger" onclick="openDeletePasswordModal('<?php echo $payment['type']; ?>', <?php echo $payment['id']; ?>)" title="<?php echo get_phrase('Delete'); ?>">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php
                                    endforeach;
                                else:
                                ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted"><?php echo get_phrase('No payment records yet'); ?></td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TAB 2: Daily Fees -->
                <div role="tabpanel" class="tab-pane" id="daily-fees">
                    <h4><?php echo get_phrase('Daily Fee Payments'); ?></h4>
                    <a href="<?php echo base_url('dailyfee'); ?>" class="btn btn-sm btn-primary mb-3">
                        <i class="fa fa-plus"></i> <?php echo get_phrase('Record Daily Fee'); ?>
                    </a>
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th><?php echo get_phrase('Date'); ?></th>
                                    <th><?php echo get_phrase('Student'); ?></th>
                                    <th><?php echo get_phrase('Class'); ?></th>
                                    <th><?php echo get_phrase('Fee Type'); ?></th>
                                    <th><?php echo get_phrase('Amount'); ?></th>
                                    <th><?php echo get_phrase('Status'); ?></th>
                                    <th><?php echo get_phrase('Actions'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($daily_fees)): ?>
                                    <?php foreach ($daily_fees as $fee): ?>
                                    <tr>
                                        <td><?php echo date('M d, Y', strtotime($fee['fee_date'])); ?></td>
                                        <td><?php echo $fee['student_name'] ?? 'Unknown'; ?></td>
                                        <td><?php echo $fee['class_name'] ?? 'Unknown'; ?></td>
                                        <td><?php echo $fee['fee_type_name'] ?? 'N/A'; ?></td>
                                        <td><?php echo get_currency_symbol() . ' ' . number_format($fee['amount'], 2); ?></td>
                                        <td>
                                            <?php if ($fee['payment_status'] == 'paid'): ?>
                                                <span class="badge" style="background-color: #28a745;"><?php echo get_phrase('Paid'); ?></span>
                                            <?php else: ?>
                                                <span class="badge" style="background-color: #ffc107;"><?php echo get_phrase('Pending'); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-xs btn-danger" onclick="openDeletePasswordModal('daily', <?php echo $fee['daily_fee_id']; ?>)" title="<?php echo get_phrase('Delete'); ?>">
                                                <i class="fa fa-trash"></i> <?php echo get_phrase('Delete'); ?>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted"><?php echo get_phrase('No daily fee records yet'); ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TAB 3: Tuition Fees -->
                <div role="tabpanel" class="tab-pane" id="tuition-fees">
                    <h4><?php echo get_phrase('Tuition Fee Payments'); ?></h4>
                    <a href="<?php echo base_url('accountant/tuition_payment'); ?>" class="btn btn-sm btn-primary mb-3">
                        <i class="fa fa-plus"></i> <?php echo get_phrase('Record Tuition Payment'); ?>
                    </a>
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th><?php echo get_phrase('Date'); ?></th>
                                    <th><?php echo get_phrase('Student'); ?></th>
                                    <th><?php echo get_phrase('Class'); ?></th>
                                    <th><?php echo get_phrase('Amount'); ?></th>
                                    <th><?php echo get_phrase('Method'); ?></th>
                                    <th><?php echo get_phrase('Recorded By'); ?></th>
                                    <th><?php echo get_phrase('Actions'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($tuition_payments)): ?>
                                    <?php foreach ($tuition_payments as $payment): ?>
                                    <tr>
                                        <td><?php echo date('M d, Y', strtotime($payment['payment_date'])); ?></td>
                                        <td><?php echo $payment['student_name'] ?? 'Unknown'; ?></td>
                                        <td><?php echo $payment['class_name'] ?? 'Unknown'; ?></td>
                                        <td><?php echo get_currency_symbol() . ' ' . number_format($payment['amount_paid'], 2); ?></td>
                                        <td><?php echo ucfirst($payment['payment_method']); ?></td>
                                        <td><?php echo $payment['created_by'] ?? 'System'; ?></td>
                                        <td>
                                            <button class="btn btn-xs btn-danger" onclick="openDeletePasswordModal('tuition', <?php echo $payment['tuition_payment_id']; ?>)" title="<?php echo get_phrase('Delete'); ?>">
                                                <i class="fa fa-trash"></i> <?php echo get_phrase('Delete'); ?>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted"><?php echo get_phrase('No tuition payment records yet'); ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TAB 4: Financial Summary -->
                <div role="tabpanel" class="tab-pane" id="financial-summary">
                    <h4><?php echo get_phrase('Financial Summary'); ?></h4>
                    
                    <div class="row">
                        <div class="col-md-3">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo get_phrase('Total Daily Fees'); ?></h3>
                                </div>
                                <div class="panel-body text-center" style="font-size: 24px; font-weight: bold; color: #2196F3;">
                                    <?php 
                                    // Calculate from daily_fee_tracking if available
                                    echo get_currency_symbol() . ' 0.00';
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo get_phrase('Total Tuition Fees'); ?></h3>
                                </div>
                                <div class="panel-body text-center" style="font-size: 24px; font-weight: bold; color: #4CAF50;">
                                    <?php 
                                    // Calculate from tuition_payment table
                                    echo get_currency_symbol() . ' 0.00';
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="panel panel-warning">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo get_phrase('Total Income'); ?></h3>
                                </div>
                                <div class="panel-body text-center" style="font-size: 24px; font-weight: bold; color: #FF9800;">
                                    <?php 
                                    // Daily + Tuition
                                    echo get_currency_symbol() . ' 0.00';
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="panel panel-danger">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo get_phrase('Total Expenditure'); ?></h3>
                                </div>
                                <div class="panel-body text-center" style="font-size: 24px; font-weight: bold; color: #F44336;">
                                    <?php 
                                    // From expenditure/payment table
                                    echo get_currency_symbol() . ' 0.00';
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Summary by Category</h3>
                                </div>
                                <div class="panel-body">
                                    <p class="text-muted">Chart and detailed breakdown would appear here.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 5: School Expenditure -->
                <div role="tabpanel" class="tab-pane" id="expenditure">
                    <h4><?php echo get_phrase('School Expenditure'); ?></h4>
                    <button class="btn btn-sm btn-primary mb-3" data-toggle="modal" data-target="#addExpenditureModal">
                        <i class="fa fa-plus"></i> <?php echo get_phrase('Add Expense'); ?>
                    </button>
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th><?php echo get_phrase('Date'); ?></th>
                                    <th><?php echo get_phrase('Category'); ?></th>
                                    <th><?php echo get_phrase('Description'); ?></th>
                                    <th><?php echo get_phrase('Vendor'); ?></th>
                                    <th><?php echo get_phrase('Amount'); ?></th>
                                    <th><?php echo get_phrase('Actions'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No expenditure records yet</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Delete Password Modal -->
<div class="modal fade" id="deletePasswordModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo get_phrase('Confirm Deletion'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deletePasswordForm" method="POST">
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fa fa-exclamation-triangle"></i>
                        <?php echo get_phrase('This action cannot be undone. Enter the password to confirm deletion.'); ?>
                    </div>
                    <input type="hidden" id="deleteType" name="delete_type" value="">
                    <input type="hidden" id="deleteId" name="delete_id" value="">
                    <div class="form-group">
                        <label><?php echo get_phrase('Administrator Password'); ?></label>
                        <input type="password" id="deletePassword" name="delete_password" class="form-control" placeholder="Enter password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo get_phrase('Cancel'); ?></button>
                    <button type="submit" class="btn btn-danger"><?php echo get_phrase('Delete'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let currentDeleteType = '';
let currentDeleteId = '';

// Initialize when document is ready
$(document).ready(function() {
    // Initialize tabs - ensure they are clickable and responsive
    $('a[data-toggle="tab"]').on('click', function(e) {
        e.preventDefault();
        $(this).tab('show');
    });

    // Attach delete form submit handler
    var deleteForm = document.getElementById('deletePasswordForm');
    if (deleteForm) {
        deleteForm.addEventListener('submit', handleDeleteSubmit);
    }
});

function openDeletePasswordModal(type, id) {
    currentDeleteType = type;
    currentDeleteId = id;
    document.getElementById('deleteType').value = type;
    document.getElementById('deleteId').value = id;
    document.getElementById('deletePassword').value = '';
    $('#deletePasswordModal').modal('show');
}

function filterPaymentHistory() {
    let typeFilter = document.getElementById('historyTypeFilter').value;
    let dateFilter = document.getElementById('historyDateFilter').value;
    
    let table = document.getElementById('paymentHistoryTable');
    let rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    
    for (let i = 0; i < rows.length; i++) {
        let row = rows[i];
        let rowType = row.getAttribute('data-type');
        let rowDate = row.getAttribute('data-date');
        
        // If no payment record (empty row), skip filtering
        if (!rowType) {
            row.style.display = '';
            continue;
        }
        
        let typeMatch = !typeFilter || rowType === typeFilter;
        let dateMatch = !dateFilter || rowDate === dateFilter;
        
        row.style.display = (typeMatch && dateMatch) ? '' : 'none';
    }
}

function handleDeleteSubmit(e) {
    e.preventDefault();
    
    let type = document.getElementById('deleteType').value;
    let id = document.getElementById('deleteId').value;
    let password = document.getElementById('deletePassword').value;
    
    // Send AJAX request to verify password and delete
    $.ajax({
        url: '<?php echo base_url('accountant/delete_payment_record'); ?>',
        type: 'POST',
        data: {
            type: type,
            id: id,
            password: password
        },
        success: function(response) {
            let result = JSON.parse(response);
            if (result.success) {
                alert('<?php echo get_phrase('Record deleted successfully'); ?>');
                location.reload();
            } else {
                alert(result.message || '<?php echo get_phrase('Deletion failed'); ?>');
            }
        },
        error: function() {
            alert('<?php echo get_phrase('Error processing request'); ?>');
        }
    });
}
</script>
