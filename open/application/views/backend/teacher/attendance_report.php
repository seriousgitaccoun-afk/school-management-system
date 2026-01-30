		
<?php $active_sms_gateway = $this->db->get_where('sms_settings' , array('type' => 'active_sms_gateway'))->row()->info; ?>

<style>
    /* Attendance Report Styling */
    .report-page-container {
        background: #f8f9fa;
        padding: 20px 0;
    }
    
    .report-filter-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        border: 1px solid #e4e7ea;
        margin-bottom: 30px;
    }
    
    .report-filter-header {
        background: linear-gradient(135deg, #03a9f3 0%, #0288d1 100%);
        color: white;
        padding: 20px;
        border-radius: 8px 8px 0 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .report-filter-header h4 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    
    .report-filter-body {
        padding: 30px;
    }
    
    .legend-box {
        background: #f0f4f8;
        border-left: 4px solid #03a9f3;
        padding: 16px;
        border-radius: 4px;
        margin-bottom: 25px;
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        align-items: center;
    }
    
    .legend-title {
        font-weight: 600;
        color: #0288d1;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-right: 10px;
        flex-basis: 100%;
    }
    
    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        color: #686868;
        
        i {
            font-size: 12px;
        }
    }
    
    .report-form-group {
        margin-bottom: 20px;
    }
    
    .report-form-label {
        label {
            font-weight: 600;
            color: #2b2b2b;
            font-size: 13px;
            letter-spacing: 0.3px;
            margin-bottom: 8px;
            display: block;
        }
    }
    
    .report-form-input {
        input, select {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid #d9dfe4;
            border-radius: 4px;
            font-size: 13px;
            transition: all 0.3s ease;
            font-family: Poppins, sans-serif;
            background-color: white;
            
            &:focus {
                border-color: #03a9f3;
                box-shadow: 0 0 0 3px rgba(3, 169, 243, 0.1);
                outline: none;
            }
        }
        
        select {
            cursor: pointer;
        }
    }
    
    .report-form-button {
        button {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #03a9f3 0%, #0288d1 100%);
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
            
            &:hover {
                box-shadow: 0 4px 12px rgba(3, 169, 243, 0.3);
                transform: translateY(-1px);
            }
            
            &:active {
                transform: translateY(0);
            }
        }
    }
    
    .report-results-container {
        margin-top: 30px;
    }
    
    .report-loading {
        text-align: center;
        padding: 40px 20px;
        color: #a8adb5;
        
        i {
            font-size: 48px;
            margin-bottom: 15px;
            animation: spin 1s linear infinite;
        }
        
        p {
            font-size: 14px;
            margin: 0;
        }
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .report-filter-body {
            padding: 20px;
        }
        
        .legend-box {
            gap: 12px;
        }
        
        .legend-item {
            font-size: 11px;
        }
    }
</style>

<div class="report-page-container">
    <!-- FILTER FORM CARD -->
    <div class="row">
        <div class="col-sm-12">
            <div class="report-filter-card">
                <div class="report-filter-header">
                    <i class="fa fa-bar-chart-o"></i>
                    <h4><?php echo get_phrase('Attendance Report');?></h4>
                </div>
                <div class="report-filter-body">
                    <!-- Attendance Legend -->
                    <div class="legend-box">
                        <span class="legend-title">Legend:</span>
                        <div class="legend-item">
                            <i class="fa fa-circle" style="color: #00c292;"></i>
                            <span>Present</span>
                        </div>
                        <div class="legend-item">
                            <i class="fa fa-circle" style="color: #f44236;"></i>
                            <span>Absent</span>
                        </div>
                        <div class="legend-item">
                            <i class="fa fa-circle" style="color: #03a9f3;"></i>
                            <span>Half Day</span>
                        </div>
                        <div class="legend-item">
                            <i class="fa fa-circle" style="color: #ff9800;"></i>
                            <span>Late</span>
                        </div>
                        <div class="legend-item">
                            <i class="fa fa-circle" style="color: #9e9e9e;"></i>
                            <span>Undefined</span>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Select Class -->
                        <div class="col-md-4">
                            <div class="report-form-group report-form-label">
                                <label><?php echo get_phrase('select_class');?> <span style="color: #f44236;">*</span></label>
                                <div class="report-form-input">
                                    <select class="form-control" id="class_id">
                                        <option value=""><?php echo get_phrase('select');?></option>
                                        <?php 
                                        $classes = $this->db->get('class')->result_array();
                                        foreach($classes as $key => $class):?>
                                        <option value="<?php echo $class['class_id'];?>"
                                            <?php if(isset($class_id) && $class_id==$class['class_id'])echo 'selected="selected"';?>>
                                                <?php echo $class['name'];?>
                                            </option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Select Month -->
                        <div class="col-md-4">
                            <div class="report-form-group report-form-label">
                                <label><?php echo get_phrase('month');?> <span style="color: #f44236;">*</span></label>
                                <div class="report-form-input">
                                    <select class="form-control" id="month">
                                        <?php $month = date('m'); ?>
                                        <?php
                                        for ($i = 1; $i <= 12; $i++):
                                            if ($i == 1)       $m = get_phrase('January');
                                            else if ($i == 2)  $m = get_phrase('February');
                                            else if ($i == 3)  $m = get_phrase('March');
                                            else if ($i == 4)  $m = get_phrase('April');
                                            else if ($i == 5)  $m = get_phrase('May');
                                            else if ($i == 6)  $m = get_phrase('June');
                                            else if ($i == 7)  $m = get_phrase('July');
                                            else if ($i == 8)  $m = get_phrase('August');
                                            else if ($i == 9)  $m = get_phrase('September');
                                            else if ($i == 10) $m = get_phrase('October');
                                            else if ($i == 11) $m = get_phrase('November');
                                            else if ($i == 12) $m = get_phrase('December');
                                        ?>
                                        <option value="<?php echo $i; ?>"<?php if($month == $i) echo 'selected'; ?>><?php echo $m; ?></option>
                                        <?php endfor;?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Select Year -->
                        <div class="col-md-4">
                            <div class="report-form-group report-form-label">
                                <label><?php echo get_phrase('year');?> <span style="color: #f44236;">*</span></label>
                                <div class="report-form-input">
                                    <select id="year" class="form-control">
                                        <?php $list_year = array("2019", "2020", "2021","2022", "2023","2024", "2025", "2026");
                                        foreach($list_year as $key => $row){
                                        ?>
                                        <option value="<?php echo $row;?>"<?php if($row == $year) echo 'selected';?>><?php echo $row;?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Search Button -->
                    <div class="report-form-button">
                        <button type="button" id="find"><i class="fa fa-search"></i>&nbsp;Generate Report</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- REPORT RESULTS -->
    <div class="report-results-container">
        <div id="data"><?php include 'loadAttendanceReport.php'; ?></div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#find').on('click', function() {
            var class_id = $('#class_id').val();
            var month    = $('#month').val();
            var year     = $('#year').val();
            
            if (class_id == "" || month == "" || year == "") {
                $.toast({
                    text: 'Please select class and date',
                    position: 'top-right',
                    loaderBg: '#f56954',
                    icon: 'warning',
                    hideAfter: 3500,
                    stack: 6
                });
                return false;
            }

            // Show loading state
            $('#data').html('<div class="report-loading"><i class="fa fa-spinner"></i><p>Generating report...</p></div>');

            $.ajax({
                url: '<?php echo site_url('teacher/loadAttendanceReport/');?>' + class_id + '/' + month + '/' + year
            }).done(function(response) {
                $('#data').html(response);
            }).fail(function() {
                $('#data').html('<div class="report-loading"><i class="fa fa-exclamation-circle"></i><p>Error loading report. Please try again.</p></div>');
            });
        });
    });
</script>