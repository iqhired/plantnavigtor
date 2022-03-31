<?php include("config.php");
if (!isset($_SESSION['user'])) {
	header('location: logout.php');
}
$timestamp = date('H:i:s');
$message = date("Y-m-d H:i:s");
$cell_id = $_SESSION['cell_id'];
$_SESSION['line_cust_dash'] =0;
$role = $_SESSION['role_id'];
$is_admin = (($role != null) && (isset($role)) && ($role == 'admin'))?1:0;
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
	<!--chart -->
	<style>
		td{
			width:50% !important;
		}
		.heading-elements {
			background-color: transparent;
		}

		.line_card{
			background-color: #181d50;
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


		.dashboard_line_heading {

			padding-top: 5px;
			font-size: 15px !important;
            color: #060818;
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
$cam_page_header = "Cell Station Status Overview";
include("tab_header.php");
 include("tab_menu.php"); ?>
<!-- Page container -->
<div class="page-container">

			<!-- Content area -->
			<div class="content">
				<div class="row">
					<?php
//					$query = sprintf("SELECT * FROM  cam_line where enabled = '1' and line_id = '$tab_line'");
					$query = sprintf("SELECT stations FROM `cell_grp` where c_id = '$cell_id'");
					$qur = mysqli_query($db, $query);
					$rowc = mysqli_fetch_array($qur);
					$stations = $rowc['stations'];
					$arr_stations = explode(',', $stations);
					$countervariable = 0;
					foreach ($arr_stations as $station) {
						if(isset($station) && $station != ''){
//						while ($rowc = mysqli_fetch_array($qur)) {
							$event_status = '';
							$line_status_text = '';
							$buttonclass = '#000';
							$p_num = '';
							$p_name = '';
							$pf_name = '';
							$time = '';
							$countervariable++;
							$line = $station;
							$query = sprintf("SELECT line_id,line_name FROM  cam_line where line_id = '$line'");
							$qur = mysqli_query($db, $query);
							$rowc = mysqli_fetch_array($qur);
							//$qur01 = mysqli_query($db, "SELECT created_on as start_time , modified_on as updated_time FROM  sg_station_event where line_id = '$line' and event_status = 1 order BY created_on DESC LIMIT 1");
							$qur01 = mysqli_query($db, "SELECT pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name, et.event_type_name as e_name ,et.color_code as color_code , sg_events.modified_on as updated_time ,sg_events.station_event_id as station_event_id , sg_events.event_status as event_status , sg_events.created_on as e_start_time FROM sg_station_event as sg_events inner join event_type as et on sg_events.event_type_id=et.event_type_id Inner Join pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on sg_events.part_number_id=pn.pm_part_number_id where sg_events.line_id= '$line' ORDER by sg_events.created_on DESC LIMIT 1");
							$rowc01 = mysqli_fetch_array($qur01);
							if($rowc01 != null){
								$time = $rowc01['updated_time'];
								$station_event_id = $rowc01['station_event_id'];
								$line_status_text = $rowc01['e_name'];
								$event_status = $rowc01['event_status'];
								$p_num = $rowc01["p_num"];;
								$p_name = $rowc01["p_name"];;
								$pf_name = $rowc01["pf_name"];;
//						$buttonclass = "94241c";
								$buttonclass = $rowc01["color_code"];
							}else{

							}

							if ($countervariable % 4 == 0) {
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
															<?php if($event_status != '0' && $event_status != ''){ ?>
																<li>
																	<a href="events_module/good_bad_piece.php?station_event_id=<?php echo $station_event_id; ?>"
																	   target="_BLANK"><i class="fa fa-eye"></i>Good & Bad Piece
																	</a></li>

															<?php }  ?>
															<li>
																<a href="view_station_status.php?station=<?php echo $rowc["line_id"]; ?>"
																   target="_BLANK"><i class="fa fa-eye"></i>View Station
																	Status</a></li>
															<li>
																<a href="events_module/station_events.php?line=<?php echo $rowc["line_id"]; ?>"
																   target="_BLANK"><i class="icon-sync"></i>Add / Update
																	Events</a></li>
								                            <?php if($is_admin == 1){ ?>
															<li>
																<a href="form_module/form_settings.php?station=<?php echo $rowc["line_id"]; ?>"
																   target="_BLANK"><i class="icon-pie5"></i> Create Form</a>
															</li>
															<?php }  ?>
															<li>
																<a href="form_module/options.php?station=<?php echo $rowc["line_id"]; ?>"
																   target="_BLANK"><i class="icon-pie5"></i> Submit Form</a>
															</li>
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
											?>
											<script>

                                                // Set the date we're counting down to
                                                var iddd<?php echo $countervariable; ?> = $("#id<?php echo $countervariable; ?>").val();
                                                console.log(iddd<?php echo $countervariable; ?>);
                                                var countDownDate<?php echo $countervariable; ?> = new Date(iddd<?php echo $countervariable; ?>).getTime();
                                                // Update the count down every 1 second
                                                var x = setInterval(function () {
                                                    // Get today's date and time
                                                    var now = getCurrentTime();
                                                    //new Date().getTime();
                                                    // Find the distance between now and the count down date
                                                    var distance = now - countDownDate<?php echo $countervariable; ?>;
                                                    // Time calculations for days, hours, minutes and seconds
                                                    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                                    //console.log(days + "d " + hours + "h "+ minutes + "m " + seconds + "s ");
                                                    //console.log("------------------------");
                                                    // Output the result in an element with id="demo"
                                                    document.getElementById("demo<?php echo $countervariable; ?>").innerHTML = days + "d " + hours + "h "
                                                        + minutes + "m " + seconds + "s ";
                                                    // If the count down is over, write some text
                                                    if (distance < 0) {
                                                        clearInterval(x);
                                                        document.getElementById("demo<?php echo $countervariable; ?>").innerHTML = "EXPIRED";
                                                    }
                                                }, 1000);
											</script>
										<?php } ?>
										<div style="height: 100%;">
											<h4 style="height:inherit;text-align: center;background-color:<?php echo $buttonclass; ?>;">
												<div style="padding: 10px 0px 5px 0px;color:#fff;"><?php echo $line_status_text; ?> -
													<span style="padding: 0px 0px 10px 0px;"
														  id="demo<?php echo $countervariable; ?>">&nbsp;</span><span
														id="server-load"></span></div>
												<!--                                        <div style="padding: 0px 0px 10px 0px;" id="demo-->
												<?php //echo $countervariable;
												?><!--" >&nbsp;</div>-->
											</h4>
										</div>
									</div>
								</div></div><?php
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
														<?php if($event_status != '0' && $event_status != ''){ ?>
															<li>
																<a href="events_module/good_bad_piece.php?station_event_id=<?php echo $station_event_id; ?>"
																   target="_BLANK"><i class="fa fa-eye"></i>Good & Bad Piece
																</a></li>
														<?php }  ?>
														<li>
															<a href="view_station_status.php?station=<?php echo $rowc["line_id"]; ?>"
															   target="_BLANK"><i class="fa fa-eye"></i>View Station Status</a>
														</li>
														<li>
															<a href="events_module/station_events.php?line=<?php echo $rowc["line_id"]; ?>"
															   target="_BLANK"><i class="icon-sync"></i>Add / Update
																Events</a></li>
								                        <?php if($is_admin == 1){ ?>
														<li>
															<a href="form_module/form_settings.php?station=<?php echo $rowc["line_id"]; ?>"
															   target="_BLANK"><i class="icon-pie5"></i> Create Form</a>
														</li>
								                        <?php } ?>
														<li>
															<a href="form_module/options.php?station=<?php echo $rowc["line_id"]; ?>"
															   target="_BLANK"><i class="icon-pie5"></i> Submit Form</a>
														</li>
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
										?>
										<script>

                                            // Set the date we're counting down to
                                            var iddd<?php echo $countervariable; ?> = $("#id<?php echo $countervariable; ?>").val();
                                            console.log(iddd<?php echo $countervariable; ?>);
                                            var countDownDate<?php echo $countervariable; ?> = new Date(iddd<?php echo $countervariable; ?>).getTime();
                                            // Update the count down every 1 second
                                            var x = setInterval(function () {
                                                // Get today's date and time
                                                var now = getCurrentTime();
                                                //new Date().getTime();
                                                // Find the distance between now and the count down date
                                                var distance = now - countDownDate<?php echo $countervariable; ?>;
                                                // Time calculations for days, hours, minutes and seconds
                                                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                                //console.log(days + "d " + hours + "h "+ minutes + "m " + seconds + "s ");
                                                //console.log("------------------------");
                                                // Output the result in an element with id="demo"
                                                document.getElementById("demo<?php echo $countervariable; ?>").innerHTML = days + "d " + hours + "h "
                                                    + minutes + "m " + seconds + "s ";
                                                // If the count down is over, write some text
                                                if (distance < 0) {
                                                    clearInterval(x);
                                                    document.getElementById("demo<?php echo $countervariable; ?>").innerHTML = "EXPIRED";
                                                }
                                            }, 1000);
										</script>
									<?php } ?>
									<div style="height: 100%">
										<h4 style="height:inherit;text-align: center;background-color:<?php echo $buttonclass; ?>;">
											<div style="padding: 10px 0px 5px 0px;color:#fff;"><?php echo $line_status_text; ?> - <span
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
					}
					?>
				</div>
			</div>

</div>

<!-- new footer here -->
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
</body>
</html>