<!-- Left navbar-header -->
<div class="navbar-default sidebar parent-sidebar" role="navigation">
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
            <li> <a href="<?php echo base_url();?>parents/dashboard" class="waves-effect"><i class="ti-dashboard p-r-10"></i> <span class="hide-menu"><?php echo get_phrase('Dashboard') ;?></span></a> </li>

            <!-- MONITORING SECTION -->
            <div class="nav-category nav-monitoring"><i class="fa fa-eye" style="margin-right: 8px;"></i>Student Progress</div>
            <li> <a href="#" class="waves-effect"><i data-icon="&#xe006;" class="fa fa-book p-r-10"></i> <span class="hide-menu"><?php echo get_phrase('Academics');?><span class="fa arrow"></span></span></a>
        
        <ul class=" nav nav-second-level<?php
            if ($page_name == 'subject' ||
                    $page_name == 'teacher' ||
                    $page_name == 'class_mate' ||
                    $page_name == 'assignment' || $page_name == 'study_material' )
                echo 'opened active';
            ?>">


            
                <li class="<?php if ($page_name == 'subject') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>parents/subject">
                        <i class="fa fa-angle-double-right p-r-10"></i>
                        <span class="hide-menu"><?php echo get_phrase('Subject'); ?></span>
                    </a>
                </li>


                <li class="<?php if ($page_name == 'teacher') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>parents/teacher">
                        <i class="fa fa-angle-double-right p-r-10"></i>
                        <span class="hide-menu"><?php echo get_phrase('Teacher'); ?></span>
                    </a>
                </li>

                    
                <li class="<?php if ($page_name == 'class_mate') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>parents/class_mate">
                        <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('Class Mate'); ?></span>
                    </a>
                </li>

                    
                <li class="<?php if ($page_name == 'assignment') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>assignment/assignment">
                        <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('Assignment'); ?></span>
                    </a>
                </li>

                <li class="<?php if ($page_name == 'study_material') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>studymaterial/study_material">
                        <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu"><?php echo get_phrase('Study Material'); ?></span>
                    </a>
                </li>

             
 
         </ul>
    </li>

            <!-- FINANCES SECTION -->
            <div class="nav-category nav-finances"><i class="fa fa-credit-card" style="margin-right: 8px;"></i>Finances</div>
            <li class="<?php if ($page_name == 'invoice') echo 'active'; ?> ">
                <a href="<?php echo base_url(); ?>parents/invoice">
                    <i class="fa fa-paypal p-r-10"></i>
                        <span class="hide-menu"><?php echo get_phrase('Invoice'); ?></span>
                </a>
            </li> 

        <li class="<?php if ($page_name == 'payment_history') echo 'active'; ?> ">
                <a href="<?php echo base_url(); ?>parents/payment_history">
                    <i class="fa fa-credit-card p-r-10"></i>
                        <span class="hide-menu"><?php echo get_phrase('Payment History'); ?></span>
                </a>
        </li>

            <!-- PROFILE SECTION -->
            <div class="nav-category nav-profile"><i class="fa fa-user-circle" style="margin-right: 8px;"></i>Profile</div>
            <li class="<?php if ($page_name == 'manage_profile') echo 'active'; ?> ">
                <a href="<?php echo base_url(); ?>parents/manage_profile">
                    <i class="fa fa-gears p-r-10"></i>
                        <span class="hide-menu"><?php echo get_phrase('manage_profile'); ?></span>
                </a>
            </li>

            <li class="">
                <a href="<?php echo base_url(); ?>login/logout">
                    <i class="fa fa-sign-out p-r-10"></i>
                        <span class="hide-menu"><?php echo get_phrase('Logout'); ?></span>
                </a>
            </li>
                  
                  
        </ul>
    </div>
</div>

<style>
    /* Navigation Category Headers */
    .nav-category {
        display: flex;
        align-items: center;
        padding: 12px 20px 10px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: #ffffff;
        margin-top: 15px;
        margin-bottom: 5px;
        border-radius: 2px;
        background: linear-gradient(135deg, var(--category-color) 0%, var(--category-color-dark) 100%);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    /* Category Color Variables */
    .nav-monitoring { --category-color: #e67e22; --category-color-dark: #d35400; }
    .nav-finances { --category-color: #2ecc71; --category-color-dark: #27ae60; }
    .nav-profile { --category-color: #3498db; --category-color-dark: #2980b9; }

    /* Navigation Links */
    #side-menu > li > a {
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
    }

    #side-menu > li > a:hover {
        border-left-color: #e67e22;
        padding-left: 17px;
        background: rgba(230, 126, 34, 0.1);
    }

    /* Active Link State */
    #side-menu > li > a.active {
        border-left: 3px solid #e67e22 !important;
        background: #e67e22 !important;
        color: #fff !important;
        font-weight: 600;
    }

    #side-menu > li > a.active:hover {
        background: #d35400 !important;
    }

    #side-menu > li > a.active .hide-menu {
        color: #fff !important;
    }

    #side-menu > li > a.active i {
        color: #fff !important;
    }

    /* Icon Styling */
    #side-menu i {
        color: #999;
    }

    #side-menu > li > a:hover i {
        color: #e67e22;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .nav-category {
            padding: 10px 15px 8px;
            font-size: 10px;
        }
    }

    /* Collapsed Sidebar - Hide Category Headers */
    .content-wrapper .nav-category {
        display: none;
    }

    /* Show only icons on hover when collapsed */
    .content-wrapper .sidebar #side-menu > li:hover .nav-category {
        display: flex;
        width: 240px;
        position: absolute;
        left: 60px;
        top: 0;
        background: rgba(0,0,0,0.95);
        border-radius: 2px;
        z-index: 999;
    }
</style>

<!-- Left navbar-header end -->