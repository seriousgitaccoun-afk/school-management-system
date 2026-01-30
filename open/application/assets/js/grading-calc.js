/**
 * Real-time Grading Calculation
 * Calculates total score based on class components and exam
 * Default: (EMT avg * 0.5) + (Exam / 2)
 * Custom: (Class sum scaled to 50) + (Exam / 2)
 */

var gradingCalc = {
    /**
     * Initialize calculation system
     * @param {object} config - Configuration with grading_structure and is_custom
     */
    init: function(config) {
        this.config = config || {};
        this.attachListeners();
    },

    /**
     * Attach change listeners to score inputs
     */
    attachListeners: function() {
        // Listen to all score inputs
        $(document).on('change keyup', '.emt-score, .custom-score, .exam-score', function() {
            gradingCalc.calculateAllTotals();
        });
    },

    /**
     * Calculate all totals on the current page
     */
    calculateAllTotals: function() {
        // Find all rows (for both student and subject teacher views)
        var rows = $('tr[data-student-id], tr[data-subject-id]');

        if (rows.length === 0) {
            rows = $('.score-row');
        }

        rows.each(function() {
            gradingCalc.calculateRowTotal($(this));
        });
    },

    /**
     * Calculate total for a single row
     * @param {object} $row - jQuery row element
     */
    calculateRowTotal: function($row) {
        var studentId = $row.data('student-id');
        var subjectId = $row.data('subject-id');

        // Determine if custom or default structure
        var isCustom = $row.find('.custom-score').length > 0;
        var total = 0;

        if (isCustom) {
            total = gradingCalc.calculateCustomTotal($row);
        } else {
            total = gradingCalc.calculateDefaultTotal($row);
        }

        // Display total with grade
        gradingCalc.displayTotal($row, total);
    },

    /**
     * Calculate total using default EMT structure
     * Formula: (EMT avg * 0.5) + (Exam / 2)
     * @param {object} $row - jQuery row element
     * @return {float} - Total score 0-100
     */
    calculateDefaultTotal: function($row) {
        var emt1 = parseFloat($row.find('[name*="emt1"]').val()) || 0;
        var emt2 = parseFloat($row.find('[name*="emt2"]').val()) || 0;
        var emt3 = parseFloat($row.find('[name*="emt3"]').val()) || 0;
        var exam = parseFloat($row.find('[name*="exam"]').val()) || 0;

        // Class score = average of EMT (max 10)
        var classScore = (emt1 + emt2 + emt3) / 3;

        // Total = (class * 0.5) + (exam / 2)
        var total = (classScore * 0.5) + (exam / 2);

        return Math.round(total * 100) / 100; // 2 decimals
    },

    /**
     * Calculate total using custom structure
     * Formula: (Sum of class components scaled to 50) + (Exam / 2)
     * @param {object} $row - jQuery row element
     * @return {float} - Total score 0-100
     */
    calculateCustomTotal: function($row) {
        var classSum = 0;
        var classMaxSum = 0;
        var examScore = 0;

        // Get all custom score fields in this row
        var customScores = $row.find('.custom-score');

        customScores.each(function() {
            var $input = $(this);
            var value = parseFloat($input.val()) || 0;
            var maxValue = parseFloat($input.data('max-value')) || 0;
            var isExam = $input.data('is-exam') === true || $input.data('is-exam') === 'true';

            if (isExam) {
                examScore = value;
            } else {
                classSum += value;
                classMaxSum += maxValue;
            }
        });

        // Scale class sum to 50
        var scaledClass = 0;
        if (classMaxSum > 0) {
            scaledClass = (classSum / classMaxSum) * 50;
        }

        // Exam / 2
        var scaledExam = examScore / 2;

        // Total
        var total = Math.min(scaledClass + scaledExam, 100); // Cap at 100

        return Math.round(total * 100) / 100; // 2 decimals
    },

    /**
     * Display total score with grade color coding
     * @param {object} $row - jQuery row element
     * @param {float} total - Total score
     */
    displayTotal: function($row, total) {
        var $totalDisplay = $row.find('.total-display');

        if ($totalDisplay.length === 0) {
            return; // No display element found
        }

        // Get grade based on total
        var grade = gradingCalc.getGrade(total);
        var gradeColor = gradingCalc.getGradeColor(grade);

        // Format display
        var html = '<strong>' + total.toFixed(2) + '</strong>';
        html += ' <span class="label" style="background-color: ' + gradeColor + '; color: white;">' + grade + '</span>';

        $totalDisplay.html(html);
    },

    /**
     * Get letter grade based on total score
     * @param {float} total - Total score (0-100)
     * @return {string} - Grade letter (A-F)
     */
    getGrade: function(total) {
        if (total >= 80) return 'A';
        if (total >= 70) return 'B';
        if (total >= 60) return 'C';
        if (total >= 50) return 'D';
        if (total >= 40) return 'E';
        return 'F';
    },

    /**
     * Get color for grade badge
     * @param {string} grade - Grade letter
     * @return {string} - Color hex code
     */
    getGradeColor: function(grade) {
        var colors = {
            'A': '#27ae60', // Green
            'B': '#3498db', // Blue
            'C': '#f39c12', // Orange
            'D': '#e74c3c', // Red
            'E': '#c0392b', // Dark Red
            'F': '#2c3e50'  // Dark Gray
        };
        return colors[grade] || '#95a5a6';
    },

    /**
     * Format score input for display
     * @param {float} value - Score value
     * @param {float} max - Max value for this component
     * @return {string} - Formatted display
     */
    formatScore: function(value, max) {
        var val = parseFloat(value) || 0;
        var m = parseFloat(max) || 0;
        return val.toFixed(1) + '/' + m.toFixed(0);
    }
};

// Initialize when document is ready
$(document).ready(function() {
    // Get config from window (should be set by the view)
    var config = window.gradingConfig || {};
    gradingCalc.init(config);

    // Initial calculation
    setTimeout(function() {
        gradingCalc.calculateAllTotals();
    }, 500);
});
