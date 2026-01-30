<?php
// Simple Subject Teacher Assignment Form
// One teacher → One subject → All their classes
?>

<style>
    /* Subject Teacher Assignment Styling */
    .assignment-page-container {
        background: #f8f9fa;
        padding: 20px 0;
    }
    
    .assignment-form-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        border: 1px solid #e4e7ea;
        margin-bottom: 30px;
    }
    
    .assignment-form-header {
        background: linear-gradient(135deg, #03a9f3 0%, #0288d1 100%);
        color: white;
        padding: 20px;
        border-radius: 8px 8px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .assignment-form-header h4 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    
    .assignment-form-header .toggle-btn {
        background: rgba(255,255,255,0.2);
        border: none;
        color: white;
        padding: 8px 12px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    
    .assignment-form-header .toggle-btn:hover {
        background: rgba(255,255,255,0.3);
    }
    
    .assignment-form-body {
        padding: 30px;
    }
    
    .assignment-intro {
        background: #e3f2fd;
        border-left: 4px solid #03a9f3;
        padding: 14px 16px;
        border-radius: 2px;
        margin-bottom: 25px;
        font-size: 13px;
        color: #1565c0;
        line-height: 1.6;
    }
    
    .assignment-intro strong {
        color: #0d47a1;
    }
    
    .assignment-form-group {
        margin-bottom: 20px;
    }
    
    .assignment-form-label {
        label {
            font-weight: 600;
            color: #2b2b2b;
            font-size: 13px;
            letter-spacing: 0.3px;
            margin-bottom: 8px;
            display: block;
        }
    }
    
    .assignment-form-input {
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
    }
    
    .assignment-form-button {
        button {
            width: 100%;
            padding: 13px;
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
    
    .assignment-list-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        border: 1px solid #e4e7ea;
    }
    
    .assignment-list-header {
        background: linear-gradient(135deg, #03a9f3 0%, #0288d1 100%);
        color: white;
        padding: 20px;
        border-radius: 8px 8px 0 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .assignment-list-header h4 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    
    .assignment-count {
        background: rgba(255,255,255,0.2);
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 12px;
        margin-left: auto;
    }
    
    .assignment-list-body {
        padding: 20px;
        overflow-x: auto;
    }
    
    .assignment-table {
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
    
    .assignment-action-btn {
        display: inline-flex;
        gap: 6px;
        
        .btn-unassign {
            padding: 8px 12px;
            background: #f44236;
            color: white;
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
            
            &:hover {
                background: #e53935;
                box-shadow: 0 2px 8px rgba(244, 66, 54, 0.3);
            }
        }
    }
    
    .assignment-empty-state {
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
        .assignment-form-body {
            padding: 20px;
        }
        
        .assignment-list-body {
            padding: 15px;
        }
        
        .assignment-table {
            thead tr th,
            tbody tr td {
                padding: 10px;
                font-size: 12px;
            }
        }
    }
</style>

<div class="assignment-page-container">
    <!-- ASSIGNMENT FORM -->
    <div class="row">
        <div class="col-sm-12">
            <div class="assignment-form-card">
                <div class="assignment-form-header">
                    <h4><i class="fa fa-link" style="margin-right: 10px;"></i>Assign Subject Teacher</h4>
                    <button type="button" class="toggle-btn" id="assignmentToggleBtn" onclick="toggleAssignmentForm()">
                        <i class="fa fa-chevron-down"></i> Collapse
                    </button>
                </div>
                <div class="assignment-form-body" id="assignmentFormBody" style="display: block;">
                    <div class="assignment-intro">
                        <strong>📋 How it works:</strong> Select a subject teacher, the subject they teach, and which specific classes they will teach it in. One teacher can teach one subject across multiple classes.
                    </div>
                    
                    <form id="assign_form" class="form-horizontal">
                        <!-- Select Teacher -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="assignment-form-group assignment-form-label">
                                    <label>Subject Teacher <span style="color: #f44236;">*</span></label>
                                    <div class="assignment-form-input">
                                        <select id="teacher_id" class="form-control" required>
                                            <option value="">-- Select Teacher --</option>
                                            <?php 
                                            if(isset($subject_teachers) && !empty($subject_teachers)):
                                                foreach($subject_teachers as $teacher):
                                            ?>
                                                <option value="<?php echo $teacher['teacher_id']; ?>">
                                                    <?php echo $teacher['name']; ?>
                                                </option>
                                            <?php 
                                                endforeach;
                                            endif;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Select Subject -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="assignment-form-group assignment-form-label">
                                    <label>Subject <span style="color: #f44236;">*</span></label>
                                    <div class="assignment-form-input">
                                        <select id="subject_id" class="form-control" required>
                                            <option value="">-- Select Subject --</option>
                                            <?php 
                                            if(isset($subjects) && !empty($subjects)):
                                                foreach($subjects as $subject):
                                            ?>
                                                <option value="<?php echo $subject['subject_id']; ?>">
                                                    <?php echo $subject['name']; ?>
                                                </option>
                                            <?php 
                                                endforeach;
                                            endif;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Select Classes -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="assignment-form-group assignment-form-label">
                                    <label>Classes <small style="color: #00c292; font-weight: 500;">(Select Multiple)</small> <span style="color: #f44236;">*</span></label>
                                    <div class="assignment-form-input">
                                        <select id="class_ids" class="form-control" multiple required size="6">
                                            <?php 
                                            if(isset($classes) && !empty($classes)):
                                                foreach($classes as $class):
                                            ?>
                                                <option value="<?php echo $class['class_id']; ?>">
                                                    ✓ <?php echo $class['name']; ?>
                                                </option>
                                            <?php 
                                                endforeach;
                                            endif;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="row" style="margin-top: 20px;">
                            <div class="col-md-12">
                                <div class="assignment-form-button">
                                    <button type="button" onclick="assign_subject_teacher()">
                                        <i class="fa fa-check"></i>&nbsp; Assign Teacher to Subject
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ASSIGNMENTS LIST -->
    <div class="row">
        <div class="col-sm-12">
            <div class="assignment-list-card">
                <div class="assignment-list-header">
                    <i class="fa fa-list"></i>
                    <h4>Current Assignments</h4>
                    <span class="assignment-count"><?php echo isset($assignments) ? count($assignments) : 0; ?> assignments</span>
                </div>
                <div class="assignment-list-body">
                    <?php if(isset($assignments) && is_array($assignments) && count($assignments) > 0): ?>
                        <table class="assignment-table">
                            <thead>
                                <tr>
                                    <th width="25%">Teacher</th>
                                    <th width="20%">Subject</th>
                                    <th width="40%">Classes Teaching</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                foreach($assignments as $assign):
                                ?>
                                    <tr>
                                        <td><strong><?php echo isset($assign['teacher_name']) ? $assign['teacher_name'] : 'N/A'; ?></strong></td>
                                        <td><?php echo isset($assign['subject_name']) ? $assign['subject_name'] : 'N/A'; ?></td>
                                        <td><?php echo isset($assign['classes']) ? $assign['classes'] : 'N/A'; ?></td>
                                        <td>
                                            <div class="assignment-action-btn">
                                                <button class="btn-unassign" onclick="unassign_subject_teacher(<?php echo $assign['subject_id']; ?>)">
                                                    <i class="fa fa-trash"></i> Unassign
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php 
                                endforeach;
                                ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="assignment-empty-state">
                            <i class="fa fa-inbox"></i>
                            <p>No subject teacher assignments yet. Create one using the form above.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle Assignment Form Expand/Collapse
    function toggleAssignmentForm() {
        const formBody = document.getElementById('assignmentFormBody');
        const toggleBtn = document.getElementById('assignmentToggleBtn');
        
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
    
    function assign_subject_teacher() {
        var teacher_id = $('#teacher_id').val();
        var subject_id = $('#subject_id').val();
        var class_ids = $('#class_ids').val();
        
        if (!teacher_id || !subject_id || !class_ids || class_ids.length === 0) {
            alert('Please select teacher, subject, and at least one class');
            return;
        }
        
        $.ajax({
            url: '<?php echo base_url(); ?>admin/assign_subject_teacher_simple',
            type: 'POST',
            data: {
                teacher_id: teacher_id,
                subject_id: subject_id,
                class_ids: class_ids.join(',')
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('✅ ' + response.message);
                    location.reload();
                } else {
                    alert('❌ ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                alert('Error saving assignment: ' + error);
                console.log('Response:', xhr.responseText);
            }
        });
    }

    function unassign_subject_teacher(subject_id) {
        if (!confirm('Are you sure you want to unassign this teacher from this subject?')) {
            return;
        }
        
        $.ajax({
            url: '<?php echo base_url(); ?>admin/unassign_subject_teacher_simple',
            type: 'POST',
            data: {
                subject_id: subject_id
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('✅ ' + response.message);
                    location.reload();
                } else {
                    alert('❌ ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                alert('Error removing assignment: ' + error);
                console.log('Response:', xhr.responseText);
            }
        });
    }
</script>

<script>
function assign_subject_teacher() {
    var teacher_id = $('#teacher_id').val();
    var subject_id = $('#subject_id').val();
    var class_ids = $('#class_ids').val();
    
    if (!teacher_id || !subject_id || !class_ids || class_ids.length === 0) {
        alert('Please select teacher, subject, and at least one class');
        return;
    }
    
    $.ajax({
        url: '<?php echo base_url(); ?>admin/assign_subject_teacher_simple',
        type: 'POST',
        data: {
            teacher_id: teacher_id,
            subject_id: subject_id,
            class_ids: class_ids.join(',')  // Send as comma-separated string
        },
        dataType: 'json',
        success: function(response) {
            // response is already parsed as JSON due to dataType
            if (response.success) {
                alert('✅ ' + response.message);
                location.reload();
            } else {
                alert('❌ ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            alert('Error saving assignment: ' + error);
            console.log('Response:', xhr.responseText);
        }
    });
}

function unassign_subject_teacher(subject_id) {
    if (!confirm('Are you sure you want to unassign this teacher from this subject?')) {
        return;
    }
    
    $.ajax({
        url: '<?php echo base_url(); ?>admin/unassign_subject_teacher_simple',
        type: 'POST',
        data: {
            subject_id: subject_id
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                alert('✅ ' + response.message);
                location.reload();
            } else {
                alert('❌ ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            alert('Error removing assignment: ' + error);
            console.log('Response:', xhr.responseText);
        }
    });
}
</script>
