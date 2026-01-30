<?php
// Class Fee Configuration View
?>

<div class="container-fluid" style="padding: 20px;">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="mb-0 text-white"><i class="fa fa-money"></i> Fee Configuration by Class</h4>
                </div>
                <div class="card-body">
                    
                    <!-- Add New Fee Section -->
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h5><i class="fa fa-plus"></i> Add New Fee Configuration</h5>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="classSelect" class="form-label"><i class="fa fa-chalkboard"></i> Class</label>
                                    <select id="classSelect" class="form-control">
                                        <option value="">-- Select Class --</option>
                                        <?php if (!empty($classes)): ?>
                                            <?php foreach ($classes as $class): ?>
                                                <option value="<?php echo $class->class_id; ?>">
                                                    <?php echo $class->name; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="feeTypeSelect" class="form-label"><i class="fa fa-receipt"></i> Fee Type</label>
                                    <select id="feeTypeSelect" class="form-control" style="height: 38px;">
                                        <option value="">-- Select Fee Type --</option>
                                        <?php if (!empty($fee_types)): ?>
                                            <?php foreach ($fee_types as $type): ?>
                                                <option value="<?php echo htmlspecialchars($type['fee_type_id']); ?>" data-category="<?php echo htmlspecialchars($type['category']); ?>">
                                                    <?php echo htmlspecialchars($type['name']); ?> (<?php echo htmlspecialchars(ucfirst($type['category'])); ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <option value="" disabled>No fee types available</option>
                                        <?php endif; ?>
                                    </select>
                                    <?php if (empty($fee_types)): ?>
                                        <small class="text-danger" style="display: block; margin-top: 5px;">
                                            <i class="fa fa-warning"></i> No fee types configured. Please create fee types first.
                                        </small>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-3">
                                    <label for="amountInput" class="form-label"><i class="fa fa-cedis"></i> Amount (₵)</label>
                                    <input type="number" id="amountInput" class="form-control" placeholder="0.00" step="0.01" min="0">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">&nbsp;</label>
                                    <button id="saveFeeBtn" class="btn btn-success w-100">
                                        <i class="fa fa-save"></i> Save Fee Configuration
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Existing Fee Configurations -->
                    <div class="row" style="margin-top: 20px;">
                        <div class="col-12">
                            <h5><i class="fa fa-list"></i> Current Fee Configurations</h5>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Class</th>
                                            <th>Fee Type</th>
                                            <th>Category</th>
                                            <th>Amount (₵)</th>
                                            <th>Active</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="feesTable">
                                        <?php if (!empty($class_fees)): ?>
                                            <?php foreach ($class_fees as $fee): ?>
                                                <tr>
                                                    <td><strong><?php echo $fee->class_name; ?></strong></td>
                                                    <td><?php echo $fee->fee_type_name; ?></td>
                                                    <td>
                                                        <span class="badge" style="background-color: <?php echo ($fee->category == 'daily') ? '#17a2b8' : (($fee->category == 'tuition') ? '#28a745' : '#6c757d'); ?>">
                                                            <?php echo ucfirst($fee->category); ?>
                                                        </span>
                                                    </td>
                                                    <td><strong>₵<?php echo number_format($fee->amount, 2); ?></strong></td>
                                                    <td>
                                                        <span class="badge <?php echo $fee->is_active ? 'badge-success' : 'badge-danger'; ?>">
                                                            <?php echo $fee->is_active ? 'Active' : 'Inactive'; ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-info" onclick="editFee(<?php echo $fee->class_fee_id; ?>, <?php echo $fee->class_id; ?>, <?php echo $fee->fee_type_id; ?>, <?php echo $fee->amount; ?>)">
                                                            <i class="fa fa-edit"></i> Edit
                                                        </button>
                                                        <button class="btn btn-sm btn-danger" onclick="deleteFee(<?php echo $fee->class_fee_id; ?>)">
                                                            <i class="fa fa-trash"></i> Delete
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center text-muted p-4">
                                                    <small>No fee configurations set yet. Add one above.</small>
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
        </div>
    </div>
</div>

<script>
let currentEditId = null;

// Debug: Log fee types on page load
document.addEventListener('DOMContentLoaded', function() {
    const feeTypeSelect = document.getElementById('feeTypeSelect');
    console.log('Fee Type Select Element:', feeTypeSelect);
    console.log('Number of options:', feeTypeSelect?.options?.length || 0);
    console.log('Options:', Array.from(feeTypeSelect?.options || []).map(o => ({value: o.value, text: o.text})));
});

document.getElementById('saveFeeBtn').addEventListener('click', async function() {
    const classId = document.getElementById('classSelect').value;
    const feeTypeId = document.getElementById('feeTypeSelect').value;
    const amount = document.getElementById('amountInput').value;

    console.log('Save clicked:', {classId, feeTypeId, amount});

    if (!classId || !feeTypeId || !amount) {
        alert('Please fill all fields');
        return;
    }

    try {
        const response = await fetch('<?php echo base_url('classfee/save_fee'); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: `class_fee_id=${currentEditId || ''}&class_id=${classId}&fee_type_id=${feeTypeId}&amount=${amount}`
        });

        const result = await response.json();
        if (result.success) {
            alert(result.message);
            location.reload();
        } else {
            alert('Error: ' + result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to save fee configuration');
    }
});

function editFee(feeId, classId, feeTypeId, amount) {
    currentEditId = feeId;
    document.getElementById('classSelect').value = classId;
    document.getElementById('feeTypeSelect').value = feeTypeId;
    document.getElementById('amountInput').value = amount;
    document.getElementById('saveFeeBtn').textContent = '✎ Update Fee Configuration';
    
    // Scroll to form
    document.querySelector('.panel-body').scrollIntoView({ behavior: 'smooth' });
}

function deleteFee(feeId) {
    if (confirm('Delete this fee configuration?')) {
        fetch('<?php echo base_url('classfee/delete_fee'); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: `class_fee_id=${feeId}`
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert('Fee configuration deleted');
                location.reload();
            } else {
                alert('Error: ' + result.message);
            }
        });
    }
}

// Reset form when class select changes
document.getElementById('classSelect').addEventListener('change', function() {
    currentEditId = null;
    document.getElementById('saveFeeBtn').textContent = '✓ Save Fee Configuration';
});
</script>
