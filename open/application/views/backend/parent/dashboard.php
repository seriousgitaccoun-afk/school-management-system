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
                    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
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
                    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    gap: 8px;
                    font-weight: 500;
                    min-height: 100px;
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

                /* Chart Card */
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

                #chartdiv {
                    width: 100%;
                    height: 500px;
                }

                .amcharts-chart-div a {
                    display: none !important;
                }

                @media (max-width: 1200px) {
                    .quick-links-grid {
                        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
                    }

                    #chartdiv {
                        height: 400px;
                    }
                }

                @media (max-width: 768px) {
                    .quick-links-grid {
                        grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
                        gap: 10px;
                    }

                    .quick-link-card {
                        padding: 15px;
                        min-height: 90px;
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

                    #chartdiv {
                        height: 300px;
                    }

                    .card-header-green {
                        padding: 15px 20px;
                        font-size: 12pt;
                    }
                }

                @media (max-width: 480px) {
                    .quick-links-grid {
                        grid-template-columns: repeat(2, 1fr);
                        gap: 8px;
                    }

                    .quick-link-card {
                        padding: 12px;
                        min-height: 80px;
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

                    #chartdiv {
                        height: 250px;
                    }
                }
            </style>

            <div class="dashboard-container">
                <!-- QUICK LINKS SECTION -->
                <div style="margin-bottom: 30px;">
                    <div class="section-title">
                        <i class="fa fa-bolt"></i> Quick Links
                    </div>
                    <div class="quick-links-grid">
                        <a href="<?php echo base_url();?>parent/child_marks" class="quick-link-card">
                            <i class="fa fa-list"></i>
                            <small>Child's Marks</small>
                        </a>
                        <a href="<?php echo base_url();?>parent/child_attendance" class="quick-link-card">
                            <i class="fa fa-calendar-check-o"></i>
                            <small>Child Attendance</small>
                        </a>
                        <a href="<?php echo base_url();?>parent/payment_history" class="quick-link-card">
                            <i class="fa fa-history"></i>
                            <small>Payment History</small>
                        </a>
                        <a href="<?php echo base_url();?>parent/child_profile" class="quick-link-card">
                            <i class="fa fa-user"></i>
                            <small>Child Profile</small>
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
                                    <i class="ti-calendar"></i>
                                </div>
                                <div class="stat-number">
                                    <?php 
                                    $parent_student_logic = $this->db->get_where('student', array('parent_id'=> $this->session->userdata('parent_id')))->row()->student_id;
                                    $check_daily_attendance = array('date' => date('Y-m-d'), 'status' => '1');
                                    $get_attendance_information = $this->db->get_where('attendance', $check_daily_attendance, 'student_id', $parent_student_logic);
                                    echo $get_attendance_information->num_rows();
                                    ?>
                                </div>
                                <div class="stat-label">Today's Attendance</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CHART SECTION -->
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="chart-card">
                            <div class="card-header-green">
                                <i class="fa fa-bar-chart"></i> Payment History
                            </div>
                            <div style="padding: 25px;">
                                <script>
                                am4core.ready(function() {

                                // Themes begin
                                am4core.useTheme(am4themes_animated);
                                // Themes end

                                /**
                                * Chart design taken from Samsung health app
                                */

                                var chart = am4core.create("chartdiv", am4charts.XYChart);
                                chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

                                chart.paddingBottom = 30;

                                chart.data = [
                    
                                    <?php 
                                    $parent_student_logic = $this->db->get_where('student', array('parent_id'=> $this->session->userdata('parent_id')))->row()->student_id;
                                    $select_student = $this->db->get_where('invoice', array('year' => $running_year, 'student_id' => $parent_student_logic))->result_array(); //$this->crud_model->get_invoice_info();
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

                                }); // end am4core.ready()
                                </script>

                                <!-- HTML -->
                                <div id="chartdiv"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
