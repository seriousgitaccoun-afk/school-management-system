<!-- Left navbar-header - Admin Sidebar Navigation -->
<div class="navbar-default sidebar admin-sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse slimscrollsidebar">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search hidden-sm hidden-md hidden-lg">
                <!-- input-group -->
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search..."> 
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button"> <i class="fa fa-search"></i> </button>
                    </span>
                </div>
                <!-- /input-group -->
            </li>

            <!-- User Profile Section -->
            <li class="nav-sidebar-header">
                <?php
                    $account_type   =   $this->session->userdata('login_type');
                    $account_id     =   $account_type.'_id';
                    $name           =   $this->crud_model->get_type_name_by_id($account_type , $this->session->userdata($account_id), 'name');
                ?>
                <a href="#" class="nav-sidebar-header" style="display: flex; align-items: center; gap: 10px; text-decoration: none;">
                    <?php echo get_avatar_badge($name, 45); ?>
                    <div class="nav-sidebar-header-info">
                        <p class="nav-sidebar-header-name"><?php echo $name; ?></p>
                        <p class="nav-sidebar-header-role">Administrator</p>
                    </div>
                    <span class="fa fa-chevron-down"></span>
                </a>
                <ul class="nav nav-second-level dropdown-menu" style="display: none;">
                    <li><a href="javascript:void(0)"><i class="ti-user"></i> My Profile</a></li>
                    <li><a href="javascript:void(0)"><i class="ti-email"></i> Inbox</a></li>
                    <li><a href="javascript:void(0)"><i class="ti-settings"></i> Account Setting</a></li>
                    <li><a href="<?php echo base_url();?>login/logout"><i class="fa fa-power-off"></i> Logout</a></li>
                </ul>
            </li>

            <!-- ========== DASHBOARD ========== -->
            <?php $check_admin_permission = $this->db->get_where('admin_role', array('admin_id' => $this->session->userdata('login_user_id')))->row()->dashboard;?>
            <?php if($check_admin_permission == '1'):?>
                <li class="nav-sidebar-menu-item <?php if ($page_name == 'dashboard') echo 'active'; ?>">
                    <a href="<?php echo base_url();?>admin/dashboard" class="nav-sidebar-menu-link waves-effect">
                        <i class="ti-dashboard" style="color: #2ecc71;"></i>
                        <span class="nav-sidebar-menu-label hide-menu"><?php echo get_phrase('Dashboard') ;?></span>
                    </a>
                </li>
            <?php endif;?>


            <!-- ========== 1. ACADEMIC MANAGEMENT ========== -->
            <?php $check_admin_permission = $this->db->get_where('admin_role', array('admin_id' => $this->session->userdata('login_user_id')))->row()->manage_academics;?>
            <?php if($check_admin_permission == '1' && is_feature_enabled('school_administration')):?>

                <li class="nav-sidebar-divider"></li>
                
                <li class="nav-sidebar-section-title">
                    <i class="fa fa-book"></i> ACADEMIC MANAGEMENT
                </li>

                <!-- Classes -->
                <li class="nav-sidebar-menu-item <?php if ($page_name == 'class') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>admin/classes" class="nav-sidebar-menu-link waves-effect">
                        <i class="fa fa-university"></i>
                        <span class="nav-sidebar-menu-label hide-menu"><?php echo get_phrase('manage_classes'); ?></span>
                    </a>
                </li>

                <!-- Subjects -->
                <li class="nav-sidebar-menu-item <?php if ($page_name == 'subject') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>subject/subject/" class="nav-sidebar-menu-link waves-effect">
                        <i class="fa fa-book"></i>
                        <span class="nav-sidebar-menu-label hide-menu"><?php echo get_phrase('manage_subjects'); ?></span>
                    </a>
                </li>

                <!-- Academic Years -->
                <li class="nav-sidebar-menu-item <?php if ($page_name == 'academic_years') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>admin/academic_years" class="nav-sidebar-menu-link waves-effect">
                        <i class="fa fa-calendar"></i>
                        <span class="nav-sidebar-menu-label hide-menu"><?php echo get_phrase('Academic Years'); ?></span>
                    </a>
                </li>

                <!-- School Administration (Enquiries, Clubs, Events, etc) -->
                <li class="nav-sidebar-menu-item">
                    <a href="javascript:void(0);" class="nav-sidebar-menu-link waves-effect" data-toggle="collapse" data-target="#school-admin-menu">
                        <i class="fa fa-cog"></i>
                        <span class="nav-sidebar-menu-label hide-menu"><?php echo get_phrase('School Administration');?></span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse <?php
                        if ($page_name == 'enquiry_category'|| $page_name == 'list_enquiry'|| $page_name == 'club'|| $page_name == 'noticeboard' || $page_name == 'circular'|| $page_name == 'academic_syllabus') echo 'in';
                    ?>" id="school-admin-menu">
                        <li class="<?php if ($page_name == 'enquiry_category') echo 'active';?>">
                            <a href="<?php echo base_url();?>admin/enquiry_category">
                                <i class="fa fa-angle-double-right"></i>
                                <span class="hide-menu"><?php echo get_phrase('Equiry Category');?></span>
                            </a>
                        </li>
                        <li class="<?php if ($page_name == 'enquiry') echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>admin/list_enquiry">
                                <i class="fa fa-angle-double-right"></i>
                                <span class="hide-menu"><?php echo get_phrase('list_enquiries'); ?></span>
                            </a>
                        </li>
                        <?php if (is_feature_enabled('clubs')): ?>
                        <li class="<?php if ($page_name == 'club') echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>admin/club">
                                <i class="fa fa-angle-double-right"></i>
                                <span class="hide-menu"><?php echo get_phrase('school_clubs'); ?></span>
                            </a>
                        </li>
                        <?php endif; ?>
                        <li class="<?php if ($page_name == 'circular') echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>admin/circular">
                                <i class="fa fa-angle-double-right"></i>
                                <span class="hide-menu"><?php echo get_phrase('manage_circular'); ?></span>
                            </a>
                        </li>
                        <li class="<?php if ($page_name == 'academic_syllabus') echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>admin/academic_syllabus">
                                <i class="fa fa-angle-double-right"></i>
                                <span class="hide-menu"><?php echo get_phrase('syllabus'); ?></span>
                            </a>
                        </li>
                        <?php if (is_feature_enabled('events')): ?>
                        <li class="<?php if ($page_name == 'noticeboard') echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>admin/noticeboard">
                                <i class="fa fa-angle-double-right"></i>
                                <span class="hide-menu"><?php echo get_phrase('manage_events'); ?></span>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>

            <?php endif;?>

            <!-- ========== 2. PEOPLE MANAGEMENT ========== -->
            <?php $check_admin_permission = $this->db->get_where('admin_role', array('admin_id' => $this->session->userdata('login_user_id')))->row()->manage_employee;?>
            <?php if($check_admin_permission == '1'):?>

                <li class="nav-sidebar-divider"></li>
                
                <li class="nav-sidebar-section-title">
                    <i class="fa fa-users"></i> PEOPLE MANAGEMENT
                </li>

                <!-- Employees -->
                <li class="nav-sidebar-menu-item">
                    <a href="javascript:void(0);" class="nav-sidebar-menu-link waves-effect" data-toggle="collapse" data-target="#employees-menu">
                        <i class="fa fa-briefcase"></i>
                        <span class="nav-sidebar-menu-label hide-menu">Employees</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse <?php if ($page_name == 'teacher' || $page_name == 'accountant_manage' || $page_name == 'assign_subject_teacher_simple' || $page_name == 'credentials') echo 'in';?>" id="employees-menu">
                        <li class="<?php if ($page_name == 'teacher') echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>admin/teacher">
                                <i class="fa fa-angle-double-right"></i>
                                <span class="hide-menu"><?php echo get_phrase('Teachers'); ?></span>
                            </a>
                        </li>
                        <li class="<?php if ($page_name == 'accountant_manage') echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>admin/accountant">
                                <i class="fa fa-angle-double-right"></i>
                                <span class="hide-menu"><?php echo get_phrase('Accountants'); ?></span>
                            </a>
                        </li>
                        <li class="<?php if ($page_name == 'assign_subject_teacher_simple') echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>admin/assign_subject_teacher_simple_page">
                                <i class="fa fa-angle-double-right"></i>
                                <span class="hide-menu">Assign Subject Teachers</span>
                            </a>
                        </li>
                        <li class="<?php if ($page_name == 'credentials') echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>admin/credentials">
                                <i class="fa fa-angle-double-right"></i>
                                <span class="hide-menu">User Credentials</span>
                            </a>
                        </li>
                    </ul>
                </li>

            <?php endif;?>

            <!-- Students -->
            <?php $check_admin_permission = $this->db->get_where('admin_role', array('admin_id' => $this->session->userdata('login_user_id')))->row()->manage_student;?>
            <?php if($check_admin_permission == '1'):?>

                <li class="nav-sidebar-menu-item">
                    <a href="javascript:void(0);" class="nav-sidebar-menu-link waves-effect" data-toggle="collapse" data-target="#students-menu">
                        <i class="fa fa-graduation-cap"></i>
                        <span class="nav-sidebar-menu-label hide-menu">Students</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse <?php
                        if ($page_name == 'new_student' || $page_name == 'student_class' || $page_name == 'student_information' || $page_name == 'view_student' || $page_name == 'searchStudent' || $page_name == 'clubActivity')
                            echo 'in';
                    ?>" id="students-menu">
                        <li class="<?php if ($page_name == 'new_student') echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>admin/new_student">
                                <i class="fa fa-angle-double-right"></i>
                                <span class="hide-menu"><?php echo get_phrase('admission_form'); ?></span>
                            </a>
                        </li>
                        <li class="<?php if ($page_name == 'student_information' || $page_name == 'view_student') echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>admin/student_information">
                                <i class="fa fa-angle-double-right"></i>
                                <span class="hide-menu"><?php echo get_phrase('list_students'); ?></span>
                            </a>
                        </li>
                        <li class="<?php if ($page_name == 'clubActivity') echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>activity/clubActivity">
                                <i class="fa fa-angle-double-right"></i>
                                <span class="hide-menu"><?php echo get_phrase('Student Activity'); ?></span>
                            </a>
                        </li>
                    </ul>
                </li>

            <?php endif;?>

            <!-- Parents -->
            <?php $check_admin_permission = $this->db->get_where('admin_role', array('admin_id' => $this->session->userdata('login_user_id')))->row()->manage_parent;?>
            <?php if($check_admin_permission == '1'):?>

                <li class="nav-sidebar-menu-item <?php if($page_name == 'parent')echo 'active';?>">
                    <a href="<?php echo base_url();?>admin/parent" class="nav-sidebar-menu-link waves-effect">
                        <i class="fa fa-heart"></i>
                        <span class="nav-sidebar-menu-label hide-menu"><?php echo get_phrase('manage_parents');?></span>
                    </a>    
                </li>

            <?php endif;?>

            <!-- ========== 3. ASSESSMENT & PERFORMANCE ========== -->
            <?php $check_admin_permission = $this->db->get_where('admin_role', array('admin_id' => $this->session->userdata('login_user_id')))->row()->manage_attendance;?>
            <?php if($check_admin_permission == '1'):?>

                <li class="menu-section-divider"></li>
                
                <li class="menu-section-header">
                    <span class="sidebar-section-title">
                        <i class="fa fa-chart-line" style="color: #e67e22;"></i> ASSESSMENT & PERFORMANCE
                    </span>
                </li>

                <!-- Attendance -->
                <li class="menu-item">
                    <a href="javascript:void(0);" class="waves-effect" data-toggle="collapse" data-target="#attendance-menu">
                        <i class="fa fa-calendar-check-o p-r-10"></i>
                        <span class="hide-menu">Attendance</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse <?php
                        if ($page_name == 'manage_attendance' || $page_name == 'attendance_report') echo 'in';
                    ?>" id="attendance-menu">
                        <li class="<?php if ($page_name == 'manage_attendance') echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>admin/manage_attendance/<?php echo date("d/m/Y"); ?>">
                                <i class="fa fa-angle-double-right p-r-10"></i>
                                <span class="hide-menu"><?php echo get_phrase('mark_attendance'); ?></span>
                            </a>
                        </li>
                        <li class="<?php if ($page_name == 'attendance_report') echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>admin/attendance_report">
                                <i class="fa fa-angle-double-right p-r-10"></i>
                                <span class="hide-menu"><?php echo get_phrase('view_attendance'); ?></span>
                            </a>
                        </li>
                    </ul>
                </li>

            <?php endif;?>

            <!-- Exams -->
            <li class="menu-item">
                <a href="javascript:void(0);" class="waves-effect" data-toggle="collapse" data-target="#exams-menu">
                    <i class="fa fa-file-text-o p-r-10"></i>
                    <span class="hide-menu">Exams & Papers</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse <?php
                    if ($page_name == 'submit_exam' || $page_name == 'grade' ||  $page_name == 'createExamination' || $page_name == 'examQuestion') echo 'in';
                ?>" id="exams-menu">
                    <li class="<?php if ($page_name == 'examQuestion') echo 'active'; ?>">
                        <a href="<?php echo base_url(); ?>admin/examQuestion">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('question_paper'); ?></span>
                        </a>
                    </li>
                    <li class="<?php if ($page_name == 'createExamination') echo 'active'; ?>">
                        <a href="<?php echo base_url(); ?>admin/createExamination">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('Add Examination'); ?></span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- ========== 4. FINANCIAL MANAGEMENT ========== -->
            <li class="menu-section-divider"></li>
            
            <li class="menu-section-header">
                <span class="sidebar-section-title">
                    <i class="fa fa-money" style="color: #27ae60;"></i> FINANCIAL MANAGEMENT
                </span>
            </li>

            <!-- Fee Collection -->
            <?php if (is_feature_enabled('online_payments')): ?>
            <li class="menu-item">
                <a href="javascript:void(0);" class="waves-effect" data-toggle="collapse" data-target="#fees-menu">
                    <i class="fa fa-credit-card p-r-10"></i>
                    <span class="hide-menu">Fee Collection</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse <?php
                    if ($page_name == 'income' || $page_name == 'student_payment'|| $page_name == 'view_invoice_details'|| $page_name == 'invoice_add'|| $page_name == 'list_invoice'|| $page_name == 'studentSpecificPaymentQuery'|| $page_name == 'student_invoice') echo 'in';
                ?>" id="fees-menu">
                    <li class="<?php if ($page_name == 'student_payment') echo 'active'; ?>">
                        <a href="<?php echo base_url(); ?>admin/student_payment">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('collect_fees'); ?></span>
                        </a>
                    </li>
                    <li class="<?php if ($page_name == 'student_invoice') echo 'active'; ?>">
                        <a href="<?php echo base_url(); ?>admin/student_invoice">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('manage_invoice'); ?></span>
                        </a>
                    </li>
                </ul>
            </li>
            <?php endif; ?>

            <!-- Expenses -->
            <li class="menu-item">
                <a href="javascript:void(0);" class="waves-effect" data-toggle="collapse" data-target="#expenses-menu">
                    <i class="fa fa-shopping-cart p-r-10"></i>
                    <span class="hide-menu">Expenses</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse <?php
                    if ($page_name == 'expense' || $page_name == 'expense_category' ) echo 'in';
                ?>" id="expenses-menu">
                    <li class="<?php if ($page_name == 'expense') echo 'active'; ?>">
                        <a href="<?php echo base_url(); ?>expense/expense">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('expense'); ?></span>
                        </a>
                    </li>
                    <li class="<?php if ($page_name == 'expense_category') echo 'active'; ?>">
                        <a href="<?php echo base_url(); ?>expense/expense_category">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('expense_category'); ?></span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Academic Reports -->
            <li class="menu-item">
                <a href="javascript:void(0);" class="waves-effect" data-toggle="collapse" data-target="#academic-reports-menu">
                    <i class="fa fa-graduation-cap p-r-10"></i>
                    <span class="hide-menu">Academic Reports</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse <?php
                    if ($page_name == 'student_terminal_report' || $page_name == 'class_performance_report') echo 'in';
                ?>" id="academic-reports-menu">
                    <li class="<?php if ($page_name == 'student_terminal_report') echo 'active'; ?>">
                        <a href="<?php echo base_url(); ?>report/student_terminal_report">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('Student Terminal Report'); ?></span>
                        </a>
                    </li>
                    <li class="<?php if ($page_name == 'class_performance_report') echo 'active'; ?>">
                        <a href="<?php echo base_url(); ?>report/class_performance_report">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('Class Performance Report'); ?></span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Financial Reports -->
            <li class="menu-item">
                <a href="javascript:void(0);" class="waves-effect" data-toggle="collapse" data-target="#financial-reports-menu">
                    <i class="fa fa-bar-chart p-r-10"></i>
                    <span class="hide-menu">Financial Reports</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse <?php
                    if ($page_name == 'studentPaymentReport' || $page_name == 'classAttendanceReport' || $page_name == 'examMarkReport') echo 'in';
                ?>" id="financial-reports-menu">
                    <li class="<?php if ($page_name == 'studentPaymentReport') echo 'active'; ?>">
                        <a href="<?php echo base_url(); ?>report/studentPaymentReport">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('Student Payments'); ?></span>
                        </a>
                    </li>
                    <li class="<?php if ($page_name == 'classAttendanceReport') echo 'active'; ?>">
                        <a href="<?php echo base_url(); ?>report/classAttendanceReport">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('Attendance Report'); ?></span>
                        </a>
                    </li>
                    <li class="<?php if ($page_name == 'examMarkReport') echo 'active'; ?>">
                        <a href="<?php echo base_url(); ?>report/examMarkReport">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('Exam Mark Report'); ?></span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- ========== 5. TEACHING RESOURCES ========== -->
            <?php $check_admin_permission = $this->db->get_where('admin_role', array('admin_id' => $this->session->userdata('login_user_id')))->row()->download_page;?>
            <?php if($check_admin_permission == '1'):?>

                <li class="menu-section-divider"></li>
                
                <li class="menu-section-header">
                    <span class="sidebar-section-title">
                        <i class="fa fa-book-open" style="color: #e74c3c;"></i> TEACHING RESOURCES
                    </span>
                </li>

                <!-- Assignments -->
                <li class="menu-item <?php if ($page_name == 'assignment') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>assignment/assignment" class="waves-effect">
                        <i class="fa fa-tasks p-r-10"></i>
                        <span class="hide-menu"><?php echo get_phrase('assignments'); ?></span>
                    </a>
                </li>

                <!-- Study Materials -->
                <li class="menu-item <?php if ($page_name == 'study_material') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>studymaterial/study_material" class="waves-effect">
                        <i class="fa fa-newspaper-o p-r-10"></i>
                        <span class="hide-menu"><?php echo get_phrase('study_materials'); ?></span>
                    </a>
                </li>

            <?php endif;?>

            <!-- ========== 6. FACILITIES MANAGEMENT ========== -->
            
            <!-- Hostel -->
            <?php if (is_feature_enabled('hostel')): ?>
            <li class="menu-section-divider"></li>
            
            <li class="menu-section-header">
                <span class="sidebar-section-title">
                    <i class="fa fa-building" style="color: #1abc9c;"></i> FACILITIES MANAGEMENT
                </span>
            </li>

            <li class="menu-item">
                <a href="javascript:void(0);" class="waves-effect" data-toggle="collapse" data-target="#hostel-menu">
                    <i class="fa fa-hotel p-r-10"></i>
                    <span class="hide-menu">Hostel</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse <?php
                    if ($page_name == 'dormitory' || $page_name == 'hostel_category' || $page_name == 'hostel_room' ) echo 'in';
                ?>" id="hostel-menu">
                    <li class="<?php if ($page_name == 'dormitory') echo 'active'; ?>">
                        <a href="<?php echo base_url(); ?>admin/dormitory">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('manage_hostel'); ?></span>
                        </a>
                    </li>
                    <li class="<?php if ($page_name == 'hostel_category') echo 'active'; ?>">
                        <a href="<?php echo base_url(); ?>admin/hostel_category">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('hostel_category'); ?></span>
                        </a>
                    </li>
                    <li class="<?php if ($page_name == 'hostel_room') echo 'active'; ?>">
                        <a href="<?php echo base_url(); ?>admin/hostel_room">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('hostel_room'); ?></span>
                        </a>
                    </li>
                </ul>
            </li>
            <?php endif;?>

            <!-- Transportation -->
            <?php if (is_feature_enabled('transportation')): ?>
            <li class="menu-item">
                <a href="javascript:void(0);" class="waves-effect" data-toggle="collapse" data-target="#transport-menu">
                    <i class="fa fa-bus p-r-10"></i>
                    <span class="hide-menu">Transportation</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse <?php
                    if ($page_name == 'transport' || $page_name == 'transport_route' || $page_name == 'vehicle' ) echo 'in';
                ?>" id="transport-menu">
                    <li class="<?php if ($page_name == 'transport') echo 'active'; ?>">
                        <a href="<?php echo base_url(); ?>transportation/transport">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('transports'); ?></span>
                        </a>
                    </li>
                    <li class="<?php if ($page_name == 'transport_route') echo 'active'; ?>">
                        <a href="<?php echo base_url(); ?>transportation/transport_route">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('transport_route'); ?></span>
                        </a>
                    </li>
                    <li class="<?php if ($page_name == 'vehicle') echo 'active'; ?>">
                        <a href="<?php echo base_url(); ?>transportation/vehicle">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('manage_vehicle'); ?></span>
                        </a>
                    </li>
                </ul>
            </li>
            <?php endif;?>

            <!-- ========== 7. CONFIGURATION ========== -->
            <li class="menu-section-divider"></li>
            
            <li class="menu-section-header">
                <span class="sidebar-section-title">
                    <i class="fa fa-cogs" style="color: #95a5a6;"></i> CONFIGURATION
                </span>
            </li>

            <li class="menu-item">
                <a href="javascript:void(0);" class="waves-effect" data-toggle="collapse" data-target="#settings-menu">
                    <i class="fa fa-sliders p-r-10"></i>
                    <span class="hide-menu">System Settings</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse <?php
                    if ($page_name == 'system_settings' || $page_name == 'manage_language' || $page_name == 'paymentSetting' || $page_name == 'sms_settings') echo 'in';
                ?>" id="settings-menu">
                    <li class="<?php if ($page_name == 'system_settings') echo 'active'; ?>">
                        <a href="<?php echo base_url(); ?>systemsetting/system_settings">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('general_settings'); ?></span>
                        </a>
                    </li>
                    <li class="<?php if ($page_name == 'sms_settings') echo 'active'; ?>">
                        <a href="<?php echo base_url(); ?>smssetting/sms_settings">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('manage_sms_api'); ?></span>
                        </a>
                    </li>
                    <li class="<?php if ($page_name == 'manage_language') echo 'active'; ?>">
                        <a href="<?php echo base_url(); ?>admin/manage_language">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('manage_language'); ?></span>
                        </a>
                    </li>
                    <li class="<?php if ($page_name == 'paymentSetting') echo 'active'; ?>">
                        <a href="<?php echo base_url(); ?>payment/paymentSetting">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('Payment Settings'); ?></span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- ========== 8. ADMINISTRATION ========== -->
            <?php $checking_level = $this->db->get_where('admin', array('admin_id' => $this->session->userdata('login_user_id')))->row()->level;?>
            <?php if($checking_level == '1' || $checking_level == '2'):?>

                <li class="menu-section-divider"></li>
                
                <li class="menu-section-header">
                    <span class="sidebar-section-title">
                        <i class="fa fa-lock" style="color: #5865F2;"></i> ADMINISTRATION
                    </span>
                </li>

                <?php if($checking_level == '1'):?>
                <li class="menu-item">
                    <a href="javascript:void(0);" class="waves-effect" data-toggle="collapse" data-target="#admin-menu">
                        <i class="fa fa-user-shield p-r-10"></i>
                        <span class="hide-menu">Manage Admins</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse <?php
                        if ($page_name == 'newAdministrator' || $page_name == 'admin_add') echo 'in';
                    ?>" id="admin-menu">
                        <li class="<?php if ($page_name == 'admin_add') echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>admin/newAdministrator">
                                <i class="fa fa-angle-double-right p-r-10"></i>
                                <span class="hide-menu"><?php echo get_phrase('Manage Admins'); ?></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif;?>

                <?php if($checking_level == '2'):?>
                <li class="menu-item <?php if ($page_name == 'manage_profile') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>admin/manage_profile" class="waves-effect">
                        <i class="fa fa-id-card p-r-10"></i>
                        <span class="hide-menu"><?php echo get_phrase('manage_profile'); ?></span>
                    </a>
                </li>
                <?php endif;?>

            <?php endif;?>

            <!-- Logout -->
            <li class="menu-item">
                <a href="<?php echo base_url(); ?>login/logout" class="waves-effect">
                    <i class="fa fa-sign-out p-r-10"></i>
                    <span class="hide-menu"><?php echo get_phrase('Logout'); ?></span>
                </a>
            </li>

        </ul>
    </div>
</div>
<!-- Left navbar-header end -->

<style>
/* ========== PHASE 2: VISUAL ENHANCEMENTS ========== */

/* Section Headers Styling */
.sidebar-section-header {
    list-style: none;
    padding: 15px 20px 10px 20px;
    margin: 0;
    border-bottom: none;
}

.sidebar-section-title {
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    color: #555;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* Section Divider */
.menu-section-divider {
    height: 1px;
    background: linear-gradient(to right, transparent, #ddd, transparent);
    margin: 15px 0;
    list-style: none;
    padding: 0;
}

/* Menu Items */
.menu-item {
    list-style: none;
    margin-bottom: 2px;
}

.menu-item > a {
    padding: 10px 15px;
    border-left: 3px solid transparent;
    transition: all 0.3s ease;
    display: block;
    line-height: 1.6;
}

.menu-item > a:hover {
    background-color: #f5f5f5;
    border-left-color: #3498db;
    padding-left: 18px;
}

.menu-item.active > a {
    background-color: #f0f0f0;
    border-left-color: #3498db;
    font-weight: 600;
    color: #03a9f3;
}

/* Submenu Icons */
.menu-item .fa-arrow {
    float: right;
    transition: transform 0.3s ease;
}

.menu-item .collapse.in ~ a .fa-arrow,
.menu-item > a[data-toggle="collapse"]:not(.collapsed) .fa-arrow {
    transform: rotate(-90deg);
}

/* Nav Second Level (Submenu) */
.nav-second-level {
    background-color: #f9f9f9;
    border-left: 2px solid #ecf0f1;
    padding-left: 0;
    margin: 5px 0;
}

.nav-second-level li {
    list-style: none;
    padding-left: 0;
    margin: 0;
}

.nav-second-level li > a {
    padding: 10px 15px 10px 35px;
    font-size: 13px;
    color: #666;
    transition: all 0.2s ease;
    display: block;
    line-height: 1.8;
}

.nav-second-level li > a:hover {
    background-color: #f0f0f0;
    padding-left: 40px;
}

.nav-second-level li.active > a {
    color: #3498db;
    font-weight: 600;
    background-color: #f0f0f0;
}

/* Icon Colors by Category */
.fa-book { color: #3498db !important; }
.fa-users { color: #9b59b6 !important; }
.fa-chart-line { color: #e67e22 !important; }
.fa-money { color: #27ae60 !important; }
.fa-book-open { color: #e74c3c !important; }
.fa-building { color: #1abc9c !important; }
.fa-cogs { color: #95a5a6 !important; }
.fa-lock { color: #5865F2 !important; }

/* Dashboard Icon Special Color */
.ti-dashboard { color: #2ecc71 !important; }

/* Smooth Collapse Transition */
.collapse {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
}

.collapse.in {
    max-height: 1000px;
}

/* Active State Enhancement */
.menu-item.active {
    border-radius: 0;
}

/* Responsive adjustments for small screens */
@media (max-width: 768px) {
    .sidebar-section-title {
        font-size: 11px;
    }

    .menu-item > a {
        padding: 8px 10px;
    }

    .menu-item > a:hover {
        padding-left: 15px;
    }

    .nav-second-level li > a {
        padding: 7px 10px 7px 30px;
    }

    .nav-second-level li > a:hover {
        padding-left: 35px;
    }
}
</style>
