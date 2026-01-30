 <!--row -->
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

                /* Development Alert Card */
                .dev-alert-card {
                    background: linear-gradient(135deg, #fff3cd 0%, #fffbea 100%);
                    border-left: 4px solid #ffc107;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.08);
                    margin-bottom: 30px;
                }

                .dev-alert-card h5 {
                    color: #856404;
                    margin-bottom: 10px;
                    font-weight: 600;
                }

                .dev-alert-card p {
                    color: #856404;
                    margin-bottom: 12px;
                    font-size: 11pt;
                }

                /* Quick Links Cards */
                .quick-links-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
                    gap: 15px;
                    margin-bottom: 30px;
                }

                .quick-link-card {
                    background: linear-gradient(135deg, #03a9f3 0%, #0288d1 100%);
                    color: white;
                    padding: 18px;
                    border-radius: 8px;
                    text-align: center;
                    text-decoration: none;
                    transition: all 0.3s ease;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    gap: 8px;
                    font-weight: 500;
                    min-height: 100px;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                }

                .quick-link-card i {
                    font-size: 24pt;
                }

                .quick-link-card small {
                    font-size: 11pt;
                    line-height: 1.4;
                }

                .quick-link-card:hover {
                    transform: translateY(-3px);
                    box-shadow: 0 4px 12px rgba(3, 169, 243, 0.3);
                    text-decoration: none;
                    color: white;
                }

                .quick-link-card:nth-child(2) {
                    background: linear-gradient(135deg, #0288d1 0%, #0277bd 100%);
                }

                .quick-link-card:nth-child(3) {
                    background: linear-gradient(135deg, #00c292 0%, #00897b 100%);
                }

                .quick-link-card:nth-child(4) {
                    background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
                }

                .quick-link-card:nth-child(5) {
                    background: linear-gradient(135deg, #f44236 0%, #d32f2f 100%);
                }

                .quick-link-card:nth-child(6) {
                    background: linear-gradient(135deg, #01c0c8 0%, #0097a7 100%);
                }

                /* Stats Cards */
                .stats-card {
                    background: white;
                    border-radius: 8px;
                    padding: 20px;
                    margin-bottom: 15px;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.08);
                    border: 1px solid #e4e7ea;
                    transition: all 0.3s ease;
                    text-align: center;
                }

                .stats-card:hover {
                    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
                    transform: translateY(-2px);
                }

                .stat-icon {
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    width: 50px;
                    height: 50px;
                    border-radius: 8px;
                    margin: 0 auto 12px;
                    font-size: 24pt;
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

                .stat-icon.red {
                    background: linear-gradient(135deg, #f44236 0%, #d32f2f 100%);
                }

                .stat-icon.cyan {
                    background: linear-gradient(135deg, #01c0c8 0%, #0097a7 100%);
                }

                .stat-number {
                    font-size: 22pt;
                    font-weight: 700;
                    color: #03a9f3;
                    margin-bottom: 8px;
                    line-height: 1;
                }

                .stat-label {
                    font-size: 11pt;
                    color: #686868;
                    font-weight: 500;
                }

                /* Chart Cards */
                .chart-card {
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
                .data-table {
                    background: white;
                    border-radius: 8px;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.08);
                    border: 1px solid #e4e7ea;
                    overflow: hidden;
                    margin-bottom: 20px;
                }

                .data-table-header {
                    background: linear-gradient(135deg, #00c292 0%, #00897b 100%);
                    color: white;
                    padding: 18px 25px;
                    font-weight: 600;
                    font-size: 13pt;
                }

                .data-table table {
                    margin-bottom: 0;
                }

                .data-table table thead tr {
                    background-color: #f5f5f5;
                    border-bottom: 2px solid #e4e7ea;
                }

                .data-table table thead th {
                    font-weight: 600;
                    color: #2b2b2b;
                    padding: 15px;
                    font-size: 11pt;
                    border: none;
                }

                .data-table table tbody tr {
                    border-bottom: 1px solid #e4e7ea;
                    transition: all 0.2s ease;
                }

                .data-table table tbody tr:hover {
                    background-color: #f9f9f9;
                }

                .data-table table tbody td {
                    padding: 12px 15px;
                    font-size: 11pt;
                    color: #2b2b2b;
                    vertical-align: middle;
                }

                .data-table table tbody img {
                    border-radius: 50%;
                    display: block;
                    margin: 0 auto;
                }

                #chartdiv,
                #chartdiv1 {
                    width: 100%;
                    height: 400px;
                }

                .amcharts-chart-div a {
                    display: none !important;
                }

                /* Responsive Design */
                @media (max-width: 1200px) {
                    .quick-links-grid {
                        grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
                    }

                    #chartdiv,
                    #chartdiv1 {
                        height: 350px;
                    }
                }

                @media (max-width: 768px) {
                    .quick-links-grid {
                        grid-template-columns: repeat(auto-fit, minmax(90px, 1fr));
                        gap: 10px;
                    }

                    .quick-link-card {
                        padding: 15px;
                        min-height: 85px;
                        font-size: 10pt;
                    }

                    .quick-link-card i {
                        font-size: 20pt;
                    }

                    .quick-link-card small {
                        font-size: 9pt;
                    }

                    .section-title {
                        font-size: 14pt;
                        margin-bottom: 15px;
                    }

                    .section-title i {
                        font-size: 16pt;
                    }

                    .stats-card {
                        padding: 15px;
                        margin-bottom: 12px;
                    }

                    .stat-icon {
                        width: 45px;
                        height: 45px;
                        font-size: 20pt;
                        margin-bottom: 10px;
                    }

                    .stat-number {
                        font-size: 18pt;
                        margin-bottom: 6px;
                    }

                    .stat-label {
                        font-size: 10pt;
                    }

                    #chartdiv,
                    #chartdiv1 {
                        height: 300px;
                    }

                    .card-header-green,
                    .data-table-header {
                        padding: 15px 20px;
                        font-size: 12pt;
                    }

                    .data-table table thead th {
                        padding: 12px;
                        font-size: 10pt;
                    }

                    .data-table table tbody td {
                        padding: 10px 12px;
                        font-size: 10pt;
                    }
                }

                @media (max-width: 480px) {
                    .quick-links-grid {
                        grid-template-columns: repeat(2, 1fr);
                        gap: 8px;
                    }

                    .quick-link-card {
                        padding: 12px;
                        min-height: 75px;
                        font-size: 9pt;
                    }

                    .quick-link-card i {
                        font-size: 18pt;
                    }

                    .section-title {
                        font-size: 12pt;
                        margin-bottom: 12px;
                        gap: 5px;
                    }

                    .stats-card {
                        padding: 12px;
                        margin-bottom: 10px;
                    }

                    .stat-icon {
                        width: 40px;
                        height: 40px;
                        font-size: 18pt;
                    }

                    .stat-number {
                        font-size: 16pt;
                    }

                    .stat-label {
                        font-size: 9pt;
                    }

                    #chartdiv,
                    #chartdiv1 {
                        height: 250px;
                    }

                    .data-table table thead th {
                        padding: 8px;
                        font-size: 9pt;
                    }

                    .data-table table tbody td {
                        padding: 8px;
                        font-size: 9pt;
                    }
                }
            </style>

            <div class="dashboard-container">
                <!-- Development Alert -->
                <div class="dev-alert-card">
                    <h5><i class="fa fa-exclamation-triangle"></i> Testing & Development Mode</h5>
                    <p>Use the button below to wipe all data from the database while preserving the table structure. Useful during testing.</p>
                    <button type="button" class="btn btn-danger" onclick="showWipeDatabaseDialog()">
                        <i class="fa fa-trash"></i> Wipe All Data
                    </button>
                </div>

                <!-- QUICK LINKS SECTION -->
                <div style="margin-bottom: 30px;">
                    <div class="section-title">
                        <i class="fa fa-bolt"></i> Quick Links
                    </div>
                    <div class="quick-links-grid">
                        <a href="<?php echo base_url();?>admin/new_student" class="quick-link-card">
                            <i class="fa fa-user-plus"></i>
                            <small>Add Student</small>
                        </a>
                        <a href="<?php echo base_url();?>admin/teacher" class="quick-link-card">
                            <i class="fa fa-user-tie"></i>
                            <small>Add Teacher</small>
                        </a>
                        <a href="<?php echo base_url();?>admin/classes" class="quick-link-card">
                            <i class="fa fa-university"></i>
                            <small>Manage Classes</small>
                        </a>
                        <a href="<?php echo base_url();?>subject/subject/" class="quick-link-card">
                            <i class="fa fa-book"></i>
                            <small>Manage Subjects</small>
                        </a>
                        <a href="<?php echo base_url();?>admin/student_payment" class="quick-link-card">
                            <i class="fa fa-credit-card"></i>
                            <small>Record Payment</small>
                        </a>
                        <a href="<?php echo base_url();?>admin/manage_attendance" class="quick-link-card">
                            <i class="fa fa-calendar-check-o"></i>
                            <small>Mark Attendance</small>
                        </a>
                    </div>
                </div>

                <!-- STATISTICS SECTION -->
                <div style="margin-bottom: 30px;">
                    <div class="section-title">
                        <i class="fa fa-bar-chart"></i> Overview
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <div class="stats-card">
                                <div class="stat-icon blue">
                                    <i class="ti-user"></i>
                                </div>
                                <div class="stat-number"><?php echo $this->db->count_all_results('student');?></div>
                                <div class="stat-label">Total Students</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <div class="stats-card">
                                <div class="stat-icon green">
                                    <i class="ti-user"></i>
                                </div>
                                <div class="stat-number"><?php echo $this->db->count_all_results('teacher');?></div>
                                <div class="stat-label">Total Teachers</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <div class="stats-card">
                                <div class="stat-icon orange">
                                    <i class="ti-user"></i>
                                </div>
                                <div class="stat-number"><?php echo $this->db->count_all_results('parent');?></div>
                                <div class="stat-label">Total Parents</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <div class="stats-card">
                                <div class="stat-icon purple">
                                    <i class="ti-book"></i>
                                </div>
                                <div class="stat-number"><?php echo $this->db->count_all_results('assignment');?></div>
                                <div class="stat-label">Total Assignments</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <div class="stats-card">
                                <div class="stat-icon red">
                                    <i class="ti-money"></i>
                                </div>
                                <div class="stat-number">
                                    <?php 
                                    $this->db->select_sum('amount');
                                    $this->db->from('payment');
                                    $this->db->where('payment_type', 'expense');
                                    $query = $this->db->get();
                                    $expense_amount = $query->row()->amount;
                                    echo $expense_amount ?: '0';
                                    ?>
                                </div>
                                <div class="stat-label">Total Expenses</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <div class="stats-card">
                                <div class="stat-icon blue">
                                    <i class="ti-money"></i>
                                </div>
                                <div class="stat-number">
                                    <?php 
                                    $this->db->select_sum('amount');
                                    $this->db->from('payment');
                                    $this->db->where('payment_type', 'income');
                                    $query = $this->db->get();
                                    $income_amount = $query->row()->amount;
                                    echo $income_amount ?: '0';
                                    ?>
                                </div>
                                <div class="stat-label">Total Income</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <div class="stats-card">
                                <div class="stat-icon cyan">
                                    <i class="ti-wallet"></i>
                                </div>
                                <div class="stat-number"><?php echo $this->db->count_all_results('admin');?></div>
                                <div class="stat-label">Total Admins</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <div class="stats-card">
                                <div class="stat-icon green">
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

                <!-- CHARTS SECTION -->
                <div class="row">
                    <div class="col-md-5 col-sm-12 col-xs-12">
                        <div class="chart-card">
                            <div class="card-header-green">
                                <i class="fa fa-pie-chart"></i> Expense Distribution
                            </div>
                            <div style="padding: 25px;">
                                <script>
                                am4core.ready(function() {
                                    am4core.useTheme(am4themes_animated);
                                    var chart = am4core.create("chartdiv1", am4charts.PieChart);
                                    chart.data = [
                        <?php $select_expense = $this->db->get_where('payment', array('payment_type' => 'expense', 'year' => $running_year))->result_array();
                                foreach ($select_expense as $key => $expense_selected):?>
                                        {
                                        "country": "<?php echo $expense_selected['title'];?>",
                                        "litres": <?php echo $expense_selected['amount'];?>
                                        },
                        <?php endforeach;?>
                                    ];
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
                                });
                                </script>
                                <div id="chartdiv1"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 col-sm-12 col-xs-12">
                        <div class="chart-card">
                            <div class="card-header-green">
                                <i class="fa fa-bar-chart"></i> Student Payment History
                            </div>
                            <div style="padding: 25px;">
                                <script>
                                am4core.ready(function() {
                                    am4core.useTheme(am4themes_animated);
                                    var chart = am4core.create("chartdiv", am4charts.XYChart);
                                    chart.hiddenState.properties.opacity = 0;
                                    chart.paddingBottom = 30;
                                    chart.data = [
                        <?php $select_student = $this->db->get_where('invoice', array('year' => $running_year))->result_array();
                                foreach ($select_student as $key => $student_selected):?>
                            {
                            "name": "<?php echo $this->crud_model->get_type_name_by_id('student', $student_selected['student_id']);?>",
                            "steps": <?php echo $student_selected['amount_paid'];?>,
                            "href": "<?php echo base_url();?>uploads/student_image/<?php echo $student_selected['student_id']. '.jpg';?>"
                            },
                        <?php endforeach;?>
                                    ];
                                    var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                                    categoryAxis.dataFields.category = "name";
                                    categoryAxis.renderer.grid.template.strokeOpacity = 0;
                                    categoryAxis.renderer.minGridDistance = 10;
                                    categoryAxis.renderer.labels.template.dy = 35;
                                    categoryAxis.renderer.tooltip.dy = 35;
                                    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                                    valueAxis.renderer.inside = true;
                                    valueAxis.renderer.labels.template.fillOpacity = 0.3;
                                    valueAxis.renderer.grid.template.strokeOpacity = 0;
                                    valueAxis.min = 0;
                                    valueAxis.cursorTooltipEnabled = false;
                                    valueAxis.renderer.baseGrid.strokeOpacity = 0;
                                    var series = chart.series.push(new am4charts.ColumnSeries);
                                    series.dataFields.valueY = "steps";
                                    series.dataFields.categoryX = "name";
                                    series.tooltipText = "{valueY.value}";
                                    series.tooltip.pointerOrientation = "vertical";
                                    series.tooltip.dy = - 6;
                                    series.columnsContainer.zIndex = 100;
                                    var columnTemplate = series.columns.template;
                                    columnTemplate.width = am4core.percent(50);
                                    columnTemplate.maxWidth = 66;
                                    columnTemplate.column.cornerRadius(60, 60, 10, 10);
                                    columnTemplate.strokeOpacity = 0;
                                    series.heatRules.push({ target: columnTemplate, property: "fill", dataField: "valueY", min: am4core.color("#e5dc36"), max: am4core.color("#5faa46") });
                                    series.mainContainer.mask = undefined;
                                    var cursor = new am4charts.XYCursor();
                                    chart.cursor = cursor;
                                    cursor.lineX.disabled = true;
                                    cursor.lineY.disabled = true;
                                    cursor.behavior = "none";
                                    var bullet = columnTemplate.createChild(am4charts.CircleBullet);
                                    bullet.circle.radius = 30;
                                    bullet.valign = "bottom";
                                    bullet.align = "center";
                                    bullet.isMeasured = true;
                                    bullet.mouseEnabled = false;
                                    bullet.verticalCenter = "bottom";
                                    bullet.interactionsEnabled = false;
                                    var hoverState = bullet.states.create("hover");
                                    var outlineCircle = bullet.createChild(am4core.Circle);
                                    outlineCircle.adapter.add("radius", function (radius, target) {
                                        var circleBullet = target.parent;
                                        return circleBullet.circle.pixelRadius + 10;
                                    })
                                    var image = bullet.createChild(am4core.Image);
                                    image.width = 60;
                                    image.height = 60;
                                    image.horizontalCenter = "middle";
                                    image.verticalCenter = "middle";
                                    image.propertyFields.href = "href";
                                    image.adapter.add("mask", function (mask, target) {
                                        var circleBullet = target.parent;
                                        return circleBullet.circle;
                                    })
                                    var previousBullet;
                                    chart.cursor.events.on("cursorpositionchanged", function (event) {
                                        var dataItem = series.tooltipDataItem;
                                        if (dataItem.column) {
                                            var bullet = dataItem.column.children.getIndex(1);
                                            if (previousBullet && previousBullet != bullet) {
                                                previousBullet.isHover = false;
                                            }
                                            if (previousBullet != bullet) {
                                                var hs = bullet.states.getKey("hover");
                                                hs.properties.dy = -bullet.parent.pixelHeight + 30;
                                                bullet.isHover = true;
                                                previousBullet = bullet;
                                            }
                                        }
                                    })
                                });
                                </script>
                                <div id="chartdiv"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DATA TABLES SECTION -->
                <div class="row" style="margin-top: 20px;">
                    <div class="col-sm-6">
                        <div class="data-table">
                            <div class="data-table-header">
                                <i class="fa fa-users"></i> Recently Added Teachers
                            </div>
                            <div style="overflow-x: auto;">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                        <?php $get_teacher_from_model = $this->crud_model->list_all_teacher_and_order_with_teacher_id();
                                foreach ($get_teacher_from_model as $key => $teacher):?>
                                        <tr>
                                            <td style="text-align: center;"><img src="<?php echo $teacher['face_file'];?>" class="img-circle" width="40px"></td>
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
                    <div class="col-sm-6">
                        <div class="data-table">
                            <div class="data-table-header">
                                <i class="fa fa-graduation-cap"></i> Recently Added Students
                            </div>
                            <div style="overflow-x: auto;">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                        <?php $get_student_from_model = $this->crud_model->list_all_student_and_order_with_student_id();
                                foreach ($get_student_from_model as $key => $student):?>
                                        <tr>
                                            <td style="text-align: center;"><img src="<?php echo $student['face_file'];?>" class="img-circle" width="40px"></td>
                                            <td><?php echo $student['name'];?></td>
                                            <td><?php echo $student['email'];?></td>
                                            <td><?php echo $student['phone'];?></td>
                                        </tr>
                        <?php endforeach;?>
            </div>

<!-- Wipe Database Modal -->
<div class="modal fade" id="wipeDatabaseModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-exclamation-triangle"></i> Wipe All Data</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" role="alert">
                    <strong>Warning!</strong> This action will delete ALL data from the database while preserving table structure. This cannot be undone.
                </div>
                <p><strong>Tables that will be cleared:</strong></p>
                <ul>
                    <li>Students</li>
                    <li>Teachers</li>
                    <li>Parents</li>
                    <li>Classes</li>
                    <li>Marks & Attendance</li>
                    <li>Payments & Invoices</li>
                    <li>And more...</li>
                </ul>
                <div class="form-group">
                    <label>You are logged in as:</label>
                    <div class="alert alert-info">
                        <strong id="adminEmailDisplay"></strong>
                    </div>
                </div>
                <div class="form-group">
                    <label for="adminPassword">Enter your admin password to confirm:</label>
                    <input type="password" class="form-control" id="adminPassword" placeholder="Admin password">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="confirmWipeDatabase()">
                    <i class="fa fa-trash"></i> Yes, Wipe All Data
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function showWipeDatabaseDialog() {
    $('#adminPassword').val('');
    // Try to get admin email from session or page - you may need to add a hidden element with admin info
    let adminEmail = document.getElementById('adminEmailDisplay');
    if (adminEmail) {
        // This will be populated by the server
    }
    $('#wipeDatabaseModal').modal('show');
}

function confirmWipeDatabase() {
    let password = document.getElementById('adminPassword').value;
    
    if (!password) {
        alert('Please enter your admin password');
        return;
    }

    $.ajax({
        url: '<?php echo base_url('admin/wipe_database'); ?>',
        method: 'POST',
        data: { admin_password: password },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                alert(response.message);
                $('#wipeDatabaseModal').modal('hide');
                // Reload the page to show updated stats
                setTimeout(() => location.reload(), 500);
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function() {
            alert('Error communicating with server');
        }
    });
}
</script>
