<?php
/**
 * Dashboard - Financial Overview
 */
?>

<style>
    .dashboard-container {
        font-family: Poppins, sans-serif;
    }

    .section-title {
        font-size: 16pt;
        font-weight: 600;
        color: #2b2b2b;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid #03a9f3;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: #03a9f3;
        font-size: 18pt;
    }

    /* Quick Links Cards */
    .quick-links-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
        margin-bottom: 30px;
    }

    .quick-link-card {
        background: linear-gradient(135deg, #03a9f3 0%, #0288d1 100%);
        color: white;
        padding: 20px;
        border-radius: 8px;
        text-align: center;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
        font-weight: 500;
    }

    .quick-link-card i {
        font-size: 28pt;
    }

    .quick-link-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(3, 169, 243, 0.3);
        text-decoration: none;
        color: white;
    }

    /* Stats Cards */
    .stats-card {
        background: white;
        border-radius: 8px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        border: 1px solid #e4e7ea;
        transition: all 0.3s ease;
    }

    .stats-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }

    .stat-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 60px;
        border-radius: 8px;
        margin-bottom: 15px;
        font-size: 28pt;
        color: white;
    }

    .stat-icon.blue {
        background: linear-gradient(135deg, #03a9f3 0%, #0288d1 100%);
    }

    .stat-icon.green {
        background: linear-gradient(135deg, #00c292 0%, #00897b 100%);
    }

    .stat-icon.orange {
        background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
    }

    .stat-icon.purple {
        background: linear-gradient(135deg, #9c27b0 0%, #7b1fa2 100%);
    }

    .stat-number {
        font-size: 24pt;
        font-weight: 700;
        color: #03a9f3;
        margin-bottom: 8px;
    }

    .stat-label {
        font-size: 12pt;
        color: #686868;
        font-weight: 500;
    }

    /* Action Buttons Card */
    .action-buttons-card {
        background: white;
        border-radius: 8px;
        padding: 25px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        border: 1px solid #e4e7ea;
        margin-bottom: 20px;
    }

    .action-buttons-card .card-title {
        font-size: 14pt;
        font-weight: 600;
        color: #2b2b2b;
        margin-bottom: 20px;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 12px 20px;
        border-radius: 6px;
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 500;
        font-size: 12pt;
        gap: 8px;
        width: 100%;
        text-align: center;
        margin-bottom: 15px;
    }

    .action-btn-blue {
        background: linear-gradient(135deg, #03a9f3 0%, #0288d1 100%);
        color: white;
    }

    .action-btn-blue:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(3, 169, 243, 0.3);
        text-decoration: none;
        color: white;
    }

    .action-btn-green {
        background: linear-gradient(135deg, #00c292 0%, #00897b 100%);
        color: white;
    }

    .action-btn-green:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 194, 146, 0.3);
        text-decoration: none;
        color: white;
    }

    .action-btn-orange {
        background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
        color: white;
    }

    .action-btn-orange:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(255, 152, 0, 0.3);
        text-decoration: none;
        color: white;
    }

    .action-btn-purple {
        background: linear-gradient(135deg, #9c27b0 0%, #7b1fa2 100%);
        color: white;
    }

    .action-btn-purple:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(156, 39, 176, 0.3);
        text-decoration: none;
        color: white;
    }

    /* Data Display Card */
    .data-display-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        border: 1px solid #e4e7ea;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .card-header-green {
        background: linear-gradient(135deg, #00c292 0%, #00897b 100%);
        color: white;
        padding: 18px 25px;
        font-weight: 600;
        font-size: 13pt;
    }

    /* Table Styling */
    .dashboard-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 0;
    }

    .dashboard-table thead {
        background: #f5f5f5;
    }

    .dashboard-table th {
        padding: 15px;
        text-align: left;
        font-weight: 600;
        color: #2b2b2b;
        font-size: 12pt;
        border-bottom: 2px solid #e4e7ea;
    }

    .dashboard-table td {
        padding: 15px;
        border-bottom: 1px solid #e4e7ea;
        color: #686868;
        font-size: 12pt;
    }

    .dashboard-table tbody tr:hover {
        background: #f9fbfd;
    }

    .table-body-content {
        padding: 20px 25px;
    }

    .badge-income {
        background: linear-gradient(135deg, #00c292 0%, #00897b 100%);
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11pt;
        font-weight: 500;
    }

    .badge-expense {
        background: linear-gradient(135deg, #f44236 0%, #d32f2f 100%);
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11pt;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .quick-links-grid {
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        }

        .section-title {
            font-size: 14pt;
        }

        .action-btn {
            margin-bottom: 10px;
        }
    }
</style>

<!-- Row -->
<!-- QUICK LINKS SECTION -->
<div class="dashboard-container">
    <div style="margin-bottom: 30px;">
        <div class="section-title">
            <i class="fa fa-bolt"></i> Quick Links
        </div>
        <div class="quick-links-grid">
            <a href="<?php echo base_url();?>accountant/student_payment" class="quick-link-card">
                <i class="fa fa-plus-circle"></i>
                <small>Record Payment</small>
            </a>
            <a href="<?php echo base_url();?>accountant/view_invoices" class="quick-link-card">
                <i class="fa fa-file-text-o"></i>
                <small>View Invoices</small>
            </a>
            <a href="<?php echo base_url();?>accountant/financial_report" class="quick-link-card">
                <i class="fa fa-bar-chart"></i>
                <small>Financial Report</small>
            </a>
            <a href="<?php echo base_url();?>accountant/expense_management" class="quick-link-card">
                <i class="fa fa-money"></i>
                <small>Manage Expenses</small>
            </a>
        </div>
    </div>

    <!-- STATISTICS SECTION -->
    <div style="margin-bottom: 30px;">
        <div class="section-title">
            <i class="fa fa-bar-chart"></i> Financial Overview
        </div>
        <div class="row">
            <!-- Total Invoices -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="stats-card">
                    <div class="stat-icon blue">
                        <i class="ti-file"></i>
                    </div>
                    <div class="stat-number"><?php echo isset($total_invoices) ? $total_invoices : 0; ?></div>
                    <div class="stat-label"><?php echo get_phrase('Total Invoices'); ?></div>
                </div>
            </div>

            <!-- Paid Invoices -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="stats-card">
                    <div class="stat-icon green">
                        <i class="ti-check"></i>
                    </div>
                    <div class="stat-number"><?php echo isset($paid_invoices) ? $paid_invoices : 0; ?></div>
                    <div class="stat-label"><?php echo get_phrase('Paid Invoices'); ?></div>
                </div>
            </div>

            <!-- Unpaid Invoices -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="stats-card">
                    <div class="stat-icon orange">
                        <i class="ti-time"></i>
                    </div>
                    <div class="stat-number"><?php echo isset($unpaid_invoices) ? $unpaid_invoices : 0; ?></div>
                    <div class="stat-label"><?php echo get_phrase('Unpaid Invoices'); ?></div>
                </div>
            </div>

            <!-- Net Balance -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="stats-card">
                    <div class="stat-icon purple">
                        <i class="ti-money"></i>
                    </div>
                    <div class="stat-number"><?php echo get_currency_symbol() . ' ' . number_format((isset($net_balance) ? $net_balance : 0), 2); ?></div>
                    <div class="stat-label"><?php echo get_phrase('Net Balance'); ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- ACTION BUTTONS SECTION -->
    <div class="row" style="margin-bottom: 30px;">
        <div class="col-md-12">
            <div class="action-buttons-card">
                <div class="card-title">
                    <i class="fa fa-tasks"></i> Quick Actions
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a href="<?php echo base_url(); ?>accountant/invoices" class="action-btn action-btn-blue">
                            <i class="fa fa-file"></i> Manage Invoices
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a href="<?php echo base_url(); ?>accountant/payments" class="action-btn action-btn-green">
                            <i class="fa fa-money"></i> Record Payment
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a href="<?php echo base_url(); ?>accountant/reports" class="action-btn action-btn-orange">
                            <i class="fa fa-bar-chart"></i> Financial Reports
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a href="<?php echo base_url(); ?>accountant/manage_profile" class="action-btn action-btn-purple">
                            <i class="fa fa-user"></i> My Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- RECENT TRANSACTIONS SECTION -->
    <?php if (isset($recent_transactions) && !empty($recent_transactions)): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="data-display-card">
                <div class="card-header-green">
                    <i class="fa fa-history"></i> Recent Transactions
                </div>
                <div class="table-body-content">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th><?php echo get_phrase('Title'); ?></th>
                                <th><?php echo get_phrase('Type'); ?></th>
                                <th><?php echo get_phrase('Amount'); ?></th>
                                <th><?php echo get_phrase('Date'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_transactions as $transaction): ?>
                            <tr>
                                <td><?php echo isset($transaction['title']) ? $transaction['title'] : '-'; ?></td>
                                <td>
                                    <span class="<?php echo ($transaction['payment_type'] == 'income') ? 'badge-income' : 'badge-expense'; ?>">
                                        <?php echo ucfirst($transaction['payment_type']); ?>
                                    </span>
                                </td>
                                <td><strong><?php echo get_currency_symbol() . ' ' . number_format($transaction['amount'], 2); ?></strong></td>
                                <td><?php echo date('Y-m-d', $transaction['timestamp']); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

