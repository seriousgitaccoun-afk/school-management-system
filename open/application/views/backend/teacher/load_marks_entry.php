<?php 
// Debug info
$debug_subject_name = isset($subject_id) ? $this->crud_model->get_type_name_by_id('subject', $subject_id) : 'Unknown';
?>

<?php 
// Get teacher ID and current user info
$teacher_id = $this->session->userdata('user_id');

// Fetch grading structure for this teacher-subject combo
$grading_structure = null;
if ($teacher_id && $subject_id) {
    $grading_structure = $this->score_entry_model->get_grading_structure($teacher_id, $subject_id);
}

// Parse JSON if it exists
$grading_components = null;
if ($grading_structure) {
    $grading_components = json_decode($grading_structure, true);
}
?>

<?php if(empty($students)): ?>
    <div class="alert alert-warning">
        <i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;
        <strong>No students found for this class.</strong>
        <br>
        <small>Class ID: <?php echo $class_id; ?> | Subject: <?php echo $debug_subject_name; ?> (<?php echo $subject_id; ?>) | Term ID: <?php echo $academic_term_id; ?></small>
        <br>
        <em>Make sure students are enrolled in this class.</em>
    </div>
<?php else: ?>
<div class="panel panel-success" style="margin-bottom: 20px;">
    <div class="panel-heading">
        <i class="fa fa-book"></i>&nbsp;&nbsp;Subject: <strong><?php echo $this->crud_model->get_type_name_by_id('subject', $subject_id); ?></strong>
    </div>
</div>
<form id="marks_entry_form">
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo get_phrase('Name'); ?></th>
                    <th><?php echo get_phrase('Roll'); ?></th>
                    <?php if ($grading_components && is_array($grading_components)): ?>
                        <?php foreach ($grading_components as $component): ?>
                            <th>
                                <?php echo htmlspecialchars($component['name']); ?>
                                <?php if ($component['is_exam']): ?>
                                    <span class="badge badge-info">Exam</span>
                                    <small style="color: #888;">(Max: 100)</small>
                                <?php else: ?>
                                    <small style="color: #888;">(Max: 50)</small>
                                <?php endif; ?>
                            </th>
                        <?php endforeach; ?>
                        <th><?php echo get_phrase('Total'); ?></th>
                    <?php else: ?>
                        <th>
                            <?php echo get_phrase('Class Score'); ?>
                            <small style="color: #888;">(Max: 50)</small>
                        </th>
                        <th>
                            <?php echo get_phrase('Exam Score'); ?>
                            <span class="badge badge-info">Exam</span>
                            <small style="color: #888;">(Max: 100)</small>
                        </th>
                        <th><?php echo get_phrase('Total'); ?></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; foreach($students as $student): ?>
                    <tr class="marks-row" data-student-id="<?php echo $student['student_id']; ?>" data-grading-custom="<?php echo ($grading_components ? 'true' : 'false'); ?>">
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $student['name']; ?></td>
                        <td><?php echo $student['roll']; ?></td>
                        <?php if ($grading_components && is_array($grading_components)): ?>
                            <?php foreach ($grading_components as $component): ?>
                                <td>
                                    <input class="form-control custom-score" 
                                           name="custom_<?php echo $this->score_entry_model->sanitize_column_name($component['name']); ?>_<?php echo $student['student_id']; ?>"
                                           type="number"
                                           step="0.01"
                                           min="0"
                                           max="<?php echo $component['max_value']; ?>"
                                           data-max-value="<?php echo $component['max_value']; ?>"
                                           data-is-exam="<?php echo ($component['is_exam'] ? '1' : '0'); ?>"
                                           data-student-id="<?php echo $student['student_id']; ?>"
                                           placeholder="0">
                                </td>
                            <?php endforeach; ?>
                            <td>
                                <strong class="total-display" data-student-id="<?php echo $student['student_id']; ?>">0.00</strong>
                            </td>
                        <?php else: ?>
                            <td><input class="form-control class-score" name="class_score_<?php echo $student['student_id']; ?>" type="number" step="0.01" min="0" max="50" data-student-id="<?php echo $student['student_id']; ?>" placeholder="0" onchange="calculate_default_total(<?php echo $student['student_id']; ?>)"></td>
                            <td><input class="form-control exam-score" name="exam_score_<?php echo $student['student_id']; ?>" type="number" step="0.01" min="0" max="100" data-student-id="<?php echo $student['student_id']; ?>" placeholder="0" onchange="calculate_default_total(<?php echo $student['student_id']; ?>)"></td>
                            <td><strong class="total-display" data-student-id="<?php echo $student['student_id']; ?>">0.00</strong></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Hidden fields for form submission -->
    <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
    <input type="hidden" name="subject_id" value="<?php echo $subject_id; ?>">
    <input type="hidden" name="academic_term_id" value="<?php echo $academic_term_id; ?>">
    <input type="hidden" name="grading_structure_json" value="<?php echo htmlspecialchars(json_encode($grading_components)); ?>">
    
    <div class="form-group">
        <button type="button" class="btn btn-success" onclick="save_all_marks();"><?php echo get_phrase('Save All Scores'); ?></button>
    </div>
</form>

<?php if ($grading_components): ?>
<script>
// Calculate total for default grading (Class Score 50 + Exam/2 = 100)
function calculate_default_total(studentId) {
    var classScore = parseFloat($('input[name="class_score_' + studentId + '"]').val()) || 0;
    var examScore = parseFloat($('input[name="exam_score_' + studentId + '"]').val()) || 0;
    
    // Formula: Class Score (max 50) + Exam/2 (max 100/2 = 50) = 100
    var total = classScore + (examScore / 2);
    
    // Cap at 100
    total = Math.min(total, 100);
    
    // Update display
    $('.total-display[data-student-id="' + studentId + '"]').text(total.toFixed(2));
}

// Initialize real-time calculation for custom grading
$(document).ready(function() {
    var gradingStructure = <?php echo json_encode($grading_components); ?>;
    
    // Attach change event listeners to all score inputs
    $('.marks-row').each(function() {
        var studentId = $(this).data('student-id');
        var totalDisplay = $(this).find('.total-display[data-student-id="' + studentId + '"]');
        
        $(this).find('.custom-score').on('change keyup', function() {
            var scores = {};
            var row = $(this).closest('.marks-row');
            
            // Collect all scores for this student
            row.find('.custom-score').each(function() {
                var fieldName = $(this).attr('name');
                var match = fieldName.match(/custom_(.+?)_\d+$/);
                if (match) {
                    scores[match[1]] = parseFloat($(this).val()) || 0;
                }
            });
            
            // Calculate total using custom grading
            if (gradingCalc && typeof gradingCalc.calculateCustomTotal === 'function') {
                var customScores = scores;
                var total = gradingCalc.calculateCustomTotal({
                    custom_scores: customScores,
                    grading_components: gradingStructure
                });
                totalDisplay.text(total.toFixed(2));
            }
        });
    });
});
</script>
<?php endif; ?>

<?php endif; ?>
