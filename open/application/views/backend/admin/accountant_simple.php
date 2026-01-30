<?php
// Simplified Accountant Form - Only Essential Fields
?>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4><?php echo get_phrase('new_accountant');?></h4>
                <div class="pull-right">
                    <a href="#" data-perform="panel-collapse"><i class="fa fa-minus"></i> COLLAPSE</a>
                </div>
            </div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    
                    <?php echo form_open(base_url() . 'admin/accountant/insert/', array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            
                            <!-- NAME -->
                            <div class="form-group">
                                <label class="col-md-3"><strong><?php echo get_phrase('name');?> *</strong></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name" placeholder="Full Name" required>
                                    <input type="hidden" value="<?php echo substr(md5(uniqid(rand(), true)), 0, 7); ?>" name="accountant_number">
                                </div>
                            </div>

                            <!-- EMAIL -->
                            <div class="form-group">
                                <label class="col-md-3"><strong><?php echo get_phrase('email');?> *</strong></label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" name="email" placeholder="accountant@school.com" required>
                                </div>
                            </div>

                            <!-- PHONE -->
                            <div class="form-group">
                                <label class="col-md-3"><strong><?php echo get_phrase('phone');?> *</strong></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="phone" placeholder="+1234567890" required>
                                </div>
                            </div>

                            <!-- ADDRESS -->
                            <div class="form-group">
                                <label class="col-md-3"><strong><?php echo get_phrase('address');?> *</strong></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="address" placeholder="Street Address" required>
                                </div>
                            </div>


                            <!-- DESIGNATION -->
                            <div class="form-group">
                                <label class="col-md-3"><strong><?php echo get_phrase('designation');?> *</strong></label>
                                <div class="col-sm-9">
                                    <select name="designation_id" class="form-control select2" id="designation_holder" required>
                                        <option value="">-- Select Designation --</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="col-sm-6">

                            <!-- PASSWORD -->
                            <div class="form-group">
                                <label class="col-md-3"><strong><?php echo get_phrase('password');?> *</strong></label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" name="password" placeholder="Enter password" onkeyup="CheckPasswordStrength(this.value)" required>
                                    <small id="password_strength" style="display: block; margin-top: 5px;"></small>
                                </div>
                            </div>

                            <!-- PROFILE IMAGE -->
                            <div class="form-group">
                                <label class="col-md-3"><strong><?php echo get_phrase('profile_image');?></strong></label>
                                <div class="col-sm-9">
                                    <input type='file' name="userfile" class="dropify" onChange="readURL(this);" accept="image/*" />
                                </div>
                            </div>

                            <!-- STATUS -->
                            <div class="form-group">
                                <label class="col-md-3"><strong><?php echo get_phrase('status');?> *</strong></label>
                                <div class="col-sm-9">
                                    <select name="status" class="form-control select2" required>
                                        <option value="1"><?php echo get_phrase('active'); ?></option>
                                        <option value="2"><?php echo get_phrase('inactive'); ?></option>
                                    </select>
                                </div>
                            </div>

                            <!-- DATE OF JOINING -->
                            <div class="form-group">
                                <label class="col-md-3"><strong><?php echo get_phrase('date_of_joining');?> *</strong></label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" name="date_of_joining" value="<?php echo date('Y-m-d');?>" required>
                                </div>
                            </div>

                            <!-- JOINING SALARY -->
                            <div class="form-group">
                                <label class="col-md-3"><strong><?php echo get_phrase('joining_salary');?> *</strong></label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="joining_salary" placeholder="0.00" step="0.01" min="0" required>
                                </div>
                            </div>

                            <!-- SUBMIT BUTTON -->
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-success btn-block btn-lg">
                                        <i class="fa fa-save"></i> &nbsp; CREATE ACCOUNTANT
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>

                    <?php echo form_close();?>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Existing Accountants List -->
<?php if (isset($select_accountant) && !empty($select_accountant)): ?>
<div class="row" style="margin-top: 30px;">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4><?php echo get_phrase('existing_accountants');?></h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($select_accountant as $accountant): ?>
                            <tr>
                                <td><?php echo $accountant['name']; ?></td>
                                <td><?php echo $accountant['email']; ?></td>
                                <td><?php echo $accountant['phone']; ?></td>
                                <td>
                                    <span class="label <?php echo ($accountant['status'] == 1) ? 'label-success' : 'label-danger'; ?>">
                                        <?php echo ($accountant['status'] == 1) ? 'Active' : 'Inactive'; ?>
                                    </span>
                                </td>
                                <td>
                                    <a onclick="showAjaxModal('<?php echo base_url();?>modal/popup/edit_accountant/<?php echo $accountant['accountant_id'];?>')" class="btn btn-info btn-xs"><i class="fa fa-edit"></i> Edit</a>
                                    <a href="#" onclick="confirm_modal('<?php echo base_url();?>admin/accountant/delete/<?php echo $accountant['accountant_id'];?>');" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>


