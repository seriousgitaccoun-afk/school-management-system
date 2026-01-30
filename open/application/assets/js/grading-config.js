/**
 * Grading Configuration Modal
 * Handles custom assessment column management for teachers
 */

var gradingConfig = {
    currentStructure: null,
    currentSubjectId: null,
    currentClassId: null,

    /**
     * Initialize the grading config modal
     */
    init: function() {
        this.attachEventHandlers();
    },

    /**
     * Attach event handlers to modal elements
     */
    attachEventHandlers: function() {
        // Add new column row
        $(document).on('click', '#add_column_row', function() {
            gradingConfig.addColumnRow();
        });

        // Remove column row
        $(document).on('click', '.remove_column_btn', function() {
            $(this).closest('.column-row').remove();
        });

        // Only one exam checkbox per structure
        $(document).on('change', '.is_exam_checkbox', function() {
            if ($(this).is(':checked')) {
                $('.is_exam_checkbox').not(this).prop('checked', false);
                // Set max value to 100 for exam
                $(this).closest('.column-row').find('.column_max').val(100);
            }
        });

        // Save grading structure
        $(document).on('click', '#save_grading_structure', function() {
            gradingConfig.saveStructure();
        });

        // Switch to custom columns
        $(document).on('click', '#switch_to_custom_btn', function() {
            gradingConfig.switchToCustom();
        });

        // Switch to default columns
        $(document).on('click', '#switch_to_default_btn', function() {
            gradingConfig.switchToDefault();
        });
    },

    /**
     * Open grading configuration modal
     * @param {int} subjectId - Subject ID
     * @param {int} classId - Class ID
     */
    openModal: function(subjectId, classId) {
        this.currentSubjectId = subjectId;
        this.currentClassId = classId;

        // Fetch current structure from server
        $.ajax({
            url: base_url + 'teacher/get_grading_structure',
            type: 'POST',
            dataType: 'JSON',
            data: {
                subject_id: subjectId,
                class_id: classId
            },
            success: function(response) {
                if (response.success) {
                    gradingConfig.currentStructure = response.structure;
                    gradingConfig.renderModal();
                    $('#gradingConfigModal').modal('show');
                } else {
                    alert('Error loading grading structure');
                }
            },
            error: function() {
                alert('Error communicating with server');
            }
        });
    },

    /**
     * Render modal content based on current structure
     */
    renderModal: function() {
        var html = '';
        var isCustom = this.currentStructure && this.currentStructure.length > 0;

        if (isCustom) {
            // Show current custom structure
            html += '<div class="alert alert-info">';
            html += '<strong>Current Structure: Custom</strong><br>';
            html += 'You have defined ' + this.currentStructure.length + ' assessment column(s)';
            html += '</div>';

            html += '<div class="current-structure-display">';
            $.each(this.currentStructure, function(idx, comp) {
                var examLabel = comp.is_exam ? ' <span class="label label-warning">Exam</span>' : '';
                html += '<div class="column-display">';
                html += '<strong>' + comp.name + '</strong> (Max: ' + comp.max_value + ')' + examLabel;
                html += '</div>';
            });
            html += '</div>';

            html += '<hr>';
            html += '<button type="button" class="btn btn-warning" id="switch_to_default_btn">';
            html += '<i class="fa fa-refresh"></i> Switch to Default (EMT)</button>';
            html += ' <span class="text-muted">Warning: This will delete all scores for this subject</span>';

        } else {
            // Show default structure
            html += '<div class="alert alert-info">';
            html += '<strong>Current Structure: Default</strong><br>';
            html += 'Using: EMT 1, EMT 2, EMT 3 (Class Score) + Exam<br>';
            html += 'Calculation: Class Score (avg EMT) 50% + Exam 50% = Total 100';
            html += '</div>';

            html += '<hr>';
            html += '<button type="button" class="btn btn-primary" id="switch_to_custom_btn">';
            html += '<i class="fa fa-plus"></i> Switch to Custom Columns</button>';
            html += ' <span class="text-muted">Define your own assessment types</span>';
        }

        $('#gradingStructureDisplay').html(html);
        $('#customColumnsContainer').hide();

        if (isCustom) {
            this.renderCustomColumns();
        }
    },

    /**
     * Render custom columns editor
     */
    renderCustomColumns: function() {
        var html = '<h5 class="m-t-20">Edit Columns</h5>';
        html += '<div id="columns_list">';

        $.each(this.currentStructure, function(idx, comp) {
            html += gradingConfig.getColumnRowHTML(idx, comp);
        });

        html += '</div>';

        html += '<button type="button" class="btn btn-sm btn-info m-t-10" id="add_column_row">';
        html += '<i class="fa fa-plus"></i> Add Column</button>';

        html += '<hr>';
        html += '<button type="button" class="btn btn-success" id="save_grading_structure">';
        html += '<i class="fa fa-save"></i> Save Changes</button>';

        $('#customColumnsEditor').html(html);
    },

    /**
     * Get HTML for a single column row
     */
    getColumnRowHTML: function(index, component) {
        var isExam = component && component.is_exam ? 'checked' : '';
        var name = component ? component.name : '';
        var maxValue = component ? component.max_value : '';

        var html = '<div class="column-row form-group row m-b-15" style="background: #f5f5f5; padding: 10px; border-radius: 4px;">';

        html += '<div class="col-md-5">';
        html += '<label>Column Name</label>';
        html += '<input type="text" class="form-control column_name" placeholder="e.g., Homework, SBA Assessment" value="' + name + '">';
        html += '</div>';

        html += '<div class="col-md-3">';
        html += '<label>Max Value</label>';
        html += '<input type="number" class="form-control column_max" min="1" max="100" placeholder="Max" value="' + maxValue + '">';
        html += '</div>';

        html += '<div class="col-md-2">';
        html += '<label><input type="checkbox" class="is_exam_checkbox" ' + isExam + '> Is Exam?</label>';
        html += '<small class="text-muted d-block">Only one exam per structure</small>';
        html += '</div>';

        html += '<div class="col-md-2">';
        html += '<label>&nbsp;</label>';
        html += '<button type="button" class="btn btn-sm btn-danger remove_column_btn" title="Remove this column">';
        html += '<i class="fa fa-trash"></i></button>';
        html += '</div>';

        html += '</div>';

        return html;
    },

    /**
     * Add a new blank column row
     */
    addColumnRow: function() {
        var newIndex = $('.column-row').length;
        var newRowHTML = this.getColumnRowHTML(newIndex, null);
        $('#columns_list').append(newRowHTML);
    },

    /**
     * Switch to custom columns
     */
    switchToCustom: function() {
        $('#customColumnsContainer').show();

        // Initialize with default custom columns
        this.currentStructure = [
            { name: 'Homework', max_value: 20, is_exam: false },
            { name: 'Class Tests', max_value: 30, is_exam: false },
            { name: 'Exam', max_value: 100, is_exam: true }
        ];

        this.renderCustomColumns();
    },

    /**
     * Switch to default (EMT) structure
     */
    switchToDefault: function() {
        if (!confirm('This will delete all scores for this subject. Continue?')) {
            return;
        }

        $.ajax({
            url: base_url + 'teacher/delete_subject_scores',
            type: 'POST',
            dataType: 'JSON',
            data: {
                subject_id: this.currentSubjectId
            },
            success: function(response) {
                if (response.success) {
                    gradingConfig.currentStructure = null;
                    alert('Switched to default grading structure. All scores deleted.');
                    $('#gradingConfigModal').modal('hide');
                    location.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('Error communicating with server');
            }
        });
    },

    /**
     * Save grading structure
     */
    saveStructure: function() {
        // Collect columns from form
        var columns = [];
        var hasExam = false;

        $('.column-row').each(function() {
            var name = $(this).find('.column_name').val().trim();
            var maxValue = parseInt($(this).find('.column_max').val());
            var isExam = $(this).find('.is_exam_checkbox').is(':checked');

            if (!name || !maxValue) {
                alert('Please fill in all column fields');
                return false;
            }

            if (isExam) {
                if (hasExam) {
                    alert('Only one column can be marked as Exam');
                    return false;
                }
                hasExam = true;
                maxValue = 100; // Force exam max to 100
            }

            // Sanitize column name
            var sanitizedName = gradingConfig.sanitizeName(name);

            columns.push({
                name: name,
                sanitized_name: sanitizedName,
                max_value: maxValue,
                is_exam: isExam
            });
        });

        if (columns.length === 0) {
            alert('Please add at least one column');
            return;
        }

        if (!hasExam) {
            alert('You must have exactly one column marked as Exam');
            return;
        }

        // Send to server
        $.ajax({
            url: base_url + 'teacher/save_grading_structure',
            type: 'POST',
            dataType: 'JSON',
            data: {
                subject_id: this.currentSubjectId,
                columns: JSON.stringify(columns)
            },
            success: function(response) {
                if (response.success) {
                    alert('Grading structure saved successfully');
                    $('#gradingConfigModal').modal('hide');
                    location.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('Error saving grading structure');
            }
        });
    },

    /**
     * Sanitize column name for consistency
     */
    sanitizeName: function(name) {
        return name.toLowerCase()
            .trim()
            .replace(/\s+/g, '_')
            .replace(/[^a-z0-9_]/g, '')
            .replace(/^_+|_+$/g, '');
    }
};

// Initialize when document is ready
$(document).ready(function() {
    gradingConfig.init();
});
