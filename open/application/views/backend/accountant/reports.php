<?php
/**
 * Reports - Financial Analysis
 */
?>

<!-- Row -->
<div class="row">
    <!-- Column -->
    <div class="col-md-3 col-sm-6">
        <div class="white-box">
            <div class="r-icon-stats">
                <i class="ti-file bg-megna"></i>
                <div class="bodystate">
                    <h4><?php echo isset($total_invoices) ? $total_invoices : 0; ?></h4>
                    <span class="text-muted"><?php echo get_phrase('Total Invoices'); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Column -->
    <div class="col-md-3 col-sm-6">
        <div class="white-box">
            <div class="r-icon-stats">
                <i class="ti-check bg-success"></i>
                <div class="bodystate">
                    <h4><?php echo isset($paid_invoices) ? $paid_invoices : 0; ?></h4>
                    <span class="text-muted"><?php echo get_phrase('Paid Invoices'); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Column -->
    <div class="col-md-3 col-sm-6">
        <div class="white-box">
            <div class="r-icon-stats">
                <i class="ti-time bg-warning"></i>
                <div class="bodystate">
                    <h4><?php echo isset($unpaid_invoices) ? $unpaid_invoices : 0; ?></h4>
                    <span class="text-muted"><?php echo get_phrase('Unpaid Invoices'); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Column -->
    <div class="col-md-3 col-sm-6">
        <div class="white-box">
            <div class="r-icon-stats">
                <i class="ti-percent bg-inverse"></i>
                <div class="bodystate">
                    <h4><?php echo isset($payment_rate) ? $payment_rate : 0; ?>%</h4>
                    <span class="text-muted"><?php echo get_phrase('Payment Rate'); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Row -->
<div class="row">
    <div class="col-md-6">
        <div class="white-box">
            <h3 class="box-title m-b-20"><i class="ti-money"></i> <?php echo get_phrase('Income'); ?></h3>
            <div class="table-responsive">
                <table class="table table-condensed table-striped">
                    <tr>
                        <td><?php echo get_phrase('Total Income'); ?></td>
                        <td class="text-right"><strong><?php echo get_currency_symbol() . ' ' . number_format((isset($total_income) ? $total_income : 0), 2); ?></strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="white-box">
            <h3 class="box-title m-b-20"><i class="ti-money"></i> <?php echo get_phrase('Expenses'); ?></h3>
            <div class="table-responsive">
                <table class="table table-condensed table-striped">
                    <tr>
                        <td><?php echo get_phrase('Total Expenses'); ?></td>
                        <td class="text-right"><strong><?php echo get_currency_symbol() . ' ' . number_format((isset($total_expenses) ? $total_expenses : 0), 2); ?></strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Row -->
<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <h3 class="box-title m-b-0"><i class="ti-calculator"></i> <?php echo get_phrase('Net Profit'); ?></h3>
            <div class="text-center m-t-30">
                <h2 style="color: <?php echo (isset($net_profit) && $net_profit >= 0) ? '#28a745' : '#dc3545'; ?>;">
                    <?php echo get_currency_symbol() . ' ' . number_format((isset($net_profit) ? $net_profit : 0), 2); ?>
                </h2>
            </div>
        </div>
    </div>
</div>

<!-- Row -->
<?php if (isset($expense_breakdown) && !empty($expense_breakdown)): ?>
<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <h3 class="box-title m-b-0"><?php echo get_phrase('Expense Breakdown'); ?></h3>
            <div class="table-responsive m-t-20">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th><?php echo get_phrase('Category'); ?></th>
                            <th><?php echo get_phrase('Amount'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($expense_breakdown as $expense): ?>
                        <tr>
                            <td><?php echo isset($expense['name']) ? $expense['name'] : get_phrase('Uncategorized'); ?></td>
                            <td><?php echo get_currency_symbol() . ' ' . number_format($expense['total'], 2); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
