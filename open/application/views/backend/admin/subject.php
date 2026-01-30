<div class="row">
                    <div class="col-sm-5">
				  	<div class="panel panel-info">
                            <div class="panel-heading"> <i class="fa fa-plus"></i>&nbsp;&nbsp;<?php echo get_phrase('add_subject');?></div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body table-responsive">
			
<!----CREATION FORM STARTS---->

                	<?php echo form_open(base_url() . 'subject/subject/create' , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                            <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase('name');?></label>
                    <div class="col-sm-12">
                                    <input type="text" class="form-control" name="name" / required>
                                </div>
                            </div>

                    
                    <div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase('class');?></label>
                    <div class="col-sm-12">
                    <select name="class_id" class="form-control select2" required>
                    <option value=""><?php echo get_phrase('select_class');?></option>

                    <?php $class =  $this->db->get('class')->result_array();
                    foreach($class as $key => $class):?>
                    <option value="<?php echo $class['class_id'];?>"><?php echo $class['name'];?></option>
                    <?php endforeach;?>
                   </select>

                  </div>
                 </div>

								
					<div class="form-group">
                 	<label class="col-md-12" for="example-text"><?php echo get_phrase('teacher');?></label>
                    <div class="col-sm-12">
                    <select name="teacher_id" class="form-control select2" required>
                    <option value=""><?php echo get_phrase('select_teacher');?></option>

                    <?php $teacher =  $this->db->get('teacher')->result_array();
                    foreach($teacher as $key => $teacher):?>
                    <option value="<?php echo $teacher['teacher_id'];?>"><?php echo $teacher['name'];?></option>
                    <?php endforeach;?>
                   </select>

                  </div>
                 </div>
                    <div class="form-group">
                    <button type="submit" class="btn btn-info btn-block btn-rounded btn-sm"><i class="fa fa-book"></i>&nbsp;<?php echo get_phrase('add_subject');?></button>
					</div>
							
                    </form>
                    
                    <hr>
                    <h5 style="text-align: center;"><strong>BULK LINK ALL SUBJECTS</strong></h5>
                    <hr>
                    
                    <!----BULK LINK FORM STARTS---->
                    <div class="form-group">
                 	<label class="col-md-12"><strong>Select Class to Link All Subjects</strong></label>
                    <div class="col-sm-12">
                    <select id="bulk_class_id" class="form-control">
                    <option value=""><?php echo get_phrase('select_class');?></option>

                    <?php $class =  $this->db->get('class')->result_array();
                    foreach($class as $key => $class):?>
                    <option value="<?php echo $class['class_id'];?>"><?php echo $class['name'];?></option>
                    <?php endforeach;?>
                   </select>

                  </div>
                 </div>
                 
                    <div class="form-group">
                    <button type="button" onclick="bulk_link_all_subjects()" class="btn btn-success btn-block btn-rounded btn-sm"><i class="fa fa-link"></i>&nbsp;Link All Subjects to This Class</button>
					</div>
                    <div id="bulk_message" style="display:none;" class="alert alert-info"></div>
                    <!----BULK LINK FORM ENDS---->
                    
                </div>                
			</div>
			</div>
			</div>
			<!----CREATION FORM ENDS-->

                    <div class="col-sm-7">
				  	<div class="panel panel-info">
                            <div class="panel-heading"> <i class="fa fa-plus"></i>&nbsp;&nbsp;<?php echo get_phrase('list_subject');?></div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body table-responsive">
                    
                                <div class="form-group">
                    <div class="col-sm-12">
                    <select id="class_id" class="form-control">
                    <option value=""><?php echo get_phrase('select_class');?></option>

                    <?php $class =  $this->db->get('class')->result_array();
                    foreach($class as $key => $class):?>
                    <option value="<?php echo $class['class_id'];?>"
                    <?php if($class_id == $class['class_id']) echo 'selected';?>><?php echo $class['name'];?></option>
                    <?php endforeach;?>
                   </select>

                  </div>
                 </div>
                 <button type="button" id="find" class="btn btn-success btn-rounded btn-sm btn-block">Get Subject</button>
                 <hr>
				
 				<!-- PHP that includes table for subject starts here  ------>
                <div id="data">
                <?php include 'displaySubjectClasswise.php';?>
                </div>
                <!-- PHP that includes table for subject ends here  ------>


				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	// Bulk link all subjects to a class
	function bulk_link_all_subjects() {
		var class_id = $('#bulk_class_id').val();
		
		if (!class_id || class_id == "") {
			$.toast({
				text: 'Please select a class first',
				position: 'top-right',
				loaderBg: '#f56954',
				icon: 'warning',
				hideAfter: 3500,
				stack: 6
			});
			return false;
		}
		
		// Show loading message
		$('#bulk_message').html('<i class="fa fa-spinner fa-spin"></i> Linking all subjects...').show();
		
		$.ajax({
			url: '<?php echo base_url(); ?>subject/bulk_link_subjects',
			type: 'POST',
			data: { class_id: class_id },
			dataType: 'JSON',
			success: function(response) {
				if (response.success) {
					$('#bulk_message').removeClass('alert-info alert-warning').addClass('alert-success');
					$('#bulk_message').html('<i class="fa fa-check"></i> ' + response.message);
					
					// Refresh the subject list
					setTimeout(function() {
						$('#class_id').val(class_id).change();
						$('#find').click();
					}, 1500);
				} else {
					$('#bulk_message').removeClass('alert-info alert-success').addClass('alert-warning');
					$('#bulk_message').html('<i class="fa fa-warning"></i> ' + response.message);
				}
			},
			error: function() {
				$('#bulk_message').removeClass('alert-info alert-success').addClass('alert-danger');
				$('#bulk_message').html('<i class="fa fa-times"></i> Error linking subjects. Please try again.');
			}
		});
	}

	$(document).ready(function() {

		$('#class_id').select2();
		$('#bulk_class_id').select2();
		
		$('#find').on('click', function() 
		{
			var class_id = $('#class_id').val();
			console.log('Get Subject button clicked - class_id:', class_id);
			 if (class_id == "") {
           $.toast({
            text: 'Please select class before clicking get subject button',
            position: 'top-right',
            loaderBg: '#f56954',
            icon: 'warning',
            hideAfter: 3500,
            stack: 6
        })
            return false;
        }
			console.log('Fetching subjects for class:', class_id);
			$.ajax({
				url: '<?php echo site_url('subject/getsubjectbyClasswise/');?>' + class_id
			}).done(function(response) {
				console.log('Subjects loaded, HTML length:', response.length);
				$('#data').html(response);
				console.log('Link buttons in DOM:', $('.link-subject-btn').length);
			}).fail(function(error) {
				console.error('Failed to load subjects:', error);
			});
		});

	});
	
	// Link a single subject to a class - using event delegation (outside ready block for global scope)
	$(document).on('click', '.link-subject-btn', function(e) {
		e.preventDefault();
		var subject_id = $(this).data('subject-id');
		var class_id = $(this).data('class-id');
		
		console.log('Link button clicked - subject_id:', subject_id, 'class_id:', class_id);
		
		if (!subject_id || !class_id) {
			console.error('Missing subject_id or class_id');
			$.toast({
				text: 'Missing subject or class',
				position: 'top-right',
				loaderBg: '#f56954',
				icon: 'warning',
				hideAfter: 3500,
				stack: 6
			});
			return false;
		}
		
		console.log('Sending AJAX request to link subject');
		$.ajax({
			url: '<?php echo site_url('subject/link_single_subject'); ?>',
			type: 'POST',
			data: { subject_id: subject_id, class_id: class_id },
			dataType: 'JSON',
			success: function(response) {
				console.log('AJAX success:', response);
				if (response.success) {
					$.toast({
						text: response.message,
						position: 'top-right',
						loaderBg: '#51cbce',
						icon: 'success',
						hideAfter: 3500,
						stack: 6
					});
					// Refresh the subject list
					setTimeout(function() {
						$('#find').click();
					}, 1000);
				} else {
					$.toast({
						text: response.message,
						position: 'top-right',
						loaderBg: '#f56954',
						icon: 'warning',
						hideAfter: 3500,
						stack: 6
					});
				}
			},
			error: function(xhr, status, error) {
				console.error('AJAX error:', error, 'Status:', status, 'Response:', xhr.responseText);
				$.toast({
					text: 'Error linking subject: ' + error,
					position: 'top-right',
					loaderBg: '#f56954',
					icon: 'error',
					hideAfter: 3500,
					stack: 6
				});
			}
		});
	});
	
	// Unlink subject from a class
	function unlink_subject(subject_id) {
		if (!subject_id) {
			$.toast({
				text: 'No subject selected',
				position: 'top-right',
				loaderBg: '#f56954',
				icon: 'warning',
				hideAfter: 3500,
				stack: 6
			});
			return false;
		}
		
		// Confirm deletion
		if (!confirm('Are you sure you want to unlink this subject from the class?')) {
			return false;
		}
		
		$.ajax({
			url: '<?php echo base_url(); ?>subject/unlink_subject',
			type: 'POST',
			data: { subject_id: subject_id },
			dataType: 'JSON',
			success: function(response) {
				if (response.success) {
					$.toast({
						text: response.message,
						position: 'top-right',
						loaderBg: '#51cbce',
						icon: 'success',
						hideAfter: 3500,
						stack: 6
					});
					// Refresh the subject list
					setTimeout(function() {
						$('#find').click();
					}, 1000);
				} else {
					$.toast({
						text: response.message,
						position: 'top-right',
						loaderBg: '#f56954',
						icon: 'warning',
						hideAfter: 3500,
						stack: 6
					});
				}
			},
			error: function() {
				$.toast({
					text: 'Error unlinking subject',
					position: 'top-right',
					loaderBg: '#f56954',
					icon: 'error',
					hideAfter: 3500,
					stack: 6
				});
			}
		});
	}
</script>



            