<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    .menu-bttn {
        background: none !important;
        border: none;
        padding: 0 !important;
        /*optional*/
        font-family: arial, sans-serif;
        /*input has OS specific font-family*/
        color: white;
        cursor: pointer;
    }
    .sidebar {

        width: 210px;
    }

</style>
<?php
//session_start();
?>
<div class="sidebar sidebar-main sidebar-default overlay" id="myNav" style="background-color:#1a4a73;">

    <div class="sidebar-content">
        <div class="sidebar-category sidebar-category-visible">
            <div class="category-content no-padding">
                <ul class="navigation navigation-main navigation-accordion" style="padding:0px 0;">
                    <br/>
                    <!--                    <li><a href="../dashboard.php"><i class="icon-home4"></i> <span>Dashboard</span></a></li>-->
                    <li>
                        <a href="#"><i class="icon-home4"></i><span>Dashboards</span></a>
                        <ul>
                            <li><a href="../line_status_grp_dashboard.php"><span>Cell Overview</span></a></li>
                            <li><a href="../dashboard.php"><span>Crew Status Overview</span></a></li>
                        </ul>
                    </li>
                    <?php
                    $msg = $_SESSION["side_menu"];
                    $msg = explode(',', $msg);
                    /*Taskboard*/
                    if (in_array('4', $msg)) {

                        ?>

                        <li>
                            <a href="#"><i class="icon-task"></i><span>Taskboard</span></a>
                            <ul>
                                <?php
                                if (in_array('9', $msg)) {

                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>taskboard_module/taskboard.php"><span>Taskboard</span></a></li>
                                    <?php
                                }
                                if (in_array('11', $msg)) {
                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>taskboard_module/create_taskboard.php"><span>Create Taskboard</span></a>
                                    </li>
                                    <?php
                                }
                                if (in_array('12', $msg)) {
                                    ?>
                                    <li>
                                        <a href="<?php echo $siteURL; ?>taskboard_module/create_task.php"><span>Create / Edit Task</span></a>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <?php
                    }
                    /*Forms*/
                    if (in_array('23', $msg)) {
                        ?>
                        <li>
                            <a href="#"><i class="icon-magazine"></i><span>Forms</span></a>
                            <ul>
                                <?php
                                if (in_array('42', $msg)) {
                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>form_module/form_settings.php"><span>Add / Create Form </span></a>
                                    </li>
                                    <?php
                                }
                                if (in_array('50', $msg)) {
                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>form_module/edit_form_options.php"><span>Edit Form</span></a>
                                    </li>
                                    <?php
                                }
                                if (in_array('38', $msg)) {
                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>form_module/options.php"><span>Submit Form</span></a>
                                    </li>
                                    <?php
                                }
                                if (in_array('44', $msg)) {
                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>form_module/form_search.php"><span>View Form </span></a>
                                    </li>
                                    <?php
                                }
                                if (in_array('49', $msg)) {
                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>form_module/pending_approval_list.php"><span>Pending Approval </span></a>
                                    </li>
                                    <?php
                                }
                                if (in_array('60', $msg)) {
                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>form_module/forms_recycle_bin.php"><span>Restore Form</span></a>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <?php
                    }
                    /*Station Events*/
                    if (in_array('45', $msg)) {
                        ?>
                        <li>
                            <a href="#"><i class="icon-magazine"></i><span>Station Events</span></a>
                            <ul>
                                <?php
                                if (in_array('46', $msg)) {
                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>events_module/station_events.php"><span>Add / Update Events</span></a></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <?php
                    }
                    /*Crew Assignment*/
                    if (in_array('7', $msg)) {
                        ?>
                        <li><a href="<?php echo $siteURL; ?>assignment_module/assign_crew.php"><i class="icon-copy"></i> <span>Crew Assignment</span></a>
                        </li>

                        <?php
                    }
                    /*Users*/
                    if (in_array('8', $msg)) {
                        ?>
                        <li>
                            <a href="#"><i class="icon-people"></i> <span>User Config</span></a>
                            <ul>
                                <?php
                                if (in_array('13', $msg)) {
                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>user_module/users_list.php">Add / Update User</a></li>
                                    <?php
                                }
                                if (in_array('14', $msg)) {
                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>user_module/role_list.php"><span>Add User Role(s)</span></a></li>
                                    <?php
                                }
                                if (in_array('61', $msg)) {
                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>user_module/user_custom_dashboard.php">Custom Dashboard</a></li>
                                    <?php
                                }
                                if (in_array('15', $msg)) {
                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>user_module/user_ratings.php">User Station-Pos Ratings</a></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <?php
                    }
                    /*Groups*/
                    if (in_array('17', $msg)) {
                        ?>
                        <li>
                            <a href="#"><i class="icon-user-plus"></i> <span>Groups</span></a>
                            <ul>
                                <?php
                                if (in_array('16', $msg)) {
                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>group.php">User Group(s)</a></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <?php
                    }
                    /*Mail Communication*/
                    if (in_array('5', $msg)) {
                        ?>
                        <li><a href="<?php echo $siteURL; ?>group_mail_module.php"><i class="fa fa-comments"></i>
                                <span>Mail Communicator</span></a></li>
                        <?php
                    }
                    /*Chat Communication*/
                    if (in_array('6', $msg)) {
                        ?>
                        <li><a href="<?php echo $siteURL; ?>chatbot/chat.php"><i class="fa fa-comments"></i> <span>Chat Communicator</span></a>
                        </li>
                        <?php
                    }
                    /*order module*/
                    if (in_array('57', $msg)) {
                        ?>
                        <li>
                            <a href="#"><i class="icon-user-plus"></i> <span>Order</span></a>
                            <ul>
                                <?php
                                if (in_array('54', $msg)) {
                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>order_module/create_order.php"><span>Create Order</span></a></li>
                                    <?php
                                }
                                if (in_array('58', $msg)) {
                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>order_module/historical_order.php"><span>Historical Order</span></a></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <?php
                    }
                    /*Configuration*/
                    if (in_array('18', $msg)) {
                        ?>
                        <li>
                            <a href="#"><i class="icon-gear"></i><span>Configurations</span></a>
                            <ul>
                                <?php
                                if (in_array('62', $msg)) {
                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>config_module/dashboard_config.php"><span>Cell Dashboard Config</span></a></li>
                                    <?php
                                }
                                if (in_array('24', $msg)) {
                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>config_module/line.php"><span>Station</span></a></li>
                                    <?php
                                }
                                if (in_array('56', $msg)) {
                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>config_module/accounts.php"><span>Customer Accounts</span></a></li>
                                    <?php
                                }
                                if (in_array('63', $msg)) {
                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>config_module/defect_group.php"><span>Defect Group</span></a></li>
                                    <?php
                                }
                                if (in_array('55', $msg)) {
                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>config_module/defect_list.php"><span>Defect List</span></a></li>
                                    <?php
                                }
                                if (in_array('43', $msg)) {
                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>config_module/form_type.php"><span>Form Type</span></a></li>
                                    <?php
                                }
                                if (in_array('52', $msg)) {
                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>config_module/event_category.php"><span>Event Category</span></a></li>
                                    <?php
                                }
                                if (in_array('47', $msg)) {
                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>config_module/event_type.php"><span>Event Type</span></a></li>
                                    <?php
                                }
                                if (in_array('25', $msg)) {
                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>config_module/position.php"><span>Position</span></a></li>
                                    <?php
                                }
                                if (in_array('26', $msg)) {
                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>config_module/job_title.php"><span>Job Title</span></a></li>
                                    <?php
                                }
                                if (in_array('27', $msg)) {
                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>config_module/shift_location.php"><span>Shift / Location</span></a>
                                    </li>
                                    <?php
                                }
                                if (in_array('28', $msg)) {
                                    ?>
                                    <li>
                                        <a href="<?php echo $siteURL; ?>config_module/station_pos_rel.php"><span>Station Position Config</span></a>
                                    </li>
                                    <?php
                                }
                                if (in_array('29', $msg)) {
                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>config_module/create_assets.php"><span>Assets Config</span></a></li>
                                    <?php
                                }
                                if (in_array('53', $msg)) {
                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>config_module/form_measurement_unit.php"><span>Measurement Unit</span></a></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <?php
                    }
                    /*Report Config*/
                    if (in_array('19', $msg)) {
                        ?>
                        <li>
                            <a href="#"><i class="icon-gear"></i><span>Report Config</span></a>
                            <ul>
                                <?php
                                if (in_array('31', $msg)) {
                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>report_config_module/communicator_config.php"><span>Communicator Config</span></a>
                                    </li>
                                    <?php
                                }
                                if (in_array('64', $msg)) {
                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>cronjobs/training_mail_config.php"><span>Training Completion Mail Config</span></a>
                                    </li>
                                    <?php
                                }
                                if (in_array('32', $msg)) {
                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>report_config_module/assignment_log_config.php"><span>Assignment Log Config</span></a>
                                    </li>
                                    <?php
                                }
                                if (in_array('33', $msg)) {
                                    ?>
                                    <li>
                                        <a href="<?php echo $siteURL; ?>report_config_module/task_log_config.php"><span>Task Log Config</span></a>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <?php
                    }
                    /*Parts Config*/
                    if (in_array('20', $msg)) {
                        ?>
                        <li>
                            <a href="#"><i class="icon-gear"></i><span>Parts</span></a>
                            <ul>
                                <?php
                                if (in_array('34', $msg)) {
                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>part_module/part_number.php"><span>Part Number</span></a></li>
                                    <?php
                                }
                                if (in_array('35', $msg)) {
                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>part_module/part_family.php"><span>Part Family</span></a></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <?php
                    }
                    /*Training Matrix*/
                    if (in_array('21', $msg)) {
                        ?>
                        <li><a href="<?php echo $siteURL; ?>table.php"><i class="icon-lifebuoy"></i> <span>Training Matrix</span></a></li>
                        <?php
                    }
                    /*Logs*/
                    if (in_array('22', $msg)) {
                        ?>
                        <li>
                            <a href="#"><i class="icon-magazine"></i><span>Logs</span></a>
                            <ul>
                                <?php
                                if (in_array('36', $msg)) {
                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>log_module/assign_crew_log.php"><span>Crew Assignment Log</span></a>
                                    </li>
                                    <?php
                                }
                                if (in_array('37', $msg)) {
                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>log_module/chat_log.php"><span>Chat Log</span></a></li>
                                    <?php
                                }
                                if (in_array('40', $msg)) {
                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>log_module/task_crew_log.php"><span>Task Crew Log</span></a></li>
                                    <?php
                                }
                                if (in_array('51', $msg)) {
                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>log_module/station_events_log.php"><span>Station Events Log</span></a></li>
                                    <?php
                                }
                                if (in_array('59', $msg)) {
                                    ?>
                                    <li><a href="<?php echo $siteURL; ?>log_module/good_bad_pieces_log.php"><span>Good Bad Pieces Log</span></a></li>
                                    <?php
                                }
                                ?>

                            </ul>
                        </li>
                        <?php
                    }


                    ?>

                    <!-- /main -->
                </ul>
            </div>
        </div>
    </div>
</div>
<style>
    html, body {
        max-width: 100%;
        overflow-x: hidden;
    }
</style>
