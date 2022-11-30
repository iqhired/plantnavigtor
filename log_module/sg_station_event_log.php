<?php
include("../config.php");
$button_event = "button3";
$curdate = date('Y-m-d');
//$dateto = $curdate;
//$datefrom = $curdate;
$button = "";
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
$_SESSION['station'] = "";
$_SESSION['date_from'] = "";
$_SESSION['date_to'] = "";
$_SESSION['button'] = "";
$_SESSION['timezone'] = "";
$_SESSION['button_event'] = "";
$_SESSION['event_type'] = "";
$_SESSION['event_category'] = "";

if (count($_POST) > 0) {
	$_SESSION['station'] = $_POST['station'];
	$_SESSION['date_from'] = $_POST['date_from'];
	$_SESSION['date_to'] = $_POST['date_to'];
	$_SESSION['button'] = $_POST['button'];
	$_SESSION['timezone'] = $_POST['timezone'];
	$_SESSION['button_event'] = $_POST['button_event'];
	$_SESSION['event_type'] = $_POST['event_type'];
	$_SESSION['event_category'] = $_POST['event_category'];
	$button_event = $_POST['button_event'];
	$event_type = $_POST['event_type'];
	$event_category = $_POST['event_category'];
	$station = $_POST['station'];
	$dateto = $_POST['date_to'];
	$datefrom = $_POST['date_from'];
	$button = $_POST['button'];
	$timezone = $_POST['timezone'];
}
if (count($_POST) > 0) {
	$station1 = $_POST['station'];
	$qurtemp = mysqli_query($db, "SELECT * FROM  cam_line where line_id = '$station1' ");
	while ($rowctemp = mysqli_fetch_array($qurtemp)) {
		$station1 = $rowctemp["line_name"];
	}
}
if(empty($dateto)){
	$curdate = date('Y-m-d');
	$dateto = $curdate;
}

if(empty($datefrom)){
	$yesdate = date('Y-m-d');
	$datefrom = $curdate;
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $sitename; ?> | Station Events Log</title>
	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
		  type="text/css">
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
		.col-md-2{
			width:auto!important;
			float: left;
		}
		.col-lg-2 {
			max-width: 30%!important;
			float: left;
		}
		.row_date {
			padding-top: 22px;
			margin-left: -9px;
			padding-bottom: 20px;

		}

		@media
		only screen and (max-width: 760px),
		(min-device-width: 768px) and (max-device-width: 1024px) {

			.select2-container{
				width: 100%!important;
			}
			.col-md-8 {
				width: 100%;
			}
			input[type=checkbox], input[type=radio]{
				margin: 4px 19px 0px;
			}
			.col-lg-1 {
				width: 5%;
				float: left;
			}
			.col-lg-7 {
				float: right;
				width: 65%;
			}
		}

	</style>
	<script>
        window.onload = function () {
            history.replaceState("", "", "<?php echo $siteURL; ?>log_module/sg_station_event_log.php");
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

	<!-- event -->
	<?php
	if ($button_event == "button4") {
		?>
		<script>
            $(function () {
                $('#event_type').prop('disabled', true);
                $('#event_category').prop('disabled', false);
            });
		</script>
	<?php
	} else {
	?>
		<script>
            $(function () {
                $('#event_type').prop('disabled', false);
                $('#event_category').prop('disabled', true);
            });
		</script>
		<?php
	}
	?>


</head>

<!-- Main navbar -->
<?php
$cust_cam_page_header = "Station Events Log";
include("../header.php");
include("../admin_menu.php");
include("../heading_banner.php");
?>
<body class="alt-menu sidebar-noneoverflow">
<!-- /main navbar -->
<!-- Page container -->
<div class="page-container">
	<!-- Page content -->

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
							<label class=" col-lg-3 control-label">Event Type :</label>
							<?php
							if ($button_event == "button3") {
								$checked = "checked";
							} else {
								$checked = "";
							}
							?>
							<div class="col-lg-1">
								<input type="radio" name="button_event" id="button3" value="button3"
									   class="form-control"
									   style="float: left;width: initial;" <?php echo $checked; ?>>
							</div>
							<div class="col-lg-7">

								<select name="event_type" id="event_type" class="select form-control"
										style="float: left;width: 60%;">
									<option value="" selected disabled>--- Select Event Type ---</option>
									<?php
									$ev_ty_post = $_POST['event_type'];
									$sql1 = "SELECT * FROM `event_type` where is_deleted != 1 ";
									$result1 = $mysqli->query($sql1);
									//                                            $entry = 'selected';
									while ($row1 = $result1->fetch_assoc()) {
										$lin = $row1['event_type_id'];

										if ($lin == $ev_ty_post) {
											$entry = 'selected';
										} else {
											$entry = '';
										}
										echo "<option value='" . $row1['event_type_id'] . "' $entry >" . $row1['event_type_name'] . "</option>";
									}
									?>
								</select>
							</div>

						</div>
						<div class="col-md-6 mobile">

							<label class="col-lg-3 control-label" >Event Catagory :</label>

							<?php
							if ($button_event == "button4") {
								$checked = "checked";
							} else {
								$checked = "";
							}
							?>
							<div class="col-lg-1">
								<input type="radio" name="button_event" id="button4" value="button4"
									   class="form-control"  style="float: left;width: initial;" <?php echo $checked; ?>>
							</div>
							<div class="col-lg-7">
								<select name="event_category" id="event_category" class="select form-control"
										style="float: left;width: 60%;">
									<option value="" selected disabled>--- Select Event Catagory ---</option>
									<?php
									$ev_cat_post = $_POST['event_category'];
									$sql1 = "SELECT * FROM `events_category` where is_deleted != 1 ";
									$result1 = $mysqli->query($sql1);
									//                                            $entry = 'selected';
									while ($row1 = $result1->fetch_assoc()) {
										$lin = $row1['events_cat_id'];

										if ($lin == $ev_cat_post) {
											$entry = 'selected';
										} else {
											$entry = '';
										}
										echo "<option value='" . $row1['events_cat_id'] . "' $entry >" . $row1['events_cat_name'] . "</option>";
									}
									?>
								</select>
							</div>
						</div>

					</div>
					<br/>
					<div class="row">
						<div class="col-md-6 mobile">
							<label class="col-lg-3 control-label">Station :</label>

							<div class="col-lg-7">
								<select name="station" id="station" class="select form-control"
										style="float: left;width: initial;">
									<option value="" selected disabled>--- Select Station ---</option>
									<?php
									$sql1 = "SELECT * FROM `cam_line` where  enabled = 1 and is_deleted != 1 ORDER BY `cam_line`.`line_id` ASC;";
									$result1 = $mysqli->query($sql1);
									//                                            $entry = 'selected';
									while ($row1 = $result1->fetch_assoc()) {
										$lin = $row1['line_id'];

										if ($lin == $station) {
											$entry = 'selected';
										} else {
											$entry = '';
										}
										echo "<option value='" . $row1['line_id'] . "' $entry >" . $row1['line_name'] . "</option>";
									}
									?>
								</select>
							</div>
						</div>
					</div>
					<div class="row_date">
						<div class="col-md-6 mobile_date">
							<?php
							if ($button != "button2") {
								$checked = "checked";
							} else {
								$checked == "";
							}
							?>

							<label class="col-lg-2 control-label">Date From :</label>
							<input type="date" name="date_from" id="date_from" class="form-control"
								   value="<?php echo $datefrom; ?>" style="float: left;width: initial;"
								   required>
						</div>
						<div class="col-md-6 mobile_date">
							<label class="col-lg-2 control-label" >Date To:</label>
							<input type="date" name="date_to" id="date_to" class="form-control"
								   value="<?php echo $dateto; ?>" style="float: left;width: initial;" required>
						</div>
					</div>
					<br/>
			</div>
			<div class="panel-footer p_footer">
				<div class="row">
					<div class="col-md-2">
						<button type="submit" class="btn btn-primary"
								style="width:120px;margin-right: 20px;background-color:#1e73be;">
							Search
						</button>
					</div>
					<div class="col-md-2">
						<button type="button" class="btn btn-primary" onclick='window.location.reload();'
								style="background-color:#1e73be;margin-right: 20px;width:120px;">Reset
						</button>
					</div>
					</form>
<!--					<div class="col-md-2">-->
<!--						<button type="button" class="btn btn-primary" id="update_btn" style="background-color:#1e73be;margin-right: 20px;width:120px;">Update</button>-->
<!--					</div>-->
					<div class="col-md-2">
						<form action="export_se_log_new.php" method="post" name="export_excel">
							<button type="submit" class="btn btn-primary"
									style="background-color:#1e73be;width:120px;"
									id="export" name="export" data-loading-text="Loading...">Export Data
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>


		<div class="panel panel-flat">
			<table class="table datatable-basic">
				<thead>
				<tr>
					<th>Station</th>
					<th>Event Type</th>
					<th>Part Number</th>
					<th>Part Name</th>
					<th>Part Family</th>
					<th>Start Time</th>
					<th>End Time</th>
					<th>Total Time</th>
				</tr>
				</thead>
				<tbody>
				<?php

				$main_query = "select slogup.line_id , ( select event_type_name from event_type where event_type_id = slogup.event_type_id) as e_type, 
( select events_cat_name from events_category where events_cat_id = slogup.event_cat_id) as cat_name , pn.part_number as p_num, pn.part_name as p_name , 
pf.part_family_name as pf_name,slogup.created_on as start_time , slogup.end_time as end_time ,slogup.total_time as total_time from sg_station_event_log_update as slogup 
inner join sg_station_event as sg_events on slogup.station_event_id = sg_events.station_event_id INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id 
inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id where 1 ";
//where DATE_FORMAT(sg_events.created_on,'%Y-%m-%d') >= '2022-11-03' 
//and DATE_FORMAT(sg_events.created_on,'%Y-%m-%d') <= '2022-11-03' and slogup.line_id = '3' ORDER BY slogup.created_on ASC";
				/* Default Query */
				$q = $main_query . " and DATE_FORMAT(slogup.created_on,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(slogup.created_on,'%Y-%m-%d') <= '$dateto'ORDER BY slogup.created_on  ASC";

				$line = $_POST['station'];

				/* If Line is selected. */
				if ($line != null) {
					$line = $_POST['station'];
					$q = $main_query . "and DATE_FORMAT(slogup.created_on,'%Y-%m-%d') >= '$curdate' and DATE_FORMAT(slogup.created_on,'%Y-%m-%d') <= '$curdate' and slogup.line_id = '$line' ORDER BY slogup.created_on  ASC";
				}

				/* Build the query to fetch the data*/
				if (count($_POST) > 0) {
					$line = $_POST['station'];
					$line_id = $_POST['station'];
					$dateto = $_POST['date_to'];
					$datefrom = $_POST['date_from'];
					$button = $_POST['button'];
					$button_event = $_POST['button_event'];
					$event_type = $_POST['event_type'];
					$event_category = $_POST['event_category'];
					$timezone = $_POST['timezone'];
					//event type
 					$q = $main_query;

					/* If Line is selected. */
					if ($line_id != null) {
						$q = $q . " and slogup.line_id = '$line_id' ";
					}
					if ($datefrom != "" && $dateto != "") {
						$q = $q . " AND DATE_FORMAT(slogup.created_on,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(slogup.created_on,'%Y-%m-%d') <= '$dateto' ";
					} else if ($datefrom != "" && $dateto == "") {
						$q = $q . " AND DATE_FORMAT(slogup.created_on,'%Y-%m-%d') >= '$datefrom' ";
					} else if ($datefrom == "" && $dateto != "") {
						$q = $q . " AND DATE_FORMAT(slogup.created_on,'%Y-%m-%d') <= '$dateto' ";
					}

					if ($event_type != "") {
						$q = $q . " and slogup.event_type_id = '$event_type'";
					}

					if ($event_category != "") {
						$q = $q . " AND  slogup.event_cat_id ='$event_category'";
					}

					$q = $q . " ORDER BY slogup.created_on  ASC";

				}
				/* Execute the Query Built*/
				$qur = mysqli_query($db, $q);
				while ($rowc = mysqli_fetch_array($qur)) {
					?>
					<tr>
						<?php
						$un = $rowc['line_id'];
						$qur04 = mysqli_query($db, "SELECT line_name FROM  cam_line where line_id = '$un' ");
						while ($rowc04 = mysqli_fetch_array($qur04)) {
							$lnn = $rowc04["line_name"];
						}
						?>
						<td><?php echo $lnn; ?></td>
						<td><?php echo $rowc["e_type"]; ?></td>
						<td><?php echo $rowc['p_num']; ?></td>
						<td><?php echo $rowc['p_name']; ?></td>
						<td><?php echo $rowc['pf_name']; ?></td>
						<td><?php echo dateReadFormat($rowc['start_time']); ?></td>
						<td><?php echo dateReadFormat($rowc['end_time']); ?></td>
						<td><?php echo $rowc['total_time']; ?></td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
		<!-- /basic datatable -->
		<!-- /dashboard content -->
		<script>
            $(function () {
                $('input:radio').change(function () {
                    var abc = $(this).val()
                    //  alert(abc);
                    if (abc == "button1") {
                        $('#date_from').prop('disabled', false);
                        $('#date_to').prop('disabled', false);
                        $('#timezone').prop('disabled', true);
                    } else if (abc == "button2") {
                        $('#date_from').prop('disabled', true);
                        $('#date_to').prop('disabled', true);
                        $('#timezone').prop('disabled', false);
                    } else if (abc == "button3") {
                        $('#event_category').prop('disabled', true);
                        $('#event_type').prop('disabled', false);
                    } else if (abc == "button4") {
                        $('#event_type').prop('disabled', true);
                        $('#event_category').prop('disabled', false);
                    }


                });
            });
		</script>
	</div>
	<!-- /content area -->

</div>
<!-- /page container -->
<?php include('../footer.php') ?>
<script>
    $("#update_btn").click(function (e) {
        //          $(':input[type="button"]').prop('disabled', true);
        $.ajax({
            type: 'POST',
            url: 'se_log_schedular.php',
            async: false,
            cache:false,
            success: function (data) {
                event.preventDefault()
                window.scrollTo(0, 300);
            }
        });

        // e.preventDefault();
    });
</script>
</body>
</html>
