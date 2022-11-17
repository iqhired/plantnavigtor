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
	//Unset the session variablesc

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
$i = $_SESSION["role_id"];
if ($i != "super" && $i != "admin" && $i != "pn_user" && $_SESSION['is_tab_user'] != 1 && $_SESSION['is_cell_login'] != 1 ) {
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
		<?php echo $sitename; ?> | View Form</title>
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
    <script type="text/javascript" src="../assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="../assets/js/core/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="../assets/js/core/libraries/bootstrap.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->
    <!-- Theme JS files -->
    <script type="text/javascript" src="../assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="../assets/js/core/libraries/jquery_ui/interactions.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/media/fancybox.min.js"></script>
    <script type="text/javascript" src="../assets/js/core/app.js"></script>
    <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_select2.js"></script>
    <script type="text/javascript" src="../assets/js/pages/gallery.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=WindSong&display=swap');

        .signature {

            font-family: 'WindSong', swap;
            font-size: 25px;
            font-weight: 600;
        }


        .pn_none {
            pointer-events: none;
            color: #050505;
        }
        .form_table_mobile {
            display: none;
        }
        @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
            .col-lg-2{
                width: 35%!important;
            }
            .content:first-child {
                padding-top: 90px!important;
            }
            .col-md-8.form_col_item {
                float: left;
                width: 100%;
                padding-bottom: 10px;
            }
            .border-primary {
                border-color: #ffffff;
            }
            .form_table_mobile {
                display: block;
            }
            table.form_table {
                display: none;
            }
            .form_table_mobile {
                width: 100%;
                background-color: #eee;
                margin-top: 12px;
            }
            .form_table_mobile {
                width: 100%;
                background-color: #eee;
                margin-top: 12px;
            }
            .form_row_mobile {
                width: 100%;
                height: auto;
            }
            .col-lg-8.mobile {
                width: 58%;
                float: right;
                padding: 10px 30px 10px 26px;
            }
            label.col-lg-3.control-label.mobile {
                width: 42%;
                float: left;
                padding: 10px 30px 10px 26px;
            }
            .col-md-2 {
                width: 50%;
                float: left;
            }


        }

    </style>
</head>
<body>
<!-- Main navbar -->
<?php
$cam_page_header = "View Form";
include("../header.php");
if ($is_tab_login || ($_SESSION["role_id"] == "pn_user")) {
    include("../tab_menu.php");
} else {
    include("../admin_menu.php");
}
?>
<!-- /main navbar -->
<!-- Page container -->
<div class="page-container">

        <div class="content">

			<?php
			$id = $_GET['id'];

			$querymain = sprintf("SELECT * FROM `form_user_data` where form_user_data_id = '$id' ");
			$qurmain = mysqli_query($db, $querymain);

			while ($rowcmain = mysqli_fetch_array($qurmain)) {
				$formname = $rowcmain['form_name'];
				$form_create_id = $rowcmain['form_create_id'];

				?>
                <div class="panel panel-flat form_panel">
                    <div class="panel-heading form_panel_heading">
                        <h5 class="panel-title form_panel_title"><?php echo $rowcmain['form_name']; ?></h5>
                        <div class="row ">
                            <div class="col-md-12">
                                <form action="user_form_backend.php" id="form_settings" enctype="multipart/form-data" class="form-horizontal" method="post">
                                    <input type="hidden" name="name" id="name" value="<?php echo $rowcmain['form_name']; ?>">

                                    <div class="form_row row">
                                        <label class="col-lg-2 control-label">Form Type : </label>
                                        <div class="col-md-6">
											<?php
											$get_form_type = $rowcmain['form_type'];
											if($get_form_type != ''){	$disabled = 'disabled';	}else{$disabled = '';}
											?>

                                            <input type="hidden" name="form_type" id="form_type" value="<?php echo $get_form_type; ?>">
                                            <select name="form_type1" id="form_type" class="select-border-color" <?php echo $disabled; ?>>
                                                <option value="" selected disabled>--- Select Form Type ---</option>
												<?php

												$sql1 = "SELECT * FROM `form_type` ";
												$result1 = $mysqli->query($sql1);
												// $entry = 'selected';
												while ($row1 = $result1->fetch_assoc()) {
													if($get_form_type == $row1['form_type_id'])
													{
														$entry = 'selected';
													}
													else
													{
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
                                        <label class="col-lg-2 control-label">Station : </label>
                                        <div class="col-md-6">

											<?php
											$get_station = $rowcmain['station'];
											if($get_station != ''){	$disabled = 'disabled';	}else{$disabled = '';}
											?>

                                            <input type="hidden" name="station" id="station" value="<?php echo $get_station; ?>">
                                            <select name="station1" id="station1" class="select-border-color" <?php echo $disabled; ?>>
                                                <option value="" selected disabled>--- Select Station ---</option>
												<?php
												$sql1 = "SELECT * FROM `cam_line` where enabled = '1' ORDER BY `line_name` ASC ";
												$result1 = $mysqli->query($sql1);
												//                                            $entry = 'selected';
												while ($row1 = $result1->fetch_assoc()) {
													if($get_station == $row1['line_id'])
													{
														$entry = 'selected';
													}
													else
													{
														$entry = '';
													}
													echo "<option value='" . $row1['line_id'] . "' $entry >" . $row1['line_name'] . "</option>";
												}
												?>
                                            </select>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="form_row row">
                                        <label class="col-lg-2 control-label">Part Family : </label>
                                        <div class="col-md-6">

											<?php
											$get_part_family = $rowcmain['part_family'];
											if($get_part_family != ''){	$disabled = 'disabled';	}else{$disabled = '';}
											?>

                                            <input type="hidden" name="part_family" id="part_family" value="<?php echo $get_part_family; ?>">
                                            <select name="part_family1" id="part_family1" class="select-border-color" <?php echo $disabled; ?>>
                                                <option value="" selected disabled>--- Select Part Family ---</option>
												<?php
												$sql1 = "SELECT * FROM `pm_part_family` ";
												$result1 = $mysqli->query($sql1);
												//                                            $entry = 'selected';
												while ($row1 = $result1->fetch_assoc()) {
													if($get_part_family == $row1['pm_part_family_id'])
													{
														$entry = 'selected';
													}
													else
													{
														$entry = '';
													}
													echo "<option value='" . $row1['pm_part_family_id'] . "' $entry >" . $row1['part_family_name'] . "</option>";
												}
												?>
                                            </select>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="form_row row">
                                        <label class="col-lg-2 control-label">Part Number : </label>
                                        <div class="col-md-6">

											<?php
											$get_part_number = $rowcmain['part_number'];
											if($get_part_number != ''){	$disabled = 'disabled';	}else{$disabled = '';}
											?>

                                            <input type="hidden" name="part_number" id="part_number" value="<?php echo $get_part_number; ?>">
                                            <select name="part_number1" id="part_number1" class="select-border-color" <?php echo $disabled; ?>>
                                                <option value="" selected disabled>--- Select Part Number ---</option>
												<?php
												$sql1 = "SELECT * FROM `pm_part_number` ";
												$result1 = $mysqli->query($sql1);
												//                                            $entry = 'selected';
												while ($row1 = $result1->fetch_assoc()) {
													if($get_part_number == $row1['pm_part_number_id'])
													{
														$entry = 'selected';
													}
													else
													{
														$entry = '';
													}
													echo "<option value='" . $row1['pm_part_number_id'] . "' $entry >" . $row1['part_number'] ." - ".$row1['part_name']  . "</option>";
												}
												?>
                                            </select>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="form_row row">
                                        <label class="col-lg-2 control-label">Operator : </label>
                                        <div class="col-md-6">

											<?php
											$createdby = $rowcmain['created_by'];
											$qur04 = mysqli_query($db, "SELECT firstname,lastname,pin FROM  cam_users where users_id = '$createdby' ");
											$rowc04 = mysqli_fetch_array($qur04);
											$fullnnm = $rowc04["firstname"]." ".$rowc04["lastname"];
											$pin = $rowc04["pin"];

											?>

                                            <input type="text" name="createdby" class="form-control" id="createdby" value="<?php echo $fullnnm; ?>" disabled>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="form_row row">

										<?php


//										$query1 = sprintf("SELECT form_create_id FROM  form_create where form_type = '$get_form_type' and station = '$get_station' and part_family = '$get_part_family' and part_number = '$get_part_number' and name = '$formname'");
//										$qur1 = mysqli_query($db, $query1);
//										$rowc1 = mysqli_fetch_array($qur1);
//										$item_id = $rowc1['form_create_id'];
										$item_id = $form_create_id;

										$qurimage = mysqli_query($db, "SELECT * FROM  form_images where form_create_id = '$item_id'");
										while ($rowcimage = mysqli_fetch_array($qurimage)) {


											?>

                                            <div class="col-lg-3 col-sm-6">
                                                <div class="thumbnail">
                                                    <div class="thumb">
                                                        <img src="../form_images/<?php echo $rowcimage['image_name']; ?>" alt="">
                                                        <div class="caption-overflow">
														<span>
															<a href="../form_images/<?php echo $rowcimage['image_name']; ?>" data-popup="lightbox" rel="gallery" class="btn border-white text-white btn-flat btn-icon btn-rounded"><i class="icon-plus3"></i></a>

														</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
										<?php } ?>
                                    </div>
                                    <br/>
                                    <b><h4 class="panel-title form_panel_title">Form Information</h4></b>
									<?php

									$query = sprintf("SELECT * FROM  form_item where form_create_id = '$item_id'  order by form_item_seq+0 ASC ");
									$qur = mysqli_query($db, $query);
									$aray_item_cnt = 0;
									$arrteam = explode(',', $rowcmain["form_user_data_item"]);
									while ($rowc = mysqli_fetch_array($qur)) {
										$expVal = $arrteam[$aray_item_cnt];
										$ccnt = substr_count ($expVal, '~');
										if($ccnt > 0){
											$itemVal = explode('~',  $expVal)[1];
										}else{
											$itemVal = explode('~',  $expVal)[0];
										}
										$item_val = $rowc['item_val'];

										if($item_val == "header"){

											?>
                                            <div class="form_row_item row">
                                                <h4 class="panel-title "><b><u><?php echo htmlspecialchars($rowc['item_desc']); ?></u></b></h4>
                                            </div>
										<?php }
										if($item_val == "numeric")
										{
											$checked = $itemVal;


											$numeric_normal = $rowc['numeric_normal'];
											$numeric_lower_tol1 = $rowc['numeric_lower_tol'];
											$numeric_upper_tol1 = $rowc['numeric_upper_tol'];

											$numeric_lower_tol1 = str_replace(' ', '', $numeric_lower_tol1); // Replaces all spaces with hyphens.
											$numeric_lower_tol1 = preg_replace('/[^A-Za-z0-9]/', '', $numeric_lower_tol1); // Removes special chars.
											$final_lower = $numeric_normal - $numeric_lower_tol1; // final lower value

											$numeric_upper_tol1 = str_replace(' ', '', $numeric_upper_tol1); // Replaces all spaces with hyphens.
											$numeric_upper_tol1 = preg_replace('/[^A-Za-z0-9]/', '', $numeric_upper_tol1); // Removes special chars.
											$final_upper = $numeric_normal + $numeric_upper_tol1; // final upper value

											//echo $final_upper;



											?>
                                            <input type="hidden" data-id="<?php echo $rowc['form_item_id']; ?>"
                                                   class="lower_compare" value="<?php echo $final_lower; ?>">
                                            <input type="hidden" data-id="<?php echo $rowc['form_item_id']; ?>"
                                                   class="upper_compare" value="<?php echo $final_upper; ?>">
                                            <div class="form_row_item row">
                                                   <div class="col-md-8" >
                                                 <label class=" form_col_item"><?php  if ($rowc['optional'] != '1') {
                                                        echo '<span class="red-star">★</span>';
                                                    }echo $rowc['item_desc']; ?> </label>
												<?php if (isset($rowc['discription']) && ($rowc['discription'] != '')) { ?>
                                                   <?php echo "(" . $rowc['discription'] . ")" ?>
												<?php } ?>
                                                   </div>

												<?php if ($checked >= $final_lower && $checked <= $final_upper) { ?>
                                                    <div class="col-md-2">
                                                        <input type="number" name="<?php echo $rowc['form_item_id']; ?>"
                                                               id="<?php echo $rowc['form_item_id']; ?>"
                                                               class="form-control compare_text pn_none" required step="any"
                                                               value="<?php echo $itemVal; ?>"  disabled>
                                                    </div>
												<?php } else { ?>
                                                    <div class="col-md-2">
                                                        <input type="number" name="<?php echo $rowc['form_item_id']; ?>"
                                                               id="<?php echo $rowc['form_item_id']; ?>"
                                                               class="form-control compare_text pn_none" required step="any"
                                                               value="<?php echo $itemVal; ?>"  style="background-color: #ffadad" disabled>
                                                    </div>
												<?php } ?>


													<?php
													$unit_of_measurement_id = $rowc['unit_of_measurement'];
													$sql1 = "SELECT unit_of_measurement FROM `form_measurement_unit` where form_measurement_unit_id = '$unit_of_measurement_id'";
													$result1 = $mysqli->query($sql1);
													$row1 = $result1->fetch_assoc();
													echo $row1['unit_of_measurement'];
													?>



                                                <input type="hidden"  name="form_item_array[]" value="<?php echo $rowc['form_item_id']; ?>">
                                            </div><br/>
											<?php
											$aray_item_cnt++;
										}
										if($item_val == "binary"){
											$checked = $itemVal;
											?>
                                            <div class="form_row_item row">
                                                <div class="col-md-8 form_col_item">
													<?php if ($rowc['optional'] != '1') {
														echo '<span class="red-star">★</span>';
													}
													echo htmlspecialchars($rowc['item_desc']); ?>
                                                </div>

                                                <input type="hidden"  name="form_item_array[]" value="<?php echo $rowc['form_item_id']; ?>">
                                                <div class="col-md-4">
                                                    <div class="form-check form-check-inline">

														<?php
														if ($checked == "yes") {
															?>

                                                            <input type="radio" id="yes" name="<?php echo $rowc['form_item_id']; ?>"
                                                                   value="<?php echo $rowc['binary_yes_alias']; ?>"
                                                                   class="form-check-input pn_none" checked disabled >
                                                            <label for="yes"
                                                                   class="pn_none item_label <?php echo $rowc['form_item_id']; ?>"
                                                                   id="<?php echo $rowc['form_item_id']; ?>"><?php $yes_alias = $rowc['binary_yes_alias'];
																echo (($yes_alias != null) || ($yes_alias != '')) ? $yes_alias : "Yes" ?></label>
                                                            <!--															<label for="yes" class="item_label" style="background-color: green;">--><?php //echo $rowc['binary_yes_alias'];
															?><!--</label>-->
                                                            <input type="radio" id="no" name="<?php echo $rowc['form_item_id']; ?>"
                                                                   value="<?php echo $rowc['binary_no_alias']; ?>"
                                                                   class="form-check-input pn_none" disabled >
                                                            <label for="no"
                                                                   class="pn_none item_label <?php echo $rowc['form_item_id']; ?>"
                                                                   id="<?php echo $rowc['form_item_id']; ?>"><?php $no_alias = $rowc['binary_no_alias'];
																echo (($no_alias != null) || ($no_alias != '')) ? $no_alias : "No" ?></label>
                                                            <!--															<label for="no" class="item_label"  style="background-color: green;">--><?php //echo $rowc['binary_no_alias'];
															?><!--</label>-->


															<?php
														} else { ?>

                                                            <input type="radio" id="yes" name="<?php echo $rowc['form_item_id']; ?>"
                                                                   value="<?php echo $rowc['binary_yes_alias']; ?>"
                                                                   class="form-check-input pn_none" disabled >
                                                            <label for="yes" class="item_label" style="background-color: #ffadad;"
                                                                   style="background-color: #ffadad;"><?php echo $rowc['binary_yes_alias']; ?></label>
                                                            <input type="radio" id="no" name="<?php echo $rowc['form_item_id']; ?>"
                                                                   value="<?php echo $rowc['binary_no_alias']; ?>"
                                                                   class="form-check-input pn_none" checked disabled >
                                                            <label for="no" class="item_label" style="background-color: #ffadad;"
                                                                   style="background-color: #ffadad;"><?php echo $rowc['binary_no_alias']; ?></label>

														<?php }
														?>
														<?php if ($rowc['optional'] == '1') {
															echo '<span style="color: #a1a1a1; font-size: small;padding-top: 15px;padding-left:15px;">(Optional)</span>';
														} ?>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="form_row_item row">
                                                <div class="col-md-8 form_col_item"><u><b><?php echo $rowc['discription']; ?> </b></u></div>

                                            </div>
                                            <br/>
											<?php
											$aray_item_cnt++;

										}
                                        if($item_val == "list"){
                                            $checked = $itemVal;
                                            ?>
                                            <div class="form_row_item row">
                                                <div class="col-md-8 form_col_item">
                                                    <?php if ($rowc['optional'] != '1') {
                                                        echo '<span class="red-star">★</span>';
                                                    }
                                                    echo htmlspecialchars($rowc['item_desc']); ?>
                                                </div>

                                                <input type="hidden"  name="form_item_array[]" value="<?php echo $rowc['form_item_id']; ?>">
                                                <div class="col-md-4">
                                                    <div class="form-check form-check-inline">

                                                        <?php
                                                        if (($checked == "yes") ) {
                                                            ?>

                                                            <input type="radio" id="yes" name="<?php echo $rowc['form_item_id']; ?>"
                                                                   value="<?php echo $rowc['list_name2']; ?>"
                                                                   class="form-check-input pn_none" checked disabled >
                                                            <label for="yes"
                                                                   class="pn_none item_label <?php echo $rowc['form_item_id']; ?>"
                                                                   id="<?php echo $rowc['form_item_id']; ?>"><?php $yes_alias = $rowc['list_name2'];
                                                                echo (($yes_alias != null) || ($yes_alias != '')) ? $yes_alias : "Yes" ?></label>

                                                            <input type="radio" id="no" name="<?php echo $rowc['form_item_id']; ?>"
                                                                   value="<?php echo $rowc['list_name3']; ?>"
                                                                   class="form-check-input pn_none" disabled >
                                                             <label for="no"
                                                                   class="pn_none item_label <?php echo $rowc['form_item_id']; ?>"
                                                                   id="<?php echo $rowc['form_item_id']; ?>"><?php $no_alias = $rowc['list_name3'];
                                                                echo (($no_alias != null) || ($no_alias != '')) ? $no_alias : "No" ?></label>

                                                            <?php if (empty($rowc['list_name1'])){ ?>
                                                                 <input type="radio" id="none" name="<?php echo $rowc['form_item_id']; ?>"
                                                                   value="<?php echo $rowc['list_name1']; ?>"
                                                                   class="form-check-input pn_none" disabled style="display: none">
                                                             <label for="none"
                                                                   class="pn_none item_label <?php echo $rowc['form_item_id']; ?>"
                                                                   id="<?php echo $rowc['form_item_id']; ?>" ></label>
                                                            <?php } else { ?>
                                                                <input type="radio" id="none" name="<?php echo $rowc['form_item_id']; ?>"
                                                                       value="<?php echo $rowc['list_name1']; ?>"
                                                                       class="form-check-input pn_none" disabled >
                                                                <label for="none"
                                                                       class="pn_none item_label <?php echo $rowc['form_item_id']; ?>"
                                                                       id="<?php echo $rowc['form_item_id']; ?>"><?php $yes_alias = $rowc['list_name1'];
                                                                    echo (($yes_alias != null) || ($yes_alias != '')) ? $yes_alias : "None" ?></label>
                                                            <?php } ?>
                                                            <?php $list_extra =  $rowc['list_name_extra'];
                                                            if(!empty($list_extra)){
																$arrteam_list = explode(',', $list_extra);
																$radiocount = 1;
																foreach ($arrteam_list as $arr_list) { ?>

                                                                    <input type="radio" id="extra" name="<?php echo $rowc['form_item_id']; ?>"
                                                                           value="<?php echo $arr_list; ?>"
                                                                           class="form-check-input pn_none" disabled >
                                                                    <label for="none"
                                                                           class="pn_none item_label <?php echo $rowc['form_item_id']; ?>"
                                                                           id="<?php echo $rowc['form_item_id']; ?>"><?php $extra_alias = $arr_list;
																		echo (($extra_alias != null) || ($extra_alias != '')) ? $extra_alias : "Extra" ?></label>
																	<?php  $radiocount++; }
															}
                                                            ?>

                                                            <?php
                                                        }  else if (($checked == "no") ) { ?>

                                                            <input type="radio" id="yes" name="<?php echo $rowc['form_item_id']; ?>"
                                                                   value="<?php echo $rowc['list_name2']; ?>"
                                                                   class="form-check-input pn_none" disabled >
                                                            <label for="yes" class="item_label"
                                                                <?php if($rowc['list_enabled'] ==1 ){ echo 'style="background-color: #ffadad;"';}else{echo 'style="background-color: #fff;"';}?>><?php echo $rowc['list_name2']; ?></label>

                                                            <input type="radio" id="no" name="<?php echo $rowc['form_item_id']; ?>"
                                                                   value="<?php echo $rowc['list_name3']; ?>"
                                                                   class="form-check-input pn_none" checked disabled >
                                                            <label for="no" class="item_label" <?php if($rowc['list_enabled'] ==1 ){ echo 'style="background-color: #ffadad;"';}else{echo 'style="background-color: #fff;"';}?>><?php echo $rowc['list_name3']; ?></label>

                                                            <?php if (empty($rowc['list_name1'])){ ?>
                                                                <input type="radio" id="none" name="<?php echo $rowc['form_item_id']; ?>"
                                                                       value="<?php echo $rowc['list_name1']; ?>"
                                                                       class="form-check-input pn_none" disabled style="display: none">
                                                                <label for="none"
                                                                       class="pn_none item_label <?php echo $rowc['form_item_id']; ?>"
                                                                       id="<?php echo $rowc['form_item_id']; ?>" <?php if($rowc['list_enabled'] ==1 ){ echo 'style="background-color: #ffadad;"';}else{echo 'style="background-color: #fff;"';}?>></label>
                                                            <?php } else { ?>
                                                                <input type="radio" id="none" name="<?php echo $rowc['form_item_id']; ?>"
                                                                       value="<?php echo $rowc['list_name1']; ?>"
                                                                       class="form-check-input pn_none" disabled >
                                                                <label for="none"
                                                                       class="pn_none item_label <?php echo $rowc['form_item_id']; ?>"
                                                                       id="<?php echo $rowc['form_item_id']; ?>" <?php if($rowc['list_enabled'] ==1 ){ echo 'style="background-color: #ffadad;"';}else{echo 'style="background-color: #fff;"';}?>><?php $yes_alias = $rowc['list_name1'];
                                                                    echo (($yes_alias != null) || ($yes_alias != '')) ? $yes_alias : "None" ?></label>
                                                            <?php } ?>
                                                            <?php $list_extra =  $rowc['list_name_extra'];
                                                            if(!empty($list_extra)){
																$arrteam_list = explode(',', $list_extra);
																$radiocount = 1;
																foreach ($arrteam_list as $arr_list) { ?>

                                                                    <input type="radio" id="extra" name="<?php echo $rowc['form_item_id']; ?>"
                                                                           value="<?php echo $arr_list; ?>"
                                                                           class="form-check-input pn_none" disabled>
                                                                    <label for="none"
                                                                           class="pn_none item_label <?php echo $rowc['form_item_id']; ?>"
                                                                           id="<?php echo $rowc['form_item_id']; ?>" <?php if($rowc['list_enabled'] ==1 ){ echo 'style="background-color: #ffadad;"';}else{echo 'style="background-color: #fff;"';}?>><?php $extra_alias = $arr_list;
																		echo (($extra_alias != null) || ($extra_alias != '')) ? $extra_alias : "Extra" ?></label>
																	<?php  $radiocount++; }
                                                            }
                                                             ?>

                                                        <?php }  else if (($checked == "none") ){ ?>

                                                            <input type="radio" id="yes" name="<?php echo $rowc['form_item_id']; ?>"
                                                                   value="<?php echo $rowc['list_name2']; ?>"
                                                                   class="form-check-input pn_none" disabled >
                                                            <label for="yes" class="item_label"><?php echo $rowc['list_name2']; ?></label>
                                                            <input type="radio" id="no" name="<?php echo $rowc['form_item_id']; ?>"
                                                                   value="<?php echo $rowc['list_name3']; ?>"
                                                                   class="form-check-input pn_none"  disabled >
                                                            <label for="no" class="item_label"><?php echo $rowc['list_name3']; ?></label>

                                                            <input type="radio" id="none" name="<?php echo $rowc['form_item_id']; ?>"
                                                                   value="<?php echo $rowc['list_name1']; ?>"
                                                                   class="form-check-input pn_none" checked disabled >
                                                            <label for="none" class="item_label"><?php echo $rowc['list_name1']; ?></label>

                                                            <?php if (empty($rowc['list_name1'])){ ?>
                                                                <input type="radio" id="none" name="<?php echo $rowc['form_item_id']; ?>"
                                                                       value="<?php echo $rowc['list_name1']; ?>"
                                                                       class="form-check-input pn_none" disabled style="display: none">
                                                                <label for="none"
                                                                       class="pn_none item_label <?php echo $rowc['form_item_id']; ?>"
                                                                       id="<?php echo $rowc['form_item_id']; ?>" ></label>
                                                            <?php } else { ?>
                                                                <input type="radio" id="none" name="<?php echo $rowc['form_item_id']; ?>"
                                                                       value="<?php echo $rowc['list_name1']; ?>"
                                                                       class="form-check-input pn_none" disabled >
                                                                <label for="none"
                                                                       class="pn_none item_label <?php echo $rowc['form_item_id']; ?>"
                                                                       id="<?php echo $rowc['form_item_id']; ?>"><?php $yes_alias = $rowc['list_name1'];
                                                                    echo (($yes_alias != null) || ($yes_alias != '')) ? $yes_alias : "None" ?></label>
                                                            <?php } ?>

                                                            <?php $list_extra =  $rowc['list_name_extra'];
															if(!empty($list_extra)){
																$arrteam_list = explode(',', $list_extra);
																$radiocount = 1;
																foreach ($arrteam_list as $arr_list) { ?>

                                                                    <input type="radio" id="extra" name="<?php echo $rowc['form_item_id']; ?>"
                                                                           value="extra_<?php echo $radiocount; ?>"
                                                                           class="form-check-input pn_none" disabled >
                                                                    <label for="none"
                                                                           class="pn_none item_label <?php echo $rowc['form_item_id']; ?>"
                                                                           id="<?php echo $rowc['form_item_id']; ?>" <?php if($rowc['list_enabled'] == 1 ){ echo 'style="background-color: #ffadad;"';}else{echo 'style="background-color: #fff;"';}?>><?php $extra_alias = $arr_list;
																		echo (($extra_alias != null) || ($extra_alias != '')) ? $extra_alias : "Extra" ?></label>
																	<?php  $radiocount++; }
															}
                                                             ?>

                                                        <?php } else { ?>

                                                            <input type="radio" id="yes" name="<?php echo $rowc['form_item_id']; ?>"
                                                                   value="<?php echo $rowc['list_name2']; ?>"
                                                                   class="form-check-input pn_none" disabled >
                                                            <label for="yes" class="item_label"
                                                                <?php if($rowc['list_enabled'] ==1  ){ echo 'style="background-color: #ffadad;"';}else{echo 'style="background-color: #fff!important;"';}?>><?php echo $rowc['list_name2']; ?></label>
                                                            <input type="radio" id="no" name="<?php echo $rowc['form_item_id']; ?>"
                                                                   value="<?php echo $rowc['list_name3']; ?>"
                                                                   class="form-check-input pn_none"  disabled >
                                                            <label for="no" class="item_label"
                                                                <?php if($rowc['list_enabled'] ==1  ){ echo 'style="background-color: #ffadad;"';}else{echo 'style="background-color: #fff!important;"';}?>><?php echo $rowc['list_name3']; ?></label>

                                                            <?php if (empty($rowc['list_name1'])){ ?>
                                                                <input type="radio" id="none" name="<?php echo $rowc['form_item_id']; ?>"
                                                                       value="<?php echo $rowc['list_name1']; ?>"
                                                                       class="form-check-input pn_none" disabled style="display: none">
                                                                <label for="none"
                                                                       class="pn_none item_label <?php echo $rowc['form_item_id']; ?>"
                                                                       id="<?php echo $rowc['form_item_id']; ?>" ></label>
                                                            <?php } else { ?>
                                                                <input type="radio" id="none" name="<?php echo $rowc['form_item_id']; ?>"
                                                                       value="<?php echo $rowc['list_name1']; ?>"
                                                                       class="form-check-input pn_none" disabled >
                                                                <label for="none"
                                                                       class="pn_none item_label <?php echo $rowc['form_item_id']; ?>"
                                                                       id="<?php echo $rowc['form_item_id']; ?>"><?php $yes_alias = $rowc['list_name1'];
                                                                    echo (($yes_alias != null) || ($yes_alias != '')) ? $yes_alias : "None" ?></label>
                                                            <?php } ?>
                                                            <?php $list_extra =  $rowc['list_name_extra'];
															if(!empty($list_extra)){
																$arrteam_list = explode(',', $list_extra);
																$radiocount = 1;
																foreach ($arrteam_list as $arr_list) { ?>

                                                                    <input type="radio" id="extra" name="<?php echo $rowc['form_item_id']; ?>"
                                                                           value="<?php echo $arr_list;?>"
                                                                           class="form-check-input pn_none" <?php if($checked == "extra_$radiocount"){echo 'checked'; }?>  disabled >
                                                                    <label for="none"
                                                                           class="pn_none item_label <?php echo $rowc['form_item_id']; ?>"
                                                                           id="<?php echo $rowc['form_item_id']; ?>"><?php $extra_alias = $arr_list;
																		echo (($extra_alias != null) || ($extra_alias != '')) ? $extra_alias : "Extra" ?></label>
																	<?php  $radiocount++; }
															}
                                                            ?>
                                                        <?php } ?>
                                                        <?php if ($rowc['optional'] == '1') {
                                                            echo '<span style="color: #a1a1a1; font-size: small;padding-top: 15px;padding-left:15px;">(Optional)</span>';
                                                        } ?>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="form_row_item row">
                                                <div class="col-md-8 form_col_item"><u><b><?php echo $rowc['discription']; ?> </b></u></div>

                                            </div>
                                            <br/>
                                            <?php
                                            $aray_item_cnt++;
                                        }
										if($item_val == "text"){

											?>
                                            <div class="form_row_item row">
                                                <div class="col-md-8 form_col_item">
													<?php
													if ($rowc['optional'] != '1') {
														echo '<span class="red-star">★</span>';
													}
													echo htmlspecialchars($rowc['item_desc']); ?> </div>
                                                <div class="col-md-4">
                                                    <input type="hidden" name="form_item_array[]"
                                                           value="<?php echo $rowc['form_item_id']; ?>">
                                                    <input type="text" name="<?php echo $rowc['form_item_id']; ?>"
                                                           id="<?php echo $rowc['form_item_id']; ?>"
                                                           value="<?php echo $itemVal; ?>"
                                                           class="form-control pn_none" disabled></div>
                                                <div class="col-md-3 form_col_item">
                                                    <u><b><?php echo $rowc['discription']; ?> </b></u></div>

                                            </div><br/>
											<?php
											$aray_item_cnt++;

										}
									}
									?>

                                    <br/>
                                    <?php
                                    $qur05 = mysqli_query($db, "SELECT * FROM  form_approval where form_user_data_id = '$id' ");
                                    $rowc05 = mysqli_fetch_array($qur05);
                                    $app_in = $rowc05["approval_initials"];
                                    $passcd = $rowc05["passcode"];
                                    $datetime = $rowc05["created_at"];
                                    $date_time = strtotime($datetime);

                                    $approval_status = $rowc05["approval_status"];
                                    $reject_status = $rowc05["reject_status"];

                                    if (empty($approval_status) && empty($reject_status)){ ?>
                                        <b><h4 class="panel-title form_panel_title" style="background-color: #4caf507a;"> Auto Approved by System</h4></b>
                                    <?php }else{ ?>

                                        <b><h4 class="panel-title form_panel_title">Approval List</h4></b>
                                        <table class="form_table">
                                            <tr class="form_tab_tr">
                                                <th class="form_tab_th">Department</th>
                                                <th class="form_tab_th">Form Status</th>
                                                <th class="form_tab_th">Approver</th>
                                                <th class="form_tab_th">Approval/Rejection Time</th>
                                            </tr>


                                            <?php
                                            $query1 = sprintf("SELECT * FROM  form_create where form_create_id = '$item_id'");
                                            $qur1 = mysqli_query($db, $query1);
                                            $i = 0;
                                            while ($rowc1 = mysqli_fetch_array($qur1)) {
                                                $approval_dept_array = $rowcmain['approval_dept'];
                                                $approval_dept = explode(',', $approval_dept_array);
                                                $approval_initials_array = $rowcmain['approval_initials'];
                                                $approval_initials = explode(',', $approval_initials_array);
                                                $passcode_array = $rowcmain['passcode'];
                                                $passcode = explode(',', $passcode_array);
                                                $approval_by_array = $rowc1['approval_by'];
                                                $arrteam = explode(',', $approval_by_array);


                                                foreach ($arrteam as $arr) {
                                                    if ($arr != "") {
                                                        ?>
                                                        <tr class="form_tab_tr">
                                                            <!--								<div class="form_row_item row">-->
                                                            <?php
                                                            $qurtemp = mysqli_query($db, "SELECT group_name FROM `sg_group` where group_id = '$arr' ");
                                                            $rowctemp = mysqli_fetch_array($qurtemp);
                                                            $groupname = $rowctemp["group_name"];

                                                            $qur05 = mysqli_query($db, "SELECT * FROM  form_approval where approval_dept = '$arr' and form_user_data_id = '$id' ");
                                                            $rowc05 = mysqli_fetch_array($qur05);
                                                            $app_in = $rowc05["approval_initials"];
                                                            $passcd = $rowc05["passcode"];
                                                            $datetime = $rowc05["created_at"];
                                                            $date_time = strtotime($datetime);

                                                            $approval_status = $rowc05["approval_status"];
                                                            $reject_status = $rowc05["reject_status"];

                                                            if ($approval_status == '0' && $reject_status == '1') {
                                                                $form_status = "Rejected";
                                                            } else {
                                                                $form_status = "Approved";
                                                            }

                                                            $qur04 = mysqli_query($db, "SELECT firstname,lastname FROM  cam_users where users_id = '$app_in' ");
                                                            $rowc04 = mysqli_fetch_array($qur04);
                                                            $fullnnm = $rowc04["firstname"] . " " . $rowc04["lastname"];

                                                            ?>
                                                            <!--								</div>-->
                                                            <td class="form_tab_td">
                                                                <?php echo $groupname; ?>
                                                            </td>
                                                            <td class="form_tab_td">
                                                                <?php echo $form_status; ?>
                                                            </td>
                                                            <td class="form_tab_td">
                                                                <input type="text" name="approve_initial[]" id=""
                                                                       value="<?php echo $rowc04["firstname"] . " " . $rowc04["lastname"];; ?>"
                                                                       class="form-control pn_none">
                                                            </td>

                                                            <?php

                                                            $qur_pin = mysqli_query($db, "SELECT pin FROM  cam_users where users_id = '$id' ");
                                                            $row_pin = mysqli_fetch_assoc($qur_pin);
                                                            //  $full_pin = $row_pin["pin"];


                                                            ?>

                                                            <td class="form_tab_td">
                                                                <input type="text" name="approval_time" id="approval_time"
                                                                       value="<?php echo date('d-M-Y h:i:s', $date_time); ?>"
                                                                       class="form-control pn_none">
                                                            </td>

                                                        </tr>
                                                        <?php if ($form_status == 'Rejected') { ?>
                                                            <tr id="rej_reason_div" style="display: table-row;border: 1px solid red;">
                                                                <td class="form_tab_td" colspan="4"> Reject Reason :
                                                                    <textarea class="form-control pn_none" name="rej_reason" rows="1" ><?php echo $rowc05['reject_reason']; ?>

                                                                </textarea>
                                                                </td>
                                                            </tr>
                                                        <?php } else if ($form_status == 'Approved') {
                                                            if ($rowc05['reject_reason'] != ""){?>
                                                                <tr id="rej_reason_div" style="display: table-row;border: 1px solid green;">
                                                                    <td class="form_tab_td" colspan="4"> Approve Reason :
                                                                        <textarea class="form-control pn_none" name="rej_reason" rows="1"><?php echo $rowc05['reject_reason']; ?>

                                                                </textarea>
                                                                    </td>
                                                                </tr>
                                                            <?php  } }
                                                        $fullnnm = "";
                                                        $passcd = "";
                                                    }
                                                }
                                            }
                                            ?>


                                        </table>

                                        <?php
                                        $query1 = sprintf("SELECT * FROM  form_create where form_create_id = '$item_id'");
                                        $qur1 = mysqli_query($db, $query1);
                                        $i = 0;
                                        while ($rowc1 = mysqli_fetch_array($qur1)) {
                                            $approval_dept_array = $rowcmain['approval_dept'];
                                            $approval_dept = explode(',', $approval_dept_array);
                                            $approval_initials_array = $rowcmain['approval_initials'];
                                            $approval_initials = explode(',', $approval_initials_array);
                                            $passcode_array = $rowcmain['passcode'];
                                            $passcode = explode(',', $passcode_array);
                                            $approval_by_array = $rowc1['approval_by'];
                                            $arrteam = explode(',', $approval_by_array);


                                            foreach ($arrteam as $arr) {
                                                if ($arr != "") {
                                                    ?>
                                                    <div class="form_table_mobile">
                                                        <?php
                                                        $qurtemp = mysqli_query($db, "SELECT group_name FROM `sg_group` where group_id = '$arr' ");
                                                        $rowctemp = mysqli_fetch_array($qurtemp);
                                                        $groupname = $rowctemp["group_name"];

                                                        $qur05 = mysqli_query($db, "SELECT * FROM  form_approval where approval_dept = '$arr' and form_user_data_id = '$id' ");
                                                        $rowc05 = mysqli_fetch_array($qur05);
                                                        $app_in = $rowc05["approval_initials"];
                                                        $passcd = $rowc05["passcode"];
                                                        $datetime = $rowc05["created_at"];
                                                        $date_time = strtotime($datetime);

                                                        $approval_status = $rowc05["approval_status"];
                                                        $reject_status = $rowc05["reject_status"];

                                                        if ($approval_status == '0' && $reject_status == '1') {
                                                            $form_status = "Rejected";
                                                        } else {
                                                            $form_status = "Approved";
                                                        }

                                                        $qur04 = mysqli_query($db, "SELECT firstname,lastname FROM  cam_users where users_id = '$app_in' ");
                                                        $rowc04 = mysqli_fetch_array($qur04);
                                                        $fullnnm = $rowc04["firstname"] . " " . $rowc04["lastname"];

                                                        ?>
                                                        <div class="row">
                                                            <label class="col-lg-3 control-label mobile">Department</label>
                                                            <div class="col-lg-8 mobile">   <?php echo $groupname; ?></div>
                                                        </div>
                                                        <div class="row">
                                                            <label class="col-lg-3 control-label mobile">Form Status</label>
                                                            <div class="col-lg-8 mobile">     <?php echo $form_status; ?></div>

                                                        </div>
                                                        <div class="row">
                                                            <label class="col-lg-3 control-label mobile">Approver</label>
                                                            <div class="col-lg-8 mobile">
                                                                <input type="text" name="approve_initial[]" id=""
                                                                       value="<?php echo $rowc04["firstname"] . " " . $rowc04["lastname"];; ?>"
                                                                       class="form-control pn_none"></div>
                                                            <?php

                                                            $qur_pin = mysqli_query($db, "SELECT pin FROM  cam_users where users_id = '$id' ");
                                                            $row_pin = mysqli_fetch_assoc($qur_pin);
                                                            //  $full_pin = $row_pin["pin"];


                                                            ?>
                                                        </div>
                                                        <div class="row">
                                                            <label class="col-lg-3 control-label mobile">Time</label>
                                                            <div class="col-lg-8 mobile">
                                                                <input type="text" name="approval_time" id="approval_time"
                                                                       value="<?php echo date('d-M-Y h:i:s', $date_time); ?>"
                                                                       class="form-control pn_none">
                                                            </div>
                                                        </div>

                                                        <?php if ($form_status == 'Rejected') { ?>
                                                            <div id="rej_reason_div" style="border: 1px solid red;padding: 10px;">
                                                                <td class="form_tab_td pn_none" colspan="4">Reject Reason : <textarea
                                                                            placeholder="<?php echo $rowc05['reject_reason']; ?>"
                                                                            style="color: #333333 !important;width: 100%;height: auto; border: none;padding: 14px;" name="rej_reason" rows="1"></textarea>
                                                                </td>
                                                            </div>
                                                        <?php }  else if ($form_status == 'Approved') { ?>
                                                            <div id="rej_reason_div" style="border: 1px solid green;padding: 10px;">
                                                                <td class="form_tab_td pn_none" colspan="4">Approve Reason : <textarea
                                                                            placeholder="<?php echo $rowc05['reject_reason']; ?>"
                                                                            style="color: #333333 !important;width: 100%;height: auto; border: none;padding: 14px;" name="rej_reason" rows="1"></textarea>
                                                                </td>
                                                            </div>
                                                        <?php  } ?>
                                                    </div>
                                                    <?php     $fullnnm = "";
                                                    $passcd = "";
                                                }
                                            }
                                        }
                                        ?>
                                  <?php  } ?>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>


			<?php } ?>

            <!-- /main charts -->
            <!-- edit modal -->
            <!-- Dashboard content -->
            <!-- /dashboard content -->
        </div>
        <!-- /content area -->

    <!-- /page content -->
</div>
<!-- /page container -->


<script>
    function submitFormSettings(url) {
        //          $(':input[type="button"]').prop('disabled', true);
        var data = $("#form_settings").serialize();
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function(data) {
                // $("#textarea").val("")
                // window.location.href = window.location.href + "?aa=Line 1";
                //                   $(':input[type="button"]').prop('disabled', false);
                //                   location.reload();
                //$(".enter-message").val("");
            }
        });
    }
    $(".compare_text").keyup(function () {
        var text_id = $(this).attr("id");
        var lower_compare = parseInt($(".lower_compare[data-id='" + text_id + "']").val());
        var upper_compare = parseInt($(".upper_compare[data-id='" + text_id + "']").val());
        var text_val = $(this).val();

        if ($(".compare_text").val().length == 0) {
            $(this).css("background-color", "white");
            return false;
        } else {
            if ($.isNumeric(text_val)) {

                if (text_val >= lower_compare && text_val <= upper_compare){
                    $(this).css("background-color", "");
                } else {
                    $(this).css("background-color", "#ffadad");
                }
            }
        }

    });
</script>
<?php include ('../footer.php') ?>
</body>

</html>