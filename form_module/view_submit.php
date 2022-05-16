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
        @import url('https://fonts.googleapis.com/css2?family=WindSong&display=swap');

        .signature {

            font-family: 'WindSong', swap;
            font-size: 25px;
            font-weight: 600;
        }

        #form_save_btn {
            background-color: #1e73be;
            margin-left: 35px;
            padding: 12px 22px 10px 18px;
            margin-bottom: 10px;
        }

        .pn_none {
            pointer-events: none;
            color: #050505;
        }
        .tooltip {
            position: relative;
            display: inline-block;
            /*border-bottom: 1px dotted black;*/
            opacity: 1!important;
            overflow: inherit;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 120px;
            background-color: #26a69a;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px 0;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -60px;
            opacity: 0;
            transition: opacity 0.3s;

        }

        .tooltip .tooltiptext::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #555 transparent transparent transparent;

        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;

        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #191e3a!important;
            line-height: 20px!important;
        }
        .select2-container--disabled .select2-selection--single:not([class*=bg-]) {
            color: #060818!important;
            border-block-start: none;
            border-bottom-color: #191e3a!important;
        }
        .select2-container--disabled .select2-selection--single:not([class*=bg-]) {
            color: #999;
            border-bottom-style: inset;
        }


    </style>
</head>
<!-- Main navbar -->
<?php
$cust_cam_page_header = "View Form";
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
              <?php
            $id = $_GET['id'];
            $fill_op_data = $_GET['optional'];

            $querymain = sprintf("SELECT * FROM `form_user_data` where form_user_data_id = '$id' ");
            $qurmain = mysqli_query($db, $querymain);

            while ($rowcmain = mysqli_fetch_array($qurmain)) {
            $formname = $rowcmain['form_name'];

            ?>

            <div class="panel panel-flat">
                <!--                <h5 style="text-align: left;margin-right: 120px;"> <b>Submitted on : </b>--><?php //echo date('d-M-Y h:m'); ?><!--</h5>-->
                <div class="panel-heading">
                    <h5 class="panel-title form_panel_title"><?php echo $rowcmain['form_name']; ?>  </h5>
                    <div class="row ">
                        <div class="col-md-12">
                            <form action="edit_user_form_backend.php" id="form_settings" enctype="multipart/form-data"
                                  class="form-horizontal" method="post" autocomplete="off">
                                <input type="hidden" name="name" id="name"
                                       value="<?php echo $rowcmain['form_name']; ?>">
                                <input type="hidden" name="formcreateid" id="formcreateid"
                                       value="<?php echo $rowcmain['form_create_id']; ?>">
                                <input type="hidden" name="form_user_data_id" id="form_user_data_id"
                                       value="<?php echo $id; ?>">
                                <div class="form_row row">
                                    <label class="col-lg-2 control-label">Notes : </label>
                                    <div class="col-md-6">

                                        <?php
                                        $notes = $rowcmain["notes"];
                                        ?>

                                        <input type="text" name="notes" class="form-control pn_none" id="notes"
                                               value="<?php echo $notes; ?>">
                                    </div>
                                </div>
                                <div class="form_row row">
                                    <label class="col-lg-2 control-label">Form Type : </label>
                                    <div class="col-md-6">
                                        <?php
                                        $get_form_type = $rowcmain['form_type'];
                                        if ($get_form_type != '') {
                                            $disabled = 'disabled';
                                        } else {
                                            $disabled = '';
                                        }
                                        ?>
                                        <input type="hidden" name="form_type" id="form_type"
                                               value="<?php echo $get_form_type; ?>">
                                        <select name="form_type1" id="form_type"
                                                class="select-border-color" <?php echo $disabled; ?>>
                                            <option value="" selected disabled>--- Select Form Type ---</option>
                                            <?php

                                            $sql1 = "SELECT * FROM `form_type` ";
                                            $result1 = $mysqli->query($sql1);
                                            // $entry = 'selected';
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
                                    <label class="col-lg-2 control-label">Station : </label>
                                    <div class="col-md-6">

                                        <?php
                                        $get_station = $rowcmain['station'];
                                        if ($get_station != '') {
                                            $disabled = 'disabled';
                                        } else {
                                            $disabled = '';
                                        }
                                        ?>

                                        <input type="hidden" name="station" id="station"
                                               value="<?php echo $get_station; ?>">
                                        <select name="station1" id="station1"
                                                class="select-border-color" <?php echo $disabled; ?>>
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
                                <div class="form_row row">
                                    <label class="col-lg-2 control-label">Part Family : </label>
                                    <div class="col-md-6">

                                        <?php
                                        $get_part_family = $rowcmain['part_family'];
                                        if ($get_part_family != '') {
                                            $disabled = 'disabled';
                                        } else {
                                            $disabled = '';
                                        }
                                        ?>

                                        <input type="hidden" name="part_family" id="part_family"
                                               value="<?php echo $get_part_family; ?>">
                                        <select name="part_family1" id="part_family1"
                                                class="select-border-color" <?php echo $disabled; ?>>
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
                                <div class="form_row row">
                                    <label class="col-lg-2 control-label">Part Number : </label>
                                    <div class="col-md-6">

                                        <?php
                                        $get_part_number = $rowcmain['part_number'];
                                        if ($get_part_number != '') {
                                            $disabled = 'disabled';
                                        } else {
                                            $disabled = '';
                                        }
                                        ?>

                                        <input type="hidden" name="part_number" id="part_number"
                                               value="<?php echo $get_part_number; ?>">
                                        <select name="part_number1" id="part_number1"
                                                class="select-border-color" <?php echo $disabled; ?>>
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
                                                echo "<option value='" . $row1['pm_part_number_id'] . "' $entry >" . $row1['part_number'] . " - " . $row1['part_name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <br/>

                                <?php
                                $sql_wol = "SELECT wol FROM `form_type` where form_type_id = '$get_form_type' ";
                                $res_wol = $mysqli->query($sql_wol);
                                $r = $res_wol->fetch_assoc();
                                $wol = $r['wol'];
                                ?>
                                <?php if ($wol == '1') { ?>
                                    <div class="form_row row">
                                        <label class="col-lg-2 control-label">Work Order/Lot : </label>
                                        <div class="col-md-6">
                                            <?php if ($_GET != null && ($_GET['optional'] == '1')) { ?>
                                                <input type="text" name="wol" class="form-control" id="wol"
                                                       value="<?php echo $rowcmain['wol']; ?>" disabled>
                                            <?php } else { ?>
                                                <input type="text" name="wol" class="form-control" id="wol"
                                                       value="<?php echo $rowcmain['wol']; ?>">
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="form_row row">
                                    <label class="col-lg-2 control-label">Operator : </label>
                                    <div class="col-md-6">

                                        <?php
                                        $createdby = $rowcmain['created_by'];
                                        $datetime = $rowcmain["created_at"];
                                        $create_date = strtotime($datetime);
                                        $qur04 = mysqli_query($db, "SELECT firstname,lastname,pin FROM  cam_users where users_id = '$createdby' ");
                                        $rowc04 = mysqli_fetch_array($qur04);
                                        $fullnnm = $rowc04["firstname"] . " " . $rowc04["lastname"];
                                        $pin = $rowc04["pin"];

                                        ?>

                                        <input type="text" name="createdby" class="form-control" id="createdby"
                                               value="<?php echo $fullnnm; ?>" disabled>
                                    </div>
                                </div>
                                <div class="form_row row">
                                    <label class="col-lg-2 control-label">Submitted Time : </label>
                                    <div class="col-md-6">
                                        <input type="text" name="createdby" class="form-control" id="createdby"
                                               value="<?php echo date('d-M-Y h:i:s', $create_date); ?>" disabled>
                                    </div>
                                </div>
                                <br/>
                                <div class="form_row row">

                                    <?php
                                    $query1 = sprintf("SELECT form_create_id FROM  form_create where form_type = '$get_form_type' and station = '$get_station' and part_family = '$get_part_family' and part_number = '$get_part_number' and name = '$formname'");
                                    $qur1 = mysqli_query($db, $query1);
                                    $rowc1 = mysqli_fetch_array($qur1);
                                    $item_id = $rowc1['form_create_id'];

                                    $qurimage = mysqli_query($db, "SELECT * FROM  form_images where form_create_id = '$item_id'");
                                    while ($rowcimage = mysqli_fetch_array($qurimage)) {
                                        ?>

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

                                <br/>
                                <b><h4 class="panel-title form_panel_title">Form Information</h4></b>
                                <?php
                                $is_form_editable = ($rowcmain['form_comp_status'] == '0');
                                $query = sprintf("SELECT * FROM  form_item where form_create_id = '$item_id'");
                                $qur = mysqli_query($db, $query);

                                $op_data = $rowcmain["form_user_data_item_op"];
                                if (empty($op_data)){
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
                                $number_binary = $rowc['binary_normal'];


                                if ($item_val == "header") {

                                    ?>
                                    <div class="form_row_item row">
                                        <h4 class="panel-title ">
                                            <b><u><?php echo htmlspecialchars($rowc['item_desc']); ?></u></b></h4>
                                    </div>
                                <?php }
                                if ($item_val == "numeric") {
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

                                    ?>
                                    <input type="hidden" data-id="<?php echo $rowc['form_item_id']; ?>"
                                           class="lower_compare" value="<?php echo $final_lower; ?>">
                                    <input type="hidden" data-id="<?php echo $rowc['form_item_id']; ?>"
                                           class="upper_compare" value="<?php echo $final_upper; ?>">

                                    <div class="form_row_item row">

                                        <div class="col-md-8 form_col_item">
                                            <?php if ($rowc['optional'] != '1') {
                                                echo '<span class="red-star">★</span>';
                                            }
                                            echo htmlspecialchars($rowc['item_desc']); ?>
                                            <?php if (isset($rowc['discription']) && ($rowc['discription'] != '')) { ?>
                                                <div style="font-size: medium;font-color:#c1c1c1"><?php echo "(" . htmlspecialchars($rowc['discription']) . ")" ?></div>
                                            <?php }
                                            ?>
                                        </div>
                                        <?php if ($checked >= $final_lower && $checked <= $final_upper) { ?>
                                            <div class="col-md-2"><?php if ($rowc['optional'] != '1') { ?>
                                                    <input type="number" name="<?php echo $rowc['form_item_id']; ?>"
                                                           id="<?php echo $rowc['form_item_id']; ?>"
                                                           class="form-control compare_text pn_none" style="background-color: green" required step="any"
                                                           value="<?php echo $itemVal; ?>">
                                                    <?php
                                                } else if ($is_form_editable) { ?>
                                                    <input type="number" name="<?php echo $rowc['form_item_id']; ?>"
                                                           id="<?php echo $rowc['form_item_id']; ?>"
                                                           class="form-control compare_text" style="background-color: green" required step="any"
                                                           value="<?php echo $itemVal; ?>">
                                                <?php } else { ?>
                                                    <input type="number" name="<?php echo $rowc['form_item_id']; ?>"
                                                           id="<?php echo $rowc['form_item_id']; ?>"
                                                           class="form-control compare_text pn_none" style="background-color: green" required step="any"
                                                           value="<?php echo $itemVal; ?>">
                                                <?php } ?>
                                            </div>
                                        <?php } else { ?>
                                            <div class="col-md-2"><?php if ($rowc['optional'] != '1') { ?>
                                                    <input type="number" name="<?php echo $rowc['form_item_id']; ?>"
                                                           id="<?php echo $rowc['form_item_id']; ?>"
                                                           class="form-control compare_text pn_none" style="background-color: red" required step="any"
                                                           value="<?php echo $itemVal; ?>">
                                                    <?php
                                                } else if ($is_form_editable) { ?>
                                                    <input type="number" name="<?php echo $rowc['form_item_id']; ?>"
                                                           id="<?php echo $rowc['form_item_id']; ?>"
                                                           class="form-control compare_text" style="background-color: red" required step="any"
                                                           value="<?php echo $itemVal; ?>">
                                                <?php } else { ?>
                                                    <input type="number" name="<?php echo $rowc['form_item_id']; ?>"
                                                           id="<?php echo $rowc['form_item_id']; ?>"
                                                           class="form-control compare_text pn_none" style="background-color: red" required step="any"
                                                           value="<?php echo $itemVal; ?>">
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                        <div class="col-md-1"  style="padding-top: 15px;">
                                            <?php
                                            $unit_of_measurement_id = $rowc['unit_of_measurement'];
                                            $sql1 = "SELECT unit_of_measurement FROM `form_measurement_unit` where form_measurement_unit_id = '$unit_of_measurement_id'";
                                            $result1 = $mysqli->query($sql1);
                                            $row1 = $result1->fetch_assoc();
                                            echo $row1['unit_of_measurement'];
                                            ?>

                                        </div>
                                        <?php if ($rowc['optional'] == '1') {
                                            echo '<div style="color: #a1a1a1; font-size: small;padding-top: 15px;">(Optional)</div>';
                                        } ?>

                                        <input type="hidden" name="form_item_array[]"
                                               value="<?php echo $rowc['form_item_id']; ?>">
                                    </div><br/>
                                    <?php
                                    $aray_item_cnt++;
                                }
                                if ($item_val == "binary") {
                                    $bin_def = $rowc['binary_normal'];
                                    $bnf = $rowc['binary_default'];
                                    $checked = $itemVal;
                                    ?>
                                    <div class="form_row_item row">
                                        <div class="col-md-8 form_col_item">
                                            <input type="hidden" class="binary_compare"
                                                   value="<?php echo $bin_def; ?>"
                                                   data-id="<?php echo $rowc['form_item_id']; ?>"/>
                                            <?php if ($rowc['optional'] != '1') {
                                                echo '<span class="red-star">★</span>';
                                            }
                                            echo htmlspecialchars($rowc['item_desc']); ?>
                                            <?php if (isset($rowc['discription']) && ($rowc['discription'] != '')) { ?>
                                                <div style="font-size: medium;font-color:#c1c1c1"><?php echo "(" . htmlspecialchars($rowc['discription']) . ")" ?></div>
                                            <?php } ?>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="hidden" name="form_item_array[]"
                                                   value="<?php echo $rowc['form_item_id']; ?>"/>
                                            <div class="form-check form-check-inline">
                                                <?php
                                                //												if ($number = range($final_lower, $final_upper)) {
                                                if ($item_val == "binary") { ?>



                                                    <?php if ($rowc['optional'] != '1') { ?>

                                                        <input type="radio" id="yes"
                                                               name="<?php echo $rowc['form_item_id']; ?>"
                                                               value="<?php echo $rowc['binary_yes_alias']; ?>"
                                                               class="form-check-input pn_none" <?php echo (($itemVal != null) && ($itemVal == 'yes')) ? "checked" : "" ?> >
                                                        <label for="yes" style="background-color: green;"
                                                               class="pn_none item_label <?php echo $rowc['form_item_id']; ?>"
                                                               id="<?php echo $rowc['form_item_id']; ?>"><?php $yes_alias = $rowc['binary_yes_alias'];
                                                            echo (($yes_alias != null) || ($yes_alias != '')) ? $yes_alias : "Yes" ?></label>
                                                        <!--<label for="yes" class="item_label" style="background-color: green;">--><?php //echo $rowc['binary_yes_alias']; ?><!--</label>-->
                                                        <input type="radio" id="no"
                                                               name="<?php echo $rowc['form_item_id']; ?>"
                                                               value="<?php echo $rowc['binary_no_alias']; ?>"
                                                               class="form-check-input pn_none" <?php echo (($itemVal != null) && ($itemVal == 'no')) ? "checked" : "" ?> >
                                                        <label for="no" style="background-color: green;"
                                                               class="pn_none item_label <?php echo $rowc['form_item_id']; ?>"
                                                               id="<?php echo $rowc['form_item_id']; ?>"><?php $no_alias = $rowc['binary_no_alias'];
                                                            echo (($no_alias != null) || ($no_alias != '')) ? $no_alias : "No" ?></label>


                                                        <?php
                                                    } else if ($is_form_editable) { ?>

                                                        <input type="radio" id="yes"
                                                               name="<?php echo $rowc['form_item_id']; ?>"
                                                               value="<?php echo $rowc['binary_yes_alias']; ?>"
                                                               class="form-check-input" <?php echo (($itemVal != null) && ($itemVal == 'yes')) ? "checked" : "" ?> >
                                                        <label for="yes" style="background-color: green;"
                                                               class="item_label <?php echo $rowc['form_item_id']; ?>"
                                                               id="<?php echo $rowc['form_item_id']; ?>"><?php $yes_alias = $rowc['binary_yes_alias'];
                                                            echo (($yes_alias != null) || ($yes_alias != '')) ? $yes_alias : "Yes" ?></label>
                                                        <!--															<label for="yes" class="item_label" style="background-color: green;">--><?php //echo $rowc['binary_yes_alias']; ?><!--</label>-->
                                                        <input type="radio" id="no"
                                                               name="<?php echo $rowc['form_item_id']; ?>"
                                                               value="<?php echo $rowc['binary_no_alias']; ?>"
                                                               class="form-check-input" <?php echo (($itemVal != null) && ($itemVal == 'no')) ? "checked" : "" ?>>
                                                        <label for="no" style="background-color: red;"
                                                               class="item_label <?php echo $rowc['form_item_id']; ?>"
                                                               id="<?php echo $rowc['form_item_id']; ?>"><?php $no_alias = $rowc['binary_no_alias'];
                                                            echo (($no_alias != null) || ($no_alias != '')) ? $no_alias : "No" ?></label>
                                                        <?php if ($rowc['optional'] == '1') {
                                                            echo '<span style="color: #a1a1a1; font-size: small;">(Optional)</span>';
                                                        } ?>
                                                    <?php } else { ?>

                                                        <input type="radio" id="yes"
                                                               name="<?php echo $rowc['form_item_id']; ?>"
                                                               value="<?php echo $rowc['binary_yes_alias']; ?>"
                                                               class="form-check-input pn_none" <?php echo (($itemVal != null) && ($itemVal == 'yes')) ? "checked" : "" ?> >
                                                        <label for="yes" style="background-color: red;"
                                                               class="pn_none item_label <?php echo $rowc['form_item_id']; ?>"
                                                               id="<?php echo $rowc['form_item_id']; ?>"><?php $yes_alias = $rowc['binary_yes_alias'];
                                                            echo (($yes_alias != null) || ($yes_alias != '')) ? $yes_alias : "Yes" ?></label>
                                                        <!--															<label for="yes" class="item_label" style="background-color: green;">--><?php //echo $rowc['binary_yes_alias']; ?><!--</label>-->
                                                        <input type="radio" id="no"
                                                               name="<?php echo $rowc['form_item_id']; ?>"
                                                               value="<?php echo $rowc['binary_no_alias']; ?>"
                                                               class="form-check-input pn_none" <?php echo (($itemVal != null) && ($itemVal == 'no')) ? "checked" : "" ?> >
                                                        <label for="no" style="background-color: red;"
                                                               class="pn_none item_label <?php echo $rowc['form_item_id']; ?>"
                                                               id="<?php echo $rowc['form_item_id']; ?>"><?php $no_alias = $rowc['binary_no_alias'];
                                                            echo (($no_alias != null) || ($no_alias != '')) ? $no_alias : "No" ?></label>
                                                        <?php if ($rowc['optional'] == '1') {
                                                            echo '<span style="color: #a1a1a1; font-size: small;">(Optional)</span>';
                                                        } ?>
                                                    <?php }

                                                }
                                                //}
                                                ?>

                                            </div>
                                        </div>
                                        <?php if ($rowc['optional'] != '1') { ?>
                                            <div class="col-md-3 form_col_item">
                                                <u><b><?php echo $rowc['discription']; ?> </b></u></div>
                                        <?php } else { ?>
                                            <div class="col-md-3 form_col_item">
                                                <u><b><?php echo $rowc['discription']; ?> </b></u></div>

                                        <?php } ?>

                                    </div>
                                    <br/>
                                    <?php
                                    $aray_item_cnt++;

                                }
                                if ($item_val == "text"){

                                ?>
                                <div class="form_row_item row">
                                    <div class="col-md-8 form_col_item">
                                        <?php
                                        if ($rowc['optional'] != '1') {
                                            echo '<span class="red-star">★</span>';
                                        }
                                        echo htmlspecialchars($rowc['item_desc']); ?>
                                        <?php if (isset($rowc['discription']) && ($rowc['discription'] != '')) { ?>
                                            <div style="font-size: medium;font-color:#c1c1c1"><?php echo "(" . $rowc['discription'] . ")" ?></div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="hidden" name="form_item_array[]"
                                               value="<?php echo $rowc['form_item_id']; ?>">
                                        <?php if ($rowc['optional'] != '1') { ?>
                                        <input type="text" name="<?php echo $rowc['form_item_id']; ?>"
                                               id="<?php echo $rowc['form_item_id']; ?>" autocomplete="off"
                                               value="<?php echo $itemVal; ?>"
                                               class="form-control pn_none"></div>
                                    <?php } else {
                                    if ($is_form_editable){
                                    ?>
                                    <input type="text" name="<?php echo $rowc['form_item_id']; ?>"
                                           id="<?php echo $rowc['form_item_id']; ?>" autocomplete="off"
                                           value="<?php echo $itemVal; ?>" class="form-control"></div>
                                <?php }else{ ?>
                                <input type="text" name="<?php echo $rowc['form_item_id']; ?>"
                                       id="<?php echo $rowc['form_item_id']; ?>" autocomplete="off"
                                       value="<?php echo $itemVal; ?>" class="form-control pn_none">
                        </div>
                        <?php }
                        } ?>
                        <div class="col-md-3 form_col_item"><u><b><?php echo $rowc['discription']; ?> </b></u>
                        </div>

                    </div>
                    <br/>
                    <?php
                    $aray_item_cnt++;

                    }
                    }
                    if ($is_form_editable){
                        ?>
                        <div class="row">
                            <input type="hidden" name="click_id" id="click_id">
                            <div class="col-md-2">
                                <button type="submit" id="form_save_btn" class="btn btn-primary submit_btn">Save
                                </button>
                            </div>
                        </div>
                        <?php
                    }} else {
//									$arrteam = $op_data;
                        $aray_item_cnt = 0;
                        $arrteam = explode(',', $op_data);
                        while ($rowc = mysqli_fetch_array($qur)) {
							$expVal = $arrteam[$aray_item_cnt];
							$ccnt = substr_count ($expVal, '~');
							if($ccnt > 0){
								$itemVal = explode('~',  $expVal)[1];
							}else{
								$itemVal = explode('~',  $expVal)[0];
							}
                            $item_val = $rowc['item_val'];

                            if ($item_val == "header") {

                                ?>
                                <div class="form_row_item row">
                                    <h4 class="panel-title ">
                                        <b><u><?php echo htmlspecialchars($rowc['item_desc']); ?></u></b></h4>
                                </div>
                            <?php }
                            if ($item_val == "numeric") {
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

                                ?>

                                <div class="form_row_item row">
                                    <div class="col-md-8 form_col_item"><?php if ($rowc['optional'] != '1') {
                                            echo '<span class="red-star">★</span>';
                                        }
                                        echo htmlspecialchars($rowc['item_desc']); ?></div>
                                    <?php if (isset($rowc['discription']) && ($rowc['discription'] != '')) { ?>
                                        <div style="font-size: medium;font-color:#c1c1c1"><?php echo "(" . $rowc['discription'] . ")" ?></div>
                                    <?php } ?>
                                    <div class="col-md-3">
                                        <input type="text" name="<?php echo $rowc['form_item_id']; ?>"
                                               id="<?php echo $rowc['form_item_id']; ?>" value="<?php echo $checked; ?>"
                                               class="form-control pn_none">
                                    </div>
                                    <div class="col-md-1">
                                        <?php
                                        $unit_of_measurement_id = $rowc['unit_of_measurement'];
                                        $sql1 = "SELECT unit_of_measurement FROM `form_measurement_unit` where form_measurement_unit_id = '$unit_of_measurement_id'";
                                        $result1 = $mysqli->query($sql1);
                                        $row1 = $result1->fetch_assoc();
                                        echo $row1['unit_of_measurement'];
                                        ?>
                                    </div>
                                    <!--										<div class="col-md-3 form_col_item"><u><b>-->
                                    <?php //echo $rowc['discription'];
                                    ?><!-- </b></u></div>-->

                                    <input type="hidden" name="form_item_array[]"
                                           value="<?php echo $rowc['form_item_id']; ?>">
                                </div><br/>
                                <?php
                                $aray_item_cnt++;
                            }
                            if ($item_val == "binary") {
                                $checked = $itemVal;
                                ?>
                                <div class="form_row_item row">
                                    <div class="col-md-8 form_col_item">
                                        <?php if ($rowc['optional'] != '1') {
                                            echo '<span class="red-star">★</span>';
                                        }
                                        echo htmlspecialchars($rowc['item_desc']); ?>
                                    </div>

                                    <input type="hidden" name="form_item_array[]"
                                           value="<?php echo $rowc['form_item_id']; ?>">
                                    <div class="col-md-4">
                                        <div class="form-check form-check-inline">


                                            <?php
                                            if ($checked == "yes") {
                                                ?>

                                                <input type="radio" id="yes" name="<?php echo $rowc['form_item_id']; ?>"
                                                       value="<?php echo $rowc['binary_yes_alias']; ?>"
                                                       class="form-check-input pn_none" checked>
                                                <label for="yes" style="background-color: green;"
                                                       class="pn_none item_label <?php echo $rowc['form_item_id']; ?>"
                                                       id="<?php echo $rowc['form_item_id']; ?>"><?php $yes_alias = $rowc['binary_yes_alias'];
                                                    echo (($yes_alias != null) || ($yes_alias != '')) ? $yes_alias : "Yes" ?></label>
                                                <!--															<label for="yes" class="item_label" style="background-color: green;">--><?php //echo $rowc['binary_yes_alias'];
                                                ?><!--</label>-->
                                                <input type="radio" id="no" name="<?php echo $rowc['form_item_id']; ?>"
                                                       value="<?php echo $rowc['binary_no_alias']; ?>"
                                                       class="form-check-input pn_none">
                                                <label for="no" style="background-color: green;"
                                                       class="pn_none item_label <?php echo $rowc['form_item_id']; ?>"
                                                       id="<?php echo $rowc['form_item_id']; ?>"><?php $no_alias = $rowc['binary_no_alias'];
                                                    echo (($no_alias != null) || ($no_alias != '')) ? $no_alias : "No" ?></label>
                                                <!--															<label for="no" class="item_label"  style="background-color: green;">--><?php //echo $rowc['binary_no_alias'];
                                                ?><!--</label>-->


                                                <?php
                                            } else { ?>

                                                <input type="radio" id="yes" name="<?php echo $rowc['form_item_id']; ?>"
                                                       value="<?php echo $rowc['binary_yes_alias']; ?>"
                                                       class="form-check-input pn_none">
                                                <label for="yes" class="item_label" style="background-color: green;"
                                                       style="background-color: red;"><?php echo $rowc['binary_yes_alias']; ?></label>
                                                <input type="radio" id="no" name="<?php echo $rowc['form_item_id']; ?>"
                                                       value="<?php echo $rowc['binary_no_alias']; ?>"
                                                       class="form-check-input pn_none" checked>
                                                <label for="no" class="item_label" style="background-color: green;"
                                                       style="background-color: red;"><?php echo $rowc['binary_no_alias']; ?></label>

                                            <?php }
                                            ?>

                                        </div>
                                    </div>
                                    <div class="col-md-3 form_col_item">
                                        <u><b><?php echo $rowc['discription']; ?> </b></u></div>

                                </div>
                                <br/>
                                <?php
                                $aray_item_cnt++;

                            }
                            if ($item_val == "text") {

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
                                               id="<?php echo $rowc['form_item_id']; ?>" autocomplete="off"
                                               value="<?php echo $itemVal; ?>"
                                               class="form-control pn_none"></div>
                                    <div class="col-md-3 form_col_item">
                                        <u><b><?php echo $rowc['discription']; ?> </b></u></div>

                                </div><br/>
                                <?php
                                $aray_item_cnt++;

                            }
                        }

                    }
                    ?>

                    <?php
                    $queryst = sprintf("SELECT * FROM `form_user_data` where form_user_data_id = '$id' ");
                    $qur = mysqli_query($db, $queryst);

                    $rowcst = mysqli_fetch_array($qur);
                    $status = $rowcst["form_status"];
                    if ( $status != null ) {?>
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
                                                <td class="form_tab_td" colspan="4"> Reject Reason : <textarea
                                                            placeholder="<?php echo $rowc05['reject_reason']; ?>"
                                                            class="form-control" name="rej_reason" rows="1"></textarea></td>
                                            </tr>
                                        <?php }
                                        $fullnnm = "";
                                        $passcd = "";
                                    }
                                }
                            }
                            ?>


                        </table>
                    <?php } else { ?>
                        <b><h4 class="panel-title form_panel_title">Approval List</h4></b>
                        <form action="" id="approve_form" class="form-horizontal" method="post" autocomplete="off">
                            <table class="form_table">
                                <tr class="form_tab_tr">
                                    <th class="form_tab_th">Department</th>
                                    <th class="form_tab_th">Approver</th>
                                    <th class="form_tab_th">Digital Signature</th>
                                    <th class="form_tab_th">Actions</th>
                                </tr>
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
                                            <tr class="form_tab_tr">
                                                <?php
                                                $qurtemp = mysqli_query($db, "SELECT group_name FROM `sg_group` where group_id = '$arr' ");
                                                $rowctemp = mysqli_fetch_array($qurtemp);
                                                $groupname = $rowctemp["group_name"]

                                                ?>
                                                <td class="form_tab_td">
                                                    <input type="hidden" name="approval_dept"
                                                           id="approval_dept_<?php echo $j ?>"
                                                           value="<?php echo $arr; ?>">
                                                    <?php echo $groupname; ?>
                                                </td>
                                                <td class="form_tab_td">
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
                                                </td>
                                                <td class="form_tab_td" id="approve_msg">
                                                    <input type="password" name="pin[]" id="pin_<?php echo $j ?>"
                                                           class="form-control" style=" margin-bottom: 5px;"
                                                           placeholder="Enter Pin..."  autocomplete="off" >
                                                    <span style="font-size: x-small;color: darkred; display: none;" id="pin_error_<?php echo $j; ?>">Invalid Pin.</span>
                                                </td>

                                                <td class="form_tab_td ">
                                                    <input type="hidden" id="form_user_data_id"
                                                           name="form_user_data_id" value=""/>
                                                    <input type="hidden" id="approval_dept_cnt"
                                                           name="approval_dept_cnt" value=""/>
                                                    <button type="submit" id="approve_<?php echo $j ?>"
                                                            name="approve"
                                                            class="btn btn-primary tooltip approve"
                                                            style="background-color:#1e73be;font-size: 12px;margin-top: -22px;">
                                                        <i class="fa fa-check" aria-hidden="true"></i>
                                                        <span class="tooltiptext">Approve</span>
                                                    </button>

                                                    <!--                                                        </td>-->
                                                    <!--                                                        <td class="form_tab_td" style="padding: 0px;">-->
                                                    <input type="hidden" id="rejected_dept_cnt"
                                                           name="rejected_dept_cnt" value=""/>
                                                    <input type="hidden" id="reject_dept_cnt"
                                                           name="reject_dept_cnt" value=""/>
                                                    <button type="submit" id="reject_<?php echo $k ?>"
                                                            name="reject"
                                                            class="btn btn-primary tooltip reject"
                                                            style="background-color:#1e73be;font-size: 12px;margin-left: 50px;margin-top: -22px;">
                                                        <i class="fa fa-times" aria-hidden="true"></i>
                                                        <span class="tooltiptext">Reject</span>
                                                    </button>
                                                </td>

                                            </tr>
                                            <tr id="rej_reason_div_<?php echo $j ?>" style="display: none">
                                                <td class="form_tab_td" colspan="4">
                                                    <textarea class="form-control" placeholder="Enter Reject Reason..." id="rej_reason_<?php echo $j ?>" name = "rej_reason_<?php echo $j ?>" rows="1" ></textarea>
                                                </td>
                                            </tr>
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

                            </table>
                            <tr>
                                <hr class="form_hr"/>

                            </tr>
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
                    <?php  }
                    ?>
                    <br/> </form>
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
</div>
<!-- /page container -->
<script>

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

                if (text_val >= lower_compare && text_val <= upper_compare) {
                    $(this).css("background-color", "green");
                } else {
                    $(this).css("background-color", "red");
                }
            }
        }

    });

    $("input:radio").click(function () {
        var radio_id = $(this).attr("name");
        var binary_compare = $(".binary_compare[data-id='" + radio_id + "']").val();


        var exact_val = $('input[name="' + radio_id + '"]:checked').val();


        if (exact_val == binary_compare) {
            $("." + radio_id).css("background-color", "green");
        } else {
            $("." + radio_id).css("background-color", "red");
        }


    })

    $("#form_save_btn").click(function (e) {
        //          $(':input[type="button"]').prop('disabled', true);
        var data = $("#form_settings").serialize();
        $.ajax({
            type: 'POST',
            url: 'edit_user_form_backend.php',
            async: false,
            data: data,
            success: function (data) {
                e.preventDefault()
                $("#form_save_btn").prop("disabled", true);
              //  $("form :input").prop("disabled", true);
              //  window.scrollTo(0, 0);
            }
        });

        // e.preventDefault();
    });


    $("#btnSubmit_1").click(function (e) {
        document.getElementById("form_save_btn").required = true;
        var data_1 = "update_fud=1"+"&form_user_data_id=" + document.getElementById("form_user_data_id").value ;
        $.ajax({
            type: 'POST',
            url: 'user_form_backend.php',
            // dataType: "json",
            // context: this,
            // async: false,
            data: data_1,
            success: function (response) {
                $('#btnSubmit_1').attr('disabled', 'disabled');
                // $('#form_save_btn').attr('disabled', 'disabled');
                var x = document.getElementById("sub_app");
                x.style.display = "none";
                $('#success_msg').text('Form submitted Successfully').css('background-color','#0080004f');
                $("form :input").prop("disabled", true);
                window.scrollTo(0, 0);
            }
        });
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
                    $('#' + this.id).attr('disabled', 'disabled').text('Approved');
                    $('#pin_'+this.id.split("_")[1]).attr('disabled', 'disabled');
                    $('#reject_'+this.id.split("_")[1]).attr('disabled', 'disabled');
                    $('#approval_initials_'+this.id.split("_")[1]).attr('disabled', 'disabled');
                    $('#btnSubmit_1').removeAttr('disabled');
                }else if(arr_data["all_dept_approved"] == 0){
                    $('#' + this.id).attr('disabled', 'disabled').text('Approved');
                    $('#pin_'+this.id.split("_")[1]).attr('disabled', 'disabled');
                    $('#reject_'+this.id.split("_")[1]).attr('disabled', 'disabled');
                    $('#approval_initials_'+this.id.split("_")[1]).attr('disabled', 'disabled');
                    $('#btnSubmit_1').removeAttr('disabled');
                }
            },

        });
    });

    $(".reject").click(function (e) {
        e.preventDefault();
        var index = this.id.split("_")[1];
        //  alert(index);
        var x = document.getElementById("u_error_"+index);
        x.style.display = "none";
        var y = document.getElementById("pin_error_"+index);
        y.style.display = "none";

        var z = document.getElementById("rej_reason_div_"+index);
        if (z.style.display === "none") {
            z.style.display = "table-row";
        }
        if(document.getElementById("rej_reason_"+index).value){
            var data_1 = "index="+index+"&rejected_dept_cnt=" + document.getElementById("rejected_dept_cnt").value + "&form_user_data_id=" + document.getElementById("form_user_data_id").value + "&app_dept=" + document.getElementById("approval_dept" + "_" + this.id.split("_")[1]).value + "&app_id=" + document.getElementById("approval_initials" + "_" + this.id.split("_")[1]).value + "&pin=" + document.getElementById("pin" + "_" + this.id.split("_")[1]).value + "&reject_reason=" + document.getElementById("rej_reason_" + this.id.split("_")[1]).value;
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
                    }else  if (arr_data["all_dept_rejected"] == 1) {
                        $('#' + this.id).attr('disabled', 'disabled').text('Rejected');
                        $('#rej_reason_div_'+this.id.split("_")[1]).attr('disabled', 'disabled');

                        $('#pin_'+this.id.split("_")[1]).attr('disabled', 'disabled');
                        $('#approve_'+this.id.split("_")[1]).attr('disabled', 'disabled');

                        $('#approval_initials_'+this.id.split("_")[1]).attr('disabled', 'disabled');
                        $('#btnSubmit_1').removeAttr('disabled');
                    }else if(arr_data["all_dept_rejected"] == 0){
                        $('#' + this.id).attr('disabled', 'disabled').text('Rejected');
                        $('#rej_reason_div_'+this.id.split("_")[1]).attr('disabled', 'disabled');

                        $('#pin_'+this.id.split("_")[1]).attr('disabled', 'disabled');

                        $('#approve_'+this.id.split("_")[1]).attr('disabled', 'disabled');
                        $('#approval_initials_'+this.id.split("_")[1]).attr('disabled', 'disabled');
                        $('#btnSubmit_1').removeAttr('disabled');
                    }
                },

            });
        }else{

        }
        // alert(x);
        // var y = document.getElementById("pin_error_"+index);
        // y.style.display = "none";

    });

</script>
<?php include('../footer.php') ?>
<script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/core/app.js"></script>
</body>

</html>