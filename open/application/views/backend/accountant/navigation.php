<?php
/**
 * Accountant Sidebar Navigation - Reorganized to match Admin Sidebar Structure
 */
?>

<style>
    /* Additional responsive fixes for accountant sidebar */
    .sidebar #side-menu .menu-item.active > a {
        color: var(--active-color) !important;
        border-left-color: var(--active-color) !important;
    }
    
    .sidebar #side-menu .nav-second-level li.active > a {
        color: var(--active-color) !important;
    }
</style>

<!-- Left navbar-header -->
<div class="navbar-default sidebar accountant-sidebar" role="navigation">
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
            <li class="user-pro">
                <?php
                    $name = $this->crud_model->get_type_name_by_id('accountant', $this->session->userdata('accountant_id'), 'name');
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

            <!-- ========== DASHBOARD ========== -->
            <li class="menu-item <?php if ($page_name == 'accountant_dashboard') echo 'active'; ?>">
                <a href="<?php echo base_url();?>accountant/dashboard" class="waves-effect">
                    <i class="ti-dashboard p-r-10" style="color: #2ecc71;"></i>
                    <span class="hide-menu"><?php echo get_phrase('Dashboard') ;?></span>
                </a>
            </li>

            <!-- ========== FINANCIAL MANAGEMENT ========== -->
            <li class="menu-section-divider"></li>
            
            <li class="menu-section-header">
                <span class="sidebar-section-title">
                    <i class="fa fa-bar-chart-o" style="color: #00c292;"></i> FINANCIAL MANAGEMENT
                </span>
            </li>

            <!-- Financial Summary -->
            <li class="menu-item <?php if ($page_name == 'financial_summary' || $page_name == 'invoices') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>accountant/invoices" class="waves-effect">
                    <i class="ti-receipt p-r-10"></i>
                    <span class="hide-menu"><?php echo get_phrase('Financial Summary'); ?></span>
                </a>
            </li>

            <!-- Tuition Fees -->
            <li class="menu-item <?php if ($page_name == 'tuition_payment') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>accountant/tuition_payment" class="waves-effect">
                    <i class="fa fa-graduation-cap p-r-10"></i>
                    <span class="hide-menu">Tuition Fees</span>
                </a>
            </li>

            <!-- Daily Fees -->
            <li class="menu-item <?php if ($page_name == 'daily_fees' || $page_name == 'dailyfee') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>dailyfee" class="waves-effect">
                    <i class="ti-calendar p-r-10"></i>
                    <span class="hide-menu">Daily Fees</span>
                </a>
            </li>

            <!-- Salary Management -->
            <li class="menu-item <?php if ($page_name == 'salary') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>salary" class="waves-effect">
                    <i class="ti-money p-r-10"></i>
                    <span class="hide-menu">Salary Management</span>
                </a>
            </li>

            <!-- Fee Configuration -->
            <li class="menu-item <?php if ($page_name == 'fee_configuration' || $page_name == 'classfee') echo 'active'; ?>">
                <a href="javascript:void(0);" class="waves-effect" data-toggle="collapse" data-target="#fee-config-menu">
                    <i class="ti-settings p-r-10"></i>
                    <span class="hide-menu">Fee Configuration</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse <?php
                    if ($page_name == 'fee_configuration' || $page_name == 'classfee') echo 'in';
                ?>" id="fee-config-menu">
                    <li class="<?php if ($page_name == 'classfee') echo 'active'; ?>">
                        <a href="<?php echo base_url(); ?>classfee" class="waves-effect">
                            <i class="fa fa-angle-double-right p-r-10"></i>
                            <span class="hide-menu">Class Fee Setup</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- ========== REPORTS & ANALYTICS ========== -->
            <li class="menu-section-divider"></li>
            
            <li class="menu-section-header">
                <span class="sidebar-section-title">
                    <i class="fa fa-line-chart" style="color: #03a9f3;"></i> REPORTS & ANALYTICS
                </span>
            </li>

            <!-- Reports -->
            <li class="menu-item <?php if ($page_name == 'reports') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>accountant/reports" class="waves-effect">
                    <i class="ti-stats-up p-r-10"></i>
                    <span class="hide-menu"><?php echo get_phrase('Reports'); ?></span>
                </a>
            </li>

            <!-- ========== ADMINISTRATION ========== -->
            <li class="menu-section-divider"></li>
            
            <li class="menu-section-header">
                <span class="sidebar-section-title">
                    <i class="fa fa-lock" style="color: #34495e;"></i> ADMINISTRATION
                </span>
            </li>

            <!-- Accountants -->
            <li class="menu-item <?php if ($page_name == 'accountants') echo 'active'; ?>">
                <a href="<?php echo base_url(); ?>accountant/accountants" class="waves-effect">
                    <i class="fa fa-users p-r-10"></i>
                    <span class="hide-menu"><?php echo get_phrase('Accountants'); ?></span>
                </a>
            </li>

        </ul>
    </div>
</div>