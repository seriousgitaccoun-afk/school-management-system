 <!--row -->
            <!-- QUICK LINKS SECTION -->
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
                    font-size: 28pt;
                    font-weight: 700;
                    color: #03a9f3;
                    margin-bottom: 8px;
                }

                .stat-label {
                    font-size: 12pt;
                    color: #686868;
                    font-weight: 500;
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

                .card-header-blue {
                    background: linear-gradient(135deg, #03a9f3 0%, #0288d1 100%);
                    color: white;
                    padding: 18px 25px;
                    font-weight: 600;
                    font-size: 13pt;
                }

                /* Chart Container */
                #chartdiv1 {
                    width: 100%;
                    height: 500px;
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

                .dashboard-table .avatar-cell {
                    display: flex;
                    align-items: center;
                    gap: 10px;
                }

                .avatar-cell svg {
                    flex-shrink: 0;
                }

                .table-body-content {
                    padding: 20px 25px;
                }

                @media (max-width: 768px) {
                    .quick-links-grid {
                        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
                    }

                    .section-title {
                        font-size: 14pt;
                    }
                }

                .amcharts-chart-div a {
                    display: none !important;
                }
            </style>

            <div class="dashboard-container">
                <!-- QUICK LINKS SECTION -->
                <div style="margin-bottom: 30px;">
                    <div class="section-title">
                        <i class="fa fa-bolt"></i> Quick Links
                    </div>
                    <div class="quick-links-grid">
                        <a href="<?php echo base_url();?>teacher/marks" class="quick-link-card">
                            <i class="fa fa-pencil-square-o"></i>
                            <small>Enter Marks</small>
                        </a>
                        <a href="<?php echo base_url();?>teacher/manage_attendance" class="quick-link-card">
                            <i class="fa fa-calendar-check-o"></i>
                            <small>Mark Attendance</small>
                        </a>
                        <a href="<?php echo base_url();?>teacher/assignment" class="quick-link-card">
                            <i class="fa fa-book"></i>
                            <small>Upload Assignment</small>
                        </a>
                        <a href="<?php echo base_url();?>teacher/my_classes" class="quick-link-card">
                            <i class="fa fa-university"></i>
                            <small>My Classes</small>
                        </a>
                    </div>
                </div>

                <!-- STATISTICS SECTION -->
                <div style="margin-bottom: 30px;">
                    <div class="section-title">
                        <i class="fa fa-bar-chart"></i> Overview
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="stats-card">
                                <div class="stat-icon blue">
                                    <i class="ti-user"></i>
                                </div>
                                <div class="stat-number"><?php echo $this->db->count_all_results('student');?></div>
                                <div class="stat-label"><?php echo get_phrase('Total Students');?></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="stats-card">
                                <div class="stat-icon green">
                                    <i class="ti-user"></i>
                                </div>
                                <div class="stat-number"><?php echo $this->db->count_all_results('parent');?></div>
                                <div class="stat-label"><?php echo get_phrase('Total Parents');?></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="stats-card">
                                <div class="stat-icon orange">
                                    <i class="ti-user"></i>
                                </div>
                                <div class="stat-number"><?php echo $this->db->count_all_results('teacher');?></div>
                                <div class="stat-label"><?php echo get_phrase('Total Teachers');?></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="stats-card">
                                <div class="stat-icon purple">
                                    <i class="ti-calendar"></i>
                                </div>
                                <div class="stat-number">
                                    <?php 
                                    $check_daily_attendance = array('date' => date('Y-m-d'), 'status' => '1');
                                    $get_attendance_information = $this->db->get_where('attendance', $check_daily_attendance);
                                    echo $get_attendance_information->num_rows();
                                    ?>
                                </div>
                                <div class="stat-label">Today's Attendance</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ATTENDANCE CHART SECTION -->
                <div class="row" style="margin-bottom: 30px;">
                    <div class="col-md-12">
                        <div class="data-display-card">
                            <div class="card-header-green">
                                <i class="fa fa-pie-chart"></i> Attendance Overview
                            </div>
                            <div style="padding: 25px;">
                                <script>
                                am4core.ready(function() {

                                // Themes begin
                                am4core.useTheme(am4themes_animated);
                                // Themes end

                                // Create chart instance
                                var chart = am4core.create("chartdiv1", am4charts.PieChart);

                                // Add data
                                chart.data = [
                    
                    <?php $selects = $this->db->get('attendance')->result_array(); //$this->crud_model->get_invoice_info();
                            foreach ($selects as $key => $select):?>

                                {
                                "country": "<?php echo $this->crud_model->get_type_name_by_id('student', $select['student_id']);?>",
                                "litres": <?= $this->db->get_where('student', array('student_id' => $select['student_id']))->num_rows();?>
                                }, 
                    <?php endforeach;?>
                                
                                ];

                                // Add and configure Series
                                var pieSeries = chart.series.push(new am4charts.PieSeries());
                                pieSeries.dataFields.value = "litres";
                                pieSeries.dataFields.category = "country";
                                pieSeries.innerRadius = am4core.percent(50);
                                pieSeries.ticks.template.disabled = true;
                                pieSeries.labels.template.disabled = true;

                                var rgm = new am4core.RadialGradientModifier();
                                rgm.brightnesses.push(-0.8, -0.8, -0.5, 0, - 0.5);
                                pieSeries.slices.template.fillModifier = rgm;
                                pieSeries.slices.template.strokeModifier = rgm;
                                pieSeries.slices.template.strokeOpacity = 0.4;
                                pieSeries.slices.template.strokeWidth = 0;

                                chart.legend = new am4charts.Legend();
                                chart.legend.position = "right";

                                }); // end am4core.ready()
                                </script>
                                <div id="chartdiv1"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RECENT DATA SECTION -->
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="data-display-card">
                            <div class="card-header-blue">
                                <i class="fa fa-user-circle"></i> Recently Added Teachers
                            </div>
                            <div class="table-body-content">
                                <table class="dashboard-table">
                                    <thead>
                                        <tr>
                                            <th>Avatar</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $get_teacher_from_model = $this->crud_model->list_all_teacher_and_order_with_teacher_id();
                                        foreach ($get_teacher_from_model as $key => $teacher):?>
                                        <tr>
                                            <td class="avatar-cell">
                                                <?php echo get_avatar_badge($teacher['name'], 40); ?>
                                            </td>
                                            <td><?php echo $teacher['name'];?></td>
                                            <td><?php echo $teacher['email'];?></td>
                                            <td><?php echo $teacher['phone'];?></td>
                                        </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="data-display-card">
                            <div class="card-header-blue">
                                <i class="fa fa-users"></i> Recently Added Students
                            </div>
                            <div class="table-body-content">
                                <table class="dashboard-table">
                                    <thead>
                                        <tr>
                                            <th>Avatar</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $get_student_from_model = $this->crud_model->list_all_student_and_order_with_student_id();
                                        foreach ($get_student_from_model as $key => $student):?>
                                        <tr>
                                            <td class="avatar-cell">
                                                <?php echo get_avatar_badge($student['name'], 40); ?>
                                            </td>
                                            <td><?php echo $student['name'];?></td>
                                            <td><?php echo $student['email'];?></td>
                                            <td><?php echo $student['phone'];?></td>
                                        </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
