<?php
// Daily Fee Report View
?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-chart-bar"></i> Daily Fee Report</h4>
                </div>
                <div class="card-body">
                    <!-- Date Range Filter -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label for="startDate" class="form-label fw-semibold">From Date</label>
                            <input type="date" id="startDate" class="form-control" value="<?php echo $start_date; ?>">
                        </div>
                        <div class="col-md-3">
                            <label for="endDate" class="form-label fw-semibold">To Date</label>
                            <input type="date" id="endDate" class="form-control" value="<?php echo $end_date; ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">&nbsp;</label>
                            <button id="filterBtn" class="btn btn-primary w-100">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">&nbsp;</label>
                            <button id="printBtn" class="btn btn-secondary w-100">
                                <i class="fas fa-print"></i> Print
                            </button>
                        </div>
                    </div>

                    <!-- Summary Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                    <h6 class="text-muted small mb-1"><i class="fas fa-list"></i> Total Records</h6>
                                    <h3 class="mb-0"><?php echo $summary['total_records']; ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                    <h6 class="text-muted small mb-1"><i class="fas fa-money-bill-alt"></i> Total Amount</h6>
                                    <h3 class="mb-0">₵<?php echo number_format($summary['total_amount'], 2); ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                    <h6 class="text-muted small mb-1"><i class="fas fa-check-circle text-success"></i> Paid</h6>
                                    <h3 class="mb-0 text-success"><?php echo $summary['paid']; ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                    <h6 class="text-muted small mb-1"><i class="fas fa-hourglass-end text-warning"></i> Unpaid</h6>
                                    <h3 class="mb-0 text-warning"><?php echo $summary['unpaid']; ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fees Table -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="feesTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Student</th>
                                    <th>Class</th>
                                    <th>Fee Type</th>
                                    <th>Amount (₵)</th>
                                    <th>Status</th>
                                    <th>Paid By</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($fees)): ?>
                                    <?php foreach ($fees as $fee): ?>
                                        <tr>
                                            <td>
                                                <small><?php echo date('M d, Y', strtotime($fee->fee_date)); ?></small>
                                            </td>
                                            <td>
                                                <strong><?php echo isset($fee->student_name) ? $fee->student_name : 'N/A'; ?></strong>
                                            </td>
                                            <td>
                                                <small><?php echo isset($fee->class_name) ? $fee->class_name : 'N/A'; ?></small>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <?php 
                                                    echo $fee->fee_type_id == 1 ? 'Tuition' : ($fee->fee_type_id == 2 ? 'Daily Fee' : 'Other'); 
                                                    ?>
                                                </span>
                                            </td>
                                            <td>
                                                <strong><?php echo number_format($fee->amount, 2); ?></strong>
                                            </td>
                                            <td>
                                                <?php if ($fee->payment_status === 'paid'): ?>
                                                    <span class="badge bg-success"><i class="fas fa-check"></i> Paid</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning"><i class="fas fa-clock"></i> Unpaid</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <small><?php echo isset($fee->paid_by_admin_id) ? 'Admin ID: ' . $fee->paid_by_admin_id : '-'; ?></small>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-primary" data-fee-id="<?php echo $fee->daily_fee_id; ?>" onclick="editFee(this)">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger" data-fee-id="<?php echo $fee->daily_fee_id; ?>" onclick="deleteFee(this)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">
                                            <i class="fas fa-inbox"></i> No fees recorded for this period
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Class Summary -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="fas fa-chalkboard"></i> Summary by Class</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Class</th>
                                    <th>Total Records</th>
                                    <th>Total Amount (₵)</th>
                                    <th>Paid %</th>
                                </tr>
                            </thead>
                            <tbody id="classSummary">
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">
                                        <small>Class summary will be calculated</small>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('filterBtn').addEventListener('click', function() {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    
    if (!startDate || !endDate) {
        alert('Please select both dates');
        return;
    }

    window.location.href = `<?php echo base_url('dailyfee/get_fees_report/'); ?>${startDate}/${endDate}`;
});

document.getElementById('printBtn').addEventListener('click', function() {
    window.print();
});

function editFee(btn) {
    alert('Edit functionality coming soon');
}

function deleteFee(btn) {
    if (confirm('Are you sure you want to delete this record?')) {
        const feeId = btn.dataset.feeId;
        // Send delete request
        alert('Delete functionality coming soon');
    }
}
</script>

<style>
@media print {
    .btn-group, #filterBtn, #printBtn {
        display: none;
    }
    
    .table {
        font-size: 0.9em;
    }
}
</style>
