<?php
include("../config.php");
$chicagotime = date("Y-m-d H:i:s");
$temp = "";
if (!isset($_SESSION['user'])) {
	if ($_SESSION['is_tab_user'] || $_SESSION['is_cell_login']) {
		header($redirect_tab_logout_path);
	} else {
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
	if ($_SESSION['is_tab_user'] || $_SESSION['is_cell_login']) {
		header($redirect_tab_logout_path);
	} else {
		header($redirect_logout_path);
	}

//	header('location: ../logout.php');
	exit;
}
//Set the time of the user's last activity
$_SESSION['LAST_ACTIVITY'] = $time;
$i = $_SESSION["role_id"];
if ($i != "super" && $i != "admin" && $i != "pn_user" && $_SESSION['is_tab_user'] != 1 && $_SESSION['is_cell_login'] != 1) {
	header('location: ../dashboard.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
		<?php echo $sitename; ?> | User Form</title>
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
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/core/libraries/jquery_ui/interactions.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/media/fancybox.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/form_select2.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/gallery.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/ui/ripple.min.js"></script>

    <style>
        #sub_app {
            padding: 20px 40px;
            color: red;
            font-size: initial;
        }

        #approve_msg {
            color: red;
            font-size: x-small;;
        }
        #success_msg{
            font-size: large;
            padding: 12px;
            width: 30%;

        }
        #success_msg_app{
            font-size: large;
            padding: 12px;
            width: 30%;
            width: 30%;

        }
        .form-control[disabled]{
            color: #000 !important;
        }
        #rej_reason_div_{
            display: none;
        }
        .select2-container {
            width: auto !important;
            float: left !important;
        }

        .select2-container--disabled .select2-selection--single:not([class*=bg-]) {
            color: #060818!important;
            border-block-start: none;
            border-bottom-color: #191e3a!important;
        }
        .select2-container--disabled .select2-selection--single:not([class*=bg-]) {
            color: #999;
            border-bottom-style: none;
        }
        .approve {
            background-color: #1e73be;
            font-size: 12px;
            margin-left: 16px;
            margin-top: 1px;
        }
        .reject {
            background-color: #1e73be;
            font-size: 12px;
            margin-left: 16px;
            margin-top: 1px;
        }





        @media
        only screen and (max-width: 760px),
        (min-device-width: 768px) and (max-device-width: 1024px) {
            #success_msg{
                width: 45%;
            }
            #success_msg_app{
                width: 45%;
            }

            .form_row_item{
                width: 100%;
            }

            .col-md-3.mob{
                width:40%;
            }
            .form_tab_td{
                padding: 10px 100px;
            }

            textarea.form-control {
                height: auto;
                font-size: 15px;
            }
        }
        @media
        only screen and (max-width: 400px),
        (min-device-width: 400px) and (max-device-width: 670px)  {
            #success_msg{
                width: 45%;
            }
            #success_msg_app{
                width: 45%;
            }
            .form_tab_td{
                padding: 0px 0px;
            }
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered{
            line-height: 21px!important;
        }
        @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
            .col-lg-3{
                width: 35%!important;
            }

            .select2-selection--single{
                border-block-start: inherit;
            }

        }
    </style>
</head>

<!-- Main navbar -->
<?php
$cust_cam_page_header = "Submit Form";
$get_form_name = $_GET['form_name'];
$timedisplay = $chicagotime;
//echo $timedisplay;
include("../header.php");
include("../admin_menu.php");
include("../heading_banner.php");
?>
<body class="alt-menu sidebar-noneoverflow">
<!-- Main content -->
<div class="page-container">
    <div class="content">
        <!-- Page header -->
        <div class="panel panel-flat">
            <div id ="success_msg"></div>
            <div id ="success_msg_app"></div>
            <!--            <h5 style="text-align: left;width: 90%;">--><?php //echo date('d-M-Y h:m'); ?><!--</h5>-->
            <div class="panel-heading ">
                <b><h4 class="panel-title form_panel_title"><?php echo $get_form_name; ?></h4></b>
				<?php if ($temp == "one") { ?>
                    <br/>
                    <div class="alert alert-success no-border">
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span
                                    class="sr-only">Close</span></button>
                        <span class="text-semibold">Group</span> Created Successfully.
                    </div>
				<?php } ?>
				<?php if ($temp == "two") { ?>
                    <br/>
                    <div class="alert alert-success no-border">
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span
                                    class="sr-only">Close</span></button>
                        <span class="text-semibold">Group</span> Updated Successfully.
                    </div>
				<?php } ?>
				<?php
				if (!empty($import_status_message)) {
					echo '<br/><div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
				}
				?>
				<?php
				if (!empty($_SESSION[$import_status_message])) {
					echo '<br/><div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
					$_SESSION['message_stauts_class'] = '';
					$_SESSION['import_status_message'] = '';
				}
				?>
                <div class="row ">
                    <div class="col-md-12">
                        <form action="" id="form_settings" enctype="multipart/form-data"  class="form-horizontal" method="post" autocomplete="off">
							<?php
							$form_createid = $_GET['id'];
							$query1 = sprintf("SELECT form_create_id,need_approval,approval_list FROM  form_create where form_create_id = '$form_createid' ");
							$qur1 = mysqli_query($db, $query1);
							$rowc1 = mysqli_fetch_array($qur1);
							$item_id = $rowc1['form_create_id'];
							$need_approval = $rowc1['need_approval'];
							$bypass_approval = $rowc1['approval_list'];
							?>

                            <input type="hidden" name="name" id="name" value="<?php echo $_GET['form_name']; ?>">
                            <input type="hidden" name="formcreateid" id="formcreateid"  value="<?php echo $_GET['id']; ?>">
                            <input type="hidden" name="bypass_approve" id="bypass_approve" value="<?php echo $rowc1['approval_list']; ?>">
                            <div class="form_row row">
                                <label class="col-lg-3 control-label">Form Type : </label>
                                <div class="col-md-7">
									<?php
									$get_form_type = $_GET['form_type'];
									if ($get_form_type != '') {
										$disabled = 'disabled';
									} else {
										$disabled = '';
									}
									?>

                                    <input type="hidden" name="form_type" id="form_type"
                                           value="<?php echo $get_form_type; ?>">
                                    <select name="form_type1" id="form_type"
                                            class="select form-control select-border-color" <?php echo $disabled; ?>>
                                        <option value="" selected disabled>--- Select Form Type ---</option>
										<?php

										$sql1 = "SELECT * FROM `form_type` ";
										$result1 = $mysqli->query($sql1);
										//                                            $entry = 'selected';
										while ($row1 = $result1->fetch_assoc()) {
											if ($get_form_type == $row1['form_type_id']) {
												$entry = 'selected';
											} else {
												$entry = '';
											}
											echo "<option value='" . $row1['form_type_id'] . "'  $entry>" . $row1['form_type_name'] . "</option>";
										}
										?>
                                    </select>
                                </div>
                            </div>
                            <br/>
                            <div class="form_row row">
                                <label class="col-lg-3 control-label">Station : </label>
                                <div class="col-md-7">

									<?php
									$get_station = $_GET['station'];
									if ($get_station != '') {
										$disabled = 'disabled';
									} else {
										$disabled = '';
									}
									?>

                                    <input type="hidden" name="station" id="station"
                                           value="<?php echo $get_station; ?>">
                                    <select name="station1" id="station1"
                                            class="select form-control select-border-color" <?php echo $disabled; ?>>
                                        <option value="" selected disabled>--- Select Station ---</option>
										<?php
										$sql1 = "SELECT * FROM `cam_line` where enabled = '1' ORDER BY `line_name` ASC ";
										$result1 = $mysqli->query($sql1);
										//                                            $entry = 'selected';
										while ($row1 = $result1->fetch_assoc()) {
											if ($get_station == $row1['line_id']) {
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
                            <br/>
							<?php
							$get_part_family = $_GET['part_family'];
							if ($get_part_family != '') {
								$disabled = 'disabled';
								?>
                                <div class="form_row row">
                                    <label class="col-lg-3 control-label">Part Family : </label>
                                    <div class="col-md-7">
                                        <input type="hidden" name="part_family" id="part_family"
                                               value="<?php echo $get_part_family; ?>">
                                        <select name="part_family1" id="part_family1"
                                                class="select form-control select-border-color" <?php echo $disabled; ?>>
                                            <option value="" selected disabled>--- Select Part Family ---</option>
											<?php
											$sql1 = "SELECT * FROM `pm_part_family` ";
											$result1 = $mysqli->query($sql1);
											//                                            $entry = 'selected';
											while ($row1 = $result1->fetch_assoc()) {
												if ($get_part_family == $row1['pm_part_family_id']) {
													$entry = 'selected';
												} else {
													$entry = '';
												}
												echo "<option value='" . $row1['pm_part_family_id'] . "' $entry >" . $row1['part_family_name'] . "</option>";
											}
											?>
                                        </select>
                                    </div>
                                </div>
                                <br/>
								<?php
							}
							?>
							<?php
							$get_part_number = $_GET['part_number'];
							if ($get_part_number != '') {
								$disabled = 'disabled'; ?>
                                <div class="form_row row">
                                    <label class="col-lg-3 control-label">Part Number : </label>
                                    <div class="col-md-7">
                                        <input type="hidden" name="part_number" id="part_number"
                                               value="<?php echo $get_part_number; ?>">
                                        <select name="part_number1" id="part_number1"
                                                class="select form-control select-border-color" <?php echo $disabled; ?>>
                                            <option value="" selected disabled>--- Select Part Number ---</option>
											<?php
											$sql1 = "SELECT * FROM `pm_part_number` ";
											$result1 = $mysqli->query($sql1);
											//                                            $entry = 'selected';
											while ($row1 = $result1->fetch_assoc()) {
												if ($get_part_number == $row1['pm_part_number_id']) {
													$entry = 'selected';
												} else {
													$entry = '';
												}
												echo "<option style=\"word-wrap:break-word;\" value='" . $row1['pm_part_number_id'] . "'  $entry >" . $row1['part_number'] . " - " . $row1['part_name'] . "</option>";
											}
											?>
                                        </select>
                                    </div>
                                </div>
                                <br/>
								<?php
							}
							?>
							<?php
							$sql_wol = "SELECT wol FROM `form_type` where form_type_id = '$get_form_type' ";
							$res_wol = $mysqli->query($sql_wol);
							$r=$res_wol->fetch_assoc();
							$wol = $r['wol'];
							?>
							<?php if($wol != 0){  ?>
                                <div class="form_row row">
                                    <label class="col-lg-3 control-label">Work Order/Lot<span class="red-star" style="font-size: 10px; padding-left:10px;">★ </span>
                                    </label>
                                    <div class="col-md-7">
                                        <textarea class="form-control" name = "wol" id="wol" rows="1" required></textarea>
                                    </div>

                                </div>
							<?php } ?>
                            <div class="form_row row">
                                <label class="col-lg-3 control-label">Notes : </label>
                                <div class="col-md-7">

                                    <textarea class="form-control" id ="notes" name="notes" rows="2"></textarea>
                                </div>
                            </div>
                            <br/>
                            <div class="form_row row">
								<?php
								$qurimage = mysqli_query($db, "SELECT * FROM  form_images where form_create_id = '$item_id'");
								while ($rowcimage = mysqli_fetch_array($qurimage)) { ?>
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="thumbnail">
                                            <div class="thumb">
                                                <img src="../form_images/<?php echo $rowcimage['image_name']; ?>"
                                                     alt="">
                                                <div class="caption-overflow">
														<span>
															<a href="../form_images/<?php echo $rowcimage['image_name']; ?>"
                                                               data-popup="lightbox" rel="gallery"
                                                               class="btn border-white text-white btn-flat btn-icon btn-rounded"><i
                                                                        class="icon-plus3"></i></a>

														</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

								<?php } ?>
                            </div>

                            <b><h4 class="panel-title form_panel_title">Form Information</h4></b>
							<?php
							$query = sprintf("SELECT * FROM  form_item where form_create_id = '$item_id' order by form_item_seq+0 ASC ");
							$qur = mysqli_query($db, $query);
							while ($rowc = mysqli_fetch_array($qur)) {
								$item_val = $rowc['item_val'];
								if ($item_val == "header") {
									?>
                                    <div class="row form_row_item" style="background-color: #e5f3ff;">
                                        <b>
                                            <h4 class="panel-title form_sub_header"><?php echo htmlspecialchars($rowc['item_desc']); ?></h4>
                                        </b>
                                    </div>
								<?php }
								if ($item_val == "numeric") {
									$numeric_normal = $rowc['numeric_normal'];
									$numeric_lower_tol1 = $rowc['numeric_lower_tol'];
									$numeric_upper_tol1 = $rowc['numeric_upper_tol'];

									$numeric_lower_tol1 = str_replace(' ', '', $numeric_lower_tol1); // Replaces all spaces with hyphens.
									$numeric_lower_tol1 = preg_replace('/[^A-Za-z0-9]/', '', $numeric_lower_tol1); // Removes special chars.
									$final_lower = $numeric_normal - $numeric_lower_tol1; // final lower value

									$numeric_upper_tol1 = str_replace(' ', '', $numeric_upper_tol1); // Replaces all spaces with hyphens.
									$numeric_upper_tol1 = preg_replace('/[^A-Za-z0-9]/', '', $numeric_upper_tol1); // Removes special chars.
									$final_upper = $numeric_normal + $numeric_upper_tol1; // final upper value

									?>
                                    <input type="hidden" data-id="<?php echo $rowc['form_item_id']; ?>" class="lower_compare" value="<?php echo $final_lower; ?>">
                                    <input type="hidden" data-id="<?php echo $rowc['form_item_id']; ?>" class="upper_compare" value="<?php echo $final_upper; ?>">
                                    <div class="row form_row_item">
                                        <div class="col-md-7 form_col_item">
                                            <div><?php if ($rowc['optional'] != '1') {
													echo '<span class="red-star">★</span>';
												}
												echo htmlspecialchars($rowc['item_desc']); ?></div>
											<?php if (isset($rowc['discription']) && ($rowc['discription'] != '')) { ?>
                                                <div style="font-size: medium;font-color:#c1c1c1"><?php echo "(" . $rowc['discription'] . ")" ?></div>
											<?php }
											?>
                                        </div>
                                        <div class="col-md-3 mob">

                                            <input type="number" name="<?php echo $rowc['form_item_id']; ?>"
                                                   id="<?php echo $rowc['form_item_id']; ?>"
                                                   class="form-control compare_text" required step="any">
                                        </div>
                                        <div class="col-md-1 form_col_item">
											<?php
											$unit_of_measurement_id = $rowc['unit_of_measurement'];
											$sql1 = "SELECT unit_of_measurement FROM `form_measurement_unit` where form_measurement_unit_id = '$unit_of_measurement_id'";
											$result1 = $mysqli->query($sql1);
											$row1 = $result1->fetch_assoc();
											echo $row1['unit_of_measurement'];
											?>
                                        </div>
                                        <!--											<div class="col-md-3 form_col_item"><u><b>-->
										<?php //echo $rowc['discription']; ?><!-- </b></u></div>-->

                                        <input type="hidden" name="form_item_array[]"
                                               value="<?php echo $rowc['form_item_id']; ?>">
                                    </div>
									<?php
								}
								if ($item_val == "binary") {

									$bin_def = $rowc['binary_normal'];
									$bnf = $rowc['binary_default'];
									?>

                                    <div class="row form_row_item">

                                        <div class="col-md-7 form_col_item">
                                            <input type="hidden" class="binary_compare"
                                                   value="<?php echo $bin_def; ?>"
                                                   data-id="<?php echo $rowc['form_item_id']; ?>"/>
											<?php if ($rowc['optional'] != '1') {
												echo '<span class="red-star">★</span>';
											}
											echo htmlspecialchars($rowc['item_desc']); ?>
											<?php if (isset($rowc['discription']) && ($rowc['discription'] != '')) { ?>
                                                <div style="font-size: medium;font-color:#c1c1c1"><?php echo "(" . $rowc['discription'] . ")" ?></div>
											<?php } ?>
                                        </div>

                                        <div class="col-md-4">
                                            <input type="hidden" name="form_item_array[]"
                                                   value="<?php echo $rowc['form_item_id']; ?>"/>
                                            <div class="form-check form-check-inline form_col_option">
                                                <input type="radio" id="yes"
                                                       name="<?php echo $rowc['form_item_id']; ?>"
                                                       value="yes"
                                                       class="form-check-input" <?php if ($bnf == 'yes') {
													echo 'checked';
												}
												if ($rowc['optional'] != '1') {
													echo 'required';
												} ?> />
                                                <label for="yes"
                                                       class="item_label <?php echo $rowc['form_item_id']; ?>"
                                                       id="<?php echo $rowc['form_item_id']; ?>"><?php $yes_alias = $rowc['binary_yes_alias'];
													echo (($yes_alias != null) || ($yes_alias != '')) ? $yes_alias : "Yes" ?></label>
                                                <input type="radio" id="no"
                                                       name="<?php echo $rowc['form_item_id']; ?>"
                                                       value="no"
                                                       class="form-check-input" <?php if ($bnf == "no") {
													echo 'checked';
												}
												if ($rowc['optional'] != '1') {
													echo 'required';
												} ?> />
                                                <label for="no"
                                                       class="item_label <?php echo $rowc['form_item_id']; ?>"
                                                       id="<?php echo $rowc['form_item_id']; ?>"><?php $no_alias = $rowc['binary_no_alias'];
													echo (($no_alias != null) || ($no_alias != '')) ? $no_alias : "No" ?></label>
												<?php if ($rowc['optional'] == '1') {
													echo '<span style="color: #a1a1a1; font-size: small;">(Optional)</span>';
												} ?>
                                            </div>
                                        </div>
                                        <!--<div class="col-md-3 form_col_item"><u></u></div>-->
                                    </div>
								<?php }
								if ($item_val == "list") {
									$list_def = $rowc['list_normal'];
									$lnf = $rowc['list_name1'];
									$lnf1 = $rowc['list_name2'];
									$lnf2 = $rowc['list_name2'];
									$list_enabled =  $rowc['list_enabled'];
									$extra_enabled =  $rowc['radio_extra'];
									?>
                                    <div class="row form_row_item">
                                        <div class="col-md-7 form_col_item">
                                            <input type="hidden" class="list_enabled" name="list_enabled" data-id="<?php echo $rowc['form_item_id']; ?>" value="<?php echo $list_enabled; ?>"/>
                                            <input type="hidden" class="binary_compare"
                                                   value="<?php echo $list_def; ?>"
                                                   data-id="<?php echo $rowc['form_item_id']; ?>"/>
											<?php if ($rowc['optional'] != '1') {
												echo '<span class="red-star">★</span>';
											}
											echo htmlspecialchars($rowc['item_desc']); ?>
											<?php if (isset($rowc['discription']) && ($rowc['discription'] != '')) { ?>
                                                <div style="font-size: medium;font-color:#c1c1c1"><?php echo "(" . $rowc['discription'] . ")" ?></div>
											<?php } ?>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="hidden" name="form_item_array[]"
                                                   value="<?php echo $rowc['form_item_id']; ?>"/>
                                            <div class="form-check form-check-inline form_col_option">
                                                <input type="radio" id="yes"
                                                       name="<?php echo $rowc['form_item_id']; ?>"
                                                       value="yes"
                                                       class="form-check-input" <?php if ($list_def == 'yes') {
													echo 'checked';
												}
												if ($rowc['optional'] != '1') {
													echo 'required';
												} ?> />
                                                <label for="yes"
                                                       class="item_label <?php echo $rowc['form_item_id']; ?>"
                                                       id="<?php echo $rowc['form_item_id']; ?>"><?php $yes_alias = $rowc['list_name2'];
													$none_alias = $rowc['list_name1'];
													echo (($yes_alias != null) || ($yes_alias != '')) ? $yes_alias : "Yes" ?></label>
                                                <input type="radio" id="no"
                                                       name="<?php echo $rowc['form_item_id']; ?>"
                                                       value="no"
                                                       class="form-check-input" <?php if ($list_def == "no") {
													echo 'checked';
												}
												if ($rowc['optional'] != '1') {
													echo 'required';
												} ?> />
                                                <label for="no"
                                                       class="item_label <?php echo $rowc['form_item_id']; ?>"
                                                       id="<?php echo $rowc['form_item_id']; ?>"><?php $no_alias = $rowc['list_name3'];
													echo (($no_alias != null) || ($no_alias != '')) ? $no_alias : "No" ?></label>

												<?php if ($list_enabled == 1 && !empty($none_alias)) { ?>
                                                    <input type="radio" id="none"
                                                           name="<?php echo $rowc['form_item_id']; ?>"
                                                           value="none"
                                                           class="form-check-input" <?php if ($list_def == 'none') {
														echo 'checked';
													}
													if ($rowc['optional'] != '1') {
														echo 'required';
													} ?> />
                                                    <label for="none"
                                                           class="item_label <?php echo $rowc['form_item_id']; ?>"
                                                           id="<?php echo $rowc['form_item_id']; ?>"><?php $none_alias = $rowc['list_name1'];
														echo (($none_alias != null) || ($none_alias != '')) ? $none_alias : "None" ?></label>


												<?php } ?>

                                                 <?php $list_extra =  $rowc['list_name_extra'];
                                                 if(!empty($list_extra)){
													 $arrteam = explode(',', $list_extra);
													 $radiocount = 1;
													 foreach ($arrteam as $arr) { ?>
                                                         <input type="radio" id="extra"
                                                                name="<?php echo $rowc['form_item_id']; ?>"
                                                                value="extra_<?php echo $radiocount; ?>"
                                                                class="form-check-input" <?php if ($list_def == "extra_$radiocount") {
															 echo 'checked';
														 }
														 if ($rowc['optional'] != '1') {
															 echo 'required';
														 } ?> />
                                                         <label for="extra"
                                                                class="item_label <?php echo $rowc['form_item_id']; ?>"
                                                                id="<?php echo $rowc['form_item_id']; ?>"><?php $extra_alias = "$arr";
															 echo (($extra_alias != null) || ($extra_alias != '')) ? $extra_alias : "Extra" ?></label>
														 <?php if ($rowc['optional'] == '1') {
															 echo '<span style="color: #a1a1a1; font-size: small;">(Optional)</span>';

														 }   $radiocount++; }
                                                 }
                                                  ?>
                                            </div>
                                        </div>

                                    </div>

								<?php }
								if ($item_val == "text") {
									?>
                                    <div class="row form_row_item">
                                        <div class="col-md-7 form_col_item">
                                            <div><?php
												if ($rowc['optional'] != '1') {
													echo '<span class="red-star">★</span>';
												}
												echo htmlspecialchars($rowc['item_desc']); ?></div>
											<?php if (isset($rowc['discription']) && ($rowc['discription'] != '')) { ?>
                                                <div style="font-size: medium;font-color:#c1c1c1"><?php echo "(" . $rowc['discription'] . ")" ?></div>
											<?php } ?>
                                        </div>
                                        <!-- <div class="col-md-4 form_col_item">-->
										<?php //echo $rowc['item_desc']; ?><!-- </div>-->
                                        <div class="col-md-3 form">
                                            <input type="hidden" name="form_item_array[]"
                                                   value="<?php echo $rowc['form_item_id']; ?>"/>
                                            <input type="text" class="form-control text_num" name="<?php echo $rowc['form_item_id']; ?>" autocomplete="off"
                                                   id="<?php echo $rowc['form_item_id']; ?>" <?php if ($rowc['optional'] != '1') {
												echo 'required';
											} ?> />
                                        </div>
										<?php if (isset($rowc['discription']) && ($rowc['discription'] != '')) { ?>
                                            <div class="col-md-3 form_col_item">
                                                <u><b><?php echo $rowc['discription']; ?> </b></u></div>
										<?php } ?>
                                    </div>
									<?php
								}
							}
							?>
                            <hr class="form_hr"/>
							<?php if($need_approval == "yes") { ?>
                                <div class="row form_row_item">
                                    <input type="hidden" name="click_id" id="click_id">
                                    <div class="col-md-2">
                                        <button id="btnSubmit" class="btn btn-primary"
                                                style="background-color:#1e73be;">
                                            Submit
                                        </button>
                                    </div>
                                </div>
							<?php } else { ?>
                                <div class="row form_row_item">
                                    <input type="hidden" name="click_id" id="click_id">
                                    <div class="col-md-2">
                                        <button id="btnSubmit_app" class="btn btn-primary"
                                                style="background-color:#1e73be;">
                                            Submit
                                        </button>
                                    </div>
                                </div>
							<?php } ?>

                            <div id="approve_sec" style="display: none">
								<?php
								if ($need_approval == "yes") {
								?>
                                <div id="sub_app">The form needs to be approved before submitting</div>
                                <br/>
                                <!-- Approval List-->

                                <div id="app_list">
                                    <b><h4 class="panel-title form_panel_title">Approval List</h4></b>
                                    <form action="" id="approve_form" class="form-horizontal" method="post" autocomplete="off">
                                        <div class="form_table">
                                            <!--                                        <tr class="form_tab_tr">-->
                                            <!--                                            <th class="form_tab_th">Department</th>-->
                                            <!--                                            <th class="form_tab_th">Approver</th>-->
                                            <!--                                            <th class="form_tab_th">Digital Signature</th>-->
                                            <!--                                            <th class="form_tab_th">Actions</th>-->
                                            <!--                                        </tr>-->
											<?php
											$query1 = sprintf("SELECT * FROM  form_create where form_create_id = '$item_id' and need_approval = 'yes'");
											$qur1 = mysqli_query($db, $query1);
											$i = 0;
											while ($rowc1 = mysqli_fetch_array($qur1)) {
												$approval_by_array = $rowc1['approval_by'];

												$arrteam = explode(',', $approval_by_array);
												$j = 0;	$k = 0;
												foreach ($arrteam as $arr) {
													if ($arr != "") {
														?>
                                                        <div class="form_tab_tr" style="margin-bottom: 30px;">
															<?php
															$qurtemp = mysqli_query($db, "SELECT group_name FROM `sg_group` where group_id = '$arr' ");
															$rowctemp = mysqli_fetch_array($qurtemp);
															$groupname = $rowctemp["group_name"]

															?>
                                                            <div style="margin-bottom: 10px;">
                                                                <input type="hidden" name="approval_dept"
                                                                       id="approval_dept_<?php echo $j ?>"
                                                                       value="<?php echo $arr; ?>">
																<?php echo $groupname; ?>
                                                            </div>
                                                            <div style="font-size: small !important;">
                                                                <select class="select-border-color"
                                                                        name="approval_initials"
                                                                        id="approval_initials_<?php echo $j ?>"
                                                                        class="select" data-style="bg-slate">
                                                                    <option value="" selected disabled>--- Select Approver
                                                                        ---
                                                                    </option>
																	<?php
																	$sql1 = "SELECT * FROM `sg_user_group` where group_id = '$arr'";
																	$result1 = $mysqli->query($sql1);
																	while ($row1 = $result1->fetch_assoc()) {

																		$user_id = $row1['user_id'];
																		$qurtemp = mysqli_query($db, "SELECT firstname,lastname FROM `cam_users` where users_id = '$user_id' and pin_flag = '1' ");
																		$rowctemp = mysqli_fetch_array($qurtemp);
																		if ($rowctemp != NULL) {
																			$fullnn = $rowctemp["firstname"] . " " . $rowctemp["lastname"];

																			echo "<option value='" . $user_id . "' >" . $fullnn . "</option>";
																		}
																		$fullnm = "";
																	}
																	?>
                                                                </select>
                                                                <span style="font-size: x-small;color: darkred;display: none;" id="u_error_<?php echo $j; ?>">Select User.</span>

                                                                <span class="form_tab_td" id="approve_msg" style="float: left !important;width: 40% !important;padding: 0px 30px !important;">
                                                            <input type="password" name="pin[]" id="pin_<?php echo $j ?>"
                                                                   class="form-control" style=" margin-bottom: 5px;width: auto !important;"
                                                                   placeholder="Enter Pin..."  autocomplete="off" >
                                                            <span style="font-size: x-small;color: darkred; display: none;" id="pin_error_<?php echo $j; ?>">Invalid Pin.</span>
                                                        </span>

                                                                <span class="form_tab_td ">
                                                            <input type="hidden" id="form_user_data_id"
                                                                   name="form_user_data_id" value=""/>
                                                            <input type="hidden" id="approval_dept_cnt"
                                                                   name="approval_dept_cnt" value=""/>
                                                            <button type="submit" id="approve_<?php echo $j ?>"
                                                                    name="approve"
                                                                    class="btn btn-primary approve">
                                                                <i class="fa fa-check" aria-hidden="true"></i>

                                                            </button>
                                                            <button type="submit" id="reject_<?php echo $k ?>"
                                                                    name="reject"
                                                                    class="btn btn-primary reject">
                                                                <i class="fa fa-times" aria-hidden="true"></i>

                                                            </button>
                                                                    <!--                                                        </td>-->
                                                                    <!--                                                        <td class="form_tab_td" style="padding: 0px;">-->
                                                            <input type="hidden" id="rejected_dept_cnt"
                                                                   name="rejected_dept_cnt" value=""/>
                                                            <input type="hidden" id="reject_dept_cnt"
                                                                   name="reject_dept_cnt" value=""/>

                                                        </span>
                                                            </div>
                                                        </div>
                                                        <div class="reason" id="rej_reason_div_<?php echo $j ?>" style="display: none">
                                                        <span class="form_tab_td" id="rej_reason_td_<?php echo $j ?>" >
<!--                                                            <textarea class="form-control reason" id="rej_reason_td_--><?php //echo $j ?><!--" >  </textarea>-->
                                                        </div>
                                                        <hr/>
														<?php
														$j++;
														$k++;
													}
												}
												?>
                                                <input type="hidden" name="tot_approval_dept" id="tot_approval_dept"
                                                       value="<?php echo ($j); ?>">
                                                <input type="hidden" name="tot_rejected_dept" id="tot_rejected_dept"
                                                       value="<?php echo ($k); ?>">
												<?php
											}
											?>

                                        </div>
                                        <div>
                                            <hr class="form_hr"/>
                                        </div>
                                        <!--                                    </form>-->
                                        <div class="row form_row_item">
                                            <input type="hidden" name="click_id_1" id="click_id_1">
                                            <div class="col-md-2">
                                                <button type="button" id="btnSubmit_1" class="btn btn-primary" disabled
                                                        style="background-color:#1e73be;">
                                                   Submit
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
						<?php
						}
						?>
                            <br/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /main charts -->
        <!-- edit modal -->
        <!-- Dashboard content -->
        <!-- /dashboard content -->
        <!-- /content area -->
    </div>
    <!-- /main content -->
</div>
<!-- <script>
$('#reject').on('change', function () {

        var selected_val = this.value.split("_")[1];
        if (selected_val == 3) {
            document.getElementById("reject_div").innerHTML +="<div class=\"col-md-12\">\n" +
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
            document.getElementById("reject_div").innerHTML ="";
            // document.getElementById("reason_div").required = false;
            // $("#reason_div").hide();
        }
    });
</script> -->
</body>
<script>
    $("#btnSubmit").click(function (e) {
        if ($("#form_settings")[0].checkValidity()){
            var data = $("#form_settings").serialize();
            $.ajax({
                type: 'POST',
                url: 'user_form_backend.php',
                dataType: "json",
                // context: this,
                async: false,
                data: data,
                success: function (data) {
                    $('#btnSubmit').attr('disabled', 'disabled');
                    $('form input[type="radio"]').css('pointer-events','none');
                    $('form input[type="number"]').css('pointer-events','none');
                    $('form input[type="text"]').css('pointer-events','none');
                    $("label[for='yes']").css('pointer-events','none');
                    $("label[for='no']").css('pointer-events','none');
                    $("textarea#wol").css('pointer-events','none');
                    $("textarea#notes").css('pointer-events','none');
                    document.getElementById("form_user_data_id").value = data["form_user_data_id"];
                    document.getElementById("approval_dept_cnt").value = data["approval_dept_cnt"];
                    document.getElementById("rejected_dept_cnt").value = data["rejected_dept_cnt"];
                    var bypass_approve = $("#bypass_approve").val();
                    var err_cnt = data["out_of_tol_val_cnt"];
                    var dept_cnt =data["approval_dept_cnt"];

                    var x = document.getElementById("approve_sec");
                    if (x.style.display === "none") {
                        x.style.display = "block";
                        var y = document.getElementById("btnSubmit");
                        y.style.display = "none";
                    }

                    if(err_cnt > 0){
                        document.getElementById("sub_app").style.display = "block";
                        document.getElementById("app_list").style.display = "block";
                        document.getElementById("notes").required = true;
                        // document.getElementsByClassName("reason").style.display = "block";
                        for(var i =0 ; i<dept_cnt ; i++){
                            var z = document.getElementById("rej_reason_div_"+i);
                            if (z.style.display === "none") {
                                z.style.display = "block";
                                //<td class="form_tab_td" colspan="4">
                                //        <textarea class="form-control" placeholder="Enter Reject Reason..." oninvalid="this.setCustomValidity('Enter Reject reason')"
                                //    onvalid="this.setCustomValidity('')" id="rej_reason_<?php //echo $j ?>//" name = "rej_reason_<?php //echo $j ?>//" rows="1"></textarea>
                                //        </td>
                                var y = document.getElementById("rej_reason_td_"+i);
                                var rr_id = 'rej_reason_'+i;
                                y.innerHTML += "<textarea class= \"form-control\" placeholder=\"Enter Reason\" id= \"" +  rr_id + "\" name = \"" +  rr_id + "\" rows=\"1\" required></textarea>";
                            }
                        }


                    }else{
                        // document.getElementsByClassName("reason").style.display = "none";
                        if (bypass_approve == 'yes'){
                            $('#success_msg_app').text('Form submitted Successfully').css('background-color', '#0080004f');
                            window.scrollTo(0, 0);
                        }
                    }

                }
            });
        }
        // e.preventDefault();
    });

    $("#btnSubmit_app").click(function (e) {
        if ($("#form_settings")[0].checkValidity()){
            var data = $("#form_settings").serialize();
            $.ajax({
                type: 'POST',
                url: 'user_form_backend.php',
                dataType: "json",
                // context: this,
                async: false,
                data: data,
                success: function (data) {
                    $('#btnSubmit_app').attr('disabled', 'disabled');
                    $('#success_msg').text('Form submitted Successfully').css('background-color','#0080004f');
                    $("form :input").prop("disabled", true);
                    window.scrollTo(0, 0);

                }
            });
        }
        // e.preventDefault();
    });

    $("#btnSubmit_1").click(function (e) {
        if ($("#form_settings")[0].checkValidity()) {
            var data = $("#form_settings").serialize();
            var rr = document.getElementById("rej_reason_" + this.id.split("_")[1]);
            var rr_data = "";
            if (null != rr) {
                rr_data = rr.value;
            }
            var data_1 = data + "&update_fud=1" + "&form_user_data_id=" + document.getElementById("form_user_data_id").value + "&reject_reason=" + rr_data;
            $.ajax({
                type: 'POST',
                url: 'user_form_backend.php',
                // dataType: "json",
                // context: this,
                // async: false,
                data: data_1,
                success: function (response) {
                    $('#btnSubmit_1').attr('disabled', 'disabled');
                    var x = document.getElementById("sub_app");
                    x.style.display = "none";
                    $('#success_msg').text('Form submitted Successfully').css('background-color', '#0080004f');
                    $("form :input").css('pointer-events','none');
                    window.scrollTo(0, 0);
                }
            });
        }else{
            var data = $("#form_settings").serialize();
            var cnt = document.getElementById("rejected_dept_cnt").value;
            for(var rid = 0; rid < cnt ; rid++){
                var rr = document.getElementById("rej_reason_td_" + rid );
                var rr_id = 'rej_reason_'+ rid;
                var rr_e_id = 'rej_reason_error_'+ rid;
                if(null != document.getElementById("rej_reason_" + rid )){
                    var rej_r = document.getElementById("rej_reason_" + rid ).value;
                    if(null == rej_r || '' == rej_r) {
                        rr.innerHTML = "<textarea class= \"form-control\" placeholder=\"Enter Reason\" id= \"" + rr_id + "\" name = \"" + rr_id + "\" rows=\"1\" required></textarea><span style=\"font-size: x-small;color: darkred;\" id=\"" + rr_e_id + "\">Enter Reason.</span>";
                    }else if((null != rej_r || '' != rej_r) && (null != document.getElementById(rr_e_id))){
                        document.getElementById(rr_e_id).innerHTML = '';
                    }else{
                        if( null != document.getElementById("rr_e_id")){
                            document.getElementById(rr_e_id).style.display = "none";
                            document.getElementById(rr_e_id).innerHTML = '';
                        }
                    }
                }
            }
        }
    });

    $(".approve").click(function (e) {
        e.preventDefault();
        var index = this.id.split("_")[1];
        //  alert(index);
        var x = document.getElementById("u_error_"+index);
        x.style.display = "none";
        var y = document.getElementById("pin_error_"+index);
        y.style.display = "none";
        var data_1 = "index="+index+"&approval_dept_cnt=" + document.getElementById("approval_dept_cnt").value + "&form_user_data_id=" + document.getElementById("form_user_data_id").value + "&app_dept=" + document.getElementById("approval_dept" + "_" + this.id.split("_")[1]).value + "&app_id=" + document.getElementById("approval_initials" + "_" + this.id.split("_")[1]).value + "&pin=" + document.getElementById("pin" + "_" + this.id.split("_")[1]).value;
        // alert(data_1);
        $.ajax({
            type: "POST",
            context: this,
            url: "approve_store_backend.php",
            data: data_1,
            //  cache: false,
            success: function (response) {
                // button manipulation here
                var arr_data = JSON.parse(response);
                if(arr_data["error_type"] === "user_error"){
                    var id = "u_error_"+ arr_data["err_row"];
                    var x = document.getElementById(id);
                    if (x.style.display === "none") {
                        x.style.display = "block";
                    }
                }else if (arr_data["error_type"] === "pin_error"){
                    var id = "pin_error_"+ arr_data["err_row"];
                    var x = document.getElementById(id);
                    if (x.style.display === "none") {
                        x.style.display = "block";
                    }
                }else if (arr_data["all_dept_approved"] == 1) {
                    $('#' + this.id).attr('disabled', 'disabled').addClass('<i class="fa fa-times" aria-hidden="true"></i>').css({'background-color': '#43a047'});
                    $('#pin_'+this.id.split("_")[1]).attr('disabled', 'disabled');
                    // $('#reject_'+this.id.split("_")[1]).attr('disabled', 'disabled');
                    $('#reject_'+this.id.split("_")[1]).css('display', 'none');
                    $('#approval_initials_'+this.id.split("_")[1]).attr('disabled', 'disabled');
                    $('#btnSubmit_1').removeAttr('disabled');
                }else if(arr_data["all_dept_approved"] == 0){
                    $('#' + this.id).attr('disabled', 'disabled').addClass('<i class="fa fa-times" aria-hidden="true"></i>').css({'background-color': '#43a047'});
                    $('#pin_'+this.id.split("_")[1]).attr('disabled', 'disabled');
                    $('#reject_'+this.id.split("_")[1]).css('display', 'none');
                    $('#approval_initials_'+this.id.split("_")[1]).attr('disabled', 'disabled');
                }
            },
        });
    });
    $(".reject").click(function (e) {
        e.preventDefault();
        var index = this.id.split("_")[1];
        var x = document.getElementById("u_error_"+index);
        x.style.display = "none";
        var y = document.getElementById("pin_error_"+index);
        y.style.display = "none";
        var z = document.getElementById("rej_reason_div_"+index);
        if (z.style.display === "none") {
            z.style.display = "block";
            //<td class="form_tab_td" colspan="4">
            //        <textarea class="form-control" placeholder="Enter Reject Reason..." oninvalid="this.setCustomValidity('Enter Reject reason')"
            //    onvalid="this.setCustomValidity('')" id="rej_reason_<?php //echo $j ?>//" name = "rej_reason_<?php //echo $j ?>//" rows="1"></textarea>
            //        </td>
            var y = document.getElementById("rej_reason_td_"+index);
            var rr_id = 'rej_reason_'+index;
            y.innerHTML += "<textarea class= \"form-control\" placeholder=\"Enter Reason\" id= \"" +  rr_id + "\" name = \"" +  rr_id + "\" rows=\"1\" required></textarea>";
        }

        // if(document.getElementById("rej_reason_"+index).value){
        var data_1 = "index="+index+"&rejected_dept_cnt=" + document.getElementById("rejected_dept_cnt").value + "&form_user_data_id=" + document.getElementById("form_user_data_id").value + "&app_dept=" + document.getElementById("approval_dept" + "_" + this.id.split("_")[1]).value + "&app_id=" + document.getElementById("approval_initials" + "_" + this.id.split("_")[1]).value + "&pin=" + document.getElementById("pin" + "_" + this.id.split("_")[1]).value ;
        $.ajax({
            type: "POST",
            context: this,
            url: "reject_store_backend.php",
            data: data_1,
            //  cache: false,
            success: function (response) {
                // button manipulation here
                var arr_data = JSON.parse(response);
                if(arr_data["error_type"] === "user_error"){
                    var id = "u_error_"+ arr_data["err_row"];
                    var x = document.getElementById(id);
                    if (x.style.display === "none") {
                        x.style.display = "block";
                    }
                }else if (arr_data["error_type"] === "pin_error"){
                    var id = "pin_error_"+ arr_data["err_row"];
                    var x = document.getElementById(id);
                    if (x.style.display === "none") {
                        x.style.display = "block";
                    }
                }else if(arr_data["all_dept_rejected"] == 1) {
                    $('#' + this.id).attr('disabled', 'disabled').addClass('<i class="fa fa-times" aria-hidden="true"></i>').css({'background-color': '#d84315'});
                    $('#rej_reason_div_'+this.id.split("_")[1]).attr('disabled', 'disabled');

                    $('#pin_'+this.id.split("_")[1]).attr('disabled', 'disabled');
                    // $('#approve_'+this.id.split("_")[1]).attr('disabled', 'disabled');
                    $('#approve_'+this.id.split("_")[1]).css('display', 'none');

                    $('#approval_initials_'+this.id.split("_")[1]).attr('disabled', 'disabled');
                    $('#btnSubmit_1').removeAttr('disabled');
                }else if(arr_data["all_dept_rejected"] == 0){
                    $('#' + this.id).attr('disabled', 'disabled').addClass('<i class="fa fa-times" aria-hidden="true"></i>').css({'background-color': '#d84315'});
                    $('#rej_reason_div_'+this.id.split("_")[1]).attr('disabled', 'disabled');

                    $('#pin_'+this.id.split("_")[1]).attr('disabled', 'disabled');
                    $('#approve_'+this.id.split("_")[1]).css('display', 'none');
                    $('#approval_initials_'+this.id.split("_")[1]).attr('disabled', 'disabled');
                    // $('#btnSubmit_1').removeAttr('disabled');
                }
            },
        });
    });
</script>
<script>
    $(".text_num").keyup(function () {

        var bypass_approve = $("#bypass_approve").val();
        if (bypass_approve == 'yes') {
            document.getElementById("app_list").style.display = "none"
            document.getElementById("sub_app").style.display = "none"
           // $('#success_msg_app').text('Form submitted Successfully').css('background-color', '#0080004f');
        }
    });
</script>
<script>
    $(".compare_text").keyup(function () {
        var text_id = $(this).attr("id");
        var lower_compare = parseFloat($(".lower_compare[data-id='" + text_id + "']").val());
        var upper_compare = parseFloat($(".upper_compare[data-id='" + text_id + "']").val());
        var text_val = $(this).val();
        var bypass_approve = $("#bypass_approve").val();
        if ($(".compare_text").val().length == 0) {
            $(this).attr('style','background-color:white !important');
            return false;
        } else {
            if ($.isNumeric(text_val)) {

                if (text_val >= lower_compare && text_val <= upper_compare) {
                    $(this).attr('style','background-color:#abf3ab !important');
                    if (bypass_approve == 'yes') {
                        document.getElementById("app_list").style.display = "none"
                        document.getElementById("sub_app").style.display = "none"
                        $('#success_msg_app').text('Form submitted Successfully').css('background-color', '#0080004f');
                    }
                    document.getElementById("notes").required = false;
                    document.getElementsByClassName("reason").style.display = "none";
                } else {
                    $(this).attr('style','background-color:#ffadad !important');
                    document.getElementById("app_list").style.display = "block"
                    document.getElementById("sub_app").style.display = "block"
                    document.getElementById("notes").required = true;
                    document.getElementsByClassName("reason").style.display = "block";
                }
            }
        }
    });
    $('form').attr('autocomplete', 'off');
    $('input').attr('autocomplete', 'off');
    $("input:radio").click(function () {
        var radio_id = $(this).attr("name");
        var binary_compare = $(".binary_compare[data-id='" + radio_id + "']").val();
        var exact_val = $('input[name="' + radio_id + '"]:checked').val();
        var bypass_approve = $("#bypass_approve").val();
        var list_value = $(".list_enabled[data-id='" + radio_id + "']").val();

        if (exact_val == binary_compare) {
            if (list_value != '0') {
                if (exact_val != 'none'){
                    $("." + radio_id).css("background-color", "#abf3ab");
                }
            }else {
                $("." + radio_id).css("background-color", "#FFF");
            }
            if (bypass_approve == 'yes' || exact_val == 'none'){
                document.getElementById("app_list").style.display = "none";
                document.getElementById("sub_app").style.display = "none";
                // $('#success_msg_app').text('Form submitted Successfully').css('background-color', '#0080004f');
            }
            document.getElementById("notes").required = false;
        } else {
            if (list_value != '0') {
                if (exact_val != 'none') {
                    $("." + radio_id).css("background-color", "#ffadad");
                }else{
                    $("." + radio_id).css("background-color", "#FFF");
                }
            }
            else {

                $("." + radio_id).css("background-color", "#FFF");
            }
            if (bypass_approve == 'yes' || exact_val == 'none'){
                if(list_value == null){
                    document.getElementById("notes").required = true;
                }else{
                    document.getElementById("app_list").style.display = "none";
                    document.getElementById("sub_app").style.display = "none";
                }
                // $('#success_msg_app').text('Form submitted Successfully').css('background-color', '#0080004f');
            }else{
                if ((list_value != '0') || (list_value == null)) {
                    document.getElementById("notes").required = true;
                }
                document.getElementById("app_list").style.display = "block"
                document.getElementById("sub_app").style.display = "block"

            }
        }
    });
</script>

<?php include('../footer.php') ?>
</body>
</html>