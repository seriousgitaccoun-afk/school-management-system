<?php 
// Get teacher ID and current user info
$teacher_id = $this->session->userdata('user_id');
?>

<?php if(empty($subjects)): ?>
    <div class="alert alert-info">No subjects found for this class.</div>
<?php else: ?>
    <form id="score_form_student">
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th colspan="100" style="text-align: center;">Assessment Components</th>
                    <th>Total</th>
                    <th>Comment</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($subjects as $subject):
                    // find existing score entry
                    $entry = null;
                    foreach($scores as $s) {
                        if ($s['subject_id'] == $subject['subject_id']) { $entry = $s; break; }
                    }
                    
                    // Get grading structure for this subject
                    $grading_structure = null;
                    if ($teacher_id && $subject['subject_id']) {
                        $grading_structure = $this->score_entry_model->get_grading_structure($teacher_id, $subject['subject_id']);
                    }
                    $grading_components = $grading_structure ? json_decode($grading_structure, true) : null;
                ?>
                <tr class="score-row" data-subject-id="<?php echo $subject['subject_id']; ?>" data-grading-custom="<?php echo ($grading_components ? 'true' : 'false'); ?>">
                    <td><strong><?php echo htmlspecialchars($subject['subject_name']); ?></strong><br><small data-grading-json='<?php echo htmlspecialchars(json_encode($grading_components)); ?>'></small></td>
                    <?php if ($grading_components && is_array($grading_components)): ?>
                        <?php foreach ($grading_components as $component): ?>
                            <?php 
                                $sanitized_name = $this->score_entry_model->sanitize_column_name($component['name']);
                                $field_name = 'custom_' . $sanitized_name . '_' . $subject['subject_id'];
                                // Try to get the value from the entry if it exists
                                $value = '';
                                if ($entry && isset($entry[$field_name])) {
                                    $value = $entry[$field_name];
                                }
                            ?>
                            <td>
                                <label style="display: block; font-size: 11px; margin-bottom: 2px;">
                                    <?php echo htmlspecialchars($component['name']); ?>
                                    <?php if ($component['is_exam']): ?>
                                        <span class="badge badge-info" style="font-size: 9px;">Exam</span>
                                    <?php else: ?>
                                        <span style="color: #888; font-size: 9px;">Max: <?php echo $component['max_value']; ?></span>
                                    <?php endif; ?>
                                </label>
                                <input class="form-control custom-score"
                                       name="<?php echo $field_name; ?>"
                                       type="number"
                                       step="0.01"
                                       min="0"
                                       max="<?php echo $component['max_value']; ?>"
                                       value="<?php echo $value; ?>"
                                       data-max-value="<?php echo $component['max_value']; ?>"
                                       data-is-exam="<?php echo ($component['is_exam'] ? '1' : '0'); ?>"
                                       data-subject-id="<?php echo $subject['subject_id']; ?>"
                                       style="font-size: 12px; padding: 4px;">
                            </td>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <td><label style="font-size: 11px;">EMT1</label><input class="form-control emt-score" name="emt1_<?php echo $subject['subject_id']; ?>" value="<?php echo $entry ? $entry['emt1_score'] : ''; ?>" type="number" step="0.01" min="0" max="100" style="font-size: 12px; padding: 4px;"></td>
                        <td><label style="font-size: 11px;">EMT2</label><input class="form-control emt-score" name="emt2_<?php echo $subject['subject_id']; ?>" value="<?php echo $entry ? $entry['emt2_score'] : ''; ?>" type="number" step="0.01" min="0" max="100" style="font-size: 12px; padding: 4px;"></td>
                        <td><label style="font-size: 11px;">EMT3</label><input class="form-control emt-score" name="emt3_<?php echo $subject['subject_id']; ?>" value="<?php echo $entry ? $entry['emt3_score'] : ''; ?>" type="number" step="0.01" min="0" max="100" style="font-size: 12px; padding: 4px;"></td>
                        <td><label style="font-size: 11px;">SBA</label><input class="form-control" name="sba_<?php echo $subject['subject_id']; ?>" value="<?php echo $entry ? $entry['sba_assessment_score'] : ''; ?>" type="number" step="0.01" min="0" max="100" style="font-size: 12px; padding: 4px;"></td>
                        <td><label style="font-size: 11px;">Project</label><input class="form-control" name="project_<?php echo $subject['subject_id']; ?>" value="<?php echo $entry ? $entry['project_score'] : ''; ?>" type="number" step="0.01" min="0" max="100" style="font-size: 12px; padding: 4px;"></td>
                        <td><label style="font-size: 11px;">Exam</label><input class="form-control exam-score" name="exam_<?php echo $subject['subject_id']; ?>" value="<?php echo $entry ? $entry['exam_score'] : ''; ?>" type="number" step="0.01" min="0" max="100" style="font-size: 12px; padding: 4px;"></td>
                    <?php endif; ?>
                    <td><strong class="total-display" data-subject="<?php echo $subject['subject_id']; ?>"><?php echo $entry ? $entry['total_score'] : '0.00'; ?></strong></td>
                    <td><input class="form-control" name="comment_<?php echo $subject['subject_id']; ?>" value="<?php echo $entry ? $entry['teacher_comment'] : ''; ?>" style="font-size: 12px; padding: 4px;"></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
    <input type="hidden" name="academic_term_id" value="<?php echo $academic_term_id; ?>">
    <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
    <div class="form-group">
        <button type="button" class="btn btn-success" onclick="save_student_scores()">Save All Scores</button>
    </div>
    </form>

<script>
// Initialize real-time calculation for custom and default grading
$(document).ready(function() {
    // Handle both custom and default grading for each subject row
    $('.score-row').each(function() {
        var subjectId = $(this).data('subject-id');
        var isCustom = $(this).data('grading-custom') === 'true';
        var totalDisplay = $(this).find('.total-display[data-subject="' + subjectId + '"]');
        var gradingJsonEl = $(this).find('small[data-grading-json]');
        var gradingStructure = null;
        
        if (isCustom && gradingJsonEl.length) {
            try {
                gradingStructure = JSON.parse(gradingJsonEl.attr('data-grading-json'));
            } catch(e) {
                gradingStructure = null;
            }
        }
        
        // Attach change event listeners
        $(this).find('.custom-score, .emt-score, .exam-score').on('change keyup', function() {
            var row = $(this).closest('.score-row');
            var total = 0;
            
            if (isCustom && gradingStructure) {
                // Custom grading: collect scores and calculate
                var customScores = {};
                row.find('.custom-score').each(function() {
                    var fieldName = $(this).attr('name');
                    var match = fieldName.match(/custom_(.+?)_\d+$/);
                    if (match) {
                        customScores[match[1]] = parseFloat($(this).val()) || 0;
                    }
                });
                
                if (gradingCalc && typeof gradingCalc.calculateCustomTotal === 'function') {
                    total = gradingCalc.calculateCustomTotal({
                        custom_scores: customScores,
                        grading_components: gradingStructure
                    });
                }
            } else {
                // Default grading (EMT1, EMT2, EMT3, Exam)
                var emt1 = parseFloat(row.find('input[name="emt1_' + subjectId + '"]').val()) || 0;
                var emt2 = parseFloat(row.find('input[name="emt2_' + subjectId + '"]').val()) || 0;
                var emt3 = parseFloat(row.find('input[name="emt3_' + subjectId + '"]').val()) || 0;
                var exam = parseFloat(row.find('input[name="exam_' + subjectId + '"]').val()) || 0;
                
                if (gradingCalc && typeof gradingCalc.calculateDefaultTotal === 'function') {
                    total = gradingCalc.calculateDefaultTotal({
                        emt1: emt1,
                        emt2: emt2,
                        emt3: emt3,
                        exam: exam
                    });
                } else {
                    // Fallback calculation if gradingCalc not available
                    var classScore = (emt1 + emt2 + emt3) / 3;
                    total = (classScore * 0.5) + (exam / 2);
                }
            }
            
            totalDisplay.text(Math.min(total, 100).toFixed(2));
        });
    });
});
</script>

<?php endif; ?>
