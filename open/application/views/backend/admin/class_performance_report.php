<?php
// Class Terminal Reports - Compiled Document
// Admin generates individual terminal reports for all students in a class as one compiled document
// Each student's report fits on one A4 page with page breaks between students
?>

<div id="report-selection-section">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <i class="fa fa-file-text"></i>&nbsp;&nbsp;<?php echo get_phrase('Class Terminal Reports - Compiled'); ?>
                </div>
                <div class="panel-body">
                <?php if ($this->session->flashdata('error_message')): ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="fa fa-warning"></i>&nbsp;
                        <?php echo $this->session->flashdata('error_message'); ?>
                    </div>
                <?php endif; ?>

                <!---- Selection Form ---->
                <?php echo form_open(base_url() . 'report/class_performance_report', array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>
                
                    <!-- Academic Year Selection -->
                    <div class="form-group">
                        <label class="col-md-3" for="academic_year_id"><?php echo get_phrase('Academic Year'); ?></label>
                        <div class="col-sm-9">
                            <select name="academic_year_id" id="academic_year_id" class="form-control select2" required onchange="load_academic_terms_class()">
                                <option value=""><?php echo get_phrase('Select Academic Year'); ?></option>
                                <?php if (!empty($all_academic_years)): ?>
                                    <?php foreach ($all_academic_years as $year): ?>
                                        <option value="<?php echo $year->academic_year_id; ?>" 
                                            <?php if ($academic_year_id == $year->academic_year_id) echo 'selected="selected"'; ?>>
                                            <?php echo $year->academic_year_title; ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Academic Term Selection -->
                    <div class="form-group">
                        <label class="col-md-3" for="academic_term_id"><?php echo get_phrase('Academic Term'); ?></label>
                        <div class="col-sm-9">
                            <select name="academic_term_id" id="academic_term_id" class="form-control select2" required>
                                <option value=""><?php echo get_phrase('Select Academic Term'); ?></option>
                                <?php if ($academic_year_id && !empty($all_academic_years)): 
                                    $selected_year = null;
                                    foreach ($all_academic_years as $year) {
                                        if ($year->academic_year_id == $academic_year_id) {
                                            $selected_year = $year;
                                            break;
                                        }
                                    }
                                    if ($selected_year):
                                        $terms = $this->db->where('academic_year_id', $academic_year_id)
                                                        ->order_by('academic_term_id', 'ASC')
                                                        ->get('academic_terms')
                                                        ->result_array();
                                        foreach ($terms as $term):
                                ?>
                                            <option value="<?php echo $term['academic_term_id']; ?>"
                                                <?php if ($academic_term_id == $term['academic_term_id']) echo 'selected="selected"'; ?>>
                                                <?php echo $term['term_name']; ?>
                                            </option>
                                <?php
                                        endforeach;
                                    endif;
                                endif;
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- Class Selection -->
                    <div class="form-group">
                        <label class="col-md-3" for="class_id"><?php echo get_phrase('Class'); ?></label>
                        <div class="col-sm-9">
                            <select name="class_id" id="class_id" class="form-control select2" required>
                                <option value=""><?php echo get_phrase('Select Class'); ?></option>
                                <?php
                                $classes = $this->db->get('class')->result_array();
                                foreach ($classes as $class):
                                ?>
                                    <option value="<?php echo $class['class_id']; ?>"
                                        <?php if ($class_id == $class['class_id']) echo 'selected="selected"'; ?>>
                                        <?php echo $class['name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <input type="hidden" name="operation" value="selection">
                    
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-info btn-block btn-rounded btn-sm">
                                <i class="fa fa-file-pdf-o"></i>&nbsp;<?php echo get_phrase('Generate Compiled Report'); ?>
                            </button>
                        </div>
                    </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<?php if ($academic_year_id > 0 && $academic_term_id > 0 && $class_id > 0): ?>
    <!-- Compiled Student Terminal Reports (One Page Per Student with Page Breaks) -->
    <?php
    // Get class and term details
    $class = $this->db->get_where('class', array('class_id' => $class_id))->row_array();
    $year = $this->db->get_where('academic_years', array('academic_year_id' => $academic_year_id))->row_array();
    $term = $this->db->get_where('academic_terms', array('academic_term_id' => $academic_term_id))->row_array();
    
    // Get all students in this class
    $all_students = $this->db->where('class_id', $class_id)
                              ->order_by('roll', 'ASC')
                              ->get('student')
                              ->result_array();
    
    // Get all subjects for this class
    $class_subjects = $this->db->get_where('class_subjects', array('class_id' => $class_id))->result_array();
    
    // Hide selection form when showing report
    echo '<style>#report-selection-section { display: none; }</style>';
    ?>

    <div id="print-section">
        <?php foreach ($all_students as $student_index => $student): 
            // Get student info
            $student_class = $this->db->get_where('class', array('class_id' => $student['class_id']))->row_array();
        ?>
            <!-- STUDENT REPORT PAGE - Each on A4 Page -->
            <div class="student-report-page" style="page-break-after: always; padding: 20px; background: white; margin-bottom: 20px; border: 1px solid #ddd; min-height: 297mm; font-family: Arial, sans-serif; color: #333; font-size: 13px;">
                
                <!-- HEADER: School Info & Dates -->
                <div style="text-align: center; margin-bottom: 15px; border-bottom: 2px solid #6c5ce7; padding-bottom: 10px;">
                    <!-- School Badge/Logo Space -->
                    <div style="margin-bottom: 8px;">
                        <div style="width: 50px; height: 50px; margin: 0 auto 5px; background: #6c5ce7; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 24px;">
                            🏫
                        </div>
                    </div>
                    
                    <!-- School Name -->
                    <h2 style="margin: 0 0 5px 0; color: #6c5ce7; font-size: 16px; font-weight: bold;">
                        <?php echo get_phrase('School Name'); ?>
                    </h2>
                    
                    <!-- Term & Year -->
                    <p style="margin: 3px 0; font-weight: bold; color: #333;">
                        <?php echo $term['term_name'] . ' - ' . $year['academic_year_title']; ?>
                    </p>
                    
                    <!-- Dates -->
                    <div style="margin-top: 8px; font-size: 11px; color: #666;">
                        <p style="margin: 2px 0;">
                            <strong>Vacation Date:</strong> [Enter Date] &nbsp;&nbsp;&nbsp;
                            <strong>Re-opening Date:</strong> [Enter Date]
                        </p>
                    </div>
                </div>

                <!-- STUDENT INFO & CLASS INFO -->
                <table style="width: 100%; margin-bottom: 15px; font-size: 12px;">
                    <tr>
                        <td style="width: 50%; vertical-align: top;">
                            <p style="margin: 3px 0;"><strong>Student Name:</strong> <?php echo $student['name']; ?></p>
                            <p style="margin: 3px 0;"><strong>Roll Number:</strong> <?php echo $student['roll']; ?></p>
                            <p style="margin: 3px 0;"><strong>Admission No:</strong> <?php echo isset($student['admission_number']) ? $student['admission_number'] : 'N/A'; ?></p>
                        </td>
                        <td style="width: 50%; vertical-align: top; text-align: right;">
                            <p style="margin: 3px 0;"><strong>Class:</strong> <?php echo $student_class['name']; ?></p>
                            <p style="margin: 3px 0;"><strong>Class Size:</strong> <?php echo count($all_students); ?></p>
                            <p style="margin: 3px 0;"><strong>Number on Roll:</strong> <?php echo count($all_students); ?></p>
                        </td>
                    </tr>
                </table>

                <!-- MARKS TABLE -->
                <table style="width: 100%; border-collapse: collapse; font-size: 12px; margin-bottom: 15px;">
                    <thead>
                        <tr style="background: #6c5ce7; color: white;">
                            <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Subject</th>
                            <th style="border: 1px solid #ddd; padding: 8px; text-align: center; width: 13%;">Class (50)</th>
                            <th style="border: 1px solid #ddd; padding: 8px; text-align: center; width: 13%;">Exam (100)</th>
                            <th style="border: 1px solid #ddd; padding: 8px; text-align: center; width: 13%;">Total (100)</th>
                            <th style="border: 1px solid #ddd; padding: 8px; text-align: center; width: 12%;">Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total_scores = [];
                        foreach ($class_subjects as $class_subject):
                            $subject = $this->db->get_where('subject', array('subject_id' => $class_subject['subject_id']))->row_array();
                            
                            // Get student scores for this subject
                            $score = $this->db->where([
                                'student_id' => $student['student_id'],
                                'academic_term_id' => $academic_term_id,
                                'subject_id' => $class_subject['subject_id']
                            ])->get('score_entry')->row_array();

                            if ($score):
                                $class_score = isset($score['custom_class_score']) ? $score['custom_class_score'] : 0;
                                $exam_score = isset($score['custom_exam_score']) ? $score['custom_exam_score'] : 0;
                                
                                // Calculate total using the formula: Class Score (50) + Exam Score/2 (50) = 100
                                $total_score = $class_score + ($exam_score / 2);
                                $total_score = min(100, $total_score);
                                
                                $total_scores[] = $total_score;
                                
                                // Get grading info
                                $grade_info = $this->db->where('max_score >=', $total_score)
                                                       ->order_by('max_score', 'ASC')
                                                       ->limit(1)
                                                       ->get('grade')
                                                       ->row_array();
                                
                                $grade = $grade_info ? $grade_info['grade'] : 'N/A';
                        ?>
                            <tr style="border: 1px solid #ddd;">
                                <td style="border: 1px solid #ddd; padding: 8px;"><?php echo $subject['name']; ?></td>
                                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;"><?php echo number_format($class_score, 1); ?></td>
                                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;"><?php echo number_format($exam_score, 1); ?></td>
                                <td style="border: 1px solid #ddd; padding: 8px; text-align: center; font-weight: bold; color: #6c5ce7;">
                                    <?php echo number_format($total_score, 1); ?>
                                </td>
                                <td style="border: 1px solid #ddd; padding: 8px; text-align: center; font-weight: bold;">
                                    <?php echo $grade; ?>
                                </td>
                            </tr>
                        <?php
                            else:
                        ?>
                            <tr style="border: 1px solid #ddd; background: #f5f5f5;">
                                <td colspan="5" style="border: 1px solid #ddd; padding: 8px; text-align: center; color: #999;">
                                    <?php echo $subject['name']; ?> - <?php echo get_phrase('No scores entered'); ?>
                                </td>
                            </tr>
                        <?php
                            endif;
                        endforeach;
                        ?>
                    </tbody>
                </table>

                <!-- OVERALL PERFORMANCE SUMMARY -->
                <?php if (!empty($total_scores) && count($total_scores) > 0): ?>
                    <div style="background: #f0f0f0; padding: 8px; border: 1px solid #ddd; margin-bottom: 15px; font-size: 11px; text-align: right;">
                        <strong>Average Score:</strong> <span style="color: #6c5ce7; font-weight: bold; font-size: 12px;">
                            <?php echo number_format(array_sum($total_scores) / count($total_scores), 1); ?> / 100
                        </span>
                    </div>
                <?php endif; ?>

                <!-- TEACHER COMMENTS SECTION -->
                <div style="margin-bottom: 15px;">
                    <div style="background: #6c5ce7; color: white; padding: 5px 8px; font-weight: bold; font-size: 11px; margin-bottom: 5px;">
                        CLASS TEACHER'S COMMENTS
                    </div>
                    <div style="border: 1px solid #ddd; padding: 10px; min-height: 40px; background: #fafafa; font-size: 11px; line-height: 1.6;">
                        [Teacher will add comments here]
                    </div>
                </div>

                <!-- HEADMASTER COMMENTS SECTION -->
                <div style="margin-bottom: 15px;">
                    <div style="background: #6c5ce7; color: white; padding: 5px 8px; font-weight: bold; font-size: 11px; margin-bottom: 5px;">
                        HEADMASTER'S COMMENTS
                    </div>
                    <div style="border: 1px solid #ddd; padding: 10px; min-height: 40px; background: #fafafa; font-size: 11px; line-height: 1.6;">
                        [Headmaster will add comments here]
                    </div>
                </div>

                <!-- FOOTER -->
                <div style="margin-top: 10px; padding-top: 8px; border-top: 1px solid #ddd; font-size: 10px; text-align: center; color: #999;">
                    <p style="margin: 3px 0;">Generated on <?php echo date('j F Y'); ?></p>
                </div>
            </div>

        <?php endforeach; ?>
    </div>

    <!-- Print Controls -->
    <div style="text-align: center; padding: 20px; background: white; position: relative; z-index: 1000;">
        <button class="btn btn-primary btn-sm" onclick="window.print()">
            <i class="fa fa-print"></i>&nbsp;<?php echo get_phrase('Print All Reports'); ?>
        </button>
        <a href="<?php echo base_url('report/class_performance_report'); ?>" class="btn btn-default btn-sm">
            <i class="fa fa-arrow-left"></i>&nbsp;<?php echo get_phrase('Back to Selection'); ?>
        </a>
    </div>

    <style type="text/css">
        @media print {
            #report-selection-section { display: none; }
            .btn { display: none; }
            .navbar, .sidebar, .footer { display: none; }
            body { margin: 0; padding: 0; background: white; }
            .student-report-page { page-break-after: always; margin-bottom: 0; min-height: auto; }
        }
    </style>

<?php endif; ?>

<script type="text/javascript">
    var base_url = '<?php echo base_url(); ?>';

    // Load academic terms when year changes for class report
    function load_academic_terms_class() {
        var academic_year_id = $('#academic_year_id').val();
        if (academic_year_id) {
            $.ajax({
                url: base_url + 'report/get_academic_terms/' + academic_year_id,
                type: 'GET',
                dataType: 'html',
                success: function(response) {
                    $('#academic_term_id').html(response);
                }
            });
        }
    }
</script>
