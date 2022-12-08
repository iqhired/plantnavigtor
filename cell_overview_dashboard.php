<?php include("config.php");
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
	exit;
}
//Set the time of the user's last activity
$_SESSION['LAST_ACTIVITY'] = $time;
$_SESSION['timestamp_id'] = '';
$_SESSION['f_type'] = '';
$timestamp = date('H:i:s');
$message = date("Y-m-d H:i:s");
$is_cust_dash = $_SESSION['is_cust_dash'];
$line_cust_dash = $_SESSION['line_cust_dash'];
$cellID = $_GET['cell_id'];
$c_name = $_GET['c_name'];
if (isset($cellID)) {
	$sql = "select stations from `cell_grp` where c_id = '$cellID'";
	$result1 = mysqli_query($db, $sql);
	$ass_line_array = array();
	while ($rowc = mysqli_fetch_array($result1)) {
		$arr_stations = explode(',', $rowc['stations']);
		foreach ($arr_stations as $station) {
			if (isset($station) && $station != '') {
				array_push($ass_line_array, $station);
			}
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?> | Dashboard</title>
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
          type="text/css">
    <link href="assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="assets/css/colors.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style_main.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
    <!-- Core JS files -->
    <script type="text/javascript" src="assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="assets/js/core/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/core/libraries/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->
    <!-- Theme JS files -->
    <script type="text/javascript" src="assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="assets/js/core/app.js"></script>
    <script type="text/javascript" src="assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="assets/js/pages/components_modals.js"></script>
    <script type="text/javascript" src="assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="assets/js/time_display.js"></script>
    <!--chart -->
    <style>
        .panel[class*=bg-]>.panel-body {
            background-color: inherit;
            height: 230px!important;
        }
        tbody, td, th, thead, tr {

            font-size: 14px;
        }
        .col-lg-3 {
            font-size: 12px!important;
        }
        .open > .dropdown-menu {
            min-width: 210px !important;
        }

        td {
            width: 50% !important;
        }

        .heading-elements {
            background-color: transparent;
        }

        .line_card {
            background-color: #181d50;
        }

        .bg-blue-400 {
            border: 1px solid white;
            /*background-color: #181d50;*/
        }

        .bg-orange-400 {
            background-color: #dc6805;
        }

        .bg-teal-400 {
            background-color: #218838;
        }

        .bg-pink-400 {
            background-color: #c9302c;
        }

        tr {
            background-color: transparent;
        }

        .dashboard_line_heading {
            color: #181d50;
            padding-top: 5px;
            font-size: 15px !important;
        }


        @media screen and (min-width: 2560px) {
            .dashboard_line_heading {
                font-size: 22px !important;
                padding-top: 5px;
            }
        }

        .thumb img:not(.media-preview) {
            height: 150px !important;
        }
    </style>    <!-- /theme JS files -->
</head>
<body>
<!-- Main navbar -->
<!-- /main navbar -->
<?php
$cust_cam_page_header = $c_name . " - Cell Status Overview";
include("header.php");
include("admin_menu.php");
include("heading_banner.php");
?>
<div class="content">
    <div class="row">
		<?php
		if ($is_cust_dash == 1 && isset($line_cust_dash)){
		$line_cust_dash_arr = explode(',', $line_cust_dash);
		$line_rr = '';
		$i = 0;
		foreach ($line_cust_dash_arr as $line_cust_dash_item) {
			if ($i == 0) {
				$line_rr = "SELECT * FROM  cam_line where enabled = 1 and line_id IN (";
				$i++;
				if (isset($line_cust_dash_item) && $line_cust_dash_item != '') {
					$line_rr .= "'" . $line_cust_dash_item . "'";
				}
			} else {
				if (isset($line_cust_dash_item) && $line_cust_dash_item != '') {
					$line_rr .= ",'" . $line_cust_dash_item . "'";
				}
			}
		}
		$line_rr .= ")";
		$query = $line_rr;
		$qur = mysqli_query($db, $query);
		$countervariable = 0;

		while ($rowc = mysqli_fetch_array($qur)) {
		$event_status = '';
		$line_status_text = '';
		$buttonclass = '#000';
		$p_num = '';
		$p_name = '';
		$pf_name = '';
		$time = '';
		$countervariable++;
		$line = $rowc["line_id"];

		//$qur01 = mysqli_query($db, "SELECT created_on as start_time , modified_on as updated_time FROM  sg_station_event where line_id = '$line' and event_status = 1 order BY created_on DESC LIMIT 1");
		$qur01 = mysqli_query($db, "SELECT pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,pf.pm_part_family_id as pf_no, et.event_type_name as e_name ,et.color_code as color_code , sg_events.modified_on as updated_time ,sg_events.station_event_id as station_event_id , sg_events.event_status as event_status , sg_events.created_on as e_start_time,sg_events.event_type_id as event_type_id FROM sg_station_event as sg_events inner join event_type as et on sg_events.event_type_id=et.event_type_id Inner Join pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on sg_events.part_number_id=pn.pm_part_number_id where sg_events.line_id= '$line' ORDER by sg_events.created_on DESC LIMIT 1");
		$rowc01 = mysqli_fetch_array($qur01);
		if ($rowc01 != null) {
            $event_type_id = $rowc01['event_type_id'];
			$time = $rowc01['updated_time'];
			$station_event_id = $rowc01['station_event_id'];
			$line_status_text = $rowc01['e_name'];
			$event_status = $rowc01['event_status'];
			$p_num = $rowc01["p_num"];
            $p_no = $rowc01["p_no"];;
			$p_name = $rowc01["p_name"];
            $pf_name = $rowc01["pf_name"];
            $pf_no = $rowc01["pf_no"];
//			$buttonclass = "94241c";
			$buttonclass = $rowc01["color_code"];
		} else {

		}


		if ($countervariable % 4 == 0) {
		?>
        <!--								<div class="row">-->
        <div class="col-lg-3">
            <div class="panel bg-blue-400">
                <div class="panel-body">
                    <div class="heading-elements">
                        <ul class="icons-list">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                                            class="icon-cog3"></i> <span class="caret" style="color:white;"></span></a>
                                <ul class="dropdown-menu dropdown-menu-right">
									<?php if ($event_status != '0' && $event_status != '') { ?>
                                        <li>
                                            <a href="events_module/good_bad_piece.php?station_event_id=<?php echo $station_event_id; ?>"
                                               target="_BLANK"></a><i class="fa fa-line-chart"></i> Good & Bad Piece
                                            </a>
                                        </li>
                                        <li>
                                            <a href="material_tracability/material_tracability.php?station=<?php echo $line; ?>&station_event_id=<?php echo $station_event_id; ?>" target="_BLANK">
                                                <i class="fa fa-pencil-square"></i> Material Traceability</a>
                                        </li>
                                        <li>
                                            <a href="material_tracability/material_search.php?station=<?php echo $line; ?>&station_event_id=<?php echo $station_event_id; ?>" target="_BLANK">
                                                <i class="fa fa-pencil-square"></i> View Material Traceability</a>
                                        </li>

                                        <li>
                                            <a href="10x/10x.php?station=<?php echo $line; ?>&station_event_id=<?php echo $station_event_id; ?>&f_type=n" target="_BLANK">
                                                <i class="icon-eye"></i> Submit 10x</a>
                                        </li>
                                        <li>
                                            <a href="10x/10x_search.php?station=<?php echo $line; ?>&station_event_id=<?php echo $station_event_id; ?>" target="_BLANK">
                                                <i class="icon-eye"></i> View 10x </a>
                                        </li>

									<?php } ?>

                                    <li>
                                        <a href="view_station_status.php?station=<?php echo $line; ?>"
                                        <i class="icon-eye"></i>View Station
                                        Status</a></li>
                                    <li>
                                        <a href="events_module/station_events.php?line=<?php echo $line; ?>&part_family=<?php echo $pf_no; ?>&part_number=<?php echo $p_no; ?>"
                                        <i class="icon-sync"></i>Add / Update
                                        Events</a></li>
									<?php if (($_SESSION['role_id'] == 'admin') || ($_SESSION['role_id'] == 'super')) { ?>
                                        <li>
                                            <a href="form_module/form_settings.php?station=<?php echo $line; ?>"
                                            <i class="icon-pie5"></i> Create Form</a>
                                        </li>
									<?php } ?>
                                    <li>
                                        <a href="form_module/options.php?station=<?php echo $line; ?>&part_family=<?php echo $pf_no; ?>&part_number=<?php echo $p_no; ?>">
                                        <i class="icon-pie5"></i> Submit Form</a>
                                    </li>
                                    <!--															--><?php //if(($_SESSION['role_id'] == 'admin') || ($_SESSION['role_id'] == 'super')){?>
                                    <li>
                                        <a href="assignment_module/assign_crew.php?line=<?php echo $line; ?>"
                                        <i class="icon-sync"></i>Assign / Unassign Crew</a>
                                    </li>
                                    <!--															--><?php //} ?>
                                    <li>
                                        <a href="view_assigned_crew.php?station=<?php echo $line; ?>"
                                        <i class="icon-eye"></i> View Assigned Crew</a>
                                    </li>
                                    <li>
                                        <a href="document_module/view_document.php?station=<?php echo $line; ?>&part=<?php echo $p_no; ?>" target="_BLANK">
                                            <i class="fa fa-file"></i> View Document </a>
                                    </li>
                                    <li>
                                        <a href="report_config_module/scan_line_asset.php" target="_BLANK">
                                            <i class="fa fa-file"></i> Submit Station Assets </a>
                                    </li>

                                    <?php if($event_type_id == 7) { ?>
                                        <li>
                                            <a href="view_form_status.php?station=<?php echo $line; ?>" target="_BLANK">
                                                <i class="icon-pie5"></i> Form Submit Dashboard</a>
                                        </li>
                                    <?php }  else { ?>
                                        <?php if (($_SESSION['role_id'] == 'admin') || ($_SESSION['role_id'] == 'super')) { ?>
                                            <li>
                                                <a href="config_module/line_wise_form_submit_dashboard.php?id=<?php echo $line; ?>" target="_BLANK">
                                                    <i class="icon-pie5"></i> Form Submit Dashboard</a>
                                            </li>
                                        <?php } }?>
                                </ul>

                            </li>
                        </ul>
                    </div>
                    <h3 class="no-margin dashboard_line_heading"><?php echo $rowc["line_name"]; ?></h3>
                    <hr/>

                    <table style="width:100%" id="t01">
                        <tr>
                            <td>
                                <div style="padding-top: 5px;font-size: initial; wi">Part Family :
                                </div>
                            </td>
                            <td>
                                <div><?php echo $pf_name;
									$pf_name = ''; ?> </div>
                                <input type="hidden" id="id<?php echo $countervariable; ?>"
                                       value="<?php echo $time; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="padding-top: 5px;font-size: initial;">Part Number :
                                </div>
                            </td>
                            <td><span><?php echo $p_num;
									$p_num = ''; ?></span></td>
                        </tr>
                        <!--                                        <tr>-->
                        <!--                                            <td><div style="padding-top: 5px;font-size: initial;">Event Type :  </div></td>-->
                        <!--                                            <td><span>-->
						<?php //echo $last_assignedby;	$last_assignedby = "";
						?><!--</span></span></td>-->
                        <!--                                        </tr>-->
                        <tr>
                            <td>
                                <div style="padding-top: 5px;font-size: initial;">Part Name :</div>
                            </td>
                            <td><span><?php echo $p_name;
									$p_name = ''; ?></span></td>
                        </tr>
                    </table>
                </div>
                <!--                                <h4 style="text-align: center;background-color:#<?php echo $buttonclass; ?>;"><div id="txt" >&nbsp; </div></h4>
                                        -->
				<?php
				$variable123 = $time;
				if ($variable123 != "") {
                    //include the timing configuration file
                    include("timings_config.php");
					?>

				<?php } ?>
                <div style="height: 100%;">
                    <h4 style="height:inherit;text-align: center;background-color:<?php echo $buttonclass; ?>;color: #fff;">
                        <div style="padding: 10px 0px 5px 0px;"><?php echo $line_status_text; ?> -
                            <span style="padding: 0px 0px 10px 0px;"
                                  id="demo<?php echo $countervariable; ?>">&nbsp;</span><span
                                    id="server-load"></span></div>
                        <!--                                        <div style="padding: 0px 0px 10px 0px;" id="demo-->
						<?php //echo $countervariable;
						?><!--" >&nbsp;</div>-->
                    </h4>
                </div>
            </div>
        </div>
    </div><?php
	} else {
		?>
        <div class="col-lg-3">
        <div class="panel bg-blue-400">
            <div class="panel-body">
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cog3"></i> <span
                                        class="caret"
                                        style="color:white;"></span></a>
                            <ul class="dropdown-menu dropdown-menu-right">
								<?php if ($event_status != '0' && $event_status != '') { ?>
                                    <li>
                                        <a href="events_module/good_bad_piece.php?station_event_id=<?php echo $station_event_id; ?>"
                                           target="_BLANK"><i class="fa fa-line-chart"></i>Good & Bad Piece
                                        </a>
                                    </li>
                                    <li>
                                        <a href="material_tracability/material_tracability.php?station=<?php echo $line; ?>&station_event_id=<?php echo $station_event_id; ?>" target="_BLANK">
                                            <i class="fa fa-pencil-square"></i> Material Traceability</a>
                                    </li>
                                    <li>
                                        <a href="material_tracability/material_search.php?station=<?php echo $line; ?>&station_event_id=<?php echo $station_event_id; ?>" target="_BLANK">
                                            <i class="fa fa-pencil-square"></i> View Material Traceability</a>
                                    </li>
                                    <li>
                                        <a href="10x/10x.php?station=<?php echo $line; ?>&station_event_id=<?php echo $station_event_id; ?>&f_type=n" target="_BLANK">
                                            <i class="icon-eye"></i> Submit 10x</a>
                                    </li>
                                    <li>
                                        <a href="10x/10x_search.php?station=<?php echo $line; ?>&station_event_id=<?php echo $station_event_id; ?>" target="_BLANK">
                                            <i class="icon-eye"></i> View 10x </a>
                                    </li>

								<?php } ?>

                                <li>
                                    <a href="view_station_status.php?station=<?php echo $rowc["line_id"]; ?>"><i
                                                class="icon-eye"></i>View Station Status</a>
                                </li>
                                <li>
                                    <a href="events_module/station_events.php?line=<?php echo $rowc["line_id"]; ?>&part_family=<?php echo $pf_no; ?>&part_number=<?php echo $p_no; ?>"><i
                                                class="icon-sync"></i>Add / Update
                                        Events</a></li>
								<?php if (($_SESSION['role_id'] == 'admin') || ($_SESSION['role_id'] == 'super')) { ?>
                                    <li>
                                        <a href="form_module/form_settings.php?station=<?php echo $rowc["line_id"]; ?>"><i
                                                    class="icon-pie5"></i> Create Form</a>
                                    </li>
								<?php } ?>
                                <li>
                                    <a href="form_module/options.php?station=<?php echo $rowc["line_id"]; ?>&part_family=<?php echo $pf_no; ?>&part_number=<?php echo $p_no; ?>"><i
                                                class="icon-pie5"></i> Submit Form</a>
                                </li>
                                <li>
                                    <a href="form_module/form_search.php?station=<?php echo $rowc["line_id"]; ?>"><i
                                                class="icon-eye"></i>View Form</a>
                                </li>
                                <!--														--><?php //if(($_SESSION['role_id'] == 'admin') || ($_SESSION['role_id'] == 'super')){?>
                                <li>
                                    <a href="assignment_module/assign_crew.php?line=<?php echo $rowc["line_id"]; ?>"><i
                                                class="icon-sync"></i>Assign / Unassign Crew</a>
                                </li>
                                <!--														--><?php //} ?>
                                <li>
                                    <a href="view_assigned_crew.php?station=<?php echo $rowc["line_id"]; ?>"><i
                                                class="icon-eye"></i> View Assigned Crew</a>
                                </li>
                                <li>
                                    <a href="document_module/view_document.php?station=<?php echo $line; ?>&part=<?php echo $p_no; ?>" target="_BLANK">
                                        <i class="fa fa-file"></i> View Document </a>
                                </li>
                                <li>
                                    <a href="report_config_module/scan_line_asset.php" target="_BLANK">
                                        <i class="fa fa-file"></i> Submit Station Assets </a>
                                </li>
                                <?php if($event_type_id == 7) { ?>
                                    <li>
                                        <a href="view_form_status.php?station=<?php echo $line; ?>" target="_BLANK">
                                            <i class="icon-pie5"></i> Form Submit Dashboard</a>
                                    </li>
                                <?php }  else { ?>
                                    <?php if (($_SESSION['role_id'] == 'admin') || ($_SESSION['role_id'] == 'super')) { ?>
                                        <li>
                                            <a href="config_module/line_wise_form_submit_dashboard.php?id=<?php echo $line; ?>" target="_BLANK">
                                                <i class="icon-pie5"></i> Form Submit Dashboard</a>
                                        </li>
                                    <?php } }?>
                            </ul>

                        </li>
                    </ul>
                </div>
                <h3 class="no-margin dashboard_line_heading"><?php echo $rowc["line_name"]; ?></h3>
                <hr/>

                <table style="width:100%" id="t01">
                    <tr>
                        <td>
                            <div style="padding-top: 5px;font-size: initial; wi">Part Family :</div>
                        </td>
                        <td>
                            <div><?php echo $pf_name;
								$pf_name = ''; ?> </div>
                            <input type="hidden" id="id<?php echo $countervariable; ?>"
                                   value="<?php echo $time; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div style="padding-top: 5px;font-size: initial;">Part Number :</div>
                        </td>
                        <td><span><?php echo $p_num;
								$p_num = ''; ?></span></td>
                    </tr>
                    <!--                                        <tr>-->
                    <!--                                            <td><div style="padding-top: 5px;font-size: initial;">Event Type :  </div></td>-->
                    <!--                                            <td><span>-->
					<?php //echo $last_assignedby;	$last_assignedby = "";
					?><!--</span></span></td>-->
                    <!--                                        </tr>-->
                    <tr>
                        <td>
                            <div style="padding-top: 5px;font-size: initial;">Part Name :</div>
                        </td>
                        <td><span><?php echo $p_name;
								$p_name = ''; ?></span></td>
                    </tr>
                </table>


            </div>
            <!--                                <h4 style="text-align: center;background-color:#<?php echo $buttonclass; ?>;"><div id="txt" >&nbsp; </div></h4>
                                        -->
			<?php
			$variable123 = $time;
			if ($variable123 != "") {
                //include the timing configuration file
                include("timings_config.php");
				?>

			<?php } ?>
            <div style="height: 100%">
                <h4 style="height:inherit;text-align: center;background-color:<?php echo $buttonclass; ?>;">
                    <div style="padding: 10px 0px 5px 0px;"><?php echo $line_status_text; ?> - <span
                                style="padding: 0px 0px 10px 0px;"
                                id="demo<?php echo $countervariable; ?>">&nbsp;</span><span
                                id="server-load"></span></div>
                    <!--                                        <div style="padding: 0px 0px 10px 0px;" id="demo-->
					<?php //echo $countervariable;
					?><!--" >&nbsp;</div>-->
                </h4>
            </div>


        </div>
        </div><?php
	}
	}
	} else {
		$countervariable = 0;
		asort($ass_line_array);
		foreach ($ass_line_array as $line) {
			$query = sprintf("SELECT line_name FROM  cam_line where line_id = '$line'");
			$qur = mysqli_query($db, $query);
			$rowc = mysqli_fetch_array($qur);
			$event_status = '';
			$line_status_text = '';
			$buttonclass = '#000';
			$p_num = '';
			$p_name = '';
			$pf_name = '';
			$time = '';
			$countervariable++;
			$qur01 = mysqli_query($db, "SELECT pn.part_number as p_num, pn.pm_part_number_id as p_no, pn.part_name as p_name , pf.part_family_name as pf_name,pf.pm_part_family_id as pf_no, et.event_type_name as e_name ,et.color_code as color_code , sg_events.modified_on as updated_time ,sg_events.station_event_id as station_event_id , sg_events.event_status as event_status , sg_events.created_on as e_start_time,sg_events.event_type_id as event_type_id FROM sg_station_event as sg_events inner join event_type as et on sg_events.event_type_id=et.event_type_id Inner Join pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on sg_events.part_number_id=pn.pm_part_number_id where sg_events.line_id= '$line' ORDER by sg_events.created_on DESC LIMIT 1");
			$rowc01 = mysqli_fetch_array($qur01);
			if ($rowc01 != null) {
                $event_type_id = $rowc01['event_type_id'];
				$time = $rowc01['updated_time'];
				$station_event_id = $rowc01['station_event_id'];
				$line_status_text = $rowc01['e_name'];
				$event_status = $rowc01['event_status'];
				$p_num = $rowc01["p_num"];;
                $p_no = $rowc01["p_no"];;
				$p_name = $rowc01["p_name"];;
				$pf_name = $rowc01["pf_name"];
                $pf_no = $rowc01["pf_no"];
				$buttonclass = $rowc01["color_code"];
			} else {

			}

			if ($countervariable % 4 == 0) {
				?>


                <!--								<div class="row">-->
                <div class="col-lg-3">
                    <div class="panel bg-blue-400">
                        <div class="panel-body">
                            <div class="heading-elements">
                                <ul class="icons-list">
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                                                    class="icon-cog3"></i> <span class="caret"
                                                                                 style="color:white;"></span></a>
                                        <ul class="dropdown-menu dropdown-menu-right">
											<?php if ($event_status != '0' && $event_status != '') { ?>
                                                <li>
                                                    <a href="events_module/good_bad_piece.php?station_event_id=<?php echo $station_event_id; ?>"
                                                       target="_BLANK"><i class="fa fa-line-chart"></i>Good & Bad Piece
                                                    </a></li>
                                                <li>
                                                    <a href="material_tracability/material_tracability.php?station=<?php echo $line; ?>&station_event_id=<?php echo $station_event_id; ?>" target="_BLANK">
                                                        <i class="fa fa-pencil-square"></i> Material Traceability</a>
                                                </li>
                                                <li>
                                                    <a href="material_tracability/material_search.php?station=<?php echo $line; ?>&station_event_id=<?php echo $station_event_id; ?>" target="_BLANK">
                                                        <i class="fa fa-pencil-square"></i> View Material Traceability</a>
                                                </li>
                                                <li>
                                                    <a href="10x/10x.php?station=<?php echo $line; ?>&station_event_id=<?php echo $station_event_id; ?>&f_type=n" target="_BLANK">
                                                        <i class="icon-eye"></i> Submit 10x</a>
                                                </li>
                                                <li>
                                                    <a href="10x/10x_search.php?station=<?php echo $line; ?>&station_event_id=<?php echo $station_event_id; ?>" target="_BLANK">
                                                        <i class="icon-eye"></i> View 10x </a>
                                                </li>

											<?php } ?>
                                            <li>

                                                <a href="view_station_status.php?station=<?php echo $line; ?>"
                                                ><i class="icon-eye"></i>View Station
                                                    Status</a></li>
                                            <li>
                                                <a href="events_module/station_events.php?line=<?php echo $line; ?>&part_family=<?php echo $pf_no; ?>&part_number=<?php echo $p_no; ?>"
                                                ><i class="icon-sync"></i>Add / Update
                                                    Events</a></li>
											<?php if (($_SESSION['role_id'] == 'admin') || ($_SESSION['role_id'] == 'super')) { ?>
                                                <li>
                                                    <a href="form_module/form_settings.php?station=<?php echo $line; ?>"
                                                    ><i class="icon-pie5"></i> Create Form</a>
                                                </li>
											<?php } ?>
                                            <li>
                                                <a href="form_module/options.php?station=<?php echo $line; ?>&part_family=<?php echo $pf_no; ?>&part_number=<?php echo $p_no; ?>"
                                                ><i class="icon-pie5"></i> Submit Form</a>
                                            </li>
                                            <!--															--><?php //if(($_SESSION['role_id'] == 'admin') || ($_SESSION['role_id'] == 'super')){?>
                                            <li>
                                                <a href="assignment_module/assign_crew.php?line=<?php echo $line; ?>"
                                                ><i class="icon-sync"></i>Assign / Unassign Crew</a>
                                            </li>
                                            <!--															--><?php //} ?>
                                            <li>
                                                <a href="view_assigned_crew.php?station=<?php echo $line; ?>"
                                                ><i class="icon-eye"></i> View Assigned Crew</a>
                                            </li>
                                            <li>
                                                <a href="document_module/document_form.php?station=<?php echo $line; ?>&station_event_id=<?php echo $station_event_id; ?>" target="_BLANK">
                                                    <i class="fa fa-file"></i>Upload Document </a>
                                            </li>
                                            <li>
                                                <a href="document_module/view_document.php?station=<?php echo $line; ?>&part=<?php echo $p_no; ?>" target="_BLANK">
                                                    <i class="fa fa-file"></i> View Document </a>
                                            </li>
                                            <li>
                                                <a href="report_config_module/scan_line_asset.php" target="_BLANK">
                                                    <i class="fa fa-file"></i> Submit Station Assets </a>
                                            </li>
                                            <?php if($event_type_id == 7) { ?>
                                                <li>
                                                    <a href="view_form_status.php?station=<?php echo $line; ?>" target="_BLANK">
                                                        <i class="icon-pie5"></i> Form Submit Dashboard</a>
                                                </li>
                                            <?php }  else { ?>
                                                <?php if (($_SESSION['role_id'] == 'admin') || ($_SESSION['role_id'] == 'super')) { ?>
                                                    <li>
                                                        <a href="config_module/line_wise_form_submit_dashboard.php?id=<?php echo $line; ?>" target="_BLANK">
                                                            <i class="icon-pie5"></i> Form Submit Dashboard</a>
                                                    </li>
                                                <?php } }?>
                                        </ul>
                                    </li>
                                </ul>

                            </div>
                            <h3 class="no-margin dashboard_line_heading"><?php echo $rowc["line_name"]; ?></h3>
                            <hr/>

                            <table style="width:100%" id="t01">
                                <tr>
                                    <td>
                                        <div style="padding-top: 5px;font-size: initial; wi">Part Family :
                                        </div>
                                    </td>
                                    <td>
                                        <div><?php echo $pf_name;
											$pf_name = ''; ?> </div>
                                        <input type="hidden" id="id<?php echo $countervariable; ?>"
                                               value="<?php echo $time; ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div style="padding-top: 5px;font-size: initial;">Part Number :
                                        </div>
                                    </td>
                                    <td><span><?php echo $p_num;
											$p_num = ''; ?></span></td>
                                </tr>
                                <!--                                        <tr>-->
                                <!--                                            <td><div style="padding-top: 5px;font-size: initial;">Event Type :  </div></td>-->
                                <!--                                            <td><span>-->
								<?php //echo $last_assignedby;	$last_assignedby = "";
								?><!--</span></span></td>-->
                                <!--                                        </tr>-->
                                <tr>
                                    <td>
                                        <div style="padding-top: 5px;font-size: initial;">Part Name :</div>
                                    </td>
                                    <td><span><?php echo $p_name;
											$p_name = ''; ?></span></td>
                                </tr>
                            </table>
                        </div>
                        <!--                                <h4 style="text-align: center;background-color:#<?php echo $buttonclass; ?>;"><div id="txt" >&nbsp; </div></h4>
                                        -->
						<?php
						$variable123 = $time;
						if ($variable123 != "") {
                            //include the timing configuration file
                            include("timings_config.php");
							?>

						<?php } ?>
                        <div style="height: 100%;">
                            <h4 style="height:inherit;text-align: center;background-color:<?php echo $buttonclass; ?>;color: #fff;">
                                <div style="padding: 10px 0px 5px 0px;"><?php echo $line_status_text; ?> -
                                    <span style="padding: 0px 0px 10px 0px;"
                                          id="demo<?php echo $countervariable; ?>">&nbsp;</span><span
                                            id="server-load"></span></div>
                                <!--                                        <div style="padding: 0px 0px 10px 0px;" id="demo-->
								<?php //echo $countervariable;
								?><!--" >&nbsp;</div>-->
                            </h4>
                        </div>
                    </div>
                </div>
                <!--								</div>-->
				<?php
			} else {
				?>
                <div class="col-lg-3">
                <div class="panel bg-blue-400">
                    <div class="panel-body">
                        <div class="heading-elements">
                            <ul class="icons-list">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                                                class="icon-cog3"></i> <span class="caret"
                                                                             style="color:white;"></span></a>


                                    <ul class="dropdown-menu dropdown-menu-right">
										<?php if ($event_status != '0' && $event_status != '') { ?>
                                            <li>
                                                <a href="events_module/good_bad_piece.php?station_event_id=<?php echo $station_event_id; ?>"
                                                   target="_BLANK"><i class="fa fa-line-chart"></i>Good & Bad Piece
                                                </a></li>
                                            <li>

                                                <a href="material_tracability/material_tracability.php?station=<?php echo $line ; ?>&station_event_id=<?php echo $station_event_id; ?>" target="_BLANK">
                                                    <i class="fa fa-pencil-square"></i> Material Traceability</a>
                                            </li>
                                            <li>
                                                <a href="material_tracability/material_search.php?station=<?php echo $line; ?>&station_event_id=<?php echo $station_event_id; ?>" target="_BLANK">
                                                    <i class="fa fa-pencil-square"></i> View Material Traceability</a>
                                            </li>
                                            <li>
                                                <a href="10x/10x.php?station=<?php echo $line; ?>&station_event_id=<?php echo $station_event_id; ?>&f_type=n" target="_BLANK">
                                                    <i class="icon-eye"></i> Submit 10x</a>
                                            </li>
                                            <li>
                                                <a href="10x/10x_search.php?station=<?php echo $line; ?>&station_event_id=<?php echo $station_event_id; ?>" target="_BLANK">
                                                    <i class="icon-eye"></i> View 10x </a>
                                            </li>

										<?php } ?>


                                        <li>
                                            <a href="view_station_status.php?station=<?php echo $line; ?>"
                                               target="_BLANK"><i class="icon-eye"></i>View Station Status</a>
                                        </li>
                                        <li>
                                            <a href="events_module/station_events.php?line=<?php echo $line; ?>&part_family=<?php echo $pf_no; ?>&part_number=<?php echo $p_no; ?>"
                                            ><i class="icon-sync"></i>Add / Update
                                                Events</a></li>
										<?php if (($_SESSION['role_id'] == 'admin') || ($_SESSION['role_id'] == 'super')) { ?>
                                            <li>
                                                <a href="form_module/form_settings.php?station=<?php echo $line; ?>"
                                                ><i class="icon-pie5"></i> Create Form</a>
                                            </li>
										<?php } ?>
                                        <li>
                                            <a href="form_module/options.php?station=<?php echo $line; ?>&part_family=<?php echo $pf_no; ?>&part_number=<?php echo $p_no; ?>"
                                            ><i class="icon-pie5"></i> Submit Form</a>
                                        </li>
                                        <!--														--><?php //if(($_SESSION['role_id'] == 'admin') || ($_SESSION['role_id'] == 'super')){?>
                                        <li>
                                            <a href="assignment_module/assign_crew.php?line=<?php echo $line; ?>"
                                            ><i class="icon-sync"></i>Assign / Unassign Crew</a>
                                        </li>
                                        <!--														--><?php //} ?>
                                        <li>
                                            <a href="view_assigned_crew.php?station=<?php echo $line; ?>"
                                               target="_BLANK"><i class="icon-eye"></i> View Assigned Crew</a>
                                        </li>
                                        <li>
                                            <a href="document_module/view_document.php?station=<?php echo $line; ?>&part=<?php echo $p_no; ?>" target="_BLANK">
                                                <i class="fa fa-file"></i> View Document </a>
                                        </li>
                                        <li>
                                            <a href="report_config_module/scan_line_asset.php" target="_BLANK">
                                                <i class="fa fa-file"></i> Submit Station Assets </a>
                                        </li>
                                           <?php if($event_type_id == 7) { ?>
                                            <li>
                                                <a href="view_form_status.php?station=<?php echo $line; ?>" target="_BLANK">
                                                    <i class="icon-pie5"></i> Form Submit Dashboard</a>
                                            </li>
                                           <?php }  else { ?>
                                            <?php if (($_SESSION['role_id'] == 'admin') || ($_SESSION['role_id'] == 'super')) { ?>
                                                <li>
                                                    <a href="config_module/line_wise_form_submit_dashboard.php?id=<?php echo $line; ?>" target="_BLANK">
                                                        <i class="icon-pie5"></i> Form Submit Dashboard</a>
                                                </li>
                                            <?php } }?>
                                    </ul>

                                </li>
                            </ul>
                        </div>
                        <h3 class="no-margin dashboard_line_heading"><?php echo $rowc["line_name"]; ?></h3>
                        <hr/>

                        <table style="width:100%" id="t01">
                            <tr>
                                <td>
                                    <div style="padding-top: 5px;font-size: initial; wi">Part Family :</div>
                                </td>
                                <td>
                                    <div><?php echo $pf_name;
										$pf_name = ''; ?> </div>
                                    <input type="hidden" id="id<?php echo $countervariable; ?>"
                                           value="<?php echo $time; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="padding-top: 5px;font-size: initial;">Part Number :</div>
                                </td>
                                <td><span><?php echo $p_num;
										$p_num = ''; ?></span></td>
                            </tr>
                            <!--                                        <tr>-->
                            <!--                                            <td><div style="padding-top: 5px;font-size: initial;">Event Type :  </div></td>-->
                            <!--                                            <td><span>-->
							<?php //echo $last_assignedby;	$last_assignedby = "";
							?><!--</span></span></td>-->
                            <!--                                        </tr>-->
                            <tr>
                                <td>
                                    <div style="padding-top: 5px;font-size: initial;">Part Name :</div>
                                </td>
                                <td><span><?php echo $p_name;
										$p_name = ''; ?></span></td>
                            </tr>
                        </table>


                    </div>
                    <!--                                <h4 style="text-align: center;background-color:#<?php echo $buttonclass; ?>;"><div id="txt" >&nbsp; </div></h4>
                                        -->
					<?php
					$variable123 = $time;
					if ($variable123 != "") {
                        //include the timing configuration file
                        include("timings_config.php");
						?>

					<?php } ?>
                    <div style="height: 100%">
                        <h4 style="height:inherit;text-align: center;background-color:<?php echo $buttonclass; ?>; color:#fff">
                            <div style="padding: 10px 0px 5px 0px;"><?php echo $line_status_text; ?> - <span
                                        style="padding: 0px 0px 10px 0px;"
                                        id="demo<?php echo $countervariable; ?>">&nbsp;</span>
                                 <span id="server-load"></span></div>
                            <!--                                        <div style="padding: 0px 0px 10px 0px;" id="demo-->
							<?php //echo $countervariable;
							?><!--" >&nbsp;</div>-->
                        </h4>
                    </div>


                </div>
                </div><?php
			}
		}
	}

	?>
    <!--				</div>-->
</div>
<?php
$i = $_SESSION["sqq1"];
if ($i == "") {
	?>
    <script>
        $(document).ready(function () {
            $('#modal_theme_primarydash').modal('show');
        });
    </script>
<?php }
?>
<script>
    setTimeout(function () {
        //alert("reload");
        location.reload();
    }, 60000);
</script>
<?php include("footer.php"); ?> <!-- /page container -->
<!-- new footer here -->
</body>
</html>