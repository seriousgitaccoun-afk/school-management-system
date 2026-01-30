<?php
// Simple Teacher Assignment Interface
?>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <i class="fa fa-users"></i>&nbsp;&nbsp;<?php echo get_phrase('Assign Teachers to Subjects');?>
            </div>
            <div class="panel-body">
                
                <!-- Quick Assignment Form -->
                <div class="row" style="margin-bottom: 30px;">
                    <div class="col-sm-12">
                        <h4><?php echo get_phrase('Quick Assignment');?></h4>
                        <div class="form-inline">
                            <div class="form-group">
                                <label><?php echo get_phrase('Class');?>:</label>
                                <select id="assign_class_id" class="form-control" style="width: 200px;">
                                    <option value=""><?php echo get_phrase('Select Class');?></option>
                                    <?php foreach($classes as $class): ?>
                                    <option value="<?php echo $class['class_id'];?>"><?php echo $class['name'];?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="form-group" style="margin-left: 10px;">
                                <label><?php echo get_phrase('Subject');?>:</label>
                                <select id="assign_subject_id" class="form-control" style="width: 200px;">
                                    <option value=""><?php echo get_phrase('Select Subject');?></option>
                                    <?php foreach($subjects as $subject): ?>
                                    <option value="<?php echo $subject['subject_id'];?>"><?php echo $subject['name'];?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="form-group" style="margin-left: 10px;">
                                <label><?php echo get_phrase('Teacher');?>:</label>
                                <select id="assign_teacher_id" class="form-control" style="width: 200px;">
                                    <option value="0"><?php echo get_phrase('Unassigned (Available to All)');?></option>
                                    <?php foreach($teachers as $teacher): ?>
                                    <option value="<?php echo $teacher['teacher_id'];?>"><?php echo $teacher['name'];?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <button class="btn btn-primary" onclick="save_assignment()" style="margin-left: 10px;">
                                <i class="fa fa-save"></i> <?php echo get_phrase('Assign');?>
                            </button>
                        </div>
                        <div id="assignment_message" style="margin-top: 10px; display: none;" class="alert"></div>
                    </div>
                </div>

                <!-- Current Assignments Table -->
                <div class="row">
                    <div class="col-sm-12">
                        <h4><?php echo get_phrase('Current Assignments');?></h4>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th><?php echo get_phrase('Class');?></th>
                                    <th><?php echo get_phrase('Subject');?></th>
                                    <th><?php echo get_phrase('Assigned Teacher');?></th>
                                    <th><?php echo get_phrase('Action');?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($assignments as $assignment): ?>
                                <tr>
                                    <td><?php echo $assignment['class_name'] ?? 'N/A';?></td>
                                    <td><?php echo $assignment['subject_name'] ?? 'N/A';?></td>
                                    <td>
                                        <span class="badge" style="background-color: <?php echo ($assignment['teacher_id'] == 0 ? '#999' : '#0275d8');?>">
                                            <?php echo ($assignment['teacher_id'] == 0 ? 'Unassigned (All Teachers)' : $assignment['teacher_name']);?>
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" onclick="edit_assignment(<?php echo $assignment['class_id'];?>, <?php echo $assignment['subject_id'];?>)">
                                            <i class="fa fa-edit"></i> <?php echo get_phrase('Change');?>
                                        </button>
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
</div>

<script>
function save_assignment() {
    var class_id = $('#assign_class_id').val();
    var subject_id = $('#assign_subject_id').val();
    var teacher_id = $('#assign_teacher_id').val();
    
    if (!class_id || !subject_id) {
        alert('Please select both class and subject');
        return;
    }
    
    $.ajax({
        url: '<?php echo base_url();?>admin/assign_teachers_to_subjects/save_assignment',
        type: 'POST',
        dataType: 'JSON',
        data: {
            class_id: class_id,
            subject_id: subject_id,
            teacher_id: teacher_id
        },
        success: function(response) {
            if (response.success) {
                $('#assignment_message').removeClass('alert-danger').addClass('alert-success').text(response.message).show();
                setTimeout(function() {
                    location.reload();
                }, 1500);
            } else {
                $('#assignment_message').removeClass('alert-success').addClass('alert-danger').text(response.message).show();
            }
        },
        error: function() {
            $('#assignment_message').removeClass('alert-success').addClass('alert-danger').text('Error saving assignment').show();
        }
    });
}

function edit_assignment(class_id, subject_id) {
    $('#assign_class_id').val(class_id);
    $('#assign_subject_id').val(subject_id);
    $('html, body').animate({scrollTop: 0}, 'fast');
}
</script>
