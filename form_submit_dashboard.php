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

$station = $_GET['station'];
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
<?php
$cust_cam_page_header = $c_name . " Form submit Dashboard";
include("header.php");
include("admin_menu.php");
include("heading_banner.php");
?>
<div class="content">
    <div class="row">

        <?php

        $countervariable = 0;

        $time = '';
        $qur1 = mysqli_query($db, "SELECT DISTINCT `form_type` FROM `form_user_data` where station = '$station'");
        while ($row1 = mysqli_fetch_array($qur1)) {
            $form_type = $row1["form_type"];

            $sql0 = "SELECT * FROM `form_type` where `form_type_id` = '$form_type'";
            $result0 = $mysqli->query($sql0);
            $rowc0 = $result0->fetch_assoc();
            $form_type_name = $rowc0['form_type_name'];

            $sql1 = "SELECT * FROM `form_user_data` where `form_type` = '$form_type'";
            $result1 = $mysqli->query($sql1);
            $rowc1 = $result1->fetch_assoc();
            $form_name = $rowc1['form_name'];
            $p_number = $rowc1['part_number'];
            $part_family = $rowc1['part_family'];
            $station = $rowc1['station'];
            $time = $rowc1['created_at'];

            $sql2 = "SELECT * FROM `cam_line` where `line_id` = '$station'";
            $result2 = $mysqli->query($sql2);
            $rowc2 = $result2->fetch_assoc();
            $line_name = $rowc2['line_name'];

            $sql3 = "SELECT * FROM `pm_part_family` where `pm_part_family_id` = '$part_family'";
            $result3 = $mysqli->query($sql3);
            $rowc3 = $result3->fetch_assoc();
            $part_family_name = $rowc3['part_family_name'];

            $sql4 = "SELECT * FROM `pm_part_number` where `pm_part_number_id` = '$p_number'";
            $result4 = $mysqli->query($sql4);
            $rowc4 = $result4->fetch_assoc();
            $part_number = $rowc4['part_number'];
            $part_name = $rowc4['part_name'];

            $countervariable++;

            ?>

            <?php if($form_type_name == 'First Piece Sheet Lab' ||  $form_type_name == 'First Piece Sheet Op' || $form_type_name == 'Parameter Sheet'){ ?>
                <div class="col-lg-3">
                    <div class="panel bg-blue-400">
                        <div class="panel-body">

                            <h3 class="no-margin dashboard_line_heading"><?php echo $form_type_name; ?></h3>
                            <hr/>

                            <table style="width:100%" id="t01">
                                <tr>
                                    <td>
                                        <div style="padding-top: 5px;font-size: initial; wi">Part Family :
                                        </div>
                                    </td>
                                    <td>
                                        <div><?php echo $part_family_name;
                                            $pf_name = ''; ?> </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div style="padding-top: 5px;font-size: initial;">Part Number :
                                        </div>
                                    </td>
                                    <td><span><?php echo $part_number;
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
                                    <td><span><?php echo $part_name;
                                            $p_name = ''; ?></span></td>
                                </tr>
                            </table>
                        </div>

                        <?php
                        $time_sql = "select * from form_user_data where form_type = '$form_type' and station = '$station' order by created_at DESC LIMIT 1";
                        $result_time = mysqli_query($db,$time_sql);
                        while ($row_time = mysqli_fetch_array($result_time)){
                            $form_create_id = $row_time['form_create_id'];
                            $created_time  =   $row_time['created_at'];
                            $create_t = explode(" ",$created_time);
                            $freq_time  =   $row_time['created_at'];

                            $s_arr_1 = explode(' ', $created_time);
                            $s_arr = explode(':', $s_arr_1[1]);
                            $st_time = $s_arr[0] + ($s_arr[1] / 60) + ($s_arr[2] / 3600);
                            $start_time = round($st_time, 2);

                            $time_freq = "select * from form_create where form_create_id = '$form_create_id' and station = '$station' order by created_by  DESC LIMIT 1";
                            $freq_res = mysqli_query($db,$time_freq);
                            while ($row_freq = mysqli_fetch_array($freq_res)){
                                $t11 =   $row_freq['frequency'];
                                $arrteam1 = explode(':', $t11);
                                $hours = $arrteam1[0];
                                $minutes = $arrteam1[1];
                                $hours1 = $hours * 60;
                                $minutes1 = $minutes + $hours1;
                                $date = $row_time["created_at"];
                                $date = strtotime($date);
                                $date = strtotime("+" . $minutes1 . " minute", $date);
                                $date = date('Y-m-d H:i:s', $date);
                                //  var_dump($t11);
                                $total_time = $start_time + $t11;
                                //  var_dump($total_time);


                                ?>
                                <div style="height: 100%;">
                                    <input type="hidden" id="id<?php echo $countervariable; ?>" value="<?php echo $date; ?>">
                                    <input type="hidden" id="freq_time<?php echo $countervariable; ?>" value="<?php echo $freq_time; ?>">
                                    <h4 style="height:inherit;text-align: center;background-color:green;color: #fff;">
                                        <div style="padding: 10px 0px 5px 0px;">
                                            <span style="padding: 0px 0px 10px 0px;" id="demo<?php echo $countervariable; ?>">&nbsp;</span>
<!--                                             <span id="timer--><?php //echo $countervariable; ?><!--"></span>-->
                                            <span id="server-load"></span>
                                        </div>
                                    </h4>
                                </div>
                                <script>
                                    (function(){
                                        $(document).ready(function() {
                                            var iddd<?php echo $countervariable; ?> = $("#id<?php echo $countervariable; ?>").val();
                                            var freq_time<?php echo $countervariable; ?> = $("#freq_time<?php echo $countervariable; ?>").val();
                                            var countDownDate<?php echo $countervariable; ?> = new Date(iddd<?php echo $countervariable; ?>).getTime();
                                            var countDownfreq_time<?php echo $countervariable; ?> = new Date(freq_time<?php echo $countervariable; ?>).getTime();
                                            var distance<?php echo $countervariable; ?> =  countDownDate<?php echo $countervariable; ?> - countDownfreq_time<?php echo $countervariable; ?>;
                                            var diffHrs<?php echo $countervariable; ?> = Math.floor((distance<?php echo $countervariable; ?> % 86400000) / 3600000); // hours
                                            var diffMins<?php echo $countervariable; ?> = Math.round(((distance<?php echo $countervariable; ?> % 86400000) % 3600000) / 60000); // minutes
                                            var diffSec<?php echo $countervariable; ?> = Math.floor((distance<?php echo $countervariable; ?> % (1000 * 60)) / 1000); //seconds
                                            //  parts = distance.split(':'),
                                                hours<?php echo $countervariable; ?> = diffHrs<?php echo $countervariable; ?>,
                                                minutes<?php echo $countervariable; ?> = diffMins<?php echo $countervariable; ?>,
                                                seconds<?php echo $countervariable; ?> = diffSec<?php echo $countervariable; ?>,
                                                 span = $('#demo<?php echo $countervariable; ?>');

                                                function correctNum<?php echo $countervariable; ?>(num<?php echo $countervariable; ?>) {
                                                    return (num<?php echo $countervariable; ?><10)? ("0"+num<?php echo $countervariable; ?>):num<?php echo $countervariable; ?>;
                                                }

                                            var timer<?php echo $countervariable; ?> = setInterval(function(){
                                                seconds<?php echo $countervariable; ?>--;
                                                if(seconds<?php echo $countervariable; ?> == -1) {
                                                    seconds<?php echo $countervariable; ?> = 59;
                                                    minutes<?php echo $countervariable; ?>--;

                                                    if(minutes<?php echo $countervariable; ?> == -1) {
                                                        minutes<?php echo $countervariable; ?> = 59;
                                                        hours<?php echo $countervariable; ?>--;

                                                        if(hours<?php echo $countervariable; ?>==-1) {
                                                            //    alert("timer finished");
                                                            clearInterval(timer<?php echo $countervariable; ?>);
                                                            return;
                                                        }
                                                    }
                                                }
                                                span.text(correctNum<?php echo $countervariable; ?>(hours<?php echo $countervariable; ?>) + ":" + correctNum<?php echo $countervariable; ?>(minutes<?php echo $countervariable; ?>) + ":" + correctNum<?php echo $countervariable; ?>(seconds<?php echo $countervariable; ?>));
                                            }, 1000);
                                        });
                                    })()
                                </script>
                            <?php } }?>
                    </div>
                </div>
            <?php } }?>
    </div>
</div>
</body>