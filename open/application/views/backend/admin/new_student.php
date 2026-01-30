<style>
    /* Student Registration Styling */
    .student-page-container {
        background: #f8f9fa;
        padding: 20px 0;
    }
    
    .student-form-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        border: 1px solid #e4e7ea;
        margin-bottom: 30px;
    }
    
    .student-form-header {
        background: linear-gradient(135deg, #03a9f3 0%, #0288d1 100%);
        color: white;
        padding: 20px;
        border-radius: 8px 8px 0 0;
    }
    
    .student-form-header h4 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    
    .student-form-body {
        padding: 30px;
    }
    
    .student-form-group {
        margin-bottom: 20px;
    }
    
    .student-form-label {
        label {
            font-weight: 600;
            color: #2b2b2b;
            font-size: 13px;
            letter-spacing: 0.3px;
            margin-bottom: 8px;
            display: block;
        }
    }
    
    .student-form-input {
        input, select, textarea {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid #d9dfe4;
            border-radius: 4px;
            font-size: 13px;
            transition: all 0.3s ease;
            font-family: Poppins, sans-serif;
            background-color: white;
            
            &:focus {
                border-color: #03a9f3;
                box-shadow: 0 0 0 3px rgba(3, 169, 243, 0.1);
                outline: none;
            }
        }
        
        select {
            cursor: pointer;
        }
        
        textarea {
            resize: vertical;
            min-height: 80px;
        }
    }
    
    .student-avatar-upload {
        text-align: center;
        padding: 20px;
        background: #f5f7fa;
        border-radius: 6px;
        margin-bottom: 20px;
        
        input[type="file"] {
            display: none;
        }
        
        .upload-placeholder {
            cursor: pointer;
            display: inline-block;
            
            img {
                width: 120px;
                height: 120px;
                border-radius: 50%;
                border: 3px solid #03a9f3;
                object-fit: cover;
                transition: all 0.3s ease;
            }
            
            &:hover img {
                box-shadow: 0 4px 12px rgba(3, 169, 243, 0.3);
                transform: scale(1.05);
            }
        }
        
        .upload-label {
            display: block;
            margin-top: 10px;
            font-size: 12px;
            color: #03a9f3;
            font-weight: 600;
            cursor: pointer;
            
            &:hover {
                text-decoration: underline;
            }
        }
    }
    
    .student-section-header {
        background: #f5f7fa;
        border-left: 4px solid #03a9f3;
        padding: 12px 16px;
        margin: 25px 0 15px 0;
        border-radius: 2px;
        font-weight: 600;
        color: #0288d1;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .student-form-button {
        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #03a9f3 0%, #0288d1 100%);
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
            
            &:hover {
                box-shadow: 0 4px 12px rgba(3, 169, 243, 0.3);
                transform: translateY(-1px);
            }
            
            &:active {
                transform: translateY(0);
            }
        }
    }
    
    .password-strength {
        font-size: 12px;
        margin-top: 5px;
        font-weight: 600;
        
        &.weak {
            color: #f44236;
        }
        
        &.fair {
            color: #ff9800;
        }
        
        &.good {
            color: #00c292;
        }
        
        &.strong {
            color: #0288d1;
        }
    }
    
    .quick-add-btn {
        background: #00c292;
        color: white;
        border: none;
        padding: 10px 16px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        
        &:hover {
            background: #00a86f;
            box-shadow: 0 2px 8px rgba(0, 194, 146, 0.3);
        }
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .student-form-body {
            padding: 20px;
        }
    }
</style>

<div class="student-page-container">
    <!-- STUDENT REGISTRATION FORM -->
    <div class="row">
        <div class="col-sm-12">
            <div class="student-form-card">
                <div class="student-form-header">
                    <h4><i class="fa fa-user-plus" style="margin-right: 10px;"></i>Register New Student</h4>
                </div>
                <div class="student-form-body">
                    
                    <?php echo form_open(base_url() . 'admin/new_student/create/' , array('class' => 'form-horizontal validate', 'enctype' => 'multipart/form-data'));?>
                    
                    <!-- Profile Image Upload -->
                    <div class="student-avatar-upload">
                        <label for="student_photo" class="upload-placeholder">
                            <img id="blah" src="<?php echo base_url();?>uploads/default_avatar.jpg" alt="Student photo">
                            <span class="upload-label"><i class="fa fa-cloud-upload"></i> Click to upload photo</span>
                        </label>
                        <input type='file' id="student_photo" name="userfile" onChange="readURL(this);">
                    </div>
                    
                    <!-- BASIC INFORMATION SECTION -->
                    <div class="student-section-header">
                        <i class="fa fa-info-circle" style="margin-right: 8px;"></i> Basic Information
                    </div>
                    
                    <div class="row">
                        <!-- Full Name -->
                        <div class="col-md-6">
                            <div class="student-form-group student-form-label">
                                <label>Full Name <span style="color: #f44236;">*</span></label>
                                <div class="student-form-input">
                                    <input type="text" name="name" class="form-control" placeholder="Student's full name" required autofocus>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Email -->
                        <div class="col-md-6">
                            <div class="student-form-group student-form-label">
                                <label>Email <span style="color: #f44236;">*</span></label>
                                <div class="student-form-input">
                                    <input type="email" name="email" class="form-control" placeholder="student@school.com" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <!-- Birthday -->
                        <div class="col-md-6">
                            <div class="student-form-group student-form-label">
                                <label>Date of Birth <span style="color: #f44236;">*</span></label>
                                <div class="student-form-input">
                                    <input type="text" name="birthday" class="form-control datepicker" placeholder="Select date" required>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Auto-calculated Age -->
                        <div class="col-md-6">
                            <div class="student-form-group student-form-label">
                                <label>Age (Auto-calculated)</label>
                                <div class="student-form-input">
                                    <input type="text" name="age" id="age" class="form-control" value="" readonly style="background: #f5f5f5;">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <!-- Gender -->
                        <div class="col-md-6">
                            <div class="student-form-group student-form-label">
                                <label>Gender <span style="color: #f44236;">*</span></label>
                                <div class="student-form-input">
                                    <select name="sex" class="form-control" required>
                                        <option value="">-- Select Gender --</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Phone (Optional) -->
                        <div class="col-md-6">
                            <div class="student-form-group student-form-label">
                                <label>Phone (Optional)</label>
                                <div class="student-form-input">
                                    <input type="text" name="phone" class="form-control" placeholder="Student phone">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- ACADEMIC INFORMATION SECTION -->
                    <div class="student-section-header">
                        <i class="fa fa-graduation-cap" style="margin-right: 8px;"></i> Academic Information
                    </div>
                    
                    <div class="row">
                        <!-- Session (Auto-filled) -->
                        <div class="col-md-6">
                            <div class="student-form-group student-form-label">
                                <label>Academic Year <span style="color: #f44236;">*</span></label>
                                <div class="student-form-input">
                                    <?php 
                                        $this->load->model('Academic_year_model');
                                        $current_year = $this->Academic_year_model->get_current_year();
                                        $year_name = $current_year ? $current_year->year_name : 'N/A';
                                        $academic_year_id = $current_year ? $current_year->academic_year_id : 1;
                                    ?>
                                    <input type="text" class="form-control" value="<?php echo $year_name; ?>" readonly style="background: #f5f5f5;">
                                    <input type="hidden" name="academic_year_id" value="<?php echo $academic_year_id; ?>">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Class -->
                        <div class="col-md-6">
                            <div class="student-form-group student-form-label">
                                <label>Class <span style="color: #f44236;">*</span></label>
                                <div class="student-form-input">
                                    <select name="class_id" class="form-control" id="class_id" required onchange="return get_class_sections(this.value)">
                                        <option value="">-- Select Class --</option>
                                        <?php 
                                            $classes = $this->db->get('class')->result_array();
                                            foreach($classes as $row):
                                        ?>
                                            <option value="<?php echo $row['class_id'];?>">
                                                <?php echo $row['name'];?>
                                            </option>
                                        <?php
                                            endforeach;
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Hidden Fields -->
                    <input type="hidden" name="roll" value="<?php echo substr(md5(uniqid(rand(), true)), 0, 7); ?>">
                    <input type="hidden" name="house_id" value="">
                    
                    <!-- PARENT INFORMATION SECTION -->
                    <div class="student-section-header">
                        <i class="fa fa-users" style="margin-right: 8px;"></i> Parent/Guardian Information
                    </div>
                    
                    <div class="student-form-group student-form-label">
                        <div style="margin-bottom: 12px;">
                            <button type="button" class="quick-add-btn" onclick="openAddParentModal()">
                                <i class="fa fa-plus-circle"></i> Add New Parent
                            </button>
                        </div>
                        <label>Select Parent <span style="color: #f44236;">*</span></label>
                        <div class="student-form-input">
                            <select name="parent_id" class="form-control" id="parent_select" required onchange="toggleParentInput()">
                                <option value="">-- Select Parent --</option>
                                <?php 
                                    $parents = $this->db->get('parent')->result_array();
                                    if(count($parents) > 0):
                                        foreach($parents as $row):
                                        ?>
                                        <option value="<?php echo $row['parent_id'];?>">
                                            <?php echo $row['name'];?> (<?php echo $row['email'];?>)
                                        </option>
                                        <?php
                                        endforeach;
                                    else:
                                    ?>
                                        <option value="" disabled>No parents in system - use Quick Add</option>
                                    <?php
                                    endif;
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <!-- ACCOUNT SECURITY SECTION -->
                    <div class="student-section-header">
                        <i class="fa fa-lock" style="margin-right: 8px;"></i> Account Security
                    </div>
                    
                    <div class="student-form-group student-form-label">
                        <label>Password <span style="color: #f44236;">*</span></label>
                        <div class="student-form-input">
                            <input type="password" name="password" class="form-control" placeholder="Strong password" onkeyup="CheckPasswordStrength(this.value)" required>
                        </div>
                        <div id="password_strength" class="password-strength"></div>
                    </div>
                    
                    <!-- ADDITIONAL DETAILS SECTION (OPTIONAL) -->
                    <div class="student-section-header" style="margin-top: 30px;">
                        <a href="#" onclick="toggleAdvancedDetails(event)" style="color: #0288d1; text-decoration: none; display: flex; align-items: center; gap: 8px;">
                            <i id="advIcon" class="fa fa-chevron-down"></i>
                            <span>Optional Information</span>
                        </a>
                    </div>
                    
                    <div id="advancedDetails" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="student-form-group student-form-label">
                                    <label>Address</label>
                                    <div class="student-form-input">
                                        <input type="text" name="address" class="form-control" placeholder="Student address">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="student-form-group student-form-label">
                                    <label>City</label>
                                    <div class="student-form-input">
                                        <input type="text" name="city" class="form-control" placeholder="City">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="student-form-group student-form-label">
                                    <label>State/Province</label>
                                    <div class="student-form-input">
                                        <input type="text" name="state" class="form-control" placeholder="State">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="student-form-group student-form-label">
                                    <label>Nationality</label>
                                    <div class="student-form-input">
                                        <input type="text" name="nationality" class="form-control" placeholder="Nationality">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="student-form-group student-form-label">
                                    <label>Blood Group</label>
                                    <div class="student-form-input">
                                        <input type="text" name="blood_group" class="form-control" placeholder="e.g., O+, A-, B+">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="student-form-group student-form-label">
                                    <label>Religion</label>
                                    <div class="student-form-input">
                                        <input type="text" name="religion" class="form-control" placeholder="Religion">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="student-form-group student-form-label">
                                    <label>Place of Birth</label>
                                    <div class="student-form-input">
                                        <input type="text" name="place_birth" class="form-control" placeholder="City/Country">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="student-form-group student-form-label">
                                    <label>Mother Tongue</label>
                                    <div class="student-form-input">
                                        <input type="text" name="m_tongue" class="form-control" placeholder="Mother tongue">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="student-form-group student-form-label">
                                    <label>Previous School Name</label>
                                    <div class="student-form-input">
                                        <input type="text" name="ps_attended" class="form-control" placeholder="School name">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="student-form-group student-form-label">
                                    <label>Class in Previous School</label>
                                    <div class="student-form-input">
                                        <input type="text" name="class_study" class="form-control" placeholder="e.g., 5th Grade">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="student-form-group student-form-label">
                                    <label>Date of Leaving Previous School</label>
                                    <div class="student-form-input">
                                        <input type="date" name="date_of_leaving" class="form-control">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="student-form-group student-form-label">
                                    <label>Admission Date</label>
                                    <div class="student-form-input">
                                        <input type="date" name="am_date" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="student-form-group student-form-label">
                            <label>Student Club (Optional)</label>
                            <div class="student-form-input">
                                <select name="club_id" class="form-control">
                                    <option value="">-- Select Club --</option>
                                    <?php 
                                        $club = $this->db->get('club')->result_array();
                                        foreach($club as $row):
                                    ?>
                                        <option value="<?php echo $row['club_id'];?>">
                                            <?php echo $row['club_name'];?>
                                        </option>
                                    <?php
                                        endforeach;
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- SUBMIT BUTTON -->
                    <div class="student-form-button" style="margin-top: 30px;">
                        <button type="submit" onclick="return validateParentInfo()">
                            <i class="fa fa-check"></i>&nbsp; Register Student
                        </button>
                    </div>
                    
                    <?php echo form_close();?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Add Parent Modal -->
<div id="addParentModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; padding: 30px; border-radius: 8px; width: 90%; max-width: 450px; box-shadow: 0 4px 20px rgba(0,0,0,0.3);">
        <h3 style="margin-top: 0; margin-bottom: 20px; color: #333;">
            <i class="fa fa-plus-circle" style="color: #00c292;"></i> Add New Parent
        </h3>
        <form id="quickAddParentForm">
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; margin-bottom: 5px; font-size: 13px;">Parent Name <span style="color: red;">*</span></label>
                <input type="text" id="quick_parent_name" class="form-control" placeholder="Enter parent name" required autofocus>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; margin-bottom: 5px; font-size: 13px;">Email <span style="color: red;">*</span></label>
                <input type="email" id="quick_parent_email" class="form-control" placeholder="Enter parent email" required>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; margin-bottom: 5px; font-size: 13px;">Phone <span style="color: red;">*</span></label>
                <input type="text" id="quick_parent_phone" class="form-control" placeholder="Enter parent phone" required>
            </div>

            <p style="color: #0288d1; padding: 10px; background: #e3f2fd; border-radius: 3px; margin-bottom: 20px; font-size: 12px;">
                <i class="fa fa-key"></i> Password will be auto-generated
            </p>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-success" style="flex: 1; background: #00c292; border: none; color: white; padding: 10px; border-radius: 4px; font-weight: 600; cursor: pointer;">
                    <i class="fa fa-check"></i> Add Parent
                </button>
                <button type="button" class="btn btn-secondary" onclick="closeAddParentModal()" style="flex: 1; background: #bdbdbd; border: none; color: white; padding: 10px; border-radius: 4px; font-weight: 600; cursor: pointer;">
                    <i class="fa fa-times"></i> Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openAddParentModal() {
    document.getElementById('addParentModal').style.display = 'flex';
    document.getElementById('quick_parent_name').focus();
}

function closeAddParentModal() {
    document.getElementById('addParentModal').style.display = 'none';
    document.getElementById('quickAddParentForm').reset();
}

// Close modal when clicking outside
document.getElementById('addParentModal').addEventListener('click', function(e) {
    if (e.target === this) closeAddParentModal();
});

// Handle form submission
document.getElementById('quickAddParentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    let name = document.getElementById('quick_parent_name').value.trim();
    let email = document.getElementById('quick_parent_email').value.trim();
    let phone = document.getElementById('quick_parent_phone').value.trim();
    
    // Basic validation
    if (!name || !email || !phone) {
        alert('Please fill in all required fields');
        return;
    }
    
    if (!email.includes('@')) {
        alert('Please enter a valid email');
        return;
    }
    
    // Send AJAX request to create parent
    $.ajax({
        url: '<?php echo base_url(); ?>admin/create_parent_ajax',
        type: 'POST',
        dataType: 'json',
        data: {
            name: name,
            email: email,
            phone: phone,
            address: '',
            profession: ''
        },
        success: function(response) {
            if (response.success) {
                // Add new parent to dropdown
                let selectElement = document.getElementById('parent_select');
                let newOption = document.createElement('option');
                newOption.value = response.parent_id;
                newOption.text = name + ' (' + email + ')';
                selectElement.appendChild(newOption);
                
                // Select the new parent
                selectElement.value = response.parent_id;
                selectElement.dispatchEvent(new Event('change'));
                
                // Close modal
                closeAddParentModal();
                
                alert('Parent added successfully!');
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function() {
            alert('Error creating parent. Please try again.');
        }
    });
});

// Toggle Advanced Details
function toggleAdvancedDetails(event) {
    event.preventDefault();
    const detailsDiv = document.getElementById('advancedDetails');
    const chevron = document.getElementById('advIcon');
    
    if (detailsDiv.style.display === 'none' || detailsDiv.style.display === '') {
        detailsDiv.style.display = 'block';
        chevron.classList.remove('fa-chevron-down');
        chevron.classList.add('fa-chevron-up');
    } else {
        detailsDiv.style.display = 'none';
        chevron.classList.remove('fa-chevron-up');
        chevron.classList.add('fa-chevron-down');
    }
}

function validateParentInfo() {
    var parentSelect = document.querySelector('select[name="parent_id"]').value;
    
    if(parentSelect == '' || parentSelect == null) {
        alert('Please select a parent or use "Add New Parent" to create one');
        return false;
    }
    return true;
}

function toggleParentInput() {
    // Parent selection validation occurs on submit
}

function get_class_sections(class_id) {
    $.ajax({
        url: '<?php echo base_url();?>admin/get_class_section/' + class_id ,
        success: function(response) {
            jQuery('#section_selector_holder').html(response);
        }
    });
}

function CheckPasswordStrength(password) {
    var password_strength = document.getElementById("password_strength");

    if (password.length == 0) {
        password_strength.innerHTML = "";
        return;
    }

    var regex = new Array();
    regex.push("[A-Z]");
    regex.push("[a-z]");
    regex.push("[0-9]");
    regex.push("[$@$!%*#?&]");

    var passed = 0;

    for (var i = 0; i < regex.length; i++) {
        if (new RegExp(regex[i]).test(password)) {
            passed++;
        }
    }

    var color = "";
    var strength = "";
    switch (passed) {
        case 0:
        case 1:
        case 2:
            strength = "Weak";
            color = "red";
            break;
        case 3:
             strength = "Medium";
            color = "orange";
            break;
        case 4:
             strength = "Strong";
            color = "green";
            break;
    }
    password_strength.innerHTML = strength;
    password_strength.style.color = color;
}
</script>

<script type="text/javascript">
$(function() {
    $('input[name="birthday"]').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true
    }, 
    function(start, end, label) {
        var years = moment().diff(start, 'years');
        $("#age").val(years);
    });
});
</script>





<script type="text/javascript">

	function validateParentInfo() {
		var parentSelect = document.querySelector('select[name="parent_id"]').value;
		
		// Check if parent is selected (either existing or newly added via Quick Add)
		if(parentSelect == '' || parentSelect == null) {
			alert('Please select a parent or use "Quick Add New Parent" to create one');
			console.log('Parent validation failed. Parent ID value:', parentSelect);
			return false;
		}
		console.log('Parent validation passed. Parent ID:', parentSelect);
		return true;
	}

	function toggleParentInput() {
		var parentSelect = document.querySelector('select[name="parent_id"]').value;
		// When using quick add, just select the parent from dropdown
		// No need for additional validation
	}

	function get_class_sections(class_id) {

    	$.ajax({
            url: '<?php echo base_url();?>admin/get_class_section/' + class_id ,
            success: function(response)
            {
                jQuery('#section_selector_holder').html(response);
            }
        });

    }

</script>


<script type="text/javascript">

	function CheckPasswordStrength(password) {
	var password_strength = document.getElementById("password_strength");

        //TextBox left blank.
        if (password.length == 0) {
            password_strength.innerHTML = "";
            return;
        }

        //Regular Expressions.
        var regex = new Array();
        regex.push("[A-Z]"); //Uppercase Alphabet.
        regex.push("[a-z]"); //Lowercase Alphabet.
        regex.push("[0-9]"); //Digit.
        regex.push("[$@$!%*#?&]"); //Special Character.

        var passed = 0;

        //Validate for each Regular Expression.
        for (var i = 0; i < regex.length; i++) {
            if (new RegExp(regex[i]).test(password)) {
                passed++;
            }
        }

        //Display status.
        var color = "";
        var strength = "";
        switch (passed) {
            case 0:
            case 1:
            case 2:
                strength = "Weak";
                color = "red";
                break;
            case 3:
                 strength = "Medium";
                color = "orange";
                break;
            case 4:
                 strength = "Strong";
                color = "green";
                break;
               
        }
        password_strength.innerHTML = strength;
        password_strength.style.color = color;

if(passed <= 2){
         document.getElementById('show').disabled = true;
        }else{
            document.getElementById('show').disabled = false;
        }

    }

</script>

<script type="text/javascript">
        $(function() {
            $('input[name="birthday"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true
            }, 
            function(start, end, label) {
                var years = moment().diff(start, 'years');
               // alert("You are " + years + " years old.");
                $("#age").val(years);
            });
        });
</script>

<!-- Quick Add Parent Modal -->
<div id="addParentModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; padding: 30px; border-radius: 8px; width: 90%; max-width: 450px; box-shadow: 0 4px 20px rgba(0,0,0,0.3);">
        <h3 style="margin-top: 0; margin-bottom: 20px; color: #333;">
            <i class="fa fa-plus-circle" style="color: #28a745;"></i> Add New Parent
        </h3>
        <form id="quickAddParentForm">
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; margin-bottom: 5px;">Parent Name <span style="color: red;">*</span></label>
                <input type="text" id="quick_parent_name" class="form-control" placeholder="Enter parent name" required autofocus>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; margin-bottom: 5px;">Email <span style="color: red;">*</span></label>
                <input type="email" id="quick_parent_email" class="form-control" placeholder="Enter parent email" required>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; margin-bottom: 5px;">Phone <span style="color: red;">*</span></label>
                <input type="text" id="quick_parent_phone" class="form-control" placeholder="Enter parent phone" required>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; margin-bottom: 5px;">Address (Optional)</label>
                <input type="text" id="quick_parent_address" class="form-control" placeholder="Enter parent address">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 5px;">Profession (Optional)</label>
                <input type="text" id="quick_parent_profession" class="form-control" placeholder="Enter parent profession">
            </div>

            <p style="color: #28a745; padding: 10px; background: #f0f8f5; border-radius: 3px; margin-bottom: 20px;">
                <i class="fa fa-key"></i> Password will be auto-generated
            </p>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-success" style="flex: 1;">
                    <i class="fa fa-check"></i> Add Parent
                </button>
                <button type="button" class="btn btn-secondary" onclick="closeAddParentModal()" style="flex: 1;">
                    <i class="fa fa-times"></i> Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openAddParentModal() {
    document.getElementById('addParentModal').style.display = 'flex';
    document.getElementById('quick_parent_name').focus();
}

function closeAddParentModal() {
    document.getElementById('addParentModal').style.display = 'none';
    document.getElementById('quickAddParentForm').reset();
}

// Close modal when clicking outside
document.getElementById('addParentModal').addEventListener('click', function(e) {
    if (e.target === this) closeAddParentModal();
});

// Handle form submission
document.getElementById('quickAddParentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    let name = document.getElementById('quick_parent_name').value.trim();
    let email = document.getElementById('quick_parent_email').value.trim();
    let phone = document.getElementById('quick_parent_phone').value.trim();
    let address = document.getElementById('quick_parent_address').value.trim();
    let profession = document.getElementById('quick_parent_profession').value.trim();
    
    // Basic validation
    if (!name || !email || !phone) {
        alert('Please fill in all required fields');
        return;
    }
    
    if (!email.includes('@')) {
        alert('Please enter a valid email');
        return;
    }
    
    // Send AJAX request to create parent
    $.ajax({
        url: '<?php echo base_url(); ?>admin/create_parent_ajax',
        type: 'POST',
        dataType: 'json',
        data: {
            name: name,
            email: email,
            phone: phone,
            address: address,
            profession: profession
        },
        success: function(response) {
            if (response.success) {
                // Add new parent to dropdown
                let selectElement = document.getElementById('parent_select');
                let newOption = document.createElement('option');
                newOption.value = response.parent_id;
                newOption.text = name + ' (' + email + ')';
                selectElement.appendChild(newOption);
                
                // Select the new parent
                selectElement.value = response.parent_id;
                selectElement.dispatchEvent(new Event('change'));
                
                // Close modal
                closeAddParentModal();
                
                alert('Parent added successfully!');
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function() {
            alert('Error creating parent. Please try again.');
        }
    });
});

// Allow Enter key to submit
document.getElementById('quick_parent_phone').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        document.getElementById('quickAddParentForm').dispatchEvent(new Event('submit'));
    }
});

// Toggle Advanced Details
function toggleAdvancedDetails(event) {
    event.preventDefault();
    const detailsDiv = document.getElementById('advancedDetails');
    const chevron = document.getElementById('advIcon');
    
    if (detailsDiv.style.display === 'none' || detailsDiv.style.display === '') {
        detailsDiv.style.display = 'block';
        chevron.classList.remove('fa-chevron-down');
        chevron.classList.add('fa-chevron-up');
    } else {
        detailsDiv.style.display = 'none';
        chevron.classList.remove('fa-chevron-up');
        chevron.classList.add('fa-chevron-down');
    }
}

</script>