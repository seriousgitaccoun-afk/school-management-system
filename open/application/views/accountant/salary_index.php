<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style>
.salary-container { max-width: 1200px; margin: 0 auto; padding: 20px; }
.salary-header { margin-bottom: 30px; }
.salary-header h1 { margin: 0 0 5px 0; color: #333; font-size: 28px; }
.salary-header p { margin: 0; color: #999; font-size: 14px; }
.cards-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
.card { padding: 20px; border-radius: 8px; color: white; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
.card-pending { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
.card-approved { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
.card-paid { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
.card-label { font-size: 12px; text-transform: uppercase; opacity: 0.9; margin-bottom: 10px; }
.card-value { font-size: 32px; font-weight: bold; margin-bottom: 5px; }
.card-sublabel { font-size: 11px; opacity: 0.8; }
.action-buttons { margin-bottom: 20px; display: flex; gap: 10px; flex-wrap: wrap; }
.btn { padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; font-weight: 600; text-decoration: none; display: inline-block; }
.btn-primary { background: #667eea; color: white; }
.btn-primary:hover { background: #5568d3; }
.btn-secondary { background: #6c757d; color: white; }
.btn-secondary:hover { background: #5a6268; }
.btn-success { background: #28a745; color: white; }
.btn-success:hover { background: #218838; }
.btn-warning { background: #ffc107; color: black; }
.btn-warning:hover { background: #e0a800; }
.table-card { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
.table-card h3 { margin: 0 0 20px 0; color: #333; }
.salary-table { width: 100%; border-collapse: collapse; }
.salary-table th { background: #f8f9fa; padding: 12px; text-align: left; font-weight: 600; color: #333; font-size: 13px; border-bottom: 2px solid #dee2e6; }
.salary-table td { padding: 12px; border-bottom: 1px solid #dee2e6; }
.salary-table tr:hover { background: #f8f9fa; }
.status-badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
.status-pending { background: #fff3cd; color: #856404; }
.status-approved { background: #d1ecf1; color: #0c5460; }
.status-paid { background: #d4edda; color: #155724; }
.status-rejected { background: #f8d7da; color: #721c24; }
.empty-state { text-align: center; padding: 60px 20px; color: #999; }
.empty-state-icon { font-size: 64px; margin-bottom: 20px; display: block; opacity: 0.3; }
.alert { padding: 12px 20px; border-radius: 4px; margin-bottom: 20px; }
.alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
.alert-warning { background: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
.alert-info { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }
.alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
</style>

<div class="salary-container">
    
    <!-- Flash Messages -->
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> <?php echo $this->session->flashdata('success'); ?>
        </div>
    <?php endif; ?>
    
    <?php if ($this->session->flashdata('warning')): ?>
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-circle"></i> <?php echo $this->session->flashdata('warning'); ?>
        </div>
    <?php endif; ?>
    
    <?php if ($this->session->flashdata('info')): ?>
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> <?php echo $this->session->flashdata('info'); ?>
        </div>
    <?php endif; ?>
    
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-error">
            <i class="fas fa-times-circle"></i> <?php echo $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>
    
    <!-- Header -->
    <div class="salary-header">
        <h1><i class="fas fa-money-bill-wave"></i> Salary Management</h1>
        <p>Manage teacher salaries and payment processing</p>
    </div>
    
    <!-- Summary Cards -->
    <div class="cards-row">
        <div class="card card-pending">
            <div class="card-label"><i class="fas fa-hourglass-half"></i> Pending</div>
            <div class="card-value"><?php echo isset($summary['pending']) ? $summary['pending'] : 0; ?></div>
            <div class="card-sublabel">Awaiting approval</div>
        </div>
        
        <div class="card card-approved">
            <div class="card-label"><i class="fas fa-check-circle"></i> Approved</div>
            <div class="card-value"><?php echo isset($summary['approved']) ? $summary['approved'] : 0; ?></div>
            <div class="card-sublabel">Ready to pay</div>
        </div>
        
        <div class="card card-paid">
            <div class="card-label"><i class="fas fa-check-double"></i> Paid</div>
            <div class="card-value"><?php echo isset($summary['paid']) ? $summary['paid'] : 0; ?></div>
            <div class="card-sublabel">Payment completed</div>
        </div>
    </div>
    
    <!-- Action Buttons -->
    <div class="action-buttons">
        <button class="btn btn-primary" onclick="openGenerateModal()">
            <i class="fas fa-plus-circle"></i> Generate Monthly Salaries
        </button>
        <a href="<?php echo site_url('salary/pending'); ?>" class="btn btn-secondary">
            <i class="fas fa-hourglass-half"></i> View Pending
        </a>
        <a href="<?php echo site_url('salary/approved'); ?>" class="btn btn-secondary">
            <i class="fas fa-check-circle"></i> View Approved
        </a>
        <a href="<?php echo site_url('salary/paid'); ?>" class="btn btn-secondary">
            <i class="fas fa-check-double"></i> View Paid
        </a>
    </div>
    
    <!-- Salaries Table -->
    <div class="table-card">
        <h3>All Salary Records</h3>
        
        <?php if (!empty($salaries) && count($salaries) > 0): ?>
            <table class="salary-table">
                <thead>
                    <tr>
                        <th>Teacher</th>
                        <th>Designation</th>
                        <th>Month/Year</th>
                        <th style="text-align: right;">Amount</th>
                        <th>Status</th>
                        <th style="text-align: center;">Action</th>
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
                                    <br><small style="color: #666;"><?php echo $salary->phone; ?></small>
                                <?php endif; ?>
                            </td>
                            <td><?php echo isset($salary->designation_name) ? $salary->designation_name : 'N/A'; ?></td>
                            <td><?php echo $months[$salary->payment_month] . ' ' . $salary->payment_year; ?></td>
                            <td style="text-align: right; font-weight: 600;">₵<?php echo number_format($salary->amount, 2); ?></td>
                            <td>
                                <span class="status-badge status-<?php echo $salary->status; ?>">
                                    <?php echo ucfirst($salary->status); ?>
                                </span>
                            </td>
                            <td style="text-align: center;">
                                <a href="<?php echo site_url('salary/view/' . $salary->salary_payment_id); ?>" class="btn" style="padding: 5px 10px; background: #03a9f3; color: white; border-radius: 3px; text-decoration: none; font-size: 12px;">
                                    View
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-inbox empty-state-icon"></i>
                <p style="font-size: 18px; margin: 0 0 10px 0;">No salary records found</p>
                <p style="font-size: 14px; margin: 0;">Click "Generate Monthly Salaries" to create salary records for active teachers.</p>
            </div>
        <?php endif; ?>
    </div>
    
</div>

<!-- Generate Modal -->
<div id="generateModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; padding: 20px;">
    <div style="background: white; padding: 30px; border-radius: 8px; width: 100%; max-width: 400px; box-shadow: 0 4px 20px rgba(0,0,0,0.2);">
        <h3 style="margin-top: 0; margin-bottom: 20px;">Generate Monthly Salaries</h3>
        <form method="POST" action="<?php echo site_url('salary/generate_monthly'); ?>">
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; margin-bottom: 5px;">Select Month</label>
                <select name="month" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
                    <option value="">-- Choose Month --</option>
                    <?php 
                    $months_full = array(
                        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                        5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                        9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
                    );
                    foreach ($months_full as $num => $name):
                    ?>
                        <option value="<?php echo $num; ?>"><?php echo $name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 5px;">Select Year</label>
                <select name="year" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
                    <option value="">-- Choose Year --</option>
                    <?php for ($y = date('Y') - 2; $y <= date('Y') + 1; $y++): ?>
                        <option value="<?php echo $y; ?>" <?php echo $y == date('Y') ? 'selected' : ''; ?>><?php echo $y; ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            
            <p style="color: #666; font-size: 13px; margin: 15px 0;">
                <i class="fas fa-info-circle"></i> This will create salary records for all active teachers based on their joining salary.
            </p>
            
            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-success" style="flex: 1;">Generate</button>
                <button type="button" class="btn btn-secondary" onclick="closeGenerateModal()" style="flex: 1;">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
function openGenerateModal() {
    document.getElementById('generateModal').style.display = 'flex';
}

function closeGenerateModal() {
    document.getElementById('generateModal').style.display = 'none';
}

// Close modal when clicking outside
document.getElementById('generateModal').addEventListener('click', function(e) {
    if (e.target === this) closeGenerateModal();
});
</script>
