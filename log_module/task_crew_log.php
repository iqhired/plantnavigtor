<?php
include("../config.php");
$curdate = date('Y-m-d');
//$dateto = $curdate;
//$datefrom = $curdate;
$button = "";
$temp = "";
if (!isset($_SESSION['user'])) {
    header('location: logout.php');
}


//Set the session duration for 10800 seconds - 3 hours
$duration = $auto_logout_duration;
//Read the request time of the user
$time = $_SERVER['REQUEST_TIME'];
//Check the user's session exist or not
if (isset($_SESSION['LAST_ACTIVITY']) && ($time - $_SESSION['LAST_ACTIVITY']) > $duration) {
	//Unset the session variables
	session_unset();
	//Destroy the session
	session_destroy();
	header($redirect_logout_path);
//	header('location: ../logout.php');
	exit;
}
//Set the time of the user's last activity
$_SESSION['LAST_ACTIVITY'] = $time;

$_SESSION['taskboard'] = "";
$_SESSION['user'] = "";
$_SESSION['date_from'] = "";
$_SESSION['date_to'] = "";
$_SESSION['button'] = "";
$_SESSION['timezone'] = "";
if (count($_POST) > 0) {
    $_SESSION['taskboard'] = $_POST['taskboard'];
    $_SESSION['user'] = $_POST['user'];
    $_SESSION['date_from'] = $_POST['date_from'];
    $_SESSION['date_to'] = $_POST['date_to'];
    $_SESSION['button'] = $_POST['button'];
    $_SESSION['timezone'] = $_POST['timezone'];
    $taskboard = $_POST['taskboard'];
    $user = $_POST['user'];
    $dateto = $_POST['date_to'];
    $datefrom = $_POST['date_from'];
    $button = $_POST['button'];
    $timezone = $_POST['timezone'];
}
if (count($_GET) > 0) {
    $station1 = $_GET['line'];
    $qurtemp = mysqli_query($db, "SELECT * FROM  cam_line where line_id = '$station1' ");
    while ($rowctemp = mysqli_fetch_array($qurtemp)) {
        $station = $rowctemp["line_name"];
    }
}

if(empty($dateto)){
	$curdate = date('Y-m-d');
	$dateto = $curdate;
}

if(empty($datefrom)){
	$yesdate = date('Y-m-d',strtotime("-1 days"));
	$datefrom = $yesdate;
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $sitename; ?> | Task Crew Log</title>
        <!-- Global stylesheets -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
        <link href="../assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
        <link href="../assets/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="../assets/css/core.css" rel="stylesheet" type="text/css">
        <link href="../assets/css/components.css" rel="stylesheet" type="text/css">
        <link href="../assets/css/colors.css" rel="stylesheet" type="text/css">
        <link href="../assets/css/style_main.css" rel="stylesheet" type="text/css">
        <!-- /global stylesheets -->
        <!-- Core JS files -->
        <script type="text/javascript" src="../assets/js/libs/jquery-3.6.0.min.js"> </script>
        <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/loaders/pace.min.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/loaders/blockui.min.js"></script>
        <!-- /core JS files -->
        <!-- Theme JS files -->
        <script type="text/javascript" src="../assets/js/plugins/tables/datatables/datatables.min.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
        <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/notifications/sweet_alert.min.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
        <script type="text/javascript" src="../assets/js/pages/form_bootstrap_select.js"></script>
        <script type="text/javascript" src="../assets/js/pages/form_layouts.js"></script>
       <style>
            .datatable-scroll {
                width: 100%;
                overflow-x: scroll;
            }

            .col-md-6.date {
                margin-top: 20px;
                width: 25%;
            }
            .col-md-2 {
                width: 8.666667%!important;
            }
            @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {

                .col-md-2 {
                    width: 30%!important;
                    float: left;
                }
                .col-md-6.date {
                    width: 100%;
                    float: left;
                }
                .col-lg-8 {
                    float: right;
                    width: 65%;
                }
                label.col-lg-3.control-label {
                    width: 34%;
                }
            }
            .p_footer {
                padding-top: 7px;
                padding-bottom: 5px;
                padding-left: 15px;
                background: #f7f7f7;
                margin-top: 22px;
            }
            .col-md-2 {
                width: 30%;
                float: left;
            }
        </style>        
        <script>
            window.onload = function() {
                history.replaceState("", "", "<?php echo $scriptName; ?>log_module/task_crew_log.php");
         // $('#timezone').prop('disabled', true);	 
                        
            }
        </script>
        
        <?php
        if ($button == "button2") {
            ?>
            <script>
                $(function () {
                    $('#date_from').prop('disabled', true);
                    $('#date_to').prop('disabled', true);
                    $('#timezone').prop('disabled', false);
                });
            </script>
            <?php
        } else {
            ?>
            <script>
                $(function () {
                    $('#date_from').prop('disabled', false);
                    $('#date_to').prop('disabled', false);
                    $('#timezone').prop('disabled', true);
                });
            </script>
            <?php
        }
        ?>
    </head>

        <!-- Main navbar -->
        <?php
        $cust_cam_page_header = "Task Crew Log";
        include("../header.php");
        include("../admin_menu.php");
        include("../heading_banner.php");
             ?>
        <body class="alt-menu sidebar-noneoverflow">
        <!-- /main navbar -->
        <!-- Page container -->
        <div class="page-container">

                    <!-- Content area -->
                    <div class="content">
                        <!-- Main charts -->
                        <!-- Basic datatable -->
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <!--							<h5 class="panel-title">Stations</h5>-->
                                <!--							<hr/>-->

                                    <form action="" id="user_form" class="form-horizontal" method="post">
                                        <div class="row">
                                        <div class="col-md-6 mobile">
                                            <label class="col-lg-3 control-label">Taskboard :</label>

                                        <div class="col-lg-8">
                                            <select  name="taskboard" id="taskboard" class="select"  style="float: left;width: initial;" >
                                                <option value="" selected disabled>--- Select Taskboard ---</option>
                                                <?php
                                                        $sql1 = "SELECT * FROM `sg_taskboard` ";

                                                $result1 = $mysqli->query($sql1);
//                                            $entry = 'selected';
                                                        while ($row1 = $result1->fetch_assoc()) {
                                                            $lin = $row1['sg_taskboard_id'];
															
                                                            if ($lin == $taskboard) {
                                                                $entry = 'selected';
                                                            } else {
                                                                $entry = '';
                                                            }
                                                            echo "<option value='" . $row1['sg_taskboard_id'] . "' $entry >" . $row1['taskboard_name'] . "</option>";
                                                        }
                                                ?>
                                            </select>
                                        </div>
                                      </div>
                                         <div class="col-md-6 mobile">
                                            <label class="col-lg-3 control-label">User :</label>
                                             <div class="col-lg-8">
                                                    <select  name="user" id="user" class="select" style="float: left;width: initial;" >
                                                        <option value="" selected >--- Select User ---</option>
                                                        <?php
                                                        $sql1 = "SELECT DISTINCT tt.assign_to FROM tm_task as tt right join cam_users as cu on tt.assign_to = cu.users_id where tt.assign_to != '' and cu.is_deleted != 1";
                                                        $result1 = $mysqli->query($sql1);
                                                        //$entry = 'selected';
                                                        while ($row1 = $result1->fetch_assoc()) {
                                                            $lin = $row1['assign_to'];
                                                            if ($lin == $user) {
                                                                $entry = 'selected';
                                                            } else {
                                                                $entry = '';
                                                            }
                                                            $qur05 = mysqli_query($db, "SELECT * FROM  cam_users where users_id = '$lin' and is_deleted != 1 ");
                                                            while ($rowc05 = mysqli_fetch_array($qur05)) {
                                                                $lnnm = $rowc05["firstname"]." ".$rowc05["lastname"];
                                                            }
                                                            echo "<option value='" . $row1['assign_to'] . "' $entry >" . $lnnm . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <!--                                    <div class="col-md-5">-->
                                                <!--                                        <label class="control-label" style="float: left;padding-top: 10px; font-weight: 500;">Select Period : &nbsp;&nbsp;</label>-->
                                                <!--                                        --><?php
                                                //                                        if ($button == "button2") {
                                                //                                            $checked = "checked";
                                                //                                        } else {
                                                //                                            $checked = "";
                                                //                                        }
                                                //                                        ?>
                                                <!--                                        <input type="radio" name="button" id="button2" value="button2" class="form-control" style="float: left;width: initial;" --><?php //echo $checked; ?><!--</input>-->
                                                <!--                                        <label class="control-label" style="float: left;padding-top: 10px; font-weight: 500;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>-->
                                                <!--                                        <select  name="timezone" id="timezone" class="form-control" style="float: left;width: initial;" >-->
                                                <!--                                            <option value="" selected disabled>--- Select Period ---</option>-->
                                                <!--                                            --><?php
                                                //                                            if ($timezone == "1") {
                                                //                                                $selected = "selected";
                                                //                                            } else {
                                                //                                                $selected = "";
                                                //                                            }
                                                //                                            ?>
                                                <!--                                            <option value="1" --><?php //echo $selected; ?><!--One Day</option>-->
                                                <!--                                            --><?php
                                                //                                            if ($timezone == "7") {
                                                //                                                $selected = "selected";
                                                //                                            } else {
                                                //                                                $selected = "";
                                                //                                            }
                                                //                                            ?>
                                                <!--                                            <option value="7" --><?php //echo $selected; ?><!--One Week</option>-->
                                                <!--                                            --><?php
                                                //                                            if ($timezone == "30") {
                                                //                                                $selected = "selected";
                                                //                                            } else {
                                                //                                                $selected = "";
                                                //                                            }
                                                //                                            ?>
                                                <!--                                            <option value="30" --><?php //echo $selected; ?><!--One Month</option>-->
                                                <!--                                            --><?php
                                                //                                            if ($timezone == "90") {
                                                //                                                $selected = "selected";
                                                //                                            } else {
                                                //                                                $selected = "";
                                                //                                            }
                                                //                                            ?>
                                                <!--                                            <option value="90" --><?php //echo $selected; ?><!--Three Month</option>-->
                                                <!--                                            --><?php
                                                //                                            if ($timezone == "180") {
                                                //                                                $selected = "selected";
                                                //                                            } else {
                                                //                                                $selected = "";
                                                //                                            }
                                                //                                            ?>
                                                <!--                                            <option value="180" --><?php //echo $selected; ?><!--Six Month</option>-->
                                                <!--                                            --><?php
                                                //                                            if ($timezone == "365") {
                                                //                                                $selected = "selected";
                                                //                                            } else {
                                                //                                                $selected = "";
                                                //                                            }
                                                //                                            ?>
                                                <!--                                            <option value="365" --><?php //echo $selected; ?><!--One Year</option>-->
                                                <!--                                        </select>-->
                                                <!--                                    </div>-->
                                            </div>
                                        </div>
                                        <div class="row">
                                         <div class="col-md-6 date">
<!--                                            <label class="control-label" style="float: left;padding-top: 10px; font-weight: 500;">Date Range : &nbsp;&nbsp;</label>-->
<!--                                            --><?php
//                                            if ($button != "button2") {
//                                                $checked = "checked";
//                                            } else {
//                                                $checked == "";
//                                            }
//                                            ?>
                                            <input type="radio" name="button" id="button1" class="form-control" value="button1" style="float: left;width: initial;display:none;" checked>
                                            <label class="control-label" style="float: left;padding-top: 10px; font-weight: 500;">&nbsp;&nbsp;&nbsp;&nbsp;Date From : &nbsp;&nbsp;</label>
                                            <input type="date" name="date_from" id="date_from" class="form-control" value="<?php echo $datefrom; ?>" style="float: left;width: initial;" required>
                                         </div>
                                            <div class="col-md-6 date">
                                            <label class="control-label" style="float: left;padding-top: 10px; font-weight: 500;">&nbsp;&nbsp;&nbsp;&nbsp;Date To: &nbsp;&nbsp;</label>
                                            <input type="date" name="date_to" id="date_to" class="form-control" value="<?php echo $dateto; ?>" style="float: left;width: initial;" required>
                                        </div>
                                        </div>
                                        <br>


                                
                                <?php
                                if (!empty($import_status_message)) {
                                    echo '<div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
                                }
                                ?>
                                <?php
                                if (!empty($_SESSION['import_status_message'])) {
                                    echo '<div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
                                    $_SESSION['message_stauts_class'] = '';
                                    $_SESSION['import_status_message'] = '';
                                }
                                ?>

                            <div class="panel-footer p_footer">
                            <div class="row">
                        
                                    <div class="col-md-2">
                                        <button type="submit"  class="btn btn-primary" style="background-color:#1e73be;">Search</button>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="clear" class="btn btn-primary" style="background-color:#1e73be;" onclick='window.location.reload();'>Reset</button>
                                    </div>
                                    </form>

                                <div class="col-md-2">
                                    <form action="export_task_log.php" method="post" name="export_excel">
                                        <button type="submit" class="btn btn-primary" style="background-color:#1e73be;" id="export" name="export" data-loading-text="Loading...">Export Data</button>
                                    </form>
                                </div>

                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="panel panel-flat">					
                            <table class="table datatable-basic">
                                <thead>
                                    <tr>
                                        <th>Taskboard</th>
                                        <th>Assign To</th>
                                        <th>Equipment</th>
                                        <th>Property</th>
                                        <th>Building</th>
                                        <th>Estimated Duration</th>
                                        <th>Task Assign Time</th>
                                        <th>Task Completion Time</th>
                                        <th>Total Duration</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $qur = mysqli_query($db, "SELECT `taskboard`,`assign_to`,`equipment`,`property`,`building`,`duration`,`assigned_time`,`finished_time`,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(`finished_time` ,`assigned_time`))) as total_time FROM `tm_task` WHERE DATE_FORMAT(`assigned_time`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`assigned_time`,'%Y-%m-%d') <= '$dateto' ");
                                    if (count($_GET) > 0) {
                                        $task = $_GET['taskboard'];
                                        $qur = mysqli_query($db, "SELECT `taskboard`,`assign_to`,`equipment`,`property`,`building`,`duration`,`assigned_time`,`finished_time`,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(`finished_time` ,`assigned_time`))) as total_time FROM `tm_task` WHERE DATE_FORMAT(`assign_time`,'%Y-%m-%d') >= '$curdate' and DATE_FORMAT(`assign_time`,'%Y-%m-%d') <= '$curdate' and `station_id` = '$ln'");
                                    }
                                    if (count($_POST) > 0) {
                                        $taskboard = $_POST['taskboard'];
                                        $user = $_POST['user'];
                                        $dateto = $_POST['date_to'];
                                        $datefrom = $_POST['date_from'];
                                        $button = $_POST['button'];
                                        $timezone = $_POST['timezone'];
                                        if ($button == "button1") {
                                            if ($taskboard != "" && $user != "" && $datefrom != "" && $dateto != "") {
                                                $qur = mysqli_query($db, "SELECT `taskboard`,`assign_to`,`equipment`,`property`,`building`,`duration`,`assigned_time`,`finished_time`,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(`finished_time` ,`assigned_time`))) as total_time FROM `tm_task` WHERE DATE_FORMAT(`assigned_time`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`assigned_time`,'%Y-%m-%d') <= '$dateto' and `taskboard` = '$taskboard' and `assign_to` = '$user'");
                                            } else if ($taskboard != "" && $user != "" && $datefrom == "" && $dateto == "") {
                                                $qur = mysqli_query($db, "SELECT `taskboard`,`assign_to`,`equipment`,`property`,`building`,`duration`,`assigned_time`,`finished_time`,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(`finished_time` ,`assigned_time`))) as total_time FROM `tm_task` WHERE  `taskboard` = '$taskboard' and `assign_to` = '$user'");
                                            } else if ($taskboard != "" && $user == "" && $datefrom != "" && $dateto != "") {
                                                $qur = mysqli_query($db, "SELECT `taskboard`,`assign_to`,`equipment`,`property`,`building`,`duration`,`assigned_time`,`finished_time`,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(`finished_time` ,`assigned_time`))) as total_time FROM `tm_task` WHERE DATE_FORMAT(`assigned_time`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`assigned_time`,'%Y-%m-%d') <= '$dateto' and `taskboard` = '$taskboard' ");
                                            } else if ($taskboard != "" && $user == "" && $datefrom == "" && $dateto == "") {
                                                $qur = mysqli_query($db, "SELECT `taskboard`,`assign_to`,`equipment`,`property`,`building`,`duration`,`assigned_time`,`finished_time`,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(`finished_time` ,`assigned_time`))) as total_time FROM `tm_task` WHERE `taskboard` = '$taskboard'");
                                            } else if ($taskboard == "" && $user != "" && $datefrom != "" && $dateto != "") {
                                                $qur = mysqli_query($db, "SELECT `taskboard`,`assign_to`,`equipment`,`property`,`building`,`duration`,`assigned_time`,`finished_time`,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(`finished_time` ,`assigned_time`))) as total_time FROM `tm_task` WHERE DATE_FORMAT(`assigned_time`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`assigned_time`,'%Y-%m-%d') <= '$dateto' and `assign_to` = '$user'");
                                            } else if ($taskboard == "" && $user != "" && $datefrom == "" && $dateto == "") {
                                                $qur = mysqli_query($db, "SELECT `taskboard`,`assign_to`,`equipment`,`property`,`building`,`duration`,`assigned_time`,`finished_time`,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(`finished_time` ,`assigned_time`))) as total_time FROM `tm_task` WHERE  `assign_to` = '$user'");
                                            } else if ($taskboard == "" && $user == "" && $datefrom != "" && $dateto != "") {
                                                $qur = mysqli_query($db, "SELECT `taskboard`,`assign_to`,`equipment`,`property`,`building`,`duration`,`assigned_time`,`finished_time`,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(`finished_time` ,`assigned_time`))) as total_time FROM `tm_task` WHERE DATE_FORMAT(`assigned_time`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`assigned_time`,'%Y-%m-%d') <= '$dateto' ");
                                            }
                                        }
//$message = "Date :- ".$name;
//echo "<script type='text/javascript'>alert('$message');</script>";
//$qur =  mysqli_query($db,"SELECT * FROM `assign_crew_log` WHERE DATE_FORMAT(`assign_time`,'%Y-%m-%d') = '$date' and `user` = '$name'");
                                    }
                                    while ($rowc = mysqli_fetch_array($qur)) {
                                        $dateTime = $rowc["assign_time"];
                                        $dateTime2 = $rowc["unassign_time"];
//$nt = TIMEDIFF($dateTime, $dateTime2);
                                        ?> 
                                        <tr>
                                            <?php
                                            $un = $rowc['taskboard'];
                                            $qur04 = mysqli_query($db, "SELECT taskboard_name FROM  sg_taskboard where sg_taskboard_id = '$un' ");
                                            while ($rowc04 = mysqli_fetch_array($qur04)) {
                                                $lnn = $rowc04["taskboard_name"];
                                            }
                                            ?>
                                            <td><?php echo $lnn; ?></td>
											<?php
                                            $un = $rowc['assign_to'];
                                            $qur04 = mysqli_query($db, "SELECT * FROM  cam_users where users_id = '$un' ");
                                            while ($rowc04 = mysqli_fetch_array($qur04)) {
                                                $first = $rowc04["firstname"];
                                                $last = $rowc04["lastname"];
                                            }
                                            ?>
                                            <td><?php echo $first; ?>&nbsp;<?php echo $last; ?></td>
                                            
                                            <?php
                                            $un = $rowc['equipment'];
                                            $qur04 = mysqli_query($db, "SELECT tm_equipment_name FROM  tm_equipment where tm_equipment_id = '$un' ");
                                            while ($rowc04 = mysqli_fetch_array($qur04)) {
                                                $pnn = $rowc04["tm_equipment_name"];
                                            }
                                            ?>
                                            <td><?php echo $pnn; ?></td>
                                            
											<?php
                                            $un = $rowc['property'];
                                            $qur04 = mysqli_query($db, "SELECT tm_property_name FROM  tm_property where tm_property_id = '$un' ");
                                            while ($rowc04 = mysqli_fetch_array($qur04)) {
                                                $pnn = $rowc04["tm_property_name"];
                                            }
                                            ?>
                                            <td><?php echo $pnn; ?></td>
                                            
											<?php
                                            $un = $rowc['building'];
                                            $qur04 = mysqli_query($db, "SELECT tm_building_name FROM  tm_building where tm_building_id = '$un' ");
                                            while ($rowc04 = mysqli_fetch_array($qur04)) {
                                                $pnn = $rowc04["tm_building_name"];
                                            }
                                            ?>
                                            <td><?php echo $pnn; ?></td>
                                            <td><?php echo $rowc['duration']; ?></td>
                                            
										    <td><?php echo dateReadFormat($rowc['assigned_time']); ?></td>
                                            <td><?php echo dateReadFormat($rowc['finished_time']); ?></td>
                                            <td><?php echo $rowc['total_time']; ?></td>
                                        	
											</tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /basic datatable -->
                        <!-- /main charts -->
                        <!-- edit modal -->
                        <!-- Dashboard content -->
                        <!-- /dashboard content -->

                    </div>
                    <!-- /content area -->
                    
                </div>
                <!-- /main content -->
        <script>

            $('#taskboard').on('change', function (e) {
                $("#user_form").submit();
            });
            $(function () {
                $('input:radio').change(function () {
                    var abc = $(this).val()
                    //  alert(abc);
                    if (abc == "button1")
                    {
                        $('#date_from').prop('disabled', false);
                        $('#date_to').prop('disabled', false);
                        $('#timezone').prop('disabled', true);
                    } else if (abc == "button2")
                    {
                        $('#date_from').prop('disabled', true);
                        $('#date_to').prop('disabled', true);
                        $('#timezone').prop('disabled', false);
                    }
                });
            });
        </script>

        <script type="text/javascript">
            $(function () {
                $("#btn").bind("click", function () {
                    $("#taskboard")[0].selectedIndex = 0;
                    $("#user")[0].selectedIndex = 0;

                });
            });
        </script>

        <!-- /page container -->
        <?php include('../footer.php') ?>
        <script type="text/javascript" src="../assets/js/core/app.js"></script>
    </body>
</html>
