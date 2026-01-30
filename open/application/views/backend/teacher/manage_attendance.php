
<?php $active_sms_gateway = $this->db->get_where('sms_settings' , array('type' => 'active_sms_gateway'))->row()->info;?>

<style>
    /* Teacher Attendance Management Styling */
    .attendance-page-container {
        background: #f8f9fa;
        padding: 20px 0;
    }
    
    .attendance-form-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        border: 1px solid #e4e7ea;
        margin-bottom: 30px;
    }
    
    .attendance-form-header {
        background: linear-gradient(135deg, #03a9f3 0%, #0288d1 100%);
        color: white;
        padding: 20px;
        border-radius: 8px 8px 0 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .attendance-form-header h4 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    
    .attendance-form-body {
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
        input, select {
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
    }
    
    .attendance-form-button {
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
    
    .attendance-list-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        border: 1px solid #e4e7ea;
        margin-bottom: 30px;
    }
    
    .attendance-list-header {
        background: linear-gradient(135deg, #00c292 0%, #00897b 100%);
        color: white;
        padding: 20px;
        border-radius: 8px 8px 0 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .attendance-list-header h4 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .attendance-date-info {
        background: rgba(255,255,255,0.2);
        padding: 8px 16px;
        border-radius: 4px;
        font-size: 13px;
        font-weight: 500;
    }
    
    .attendance-list-body {
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
    
    .attendance-status-group {
        display: flex;
        gap: 8px;
        justify-content: flex-start;
        
        .status-btn {
            padding: 8px 12px;
            border: 2px solid #e4e7ea;
            background: white;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 6px;
            flex: 1;
            text-align: center;
            justify-content: center;
            min-width: 60px;
            
            i {
                font-size: 14px;
            }
            
            &:hover {
                border-color: #03a9f3;
                background: #e3f2fd;
            }
            
            &.active {
                &.present {
                    background: #c8e6c9;
                    border-color: #00c292;
                    color: #00600d;
                }
                
                &.absent {
                    background: #ffcdd2;
                    border-color: #f44236;
                    color: #b71c1c;
                }
                
                &.late {
                    background: #ffe0b2;
                    border-color: #ff9800;
                    color: #e65100;
                }
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
    
    .attendance-save-btn {
        button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #00c292 0%, #00897b 100%);
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
    
    .gateway-alert {
        padding: 14px 16px;
        border-radius: 4px;
        border-left: 4px solid;
        font-size: 13px;
        margin-bottom: 20px;
        
        &.warning {
            background: #fff3cd;
            border-left-color: #ff9800;
            color: #856404;
            
            i {
                color: #ff9800;
                margin-right: 8px;
            }
        }
        
        &.success {
            background: #d4edda;
            border-left-color: #00c292;
            color: #155724;
            
            i {
                color: #00c292;
                margin-right: 8px;
            }
        }
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .attendance-form-body {
            padding: 20px;
        }
        
        .attendance-list-body {
            padding: 15px;
        }
        
        .attendance-table {
            thead tr th,
            tbody tr td {
                padding: 10px;
                font-size: 12px;
            }
        }
        
        .attendance-status-group {
            flex-wrap: wrap;
        }
    }
</style>

<div class="attendance-page-container">
    <!-- ATTENDANCE FILTER FORM -->
    <div class="row">
        <div class="col-sm-12">
            <div class="attendance-form-card">
                <div class="attendance-form-header">
                    <i class="fa fa-calendar"></i>
                    <h4><?php echo get_phrase('Mark Attendance');?></h4>
                </div>
                <div class="attendance-form-body">
                    <div id="success_message" class="alert alert-success" style="display:none;"></div>
                    <div id="error_message" class="alert alert-danger" style="display:none;"></div>

                    <?php echo form_open(base_url() . 'teacher/attendance_selector' , array('class' => 'form-horizontal','id' => 'attendance_selector'));?>
                    
                        <div class="row">
                            <div class="col-md-6">
                                <div class="attendance-form-group attendance-form-label">
                                    <label><?php echo get_phrase('class');?> <span style="color: #f44236;">*</span></label>
                                    <div class="attendance-form-input">
                                        <select name="class_id" id="class_id" class="form-control" required>
                                            <option value=""><?php echo get_phrase('select_class');?></option>
                                            <?php $classes =  $this->db->get('class')->result_array();
                                            foreach($classes as $key => $class):?>
                                            <option value="<?php echo $class['class_id'];?>"<?php if(isset($class_id) && $class_id==$class['class_id']) echo 'selected="selected"';?>><?php echo $class['name'];?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="attendance-form-group attendance-form-label">
                                    <label><?php echo get_phrase('date');?> <span style="color: #f44236;">*</span></label>
                                    <div class="attendance-form-input">
                                        <input type="date" class="form-control" id="timestamp" name="timestamp" value="<?php echo (!empty($date) && !empty($month) && !empty($year)) ? $year."-".str_pad($month, 2, '0', STR_PAD_LEFT)."-".str_pad($date, 2, '0', STR_PAD_LEFT) : date('Y-m-d'); ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="attendance-form-button">
                            <button type="submit"><i class="fa fa-search"></i>&nbsp;Load Students</button>
                        </div>
                        
                    </form>                
                </div>                
            </div>
        </div>
    </div>

    <?php if($date!=null && $month !=null && $year !=null):?>

    <!-- ATTENDANCE DETAILS TABLE -->
    <div class="row">
        <div class="col-sm-12">
            <div class="attendance-list-card">
                <div class="attendance-list-header">
                    <h4><i class="fa fa-list"></i>Attendance Details</h4>
                    <div class="attendance-date-info">
                        <?php 
                            $classes = $this->db->get('class')->result_array();
                            foreach($classes as $class){ 
                                if(isset($class_id) && $class_id == $class['class_id'])
                                    $class_name = $class['name'];
                            }
                            
                            $full_date = $date."-".$month."-".$year;
                            $full_date = date_create($full_date);
                            $full_date = date_format($full_date, "d M Y");
                        ?>
                        <?php echo $class_name; ?> • <?php echo $full_date;?>
                    </div>
                </div>
                <div class="attendance-list-body">
                    <form id="attendance_form" action="<?php echo base_url();?>teacher/manage_attendance/<?php echo $date.'/'.$month.'/'.$year.'/'.$class_id;?>" method="post" accept-charset="utf-8">
                        <?php 
                            $students = $this->db->get_where('student', array('class_id' => $class_id))->result_array();
                            $full_date = $year ."-". str_pad($month, 2, '0', STR_PAD_LEFT)."-". str_pad($date, 2, '0', STR_PAD_LEFT);
                            
                            if(empty($students)):
                        ?>
                            <div class="attendance-empty-state">
                                <i class="fa fa-inbox"></i>
                                <p>No students in this class</p>
                            </div>
                        <?php
                        else:
                        ?>
                            <table class="attendance-table">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="8%">Avatar</th>
                                        <th width="25%">Name</th>
                                        <th width="12%">Gender</th>
                                        <th width="10%">Roll</th>
                                        <th width="40%">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $i = 1;
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
                                                    $verify_data = array('student_id' => $student['student_id'], 'date' => $full_date);
                                                    $query = $this->db->get_where('attendance', $verify_data);
                                                    if($query->num_rows() < 1) {
                                                        $current_term = $this->db->where('is_active', 1)->get('academic_terms')->row();
                                                        $academic_term_id = $current_term ? $current_term->academic_term_id : 1;
                                                        $verify_data['academic_term_id'] = $academic_term_id;
                                                        $this->db->insert('attendance', $verify_data);
                                                    }

                                                    $attendance = $this->db->get_where('attendance', $verify_data)->row();
                                                    $status = $attendance->status;
                                                ?>
                                                <div class="attendance-status-group">
                                                    <label class="status-btn present <?php if($status == 1) echo 'active'; ?>" title="Present">
                                                        <input type="radio" name="status_<?php echo $student['student_id'];?>" value="1" <?php if($status == 1) echo 'checked="checked"'; ?> style="display: none;">
                                                        <i class="fa fa-check"></i> P
                                                    </label>
                                                    <label class="status-btn absent <?php if($status == 2) echo 'active'; ?>" title="Absent">
                                                        <input type="radio" name="status_<?php echo $student['student_id'];?>" value="2" <?php if($status == 2) echo 'checked="checked"'; ?> style="display: none;">
                                                        <i class="fa fa-times"></i> A
                                                    </label>
                                                    <label class="status-btn late <?php if($status == 3) echo 'active'; ?>" title="Late/Tardy">
                                                        <input type="radio" name="status_<?php echo $student['student_id'];?>" value="3" <?php if($status == 3) echo 'checked="checked"'; ?> style="display: none;">
                                                        <i class="fa fa-clock-o"></i> L
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

                            <div class="attendance-save-btn">
                                <button type="submit"><i class="fa fa-save"></i>&nbsp;Save Attendance</button>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- SMS GATEWAY STATUS -->
    <div class="row">
        <div class="col-md-12">
    <?php  if ($active_sms_gateway == ''): ?>			
            <div class="gateway-alert warning">
                <i class="fa fa-warning"></i> <?php echo get_phrase('SMS Gateway Not Selected');?>
            </div> 
    <?php elseif ($active_sms_gateway != 'disabled'): ?>			
            <div class="gateway-alert success">
                <i class="fa fa-check"></i> SMS Gateway Active: <strong><?php echo ucfirst(str_replace('_', ' ', $active_sms_gateway));?></strong>
            </div>
    <?php endif;?>
        </div>
    </div>

    <?php endif;?>
</div>

<script>
    // Make status buttons clickable
    document.querySelectorAll('.status-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from siblings
            this.parentElement.querySelectorAll('.status-btn').forEach(b => b.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
            // Check the radio input
            this.querySelector('input[type="radio"]').checked = true;
        });
    });
</script>

