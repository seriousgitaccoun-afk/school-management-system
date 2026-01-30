<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container-fluid" style="padding: 20px;">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h4 class="mb-0 text-white"><i class="fa fa-check-circle"></i> Approved Salaries</h4>
                </div>
                <div class="card-body">
                    
                    <?php if (!empty($salaries) && count($salaries) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Teacher</th>
                                        <th>Designation</th>
                                        <th>Month/Year</th>
                                        <th style="text-align: right;">Amount</th>
                                        <th>Bank</th>
                                        <th style="text-align: center;">Actions</th>
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
                                            <td><?php echo isset($salary->designation_name) ? $salary->designation_name : 'N/A'; ?></td>
                                            <td><?php echo $months[$salary->payment_month] . ' ' . $salary->payment_year; ?></td>
                                            <td style="text-align: right; font-weight: 600;">₵<?php echo number_format($salary->amount, 2); ?></td>
                                            <td>
                                                <?php echo isset($salary->bank_name) ? $salary->bank_name : 'N/A'; ?>
                                                <?php if(isset($salary->account_number) && !empty($salary->account_number)): ?>
                                                    <br><small style="color: #999;"><?php echo $salary->account_number; ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <a href="<?php echo site_url('salary/mark_paid/' . $salary->salary_payment_id); ?>" class="btn btn-sm btn-success" onclick="return confirm('Mark this salary as paid?')" style="margin: 2px;">
                                                    <i class="fa fa-check-double"></i> Mark Paid
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div style="text-align: center; padding: 40px 20px; color: #999;">
                            <p style="font-size: 16px; margin: 0 0 10px 0;">No approved salaries</p>
                            <p style="font-size: 13px; margin: 0;"><a href="<?php echo site_url('salary/pending'); ?>">Approve pending salaries</a> to get started.</p>
                        </div>
                    <?php endif; ?>
                    
                </div>
            </div>
        </div>
    </div>
</div>
