<?php
// Admin: manage academic terms for a year
?>
<div class="row">
    <div class="col-md-12">
        <h4>Academic Terms for <?php echo $academic_year->year_name; ?></h4>
        <a href="<?php echo base_url('admin/academic_years'); ?>" class="btn btn-default">Back to Years</a>
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-striped">
                    <thead>
                        <th>ID</th>
                        <th>Term Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Vacation</th>
                        <th>Resumption</th>
                        <th>Active</th>
                        <th>Milestones</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                        <?php foreach ($terms as $t): ?>
                        <tr>
                            <td><?php echo $t['academic_term_id']; ?></td>
                            <td><?php echo $t['term_name']; ?></td>
                            <td><?php echo $t['start_date']; ?></td>
                            <td><?php echo $t['end_date']; ?></td>
                            <td><?php echo $t['vacation_date']; ?></td>
                            <td><?php echo $t['resumption_date']; ?></td>
                            <td><?php echo $t['is_active'] ? 'Yes' : 'No'; ?></td>
                            <td>
                                <?php if (isset($milestones[$t['academic_term_id']])): ?>
                                    <?php foreach ($milestones[$t['academic_term_id']] as $m): ?>
                                        <div><?php echo $m['name']; ?> (<?php echo $m['start_date']; ?> - <?php echo $m['end_date']; ?>) <a href="#" onclick="deleteMilestone(<?php echo $m['milestone_id']; ?>)">Delete</a></div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="#" onclick="showEditTerm(<?php echo $t['academic_term_id']; ?>, '<?php echo $t['term_name']; ?>', '<?php echo $t['start_date'];?>', '<?php echo $t['end_date'];?>', '<?php echo $t['vacation_date'];?>', '<?php echo $t['resumption_date'];?>', <?php echo $t['is_active'];?> )">Edit</a>
                                <a class="btn btn-success btn-sm" href="#" onclick="showAddMilestone(<?php echo $t['academic_term_id']; ?>)">Add Milestone</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <h5>Add Term</h5>
                <form method="post" action="<?php echo base_url('admin/academic_terms/create'); ?>">
                    <input type="hidden" name="academic_year_id" value="<?php echo $academic_year->academic_year_id; ?>">
                    <div class="form-inline">
                        <input type="text" name="term_name" class="form-control" placeholder="Term 4">
                        <input type="date" name="start_date" class="form-control">
                        <input type="date" name="end_date" class="form-control">
                        <input type="date" name="vacation_date" class="form-control" placeholder="Vacation">
                        <input type="date" name="resumption_date" class="form-control" placeholder="Resumption">
                        <label>Active</label><input type="checkbox" name="is_active" value="1">
                        <button class="btn btn-success">Add Term</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function showEditTerm(id, name, start, end, vac, resump, is_active) {
    var newname = prompt('Term name', name); if (!newname) return;
    var newstart = prompt('Start date (YYYY-MM-DD)', start); if (!newstart) return;
    var newend = prompt('End date', end); if (!newend) return;
    var url = '<?php echo base_url('admin/academic_terms/update/'); ?>' + id;
    var form = $('<form method="post" action="'+url+'"></form>');
    form.append('<input type="hidden" name="term_name" value="'+newname+'">');
    form.append('<input type="hidden" name="start_date" value="'+newstart+'">');
    form.append('<input type="hidden" name="end_date" value="'+newend+'">');
    form.append('<input type="hidden" name="vacation_date" value="'+(vac||'')+'">');
    form.append('<input type="hidden" name="resumption_date" value="'+(resump||'')+'">');
    form.append('<input type="hidden" name="is_active" value="'+(is_active?1:0)+'">');
    $('body').append(form); form.submit();
}

function showAddMilestone(termId) {
    var name = prompt('Milestone name'); if (!name) return;
    var start = prompt('Start date (YYYY-MM-DD)'); if (!start) return;
    var end = prompt('End date (YYYY-MM-DD)'); if (!end) return;
    var desc = prompt('Description (optional)');
    $.post('<?php echo base_url('admin/add_term_milestone'); ?>', {academic_term_id: termId, name: name, start_date: start, end_date: end, description: desc}, function(resp){
        try { var r = JSON.parse(resp); if (r.success) location.reload(); else alert(r.message); } catch(e) { location.reload(); }
    });
}

function deleteMilestone(id) {
    if (!confirm('Delete milestone?')) return;
    $.get('<?php echo base_url('admin/delete_term_milestone/'); ?>' + id, function(resp){
        try { var r = JSON.parse(resp); if (r.success) location.reload(); else alert(r.message); } catch(e) { location.reload(); }
    });
}
</script>
