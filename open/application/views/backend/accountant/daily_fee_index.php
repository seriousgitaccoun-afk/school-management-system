<?php
// Daily Fee Tracking View - Main Page with 3 Modes
?>

<style>
    .student-checkbox-item:hover {
        background-color: #f0f0f0;
    }
    
    .stu-check {
        accent-color: #28a745;
    }
    
    .stu-check:checked {
        box-shadow: 0 0 5px rgba(40, 167, 69, 0.5);
    }
    
    /* Paid student styling */
    .student-paid {
        background-color: #d4edda !important;
        border: 2px solid #28a745 !important;
        opacity: 0.7;
    }
    
    .student-paid input[type="checkbox"] {
        cursor: not-allowed;
        opacity: 0.5;
    }
    
    .paid-badge {
        display: inline-block;
        background-color: #28a745;
        color: white;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: bold;
        margin-left: 8px;
    }
</style>

<div class="container-fluid" style="padding: 20px;">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h4 class="mb-0 text-white"><i class="fa fa-calendar-day"></i> Daily Fee Tracking</h4>
                </div>
                <div class="card-body">
                    
                    <!-- Class & Student Selection -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="classSelect" class="form-label"><i class="fa fa-chalkboard"></i> Class</label>
                            <select id="classSelect" class="form-control">
                                <option value="">-- Select Class --</option>
                                <?php if (!empty($classes)): ?>
                                    <?php foreach ($classes as $class): ?>
                                        <option value="<?php echo $class->class_id; ?>">
                                            <?php echo $class->name; ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><i class="fa fa-users"></i> Students</label>
                            <div id="studentList" class="border p-3" style="max-height: 200px; overflow-y: auto; background: #f9f9f9;">
                                <p class="text-muted"><small>Select a class to view students</small></p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Mode Selection -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <ul class="nav nav-tabs" role="tablist" style="border-bottom: 2px solid #ddd;">
                                <li role="presentation" class="active">
                                    <a href="#" class="payment-mode-link" data-mode="daily" style="padding: 10px 20px; display: inline-block; border: 1px solid #ddd; border-bottom: 3px solid #007bff; margin-right: 5px;">
                                        <i class="fa fa-calendar"></i> <strong>Daily</strong>
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href="#" class="payment-mode-link" data-mode="weekly" style="padding: 10px 20px; display: inline-block; border: 1px solid #ddd; margin-right: 5px;">
                                        <i class="fa fa-calendar-plus"></i> <strong>Weekly</strong>
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href="#" class="payment-mode-link" data-mode="monthly" style="padding: 10px 20px; display: inline-block; border: 1px solid #ddd;">
                                        <i class="fa fa-calendar-times"></i> <strong>Monthly</strong>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- DAILY MODE -->
                    <div id="dailyMode" class="payment-mode-content">
                        <div class="panel panel-info">
                            <div class="panel-heading"><h5>Daily Fee Payment</h5></div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="dailyDate" class="form-label"><i class="fa fa-calendar"></i> Date</label>
                                        <input type="date" id="dailyDate" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="dailyFeeInfo" class="form-label"><i class="fa fa-money"></i> Fee</label>
                                        <input type="text" id="dailyFeeInfo" class="form-control" readonly style="background-color: #f5f5f5; cursor: not-allowed;" placeholder="Select class to see fee">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">&nbsp;</label>
                                        <button id="recordDailyBtn" class="btn btn-success w-100"><i class="fa fa-check-circle"></i> Record</button>
                                        <button id="bulkDailyBtn" class="btn btn-info w-100" style="margin-top: 5px;"><i class="fa fa-check"></i> Bulk Record</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- WEEKLY MODE -->
                    <div id="weeklyMode" class="payment-mode-content d-none">
                        <div class="panel panel-success">
                            <div class="panel-heading"><h5>Weekly Fee Payment (Mon-Fri)</h5></div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="weeklyStart" class="form-label"><i class="fa fa-calendar"></i> Start (Monday)</label>
                                        <input type="date" id="weeklyStart" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="weeklyFeeInfo" class="form-label"><i class="fa fa-money"></i> Fee</label>
                                        <input type="text" id="weeklyFeeInfo" class="form-control" readonly style="background-color: #f5f5f5; cursor: not-allowed;" placeholder="Select class to see fee">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">&nbsp;</label>
                                        <button id="recordWeeklyBtn" class="btn btn-success w-100"><i class="fa fa-check-circle"></i> Record</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- MONTHLY MODE -->
                    <div id="monthlyMode" class="payment-mode-content d-none">
                        <div class="panel panel-warning">
                            <div class="panel-heading"><h5>Monthly - Select Weekdays</h5></div>
                            <div class="panel-body">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="monthlyDate" class="form-label"><i class="fa fa-calendar"></i> Month</label>
                                        <input type="month" id="monthlyDate" class="form-control" value="<?php echo date('Y-m'); ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="monthlyFeeInfo" class="form-label"><i class="fa fa-money"></i> Fee</label>
                                        <input type="text" id="monthlyFeeInfo" class="form-control" readonly style="background-color: #f5f5f5; cursor: not-allowed;" placeholder="Select class to see fee">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">&nbsp;</label>
                                        <button id="recordMonthlyBtn" class="btn btn-success w-100"><i class="fa fa-check-circle"></i> Record</button>
                                    </div>
                                </div>
                                <div id="monthlyCalendar"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Summary -->
                    <div class="row" style="margin-top: 20px;">
                        <div class="col-md-3">
                            <div class="panel panel-default">
                                <div class="panel-body text-center">
                                    <h6>Selected Students</h6>
                                    <h3 id="totalSelectedCount">0</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let selectedStudents = [];
    let monthlySelectedDays = [];
    let selectedClassId = null;
    let classFees = [];

    // Helper function to get currency symbol
    function get_currency_symbol() {
        return '₵'; // Ghana Cedis
    }

    // Function to update selected students count
    window.checkChanged = function() {
        selectedStudents = Array.from(document.querySelectorAll('.stu-check:checked')).map(c => ({
            id: c.value,
            name: c.dataset.name
        }));
        document.getElementById('totalSelectedCount').textContent = selectedStudents.length;
    };

    // Function to load students for the selected class and date (global scope)
    window.loadStudentsForDate = async function() {
        let classId = selectedClassId;
        let feeDate = document.getElementById('dailyDate').value;
        let studentList = document.getElementById('studentList');
        
        if (!classId) {
            studentList.innerHTML = '<p class="text-muted"><small>Select a class</small></p>';
            return;
        }
        
        try {
            // Pass date parameter to filter paid students
            let url = '<?php echo base_url('dailyfee/get_students_by_class/'); ?>' + classId;
            if (feeDate) {
                url += '/' + feeDate;
            }
            
            console.log('Loading students from:', url);
            let res = await fetch(url);
            let data = await res.json();
            
            console.log('Response data:', data);
            
            if (data.success && data.data && Array.isArray(data.data) && data.data.length > 0) {
                let html = '';
                data.data.forEach(s => {
                    // Show paid status badge for students already marked as paid
                    let paidBadge = s.is_paid ? '<span class="paid-badge"><i class="fa fa-check"></i> PAID</span>' : '';
                    let paidClass = s.is_paid ? 'student-paid' : '';
                    let disabledAttr = s.is_paid ? 'disabled' : '';
                    
                    html += `<div class="student-checkbox-item ${paidClass}" style="display: flex; align-items: center; padding: 8px; margin-bottom: 5px; border-radius: 4px; cursor: ${s.is_paid ? 'not-allowed' : 'pointer'}; border: 2px solid transparent; transition: all 0.3s;">
                        <input type="checkbox" value="${s.student_id}" data-name="${s.name}" class="stu-check" style="cursor: pointer; width: 18px; height: 18px; margin-right: 10px;" onchange="checkChanged()" ${disabledAttr}>
                        <label style="margin: 0; cursor: pointer; flex-grow: 1; font-weight: ${s.is_paid ? 'bold' : 'normal'};">${s.name}</label>
                        ${paidBadge}
                    </div>`;
                });
                
                studentList.innerHTML = html;
                
                // Add styling for checked items
                document.querySelectorAll('.stu-check').forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const item = this.closest('.student-checkbox-item');
                        if (this.checked) {
                            item.style.backgroundColor = '#d4edda';
                            item.style.borderColor = '#28a745';
                        } else {
                            item.style.backgroundColor = 'transparent';
                            item.style.borderColor = 'transparent';
                        }
                    });
                });
            } else {
                console.warn('No students or invalid response:', data);
                studentList.innerHTML = '<p class="text-muted"><small>No students in this class</small></p>';
            }

            // Load configured fees for this class
            let feesRes = await fetch('<?php echo base_url('dailyfee/get_class_fees/'); ?>' + classId);
            let feesData = await feesRes.json();
            
            if (feesData.success && feesData.data && feesData.data.length > 0) {
                classFees = feesData.data;
                
                // Auto-populate with first fee info
                let firstFee = feesData.data[0];
                let feeDisplay = `${firstFee.fee_name} (₵ ${parseFloat(firstFee.amount).toFixed(2)})`;
                
                document.getElementById('dailyFeeInfo').value = feeDisplay;
                document.getElementById('weeklyFeeInfo').value = feeDisplay;
                document.getElementById('monthlyFeeInfo').value = feeDisplay;
            } else {
                classFees = [];
                document.getElementById('dailyFeeInfo').value = 'No daily fee configured';
                document.getElementById('weeklyFeeInfo').value = 'No daily fee configured';
                document.getElementById('monthlyFeeInfo').value = 'No daily fee configured';
            }
        } catch (error) {
            console.error('Error loading students:', error);
            studentList.innerHTML = '<p class="text-danger"><small>Error loading students</small></p>';
        }
    };

    // Tabs
    document.querySelectorAll('.payment-mode-link').forEach(link => {
        link.onclick = function(e) {
            e.preventDefault();
            let mode = this.dataset.mode;
            document.querySelectorAll('.payment-mode-link').forEach(l => l.style.borderBottom = '1px solid #ddd');
            this.style.borderBottom = '3px solid #007bff';
            document.querySelectorAll('.payment-mode-content').forEach(c => c.classList.add('d-none'));
            document.getElementById(mode + 'Mode').classList.remove('d-none');
        };
    });

    // Load students and fees for selected class
    document.getElementById('classSelect').onchange = async function() {
        let classId = this.value;
        selectedClassId = classId;
        let studentList = document.getElementById('studentList');
        
        if (!classId) {
            studentList.innerHTML = '<p class="text-muted"><small>Select a class</small></p>';
            classFees = [];
            document.getElementById('dailyFeeInfo').value = '';
            document.getElementById('weeklyFeeInfo').value = '';
            document.getElementById('monthlyFeeInfo').value = '';
            return;
        }
        
        await window.loadStudentsForDate();
        
        // Also load fees
        let feesRes = await fetch('<?php echo base_url('dailyfee/get_class_fees/'); ?>' + classId);
        let feesData = await feesRes.json();
        
        if (feesData.success && feesData.data && feesData.data.length > 0) {
            classFees = feesData.data;
            let feeInfo = feesData.data[0].name + ' - ' + get_currency_symbol() + ' ' + feesData.data[0].amount;
            document.getElementById('dailyFeeInfo').value = feeInfo;
            document.getElementById('weeklyFeeInfo').value = feeInfo;
            document.getElementById('monthlyFeeInfo').value = feeInfo;
        } else {
            classFees = [];
            document.getElementById('dailyFeeInfo').value = 'No fee configured';
        }
    };

    // Load students when date changes (to exclude already-paid students)
    document.getElementById('dailyDate').onchange = loadStudentsForDate;

    // Record Daily Payment
    document.getElementById('recordDailyBtn').onclick = async function() {
        if (!selectedStudents[0]) { alert('Select student'); return; }
        if (classFees.length === 0) { alert('No daily fee configured for this class'); return; }
        if (!document.getElementById('dailyDate').value) { alert('Select date'); return; }
        
        let fee = classFees[0];
        let feeDate = document.getElementById('dailyDate').value;
        
        try {
            let res = await fetch('<?php echo base_url('dailyfee/record_payment'); ?>', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `student_id=${selectedStudents[0].id}&fee_date=${feeDate}&fee_type_id=${fee.fee_type_id}&amount=${fee.amount}`
            });
            
            let result = await res.json();
            if (result.success) {
                alert('✓ Payment recorded successfully!');
                document.querySelectorAll('.stu-check').forEach(c => c.checked = false);
                checkChanged();
                // Reload student list to show paid badge
                await loadStudentsForDate();
            } else {
                alert('✗ Error: ' + (result.message || 'Unknown error'));
            }
        } catch (error) {
            alert('✗ Network error: ' + error.message);
            console.error('Recording error:', error);
        }
    };

    document.getElementById('bulkDailyBtn').onclick = async function() {
        if (selectedStudents.length === 0) { alert('Select students'); return; }
        if (classFees.length === 0) { alert('No daily fee configured for this class'); return; }
        if (!confirm(`Record for ${selectedStudents.length} students?`)) return;
        
        let fee = classFees[0];
        for (const s of selectedStudents) {
            await fetch('<?php echo base_url('dailyfee/record_payment'); ?>', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'},
                body: `student_id=${s.id}&fee_date=${document.getElementById('dailyDate').value}&fee_type_id=${fee.fee_type_id}&amount=${fee.amount}`
            });
        }
        alert('Done!');
        document.querySelectorAll('.stu-check').forEach(c => c.checked = false);
        checkChanged();
        // Reload student list to show paid badges
        await loadStudentsForDate();
    };

    // Weekly
    document.getElementById('recordWeeklyBtn').onclick = async function() {
        if (selectedStudents.length === 0) { alert('Select students'); return; }
        if (classFees.length === 0) { alert('No daily fee configured for this class'); return; }
        if (!confirm(`Record for ${selectedStudents.length} students?`)) return;
        
        let fee = classFees[0];
        let start = new Date(document.getElementById('weeklyStart').value);
        for (let i = 0; i < 7; i++) {
            let d = new Date(start);
            d.setDate(d.getDate() + i);
            if (d.getDay() > 0 && d.getDay() < 6) {
                for (const s of selectedStudents) {
                    await fetch('<?php echo base_url('dailyfee/record_payment'); ?>', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'},
                        body: `student_id=${s.id}&fee_date=${d.toISOString().split('T')[0]}&fee_type_id=${fee.fee_type_id}&amount=${fee.amount}`
                    });
                }
            }
        }
        alert('Done!');
        document.querySelectorAll('.stu-check').forEach(c => c.checked = false);
        checkChanged();
        // Reload student list to show paid badges
        await loadStudentsForDate();
    };

    // Monthly calendar
    function genCal() {
        let d = new Date(document.getElementById('monthlyDate').value + '-01');
        let y = d.getFullYear(), m = d.getMonth();
        let html = '<div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 5px;">';
        ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'].forEach(n => html += `<div style="text-align: center; font-weight: bold;">${n}</div>`);
        
        let maxD = new Date(y, m + 1, 0).getDate();
        let firstD = new Date(y, m, 1).getDay();
        for (let i = 0; i < firstD; i++) html += '<div></div>';
        
        for (let day = 1; day <= maxD; day++) {
            let dow = new Date(y, m, day).getDay();
            let dateStr = `${y}-${String(m + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            if (dow > 0 && dow < 6) {
                html += `<label style="cursor: pointer; padding: 5px; border: 1px solid #ddd; text-align: center; display: block; background: #f9f9f9;"><input type="checkbox" class="m-day" value="${dateStr}" onchange="updMon()"> ${day}</label>`;
            } else {
                html += `<div style="text-align: center; color: #ccc;">${day}</div>`;
            }
        }
        html += '</div>';
        document.getElementById('monthlyCalendar').innerHTML = html;
    }

    window.updMon = function() {
        monthlySelectedDays = Array.from(document.querySelectorAll('.m-day:checked')).map(c => c.value);
    };

    document.getElementById('monthlyDate').onchange = genCal;

    document.getElementById('recordMonthlyBtn').onclick = async function() {
        if (monthlySelectedDays.length === 0) { alert('Select days'); return; }
        if (selectedStudents.length === 0) { alert('Select students'); return; }
        if (classFees.length === 0) { alert('No daily fee configured for this class'); return; }
        if (!confirm(`Record?`)) return;
        
        let fee = classFees[0];
        
        for (const dateStr of monthlySelectedDays) {
            for (const s of selectedStudents) {
                await fetch('<?php echo base_url('dailyfee/record_payment'); ?>', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'},
                    body: `student_id=${s.id}&fee_date=${dateStr}&fee_type_id=${fee.fee_type_id}&amount=${fee.amount}`
                });
            }
        }
        alert('Done!');
        document.querySelectorAll('.stu-check').forEach(c => c.checked = false);
        checkChanged();
        // Reload student list to show paid badges
        await loadStudentsForDate();
    };

    genCal();
});
</script>
