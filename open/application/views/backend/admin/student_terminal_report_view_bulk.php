<?php
// Bulk Class Terminal Reports - Professional Report Card View
// Opens in a new window with all students' reports, one per page
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Terminal Reports</title>
    <link href="<?php echo base_url(); ?>optimum/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 11pt;
            background: #ffffff;
            padding: 20px;
            color: #333;
        }

        .report-card {
            max-width: 900px;
            margin: 0 auto 30px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            overflow: hidden;
            page-break-inside: avoid;
        }

        /* Header Section */
        .report-header {
            background: #03a9f3;
            padding: 25px;
            border-bottom: 3px solid #0288d1;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .school-logo-container {
            flex-shrink: 0;
        }

        .school-logo {
            width: 55px;
            height: 55px;
            object-fit: contain;
        }

        .header-text {
            flex-grow: 1;
        }

        .header-text .report-title {
            font-size: 24pt;
            font-weight: bold;
            color: #ffffff;
            letter-spacing: 1px;
            margin: 0;
        }

        .header-text .school-name {
            font-size: 12pt;
            color: #ffffff;
            margin: 3px 0 0 0;
            font-weight: 500;
        }

        .term-info {
            font-size: 10pt;
            color: #666;
            margin-top: 5px;
        }

        /* Student Info Section */
        .student-info-box {
            background: white;
            padding: 25px;
            border-bottom: 1px solid #e0e0e0;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
        }

        .info-row {
            display: flex;
            align-items: baseline;
            gap: 10px;
        }

        .info-label {
            font-weight: bold;
            color: #03a9f3;
            font-size: 10.5pt;
            white-space: nowrap;
        }

        .info-value {
            flex: 1;
            border-bottom: 1px dotted #999;
            padding-bottom: 2px;
            font-size: 10.5pt;
            color: #333;
        }

        /* Marks Table */
        .marks-section {
            padding: 25px;
            background: white;
        }

        .marks-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 1px solid #e4e7ea;
        }

        .marks-table thead {
            background: #03a9f3;
            color: white;
        }

        .marks-table th {
            padding: 12px;
            text-align: center;
            font-weight: bold;
            font-size: 10.5pt;
            border: 1px solid #e4e7ea;
        }

        .marks-table th:first-child {
            text-align: left;
        }

        .marks-table td {
            padding: 10px 12px;
            text-align: center;
            border: 1px solid #e4e7ea;
            font-size: 10.5pt;
        }

        .marks-table td:first-child {
            text-align: left;
            font-weight: 500;
            color: #333;
        }

        .marks-table tbody tr:nth-child(even) {
            background: #f9fbfd;
        }

        .marks-table tbody tr:hover {
            background: #f5f8fc;
        }

        .score-value {
            font-weight: bold;
            color: #03a9f3;
        }

        .no-score {
            color: #999;
            font-style: italic;
        }

        /* Grade Badge */
        .grade-badge {
            background: #03a9f3;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
            display: inline-block;
            font-size: 10pt;
        }

        /* Grading Scale */
        .grading-scale {
            background: #f5f7fa;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            font-size: 10pt;
            color: #03a9f3;
            border-left: 4px solid #03a9f3;
        }

        .grading-scale strong {
            font-weight: bold;
        }

        /* Summary Section */
        .summary-box {
            background: #f5f7fa;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border: 1px solid #e4e7ea;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .summary-item {
            font-size: 10.5pt;
        }

        .summary-item strong {
            color: #03a9f3;
        }

        .summary-value {
            font-size: 13pt;
            font-weight: bold;
            color: #03a9f3;
        }

        /* Print Toolbar */
        .print-toolbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: white;
            border-bottom: 2px solid #ddd;
            padding: 15px 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            z-index: 1000;
            text-align: center;
        }

        body {
            padding-top: 80px;
        }

        .btn-print {
            background: #03a9f3;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 25px;
            font-size: 11pt;
            font-weight: bold;
            cursor: pointer;
            margin: 0 10px;
            font-family: 'Segoe UI', sans-serif;
            transition: all 0.3s ease;
        }

        .btn-print:hover {
            background: #0288d1;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        .btn-close {
            background: #999;
            color: white;
        }

        .btn-close:hover {
            background: #666;
        }

        .report-count {
            color: #666;
            font-size: 10pt;
            margin-left: 20px;
        }

        /* Print Styles */
        @media print {
            body {
                background: white;
                padding: 0;
                margin: 0;
            }
            .print-toolbar {
                display: none;
            }
            .report-card {
                box-shadow: none;
                border-radius: 0;
                margin: 0 0 30px 0;
                max-width: 100%;
                page-break-after: always;
            }
            .report-card:last-child {
                page-break-after: auto;
            }
        }
    </style>
</head>
<body>
    <div class="print-toolbar">
        <button class="btn-print" onclick="window.print()">
            <i class="fa fa-print"></i> Print All Reports
        </button>
        <button class="btn-print" onclick="downloadReport()" style="background: #27ae60;">
            <i class="fa fa-download"></i> Download PDF
        </button>
        <button class="btn-print btn-close" onclick="window.close()">
            <i class="fa fa-times"></i> Close
        </button>
        <span class="report-count"><?php echo count($students); ?> student reports</span>
    </div>

    <?php
    // Display report for each student
    foreach ($students as $index => $student):
        $class = $this->db->get_where('class', array('class_id' => $student['class_id']))->row_array();
    ?>

    <div class="report-card">
        <!-- Header Section with Logo -->
        <div class="report-header">
            <div class="school-logo-container">
                <img src="<?php echo get_school_logo(); ?>" class="school-logo" alt="School Logo">
            </div>
            <div class="header-text">
                <h1 class="report-title">TERMINAL REPORT</h1>
                <p class="school-name"><?php echo get_school_name(); ?></p>
                <div class="term-info"><?php echo $term['term_name']; ?> - <?php echo $year['academic_year_title']; ?></div>
            </div>
        </div>

        <!-- Student Avatar and Information Section -->
        <div class="student-info-box">
            <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #e0e0e0;">
                <div>
                    <?php echo get_avatar_badge($student['name'], 60); ?>
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 16pt; color: #333;"><?php echo $student['name']; ?></h3>
                    <p style="margin: 5px 0 0 0; font-size: 11pt; color: #888;">Roll: <?php echo $student['roll']; ?></p>
                </div>
            </div>
            <div class="info-grid">
                <div class="info-row">
                    <span class="info-label">Student:</span>
                    <span class="info-value"><?php echo $student['name']; ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Roll Number:</span>
                    <span class="info-value"><?php echo $student['roll']; ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Class:</span>
                    <span class="info-value"><?php echo $class['name']; ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Admission No:</span>
                    <span class="info-value"><?php echo isset($student['admission_number']) ? $student['admission_number'] : 'N/A'; ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Term:</span>
                    <span class="info-value"><?php echo $term['term_name']; ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Academic Year:</span>
                    <span class="info-value"><?php echo $year['academic_year_title']; ?></span>
                </div>
            </div>
        </div>

        <!-- Marks Section -->
        <div class="marks-section">
            <table class="marks-table">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th style="width: 20%;">Class Score (50)</th>
                        <th style="width: 20%;">Exam Score (100)</th>
                        <th style="width: 20%;">Total Score (100)</th>
                        <th style="width: 15%;">Grade</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $class_subjects = $this->db->get_where('class_subjects', array('class_id' => $student['class_id']))->result_array();
                    
                    $total_scores = [];
                    $total_subjects = 0;

                    foreach ($class_subjects as $class_subject):
                        $subject_id = $class_subject['subject_id'];
                        $subject = $this->db->get_where('subject', array('subject_id' => $subject_id))->row_array();
                        
                        $score = $this->db->where([
                            'student_id' => $student['student_id'],
                            'academic_term_id' => $academic_term_id,
                            'subject_id' => $subject_id
                        ])->get('score_entry')->row_array();

                        if ($score):
                            $class_score = isset($score['custom_class_score']) ? $score['custom_class_score'] : 0;
                            $exam_score = isset($score['custom_exam_score']) ? $score['custom_exam_score'] : 0;
                            $total_score = $class_score + ($exam_score / 2);
                            $total_score = min(100, $total_score);
                            
                            $total_scores[] = $total_score;
                            $total_subjects++;
                            
                            $grade_info = $this->db->where('max_score >=', $total_score)
                                                   ->order_by('max_score', 'ASC')
                                                   ->limit(1)
                                                   ->get('grade')
                                                   ->row_array();
                            
                            $grade = $grade_info ? $grade_info['grade'] : 'N/A';
                    ?>
                    <tr>
                        <td><?php echo $subject['name']; ?></td>
                        <td><span class="score-value"><?php echo number_format($class_score, 1); ?></span></td>
                        <td><span class="score-value"><?php echo number_format($exam_score, 1); ?></span></td>
                        <td><span class="score-value"><?php echo number_format($total_score, 1); ?></span></td>
                        <td><span class="grade-badge"><?php echo $grade; ?></span></td>
                    </tr>
                    <?php
                        else:
                    ?>
                    <tr>
                        <td><?php echo $subject['name']; ?></td>
                        <td colspan="4" class="no-score">No scores entered</td>
                    </tr>
                    <?php
                        endif;
                    endforeach;
                    ?>
                </tbody>
            </table>

            <!-- Grading Scale -->
            <div class="grading-scale">
                <strong>GRADING SCALE:</strong> A = 90%-100%, B = 80%-89%, C = 70%-79%, D = 60%-69%, E = 0%-59%
            </div>

            <!-- Summary -->
            <?php if (!empty($total_scores) && count($total_scores) > 0): ?>
                <div class="summary-box">
                    <div class="summary-item">
                        <strong>Subjects Completed:</strong><br>
                        <span class="summary-value"><?php echo $total_subjects; ?></span>
                    </div>
                    <div class="summary-item">
                        <strong>Average Score:</strong><br>
                        <span class="summary-value"><?php echo number_format(array_sum($total_scores) / count($total_scores), 1); ?>/100</span>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php endforeach; ?>

    <script>
        window.focus();

        function downloadReport() {
            // Create a container with all report cards
            const allReports = document.querySelectorAll('.report-card');
            const container = document.createElement('div');
            
            allReports.forEach((report, index) => {
                const clone = report.cloneNode(true);
                container.appendChild(clone);
                
                // Add page break between reports except after the last one
                if (index < allReports.length - 1) {
                    const pageBreak = document.createElement('div');
                    pageBreak.style.pageBreakAfter = 'always';
                    pageBreak.style.height = '5mm';
                    container.appendChild(pageBreak);
                }
            });
            
            const filename = 'Terminal_Reports_' + new Date().getTime() + '.pdf';
            
            const opt = {
                margin: [5, 5, 5, 5],
                filename: filename,
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2, useCORS: true, allowTaint: true },
                jsPDF: { orientation: 'portrait', unit: 'mm', format: 'a4' }
            };
            
            html2pdf().set(opt).from(container).save();
        }
    </script>
</body>
</html>
