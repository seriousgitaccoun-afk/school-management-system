
<?php $active_sms_gateway = $this->db->get_where('sms_settings' , array('type' => 'active_sms_gateway'))->row()->info;?>

<style>
    /* Professional Attendance Management Styling */
    .attendance-page-container {
        background: #f8f9fa;
        padding: 20px 0;
    }
    
    .attendance-filter-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        border: 1px solid #e4e7ea;
        margin-bottom: 30px;
    }
    
    .attendance-filter-header {
        background: linear-gradient(135deg, #03a9f3 0%, #0288d1 100%);
        color: white;
        padding: 20px;
        border-radius: 8px 8px 0 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .attendance-filter-header h4 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    
    .attendance-filter-body {
        padding: 30px;
    }
    
    .attendance-form-group {
        margin-bottom: 20px;
    }
    
    .attendance-form-label {
        label {
            font-weight: 600;
            color: #2b2b2b;
            font-size: 13px;
            letter-spacing: 0.3px;
            margin-bottom: 8px;
            display: block;
        }
    }
    
    .attendance-form-input {
        select, input {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid #d9dfe4;
            border-radius: 4px;
            font-size: 13px;
            transition: all 0.3s ease;
            font-family: Poppins, sans-serif;
            background-color: white;
            cursor: pointer;
            appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg fill="%23686868" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>');
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 20px;
            padding-right: 35px;
            
            &:focus {
                border-color: #03a9f3;
                box-shadow: 0 0 0 3px rgba(3, 169, 243, 0.1);
                outline: none;
            }
        }
        
        input {
            appearance: auto;
            background-image: none;
            padding-right: 14px;
        }
    }
    
    .attendance-filter-button {
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
    
    .attendance-table-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        border: 1px solid #e4e7ea;
        margin-bottom: 30px;
    }
    
    .attendance-table-header {
        background: linear-gradient(135deg, #03a9f3 0%, #0288d1 100%);
        color: white;
        padding: 20px;
        border-radius: 8px 8px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
    }
    
    .attendance-table-header h4 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    
    .attendance-table-info {
        display: flex;
        gap: 20px;
        align-items: center;
        font-size: 13px;
    }
    
    .attendance-table-info-item {
        display: flex;
        gap: 8px;
        align-items: center;
        
        strong {
            color: #ffffff;
        }
        
        span {
            opacity: 0.95;
        }
    }
    
    .attendance-table-body {
        padding: 20px;
        overflow-x: auto;
    }
    
    .attendance-table {
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
    
    .attendance-student-image {
        img {
            max-height: 40px;
            border-radius: 50%;
            border: 2px solid #e4e7ea;
        }
    }
    
    .attendance-status-group {
        display: flex;
        gap: 8px;
        justify-content: space-between;
        
        label {
            flex: 1;
            padding: 10px 12px;
            border: 2px solid #d9dfe4;
            border-radius: 4px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            margin: 0;
            
            input[type="radio"] {
                display: none;
            }
            
            i {
                font-size: 16px;
            }
            
            &:hover {
                border-color: #03a9f3;
                background: #f0f7ff;
            }
            
            &.present input:checked ~ i,
            input[type="radio"]:checked ~ i.present-icon {
                color: #00c292;
            }
            
            input[type="radio"]:checked + i.present-icon {
                color: #00c292;
            }
        }
    }
    
    .attendance-status-group label.present:has(input:checked) {
        border-color: #00c292;
        background: #f0fdf4;
    }
    
    .attendance-status-group label.absent:has(input:checked) {
        border-color: #f44236;
        background: #fef5f5;
    }
    
    .attendance-status-group label.late:has(input:checked) {
        border-color: #ff9800;
        background: #fff8f0;
    }
    
    .status-present {
        color: #00c292;
    }
    
    .status-absent {
        color: #f44236;
    }
    
    .status-late {
        color: #ff9800;
    }
    
    .attendance-save-button {
        button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #00c292 0%, #00a876 100%);
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
            margin-top: 20px;
            
            &:hover {
                box-shadow: 0 4px 12px rgba(0, 194, 146, 0.3);
                transform: translateY(-1px);
            }
            
            &:active {
                transform: translateY(0);
            }
        }
    }
    
    .alert-custom {
        border-radius: 4px;
        padding: 14px 16px;
        border-left: 4px solid;
        margin-bottom: 20px;
        font-size: 13px;
        
        &.alert-success {
            border-left-color: #00c292;
            background: #f0fdf4;
            color: #00764a;
            
            i {
                color: #00c292;
                margin-right: 8px;
            }
        }
        
        &.alert-warning {
            border-left-color: #ff9800;
            background: #fff8f0;
            color: #7a4a00;
            
            i {
                color: #ff9800;
                margin-right: 8px;
            }
        }
        
        &.alert-danger {
            border-left-color: #f44236;
            background: #fef5f5;
            color: #7a1a17;
            
            i {
                color: #f44236;
                margin-right: 8px;
            }
        }
    }
    
    .attendance-empty-state {
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
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .attendance-filter-body {
            padding: 20px;
        }
        
        .attendance-table-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .attendance-table-info {
            flex-direction: column;
            gap: 10px;
        }
        
        .attendance-status-group {
            flex-wrap: wrap;
        }
        
        .attendance-status-group label {
            flex: 1 1 calc(33.333% - 6px);
        }
    }
</style>

<div class="attendance-page-container">
    <!-- ATTENDANCE FILTER/SELECTION FORM -->
    <div class="row">
        <div class="col-sm-12">
            <div class="attendance-filter-card">
                <div class="attendance-filter-header">
                    <i class="fa fa-calendar" style="font-size: 20px;"></i>
                    <h4><?php echo get_phrase('Attendance Management');?></h4>
                </div>
                <div class="attendance-filter-body">
                    <div id="success_message" class="alert alert-custom alert-success" style="display:none"></div>
                    <div id="error_message" class="alert alert-custom alert-danger" style="display:none"></div>
                    
                    <?php echo form_open(base_url() . 'admin/attendance_selector', array('class' => 'form-horizontal validate', 'id' => 'attendance_selector'));?>
                    
                    <div class="row">
                        <div class="col-md-5">
                            <div class="attendance-form-group attendance-form-label">
                                <label><?php echo get_phrase('class');?> <span style="color: #f44236;">*</span></label>
                                <div class="attendance-form-input">
                                    <select name="class_id" id="class_id" class="form-control" required>
                                        <option value=""><?php echo get_phrase('select_class');?></option>
                                        <?php $classes = $this->db->get('class')->result_array();
                                        foreach($classes as $key => $class):?>
                                        <option value="<?php echo $class['class_id'];?>"<?php if(isset($class_id) && $class_id==$class['class_id']) echo 'selected="selected"';?>><?php echo $class['name'];?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="attendance-form-group attendance-form-label">
                                <label><?php echo get_phrase('date');?> <span style="color: #f44236;">*</span></label>
                                <div class="attendance-form-input">
                                    <input type="date" class="form-control" id="timestamp" name="timestamp" value="<?php echo (!empty($date) && !empty($month) && !empty($year)) ? $year."-".str_pad($month, 2, '0', STR_PAD_LEFT)."-".str_pad($date, 2, '0', STR_PAD_LEFT) : date('Y-m-d'); ?>" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="attendance-form-group attendance-form-label">
                                <label style="visibility: hidden;">Search</label>
                                <div class="attendance-filter-button">
                                    <button type="submit"><i class="fa fa-search"></i>&nbsp; Get Students</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?php echo form_close();?>
                </div>
            </div>
        </div>
    </div>

    <?php if($date!=null && $month !=null && $year !=null):?>

    <!-- ATTENDANCE RECORDS TABLE -->
    <div class="row">
        <div class="col-sm-12">
            <div class="attendance-table-card">
                <div class="attendance-table-header">
                    <h4><i class="fa fa-list" style="margin-right: 10px;"></i>Attendance Details</h4>
                    <div class="attendance-table-info">
                        <div class="attendance-table-info-item">
                            <strong>Class:</strong>
                            <span>
                                <?php 
                                    $classes = $this->db->get('class')->result_array();
                                    foreach($classes as $class){ 
                                        if(isset($class_id) && $class_id == $class['class_id'])
                                            $class_name = $class['name'];
                                    }
                                    echo $class_name;
                                ?>
                            </span>
                        </div>
                        <div class="attendance-table-info-item">
                            <strong>Date:</strong>
                            <span>
                                <?php 
                                    $full_date = $date."-".$month."-".$year;
                                    $full_date = date_create($full_date);
                                    $full_date = date_format($full_date, "d M Y");
                                    echo $full_date;
                                ?>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="attendance-table-body">
                    <form id="attendance_form" action="<?php echo base_url();?>admin/manage_attendance/<?php echo $date.'/'.$month.'/'.$year.'/'.$class_id;?>" method="post" accept-charset="utf-8">
                        <?php 
                            $students = $this->db->get_where('student', array('class_id' => $class_id))->result_array();
                            $full_date = $year ."-". str_pad($month, 2, '0', STR_PAD_LEFT)."-". str_pad($date, 2, '0', STR_PAD_LEFT);
                            $i = 1;
                            
                            if(empty($students)):
                        ?>
                            <div class="attendance-empty-state">
                                <i class="fa fa-inbox"></i>
                                <p>No students in this class.</p>
                            </div>
                        <?php
                        else:
                        ?>
                        <table class="attendance-table">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="8%">Image</th>
                                    <th width="22%">Name</th>
                                    <th width="10%">Gender</th>
                                    <th width="10%">Roll</th>
                                    <th width="45%">Attendance Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($students as $student):
                                ?>
                                <tr>
                                    <td><?php echo $i?></td>
                                    <td style="text-align: center;">
                                        <?php echo get_avatar_badge($student['name'], 35); ?>
                                    </td>
                                    <td><strong><?php echo $student['name'];?></strong></td>
                                    <td><?php echo $student['sex'];?></td>
                                    <td><?php echo $student['roll'];?></td>
                                    <td>
                                        <?php 
                                            //inserting blank page for students attendance if not available
                                            $verify_data = array('student_id' => $student['student_id'], 'date' => $full_date);
                                            $query = $this->db->get_where('attendance', $verify_data);
                                            if($query->num_rows() < 1)
                                                $this->db->insert('attendance', $verify_data );

                                            //showing the attendance status editing option
                                            $attendance = $this->db->get_where('attendance', $verify_data)->row();
                                            $status = $attendance->status;
                                        ?>
                                        <div class="attendance-status-group">
                                            <label class="present" title="Present">
                                                <input type="radio" name="status_<?php echo $student['student_id'];?>" value="1" <?php if($status == 1) echo 'checked="checked"'; ?>>
                                                <i class="fa fa-check status-present"></i>
                                                <span>Present</span>
                                            </label>
                                            <label class="absent" title="Absent">
                                                <input type="radio" name="status_<?php echo $student['student_id'];?>" value="2" <?php if($status == 2) echo 'checked="checked"'; ?>>
                                                <i class="fa fa-times status-absent"></i>
                                                <span>Absent</span>
                                            </label>
                                            <label class="late" title="Late/Tardy">
                                                <input type="radio" name="status_<?php echo $student['student_id'];?>" value="3" <?php if($status == 3) echo 'checked="checked"'; ?>>
                                                <i class="fa fa-clock-o status-late"></i>
                                                <span>Late</span>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <?php 
                                        $i++;
                                    endforeach;
                                ?>
                            </tbody>
                        </table>
                        <?php endif; ?>

                        <div class="attendance-save-button">
                            <button type="submit"><i class="fa fa-save"></i>&nbsp; Save Attendance</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- SMS GATEWAY STATUS -->
    <?php if ($active_sms_gateway == ''): ?>			
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-custom alert-warning">
                    <i class="fa fa-warning"></i> <?php echo get_phrase('SMS Gateway Not Selected');?>
                </div> 
            </div>
        </div>
    <?php elseif ($active_sms_gateway != 'disabled'): ?>			
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-custom alert-success">
                    <i class="fa fa-check-circle"></i> SMS Gateway Active: <strong><?php echo ucfirst(str_replace('_', ' ', $active_sms_gateway));?></strong>
                </div> 
            </div>
        </div>
    <?php endif;?>

    <?php endif;?>
</div>