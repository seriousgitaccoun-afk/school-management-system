<?php
/**
 * Tuition Fee Payment - Record and track tuition fee payments
 */
?>

<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <div class="panel-heading">
                <div class="d-flex align-items-center">
                    <h3 class="panel-title flex-grow-1"><?php echo get_phrase('Tuition Fee Payments'); ?></h3>
                    <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#recordTuitionModal">
                        <i class="fa fa-plus"></i> <?php echo get_phrase('Record Payment'); ?>
                    </button>
                </div>
            </div>

            <!-- Filters -->
            <div class="row mb-3">
                <div class="col-md-3">
                    <label><?php echo get_phrase('Filter by Class'); ?></label>
                    <select id="filterClass" class="form-control" onchange="filterTable()">
                        <option value="">-- All Classes --</option>
                        <?php if (isset($classes)): ?>
                            <?php foreach ($classes as $class): ?>
                            <option value="<?php echo $class['class_id']; ?>"><?php echo $class['name']; ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label><?php echo get_phrase('Filter by Status'); ?></label>
                    <select id="filterStatus" class="form-control" onchange="filterTable()">
                        <option value="">-- All Status --</option>
                        <option value="paid"><?php echo get_phrase('Paid'); ?></option>
                        <option value="partial"><?php echo get_phrase('Partial'); ?></option>
                        <option value="unpaid"><?php echo get_phrase('Unpaid'); ?></option>
                    </select>
                </div>
            </div>

            <!-- Payment Records Table -->
            <div class="table-responsive">
                <?php if (isset($tuition_records) && !empty($tuition_records)): ?>
                <table class="table table-striped table-bordered" id="tuitionTable">
                    <thead>
                        <tr>
                            <th><?php echo get_phrase('Student Name'); ?></th>
                            <th><?php echo get_phrase('Class'); ?></th>
                            <th><?php echo get_phrase('Tuition Amount'); ?></th>
                            <th><?php echo get_phrase('Amount Paid'); ?></th>
                            <th><?php echo get_phrase('Outstanding'); ?></th>
                            <th><?php echo get_phrase('Status'); ?></th>
                            <th><?php echo get_phrase('Actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tuition_records as $record): 
                            $outstanding = $record['tuition_amount'] - $record['amount_paid'];
                            $status = $record['payment_status'];
                        ?>
                        <tr data-class="<?php echo $record['class_id']; ?>" data-status="<?php echo $status; ?>">
                            <td><strong><?php echo $record['student_name']; ?></strong></td>
                            <td><?php echo $record['class_name']; ?></td>
                            <td><?php echo get_currency_symbol() . ' ' . number_format($record['tuition_amount'], 2); ?></td>
                            <td><?php echo get_currency_symbol() . ' ' . number_format($record['amount_paid'], 2); ?></td>
                            <td><?php echo get_currency_symbol() . ' ' . number_format(max(0, $outstanding), 2); ?></td>
                            <td>
                                <?php if ($status == 'paid'): ?>
                                    <span class="badge badge-success"><i class="fa fa-check"></i> <?php echo get_phrase('Paid'); ?></span>
                                <?php elseif ($status == 'partial'): ?>
                                    <span class="badge badge-warning"><i class="fa fa-exclamation"></i> <?php echo get_phrase('Partial'); ?></span>
                                <?php else: ?>
                                    <span class="badge badge-danger"><i class="fa fa-times"></i> <?php echo get_phrase('Unpaid'); ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#recordTuitionModal" onclick="selectStudentForPayment(<?php echo $record['student_id']; ?>, '<?php echo $record['student_name']; ?>', <?php echo max(0, $outstanding); ?>)">
                                    <i class="fa fa-money"></i> <?php echo get_phrase('Pay'); ?>
                                </button>
                                <a href="<?php echo base_url('accountant/tuition_receipt/' . $record['student_id']); ?>" class="btn btn-xs btn-info" target="_blank">
                                    <i class="fa fa-receipt"></i> <?php echo get_phrase('Receipt'); ?>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p class="text-center text-muted"><?php echo get_phrase('No tuition records found'); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Record Tuition Payment Modal -->
<div class="modal fade" id="recordTuitionModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo get_phrase('Record Tuition Payment'); ?></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="POST" action="<?php echo base_url('accountant/record_tuition_payment'); ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label><?php echo get_phrase('Student'); ?> *</label>
                        <input type="text" id="studentSearchInput" class="form-control mb-2" placeholder="<?php echo get_phrase('Search student...'); ?>" onkeyup="filterStudents()">
                        <select name="student_id" id="tuitionStudentSelect" class="form-control" required onchange="loadStudentTuitionInfo()">
                            <option value="">-- <?php echo get_phrase('Select Student'); ?> --</option>
                        <?php if (isset($students)): ?>
                                <?php foreach ($students as $student): ?>
                                <option value="<?php echo $student['student_id']; ?>" data-student-name="<?php echo strtolower($student['name']); ?>"><?php echo $student['name']; ?></option>
                                <?php endforeach; ?>
                        <?php endif; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><?php echo get_phrase('Tuition Amount'); ?></label>
                        <input type="text" id="tuitionAmount" class="form-control" readonly style="background-color: #f5f5f5; cursor: not-allowed;">
                    </div>

                    <div class="form-group">
                        <label><?php echo get_phrase('Previously Paid'); ?></label>
                        <input type="text" id="amountAlreadyPaid" class="form-control" readonly style="background-color: #f5f5f5; cursor: not-allowed;">
                    </div>

                    <div class="form-group">
                        <label><?php echo get_phrase('Outstanding Balance'); ?></label>
                        <input type="text" id="outstandingBalance" class="form-control" readonly style="background-color: #f5f5f5; cursor: not-allowed;">
                    </div>

                    <div class="form-group">
                        <label><?php echo get_phrase('New Payment'); ?> <span class="text-danger">*</span></label>
                        <input type="number" name="payment_amount" id="paymentAmount" class="form-control" step="0.01" min="0.01" required placeholder="0.00" style="background-color: white;" oninput="calculateNewBalance()">
                    </div>

                    <div class="form-group">
                        <label><?php echo get_phrase('Balance After Payment'); ?></label>
                        <input type="text" id="newOutstandingBalance" class="form-control" readonly style="background-color: #e8f5e9; cursor: not-allowed; font-weight: bold; color: #2e7d32;">
                    </div>

                    <div class="form-group">
                        <label><?php echo get_phrase('Payment Method'); ?> *</label>
                        <select name="payment_method" class="form-control" required>
                            <option value="">-- <?php echo get_phrase('Select Method'); ?> --</option>
                            <option value="cash"><?php echo get_phrase('Cash'); ?></option>
                            <option value="check"><?php echo get_phrase('Check'); ?></option>
                            <option value="bank"><?php echo get_phrase('Bank Transfer'); ?></option>
                            <option value="card"><?php echo get_phrase('Card'); ?></option>
                            <option value="mobile"><?php echo get_phrase('Mobile Money'); ?></option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><?php echo get_phrase('Notes'); ?></label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Optional notes"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo get_phrase('Close'); ?></button>
                    <button type="submit" class="btn btn-primary"><?php echo get_phrase('Record Payment & Generate Receipt'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Ensure form fields are properly editable when modal opens
$(document).on('show.bs.modal', '#recordTuitionModal', function() {
    // Payment Amount field must be editable
    $('#paymentAmount').removeAttr('readonly').prop('disabled', false);
    // Other fields should remain readonly (they're display-only)
    $('#tuitionAmount, #amountAlreadyPaid, #outstandingBalance').prop('readonly', true).prop('disabled', false);
});

function filterTable() {
    let classFilter = document.getElementById('filterClass').value;
    let statusFilter = document.getElementById('filterStatus').value;
    let table = document.getElementById('tuitionTable');
    let rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    
    for (let row of rows) {
        let classMatch = !classFilter || row.getAttribute('data-class') === classFilter;
        let statusMatch = !statusFilter || row.getAttribute('data-status') === statusFilter;
        row.style.display = (classMatch && statusMatch) ? '' : 'none';
    }
}

function selectStudentForPayment(studentId, studentName, outstanding) {
    document.getElementById('studentSearchInput').value = '';
    document.getElementById('tuitionStudentSelect').value = studentId;
    document.getElementById('paymentAmount').value = '';
    loadStudentTuitionInfo();
}

function filterStudents() {
    let searchInput = document.getElementById('studentSearchInput').value.toLowerCase();
    let selectElement = document.getElementById('tuitionStudentSelect');
    let options = selectElement.getElementsByTagName('option');
    let visibleCount = 0;
    let lastVisibleOption = null;
    
    for (let option of options) {
        if (option.value === '') {
            option.style.display = '';
            continue;
        }
        
        let studentName = option.getAttribute('data-student-name') || '';
        if (studentName.includes(searchInput)) {
            option.style.display = '';
            visibleCount++;
            lastVisibleOption = option;
        } else {
            option.style.display = 'none';
        }
    }
    
    // Auto-open dropdown when typing
    if (searchInput.length > 0) {
        selectElement.size = Math.min(visibleCount + 1, 5); // Show up to 5 options
    } else {
        selectElement.size = 1; // Close dropdown when search is empty
    }
    
    // Auto-select if only one match
    if (visibleCount === 1 && lastVisibleOption && searchInput.length > 0) {
        selectElement.value = lastVisibleOption.value;
        loadStudentTuitionInfo();
        selectElement.size = 1;
    }
}

function loadStudentTuitionInfo() {
    let studentId = document.getElementById('tuitionStudentSelect').value;
    
    if (!studentId) {
        document.getElementById('tuitionAmount').value = '';
        document.getElementById('amountAlreadyPaid').value = '';
        document.getElementById('outstandingBalance').value = '';
        document.getElementById('newOutstandingBalance').value = '';
        document.getElementById('paymentAmount').value = '';
        return;
    }
    
    fetch('<?php echo base_url('accountant/get_tuition_info/'); ?>' + studentId)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                let tuitionAmount = parseFloat(data.tuition_amount) || 0;
                let amountPaid = parseFloat(data.amount_paid) || 0;
                let outstanding = Math.max(0, tuitionAmount - amountPaid);
                
                document.getElementById('tuitionAmount').value = tuitionAmount.toFixed(2);
                document.getElementById('amountAlreadyPaid').value = amountPaid.toFixed(2);
                document.getElementById('outstandingBalance').value = outstanding.toFixed(2);
                document.getElementById('newOutstandingBalance').value = outstanding.toFixed(2);
                
                // Set max payment to outstanding balance
                document.getElementById('paymentAmount').max = outstanding;
                document.getElementById('paymentAmount').placeholder = '0.01 - ' + outstanding.toFixed(2);
                document.getElementById('paymentAmount').value = '';
            }
        })
        .catch(error => console.error('Error:', error));
}

function calculateNewBalance() {
    let outstandingBalance = parseFloat(document.getElementById('outstandingBalance').value) || 0;
    let paymentAmount = parseFloat(document.getElementById('paymentAmount').value) || 0;
    let newBalance = Math.max(0, outstandingBalance - paymentAmount);
    
    document.getElementById('newOutstandingBalance').value = newBalance.toFixed(2);
}
</script>
