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

$_SESSION['usr'] = "";
$_SESSION['station'] = "";
//$_SESSION['date_from'] = "";
//$_SESSION['date_to'] = "";
$_SESSION['button'] = "";
$_SESSION['timezone'] = "";
if (count($_POST) > 0) {
    $_SESSION['usr'] = $_POST['usr'];
    $_SESSION['station'] = $_POST['station'];
    $_SESSION['date_from'] = $_POST['date_from'];
    $_SESSION['date_to'] = $_POST['date_to'];
    $_SESSION['button'] = $_POST['button'];
    $_SESSION['timezone'] = $_POST['timezone'];
    $name = $_POST['usr'];
    $station = $_POST['station'];
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
        <title><?php echo $sitename; ?> | Assign Crew Log</title>
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
        
        <script>
            window.onload = function() {
                history.replaceState("", "", "<?php echo $scriptName; ?>log_module/assign_crew_log.php");
         // $('#timezone').prop('disabled', true);	 
                        
            }
        </script>
        

    </head>
    <style>
        .p_footer {
            padding-top: 7px;
            padding-bottom: 5px;
            padding-left: 15px;
            background: #f7f7f7;
            margin-top: 22px;
        }
        .col-md-4 {
            width: 25%;
            margin-left: -10px;
            margin-top: 18px;
        }
        .col-md-6.date {
            width: 15%;
        }
        .col-md-2 {
            width: 8.666667%;
        }
        .col-lg-2 {
            max-width: 30%!important;
            float: left;
        }
        .col-md-6.date {
            margin-top: 20px;
            width: 25%;
        }
        @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {

            .col-md-8 {
                width: 100%;
                float: right;
                margin-top: 18px;
            }
            .col-md-2 {
                width: 30%;
                float: left;
            }
            .col-md-4 {
                width: 80%;
                float: left;
            }
            .col-lg-8 {
                float: right;
                width: 70%;
            }
            .col-md-6.date {
                width: 100%;
                float: left;
            }

        }
    </style>
    <body>
        <!-- Main navbar -->
        <?php
        $cust_cam_page_header = "Assigned Crew Log";
        include("../header.php");

        include("../admin_menu.php");
        include("../heading_banner.php");

        ?>
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

                                            <label class="col-lg-3 control-label">User :</label>
                                                <div class="col-lg-8">
                                            <select  name="usr" id="usr" class="select"  style="float: left;width: initial;" >
                                                <option value="" selected disabled>--- Select User ---</option>
                                                <?php
                                                $sql1 = "SELECT DISTINCT `user_id` FROM `cam_assign_crew_log` order by user_id ";
                                                $result1 = $mysqli->query($sql1);
                                                //$entry = 'selected';
                                                while ($row1 = $result1->fetch_assoc()) {
                                                    $lin = $row1['user_id'];
                                                    $qur05 = mysqli_query($db, "SELECT * FROM  cam_users where users_id = '$lin' ");
                                                    while ($rowc05 = mysqli_fetch_array($qur05)) {
                                                        $first1 = $rowc05["firstname"];
                                                        $last1 = $rowc05["lastname"];
                                                    }
                                                    $fulllname = $first1 . " " . $last1;
                                                    if ($lin == $name) {
                                                        $entry = 'selected';
                                                    } else {
                                                        $entry = '';
                                                    }
                                                    echo "<option value='" . $row1['user_id'] . "' $entry >$fulllname</option>";
                                                }
                                                ?>
                                            </select>
                                                </div>

                                        </div>

                                    <div class="col-md-6 mobile">
                                            <label class="col-lg-3 control-label">Station : &nbsp;&nbsp;</label>

                                    <div class="col-lg-8">
                                            <select  name="station" id="station" class="select" style="float: left;width: initial;" >
                                                <option value="" selected disabled>--- Select Station ---</option>
                                                <?php
                                                $sql1 = "SELECT DISTINCT `station_id` FROM `cam_assign_crew_log`";
                                                $result1 = $mysqli->query($sql1);
                                                //$entry = 'selected';
                                                while ($row1 = $result1->fetch_assoc()) {
                                                    $lin = $row1['station_id'];
                                                    if ($lin == $station) {
                                                        $entry = 'selected';
                                                    } else {
                                                        $entry = '';
                                                    }
                                                    $qur05 = mysqli_query($db, "SELECT * FROM  cam_line where line_id = '$lin' and is_deleted != 1 ");
                                                    while ($rowc05 = mysqli_fetch_array($qur05)) {
                                                        $lnnm = $rowc05["line_name"];
                                                    }
                                                    echo "<option value='" . $row1['station_id'] . "' $entry >" . $lnnm . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
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
                                    <br>

<!--                                            <label class="control-label" style="float: left;padding-top: 10px; font-weight: 500;">Date Range : &nbsp;&nbsp;</label>-->
                                    <div class="row">
                                        <div class="col-md-6 date">

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
                                            <button type="submit" class="btn btn-primary" style="background-color:#1e73be;">Search</button>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-primary" onclick='window.location.reload();' style="background-color:#1e73be;">Reset</button>
                                        </div>
                                </form>
                                        <div class="col-md-2">
                                            <form action="export_crew_log.php" method="post" name="export_excel">
                                                <button type="submit" class="btn btn-primary" style="background-color:#1e73be;" id="export" name="export"   data-loading-text="Loading...">Export Data</button>
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
                                        <th>S.No</th>
                                        <th>User</th>
                                        <th>Station</th>
                                        <th>Position</th>
                                        <th>Assign Time</th>
                                        <th>Unassign Time</th>
                                        <th>Total Assign Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $qur = mysqli_query($db, "SELECT `user_id`,`station_id`,`position_id`,`assign_time`,`unassign_time`,`total_time`  as time FROM `cam_assign_crew_log` WHERE DATE_FORMAT(`assign_time`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`assign_time`,'%Y-%m-%d') <= '$dateto' ");
                                    if (count($_GET) > 0) {
                                        $ln = $_GET['line'];
                                        $qur = mysqli_query($db, "SELECT `user_id`,`station_id`,`position_id`,`assign_time`,`unassign_time`,`total_time`  as time FROM `cam_assign_crew_log` WHERE DATE_FORMAT(`assign_time`,'%Y-%m-%d') >= '$curdate' and DATE_FORMAT(`assign_time`,'%Y-%m-%d') <= '$curdate' and `station_id` = '$ln'");
                                    }
                                    if (count($_POST) > 0) {
                                        $name = $_POST['usr'];
                                        $station = $_POST['station'];
                                        $dateto = $_POST['date_to'];
                                        $datefrom = $_POST['date_from'];
                                        $button = $_POST['button'];
                                        $timezone = $_POST['timezone'];
									//	$button = "button1";
                                        if ($button == "button1") {
                                            if ($name != "" && $station != "" && $datefrom != "" && $dateto != "") {
                                                $qur = mysqli_query($db, "SELECT `user_id`,`station_id`,`position_id`,`assign_time`,`unassign_time`,`total_time`  as time FROM `cam_assign_crew_log` WHERE DATE_FORMAT(`assign_time`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`assign_time`,'%Y-%m-%d') <= '$dateto' and `user_id` = '$name' and `station_id` = '$station'");
                                            } else if ($name != "" && $station != "" && $datefrom == "" && $dateto == "") {
                                                $qur = mysqli_query($db, "SELECT `user_id`,`station_id`,`position_id`,`assign_time`,`unassign_time`,`total_time`  as time FROM `cam_assign_crew_log` WHERE  `station_id` = '$station' and `user_id` = '$name'");
                                            } else if ($name != "" && $station == "" && $datefrom != "" && $dateto != "") {
                                                $qur = mysqli_query($db, "SELECT `user_id`,`station_id`,`position_id`,`assign_time`,`unassign_time`,`total_time`  as time FROM `cam_assign_crew_log` WHERE DATE_FORMAT(`assign_time`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`assign_time`,'%Y-%m-%d') <= '$dateto' and `user_id` = '$name' ");
                                            } else if ($name != "" && $station == "" && $datefrom == "" && $dateto == "") {
                                                $qur = mysqli_query($db, "SELECT `user_id`,`station_id`,`position_id`,`assign_time`,`unassign_time`,`total_time`  as time FROM `cam_assign_crew_log` WHERE `user_id` = '$name'");
                                            } else if ($name == "" && $station != "" && $datefrom != "" && $dateto != "") {
                                                $qur = mysqli_query($db, "SELECT `user_id`,`station_id`,`position_id`,`assign_time`,`unassign_time`,`total_time`  as time FROM `cam_assign_crew_log` WHERE DATE_FORMAT(`assign_time`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`assign_time`,'%Y-%m-%d') <= '$dateto' and `station_id` = '$station'");
                                            } else if ($name == "" && $station != "" && $datefrom == "" && $dateto == "") {
                                                $qur = mysqli_query($db, "SELECT `user_id`,`station_id`,`position_id`,`assign_time`,`unassign_time`,`total_time`  as time FROM `cam_assign_crew_log` WHERE  `station_id` = '$station'");
                                            } else if ($name == "" && $station == "" && $datefrom != "" && $dateto != "") {
                                                $qur = mysqli_query($db, "SELECT `user_id`,`station_id`,`position_id`,`assign_time`,`unassign_time`,`total_time`  as time FROM `cam_assign_crew_log` WHERE DATE_FORMAT(`assign_time`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`assign_time`,'%Y-%m-%d') <= '$dateto' ");
                                            }
                                        } else {
                                            $curdate = date('Y-m-d');
                                            if ($timezone == "7") {
                                                $countdate = date('Y-m-d', strtotime('-7 days'));
                                            } else if ($timezone == "1") {
                                                $countdate = date('Y-m-d', strtotime('-1 days'));
                                            } else if ($timezone == "30") {
                                                $countdate = date('Y-m-d', strtotime('-30 days'));
                                            } else if ($timezone == "90") {
                                                $countdate = date('Y-m-d', strtotime('-90 days'));
                                            } else if ($timezone == "180") {
                                                $countdate = date('Y-m-d', strtotime('-180 days'));
                                            } else if ($timezone == "365") {
                                                $countdate = date('Y-m-d', strtotime('-365 days'));
                                            }
                                            if ($name != "" && $station != "" && $timezone != "") {
                                                $qur = mysqli_query($db, "SELECT `user_id`,`station_id`,`position_id`,`assign_time`,`unassign_time`,`total_time`  as time FROM `cam_assign_crew_log` WHERE DATE_FORMAT(`assign_time`,'%Y-%m-%d') >= '$countdate' and DATE_FORMAT(`assign_time`,'%Y-%m-%d') <= '$curdate' and `user_id` = '$name' and `station_id` = '$station'");
                                            } else if ($name != "" && $station != "" && $timezone == "") {
                                                $qur = mysqli_query($db, "SELECT `user_id`,`station_id`,`position_id`,`assign_time`,`unassign_time`,`total_time`  as time FROM `cam_assign_crew_log` WHERE  `user` = '$name' and `station` = '$station'");
                                            } else if ($name == "" && $station != "" && $timezone != "") {
                                                $qur = mysqli_query($db, "SELECT `user_id`,`station_id`,`position_id`,`assign_time`,`unassign_time`,`total_time`  as time FROM `cam_assign_crew_log` WHERE DATE_FORMAT(`assign_time`,'%Y-%m-%d') >= '$countdate' and DATE_FORMAT(`assign_time`,'%Y-%m-%d') <= '$curdate' and `station_id` = '$station'");
                                            } else if ($name == "" && $station != "" && $timezone == "") {
                                                $qur = mysqli_query($db, "SELECT `user_id`,`station_id`,`position_id`,`assign_time`,`unassign_time`,`total_time`  as time FROM `cam_assign_crew_log` WHERE  `station_id` = '$station'");
                                            } else if ($name != "" && $station == "" && $timezone != "") {
                                                $qur = mysqli_query($db, "SELECT `user_id`,`station_id`,`position_id`,`assign_time`,`unassign_time`,`total_time`  as time FROM `cam_assign_crew_log` WHERE DATE_FORMAT(`assign_time`,'%Y-%m-%d') >= '$countdate' and DATE_FORMAT(`assign_time`,'%Y-%m-%d') <= '$curdate' and `user_id` = '$name' ");
                                            } else if ($name != "" && $station == "" && $timezone == "") {
                                                $qur = mysqli_query($db, "SELECT `user_id`,`station_id`,`position_id`,`assign_time`,`unassign_time`,`total_time`  as time FROM `cam_assign_crew_log` WHERE `user_id` = '$name' ");
                                            } else if ($name == "" && $station == "" && $timezone != "") {
                                                $qur = mysqli_query($db, "SELECT `user_id`,`station_id`,`position_id`,`assign_time`,`unassign_time`,`total_time`  as time FROM `cam_assign_crew_log` WHERE DATE_FORMAT(`assign_time`,'%Y-%m-%d') >= '$countdate' and DATE_FORMAT(`assign_time`,'%Y-%m-%d') <= '$curdate' ");
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
                                            <td><?php echo ++$counter; ?></td>
                                            <?php
                                            $un = $rowc['user_id'];
                                            $qur04 = mysqli_query($db, "SELECT * FROM  cam_users where users_id = '$un' ");
                                            while ($rowc04 = mysqli_fetch_array($qur04)) {
                                                $first = $rowc04["firstname"];
                                                $last = $rowc04["lastname"];
                                            }
                                            ?>
                                            <td><?php echo $first; ?>&nbsp;<?php echo $last; ?></td>
                                            <?php
                                            $un = $rowc['station_id'];
                                            $qur04 = mysqli_query($db, "SELECT * FROM  cam_line where line_id = '$un' ");
                                            while ($rowc04 = mysqli_fetch_array($qur04)) {
                                                $lnn = $rowc04["line_name"];
                                            }
                                            ?>
                                            <td><?php echo $lnn; ?></td>
                                            <?php
                                            $un = $rowc['position_id'];
                                            $qur04 = mysqli_query($db, "SELECT * FROM  cam_position where position_id = '$un' ");
                                            while ($rowc04 = mysqli_fetch_array($qur04)) {
                                                $pnn = $rowc04["position_name"];
                                            }
                                            ?>
                                            <td><?php echo $pnn; ?></td>
                                            <td><?php echo dateReadFormat($rowc["assign_time"]); ?></td>
                                            <?php
                                            $unas = $rowc["unassign_time"];
                                            $as = $rowc["assign_time"];
                                            if ($unas == $as) {
                                                $unasign = "Still Assigned";
                                            } else {
                                                $unasign = $unas;
                                            }
                                            ?>
                                            <td><?php echo dateReadFormat($unasign); ?></td>
                                            <?php
                                            $zero_time = '00:00:00';
                                            $database_time = $rowc["time"];
                                            if ($zero_time == $database_time) {
                                                $database_time = "Still Assigned";
                                            }
                                            ?> 
                                            <td><?php echo $database_time; ?></td>
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
        <script>
            $(function () {
                $('input:radio').change(function () {
                    var abc = $(this).val()
                    //alert(abc)
                    if (abc == "button1")
                    {
                        $('#date_from').prop('disabled', false);
                        $('#date_to').prop('disabled', false);
                        $('#timezone').prop('disabled', true);
                    }
                });
            });
        </script>
        <script>

            // $('#usr').on('change', function (e) {
            //     $("#user_form").submit();
            // });
            // $('#station').on('change', function (e) {
            //     $("#user_form").submit();
            // });
        </script>
        <script>
            $(document).on("click","#submit_btn",function() {

                var station = $("#station").val();
                var usr = $("#usr").val();

                $("#user_form").submit();


            });

        </script>
        <script>
            $(function(){
                var dtToday = new Date();

                var month = dtToday.getMonth() + 1;
                var day = dtToday.getDate();
                var year = dtToday.getFullYear();
                if(month < 10)
                    month = '0' + month.toString();
                if(day < 10)
                    day = '0' + day.toString();

                var maxDate = year + '-' + month + '-' + day;

                $('#date_to').attr('max', maxDate);
                $('#date_from').attr('max', maxDate);
            });
        </script>

        <!-- /page container -->
        <?php include('../footer.php') ?>

    </body>
</html>
