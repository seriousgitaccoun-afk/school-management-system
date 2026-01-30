<style>
    /* Professional Teacher Management Styling */
    .teacher-page-container {
        background: #f8f9fa;
        padding: 20px 0;
    }
    
    .teacher-form-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        border: 1px solid #e4e7ea;
        margin-bottom: 30px;
    }
    
    .teacher-form-header {
        background: linear-gradient(135deg, #03a9f3 0%, #0288d1 100%);
        color: white;
        padding: 20px;
        border-radius: 8px 8px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .teacher-form-header h4 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    
    .teacher-form-header .toggle-btn {
        background: rgba(255,255,255,0.2);
        border: none;
        color: white;
        padding: 8px 12px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    
    .teacher-form-header .toggle-btn:hover {
        background: rgba(255,255,255,0.3);
    }
    
    .teacher-form-body {
        padding: 30px;
    }
    
    .teacher-form-group {
        margin-bottom: 20px;
    }
    
    .teacher-form-label {
        label {
            font-weight: 600;
            color: #2b2b2b;
            font-size: 13px;
            letter-spacing: 0.3px;
            margin-bottom: 8px;
            display: block;
        }
    }
    
    .teacher-form-input {
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
    
    .teacher-form-button {
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
    
    .teacher-list-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        border: 1px solid #e4e7ea;
    }
    
    .teacher-list-header {
        background: linear-gradient(135deg, #03a9f3 0%, #0288d1 100%);
        color: white;
        padding: 20px;
        border-radius: 8px 8px 0 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .teacher-list-header h4 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    
    .teacher-list-body {
        padding: 20px;
        overflow-x: auto;
    }
    
    .teacher-table {
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
    
    .teacher-action-btn {
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
    
    .teacher-role-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        
        &.class-teacher {
            background: #e3f2fd;
            color: #0288d1;
        }
        
        &.subject-teacher {
            background: #f3e5f5;
            color: #7b1fa2;
        }
    }
    
    .teacher-status-badge {
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
    
    .teacher-empty-state {
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
        .teacher-form-body {
            padding: 20px;
        }
        
        .teacher-list-body {
            padding: 15px;
        }
        
        .teacher-table {
            thead tr th,
            tbody tr td {
                padding: 10px;
                font-size: 12px;
            }
        }
    }
</style>

<div class="teacher-page-container">
    <!-- ADD NEW TEACHER FORM -->
    <div class="row">
        <div class="col-sm-12">
            <div class="teacher-form-card">
                <div class="teacher-form-header">
                    <h4><i class="fa fa-plus" style="margin-right: 10px;"></i>Add New Teacher</h4>
                    <button type="button" class="toggle-btn" id="teacherToggleBtn" onclick="toggleTeacherForm()">
                        <i class="fa fa-chevron-down"></i> Collapse
                    </button>
                </div>
                <div class="teacher-form-body" id="teacherFormBody" style="display: block;">
                    <?php echo form_open(base_url() . 'admin/teacher/insert/', array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data'));?>
                    
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <!-- Name -->
                            <div class="teacher-form-group teacher-form-label">
                                <label><?php echo get_phrase('name');?> <span style="color: #f44236;">*</span></label>
                                <div class="teacher-form-input">
                                    <input type="text" name="name" class="form-control" placeholder="Teacher's full name" required>
                                </div>
                            </div>
                            
                            <!-- Teacher Number (Hidden) -->
                            <div class="teacher-form-input" style="display: none;">
                                <input type="text" class="form-control" value="<?php echo substr(md5(uniqid(rand(), true)), 0, 7); ?>" name="teacher_number" readonly>
                            </div>
                            
                            <!-- Role -->
                            <div class="teacher-form-group teacher-form-label">
                                <label><?php echo get_phrase('role');?> <span style="color: #f44236;">*</span></label>
                                <div class="teacher-form-input">
                                    <select name="role" class="form-control" required>
                                        <option value=""><?php echo get_phrase('select');?></option>
                                        <option value="1"><?php echo get_phrase('class_teacher');?></option>
                                        <option value="2"><?php echo get_phrase('subject_teacher');?></option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Email -->
                            <div class="teacher-form-group teacher-form-label">
                                <label><?php echo get_phrase('email');?> <span style="color: #f44236;">*</span></label>
                                <div class="teacher-form-input">
                                    <input type="email" name="email" class="form-control" placeholder="teacher@school.com" required>
                                </div>
                            </div>
                            
                            <!-- Phone -->
                            <div class="teacher-form-group teacher-form-label">
                                <label><?php echo get_phrase('phone');?> <span style="color: #f44236;">*</span></label>
                                <div class="teacher-form-input">
                                    <input type="text" name="phone" class="form-control" placeholder="Phone number" required>
                                </div>
                            </div>
                            
                            <!-- Address -->
                            <div class="teacher-form-group teacher-form-label">
                                <label><?php echo get_phrase('address');?> <span style="color: #f44236;">*</span></label>
                                <div class="teacher-form-input">
                                    <input type="text" name="address" class="form-control" placeholder="Home address" required>
                                </div>
                            </div>
                            
                            <!-- Qualification -->
                            <div class="teacher-form-group teacher-form-label">
                                <label><?php echo get_phrase('qualification');?></label>
                                <div class="teacher-form-input">
                                    <input type="text" name="qualification" class="form-control" placeholder="e.g., B.Ed, M.Sc">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right Column -->
                        <div class="col-md-6">
                            <!-- Designation -->
                            <div class="teacher-form-group teacher-form-label">
                                <label><?php echo get_phrase('designation');?></label>
                                <div class="teacher-form-input">
                                    <select name="designation_id" class="form-control" id="designation_holder">
                                        <option value="">-- Optional --</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Date of Joining -->
                            <div class="teacher-form-group teacher-form-label">
                                <label><?php echo get_phrase('date_of_joining');?> <span style="color: #f44236;">*</span></label>
                                <div class="teacher-form-input">
                                    <input type="date" name="date_of_joining" class="form-control datepicker" value="<?php echo date('Y-m-d');?>" required>
                                </div>
                            </div>
                            
                            <!-- Joining Salary -->
                            <div class="teacher-form-group teacher-form-label">
                                <label><?php echo get_phrase('joining_salary');?></label>
                                <div class="teacher-form-input">
                                    <input type="number" name="joining_salary" class="form-control" placeholder="Salary amount">
                                </div>
                            </div>
                            
                            <!-- Status -->
                            <div class="teacher-form-group teacher-form-label">
                                <label><?php echo get_phrase('status');?></label>
                                <div class="teacher-form-input">
                                    <select name="status" class="form-control">
                                        <option value="1"><?php echo get_phrase('active'); ?></option>
                                        <option value="2"><?php echo get_phrase('inactive'); ?></option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Password -->
                            <div class="teacher-form-group teacher-form-label">
                                <label><?php echo get_phrase('password');?> <span style="color: #f44236;">*</span></label>
                                <div class="teacher-form-input">
                                    <input type="password" name="password" class="form-control" placeholder="Secure password" onkeyup="CheckPasswordStrength(this.value)" required>
                                </div>
                                <div id="password_strength" class="password-strength"></div>
                            </div>
                            
                            <!-- Profile Image -->
                            <div class="teacher-form-group teacher-form-label">
                                <label><?php echo get_phrase('browse_image');?></label>
                                <div class="teacher-form-input">
                                    <input type="file" name="userfile" class="dropify" onChange="readURL(this);">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="teacher-form-button" style="margin-top: 30px;">
                        <button type="submit"><i class="fa fa-check"></i>&nbsp; Add Teacher</button>
                    </div>
                    
                    <?php echo form_close();?>
                </div>
            </div>
        </div>
    </div>

    <!-- TEACHERS LIST TABLE -->
    <div class="row">
        <div class="col-sm-12">
            <div class="teacher-list-card">
                <div class="teacher-list-header">
                    <i class="fa fa-users"></i>
                    <h4><?php echo get_phrase('Teachers List');?></h4>
                </div>
                <div class="teacher-list-body">
                    <?php if(!empty($select_teacher)): ?>
                        <table class="teacher-table">
                            <thead>
                                <tr>
                                    <th width="8%">Avatar</th>
                                    <th width="18%"><?php echo get_phrase('name');?></th>
                                    <th width="12%"><?php echo get_phrase('role');?></th>
                                    <th width="20%"><?php echo get_phrase('email');?></th>
                                    <th width="10%"><?php echo get_phrase('phone');?></th>
                                    <th width="20%"><?php echo get_phrase('address');?></th>
                                    <th width="12%"><?php echo get_phrase('options');?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($select_teacher as $key => $teacher): ?>
                                <tr>
                                    <td style="text-align: center;">
                                        <?php echo get_avatar_badge($teacher['name'], 35); ?>
                                    </td>
                                    <td><strong><?php echo $teacher['name'];?></strong></td>
                                    <td>
                                        <span class="teacher-role-badge <?php echo ($teacher['role'] == 1) ? 'class-teacher' : 'subject-teacher'; ?>">
                                            <?php echo ($teacher['role'] == 1) ? 'Class Teacher' : 'Subject Teacher'; ?>
                                        </span>
                                    </td>
                                    <td><?php echo $teacher['email'];?></td>
                                    <td><?php echo $teacher['phone'];?></td>
                                    <td><?php echo substr($teacher['address'], 0, 30) . (strlen($teacher['address']) > 30 ? '...' : ''); ?></td>
                                    <td>
                                        <div class="teacher-action-btn">
                                            <button class="btn-edit" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/edit_teacher/<?php echo $teacher['teacher_id'];?>')">
                                                <i class="fa fa-edit"></i> Edit
                                            </button>
                                            <button class="btn-delete" onclick="return confirm('Are you sure you want to delete this teacher?') ? window.location.href='<?php echo base_url();?>admin/teacher/delete/<?php echo $teacher['teacher_id'];?>' : false;">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                            <a href="<?php echo base_url().'uploads/teacher_image/'.  $teacher['file_name'];?>" class="btn-download">
                                                <i class="fa fa-download"></i> Download
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="teacher-empty-state">
                            <i class="fa fa-inbox"></i>
                            <p>No teachers found. Start by adding a new teacher using the form above.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle Teacher Form Expand/Collapse
    function toggleTeacherForm() {
        const formBody = document.getElementById('teacherFormBody');
        const toggleBtn = document.getElementById('teacherToggleBtn');
        
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
