
<div class="row">
    <div class="col-sm-12">
		<div class="panel panel-info">
            <div class="panel-heading"> <i class="fa fa-plus"></i>&nbsp;&nbsp;<?php echo get_phrase('Enter Student Score');?></div>
                <div class="panel-body table-responsive">
			
                    <!----CREATION FORM STARTS---->

                	<?php echo form_open(base_url() . 'admin/marks' , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top', 'enctype' => 'multipart/form-data'));?>
                    
                            <!-- ACADEMIC YEAR SELECTION -->
                            <div class="form-group">
                                    <label class="col-md-12" for="academic_year_id"><?php echo get_phrase('Academic Year');?></label>
                                <div class="col-sm-12">
                                    <select name="academic_year_id" id="academic_year_id" class="form-control select2" onchange="load_terms()">
                                        <option value=""><?php echo get_phrase('Select Academic Year');?></option>
                                        <?php if(isset($all_academic_years)): 
                                            foreach($all_academic_years as $year):?>
                                        <option value="<?php echo $year->academic_year_id;?>"<?php if(isset($academic_year_id) && $academic_year_id == $year->academic_year_id) echo 'selected="selected"' ;?>><?php echo $year->year_name;?></option>
                                        <?php endforeach; 
                                        endif;?>
                                </select>
                                </div>
                            </div>

                            <!-- ACADEMIC TERM SELECTION -->
                            <div class="form-group">
                                    <label class="col-md-12" for="academic_term_id"><?php echo get_phrase('Academic Term');?></label>
                                <div class="col-sm-12">
                                    <select name="academic_term_id" id="academic_term_id" class="form-control select2">
                                        <option value=""><?php echo get_phrase('Select Academic Term');?></option>
                                        <?php if(isset($current_term)): ?>
                                        <option value="<?php echo $current_term->academic_term_id;?>" selected="selected"><?php echo $current_term->term_name;?></option>
                                        <?php endif;?>
                                </select>
                                </div>
                            </div>

                            <!-- CLASS SELECTION -->
                            <div class="form-group">
                                    <label class="col-md-12" for="class_id"><?php echo get_phrase('class');?></label>
                                <div class="col-sm-12">
                                    <select name="class_id" id="class_id" class="form-control select2" onchange="show_students(this.value)">
                                        <option value=""><?php echo get_phrase('select_class');?></option>

                                        <?php $classes =  $this->db->get('class')->result_array();
                                        foreach($classes as $key => $class):?>
                                        <option value="<?php echo $class['class_id'];?>"<?php if(isset($class_id) && $class_id == $class['class_id']) echo 'selected="selected"' ;?>>Class: <?php echo $class['name'];?></option>
                                        <?php endforeach;?>
                                </select>

                                </div>
                            </div>

							
                            <!-- STUDENT SELECTION -->
                            <div class="form-group">
                                    <label class="col-md-12" for="student_id"><?php echo get_phrase('Student');?></label>
                                <div class="col-sm-12">

                                <?php $classes = $this->crud_model->get_classes();
                                        foreach ($classes as $key => $row): ?>

                                    <select name="<?php if(isset($class_id) && $class_id == $row['class_id']) echo 'student_id'; else echo 'temp';?>" id="student_id_<?php echo $row['class_id'];?>" style="display:<?php if(isset($class_id) && $class_id == $row['class_id']) echo 'block'; else echo 'none';?>"  class="form-control">
                                        <option value="">Student of: <?php echo $row['name'] ;?></option>

                                        <?php $students = $this->crud_model->get_students($row['class_id']);
                                        foreach ($students as $key => $student): ?>
                                        <option value="<?php echo $student['student_id'];?>"<?php if(isset($student_id) && $student_id == $student['student_id']) echo 'selected="selected"';?>><?php echo $student['name'];?></option>
                                        <?php endforeach;?>
                                    </select>
                                <?php endforeach;?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <select name="" id="student_id_0" style="display:<?php if(isset($student_id) && $student_id > 0) echo 'none'; else echo 'block';?>"  class="form-control">
                                        <option value=""><?php echo get_phrase('Select Class First');?></option>
                                    </select>
                                </div>
                            </div>
                            
                            <input class="" type="hidden" value="selection" name="operation">
                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-block btn-rounded btn-sm"><i class="fa fa-search"></i>&nbsp;<?php echo get_phrase('Get Details');?></button>
                        </div>
		
                    </form>                
            </div>                
		</div>
	</div>
</div>


<?php if(isset($class_id) && $class_id > 0 && isset($student_id) && $student_id > 0 && isset($academic_term_id) && $academic_term_id > 0):?>	

    <!-- Initialize score entries if needed -->
    <?php 
        $this->load->model('Score_entry_model');
        $this->Score_entry_model->initialize_student_scores($student_id, $academic_term_id, $class_id);
        $subjects = $this->Score_entry_model->get_class_subjects($class_id);
    ?>

					
    <div class="row">
	<div class="col-sm-12">
		<div class="panel panel-info">
            <div class="panel-heading"> <i class="fa fa-plus"></i>&nbsp;&nbsp;<?php echo get_phrase('Enter Student Scores - New System'); ?></div>
                <div class="panel-body table-responsive">
							   
    					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped">
								<thead>
									<tr>
										<td><strong><?php echo get_phrase('Subject');?></strong></td>
										<td><strong>EMT1</strong><br><small>(max 10)</small></td>
										<td><strong>EMT2</strong><br><small>(max 10)</small></td>
										<td><strong>EMT3</strong><br><small>(max 10)</small></td>
										<td><strong>SBA</strong><br><small>(max 10)</small></td>
										<td><strong>Project</strong><br><small>(max 10)</small></td>
										<td><strong>Exam</strong><br><small>(max 70)</small></td>
										<td><strong><?php echo get_phrase('Comment');?></strong></td>
									</tr>
								</thead>
                    				<tbody>

        <?php 
            foreach ($subjects as $key => $subject): 
                $score_entry = $this->Score_entry_model->get_score_entry($student_id, $academic_term_id, $subject['subject_id']);
        ?>
                    	
			<?php echo form_open(base_url() . 'admin/marks/scores' , array('class' => 'form-horizontal','id' => 'score_form'));?>
						<tr>
											<td>
												<strong><?php echo $subject['subject_name'];?></strong>
											</td>
											<td>
												<input type="number" step="0.01" class="emt1_score form-control" value="<?php echo $score_entry ? $score_entry->emt1_score : ''; ?>" name="emt1_<?php echo $subject['subject_id'];?>" min="0" max="10">
											</td>
											<td>
												<input type="number" step="0.01" class="emt2_score form-control" value="<?php echo $score_entry ? $score_entry->emt2_score : ''; ?>" name="emt2_<?php echo $subject['subject_id'];?>" min="0" max="10">
											</td>
											<td>
												<input type="number" step="0.01" class="emt3_score form-control" value="<?php echo $score_entry ? $score_entry->emt3_score : ''; ?>" name="emt3_<?php echo $subject['subject_id'];?>" min="0" max="10">
											</td>
											<td>
												<input type="number" step="0.01" class="sba_score form-control" value="<?php echo $score_entry ? $score_entry->sba_assessment_score : ''; ?>" name="sba_<?php echo $subject['subject_id'];?>" min="0" max="10">
											</td>
											<td>
												<input type="number" step="0.01" class="project_score form-control" value="<?php echo $score_entry ? $score_entry->project_score : ''; ?>" name="project_<?php echo $subject['subject_id'];?>" min="0" max="10">
											</td>
											<td>
												<input type="number" step="0.01" class="exam_score form-control" value="<?php echo $score_entry ? $score_entry->exam_score : ''; ?>" name="exam_<?php echo $subject['subject_id'];?>" min="0" max="70">
											</td>
			
											<td>
												<textarea name="comment_<?php echo $subject['subject_id'];?>" class="form-control comment_field" rows="2"><?php echo $score_entry ? $score_entry->teacher_comment : ''; ?></textarea>
											</td>
												<input type="hidden" name="student_id" value="<?php echo $student_id;?>" />
												<input type="hidden" name="academic_term_id" value="<?php echo $academic_term_id;?>" />
												<input type="hidden" name="class_id" value="<?php echo $class_id;?>" />
												
						</tr>

        <?php 
            endforeach;
        ?>

                            
                         	
                    </tbody>
               </table>
              <div id="error_message" class="alert alert-warning" style="display:none"></div>
                      <button type="button" class="btn btn-sm btn-rounded btn-block btn-info" onclick="save_all_scores()"><i class="fa fa-save"></i>&nbsp;<?php echo get_phrase('Save All Scores');?></button>
                 
                  <?php echo form_close();?>
            
			</div>
        </div>
	</div>
 </div>

<?php endif;?>



<script type="text/javascript">
    /**
     * Load academic terms when year is selected
     */
    function load_terms() {
        var academic_year_id = $('#academic_year_id').val();
        
        if (!academic_year_id) {
            $('#academic_term_id').html('<option value="">Select Academic Term</option>');
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
            }
        });
    }

    /**
     * Show students of selected class
     */
    function show_students(class_id){
            for(i=0;i<=50;i++){
                try{
                    document.getElementById('student_id_'+i).style.display = 'none' ;
                    document.getElementById('student_id_'+i).setAttribute("name" , "temp");
                }
                catch(err){}
            }
            if (class_id == "") {
                class_id = "0";
        }
        document.getElementById('student_id_'+class_id).style.display = 'block' ;
        document.getElementById('student_id_'+class_id).setAttribute("name" , "student_id");
        var student_id = $(".student_id");
        for(var i = 0; i < student_id.length; i++)
            student_id[i].selected = "";
    }

    /**
     * Save all scores via AJAX
     */
    function save_all_scores() {
        var form_data = $('#score_form').serialize();
        form_data += '&operation=save_scores';

        $.ajax({
            url: '<?php echo base_url(); ?>report/update_student_scores',
            type: 'POST',
            dataType: 'JSON',
            data: form_data,
            success: function(response) {
                if (response.success) {
                    $('#error_message').removeClass('alert-warning').addClass('alert-success');
                    $('#error_message').html('<strong>Success!</strong> ' + response.message);
                    $('#error_message').show();
                } else {
                    $('#error_message').removeClass('alert-success').addClass('alert-warning');
                    $('#error_message').html('<strong>Error!</strong> ' + response.message + '<br>' + response.errors.join('<br>'));
                    $('#error_message').show();
                }
                setTimeout(function() {
                    $('#error_message').fadeOut();
                }, 5000);
            },
            error: function() {
                $('#error_message').addClass('alert-danger').html('<strong>Error!</strong> Failed to save scores');
                $('#error_message').show();
            }
        });
    }
</script>