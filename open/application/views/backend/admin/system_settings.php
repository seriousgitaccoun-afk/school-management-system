<div class="row">

	<div class="col-sm-7">
		<div class="panel panel-info">

			<div class="panel-heading"><i class="fa fa-gear"></i>  <?php echo get_phrase('System Settings');?></div>
			<div class="panel-body table-responsive">

				<?php echo form_open(base_url(). 'systemsetting/system_settings/do_update', array('class' => 'form-horizontal form-groups-bordered', 'enctype'=> 'multipart/form-data'));?>



				<div class="form-group">
					<label class="col-md-12" for="example-text"><?php echo get_phrase('System Name');?></label>
					<div class="col-sm-12">
						<input type="text" class="form-control" name="system_name" value="<?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;?>">
					</div>
				</div>


			<div class="form-group">
				<label class="col-md-12" for="example-text"><?php echo get_phrase('System Title');?></label>
				<div class="col-sm-12">
					<input type="text" class="form-control" name="system_title" value="<?php echo school_setting('system_title', 'School Management System');?>">
				</div>
			</div>
				<div class="form-group">
					<label class="col-md-12" for="example-text"><?php echo get_phrase('System Address');?></label>
					<div class="col-sm-12">
						<input type="text" class="form-control" name="address" value="<?php echo $this->db->get_where('settings', array('type' => 'address'))->row()->description;?>">
					</div>
				</div>


				<div class="form-group">
					<label class="col-md-12" for="example-text"><?php echo get_phrase('System Phone');?></label>
					<div class="col-sm-12">
						<input type="text" class="form-control" name="phone" value="<?php echo $this->db->get_where('settings', array('type' => 'phone'))->row()->description;?>">
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-12" for="example-text"><?php echo get_phrase('Paypal Email');?></label>
					<div class="col-sm-12">
						<input type="text" class="form-control" name="paypal_email" value="<?php echo $this->db->get_where('settings', array('type' => 'paypal_email'))->row()->description;?>">
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-12" for="example-text"><?php echo get_phrase('Currency');?></label>
					<div class="col-sm-12">
						<input type="text" class="form-control" name="currency" value="<?php echo $this->db->get_where('settings', array('type' => 'currency'))->row()->description;?>">
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-12" for="example-text"><?php echo get_phrase('System Email');?></label>
					<div class="col-sm-12">
						<input type="text" class="form-control" name="system_email" value="<?php echo $this->db->get_where('settings', array('type' => 'system_email'))->row()->description;?>">
					</div>
				</div>

				<!-- School Customization Fields -->
				<hr>
				<h4><i class="fa fa-university"></i> School Information</h4>
				<hr>

				<div class="form-group">
					<label class="col-md-12" for="example-text">School Motto</label>
					<div class="col-sm-12">
						<input type="text" class="form-control" name="school_motto" value="<?php echo school_setting('school_motto', '');?>">
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-12" for="example-text">Principal Name</label>
					<div class="col-sm-12">
						<input type="text" class="form-control" name="principal_name" value="<?php echo school_setting('principal_name', '');?>">
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-12" for="example-text">Principal Title</label>
					<div class="col-sm-12">
						<input type="text" class="form-control" name="principal_title" value="<?php echo school_setting('principal_title', 'Principal');?>">
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-12" for="example-text">Vice Principal Name</label>
					<div class="col-sm-12">
						<input type="text" class="form-control" name="vice_principal_name" value="<?php echo school_setting('vice_principal_name', '');?>">
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-12" for="example-text">School Website</label>
					<div class="col-sm-12">
						<input type="url" class="form-control" name="website" value="<?php echo school_setting('website', 'https://yourschool.com');?>">
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-12" for="example-text">Board Affiliation (e.g., Ghana Education Service)</label>
					<div class="col-sm-12">
						<input type="text" class="form-control" name="board_affiliation" value="<?php echo school_setting('board_affiliation', 'Ghana Education Service');?>">
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-12" for="example-text">Accreditation Number</label>
					<div class="col-sm-12">
						<input type="text" class="form-control" name="accreditation_no" value="<?php echo school_setting('accreditation_no', '');?>">
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-12" for="example-text">School Registration Number</label>
					<div class="col-sm-12">
						<input type="text" class="form-control" name="registration_no" value="<?php echo school_setting('registration_no', '');?>">
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-12" for="example-text">Year Established</label>
					<div class="col-sm-12">
						<input type="text" class="form-control" name="year_established" value="<?php echo school_setting('year_established', '2000');?>">
					</div>
				</div>

				<!-- Feature Toggles -->
				<hr>
				<h4><i class="fa fa-toggle-on"></i> Enable/Disable Features</h4>
				<hr>

				<div class="form-group">
					<label class="col-md-12" for="example-text">Enable Hostel Management</label>
					<div class="col-sm-12">
						<select name="features_hostel" class="form-control">
							<?php $val = school_setting('features_hostel', 'yes'); ?>
							<option value="yes" <?php if($val == 'yes') echo 'selected'; ?>>Yes</option>
							<option value="no" <?php if($val == 'no') echo 'selected'; ?>>No</option>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-12" for="example-text">Enable Transportation</label>
					<div class="col-sm-12">
						<select name="features_transportation" class="form-control">
							<?php $val = school_setting('features_transportation', 'yes'); ?>
							<option value="yes" <?php if($val == 'yes') echo 'selected'; ?>>Yes</option>
							<option value="no" <?php if($val == 'no') echo 'selected'; ?>>No</option>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-12" for="example-text">Enable Clubs & Activities</label>
					<div class="col-sm-12">
						<select name="features_clubs" class="form-control">
							<?php $val = school_setting('features_clubs', 'yes'); ?>
							<option value="yes" <?php if($val == 'yes') echo 'selected'; ?>>Yes</option>
							<option value="no" <?php if($val == 'no') echo 'selected'; ?>>No</option>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-12" for="example-text">Enable Events & Noticeboard</label>
					<div class="col-sm-12">
						<select name="features_events" class="form-control">
							<?php $val = school_setting('features_events', 'yes'); ?>
							<option value="yes" <?php if($val == 'yes') echo 'selected'; ?>>Yes</option>
							<option value="no" <?php if($val == 'no') echo 'selected'; ?>>No</option>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-12" for="example-text">Enable Alumni Module</label>
					<div class="col-sm-12">
						<select name="features_alumni" class="form-control">
							<?php $val = school_setting('features_alumni', 'yes'); ?>
							<option value="yes" <?php if($val == 'yes') echo 'selected'; ?>>Yes</option>
							<option value="no" <?php if($val == 'no') echo 'selected'; ?>>No</option>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-12" for="example-text">Enable Online Payments</label>
					<div class="col-sm-12">
						<select name="features_online_payments" class="form-control">
							<?php $val = school_setting('features_online_payments', 'yes'); ?>
							<option value="yes" <?php if($val == 'yes') echo 'selected'; ?>>Yes</option>
							<option value="no" <?php if($val == 'no') echo 'selected'; ?>>No</option>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-12" for="example-text">Enable SMS Notifications</label>
					<div class="col-sm-12">
					<select name="features_sms" class="form-control">
						<?php $val = school_setting('features_sms', 'yes'); ?>
						<option value="yes" <?php if($val == 'yes') echo 'selected'; ?>>Yes</option>
						<option value="no" <?php if($val == 'no') echo 'selected'; ?>>No</option>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-12" for="example-text"><?php echo get_phrase('School Administration');?></label>
				<div class="col-sm-12">
					<select name="features_school_administration" class="form-control">
						<?php $val = school_setting('features_school_administration', 'yes'); ?>
						<option value="yes" <?php if($val == 'yes') echo 'selected'; ?>>Yes</option>
						<option value="no" <?php if($val == 'no') echo 'selected'; ?>>No</option>
					</select>
				</div>
			</div>

	
			<div class="form-group">
				<label class="col-md-12" for="example-text"><?php echo get_phrase('Text Alignment');?></label>
				<div class="col-sm-12">						<select name="text_align" class="form-control">
							<?php $align =  $this->db->get_where('settings', array('type' => 'text_align'))->row()->description;?>
								<option value="left-to-right" <?php if ($align == 'left-to-right') echo 'selected';?>> Left to right</option>
								<option value="right-to-left" <?php if ($align == 'right-to-left') echo 'selected';?>> Right to left</option>
						</select>
					</div>
				</div>
				
				<div class="form-group">
                   <label class="col-md-12" for="example-text"><?php echo get_phrase('language'); ?></label>
                    <div class="col-sm-12">
                        <select name="language" class="form-control select2">
                            <?php
                            $fields = $this->db->list_fields('language');
                            foreach ($fields as $key => $field) {
                                if ($field == 'phrase_id' || $field == 'phrase')
                                    continue;

                                $current_default_language = $this->db->get_where('settings', array('type' => 'language'))->row()->description;
                                ?>
                                <option value="<?php echo $field; ?>"
                                        <?php if ($current_default_language == $field) echo 'selected'; ?>> <?php echo $field; ?> </option>
                                        <?php
                                    }
                                    ?>
                        </select>
                    </div>
                </div>
				


				<div class="form-group">
					<label class="col-md-12" for="example-text"><?php echo get_phrase('Running Session');?></label>
					<div class="col-sm-12">
						

					<select name="running_session" class="form-control select2" >
                          <?php $running_session = $this->db->get_where('settings', array('type' => 'session'))->row()->description; ?>
                          <option value=""><?php echo get_phrase('select_running_session');?></option>
                          <?php for($i = 0; $i < 10; $i++):?>
                              <option value="<?php echo (2019+$i);?>-<?php echo (2019+$i+1);?>"
                                <?php if($running_session == (2019+$i).'-'.(2019+$i+1)) echo 'selected';?>>
                                  <?php echo (2019+$i);?>-<?php echo (2019+$i+1);?>
                              </option>
                          <?php endfor;?>
                          </select>


					</div>
				</div>



				<div class="form-group">
					<label class="col-md-12" for="example-text"><?php echo get_phrase('System Footer');?></label>
					<div class="col-sm-12">
						<input type="text" class="form-control" name="footer" value="<?php echo $this->db->get_where('settings', array('type' => 'footer'))->row()->description;?>">
					</div>
				</div>

				<!-- Email Configuration Section -->
				<hr>
				<h4><i class="fa fa-envelope"></i> Email Configuration</h4>
				<hr>

				<div class="form-group">
					<label class="col-md-12" for="example-text">Enable Email Notifications</label>
					<div class="col-sm-12">
						<select name="email_enabled" class="form-control">
							<?php $val = school_setting('email_enabled', 'no'); ?>
							<option value="no" <?php if($val == 'no') echo 'selected'; ?>>Disabled</option>
							<option value="yes" <?php if($val == 'yes') echo 'selected'; ?>>Enabled</option>
						</select>
						<small class="text-muted">Enable or disable email notifications system-wide</small>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-12" for="example-text">Gmail Address</label>
					<div class="col-sm-12">
						<input type="email" class="form-control" name="email_address" placeholder="your-email@gmail.com" value="<?php echo school_setting('email_address', '');?>">
						<small class="text-muted">Your Gmail address (e.g., youremail@gmail.com)</small>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-12" for="example-text">Gmail App Password</label>
					<div class="col-sm-12">
						<input type="password" class="form-control" name="email_password" placeholder="xxxx xxxx xxxx xxxx" value="<?php echo school_setting('email_password', '');?>">
						<small class="text-muted">
							16-character app password from 
							<a href="https://myaccount.google.com/apppasswords" target="_blank">Google Account Settings</a>
							<br>
							<strong>Note:</strong> You must have 2-Factor Authentication enabled on your Gmail account
						</small>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-12" for="example-text">Sender Name (From Name)</label>
					<div class="col-sm-12">
						<input type="text" class="form-control" name="email_from_name" placeholder="e.g., School Management System" value="<?php echo school_setting('email_from_name', get_school_name());?>">
						<small class="text-muted">This name will appear as the sender in email receipts</small>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-12" for="example-text">Sender Email (From Email)</label>
					<div class="col-sm-12">
						<input type="email" class="form-control" name="email_from_address" placeholder="noreply@yourschool.com" value="<?php echo school_setting('email_from_address', '');?>">
						<small class="text-muted">Email address that will appear as sender (can be different from Gmail address)</small>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-12" for="example-text">Email Subject Line (Receipts)</label>
					<div class="col-sm-12">
						<input type="text" class="form-control" name="email_subject_receipt" placeholder="Payment Receipt - {SCHOOL_NAME}" value="<?php echo school_setting('email_subject_receipt', 'Payment Receipt - ' . get_school_name());?>">
						<small class="text-muted">
							Use {SCHOOL_NAME}, {STUDENT_NAME}, {RECEIPT_NO} as placeholders
						</small>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-12" for="example-text">Test Email Address</label>
					<div class="col-sm-12">
						<div class="input-group">
							<input type="email" class="form-control" name="test_email" id="test_email_address" placeholder="test@example.com" value="">
							<span class="input-group-btn">
								<button class="btn btn-info" type="button" id="test_email_btn" onclick="sendTestEmail()">
									<i class="fa fa-envelope"></i> Send Test Email
								</button>
							</span>
						</div>
						<small class="text-muted">Send a test email to verify your configuration is working</small>
						<div id="test_email_result" style="margin-top: 10px;"></div>
					</div>
				</div>

				<div class="form-group">
					<button type="submit" class="btn btn-success btn-rounded btn-block btn-sm"><i class="fa fa-save"></i>  <?php echo get_phrase('save');?></button>
				</div>



				<?php echo form_close();?>







			</div>

		</div>

	</div>


<!-- Logo and Theme Settings Row -->
<div class="row m-t-30">

	<!-- System Logo Column -->
	<div class="col-md-6">
		<div class="white-box" style="border-top: 4px solid #f39c12; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
			<!-- Header -->
			<div style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); color: white; padding: 20px; margin: -25px -25px 20px -25px; border-radius: 2px 2px 0 0;">
				<h4 style="margin: 0; font-weight: 600;"><i class="fa fa-image"></i> <?php echo get_phrase('System Logo'); ?></h4>
				<small style="opacity: 0.9;">Upload and manage your school logo</small>
			</div>

			<?php echo form_open(base_url() . 'systemsetting/system_settings/upload_logo', array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top', 'enctype' => 'multipart/form-data'));?>			
				<div class="form-group"> 
					<label style="font-weight: 600; color: #2b2b2b; display: block; margin-bottom: 8px;">
						<i class="fa fa-upload" style="color: #f39c12; margin-right: 8px;"></i>
						<?php echo get_phrase('browse_image');?>
					</label>        
					<div>
  		  				<input type='file' class="form-control" name="userfile" accept="image/jpeg,image/png,image/gif" onChange="readURL(this);" required/>
       					<img id="blah" src="<?php echo get_school_logo(); ?>?nocache=<?php echo microtime(true); ?>" alt="School Logo" style="margin-top: 15px; border: 1px solid #ddd; padding: 5px; max-width: 100%; height: auto; display: block;"/>
                     	<button type="submit" class="btn btn-block btn-warning waves-effect" style="margin-top: 15px; padding: 10px; font-weight: 600;"><i class="fa fa-save"></i>&nbsp;<?php echo get_phrase('Update Logo');?></button>
					</div>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>

	<!-- Theme Settings Column -->
	<div class="col-md-6">
		<div class="white-box" style="border-top: 4px solid #9b59b6; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
			<!-- Header -->
			<div style="background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%); color: white; padding: 20px; margin: -25px -25px 20px -25px; border-radius: 2px 2px 0 0;">
				<h4 style="margin: 0; font-weight: 600;"><i class="fa fa-paint-brush"></i> <?php echo get_phrase('Theme Settings');?></h4>
				<small style="opacity: 0.9;">Choose your preferred color theme</small>
			</div>

			<?php echo form_open(base_url() . 'systemsetting/system_settings/themeSettings', array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top', 'enctype' => 'multipart/form-data'));?>
                
				<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
					<div class="radio radio-custom">
	                  <input type="radio" <?php if($skin = $this->db->get_where('settings' , array('type'=>'skin_colour'))->row()->description == 'default') echo 'checked';?> name="skin_colour" id="radio2" value="default">
	                  <label for="radio2" style="margin-left: 5px;"> Default </label>
					</div>

					<div class="radio radio-success">
	                  <input type="radio" <?php if($skin = $this->db->get_where('settings' , array('type'=>'skin_colour'))->row()->description == 'green') echo 'checked';?> name="skin_colour" id="radio3" value="green">
	                  <label for="radio3" style="margin-left: 5px;"> Green </label>
					</div>

					<div class="radio radio-gray">
	                  <input type="radio" <?php if($skin = $this->db->get_where('settings' , array('type'=>'skin_colour'))->row()->description == 'gray') echo 'checked';?> name="skin_colour" id="radio4" value="gray">
	                  <label for="radio4" style="margin-left: 5px;"> Gray </label>
					</div>

					<div class="radio radio-black">
	                  <input type="radio" <?php if($skin = $this->db->get_where('settings' , array('type'=>'skin_colour'))->row()->description == 'black') echo 'checked';?> name="skin_colour" id="radio5" value="black">
	                  <label for="radio5" style="margin-left: 5px;"> Black </label>
					</div>

					<div class="radio radio-purple">
	                  <input type="radio" <?php if($skin = $this->db->get_where('settings' , array('type'=>'skin_colour'))->row()->description == 'purple') echo 'checked';?> name="skin_colour" id="radio6" value="purple">
	                  <label for="radio6" style="margin-left: 5px;"> Purple </label>
					</div>

					<div class="radio radio-info">
	                  <input type="radio" <?php if($skin = $this->db->get_where('settings' , array('type'=>'skin_colour'))->row()->description == 'blue') echo 'checked';?> name="skin_colour" id="radio7" value="blue">
	                  <label for="radio7" style="margin-left: 5px;"> Blue </label>
					</div>

					<div class="radio radio-brown">
	                  <input type="radio" <?php if($skin = $this->db->get_where('settings' , array('type'=>'skin_colour'))->row()->description == 'brown') echo 'checked';?> name="skin_colour" id="radio8" value="brown">
	                  <label for="radio8" style="margin-left: 5px;"> Brown </label>
					</div>
				</div>
               
				<button type="submit" class="btn btn-block btn-primary waves-effect" style="margin-top: 20px; padding: 10px; font-weight: 600;"><i class="fa fa-check-circle"></i>&nbsp;<?php echo get_phrase('change_theme');?></button>
                
            <?php echo form_close();?>
		</div>
	</div>

</div>

<!-- Academic Settings Row -->
<div class="row m-t-30">

	<!-- Academic Settings Column -->
	<div class="col-md-12">
		<div class="white-box" style="border-top: 4px solid #03a9f3; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
			<!-- Header -->
			<div style="background: linear-gradient(135deg, #03a9f3 0%, #0284c7 100%); color: white; padding: 20px; margin: -25px -25px 20px -25px; border-radius: 2px 2px 0 0;">
				<h4 style="margin: 0; font-weight: 600;"><i class="fa fa-calendar-o"></i> <?php echo get_phrase('Academic Settings');?></h4>
				<small style="opacity: 0.9;">Manage the current academic year and term</small>
			</div>

			<div id="academic_message" class="alert alert-warning" style="display:none;"></div>

			<form id="academic_settings_form" method="post" onsubmit="return false;">

				<!-- Academic Year Section -->
				<div style="margin-bottom: 25px;">
					<label style="font-weight: 600; color: #2b2b2b; display: block; margin-bottom: 8px;">
						<i class="fa fa-graduation-cap" style="color: #03a9f3; margin-right: 8px;"></i>
						<?php echo get_phrase('Current Academic Year');?>
					</label>
					<select id="current_year_id" class="form-control select2" name="year_id" style="border: 1px solid #e4e7ea; padding: 10px; font-size: 15px;" required>
						<option value=""><?php echo get_phrase('Select Academic Year');?></option>
						<?php foreach($academic_years as $year): ?>
						<option value="<?php echo $year['academic_year_id'];?>" 
							<?php echo ($current_year && $current_year->academic_year_id == $year['academic_year_id']) ? 'selected' : '';?>>
							<?php echo htmlspecialchars($year['year_name']);?>
						</option>
						<?php endforeach; ?>
					</select>
					<small style="color: #8d9ea7; display: block; margin-top: 5px;"><i class="fa fa-info-circle"></i> Select the academic year for the current session</small>
				</div>

				<!-- Academic Term Section -->
				<div style="margin-bottom: 25px;">
					<label style="font-weight: 600; color: #2b2b2b; display: block; margin-bottom: 8px;">
						<i class="fa fa-bookmark" style="color: #00c292; margin-right: 8px;"></i>
						<?php echo get_phrase('Current Academic Term');?>
					</label>
					<select id="current_term_id" class="form-control select2" name="term_id" style="border: 1px solid #e4e7ea; padding: 10px; font-size: 15px;" required>
						<option value=""><?php echo get_phrase('Select Academic Term');?></option>
						<?php if($current_year): ?>
							<?php 
								$terms = $this->db->where('academic_year_id', $current_year->academic_year_id)
												 ->order_by('academic_term_id', 'ASC')
												 ->get('academic_terms')
												 ->result_array();
								foreach($terms as $term):
							?>
							<option value="<?php echo $term['academic_term_id'];?>" 
								<?php echo ($current_term && $current_term->academic_term_id == $term['academic_term_id']) ? 'selected' : '';?>>
								<?php echo htmlspecialchars($term['term_name']);?>
							</option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
					<small style="color: #8d9ea7; display: block; margin-top: 5px;"><i class="fa fa-info-circle"></i> This term will be auto-selected when teachers enter marks</small>
				</div>

				<!-- Save Button -->
				<div style="margin-bottom: 15px;">
					<button type="submit" class="btn btn-block waves-effect" style="background: linear-gradient(135deg, #03a9f3 0%, #0284c7 100%); color: white; padding: 12px; font-weight: 600; border: none;">
						<i class="fa fa-save"></i>&nbsp;<?php echo get_phrase('Save Academic Settings');?>
					</button>
				</div>

				<!-- Info Box -->
				<div style="background: #e3f2fd; border-left: 4px solid #03a9f3; padding: 12px; margin-top: 15px; border-radius: 2px;">
					<p style="margin: 0; font-size: 13px; color: #1976d2;">
						<i class="fa fa-lightbulb-o"></i> <strong><?php echo get_phrase('Info');?>:</strong><br>
						<?php echo get_phrase('The selected term will be auto-selected when teachers enter marks and manage assessments.');?>
					</p>
				</div>

			</form>

		</div>
	</div>

</div>

<script type="text/javascript">
$(document).ready(function() {
	// Load terms when year changes in academic settings
	$('#current_year_id').on('change', function() {
		var year_id = $(this).val();
		if (!year_id) {
			$('#current_term_id').html('<option value="">Select Academic Term</option>');
			return;
		}
		
		$.ajax({
			url: '<?php echo base_url();?>report/get_academic_terms/' + year_id,
			type: 'GET',
			dataType: 'html',
			success: function(response) {
				$('#current_term_id').html(response);
			},
			error: function() {
				alert('Error loading terms');
			}
		});
	});

	// Save academic settings
	$('#academic_settings_form').on('submit', function(e) {
		e.preventDefault();
		
		var year_id = $('#current_year_id').val();
		var term_id = $('#current_term_id').val();
		
		if (!year_id || !term_id) {
			$('#academic_message').removeClass('alert-success').addClass('alert-danger')
				.html('<i class="fa fa-exclamation"></i> Please select both year and term').slideDown();
			return;
		}
		
		var btn = $(this).find('button[type="submit"]').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');
		
		$.ajax({
			url: '<?php echo base_url();?>admin/save_academic_settings',
			type: 'POST',
			dataType: 'JSON',
			data: {
				year_id: year_id,
				term_id: term_id
			},
			success: function(response) {
				if (response.success) {
					$('#academic_message').removeClass('alert-danger').addClass('alert-success')
						.html('<i class="fa fa-check"></i> ' + response.message).slideDown();
					setTimeout(function() {
						$('#academic_message').slideUp();
					}, 3000);
				} else {
					$('#academic_message').removeClass('alert-success').addClass('alert-danger')
						.html('<i class="fa fa-exclamation"></i> ' + (response.message || 'Error saving settings')).slideDown();
				}
			},
			error: function(xhr) {
				$('#academic_message').removeClass('alert-success').addClass('alert-danger')
					.html('<i class="fa fa-exclamation"></i> Error saving settings').slideDown();
			},
			complete: function() {
				btn.prop('disabled', false).html('<i class="fa fa-save"></i> <?php echo get_phrase("Save Academic Settings");?>');
			}
		});
	});
	
	// Test Email Function
	window.sendTestEmail = function() {
		var testEmail = $('#test_email_address').val();
		var resultDiv = $('#test_email_result');
		var btn = $('#test_email_btn');
		
		if (!testEmail) {
			resultDiv.html('<div class="alert alert-warning"><i class="fa fa-warning"></i> Please enter a test email address</div>');
			return;
		}
		
		btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Sending...');
		resultDiv.html('');
		
		$.ajax({
			url: '<?php echo base_url("systemsetting/send_test_email"); ?>',
			type: 'POST',
			data: { test_email: testEmail },
			dataType: 'json',
			success: function(response) {
				if (response.success) {
					resultDiv.html('<div class="alert alert-success"><i class="fa fa-check"></i> ' + response.message + '</div>');
				} else {
					resultDiv.html('<div class="alert alert-danger"><i class="fa fa-times"></i> Error: ' + response.message + '</div>');
				}
			},
			error: function(xhr) {
				resultDiv.html('<div class="alert alert-danger"><i class="fa fa-times"></i> Failed to send test email. Check console for details.</div>');
				console.error(xhr);
			},
			complete: function() {
				btn.prop('disabled', false).html('<i class="fa fa-envelope"></i> Send Test Email');
			}
		});
	};
});
</script>