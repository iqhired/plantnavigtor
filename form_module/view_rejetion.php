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
        <?php echo $sitename; ?> | View Rejection Form</title>
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
//$cam_page_header = "View Form Data";
include("../hp_header.php");
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
        $form_user_data_id = $rowcmain['form_user_data_id'];

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
                                <label class="col-lg-2 control-label">Comments : </label>
                                <div class="col-md-3">
                                    <?php
                                    $qurt = mysqli_query($db, "SELECT message,comment_date FROM  comments where userid = '$form_user_data_id' ");
                                    while ($rowct = mysqli_fetch_array($qurt)) {
                                    $message = $rowct["message"];
                                    $comment_date = $rowct["comment_date"];
                                    ?>
                                    <ul class="media-list chat-list content-group">
                                        <li class="media">
                                            <div class="media-body">
                                                <div class="media-content"><?php echo $rowct["message"]."<br/>"; ?></div>
                                                <span class="media-annotation display-block mt-15"><?php echo $fullnnm;?> </span>
                                                <span class="media-annotation display-block mt-15"><?php echo $rowct["comment_date"];?> </span>
                                            </div>
                                        </li>
                                    </ul>

                                </div>
                                <?php } ?>
                            </div>
                            <br/>
                            <div class="form_row row">
                                <label class="col-lg-2 control-label">File: </label>
                                <div class="col-md-6">
                                <?php

                                $qurimage = mysqli_query($db, "SELECT * FROM  form_rejection_data where form_user_data_id = '$form_user_data_id'");
                                while ($rowcimage = mysqli_fetch_array($qurimage)) {
                                    ?>

                                    <div class="col-lg-3 col-sm-6">
                                        <div class="thumbnail">
                                            <div class="thumb">
                                                <img src="../form_images/<?php echo $rowcimage['filename']; ?>"
                                                     alt="" target="_blank">
                                                <div class="caption-overflow">
														<span>
															<a href="../form_images/<?php echo $rowcimage['filename']; ?>" target="_blank"
                                                               data-popup="lightbox" rel="gallery"
                                                               class="btn border-white text-white btn-flat btn-icon btn-rounded"><i
                                                                        class="icon-plus3" ></i></a>
														</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            </div>
                            <br/>

</div>

<!-- /main charts -->
<!-- edit modal -->
<!-- Dashboard content -->
<!-- /dashboard content -->
</div>
                <?php } ?>
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
</body>

</html>