<?php
// Admin: manage academic years
?>
<div class="row">
    <div class="col-md-12">
        <h4>Academic Years</h4>
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-striped">
                    <thead>
                        <th>ID</th>
                        <th>Year</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Current</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                        <?php foreach ($academic_years as $ay): ?>
                        <tr>
                            <td><?php echo $ay->academic_year_id; ?></td>
                            <td><?php echo $ay->year_name; ?></td>
                            <td><?php echo $ay->start_date; ?></td>
                            <td><?php echo $ay->end_date; ?></td>
                            <td><?php echo $ay->is_current ? 'Yes' : 'No'; ?></td>
                            <td>
                                <a class="btn btn-default btn-sm" href="<?php echo base_url('admin/academic_terms/' . $ay->academic_year_id); ?>">Manage Terms</a>
                                <a class="btn btn-primary btn-sm" href="#" onclick="showEditYear(<?php echo $ay->academic_year_id;?>,'<?php echo $ay->year_name; ?>','<?php echo $ay->start_date;?>','<?php echo $ay->end_date;?>', <?php echo $ay->is_current;?>)">Edit</a>
                                <a class="btn btn-danger btn-sm" href="<?php echo base_url('admin/academic_years/delete/' . $ay->academic_year_id); ?>">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <h5>Create Academic Year</h5>
                <form method="post" action="<?php echo base_url('admin/academic_years/create'); ?>" class="form-inline">
                    <div class="form-group">
                        <label>Year Label</label>
                        <input type="text" name="year_name" required class="form-control" placeholder="2025/2026">
                    </div>
                    <div class="form-group">
                        <label>Start</label>
                        <input type="date" name="start_date" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>End</label>
                        <input type="date" name="end_date" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Current</label>
                        <input type="checkbox" name="is_current" value="1" class="form-control">
                    </div>
                    <button class="btn btn-success">Create</button>
                </form>

                <!-- Edit modal placeholder -->
                <div id="editYearModal" style="display:none;">
                    <form method="post" id="editYearForm" action="<?php echo base_url('admin/academic_years/update/'); ?>">
                        <input type="hidden" name="academic_year_id" id="edit_academic_year_id">
                        <label>Year Name</label>
                        <input type="text" name="year_name" id="edit_year_name" class="form-control">
                        <label>Start Date</label>
                        <input type="date" name="start_date" id="edit_start_date" class="form-control">
                        <label>End Date</label>
                        <input type="date" name="end_date" id="edit_end_date" class="form-control">
                        <label>Current</label>
                        <input type="checkbox" name="is_current" id="edit_is_current" value="1">
                        <button class="btn btn-primary">Save</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
function showEditYear(id, year, start, end, is_current) {
    // simple inline edit via prompt for this minimal UI
    var newYear = prompt('Year name', year);
    if (!newYear) return;
    var newStart = prompt('Start date (YYYY-MM-DD)', start);
    var newEnd = prompt('End date (YYYY-MM-DD)', end);
    var url = '<?php echo base_url('admin/academic_years/update/'); ?>' + id;
    var form = $('<form method="post" action="'+url+'"></form>');
    form.append('<input type="hidden" name="year_name" value="'+newYear+'">');
    form.append('<input type="hidden" name="start_date" value="'+newStart+'">');
    form.append('<input type="hidden" name="end_date" value="'+newEnd+'">');
    form.append('<input type="hidden" name="is_current" value="'+(is_current?1:0)+'">');
    $('body').append(form);
    form.submit();
}
</script>
