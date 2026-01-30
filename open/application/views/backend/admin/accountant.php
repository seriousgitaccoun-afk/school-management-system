<style>
    /* Professional Accountant Management Styling */
    .accountant-page-container {
        background: #f8f9fa;
        padding: 20px 0;
    }
    
    .accountant-form-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        border: 1px solid #e4e7ea;
        margin-bottom: 30px;
    }
    
    .accountant-form-header {
        background: linear-gradient(135deg, #03a9f3 0%, #0288d1 100%);
        color: white;
        padding: 20px;
        border-radius: 8px 8px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .accountant-form-header h4 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    
    .accountant-form-header .toggle-btn {
        background: rgba(255,255,255,0.2);
        border: none;
        color: white;
        padding: 8px 12px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    
    .accountant-form-header .toggle-btn:hover {
        background: rgba(255,255,255,0.3);
    }
    
    .accountant-form-body {
        padding: 30px;
    }
    
    .accountant-form-group {
        margin-bottom: 20px;
    }
    
    .accountant-form-label {
        label {
            font-weight: 600;
            color: #2b2b2b;
            font-size: 13px;
            letter-spacing: 0.3px;
            margin-bottom: 8px;
            display: block;
        }
    }
    
    .accountant-form-input {
        input, select, textarea {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid #d9dfe4;
            border-radius: 4px;
            font-size: 13px;
            transition: all 0.3s ease;
            font-family: Poppins, sans-serif;
            background-color: white;
            
            &:focus {
                border-color: #03a9f3;
                box-shadow: 0 0 0 3px rgba(3, 169, 243, 0.1);
                outline: none;
            }
        }
        
        select {
            cursor: pointer;
        }
        
        textarea {
            resize: vertical;
            min-height: 80px;
        }
    }
    
    .accountant-section-header {
        background: #f5f7fa;
        border-left: 4px solid #03a9f3;
        padding: 12px 16px;
        margin: 25px 0 15px 0;
        border-radius: 2px;
        font-weight: 600;
        color: #0288d1;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .accountant-form-button {
        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #03a9f3 0%, #0288d1 100%);
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
            
            &:hover {
                box-shadow: 0 4px 12px rgba(3, 169, 243, 0.3);
                transform: translateY(-1px);
            }
            
            &:active {
                transform: translateY(0);
            }
        }
    }
    
    .accountant-list-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        border: 1px solid #e4e7ea;
    }
    
    .accountant-list-header {
        background: linear-gradient(135deg, #03a9f3 0%, #0288d1 100%);
        color: white;
        padding: 20px;
        border-radius: 8px 8px 0 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .accountant-list-header h4 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    
    .accountant-list-body {
        padding: 20px;
        overflow-x: auto;
    }
    
    .accountant-table {
        width: 100%;
        border-collapse: collapse;
        
        thead {
            tr {
                background: #f0f4f8;
                border-bottom: 2px solid #e4e7ea;
                
                th {
                    padding: 14px;
                    text-align: left;
                    font-weight: 600;
                    color: #2b2b2b;
                    font-size: 12px;
                    letter-spacing: 0.4px;
                    text-transform: uppercase;
                }
            }
        }
        
        tbody {
            tr {
                border-bottom: 1px solid #e4e7ea;
                transition: all 0.2s ease;
                
                &:hover {
                    background: #f8f9fb;
                }
                
                td {
                    padding: 14px;
                    font-size: 13px;
                    color: #686868;
                    vertical-align: middle;
                }
            }
        }
    }
    
    .accountant-action-btn {
        display: inline-flex;
        gap: 6px;
        
        .btn-edit, .btn-delete, .btn-download {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            font-size: 12px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            
            i {
                font-size: 13px;
            }
        }
        
        .btn-edit {
            background: #03a9f3;
            color: white;
            
            &:hover {
                background: #0288d1;
                box-shadow: 0 2px 8px rgba(3, 169, 243, 0.3);
            }
        }
        
        .btn-delete {
            background: #f44236;
            color: white;
            
            &:hover {
                background: #e53935;
                box-shadow: 0 2px 8px rgba(244, 66, 54, 0.3);
            }
        }
        
        .btn-download {
            background: #ff9800;
            color: white;
            
            &:hover {
                background: #f57c00;
                box-shadow: 0 2px 8px rgba(255, 152, 0, 0.3);
            }
        }
    }
    
    .accountant-status-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 3px;
        font-size: 11px;
        font-weight: 600;
        
        &.active {
            background: #c8e6c9;
            color: #00600d;
        }
        
        &.inactive {
            background: #ffcdd2;
            color: #b71c1c;
        }
    }
    
    .accountant-empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #a8adb5;
        
        i {
            font-size: 48px;
            margin-bottom: 15px;
            opacity: 0.5;
        }
        
        p {
            font-size: 14px;
            margin: 0;
        }
    }
    
    .password-strength {
        font-size: 12px;
        margin-top: 5px;
        
        &.weak {
            color: #f44236;
        }
        
        &.fair {
            color: #ff9800;
        }
        
        &.good {
            color: #00c292;
        }
        
        &.strong {
            color: #0288d1;
        }
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .accountant-form-body {
            padding: 20px;
        }
        
        .accountant-list-body {
            padding: 15px;
        }
        
        .accountant-table {
            thead tr th,
            tbody tr td {
                padding: 10px;
                font-size: 12px;
            }
        }
    }
</style>

<div class="accountant-page-container">
    <!-- ADD NEW ACCOUNTANT FORM -->
    <div class="row">
        <div class="col-sm-12">
            <div class="accountant-form-card">
                <div class="accountant-form-header">
                    <h4><i class="fa fa-plus" style="margin-right: 10px;"></i>Add New Accountant</h4>
                    <button type="button" class="toggle-btn" id="accountantToggleBtn" onclick="toggleAccountantForm()">
                        <i class="fa fa-chevron-down"></i> Collapse
                    </button>
                </div>
                <div class="accountant-form-body" id="accountantFormBody" style="display: block;">
                    <?php echo form_open(base_url() . 'admin/accountant/insert/', array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data'));?>
                    
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <!-- Name -->
                            <div class="accountant-form-group accountant-form-label">
                                <label><?php echo get_phrase('name');?> <span style="color: #f44236;">*</span></label>
                                <div class="accountant-form-input">
                                    <input type="text" name="name" class="form-control" placeholder="Accountant's full name" required>
                                </div>
                            </div>
                            
                            <!-- Accountant Number (Hidden) -->
                            <div class="accountant-form-input" style="display: none;">
                                <input type="text" class="form-control" value="<?php echo substr(md5(uniqid(rand(), true)), 0, 7); ?>" name="accountant_number" readonly>
                            </div>
                            
                            <!-- Address -->
                            <div class="accountant-form-group accountant-form-label">
                                <label><?php echo get_phrase('address');?> <span style="color: #f44236;">*</span></label>
                                <div class="accountant-form-input">
                                    <input type="text" name="address" class="form-control" placeholder="Home address" required>
                                </div>
                            </div>
                            
                            <!-- Phone -->
                            <div class="accountant-form-group accountant-form-label">
                                <label><?php echo get_phrase('phone');?> <span style="color: #f44236;">*</span></label>
                                <div class="accountant-form-input">
                                    <input type="text" name="phone" class="form-control" placeholder="Phone number" required>
                                </div>
                            </div>
                            
                            <!-- Email -->
                            <div class="accountant-form-group accountant-form-label">
                                <label><?php echo get_phrase('email');?></label>
                                <div class="accountant-form-input">
                                    <input type="email" name="email" class="form-control" placeholder="accountant@school.com">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right Column -->
                        <div class="col-md-6">
                            <!-- Password -->
                            <div class="accountant-form-group accountant-form-label">
                                <label><?php echo get_phrase('password');?> <span style="color: #f44236;">*</span></label>
                                <div class="accountant-form-input">
                                    <input type="password" name="password" class="form-control" placeholder="Secure password" onkeyup="CheckPasswordStrength(this.value)" required>
                                </div>
                                <div id="password_strength" class="password-strength"></div>
                            </div>
                            
                            <!-- Profile Image -->
                            <div class="accountant-form-group accountant-form-label">
                                <label><?php echo get_phrase('browse_image');?></label>
                                <div class="accountant-form-input">
                                    <input type="file" name="userfile" class="dropify" onChange="readURL(this);">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- HR Information Section -->
                    <div class="accountant-section-header">
                        <i class="fa fa-briefcase" style="margin-right: 8px;"></i> Human Resources Information
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Designation -->
                            <div class="accountant-form-group accountant-form-label">
                                <label><?php echo get_phrase('designation');?></label>
                                <div class="accountant-form-input">
                                    <select name="designation_id" class="form-control" id="designation_holder">
                                        <option value="">-- Optional --</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Date of Joining -->
                            <div class="accountant-form-group accountant-form-label">
                                <label><?php echo get_phrase('date_of_joining');?></label>
                                <div class="accountant-form-input">
                                    <input type="date" name="date_of_joining" class="form-control datepicker" value="<?php echo date('Y-m-d');?>">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <!-- Joining Salary -->
                            <div class="accountant-form-group accountant-form-label">
                                <label><?php echo get_phrase('joining_salary');?></label>
                                <div class="accountant-form-input">
                                    <input type="number" name="joining_salary" class="form-control" placeholder="Salary amount">
                                </div>
                            </div>
                            
                            <!-- Status -->
                            <div class="accountant-form-group accountant-form-label">
                                <label><?php echo get_phrase('status');?></label>
                                <div class="accountant-form-input">
                                    <select name="status" class="form-control">
                                        <option value="1"><?php echo get_phrase('active'); ?></option>
                                        <option value="2"><?php echo get_phrase('inactive'); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="accountant-form-button" style="margin-top: 30px;">
                        <button type="submit"><i class="fa fa-check"></i>&nbsp; Add Accountant</button>
                    </div>
                    
                    <?php echo form_close();?>
                </div>
            </div>
        </div>
    </div>

    <!-- ACCOUNTANTS LIST TABLE -->
    <div class="row">
        <div class="col-sm-12">
            <div class="accountant-list-card">
                <div class="accountant-list-header">
                    <i class="fa fa-users"></i>
                    <h4><?php echo get_phrase('Accountants List');?></h4>
                </div>
                <div class="accountant-list-body">
                    <?php if(!empty($select_accountant)): ?>
                        <table class="accountant-table">
                            <thead>
                                <tr>
                                    <th width="8%">Avatar</th>
                                    <th width="18%"><?php echo get_phrase('name');?></th>
                                    <th width="20%"><?php echo get_phrase('email');?></th>
                                    <th width="12%"><?php echo get_phrase('phone');?></th>
                                    <th width="22%"><?php echo get_phrase('address');?></th>
                                    <th width="20%"><?php echo get_phrase('options');?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($select_accountant as $key => $accountant): ?>
                                <tr>
                                    <td style="text-align: center;">
                                        <?php echo get_avatar_badge($accountant['name'], 35); ?>
                                    </td>
                                    <td><strong><?php echo $accountant['name'];?></strong></td>
                                    <td><?php echo $accountant['email'];?></td>
                                    <td><?php echo $accountant['phone'];?></td>
                                    <td><?php echo substr($accountant['address'], 0, 30) . (strlen($accountant['address']) > 30 ? '...' : ''); ?></td>
                                    <td>
                                        <div class="accountant-action-btn">
                                            <button class="btn-edit" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/edit_accountant/<?php echo $accountant['accountant_id'];?>')">
                                                <i class="fa fa-edit"></i> Edit
                                            </button>
                                            <button class="btn-delete" onclick="return confirm('Are you sure you want to delete this accountant?') ? window.location.href='<?php echo base_url();?>admin/accountant/delete/<?php echo $accountant['accountant_id'];?>' : false;">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                            <a href="<?php echo base_url().'uploads/accountant_image/'.  $accountant['file_name'];?>" class="btn-download">
                                                <i class="fa fa-download"></i> Download
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="accountant-empty-state">
                            <i class="fa fa-inbox"></i>
                            <p>No accountants found. Start by adding a new accountant using the form above.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle Accountant Form Expand/Collapse
    function toggleAccountantForm() {
        const formBody = document.getElementById('accountantFormBody');
        const toggleBtn = document.getElementById('accountantToggleBtn');
        
        if (formBody.style.display === 'none') {
            // Show form
            formBody.style.display = 'block';
            toggleBtn.innerHTML = '<i class="fa fa-chevron-down"></i> Collapse';
        } else {
            // Hide form
            formBody.style.display = 'none';
            toggleBtn.innerHTML = '<i class="fa fa-chevron-right"></i> Expand';
        }
    }
</script>
