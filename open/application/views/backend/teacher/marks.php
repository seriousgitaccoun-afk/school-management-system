<?php
// Marks Entry Page
// Teacher enters student scores for subjects
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo get_phrase('Enter Student Score'); ?></title>
    <style>
        :root {
            --primary-purple: #6c5ce7;
            --light-bg: #f8f9fd;
            --border-color: #e0e4e8;
            --text-muted: #8898aa;
            --text-dark: #32325d;
        }

        .marks-page-container {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
            color: var(--text-dark);
        }

        .marks-container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        /* Header Section */
        .marks-header {
            background: linear-gradient(135deg, var(--primary-purple) 0%, #764ba2 100%);
            color: white;
            padding: 20px 30px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .marks-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }

        /* Form Sections */
        .marks-section {
            padding: 25px 30px;
            border-bottom: 1px solid var(--border-color);
        }

        .marks-section:last-child {
            border-bottom: none;
        }

        .marks-section-title {
            color: var(--primary-purple);
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0 0 20px 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Layout Grid */
        .grid-row {
            display: flex;
            gap: 20px;
            background: var(--light-bg);
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid var(--primary-purple);
        }

        .form-group {
            flex: 1;
            min-width: 200px;
        }

        label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        /* Dropdown Styling */
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            background-color: white;
            font-size: 14px;
            color: var(--text-dark);
            outline: none;
            transition: border-color 300ms ease;
        }

        select:focus {
            border-color: var(--primary-purple);
            box-shadow: 0 0 0 3px rgba(108, 92, 231, 0.1);
        }

        /* Subject Section */
        .subject-box {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 20px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background: white;
        }

        .subject-label {
            font-weight: 700;
            font-size: 16px;
            white-space: nowrap;
            min-width: 80px;
        }

        .subject-select-wrapper {
            flex-grow: 1;
        }

        .subject-select-wrapper select {
            width: 100%;
        }

        .btn-configure {
            background-color: #a29bfe;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
            transition: all 300ms ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-configure:hover {
            background-color: var(--primary-purple);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(108, 92, 231, 0.3);
        }

        /* Class Card Styling */
        .class-card {
            padding: 16px;
            background: white;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            cursor: pointer;
            transition: all 300ms ease;
            text-align: center;
            font-family: inherit;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .class-card:hover {
            border-color: var(--primary-purple);
            background: var(--light-bg);
            transform: translateY(-4px);
            box-shadow: 0 4px 12px rgba(108, 92, 231, 0.2);
        }

        .class-card.selected {
            border-color: var(--primary-purple);
            background: var(--light-bg);
            color: var(--primary-purple);
        }

        /* Subject Card Styling */
        .subject-card {
            padding: 20px;
            background: white;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            cursor: pointer;
            transition: all 300ms ease;
            text-align: center;
            font-family: inherit;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: var(--text-dark);
        }

        .subject-card:hover {
            border-color: var(--primary-purple);
            background: var(--light-bg);
            transform: translateY(-4px);
            box-shadow: 0 6px 16px rgba(108, 92, 231, 0.15);
        }

        .subject-card:active {
            transform: translateY(-2px);
        }

        .info-text {
            font-size: 12px;
            color: var(--text-muted);
            font-style: italic;
            margin-top: 10px;
            padding-left: 5px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Data Area */
        .marks-data-area {
            min-height: 100px;
            padding: 20px;
            background: var(--light-bg);
            border-radius: 8px;
            border: 1px dashed var(--border-color);
        }

        .marks-data-area.loading {
            opacity: 0.6;
            pointer-events: none;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .marks-header h1 {
                font-size: 20px;
            }

            .grid-row {
                flex-direction: column;
                gap: 15px;
            }

            .form-group {
                flex: 1 1 auto;
            }

            .subject-box {
                flex-wrap: wrap;
            }

            .subject-select-wrapper {
                flex-basis: 100%;
            }
        }
    </style>
</head>
<body>

<?php 
// Check if query parameters are provided for direct marks entry
$show_marks_entry = isset($_GET['class_id']) && isset($_GET['subject_id']) && isset($_GET['term_id']);
$marks_class_id = $show_marks_entry ? $_GET['class_id'] : null;
$marks_subject_id = $show_marks_entry ? $_GET['subject_id'] : null;
$marks_term_id = $show_marks_entry ? $_GET['term_id'] : null;
?>

<div class="marks-page-container">
    <div class="marks-container">
        <!-- Header -->
        <div class="marks-header">
            <span style="font-size: 28px;">📝</span>
            <h1><?php echo $show_marks_entry ? get_phrase('Enter Student Marks') : get_phrase('Enter Student Score'); ?></h1>
            <?php if ($show_marks_entry): ?>
                <div style="margin-left: auto;">
                    <a href="<?php echo base_url('teacher/marks'); ?>" style="color: white; text-decoration: none; padding: 8px 16px; background: rgba(255,255,255,0.2); border-radius: 4px; font-size: 13px;">
                        ← <?php echo get_phrase('Back to Subjects'); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- SECTION 1: Current Academic Context (Auto-Selected) -->
        <?php if (!$show_marks_entry): ?>
        <div class="marks-section">
            <div class="marks-section-title">
                <span>📅</span> <?php echo get_phrase('Current Academic Context'); ?>
            </div>
            <div class="grid-row">
                <!-- Display Current Academic Year (Auto-Selected) -->
                <div class="form-group">
                    <label><?php echo get_phrase('Academic Year'); ?></label>
                    <select disabled style="background-color: #f5f5f5; cursor: not-allowed;">
                        <option><?php echo htmlspecialchars($academic_year_id && isset($all_academic_years) ? 
                            (collect($all_academic_years)->firstWhere('academic_year_id', $academic_year_id)->year_name ?? 'N/A') : 
                            'N/A'); ?></option>
                    </select>
                    <input type="hidden" id="academic_year_id" value="<?php echo $academic_year_id; ?>">
                </div>

                <!-- Display Current Academic Term (Auto-Selected) -->
                <div class="form-group">
                    <label><?php echo get_phrase('Academic Term'); ?></label>
                    <select disabled style="background-color: #f5f5f5; cursor: not-allowed;">
                        <option><?php echo htmlspecialchars($academic_term_id ? get_phrase('Term') . ' ' . $academic_term_id : 'N/A'); ?></option>
                    </select>
                    <input type="hidden" id="academic_term_id" value="<?php echo $academic_term_id; ?>">
                </div>
            </div>
            <div class="info-text" style="margin-top: 15px; color: #16a085; border-left: 3px solid #16a085; padding-left: 12px;">
                <span>ℹ️</span> <?php echo get_phrase('Academic year and term are automatically set by the administration'); ?>
            </div>
        </div>

        <!-- SECTION 2: Select Class & Subject -->
        <?php endif; ?>
        
        <?php if (!$show_marks_entry): ?>
        <div class="marks-section">
            <div class="marks-section-title">
                <span>📚</span> <?php echo get_phrase('Your Teaching Assignment'); ?>
            </div>
            
            <!-- SUBJECT TEACHER: Show class selection first -->
            <?php if (!(isset($is_class_teacher) && $is_class_teacher)): ?>
                <div style="margin-bottom: 30px;">
                    <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 12px; letter-spacing: 0.5px;">
                        <?php echo get_phrase('Step 1: Select Your Class'); ?>
                    </label>
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 12px;">
                        <?php foreach($teacher_classes as $class): ?>
                        <button type="button" class="class-card" data-class-id="<?php echo $class['class_id']; ?>" onclick="select_class('<?php echo $class['class_id']; ?>', '<?php echo htmlspecialchars($class['name']); ?>')">
                            <div style="font-size: 20px; margin-bottom: 8px;">🏫</div>
                            <div style="font-weight: 600; color: var(--text-dark); font-size: 14px;">
                                <?php echo htmlspecialchars($class['name']); ?>
                            </div>
                        </button>
                        <?php endforeach; ?>
                    </div>
                    <div class="info-text" style="margin-top: 12px;">
                        <span>ℹ️</span> <?php echo get_phrase('Select a class to see your assigned subjects for that class'); ?>
                    </div>
                </div>
            <?php else: ?>
                <!-- CLASS TEACHER: Show their assigned class as info -->
                <div style="margin-bottom: 20px; padding: 16px; background: var(--light-bg); border: 2px solid var(--primary-purple); border-radius: 8px;">
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;">
                        🏫 Your Class
                    </div>
                    <div style="font-weight: 600; color: var(--text-dark); font-size: 16px;">
                        <?php echo htmlspecialchars(isset($teacher_classes[0]['name']) ? $teacher_classes[0]['name'] : 'Your Class'); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Subject Selection as nice cards -->
            <div>
                <label style="display: block; font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 12px; letter-spacing: 0.5px;">
                    <?php echo (isset($is_class_teacher) && $is_class_teacher) ? get_phrase('Step 1: Select Subject to Enter Marks') : get_phrase('Step 2: Select Subject to Enter Marks'); ?>
                </label>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 12px;">
                    <?php 
                        $teacher_id = $this->session->userdata('teacher_id');
                        $all_subjects = $this->db->where_in('teacher_id', array($teacher_id, 0))
                                                  ->order_by('name', 'ASC')
                                                  ->get('subject')
                                                  ->result_array();
                        foreach($all_subjects as $subj):
                    ?>
                    <button type="button" class="subject-card" onclick="select_subject('<?php echo $subj['subject_id']; ?>', '<?php echo htmlspecialchars($subj['name']); ?>')">
                        <div style="font-size: 24px; margin-bottom: 10px;">📖</div>
                        <div style="font-weight: 600; color: var(--text-dark); font-size: 15px;">
                            <?php echo htmlspecialchars($subj['name']); ?>
                        </div>
                        <div style="font-size: 11px; color: var(--text-muted); margin-top: 8px;">Click to enter marks</div>
                    </button>
                    <?php endforeach; ?>
                </div>
                <div class="info-text" style="margin-top: 12px;">
                    <span>⚙️</span> 
                    <button type="button" class="btn-configure" id="configure_grading_btn" onclick="open_grading_config()" style="margin-left: 8px;">
                        <?php echo get_phrase('Configure Grading Structure'); ?>
                    </button>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- SECTION 3: Student Marks Entry (When viewing marks entry page) -->
        <?php if ($show_marks_entry): ?>
        <div class="marks-section" style="padding: 0;">
            <?php 
                // Load marks data directly via model
                if ($marks_class_id && $marks_subject_id && $marks_term_id) {
                    // Get students for this class
                    $students = $this->db->where('class_id', $marks_class_id)
                                         ->order_by('roll', 'ASC')
                                         ->get('student')
                                         ->result_array();
                    
                    // Include the marks entry view
                    $page_data = array(
                        'students' => $students,
                        'class_id' => $marks_class_id,
                        'subject_id' => $marks_subject_id,
                        'academic_term_id' => $marks_term_id
                    );
                    $this->load->view('backend/teacher/load_marks_entry', $page_data);
                } else {
                    echo '<div style="padding: 20px; text-align: center; color: #d32f2f;">Error: Missing required parameters</div>';
                }
            ?>
        </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>

<script type="text/javascript">

// Pass base_url and context to JavaScript
var base_url = '<?php echo base_url(); ?>';
var current_academic_year_id = '<?php echo $academic_year_id; ?>';
var current_academic_term_id = '<?php echo $academic_term_id; ?>';
var selected_class_id = null;
var is_class_teacher = <?php echo (isset($is_class_teacher) && $is_class_teacher) ? 'true' : 'false'; ?>;
var show_marks_entry = <?php echo $show_marks_entry ? 'true' : 'false'; ?>;

// Auto-select class for class teachers
if (is_class_teacher) {
    selected_class_id = '<?php echo isset($assigned_class_id) ? $assigned_class_id : ''; ?>';
    console.log('Class Teacher - Auto-selected class: ' + selected_class_id);
}

// Select a class (for subject teachers)
function select_class(class_id, class_name) {
    selected_class_id = class_id;
    
    // Update UI - mark this class as selected
    $('.class-card').each(function() {
        if ($(this).data('class-id') == class_id) {
            $(this).addClass('selected');
        } else {
            $(this).removeClass('selected');
        }
    });
    
    console.log('Selected class: ' + class_id + ' (' + class_name + ')');
}

// Select a subject and load marks
function select_subject(subject_id, subject_name) {
    if (!subject_id) {
        alert('<?php echo get_phrase('Please select a subject'); ?>');
        return;
    }
    
    // Class teachers already have class auto-selected
    // Subject teachers must select a class first
    if (!is_class_teacher && !selected_class_id) {
        alert('<?php echo get_phrase('Please select a class first'); ?>');
        return;
    }
    
    if (!selected_class_id) {
        // This shouldn't happen for class teachers, but just in case
        alert('<?php echo get_phrase('Error: No class selected'); ?>');
        return;
    }
    
    console.log('Subject selected: ' + subject_id + ' (' + subject_name + ') - Redirecting to marks entry page');
    
    // Redirect to marks entry page using URL parameters
    window.location.href = base_url + 'teacher/marks?class_id=' + selected_class_id + '&subject_id=' + subject_id + '&term_id=' + current_academic_term_id;
}

function open_grading_config() {
    var subject_id = $('#subject_id').val();
    var class_id = selected_class_id;
    
    if (!subject_id) {
        alert('<?php echo get_phrase('Please select a subject first'); ?>');
        return;
    }
    
    if (!class_id) {
        alert('<?php echo get_phrase('Please select a class first'); ?>');
        return;
    }
    
    if (typeof gradingConfig !== 'undefined' && gradingConfig.openModal) {
        gradingConfig.openModal(subject_id, class_id);
    } else {
        alert('<?php echo get_phrase('Grading configuration is not available'); ?>');
    }
}

// Initialize page on load
$(document).ready(function() {
    console.log('Marks page loaded with academic year: ' + current_academic_year_id + ', term: ' + current_academic_term_id);
    
// If only one class available (subject teacher), auto-select it
    if (!is_class_teacher && $('.class-card').length === 1) {
        var first_class_id = $('.class-card').data('class-id');
        var first_class_name = $('.class-card').find('div:nth-child(3)').text();
        select_class(first_class_id, first_class_name);
        console.log('Auto-selected single class: ' + first_class_id);
    }
});

</script>

<!-- Include grading scripts -->
<script src="<?php echo base_url('application/assets/js/grading-config.js'); ?>"></script>
<script src="<?php echo base_url('application/assets/js/grading-calc.js'); ?>"></script>
