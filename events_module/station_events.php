<?php
include("../config.php");
$chicagotime = date("Y-m-d H:i:s");
$temp = "";
if (!isset($_SESSION['user'])) {
	if($_SESSION['is_tab_user'] || $_SESSION['is_cell_login']){
		header($redirect_tab_logout_path);
	}else{
		header($redirect_logout_path);
	}
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
	if($_SESSION['is_tab_user'] || $_SESSION['is_cell_login']){
		header($redirect_tab_logout_path);
	}else{
		header($redirect_logout_path);
	}

//	header('location: ../logout.php');
	exit;
}
//Set the time of the user's last activity
$_SESSION['LAST_ACTIVITY'] = $time;
$is_tab_login = $_SESSION['is_tab_user'];
$is_cell_login = $_SESSION['is_cell_login'];
$i = $_SESSION["role_id"];
$station_id = null;
$event_line = $_GET['line'];
$user_id = $_SESSION["id"];
$chicagotime = date("Y-m-d H:i:s");
if (count($_POST) > 0) {

	$station_id = $_POST['station'];
	if(($station_id == null || $station_id =='') && (($event_line != null) && ($event_line != ''))){
	    $station_id = $event_line;
    }
	$part_family_id = $_POST['part_family'];
	$part_number = $_POST['part_number'];
	$event_type_id = $_POST['event_type_id'];
	$e_event_id = $_POST['edit_event_type'];
	$edit_event_id = explode("_",$e_event_id)[0];
	$station_event_id = $_POST['station_event_id'];
	$event_seq = $_POST['event_seq'];
	$event_total_time = $_POST['total_time'];
    $create_time = date("H:i");
	// Edit Event
	if ($edit_event_id != "") {
	    $reason =  $_POST['edit_reason'];
		$station_event_id = $_POST['edit_id'];

		/*Update the log table with the event value*/
		$sql = "select * from event_type where so = (select (MAX(so)) as max_seq_num from event_type)";
		$res = mysqli_query($db, $sql);
		$firstrow = mysqli_fetch_array($res);
		$max_seq = $firstrow['so'];
		$fr_event_type_id = $firstrow['event_type_id'];
		$event_status_lat = 1;

		$qur1 = "select (count(station_event_id)) as seq_num from sg_station_event_log WHERE station_event_id='$station_event_id'";
		$res = mysqli_query($db, $qur1);
		$firstrow = mysqli_fetch_array($res);
		$curr_seq = $firstrow['seq_num'];
		$next_seq = $curr_seq + 1;

		$qur2="Select SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF('$chicagotime', created_on))) as completed_time from `sg_station_event_log` WHERE station_event_id = '$station_event_id' and event_seq = '$curr_seq'";
		$res = mysqli_query($db, $qur2);
		$firstrow = mysqli_fetch_array($res);
		$total_time = $firstrow['completed_time'];

        $qur2_time ="Select (TIMEDIFF('$chicagotime', created_on)) as completed_time from `sg_station_event_log_time` WHERE station_event_id = '$station_event_id' and event_seq = '$curr_seq'";
        $res_time = mysqli_query($db, $qur2_time);
        $firstrow_time = mysqli_fetch_array($res_time);
        $total_time1 = $firstrow_time['completed_time'];

		$qur22="Select event_cat_id as cat_id from `event_type` WHERE event_type_id = '$edit_event_id'";
		$res = mysqli_query($db, $qur22);
		$firstrow = mysqli_fetch_array($res);
		$event_cat_id = $firstrow['cat_id'];

		$qur3 = "update `sg_station_event_log` set total_time = '$total_time' where station_event_id = '$station_event_id' and event_seq = '$curr_seq'";
		$result0 = mysqli_query($db, $qur3);

        $qur3_time = "update `sg_station_event_log_time` set total_time = '$total_time1',end_event_status_time = '$chicagotime',event_time_status = '1' where station_event_id = '$station_event_id' and event_seq = '$curr_seq'";
        $result0_time = mysqli_query($db, $qur3_time);


		if ($edit_event_id == $fr_event_type_id) {
			$sql = "INSERT INTO `sg_station_event_log`(`station_event_id`  ,`reason`,`event_seq`, `event_type_id`,`event_cat_id`, `event_status` , `created_on` ,`created_by`) VALUES ('$station_event_id','$reason','$next_seq','$edit_event_id','$event_cat_id',0,'$chicagotime','$user_id')";
			$event_status_lat = 0;
		} else {
			$sql = "INSERT INTO `sg_station_event_log`(`station_event_id` ,`reason`,`event_seq` , `event_type_id`,`event_cat_id`, `event_status` , `created_on` ,`created_by`) VALUES ('$station_event_id','$reason','$next_seq','$edit_event_id','$event_cat_id',1,'$chicagotime','$user_id')";

		}
		$result0 = mysqli_query($db, $sql);
		if ($event_status_lat == 1) {
			$sql = "update sg_station_event set event_type_id='$edit_event_id', reason='$reason' ,modified_on='$chicagotime', modified_by='$user_id' where  station_event_id = '$station_event_id'";
			$result1 = mysqli_query($db, $sql);
			if ($result1) {
				$message_stauts_class = 'alert-success';
				$import_status_message = 'Event status Updated successfully.';
			} else {
				$message_stauts_class = 'alert-danger';
				$import_status_message = 'Error: Please Insert valid data';
			}
		} else {
			$sql = "update sg_station_event set event_status = '$event_status_lat' ,event_type_id='$edit_event_id', modified_on='$chicagotime', modified_by='$user_id' where  station_event_id = '$station_event_id'";
			$result1 = mysqli_query($db, $sql);
			if ($result1) {
				$message_stauts_class = 'alert-success';
				$import_status_message = 'Event Cycle Completed for the Station.';
			} else {
				$message_stauts_class = 'alert-danger';
				$import_status_message = 'Error: Please Insert valid data';
			}
		}

	} else {
		if (($part_number != "") && ($station_id != "") && ($part_family_id != "") && ($event_type_id != "")) {

//production cycle is already active code
			$sql_production = "select * from sg_station_event where line_id = '$station_id'  and event_status = '1'";
			$res_production = mysqli_query($db, $sql_production);
			$firstrow_production = mysqli_fetch_array($res_production);
//		$condition = $firstrow_production['station_event_id'];
			if ($firstrow_production) {
				$message_stauts_class = 'alert-danger';
				$import_status_message = 'Error: This Station already has an active event.';
			} else {
				$sql0 = "INSERT INTO `sg_station_event`(`line_id` , `part_family_id`, `part_number_id` , `event_type_id` ,`created_on`,`created_by`,`modified_on`,`modified_by`) VALUES ('$station_id','$part_family_id','$part_number','$event_type_id','$chicagotime','$user_id','$chicagotime','$user_id')";
				$result0 = mysqli_query($db, $sql0);
				$station_event_id = ($db->insert_id);

				if ($result0) {
					$qur1 = "select (count(station_event_id)) as seq_num from sg_station_event_log WHERE station_event_id='$station_event_id'";
					$res = mysqli_query($db, $qur1);
					$firstrow = mysqli_fetch_array($res);
					$curr_seq = $firstrow['seq_num'];
					$next_seq = $curr_seq + 1;

					$qq = "SELECT max(station_event_log_id) as prev_log_id , sl.created_on as prev_st_time FROM `sg_station_event_log` as sl inner join sg_station_event as se on sl.station_event_id = se.station_event_id where se.line_id = '$station_id' and sl.event_status = 0 group by sl.created_on order by sl.created_on desc LIMIT 1";
					$res = mysqli_query($db, $qq);
					$firstrow = mysqli_fetch_array($res);
					$prev_seq = $firstrow['prev_log_id'];
					$prev_time = $firstrow['prev_st_time'];

                    $qq_time = "SELECT max(station_time_log_id) as prev_id , sl.created_on as st_time FROM `sg_station_event_log_time` as sl inner join sg_station_event as se on sl.station_event_id = se.station_event_id where se.line_id = '$station_id' and sl.event_status = 0 group by sl.created_on order by sl.created_on desc LIMIT 1";
                    $res_time = mysqli_query($db, $qq_time);
                    $firstrow_time = mysqli_fetch_array($res_time);
                    $prev_seq_time = $firstrow_time['prev_id'];
                    $prev_time1 = $firstrow_time['st_time'];

					$qur22="Select event_cat_id as cat_id from `event_type` WHERE event_type_id = '$event_type_id'";
					$res = mysqli_query($db, $qur22);
					$firstrow = mysqli_fetch_array($res);
					$event_cat_id = $firstrow['cat_id'];

					$qur2="Select SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF('$chicagotime', '$prev_time'))) as completed_time";
					$res = mysqli_query($db, $qur2);
					$firstrow = mysqli_fetch_array($res);
					$total_time = $firstrow['completed_time'];

                    $qur2_time="Select SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF('$chicagotime', '$prev_time1'))) as completed_time";
                    $res_time = mysqli_query($db, $qur2_time);
                    $firstrow_time = mysqli_fetch_array($res_time);
                    $total_time1 = $firstrow_time['completed_time'];

					$qur4 = "update`sg_station_event_log` set total_time = '$total_time' where station_event_log_id = '$prev_seq'";
					$result0 = mysqli_query($db, $qur4);

                    $qur4_time = "update`sg_station_event_log_time` set total_time = '$total_time1' where station_event_log_id = '$prev_seq_time'";
                    $result0_time = mysqli_query($db, $qur4_time);

					$sql0 = "INSERT INTO `sg_station_event_log`(`station_event_id` ,`event_seq`, `event_type_id`,`event_cat_id`, `event_status` , `created_on` ,`created_by`) VALUES ('$station_event_id','$next_seq','$event_type_id','$event_cat_id',1,'$chicagotime','$user_id')";
					$result0 = mysqli_query($db, $sql0);

                    $sql0_time = "INSERT INTO `sg_station_event_log_time`(`station_event_id` ,`event_seq`, `event_type_id`,`event_cat_id`, `event_status` , `created_on` ,`time(hrs)` ,`created_by`) VALUES ('$station_event_id','$next_seq','$event_type_id','$event_cat_id',1,'$chicagotime','$create_time','$user_id')";
                    $result0_time = mysqli_query($db, $sql0_time);

                    $station_event = "select * from sg_station_event_log_time where event_time_status = '1'";
                    $sta_event = mysqli_query($db,$station_event);
                    $event_time = mysqli_fetch_array($sta_event);
                    $event_status_time = $event_time['event_time_status'];
                    $station_event_id = $event_time['station_event_id'];

                    $sql_event_time = "INSERT INTO `sg_station_event_log`(`station_event_id` ,`event_seq`, `event_type_id`,`event_cat_id`, `event_status` , `created_on` ,`end_time` ,`created_by`) VALUES ('$station_event_id','$next_seq','$event_type_id','$event_cat_id',1,'00:00:00','11:59:59','$user_id') where station_event_id = '$station_event_id' ";
                    $result_event_time = mysqli_query($db, $sql_event_time);

					$message_stauts_class = 'alert-success';
					$import_status_message = 'Station Event Created successfully.';
				    } else {
					$message_stauts_class = 'alert-danger';
					$import_status_message = 'Error: Please Insert valid data';
				}
			}
		}
	}
}else{
	$station_id = $event_line;
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?>
        | Station Events</title>
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
          type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/colors.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/style_main.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
    <!-- Core JS files -->

    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/libs/jquery-3.6.0.min.js"> </script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->
    <!-- Theme JS files -->
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/components_modals.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/form_bootstrap_select.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/form_layouts.js"></script>
    <style>

        .sidebar-default .navigation li > a {
            color: #f5f5f5;
        }

        .sidebar-default .navigation li > a:focus, .sidebar-default .navigation li > a:hover {
            background-color: #20a9cc;
        }

	.red {
    color: red;
    display: none;
    }
        label.col-lg-4.control-label {
            color: #333;
        }

        @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
            .col-lg-8 {
                float: right;
                width: 60% !important;
            }

            label.col-lg-3.control-label {
                width: 40%;
            }
            label.col-lg-4.control-label {
                width: 40%;
            }
        }
		</style>
</head>

<!-- Main navbar -->
<?php
$cust_cam_page_header = "Station Events";
include("../header_folder.php");

if (($is_tab_login || $is_cell_login)) {
	include("../tab_menu.php");
} else {
	include("../admin_menu.php");
}
include("../heading_banner.php");
?>
<body class="alt-menu sidebar-noneoverflow">
<div class="page-container">
            <!-- Content area -->
            <div class="content">
                <!-- Basic datatable -->
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <!--							<hr/>-->
                        <form action="" id="station_event_form" class="form-horizontal" method="post">
                            <div class="row">
                                <!--Station-->
                                <div class="col-md-6 mobile">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Station * : </label>
                                        <div class="col-lg-8">
                                            <select name="station" id="station" class="select form-control" data-style="bg-slate">
                                                <option value="" selected disabled>--- Select Station ---</option>
												<?php
												if($is_tab_login){
													$station_id=$tab_line;
													$sql1 = "SELECT line_id,line_name FROM `cam_line`  where enabled = '1' and line_id = '$tab_line' ORDER BY `line_name` ASC";
													$result1 = $mysqli->query($sql1);
													//                                            $entry = 'selected';
													while ($row1 = $result1->fetch_assoc()) {
														$entry = 'selected';
														echo "<option value='" . $row1['line_id'] . "'  $entry>" . $row1['line_name'] . "</option>";
													}
												}else if($is_cell_login){
												    if(empty($_REQUEST)){
														$c_stations = implode("', '", $c_login_stations_arr);
														$sql1 = "SELECT line_id,line_name FROM `cam_line`  where enabled = '1' and line_id IN ('$c_stations') ORDER BY `line_name` ASC";
														$result1 = $mysqli->query($sql1);
//													                $                        $entry = 'selected';
														$i = 0;
														while ($row1 = $result1->fetch_assoc()) {
//														$entry = 'selected';
															if($i == 0 ){
																$entry = 'selected';
																$station = $row1['line_id'];
																echo "<option value='" . $station . "'  $entry>" . $row1['line_name'] . "</option>";

															}else{
																echo "<option value='" . $row1['line_id'] . "'  >" . $row1['line_name'] . "</option>";

															}
															$i++;
														}
                                                    }else{
												        $line_id = $_REQUEST['line'];
												        if(empty($line_id)){
															$line_id = $_REQUEST['station'];
                                                        }
														$sql1 = "SELECT line_id,line_name FROM `cam_line`  where enabled = '1' and line_id ='$line_id'";
														$result1 = $mysqli->query($sql1);
//
														while ($row1 = $result1->fetch_assoc()) {
//
                                                            $entry = 'selected';
                                                            $station = $row1['line_id'];
                                                            echo "<option value='" . $station . "'  $entry>" . $row1['line_name'] . "</option>";

														}
                                                    }

												}else{
													$station = $station_id;
													$sql1 = "SELECT * FROM `cam_line` where enabled = '1' ORDER BY `line_name` ASC";
													$result1 = $mysqli->query($sql1);
													while ($row1 = $result1->fetch_assoc()) {
														$lid = $row1['line_id'];
														if ($station == $lid) {
															$station = $lid;
															$entry = 'selected';
														} else {
															$entry = '';

														}
														echo "<option value='" . $row1['line_id'] . "' $entry >" . $row1['line_name'] . "</option>";
													}
												}

												?>
                                            </select>
                                           <!-- <div id="error1" class="red">Please Select Station</div> -->
                                        </div>
                                    </div>
                                </div>
                                <!--Part Family-->
                                <div class="col-md-6 mobile">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Part Family  : </label>
                                        <div class="col-lg-8">
                                            <select name="part_family" id="part_family" class="select form-control"
                                                    data-style="bg-slate">
                                                <option value="" selected disabled>--- Select Part Family ---</option>
												<?php
                                                if(empty($station)){
													$station = $station_id;
                                                }
												$part_family = $_POST['part_family'];
                                                if(empty($part_family) && !empty($_REQUEST['part_family'])){
													$part_family = $_REQUEST['part_family'];
                                                }
												$sql1 = "SELECT * FROM `pm_part_family` where is_deleted = 0 and station = '$station' ORDER BY `part_family_name` ASC";
												$result1 = $mysqli->query($sql1);
												//                                            $entry = 'selected';
												while ($row1 = $result1->fetch_assoc()) {
													if ($part_family == $row1['pm_part_family_id']) {
														$entry = 'selected';
													} else {
														$entry = '';

													}
													echo "<option value='" . $row1['pm_part_family_id'] . "'  $entry>" . $row1['part_family_name'] . "</option>";
												}
												?>
                                            </select>
                                            <!-- <div id="error2" class="red">Please Select Part Family</div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!--Part Number-->
                                <div class="col-md-6 mobile">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Part Number  : </label>
                                        <div class="col-lg-8">
                                            <select name="part_number" id="part_number" class="select form-control"
                                                    data-style="bg-slate">
                                                <option value="" selected disabled>--- Select Part Number ---</option>
												<?php
												$part_number = $_POST['part_number'];
												if(empty($part_number) && !empty($_REQUEST['part_number'])){
													$part_number = $_REQUEST['part_number'];
												}
												$sql1 = "SELECT * FROM `pm_part_number` where part_family = '$part_family' and is_deleted = 0  ORDER BY `part_name` ASC";
												$result1 = $mysqli->query($sql1);
												//                                            $entry = 'selected';
												while ($row1 = $result1->fetch_assoc()) {
													if ($part_number == $row1['pm_part_number_id']) {
														$entry = 'selected';
													} else {
														$entry = '';

													}
													echo "<option value='" . $row1['pm_part_number_id'] . "' $entry >" . $row1['part_number'] . " - " . $row1['part_name'] . "</option>";
												}
												?>
                                            </select>
                                            <!--                                            <input type="text" name="part_number" id="part_number" class="form-control"-->
                                            <!--                                                   placeholder="Enter Part Number" required>-->
                                           <!-- <div id="error3" class="red">Please Select Part Number</div> -->
                                        </div>
                                    </div>
                                </div>
                                <!--Event Type-->
                                <div class="col-md-6 mobile">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Event Type  : </label>
                                        <div class="col-lg-8">
                                            <select name="event_type_id" id="event_type_id" class="select form-control"
                                                    data-style="bg-slate">
                                                <option value="" selected disabled>--- Select Event Type ---</option>
												<?php
												$event_type_id = $_POST['event_type_id'];

												//$sql1 = "SELECT * FROM `event_type` ORDER BY `event_type_name` ASC";
//												$sql1 = "SELECT event_type_id , FIND_IN_SET('$station', stations) AS result from `event_type` ORDER BY so ASC";
												$sql1 = "SELECT event_type_id ,event_type_name, FIND_IN_SET('$station', stations) from `event_type` where FIND_IN_SET('$station', stations) IS NOT NULL and FIND_IN_SET('$station', stations) > 0 ORDER BY so ASC";
												$result1 = $mysqli->query($sql1);
												if ($result1 != null) {
													$count = $result1->num_rows;
													//                                            $entry = 'selected';
													while ($row1 = $result1->fetch_assoc()) {
														if ($event_type_id == $row1['event_type_id']) {
															$entry = 'selected';
														} else {
															$entry = '';

														}
														if ($count == 1) {
															echo "<option disabled value='" . $row1['event_type_id'] . "' $entry >" . $row1['event_type_name'] . "</option>";
														} else {
															echo "<option value='" . $row1['event_type_id'] . "' $entry >" . $row1['event_type_name'] . "</option>";

														}
														$count = $count - 1;
													}
												}

												?>
                                            </select>
                                           <!-- <div id="error4" class="red">Please Select Event Type</div> -->
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        <br/>
                        <br/>
						<?php
						if (!empty($import_status_message)) {
							echo '<div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
						}
						?>
						<?php
						if (!empty($_SESSION[$import_status_message])) {
							echo '<div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
							$_SESSION['message_stauts_class'] = '';
							$_SESSION['import_status_message'] = '';
						}
						?>

                            <div class="panel-footer p_footer">
                                <button type="submit" class="btn btn-primary submit_btn" style="background-color:#1e73be;">Create
                                    Station Event
                                </button>&nbsp;&nbsp;&nbsp;&nbsp;
                                <button type="clear" id="btn" class="btn btn-primary"
                                        style="background-color:#1e73be;margin-right: 20px;width:120px;">Reset
                                </button>
                            </div>
                        </form>
                    </div>

                    </div>


                <form action="" id="update-form" method="post" class="form-horizontal">
                    <br/>
                    <!-- Main charts -->
                    <!-- Basic datatable -->
                    <div class="panel panel-flat">
                        <table class="table datatable-basic">
                            <thead>
                            <tr>
                                <!--                                <th>-->
                                <!--                                    <input type="checkbox" id="checkAll">-->
                                <!--                                </th>-->
                                <th>S.No</th>
                                <th>Actions</th>
                                <th>Station</th>
                                <th>Part Family</th>
                                <th>Part Number</th>
                                <th>Event Type</th>

                            </tr>
                            </thead>
                            <tbody>
							<?php
							$query = sprintf("SELECT * FROM  sg_station_event  where event_status = 1 and line_id = '$station' order by modified_on DESC ;  ");
							$qur = mysqli_query($db, $query);
							while ($rowc = mysqli_fetch_array($qur)) {

								$station_event_id = $rowc['station_event_id'];
								$station_id = $rowc['line_id'];
								$qurtemp = mysqli_query($db, "SELECT * FROM  cam_line where line_id  = '$station_id' ");
								while ($rowctemp = mysqli_fetch_array($qurtemp)) {
									$station_name = $rowctemp["line_name"];
								}
								$part_family_id = $rowc['part_family_id'];
								$qurtemp = mysqli_query($db, "SELECT * FROM  pm_part_family where pm_part_family_id  = '$part_family_id' ");
								while ($rowctemp = mysqli_fetch_array($qurtemp)) {
									$part_family_name = $rowctemp["part_family_name"];
								}
								$part_number_id = $rowc['part_number_id'];
								$qurtemp = mysqli_query($db, "SELECT * FROM  pm_part_number where pm_part_number_id  = '$part_number_id' ");
								while ($rowctemp = mysqli_fetch_array($qurtemp)) {
									$part_number = $rowctemp["part_number"];
								}
								$event_type_id = $rowc['event_type_id'];
								$qurtemp = mysqli_query($db, "SELECT * FROM  event_type where event_type_id  = '$event_type_id' ");
								while ($rowctemp = mysqli_fetch_array($qurtemp)) {
									$event_type_name = $rowctemp["event_type_name"];
									$event_cat_id = $rowctemp["event_cat_id"];
								}
								?>
                                <tr>
                                    <td><?php echo ++$counter; ?>
                                        <!--                                        <input type="text" id="station_event_id" hidden name="station_event_id" value="-->
										<?php //echo $rowc['station_event_id']; ?><!--">-->
                                    </td>
                                    <td>
                                        <button type="button" id="edit" class="btn btn-info btn-xs"
                                                data-id="<?php echo $station_event_id ?>"
                                                data-station="<?php echo $station_id ?>"
                                                data-part_family="<?php echo $part_family_id ?>"
                                                data-part_number="<?php echo $part_number_id ?>"
                                                data-event_type_id="<?php echo $event_type_id ."_".$event_cat_id ?>"
                                                data-reason=""
                                                data-toggle="modal" style="background-color:#1e73be;"
                                                data-target="#edit_modal_theme_primary">Update
                                        </button>
                                        <!--&nbsp;	<button type="button" id="delete" class="btn btn-danger btn-xs" data-id="<?php echo $rowc['users_id']; ?>">Delete </button>
                                                    -->
                                    </td>

                                    <td><?php echo $station_name; ?></td>

                                    <td><?php echo $part_family_name; ?></td>

                                    <td><?php echo $part_number; ?></td>

                                    <td><?php echo $event_type_name; ?></td>
                                </tr>
							<?php } ?>
                            </tbody>
                        </table>
                </form>

            <!-- /basic datatable -->
            <!-- /main charts -->
            <!-- edit modal -->

            <div id="edit_modal_theme_primary" class="modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title">
                                Update Event Status
                            </h6>
                        </div>
                        <form action="" id="edit_station_event_form" enctype="multipart/form-data" class="form-horizontal"
                              method="post">
                            <div class="modal-body" style="color: #fff">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label">Station * : </label>
                                            <div class="col-lg-8">
                                                <select name="edit_station" id="edit_station"
                                                        class="form-control f_disabled">
                                                    <option value="" selected disabled>--- Select Station ---</option>
													<?php
													$sql1 = "SELECT * FROM `cam_line` ORDER BY `line_name` ASC ";
													$result1 = $mysqli->query($sql1);
													while ($row1 = $result1->fetch_assoc()) {
														echo "<option value='" . $row1['line_id'] . "'  >" . $row1['line_name'] . "</option>";
													}
													?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label">Part Family * :</label>
                                            <div class="col-lg-8">
                                                <select name="edit_part_family" id="edit_part_family"
                                                        class="form-control f_disabled">
                                                    <option value="" selected disabled>--- Select Part Family ---
                                                    </option>
													<?php
													$sql1 = "SELECT * FROM `pm_part_family` ORDER BY `part_family_name` ASC ";
													$result1 = $mysqli->query($sql1);
													//                                            $entry = 'selected';
													while ($row1 = $result1->fetch_assoc()) {
														echo "<option value='" . $row1['pm_part_family_id'] . "'  >" . $row1['part_family_name'] . "</option>";
													}
													?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label">Part Number  :</label>
                                            <div class="col-lg-8">
                                                <select name="edit_part_number" id="edit_part_number"
                                                        class="form-control f_disabled">
                                                    <option value="" selected disabled>--- Select Part Number ---
                                                    </option>
													<?php
													$sql1 = "SELECT * FROM `pm_part_number` ORDER BY `part_number` ASC ";
													$result1 = $mysqli->query($sql1);
													while ($row1 = $result1->fetch_assoc()) {
														echo "<option value='" . $row1['pm_part_number_id'] . "'  >" . $row1['part_number'] . "</option>";
													}
													?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label">Event Type * :</label>
                                            <div class="col-lg-8">
                                                <select name="edit_event_type" id="edit_event_type"
                                                        class="form-control">
                                                    <!-- <option value="" disabled>--- Select Event Type ----->
                                                    <!-- </option>-->
													<?php
													$sql1 = "SELECT event_type_id ,event_cat_id,event_type_name, FIND_IN_SET('$station_id', stations) from `event_type` where FIND_IN_SET('$station_id', stations) IS NOT NULL and FIND_IN_SET('$station_id', stations) > 0 ORDER BY so ASC";
													$result1 = $mysqli->query($sql1);
													while ($row1 = $result1->fetch_assoc()) {
														echo "<option value='" . $row1['event_type_id'] ."_".$row1['event_cat_id']. "'  >" . $row1['event_type_name'] . "</option>";
                                                       
													}
													?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                         
                                <div class="row" id="reason_div">
                                </div>

                           
                                <input type="hidden" name="edit_id" id="edit_id">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                                <button type="submit" id="edit_save" class="btn btn-primary ">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Dashboard content -->
            </div>
            <!-- /dashboard content -->
</div>
            <script>

                $("#edit_save").click(function (e) {
                    if ($("#edit_station_event_form")[0].checkValidity()){

                    }
                // e.preventDefault();
                });
                $(document).on('click', '#delete', function () {
                    var element = $(this);
                    var del_id = element.attr("data-id");
                    var info = 'id=' + del_id;
                    $.ajax({
                        type: "POST", url: "ajax_delete.php", data: info, success: function (data) {
                        }
                    });
                    $(this).parents("tr").animate({backgroundColor: "#003"}, "slow").animate({opacity: "hide"}, "slow");
                });
            </script>
            <script>
                jQuery(document).ready(function ($) {
                    $(document).on('click', '#edit', function () {
                        var element = $(this);
                        var edit_id = $(this).data("id");
                        var station = $(this).data("station");
                        var part_family = $(this).data("part_family");
                        var part_number = $(this).data("part_number");
                        var event_type = $(this).data("event_type_id");
                        var reason = $(this).data("reason");
                        $("#edit_station").val(station);
                        $("#edit_part_family").val(part_family);
                        $("#edit_part_number").val(part_number);
                        $("#edit_event_type").val(event_type);
                        $("#edit_id").val(edit_id);
                        $("#edit_reason").val(reason);
                    });
                });
            </script>
            <script>
$('#edit_event_type').on('change', function () {
    
        var selected_val = this.value.split("_")[1];
        if (selected_val == 3) {
            document.getElementById("reason_div").innerHTML +="<div class=\"col-md-12\">\n" +
                "                                        <div class=\"form-group\">\n" +
                "                                            <label class=\"col-lg-4 control-label\">Reason * :</label>\n" +
                "                                            <div class=\"col-lg-8\">\n" +
                "                                                <textarea id=\"edit_reason\" name=\"edit_reason\" rows=\"2\" class=\"form-control\" required></textarea>\n" +
                "                                            </div>\n" +
                "                                        </div>\n" +
                "                                    </div>";
                // $('#reason_div').attr('required', true);
            // $('#reason_div').prop('required',true);
            // document.getElementById("reason_div").required = true;
            // $("#reason_div").show();
        } else {
            document.getElementById("reason_div").innerHTML ="";
            // document.getElementById("reason_div").required = false;
            // $("#reason_div").hide();
        }
    });
</script>
            <script>
    window.onload = function () {
        history.replaceState("", "", "<?php echo $scriptName; ?>events_module/station_events.php");
    }
</script>
            <script>
    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
    $('#generate').click(function () {
        let r = Math.random().toString(36).substring(7);
        $('#newpass').val(r);
    })

    function submitForm(url) {
        $(':input[type="button"]').prop('disabled', true);
        var data = $("#update-form").serialize();
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function (data) {
                // window.location.href = window.location.href + "?aa=Line 1";
                $(':input[type="button"]').prop('disabled', false);
                location.reload();
            }
        });
    }

    function submitForm11(url) {
        $(':input[type="button"]').prop('disabled', true);
        var data = $("#update-form").serialize();
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function (data) {
                // window.location.href = window.location.href + "?aa=Line 1";
                $(':input[type="button"]').prop('disabled', false);
                location.reload();
            }
        });
    }

    function submitForm12(url) {
        $(':input[type="button"]').prop('disabled', true);
        var data = $("#update-form").serialize();
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function (data) {
                // window.location.href = window.location.href + "?aa=Line 1";
                $(':input[type="button"]').prop('disabled', false);
                location.reload();
            }
        });
    }

    $('#choose').on('change', function () {
        var selected_val = this.value;
        if (selected_val == 4 || selected_val == 10) {
            $("#reason_div").show();
        } else {
            $("#reason_div").hide();
        }
    });


    $('#station').on('change', function (e) {
        $("#station_event_form").submit();
    });
    $('#part_family').on('change', function (e) {
        $("#station_event_form").submit();
    });
    $('#part_number').on('change', function (e) {
        $("#station_event_form").submit();
    });
	$(document).on("click",".submit_btn",function() {
var station = $("#station").val();
var part_family = $("#part_family").val();
var part_number = $("#part_number").val();
var event_type_id = $("#event_type_id").val();
// var flag= 0;
// if(station == null){
// 	$("#error1").show();
// 	var flag= 1;
// }
// if(part_family == null){
// 	$("#error2").show();
// 	var flag= 1;
// }
// if(part_number == null){
// 	$("#error3").show();
// 	var flag= 1;
// }
// if(event_type_id == null){
// 	$("#error4").show();
// 	var flag= 1;
// }
// if (flag == 1) {
//        return false;
//        }

    });
</script>
<script type="text/javascript">
    $(function () {
        $("#btn").bind("click", function () {
            $("#station")[0].selectedIndex = 0;
            $("#part_family")[0].selectedIndex = 0;
            $("#part_number")[0].selectedIndex = 0;
            $("#event_type_id")[0].selectedIndex = 0;
        });
    });
</script>
<?php include('../footer.php') ?>
<script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/core/app.js"></script>
</body>
</html>