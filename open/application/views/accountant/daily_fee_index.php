<?php
// Daily Fee Tracking View
?>
<style>
/* Custom Checkbox Styling */
.stu-check {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    width: 20px;
    height: 20px;
    border: 2px solid #999;
    border-radius: 4px;
    cursor: pointer;
    background-color: white;
    transition: all 0.2s ease;
    vertical-align: middle;
    flex-shrink: 0;
}

.stu-check:checked {
    background-color: #28a745;
    border-color: #28a745;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='white' d='M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: center;
    background-size: 70%;
}

.stu-check:hover {
    border-color: #28a745;
    box-shadow: 0 0 5px rgba(40, 167, 69, 0.3);
}

.stu-check:focus {
    outline: none;
    box-shadow: 0 0 8px rgba(40, 167, 69, 0.5);
}

.stu-check-label {
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    user-select: none;
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
                        <div class="col-md-12">
                            <label><strong>Select Students</strong></label>
                            <div class="border p-3" style="max-height: 250px; overflow-y: auto; background: #f9f9f9;">
                                <?php 
                                // Get all students from database
                                $this->db->order_by('name', 'ASC');
                                $all_students = $this->db->get('student')->result();
                                
                                if ($all_students && count($all_students) > 0):
                                    foreach ($all_students as $student):
                                ?>
                                    <div style="margin: 5px 0;">
                                        <label class="stu-check-label">
                                            <input type="checkbox" value="<?php echo $student->student_id; ?>" data-name="<?php echo $student->name; ?>" class="stu-check" onchange="checkChanged()">
                                            <span><?php echo $student->name; ?></span>
                                        </label>
                                    </div>
                                <?php 
                                    endforeach;
                                else:
                                ?>
                                    <p class="text-muted"><small>No students found</small></p>
                                <?php 
                                endif;
                                ?>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Mode Tabs -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <a href="#" class="payment-mode-link" data-mode="daily" style="padding: 10px 20px; display: inline-block; border: 1px solid #ddd; border-bottom: 3px solid #007bff; margin-right: 5px; text-decoration: none;">
                                <strong>Daily</strong>
                            </a>
                            <a href="#" class="payment-mode-link" data-mode="weekly" style="padding: 10px 20px; display: inline-block; border: 1px solid #ddd; margin-right: 5px; text-decoration: none;">
                                <strong>Weekly</strong>
                            </a>
                            <a href="#" class="payment-mode-link" data-mode="monthly" style="padding: 10px 20px; display: inline-block; border: 1px solid #ddd; text-decoration: none;">
                                <strong>Monthly</strong>
                            </a>
                        </div>
                    </div>

                    <!-- Daily Mode -->
                    <div id="dailyMode" class="payment-mode-content">
                        <div class="panel panel-info">
                            <div class="panel-heading"><h5>Daily Fee Payment</h5></div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="dailyDate"><strong>Date</strong></label>
                                        <input type="date" id="dailyDate" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="dailyAmount"><strong>Amount (₵)</strong></label>
                                        <input type="number" id="dailyAmount" class="form-control" placeholder="0.00" step="0.01" min="0">
                                    </div>
                                    <div class="col-md-6">
                                        <label>&nbsp;</label>
                                        <button id="recordDailyBtn" class="btn btn-success w-100">Record</button>
                                        <button id="bulkDailyBtn" class="btn btn-info w-100" style="margin-top: 5px;">Bulk Record</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Weekly Mode -->
                    <div id="weeklyMode" class="payment-mode-content d-none">
                        <div class="panel panel-success">
                            <div class="panel-heading"><h5>Weekly (Mon-Fri)</h5></div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="weeklyStart"><strong>Start (Monday)</strong></label>
                                        <input type="date" id="weeklyStart" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="weeklyAmount"><strong>Daily (₵)</strong></label>
                                        <input type="number" id="weeklyAmount" class="form-control" placeholder="0.00" step="0.01" min="0">
                                    </div>
                                    <div class="col-md-6">
                                        <label>&nbsp;</label>
                                        <button id="recordWeeklyBtn" class="btn btn-success w-100">Record</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Monthly Mode -->
                    <div id="monthlyMode" class="payment-mode-content d-none">
                        <div class="panel panel-warning">
                            <div class="panel-heading"><h5>Monthly - Select Weekdays</h5></div>
                            <div class="panel-body">
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="monthlyDate"><strong>Month</strong></label>
                                        <input type="month" id="monthlyDate" class="form-control" value="<?php echo date('Y-m'); ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="monthlyAmount"><strong>Daily (₵)</strong></label>
                                        <input type="number" id="monthlyAmount" class="form-control" placeholder="0.00" step="0.01" min="0">
                                    </div>
                                    <div class="col-md-6">
                                        <label>&nbsp;</label>
                                        <button id="recordMonthlyBtn" class="btn btn-success w-100">Record</button>
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
                                    <h6>Selected</h6>
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

    // Load students when class selected
    window.checkChanged = function() {
        selectedStudents = Array.from(document.querySelectorAll('.stu-check:checked')).map(cb => ({id: cb.value, name: cb.dataset.name}));
        document.getElementById('totalSelectedCount').textContent = selectedStudents.length;
        
        // Add visual feedback to checkbox rows
        document.querySelectorAll('.stu-check-label').forEach(label => {
            let checkbox = label.querySelector('.stu-check');
            if (checkbox.checked) {
                label.style.background = '#d4edda';
                label.style.padding = '8px';
                label.style.borderRadius = '3px';
                label.style.borderLeft = '4px solid #28a745';
            } else {
                label.style.background = 'transparent';
                label.style.padding = '0';
                label.style.borderLeft = 'none';
            }
        });
    };

    // Daily
    document.getElementById('recordDailyBtn').onclick = async function() {
        if (!selectedStudents[0]) { alert('Select a student'); return; }
        let amt = document.getElementById('dailyAmount').value;
        if (!amt) { alert('Enter amount'); return; }
        
        let res = await fetch('<?php echo base_url('dailyfee/record_payment'); ?>', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'},
            body: `student_id=${selectedStudents[0].id}&fee_date=${document.getElementById('dailyDate').value}&fee_type_id=2&amount=${amt}`
        });
        let result = await res.json();
        if (result.success) {
            alert('Recorded!');
            document.querySelectorAll('.stu-check').forEach(c => c.checked = false);
            checkChanged();
        } else alert('Error: ' + result.message);
    };

    // Bulk daily
    document.getElementById('bulkDailyBtn').onclick = async function() {
        if (selectedStudents.length === 0) { alert('Select students'); return; }
        let amt = document.getElementById('dailyAmount').value;
        if (!amt) { alert('Enter amount'); return; }
        if (!confirm(`Record for ${selectedStudents.length} students?`)) return;
        
        for (const s of selectedStudents) {
            await fetch('<?php echo base_url('dailyfee/record_payment'); ?>', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'},
                body: `student_id=${s.id}&fee_date=${document.getElementById('dailyDate').value}&fee_type_id=2&amount=${amt}`
            });
        }
        alert('Done!');
        document.querySelectorAll('.stu-check').forEach(c => c.checked = false);
        checkChanged();
    };

    // Weekly
    document.getElementById('recordWeeklyBtn').onclick = async function() {
        if (selectedStudents.length === 0) { alert('Select students'); return; }
        let amt = document.getElementById('weeklyAmount').value;
        if (!amt) { alert('Enter amount'); return; }
        if (!confirm(`Record for ${selectedStudents.length} students (5 days)?`)) return;
        
        let start = new Date(document.getElementById('weeklyStart').value);
        for (let i = 0; i < 7; i++) {
            let d = new Date(start);
            d.setDate(d.getDate() + i);
            if (d.getDay() > 0 && d.getDay() < 6) {
                for (const s of selectedStudents) {
                    await fetch('<?php echo base_url('dailyfee/record_payment'); ?>', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'},
                        body: `student_id=${s.id}&fee_date=${d.toISOString().split('T')[0]}&fee_type_id=2&amount=${amt}`
                    });
                }
            }
        }
        alert('Done!');
        document.querySelectorAll('.stu-check').forEach(c => c.checked = false);
        checkChanged();
    };

    // Monthly calendar
    function genCal() {
        let d = new Date(document.getElementById('monthlyDate').value + '-01');
        let y = d.getFullYear(), m = d.getMonth();
        let html = '<div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 5px;">';
        ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'].forEach(n => html += `<div style="text-align: center; font-weight: bold; padding: 5px;">${n}</div>`);
        
        let maxD = new Date(y, m + 1, 0).getDate();
        let firstD = new Date(y, m, 1).getDay();
        for (let i = 0; i < firstD; i++) html += '<div></div>';
        
        for (let day = 1; day <= maxD; day++) {
            let dow = new Date(y, m, day).getDay();
            let dateStr = `${y}-${String(m + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            if (dow > 0 && dow < 6) {
                html += `<label style="cursor: pointer; padding: 5px; border: 1px solid #ddd; text-align: center; display: block; background: #f9f9f9;"><input type="checkbox" class="m-day" value="${dateStr}" onchange="updMon()"> ${day}</label>`;
            } else {
                html += `<div style="text-align: center; color: #ccc; padding: 5px;">${day}</div>`;
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
        let amt = document.getElementById('monthlyAmount').value;
        if (!amt) { alert('Enter amount'); return; }
        if (!confirm(`Record for ${selectedStudents.length} students?`)) return;
        
        for (const dateStr of monthlySelectedDays) {
            for (const s of selectedStudents) {
                await fetch('<?php echo base_url('dailyfee/record_payment'); ?>', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'},
                    body: `student_id=${s.id}&fee_date=${dateStr}&fee_type_id=2&amount=${amt}`
                });
            }
        }
        alert('Done!');
        document.querySelectorAll('.stu-check').forEach(c => c.checked = false);
        checkChanged();
    };

    genCal();
});
</script>
