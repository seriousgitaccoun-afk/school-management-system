<style>
    /* Additional responsive fixes for teacher sidebar */
    .sidebar #side-menu .menu-item.active > a {
        color: var(--active-color) !important;
        border-left-color: var(--active-color) !important;
    }
    
    .sidebar #side-menu .nav-second-level li.active > a {
        color: var(--active-color) !important;
    }
</style>

    <!-- Left navbar-header -->
<div class="navbar-default sidebar teacher-sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse slimscrollsidebar">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search hidden-sm hidden-md hidden-lg">
                <!-- input-group -->
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search..."> <span class="input-group-btn">
                        <button class="btn btn-default" type="button"> <i class="fa fa-search"></i> </button>
                            </span> </div>
                        <!-- /input-group -->
            </li>
            
            <li class="user-pro">
                        <?php
                            $account_type   =   $this->session->userdata('login_type');
                            $account_id     =   $account_type.'_id';
                            $name           =   $this->crud_model->get_type_name_by_id($account_type , $this->session->userdata($account_id), 'name');
                        ?>
                    <a href="#" class="waves-effect" style="display: flex; align-items: center; gap: 10px;">
                        <?php echo get_avatar_badge($name, 45); ?>
                        <span class="hide-menu">
                            <?php echo $name; ?>
                            <span class="fa arrow"></span>
                        </span>
                    </a>
                        <ul class="nav nav-second-level">
                            <li><a href="javascript:void(0)"><i class="ti-user"></i> My Profile</a></li>
                            <li><a href="javascript:void(0)"><i class="ti-email"></i> Inbox</a></li>
                            <li><a href="javascript:void(0)"><i class="ti-settings"></i> Account Setting</a></li>
                            <li><a href="<?php echo base_url();?>login/logout"><i class="fa fa-power-off"></i> Logout</a></li>
                        </ul>
                </li>

            <!-- Dashboard -->
            <li class="menu-item <?php if ($page_name == 'dashboard') echo 'active'; ?>">
                <a href="<?php echo base_url();?>teacher/dashboard" class="waves-effect">
                    <i class="ti-dashboard p-r-10" style="color: #2ecc71;"></i>
                    <span class="hide-menu"><?php echo get_phrase('Dashboard') ;?></span>
                </a>
            </li>

            <!-- ========== TEACHING RESOURCES ========== -->
            <li class="menu-section-divider"></li>
            
            <li class="menu-section-header">
                <span class="sidebar-section-title">
                    <i class="fa fa-book" style="color: #3498db;"></i> TEACHING RESOURCES
                </span>
            </li>

            <!-- Assignments & Materials -->
            <li class="menu-item">
                <a href="javascript:void(0);" class="waves-effect" data-toggle="collapse" data-target="#teaching-menu">
                    <i class="fa fa-book p-r-10"></i>
                    <span class="hide-menu"><?php echo get_phrase('Resources');?></span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse <?php
                    if ($page_name == 'assignment' || $page_name == 'study_material')
                        echo 'in';
                ?>" id="teaching-menu">
                    <li class="<?php if ($page_name == 'assignment') echo 'active'; ?>">
                        <a href="<?php echo base_url(); ?>assignment/assignment">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('assignments'); ?></span>
                        </a>
                    </li>
                    <li class="<?php if ($page_name == 'study_material') echo 'active'; ?>">
                        <a href="<?php echo base_url(); ?>studymaterial/study_material">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('study_materials'); ?></span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- ========== ATTENDANCE & PERFORMANCE ========== -->
            <li class="menu-section-divider"></li>
            
            <li class="menu-section-header">
                <span class="sidebar-section-title">
                    <i class="fa fa-clipboard" style="color: #e67e22;"></i> ATTENDANCE & MARKS
                </span>
            </li>

            <!-- Attendance -->
            <li class="menu-item">
                <a href="javascript:void(0);" class="waves-effect" data-toggle="collapse" data-target="#attendance-menu">
                    <i class="fa fa-calendar-check-o p-r-10"></i>
                    <span class="hide-menu"><?php echo get_phrase('Attendance');?></span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse <?php
                    if ($page_name == 'manage_attendance' || $page_name == 'attendance_report')
                        echo 'in';
                ?>" id="attendance-menu">
                    <li class="<?php if ($page_name == 'manage_attendance') echo 'active'; ?>">
                        <a href="<?php echo base_url(); ?>teacher/manage_attendance/<?php echo date("d/m/Y"); ?>">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('Mark Attendance'); ?></span>
                        </a>
                    </li>
                    <li class="<?php if ($page_name == 'attendance_report') echo 'active'; ?>">
                        <a href="<?php echo base_url(); ?>teacher/attendance_report">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('View Attendance'); ?></span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Student Scores -->
            <li class="menu-item">
                <a href="javascript:void(0);" class="waves-effect" data-toggle="collapse" data-target="#scores-menu">
                    <i class="fa fa-bar-chart-o p-r-10"></i>
                    <span class="hide-menu"><?php echo get_phrase('Student Scores');?></span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse <?php
                    if ($page_name == 'marks' || $page_name == 'student_marksheet_subject')
                        echo 'in';
                ?>" id="scores-menu">
                    <?php $select_role = $this->db->get_where('teacher', array('teacher_id' => $this->session->userdata('teacher_id')))->row()->role;?>
                    <?php if($select_role == '1'):?>
                        <li class="<?php if ($page_name == 'marks') echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>teacher/marks">
                                <i class="fa fa-angle-double-right p-r-10"></i>
                                <span class="hide-menu"><?php echo get_phrase('Class Teacher'); ?></span>
                            </a>
                        </li>
                    <?php endif;?>
                    <?php if($select_role == '2'):?>
                        <li class="<?php if ($page_name == 'student_marksheet_subject') echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>teacher/student_marksheet_subject">
                                <i class="fa fa-angle-double-right p-r-10"></i>
                                <span class="hide-menu"><?php echo get_phrase('Subject Teacher'); ?></span>
                            </a>
                        </li>
                    <?php endif;?>
                </ul>
            </li>

            <!-- ========== PROFILE ========== -->
            <li class="menu-section-divider"></li>
            
            <li class="menu-section-header">
                <span class="sidebar-section-title">
                    <i class="fa fa-user-circle" style="color: #9b59b6;"></i> PROFILE
                </span>
            </li>

            <!-- Manage Profile -->
            <li class="menu-item <?php if ($page_name == 'manage_profile') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>teacher/manage_profile" class="waves-effect">
                    <i class="fa fa-gears p-r-10"></i>
                    <span class="hide-menu"><?php echo get_phrase('Manage Profile'); ?></span>
                </a>
            </li>

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