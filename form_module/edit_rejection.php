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
        <?php echo $sitename; ?> | Edit Rejection Form</title>
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
$cust_cam_page_header = "Edit Rejection Form";
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
                            <?php
                            $sql_t = "SELECT tracker_id FROM `form_rejection_data` where form_user_data_id = '$id' ";
                            $res_t = $mysqli->query($sql_t);
                            $t = $res_t->fetch_assoc();
                            $track = $t['tracker_id'];
                            ?>

                            <div class="form_row row">
                                <label class="col-lg-2 control-label">Work Order/Lot : </label>
                                <div class="col-md-6">

                                        <input type="text" name="wol" class="form-control" id="wol"
                                               value="<?php echo $track; ?>">

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
                            <div class="form_row row">
                                <label class="col-lg-2 control-label">Rejection reason : </label>
                                <div class="col-md-6">
                                    <?php

                                    $qur05 = mysqli_query($db, "SELECT a.reject_reason as reject_reason11  FROM form_approval as a,form_user_data as b WHERE a.form_user_data_id = b.form_user_data_id");
                                    $rowc05 = mysqli_fetch_array($qur05);
                                    $reject_reason = $rowc05["reject_reason11"];

                                    ?>
                                    <input type="text" name="reason" class="form-control" id="reason"
                                           value="<?php echo $reject_reason; ?>" disabled>
                                </div>
                            </div>
                            <div class="form_row row">
                                <label class="col-lg-2 control-label">Enter your pin: </label>
                                <div class="col-md-6">
                                   <span class="form_tab_td" id="approve_msg" style="float: left !important;width: 40% !important;padding: 0px 30px !important;">
                                                            <input type="password" name="pin[]" id="pin_<?php echo $j ?>"
                                                                   class="form-control" style=" margin-bottom: 5px;width: auto !important;"
                                                                   placeholder="Enter Pin..."  autocomplete="off" >
                                                            <span style="font-size: x-small;color: darkred; display: none;" id="pin_error_<?php echo $j; ?>">Invalid Pin.</span>
                                                        </span>
                                </div>
                            </div>
                            <div class="form_row row">
                                <label class="col-lg-2 control-label">Notes : </label>
                                <div class="col-md-6">

                                    <textarea class="form-control" id ="notes" name="notes" rows="2"></textarea>
                                </div>
                            </div>

                                        <div class="col-md-3" style="padding-left: 950px">
                                            <button type="button" id="btnSubmit_1" class="btn btn-primary"
                                                    style="background-color:#1e73be;">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                            </div>
                    </div>

                </div>
                <?php } ?>
                <!-- /content area -->
            </div>
            <!-- /page container -->
            <script>
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