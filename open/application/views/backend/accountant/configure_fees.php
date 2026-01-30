<?php
/**
 * Configure Class Fees - Manage daily and other fees for each class
 */
?>

<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <div class="panel-heading">
                <div class="d-flex align-items-center">
                    <h3 class="panel-title flex-grow-1"><?php echo get_phrase('Configure Class Fees'); ?></h3>
                    <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#addFeeModal">
                        <i class="fa fa-plus"></i> <?php echo get_phrase('Add Fee Configuration'); ?>
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <?php if (isset($class_fees) && !empty($class_fees)): ?>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th><?php echo get_phrase('Class'); ?></th>
                            <th><?php echo get_phrase('Fee Type'); ?></th>
                            <th><?php echo get_phrase('Category'); ?></th>
                            <th><?php echo get_phrase('Amount'); ?></th>
                            <th><?php echo get_phrase('Status'); ?></th>
                            <th><?php echo get_phrase('Actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($class_fees as $fee): ?>
                        <tr>
                            <td><strong><?php echo $fee['class_name']; ?></strong></td>
                            <td><?php echo $fee['fee_name']; ?></td>
                            <td>
                                <span class="badge" style="background-color: <?php echo ($fee['category'] == 'daily') ? '#17a2b8' : (($fee['category'] == 'tuition') ? '#28a745' : '#6c757d'); ?>">
                                    <?php echo ucfirst($fee['category']); ?>
                                </span>
                            </td>
                            <td><?php echo get_currency_symbol() . ' ' . number_format($fee['amount'], 2); ?></td>
                            <td>
                                <?php if ($fee['is_active']): ?>
                                    <span class="badge badge-success"><?php echo get_phrase('Active'); ?></span>
                                <?php else: ?>
                                    <span class="badge badge-danger"><?php echo get_phrase('Inactive'); ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button class="btn btn-xs btn-primary edit-fee" data-id="<?php echo $fee['class_fee_id']; ?>" data-toggle="modal" data-target="#editFeeModal" title="<?php echo get_phrase('Edit'); ?>">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <a href="<?php echo base_url('accountant/delete_fee/' . $fee['class_fee_id']); ?>" class="btn btn-xs btn-danger" onclick="return confirm('<?php echo get_phrase('Are you sure?'); ?>');" title="<?php echo get_phrase('Delete'); ?>">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p class="text-center text-muted"><?php echo get_phrase('No fee configurations found'); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Add Fee Modal -->
<div class="modal fade" id="addFeeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo get_phrase('Add Fee Configuration'); ?></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="POST" action="<?php echo base_url('accountant/add_fee'); ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label><?php echo get_phrase('Class'); ?> *</label>
                        <select name="class_id" class="form-control" required>
                            <option value="">-- <?php echo get_phrase('Select Class'); ?> --</option>
                            <?php if (isset($classes)): ?>
                                <?php foreach ($classes as $class): ?>
                                <option value="<?php echo $class->class_id; ?>"><?php echo $class->name; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><?php echo get_phrase('Fee Type'); ?> *</label>
                        <select name="fee_type_id" class="form-control" required>
                            <option value="">-- <?php echo get_phrase('Select Fee Type'); ?> --</option>
                            <?php if (isset($fee_types)): ?>
                                <?php foreach ($fee_types as $type): ?>
                                <option value="<?php echo $type['fee_type_id']; ?>">
                                    <?php echo $type['name']; ?> (<?php echo ucfirst($type['category']); ?>)
                                </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><?php echo get_phrase('Amount'); ?> *</label>
                        <input type="number" name="amount" class="form-control" step="0.01" min="0" required placeholder="0.00">
                    </div>

                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="is_active" value="1" checked> <?php echo get_phrase('Active'); ?>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo get_phrase('Close'); ?></button>
                    <button type="submit" class="btn btn-primary"><?php echo get_phrase('Add'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Fee Modal -->
<div class="modal fade" id="editFeeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo get_phrase('Edit Fee Configuration'); ?></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="POST" action="<?php echo base_url('accountant/update_fee'); ?>">
                <div class="modal-body">
                    <input type="hidden" name="class_fee_id" id="editClassFeeId">
                    
                    <div class="form-group">
                        <label><?php echo get_phrase('Class'); ?></label>
                        <input type="text" class="form-control" id="editClassName" readonly>
                    </div>

                    <div class="form-group">
                        <label><?php echo get_phrase('Fee Type'); ?></label>
                        <input type="text" class="form-control" id="editFeeType" readonly>
                    </div>

                    <div class="form-group">
                        <label><?php echo get_phrase('Amount'); ?> *</label>
                        <input type="number" name="amount" id="editAmount" class="form-control" step="0.01" min="0" required>
                    </div>

                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="is_active" id="editIsActive" value="1"> <?php echo get_phrase('Active'); ?>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo get_phrase('Close'); ?></button>
                    <button type="submit" class="btn btn-primary"><?php echo get_phrase('Update'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.edit-fee').forEach(button => {
    button.addEventListener('click', async function() {
        let classId = this.getAttribute('data-id');
        
        // Fetch fee details via AJAX
        try {
            let res = await fetch('<?php echo base_url('accountant/get_fee_details/'); ?>' + classId);
            let data = await res.json();
            
            if (data.success) {
                document.getElementById('editClassFeeId').value = data.fee.class_fee_id;
                document.getElementById('editClassName').value = data.fee.class_name;
                document.getElementById('editFeeType').value = data.fee.fee_name;
                document.getElementById('editAmount').value = data.fee.amount;
                document.getElementById('editIsActive').checked = data.fee.is_active == 1;
            }
        } catch(e) {
            console.error('Error loading fee details', e);
        }
    });
});
</script>
