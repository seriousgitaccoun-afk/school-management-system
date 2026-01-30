


<style>
    /* Student Marksheet Subject Styling */
    .marksheet-page-container {
        background: #f8f9fa;
        padding: 20px 0;
    }
    
    .marksheet-form-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        border: 1px solid #e4e7ea;
        margin-bottom: 30px;
    }
    
    .marksheet-form-header {
        background: linear-gradient(135deg, #03a9f3 0%, #0288d1 100%);
        color: white;
        padding: 20px;
        border-radius: 8px 8px 0 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .marksheet-form-header h4 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    
    .marksheet-form-body {
        padding: 30px;
    }
    
    .marksheet-form-group {
        margin-bottom: 20px;
    }
    
    .marksheet-form-label {
        label {
            font-weight: 600;
            color: #2b2b2b;
            font-size: 13px;
            letter-spacing: 0.3px;
            margin-bottom: 8px;
            display: block;
        }
    }
    
    .marksheet-form-input {
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
    
    .marksheet-info-box {
        background: #c8e6c9;
        border-left: 4px solid #00c292;
        padding: 14px 16px;
        border-radius: 4px;
        color: #00600d;
        font-size: 13px;
        font-weight: 500;
    }
    
    .marksheet-hint {
        background: #e3f2fd;
        border-left: 4px solid #03a9f3;
        padding: 12px 16px;
        border-radius: 4px;
        color: #1565c0;
        font-size: 12px;
        margin-top: 15px;
    }
    
    .marksheet-table-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        border: 1px solid #e4e7ea;
        margin-bottom: 30px;
    }
    
    .marksheet-table-header {
        background: linear-gradient(135deg, #00c292 0%, #00897b 100%);
        color: white;
        padding: 20px;
        border-radius: 8px 8px 0 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .marksheet-table-header h4 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    
    .marksheet-subject-info {
        background: rgba(255,255,255,0.2);
        padding: 8px 12px;
        border-radius: 4px;
        font-size: 13px;
        margin-left: auto;
    }
    
    .marksheet-table-body {
        padding: 20px;
        overflow-x: auto;
    }
    
    .marksheet-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
        
        thead {
            tr {
                background: #f0f4f8;
                border-bottom: 2px solid #e4e7ea;
                
                th {
                    padding: 12px 8px;
                    text-align: left;
                    font-weight: 600;
                    color: #2b2b2b;
                    font-size: 11px;
                    letter-spacing: 0.4px;
                    text-transform: uppercase;
                    line-height: 1.4;
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
                    padding: 12px 8px;
                    font-size: 12px;
                    color: #686868;
                    vertical-align: middle;
                }
            }
        }
    }
    
    .score-input {
        width: 100%;
        padding: 8px;
        border: 1px solid #d9dfe4;
        border-radius: 3px;
        font-size: 12px;
        text-align: center;
        transition: all 0.2s ease;
        
        &:focus {
            border-color: #03a9f3;
            box-shadow: 0 0 0 2px rgba(3, 169, 243, 0.1);
            outline: none;
        }
    }
    
    .comment-input {
        width: 100%;
        padding: 8px;
        border: 1px solid #d9dfe4;
        border-radius: 3px;
        font-size: 12px;
        transition: all 0.2s ease;
        
        &:focus {
            border-color: #03a9f3;
            box-shadow: 0 0 0 2px rgba(3, 169, 243, 0.1);
            outline: none;
        }
    }
    
    .total-display {
        font-weight: 600;
        color: #00c292;
        display: block;
    }
    
    .empty-state {
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
    
    .save-button {
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
            
            &:hover:not(:disabled) {
                box-shadow: 0 4px 12px rgba(0, 194, 146, 0.3);
                transform: translateY(-1px);
            }
            
            &:disabled {
                opacity: 0.7;
                cursor: not-allowed;
            }
        }
    }
    
    .success-message {
        background: #d4edda;
        border-left: 4px solid #00c292;
        padding: 14px 16px;
        border-radius: 4px;
        color: #155724;
        margin-bottom: 20px;
        display: none;
        
        i {
            margin-right: 8px;
            color: #00c292;
        }
    }
    
    .error-message {
        background: #ffcdd2;
        border-left: 4px solid #f44236;
        padding: 14px 16px;
        border-radius: 4px;
        color: #b71c1c;
        margin-bottom: 20px;
        display: none;
        
        i {
            margin-right: 8px;
            color: #f44236;
        }
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .marksheet-form-body {
            padding: 20px;
        }
        
        .marksheet-table-body {
            padding: 15px;
        }
        
        .marksheet-table {
            font-size: 11px;
            
            thead th,
            tbody td {
                padding: 8px 6px;
            }
        }
        
        .score-input {
            padding: 6px;
            font-size: 11px;
        }
    }
</style>

<div class="marksheet-page-container">
    <!-- FILTER FORM -->
    <div class="row">
        <div class="col-sm-12">
            <div class="marksheet-form-card">
                <div class="marksheet-form-header">
                    <i class="fa fa-book"></i>
                    <h4><?php echo get_phrase('Enter Student Score');?></h4>
                </div>
                <div class="marksheet-form-body">
                    
                    <div id="error_message" class="error-message"></div>
                    
                    <form id="selection_form" class="form-horizontal" onsubmit="return validate_selection();">
                    
                        <div class="row">
                            <!-- Academic Year Selector -->
                            <div class="col-md-6">
                                <div class="marksheet-form-group marksheet-form-label">
                                    <label><?php echo get_phrase('Academic Year');?> <span style="color: #f44236;">*</span></label>
                                    <div class="marksheet-form-input">
                                        <select id="academic_year_id" name="academic_year_id" class="form-control" onchange="load_terms()">
                                            <option value="">Select Academic Year</option>
                                            <?php if(isset($all_academic_years) && !empty($all_academic_years)): ?>
                                                <?php foreach($all_academic_years as $year): ?>
                                                    <option value="<?php echo $year['academic_year_id']; ?>" <?php if(isset($current_year) && $current_year['academic_year_id'] == $year['academic_year_id']) echo 'selected="selected"'; ?>>
                                                        <?php echo $year['year_name']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Academic Term Selector -->
                            <div class="col-md-6">
                                <div class="marksheet-form-group marksheet-form-label">
                                    <label><?php echo get_phrase('Academic Term');?> <span style="color: #f44236;">*</span></label>
                                    <div class="marksheet-form-input">
                                        <select id="academic_term_id" name="academic_term_id" class="form-control" onchange="load_subjects()">
                                            <option value="">Select Academic Term</option>
                                            <?php if(isset($current_term) && !empty($current_term)): ?>
                                                <option value="<?php echo $current_term['academic_term_id']; ?>" selected="selected">
                                                    <?php echo $current_term['term_name']; ?>
                                                </option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Subject Selector -->
                            <div class="col-md-6">
                                <div class="marksheet-form-group marksheet-form-label">
                                    <label><?php echo get_phrase('Subject');?> <span style="color: #f44236;">*</span></label>
                                    <div class="marksheet-form-input">
                                        <select id="subject_id" name="subject_id" class="form-control" onchange="load_classes()">
                                            <option value="">Select Subject</option>
                                            <?php if(isset($teacher_subjects) && !empty($teacher_subjects)): ?>
                                                <?php foreach($teacher_subjects as $subject): ?>
                                                    <option value="<?php echo $subject['subject_id']; ?>" <?php if(isset($subject_id) && $subject_id == $subject['subject_id']) echo 'selected="selected"'; ?>>
                                                        <?php echo $subject['name']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <option value="">No subjects assigned</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Class Selector -->
                            <div class="col-md-6">
                                <?php if (!isset($is_class_teacher) || !$is_class_teacher): ?>
                                <!-- For Subject Teachers: Show dropdown -->
                                <div class="marksheet-form-group marksheet-form-label">
                                    <label><?php echo get_phrase('class');?> <span style="color: #f44236;">*</span></label>
                                    <div class="marksheet-form-input">
                                        <select id="class_id" name="class_id" class="form-control" onchange="load_marksheet()">
                                            <option value="">Select Class</option>
                                            <?php if(isset($teacher_classes) && !empty($teacher_classes)): ?>
                                                <?php foreach($teacher_classes as $class): ?>
                                                    <option value="<?php echo $class['class_id']; ?>" <?php if(isset($class_id) && $class_id == $class['class_id']) echo 'selected="selected"'; ?>>
                                                        <?php echo $class['name']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <option value="">No classes assigned</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <?php else: ?>
                                <!-- For Class Teachers: Show info box -->
                                <input type="hidden" id="class_id" name="class_id" value="<?php echo isset($assigned_class_id) ? $assigned_class_id : '';?>" />
                                <div class="marksheet-form-group marksheet-form-label">
                                    <label><?php echo get_phrase('class');?></label>
                                    <div class="marksheet-info-box">
                                        <strong><?php echo get_phrase('Your Class:');?></strong>
                                        <?php if(isset($teacher_classes) && !empty($teacher_classes)): ?>
                                            <?php echo $teacher_classes[0]['name']; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="marksheet-hint">
                            <i class="fa fa-info-circle"></i> Select Year → Term → Subject → Class to view and enter student scores
                        </div>
                        
                    </form>
                </div>                
            </div>
        </div>
    </div>

    <?php if(isset($class_id) && $class_id > 0 && isset($subject_id) && $subject_id > 0 && isset($academic_term_id) && $academic_term_id > 0):?>

    <!-- MARKSHEET TABLE -->
    <div class="row" id="marksheet_container">
        <div class="col-sm-12">
            <div class="marksheet-table-card">
                <div class="marksheet-table-header">
                    <i class="fa fa-list"></i>
                    <h4>
                        <span id="subject_title"><?php 
                            if(isset($teacher_subjects) && !empty($teacher_subjects)) {
                                foreach($teacher_subjects as $s) {
                                    if($s['subject_id'] == $subject_id) {
                                        echo htmlspecialchars($s['name']);
                                        break;
                                    }
                                }
                            }
                        ?></span> 
                        in 
                        <span id="class_title"><?php 
                            if(isset($teacher_classes) && !empty($teacher_classes)) {
                                foreach($teacher_classes as $c) {
                                    if($c['class_id'] == $class_id) {
                                        echo htmlspecialchars($c['name']);
                                        break;
                                    }
                                }
                            }
                        ?></span>
                    </h4>
                    <div class="marksheet-subject-info">
                        <small>Term: <span id="term_title"><?php 
                            if(isset($current_term)) {
                                echo htmlspecialchars($current_term['term_name']);
                            }
                        ?></span></small>
                    </div>
                </div>
                <div class="marksheet-table-body">
                    <form id="score_form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                    
                        <div class="success-message" id="error_message"></div>
                        
                        <?php 
                            if(isset($students) && !empty($students)): 
                        ?>
                            <table class="marksheet-table">
                                <thead>
                                    <tr>
                                        <th width="18%"><?php echo get_phrase('student');?></th>
                                        <th width="8%"><small>EMT 1<br/>(0-10)</small></th>
                                        <th width="8%"><small>EMT 2<br/>(0-10)</small></th>
                                        <th width="8%"><small>EMT 3<br/>(0-10)</small></th>
                                        <th width="8%"><small>SBA<br/>(0-10)</small></th>
                                        <th width="8%"><small>Project<br/>(0-10)</small></th>
                                        <th width="8%"><small>Exam<br/>(0-70)</small></th>
                                        <th width="8%"><strong>Total</strong></th>
                                        <th width="18%"><?php echo get_phrase('comment');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        foreach($students as $student):
                                            $score_data = $this->db->where('student_id', $student['student_id'])
                                                                  ->where('class_id', $class_id)
                                                                  ->where('subject_id', $subject_id)
                                                                  ->where('exam_id', $academic_term_id)
                                                                  ->get('mark')
                                                                  ->row_array();
                                            if(!$score_data) {
                                                $score_data = array(
                                                    'class_score1' => '',
                                                    'class_score2' => '',
                                                    'class_score3' => '',
                                                    'exam_score' => '',
                                                    'comment' => '',
                                                    'mark_id' => ''
                                                );
                                            }
                                    ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($student['name']); ?></strong></td>
                                        <td>
                                            <input type="number" class="score-input emt-score" min="0" max="10" step="0.01" value="<?php echo $score_data['class_score1'] ?: '';?>" name="emt1_<?php echo $student['student_id'];?>" placeholder="0" data-student="<?php echo $student['student_id'];?>">
                                        </td>
                                        <td>
                                            <input type="number" class="score-input emt-score" min="0" max="10" step="0.01" value="<?php echo $score_data['class_score2'] ?: '';?>" name="emt2_<?php echo $student['student_id'];?>" placeholder="0" data-student="<?php echo $student['student_id'];?>">
                                        </td>
                                        <td>
                                            <input type="number" class="score-input emt-score" min="0" max="10" step="0.01" value="<?php echo $score_data['class_score3'] ?: '';?>" name="emt3_<?php echo $student['student_id'];?>" placeholder="0" data-student="<?php echo $student['student_id'];?>">
                                        </td>
                                        <td>
                                            <input type="number" class="score-input" min="0" max="10" step="0.01" value="" name="sba_<?php echo $student['student_id'];?>" placeholder="0">
                                        </td>
                                        <td>
                                            <input type="number" class="score-input" min="0" max="10" step="0.01" value="" name="project_<?php echo $student['student_id'];?>" placeholder="0">
                                        </td>
                                        <td>
                                            <input type="number" class="score-input exam-score" min="0" max="70" step="0.01" value="<?php echo $score_data['exam_score'] ?: '';?>" name="exam_<?php echo $student['student_id'];?>" placeholder="0" data-student="<?php echo $student['student_id'];?>">
                                        </td>
                                        <td>
                                            <strong class="total-display" data-student="<?php echo $student['student_id'];?>"><?php echo $score_data['total_score'] ?: '0.00'; ?></strong>
                                        </td>
                                        <td>
                                            <textarea name="teacher_comment_<?php echo $student['student_id'];?>" class="comment-input" rows="1" placeholder="Comment..."><?php echo $score_data['comment'] ?: '';?></textarea>
                                        </td>
                                        <input type="hidden" name="score_entry_id_<?php echo $student['student_id']; ?>" value="<?php echo $score_data['mark_id'] ?: '';?>" />
                                        <input type="hidden" name="student_id_<?php echo $student['student_id']; ?>" value="<?php echo $student['student_id'];?>" />
                                    </tr>
                                    <?php 
                                        endforeach;
                                    ?>
                                </tbody>
                            </table>

                            <input type="hidden" name="academic_term_id" value="<?php echo $academic_term_id;?>" />
                            <input type="hidden" name="class_id" value="<?php echo $class_id;?>" />
                            <input type="hidden" name="subject_id" value="<?php echo $subject_id;?>" />
                            <input type="hidden" name="operation" value="save_scores" />
                            
                            <div class="save-button">
                                <button type="button" id="save_button" onclick="save_all_scores()">
                                    <i class="fa fa-save"></i>&nbsp;<?php echo get_phrase('update_marks');?>
                                </button>
                            </div>
                        <?php 
                        else:
                        ?>
                            <div class="empty-state">
                                <i class="fa fa-inbox"></i>
                                <p>No students in this class</p>
                            </div>
                        <?php endif; ?>
                 
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php endif;?>
</div>

<script type="text/javascript">
    /**
     * Validate selection form
     */
    function validate_selection() {
        var year = $('#academic_year_id').val();
        var term = $('#academic_term_id').val();
        var subject = $('#subject_id').val();
        var class_val = $('#class_id').val();
        
        if (!year || !term || !subject || !class_val) {
            alert('Please select Academic Year, Term, Subject, and Class');
            return false;
        }
        return true;
    }

    /**
     * Load academic terms when year is selected
     */
    function load_terms() {
        var academic_year_id = $('#academic_year_id').val();
        
        if (!academic_year_id) {
            $('#academic_term_id').html('<option value="">Select Academic Term</option>');
            $('#subject_id').html('<option value="">Select Subject</option>');
            $('#class_id').html('<option value="">Select Class</option>');
            return;
        }

        $.ajax({
            url: '<?php echo base_url(); ?>report/get_academic_terms',
            type: 'POST',
            dataType: 'JSON',
            data: { academic_year_id: academic_year_id },
            success: function(response) {
                var options = '<option value="">Select Academic Term</option>';
                if (response.length > 0) {
                    response.forEach(function(term) {
                        options += '<option value="' + term.academic_term_id + '">' + term.term_name + '</option>';
                    });
                }
                $('#academic_term_id').html(options);
                $('#subject_id').html('<option value="">Select Subject</option>');
                $('#class_id').html('<option value="">Select Class</option>');
            },
            error: function() {
                alert('Error loading terms');
            }
        });
    }

    /**
     * Load subjects when term is selected
     */
    function load_subjects() {
        var term_id = $('#academic_term_id').val();
        if (!term_id) {
            $('#subject_id').html('<option value="">Select Subject</option>');
            $('#class_id').html('<option value="">Select Class</option>');
            return;
        }
        // Subjects are already loaded from the server, just show them
        // (Could be enhanced with AJAX if needed)
    }

    /**
     * Load classes when subject is selected
     */
    function load_classes() {
        var subject_id = $('#subject_id').val();
        if (!subject_id) {
            $('#class_id').html('<option value="">Select Class</option>');
            return;
        }
        // Classes are already loaded from the server, just show them
        // (Could be enhanced with AJAX if needed)
    }

    /**
     * Load marksheet - redirect to full page view
     */
    function load_marksheet() {
        var year = $('#academic_year_id').val();
        var term = $('#academic_term_id').val();
        var subject = $('#subject_id').val();
        var class_val = $('#class_id').val();
        
        if (year && term && subject && class_val) {
            window.location.href = '<?php echo base_url(); ?>teacher/student_marksheet_subject/' + year + '/' + term + '/' + class_val + '/' + subject;
        }
    }

    /**
     * Calculate total score in real-time
     */
    $(document).ready(function() {
        // Bind change events to all score inputs
        $(document).on('change input', '.emt-score, .exam-score', function() {
            var student_id = $(this).data('student');
            calculate_total(student_id);
        });
    });

    /**
     * Calculate and display total for a student
     */
    function calculate_total(student_id) {
        var emt1 = parseFloat($('input[name="emt1_score_' + student_id + '"]').val()) || 0;
        var emt2 = parseFloat($('input[name="emt2_score_' + student_id + '"]').val()) || 0;
        var emt3 = parseFloat($('input[name="emt3_score_' + student_id + '"]').val()) || 0;
        var exam = parseFloat($('input[name="exam_score_' + student_id + '"]').val()) || 0;
        
        // Formula: (EMT1 + EMT2 + EMT3) / 3 * 0.5 + Exam * 0.5
        var class_score = (emt1 + emt2 + emt3) / 3;
        var total = (class_score * 0.5) + (exam * 0.5);
        
        // Display with 2 decimal places
        $('.total-display[data-student="' + student_id + '"]').text(total.toFixed(2));
    }

    /**
     * Save all scores via AJAX
     */
    function save_all_scores() {
        if (!validate_selection()) {
            return false;
        }

        // Show loading indicator
        var btn = $('#save_button');
        btn.prop('disabled', true);
        btn.html('<i class="fa fa-spinner fa-spin"></i> Saving...');

        var form_data = $('#score_form').serialize();
        form_data += '&operation=save_scores';

        $.ajax({
            url: '<?php echo base_url(); ?>teacher/save_subject_marks',
            type: 'POST',
            dataType: 'JSON',
            timeout: 10000,  // 10 second timeout
            data: form_data,
            success: function(response) {
                var message_box = $('#error_message');
                if (response.success) {
                    message_box.removeClass('error-message').addClass('success-message');
                    message_box.html('<i class="fa fa-check"></i> <strong>Success!</strong> ' + response.message);
                    message_box.show();
                } else {
                    message_box.removeClass('success-message').addClass('error-message');
                    var errors = response.errors && response.errors.length > 0 ? response.errors.join('<br>') : 'Unknown error occurred';
                    message_box.html('<i class="fa fa-warning"></i> <strong>Warning!</strong> ' + response.message + '<br>' + errors);
                    message_box.show();
                }
                setTimeout(function() {
                    message_box.fadeOut();
                }, 5000);
            },
            error: function(xhr, status, error) {
                console.log('AJAX Error - Status:', status, 'Error:', error);
                console.log('Response:', xhr.responseText);
                var message_box = $('#error_message');
                message_box.removeClass('success-message').addClass('error-message');
                message_box.html('<i class="fa fa-times"></i> <strong>Error!</strong> Failed to save scores. ' + (error || 'Please try again.'));
                message_box.show();
            },
            complete: function() {
                // Re-enable button
                btn.prop('disabled', false);
                btn.html('<i class="fa fa-save"></i>&nbsp;<?php echo get_phrase('update_marks');?>');
            }
        });
    }
</script>