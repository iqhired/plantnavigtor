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
        <?php echo $sitename; ?> |Edit Rejection Form</title>
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


    <script type="text/javascript" src="index.js" ></script>
    <script type="text/javascript" src="constants.js" ></script>
    <script type="text/javascript" src="speech.js" ></script>
    <script>
        const synth = window.speechSynthesis;

        const textToSpeech = (string) => {
            let voice = new SpeechSynthesisUtterance(string);
            voice.text = string;
            voice.lang = "en-US";
            voice.volume = 1;
            voice.rate = 1;
            voice.pitch = 1; // Can be 0, 1, or 2
            synth.speak(voice);
        }
    </script>
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

            .form_row_item{
                width: 100%;
            }

            .col-md-3.mob{
                width:40%;
            }
            .form_tab_td{
                padding: 10px 100px;
            }
            /*.reject {*/
            /*    background-color: #1e73be;*/
            /*    font-size: 12px;*/
            /*    margin-left: 16px;*/
            /*    margin-top: -36px;*/
            /*    float: right;*/
            /*}*/
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
        #check {
            background-color: #90A4AE;
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
        $form_user_data_id = $rowcmain['form_user_data_id'];

        ?>

        <div class="panel panel-flat">
            <!--                <h5 style="text-align: left;margin-right: 120px;"> <b>Submitted on : </b>--><?php //echo date('d-M-Y h:m'); ?><!--</h5>-->
            <div class="panel-heading">
                <h5 class="panel-title form_panel_title"><?php echo $rowcmain['form_name']; ?>  </h5>
                <div class="row ">
                    <div class="col-md-12">
                        <form action="update_user_form_backend.php" id="form_update" enctype="multipart/form-data"
                              class="form-horizontal" method="post" autocomplete="off">
                            <input type="hidden" name="name" id="name"
                                   value="<?php echo $rowcmain['form_name']; ?>">
                            <input type="hidden" name="formcreateid" id="formcreateid"
                                   value="<?php echo $rowcmain['form_create_id']; ?>">
                            <input type="hidden" name="form_user_data_id" id="form_user_data_id"
                                   value="<?php echo $id; ?>">

                            <div class="form_row row">
                                <label class="col-lg-2 control-label">Form link : </label>
                                <div class="col-md-6">
                                    <a href="view_rejetion.php?id=<?php echo $rowcmain['form_user_data_id'];?>">
                                            <u>Link for view the form</u>
                                    </a>
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
                                <label class="col-lg-2 control-label">Attachments : </label>
                                <div class="col-md-6">
                                    <input type="file" name="file" id="file"><br/>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" name="submit" id="submit" onclick="submitForm2('update_user_form_backend.php')" class="btn btn-primary" style="background-color:#1e73be;">submit</button>
                                </div>
                            </div>
<!--
                            <div class="form_row row">
                                <label class="col-lg-2 control-label">Submitted Time : </label>
                                <div class="col-md-6">
                                    <input type="text" name="createdby" class="form-control" id="createdby"
                                           value="<?php /*echo date('d-M-Y h:i:s', $create_date); */?>" disabled>
                                </div>
                            </div>
                            <br/>-->
                         </form>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <form action="" id="image_update" method="post" class="form-horizontal" style="width: 1320px;background-color: white;padding-top: 0px;">

        </form>
        <form action="" id="update-form" method="post" class="form-horizontal" style="width: 1320px;background-color: white;padding-top: 0px;">
            <!--<div class="form_row row">
                <label class="col-lg-2 control-label">Attachments : </label>
                <div class="col-md-6">
                    <input type="hidden" id="id" name="id" value="<?php /*echo $id; */?>">
                    <input type="file" name="file" id="file"><br/>
                </div>
                <div class="col-md-2">
                    <button type="button" name="submit" id="submit" class="btn btn-primary" onclick="submitForm2('update_user_form_backend.php')"  style="background-color:#1e73be;">submit</button>
                </div>
            </div>-->
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
                                <span class="media-annotation display-block mt-15"><?php echo $rowct["comment_date"];?> </span>
                            </div>
                        </li>
                    </ul>

                </div>
                <?php } ?>
            </div>
            <div class="form_row row">
                <label class="col-lg-2 control-label"></label>
                <div class="col-md-3">
            <input type="hidden" id="sender" name="sender" value="<?php echo $id; ?>">
            <textarea name="enter-message" style="padding-top: 20px;background-color: white;width: 250px;" class="form-control content-group enter-message" rows="3" cols="1" placeholder="Enter your message..."></textarea>
                </div>
            </div>
            <div class="row" style="padding-top: 0px;">
                <div class="col-xs-6 text-right" style="padding-left: 280px;">
                    <button type="button" class="btn btn-primary" onclick="submitForm('comment_backend.php')"  style="background-color:#1e73be;">Send</button>
                </div>
            </div>
        </form>
        <form action="" id="save_update" method="post" style="background-color: lightslategray;height: 70px;">
            <div class="form_row row">
                <label class="col-lg-2 control-label" style="padding-top: 15px">To close form : </label>
                <div class="col-md-3">
                    <div style="font-size: small !important;padding-top: 7px;">
                        <?php
                        $qurtemp = mysqli_query($db, "SELECT firstname,lastname FROM `cam_users` where pin_flag = '1' ");
                        $rowctemp = mysqli_fetch_array($qurtemp);
                        if ($rowctemp != NULL) {
                            $fullnn = $rowctemp["firstname"] . " " . $rowctemp["lastname"];
                        }
                        $fullnm = "";

                        ?>
                        <input type="hidden" id="userid" name="userid" value="<?php echo $id; ?>">
                        <input type="text" name="username" class="form-control" id="username"
                               value="<?php echo $fullnnm; ?>" disabled>
                    </div>

                </div>
                <div class="col-md-3">
                                            <span class="form_tab_td" id="approve_msg" style="float: left !important;width: 40% !important; padding-top: 5px;">
                                                            <input type="password" name="pin" id="pin"
                                                                   class="form-control" style=" margin-bottom: 5px;width: auto !important;"
                                                                   placeholder="Enter Pin..."  autocomplete="off" >
                                                            <span style="font-size: x-small;color: darkred; display: none;" id="pin_error">Invalid Pin.</span>
                                                        </span>
                </div>
                <div class="col-md-2" style="padding-top: 5px;">
                    <div class="col-xs-6 text-right" style="padding-left: 10px;">
                        <button type="button" class="btn btn-primary" onclick="submitForm1('savepin_backend.php')"  style="background-color:#1e73be;">Save</button>
                    </div>
                   <!-- <button type="submit" name="save" id="save" class="btn btn-primary"
                            style="background-color:#1e73be;">
                        Save
                    </button>-->
                </div>

            </div>
        </form>

</div>
<!-- /content area -->
</div>
<!-- /page container -->
<script>
    $("#commit").click(function (e) {
        if ($("#form_settings")[0].checkValidity()){
            var data = $("#form_update").serialize();
            $.ajax({
                type: 'POST',
                url: 'edit_rejection.php',
                dataType: "json",
                // context: this,
                async: false,
                data: data,
                success: function (data) {
                    $('#commit').attr('disabled', 'disabled');

                    $('#success_msg').text('Form submitted Successfully').css('background-color','#0080004f');
                    $("form :input").prop("disabled", true);
                    window.scrollTo(0, 0);

                }
            });
        }
        // e.preventDefault();
    });

</script>
<!--//to close the form-->
<script>
    function submitForm1(url) {
        //          $(':input[type="button"]').prop('disabled', true);
        var data = $("#save_update").serialize();
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function (data) {

                $("#input").val("")
                // window.location.href = window.location.href + "?aa=Line 1";
                //                   $(':input[type="button"]').prop('disabled', false);
                location.reload();
                $(".pin").val("");
            }
        });
    }

</script>
<!--chatbox message-->
<script>
    function submitForm(url) {
        //          $(':input[type="button"]').prop('disabled', true);
        var data = $("#update-form").serialize();
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function (data) {

                $("#textarea").val("")
                // window.location.href = window.location.href + "?aa=Line 1";
                //                   $(':input[type="button"]').prop('disabled', false);
                                  location.reload();
                $(".enter-message").val("");
            }
        });
    }

</script>
<script>
    function submitForm2(url) {
        //          $(':input[type="button"]').prop('disabled', true);
        var data = $("#form_update").serialize();
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function (data) {

                $("#input").val("")
                // window.location.href = window.location.href + "?aa=Line 1";
                //                   $(':input[type="button"]').prop('disabled', false);
                location.reload();
                $(".file").val("");
            }
        });
    }

</script>

<?php
/*$comment = $_POST['comment'];
$sqlt = "UPDATE `form_rejection_data` SET `comments`='$comment' where form_user_data_id = '$form_user_data_id'";
$qurmaint = mysqli_query($db, $sqlt);
if($qurmaint)
{
    echo 'success';
}else{
    echo 'fail';
}
*/?>
<script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/core/app.js"></script>
</body>

</html>