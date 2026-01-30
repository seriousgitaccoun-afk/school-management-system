<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container-fluid" style="padding: 20px;">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-success">
                    <h4 class="mb-0 text-white"><i class="fa fa-check-double"></i> Paid Salaries</h4>
                </div>
                <div class="card-body">
                    
                    <?php if (!empty($salaries) && count($salaries) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Teacher</th>
                                        <th>Month/Year</th>
                                        <th style="text-align: right;">Amount</th>
                                        <th>Bank</th>
                                        <th>Payment Date</th>
                                        <th style="text-align: center;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $months = array(1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 
                                                   7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec');
                                    foreach ($salaries as $salary):
                                    ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo isset($salary->teacher_name) ? $salary->teacher_name : 'Unknown'; ?></strong>
                                                <?php if(isset($salary->phone) && !empty($salary->phone)): ?>
                                                    <br><small style="color: #999;"><?php echo $salary->phone; ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo isset($salary->bank_name) ? $salary->bank_name : 'N/A'; ?></td>
                                            <td><?php echo $months[$salary->payment_month] . ' ' . $salary->payment_year; ?></td>
                                            <td style="text-align: right; font-weight: 600;">₵<?php echo number_format($salary->amount, 2); ?></td>
                                            <td>
                                                <?php echo isset($salary->bank_name) ? $salary->bank_name : 'N/A'; ?>
                                                <?php if(isset($salary->account_number) && !empty($salary->account_number)): ?>
                                                    <br><small style="color: #999;"><?php echo $salary->account_number; ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo $salary->payment_date ? date('M d, Y', strtotime($salary->payment_date)) : '-'; ?></td>
                                            <td style="text-align: center;">
                                                <span class="label label-success">Paid</span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div style="text-align: center; padding: 40px 20px; color: #999;">
                            <p style="font-size: 16px; margin: 0 0 10px 0;">No paid salaries yet</p>
                            <p style="font-size: 13px; margin: 0;"><a href="<?php echo site_url('salary/approved'); ?>">Mark salaries as paid</a> to see them here.</p>
                        </div>
                    <?php endif; ?>
                    
                </div>
            </div>
        </div>
    </div>
</div>
