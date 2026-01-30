<?php
// Student Terminal Report Selection Form
// Admin view to select parameters and generate terminal reports
?>

<style>
    .report-container {
        width: 95%;
        max-width: 1000px;
        background: white;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        border-radius: 4px;
        overflow: hidden;
        margin: 20px auto;
    }

    /* Header Styling */
    .report-header {
        background: linear-gradient(to right, #4a90e2, #7eb6ff);
        color: white;
        padding: 25px 30px;
        display: flex;
        align-items: center;
        font-weight: bold;
        font-size: 1.4rem;
        font-family: Poppins, sans-serif;
    }

    .report-header i { margin-right: 14px; font-size: 1.5rem; }

    /* Form Layout */
    .report-form-content {
        padding: 30px;
        font-family: Poppins, sans-serif;
    }

    .form-row {
        display: grid;
        grid-template-columns: 0.6fr 1.4fr;
        gap: 25px;
        padding: 22px 0;
        border-bottom: 1px solid #f0f0f0;
        align-items: center;
    }

    .form-row:last-of-type { border-bottom: none; }

    .label-group {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        color: #555;
        font-size: 13.5pt;
        font-weight: 500;
        font-family: Poppins, sans-serif;
        padding-left: 0;
    }

    /* Highlighted blue labels */
    .blue-label {
        color: #2daae1;
        margin-right: 10px;
        font-weight: 600;
    }

    /* Dropdown Styling */
    .report-form-content select {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #ddd;
        border-radius: 3px;
        background-color: #fff;
        color: #333;
        outline: none;
        font-size: 13.5pt;
        font-family: Poppins, sans-serif;
    }

    .report-form-content select:focus {
        border-color: #2daae1;
        box-shadow: 0 0 5px rgba(45, 170, 225, 0.3);
    }

    /* Button Styling */
    .btn-container {
        padding: 0 30px 30px 30px;
    }

    .generate-btn {
        width: 100%;
        background-color: #00aeef;
        color: white;
        border: none;
        padding: 14px 24px;
        border-radius: 25px;
        font-size: 14pt;
        font-weight: bold;
        font-family: Poppins, sans-serif;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: all 0.3s ease;
    }

    .generate-btn:hover {
        background-color: #008fca;
        box-shadow: 0 4px 10px rgba(0, 143, 202, 0.3);
    }

    .generate-btn i {
        margin-right: 10px;
    }

    /* Alert styling */
    .alert-box {
        margin: 20px auto;
        width: 95%;
        max-width: 1000px;
        font-family: Poppins, sans-serif;
        font-size: 13.5pt;
    }

    /* Checkbox styling */
    .checkbox-row {
        display: flex;
        align-items: center;
        justify-content: flex-start;
    }

    .checkbox-row input[type="checkbox"] {
        width: 20px;
        height: 20px;
        margin-right: 12px;
        cursor: pointer;
    }

    .checkbox-row label {
        margin: 0;
        font-size: 13.5pt;
        font-weight: 500;
        cursor: pointer;
        color: #555;
    }
</style>

<div class="alert-box">
    <?php if ($this->session->flashdata('error_message')): ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="fa fa-warning"></i>&nbsp;
            <?php echo $this->session->flashdata('error_message'); ?>
        </div>
    <?php endif; ?>
</div>

<div class="report-container">
    <div class="report-header">
        <i class="fa fa-graduation-cap"></i> 
        <?php echo get_phrase('Student Terminal Report'); ?>
    </div>

    <?php echo form_open(base_url() . 'report/student_terminal_report_view', array('class' => 'report-form', 'target' => '_blank', 'onsubmit' => 'return validateForm()')); ?>

    <div class="report-form-content">
        
        <!-- Academic Year Selection -->
        <div class="form-row">
            <div class="label-group">
                <?php echo get_phrase('Academic Year'); ?>
            </div>
            <select name="academic_year_id" id="academic_year_id" class="form-control" required onchange="load_academic_terms()">
                <option value="">-- <?php echo get_phrase('Select Academic Year'); ?> --</option>
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

        <!-- Academic Term Selection -->
        <div class="form-row">
            <div class="label-group">
                <?php echo get_phrase('Academic Term'); ?>
            </div>
            <select name="academic_term_id" id="academic_term_id" class="form-control" required onchange="load_class_list()">
                <option value="">-- <?php echo get_phrase('Select Academic Term'); ?> --</option>
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

        <!-- Class Selection (for filtering students) -->
        <div class="form-row">
            <div class="label-group">
                <?php echo get_phrase('Class'); ?>
            </div>
            <select name="class_id" id="class_id" class="form-control" required onchange="load_students()">
                <option value="">-- <?php echo get_phrase('Select Class'); ?> --</option>
                <?php
                $classes = $this->db->get('class')->result_array();
                foreach ($classes as $class):
                ?>
                    <option value="<?php echo $class['class_id']; ?>">
                        <?php echo $class['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Student Selection -->
        <div class="form-row">
            <div class="label-group">
                <?php echo get_phrase('Student'); ?>
            </div>
            <select name="student_id" id="student_id" class="form-control">
                <option value="">-- <?php echo get_phrase('Select Student'); ?> --</option>
                <?php if ($student_id > 0):
                    $student = $this->db->get_where('student', array('student_id' => $student_id))->row_array();
                    if ($student):
                ?>
                        <option value="<?php echo $student['student_id']; ?>" selected="selected">
                            <?php echo $student['name'] . ' (Roll: ' . $student['roll'] . ')'; ?>
                        </option>
                <?php
                    endif;
                endif;
                ?>
            </select>
        </div>

        <!-- Bulk Class Generation Checkbox -->
        <div class="form-row">
            <div class="checkbox-row">
                <input type="checkbox" name="generate_bulk" id="generate_bulk" onchange="toggleStudentSelect()">
                <label for="generate_bulk">
                    <?php echo get_phrase('Generate for all students in class'); ?>
                </label>
            </div>
        </div>

    </div>

    <div class="btn-container">
        <button type="submit" class="generate-btn" id="submit_btn">
            <i class="fa fa-search"></i> <?php echo get_phrase('Generate Report'); ?>
        </button>
    </div>

    <?php echo form_close(); ?>
</div>
<script type="text/javascript">
    var base_url = '<?php echo base_url(); ?>';

    // Validate form before submission
    function validateForm() {
        var year = $('#academic_year_id').val();
        var term = $('#academic_term_id').val();
        var class_id = $('#class_id').val();
        var student = $('#student_id').val();
        var bulk = $('#generate_bulk').is(':checked');

        if (!year || !term || !class_id) {
            alert('<?php echo get_phrase("Please select Academic Year, Term, and Class"); ?>');
            return false;
        }

        if (!bulk && !student) {
            alert('<?php echo get_phrase("Please select a student or check Generate for all students"); ?>');
            return false;
        }

        return true;
    }

    // Toggle student select requirement
    function toggleStudentSelect() {
        var bulk = $('#generate_bulk').is(':checked');
        var studentSelect = $('#student_id');
        
        if (bulk) {
            studentSelect.prop('disabled', true);
            studentSelect.val('');
        } else {
            studentSelect.prop('disabled', false);
        }
    }

    // Load academic terms when year changes
    function load_academic_terms() {
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

    // Load students when class changes
    function load_students() {
        var class_id = $('#class_id').val();
        if (class_id) {
            $.ajax({
                url: base_url + 'report/get_class_students/' + class_id,
                type: 'GET',
                dataType: 'html',
                success: function(response) {
                    $('#student_id').html(response);
                }
            });
        }
    }
</script>
