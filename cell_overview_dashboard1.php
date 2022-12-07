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
$cell_name = $_GET['c_name'];
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
<?php
$station_id = null;
$event_line = $_GET['line'];
$user_id = $_SESSION["id"];
$chicagotime = date("Y-m-d H:i:s");
if (count($_POST) > 0) {

    $station_id = $_POST['station'];
    if(($station_id == null || $station_id =='') && (($event_line != null) && ($event_line != ''))){
        $station_id = $event_line;
    }
    $part_family_id = $_POST['part_family'];
    $part_number = $_POST['part_number'];
    $event_type_id = $_POST['event_type_id'];
    $e_event_id = $_POST['edit_event_type'];
    $edit_event_id = explode("_",$e_event_id)[0];
    $station_event_id = $_POST['station_event_id'];
    $event_seq = $_POST['event_seq'];
    $event_total_time = $_POST['total_time'];

    // Edit Event
    if ($edit_event_id != "") {
        $reason =  $_POST['edit_reason'];
        $station_event_id = $_POST['edit_id'];

        /*Update the log table with the event value*/
        $sql = "select * from event_type where so = (select (MAX(so)) as max_seq_num from event_type)";
        $res = mysqli_query($db, $sql);
        $firstrow = mysqli_fetch_array($res);
        $max_seq = $firstrow['so'];
        $fr_event_type_id = $firstrow['event_type_id'];
        $event_status_lat = 1;

        $qur1 = "select (count(station_event_id)) as seq_num from sg_station_event_log WHERE station_event_id='$station_event_id'";
        $res = mysqli_query($db, $qur1);
        $firstrow = mysqli_fetch_array($res);
        $curr_seq = $firstrow['seq_num'];
        $next_seq = $curr_seq + 1;

        $qur2="Select SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF('$chicagotime', created_on))) as completed_time from `sg_station_event_log` WHERE station_event_id = '$station_event_id' and event_seq = '$curr_seq'";
        $res = mysqli_query($db, $qur2);
        $firstrow = mysqli_fetch_array($res);
        $total_time = $firstrow['completed_time'];

        $qur22="Select event_cat_id as cat_id from `event_type` WHERE event_type_id = '$edit_event_id'";
        $res = mysqli_query($db, $qur22);
        $firstrow = mysqli_fetch_array($res);
        $event_cat_id = $firstrow['cat_id'];



        $qur3 = "update `sg_station_event_log` set total_time = '$total_time' , is_incomplete = '0' where station_event_id = '$station_event_id' and event_seq = '$curr_seq'";
        $result0 = mysqli_query($db, $qur3);



        $res_event = "select event_type_id from sg_station_event where station_event_id = '$station_event_id'";
        $sta_res = mysqli_query($db,$res_event);
        $event_row = mysqli_fetch_array($sta_res);
        $is_present = $event_row['event_type_id'];

        if ($is_present == '7' ){
            $message_stauts_class = 'alert-success';
            $import_status_message = 'Event cycle was already Ended.';
        }else{
            if ($edit_event_id == $fr_event_type_id) {
                $sql = "update sg_station_event set event_status = '0' ,event_type_id='$edit_event_id', modified_on='$chicagotime', modified_by='$user_id' where  station_event_id = '$station_event_id'";
                $result1 = mysqli_query($db, $sql);
                if ($result1) {
                    $message_stauts_class = 'alert-success';
                    $import_status_message = 'Event Cycle Completed for the Station.';
                } else {
                    $message_stauts_class = 'alert-danger';
                    $import_status_message = 'Error: Please Insert valid data';
                }

                $sql = "INSERT INTO `sg_station_event_log`(`station_event_id`  ,`reason`,`event_seq`, `event_type_id`,`event_cat_id`, `event_status` , `created_on` ,`created_by`) VALUES ('$station_event_id','$reason','$next_seq','$edit_event_id','$event_cat_id',0,'$chicagotime','$user_id')";
                $result0 = mysqli_query($db, $sql);



            } else {
                $sql = "update sg_station_event set event_type_id='$edit_event_id', reason='$reason' ,modified_on='$chicagotime', modified_by='$user_id' where  station_event_id = '$station_event_id'";
                $result1 = mysqli_query($db, $sql);
                if ($result1) {

                    $message_stauts_class = 'alert-success';
                    $import_status_message = 'Event status Updated successfully.';
                } else {
                    $message_stauts_class = 'alert-danger';
                    $import_status_message = 'Error: Please Insert valid data';
                }
                $sql = "INSERT INTO `sg_station_event_log`(`station_event_id` ,`reason`,`event_seq` , `event_type_id`,`event_cat_id`, `event_status` , `created_on` ,`created_by`) VALUES ('$station_event_id','$reason','$next_seq','$edit_event_id','$event_cat_id',1,'$chicagotime','$user_id')";
                $result0 = mysqli_query($db, $sql);


            }
        }
    } else {
        if (($part_number != "") && ($station_id != "") && ($part_family_id != "") && ($event_type_id != "")) {

//production cycle is already active code
            $sql_production = "select * from sg_station_event where line_id = '$station_id'  and event_status = '1'";
            $res_production = mysqli_query($db, $sql_production);
            $firstrow_production = mysqli_fetch_array($res_production);
//		$condition = $firstrow_production['station_event_id'];

            if ($firstrow_production) {
                $message_stauts_class = 'alert-danger';
                $import_status_message = 'Error: This Station already has an active event.';
            } else {

                $sql0 = "INSERT INTO `sg_station_event`(`line_id` , `part_family_id`, `part_number_id` , `event_type_id` ,`created_on`,`created_by`,`modified_on`,`modified_by`) VALUES ('$station_id','$part_family_id','$part_number','$event_type_id','$chicagotime','$user_id','$chicagotime','$user_id')";
                $result0 = mysqli_query($db, $sql0);
                $station_event_id = ($db->insert_id);

                if ($result0) {
                    $qur1 = "select (count(station_event_id)) as seq_num from sg_station_event_log WHERE station_event_id='$station_event_id'";
                    $res = mysqli_query($db, $qur1);
                    $firstrow = mysqli_fetch_array($res);
                    $curr_seq = $firstrow['seq_num'];
                    $next_seq = $curr_seq + 1;

//					$qq = "SELECT max(station_event_log_id)  as prev_log_id FROM `sg_station_event_log` as sl inner join sg_station_event as se on sl.station_event_id = se.station_event_id where se.line_id = '$station_id' and sl.event_status = 0 order by sl.created_on";
                    $qq = "SELECT max(station_event_log_id) as prev_log_id , sl.created_on as prev_st_time FROM `sg_station_event_log` as sl inner join sg_station_event as se on sl.station_event_id = se.station_event_id where se.line_id = '$station_id' and sl.event_status = 0 group by sl.created_on order by sl.created_on desc LIMIT 1";
                    $res = mysqli_query($db, $qq);
                    $firstrow = mysqli_fetch_array($res);
                    $prev_seq = $firstrow['prev_log_id'];
                    $prev_time = $firstrow['prev_st_time'];

                    $qur22="Select event_cat_id as cat_id from `event_type` WHERE event_type_id = '$event_type_id'";
                    $res = mysqli_query($db, $qur22);
                    $firstrow = mysqli_fetch_array($res);
                    $event_cat_id = $firstrow['cat_id'];

                    $qur2="Select SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF('$chicagotime', '$prev_time'))) as completed_time";
                    $res = mysqli_query($db, $qur2);
                    $firstrow = mysqli_fetch_array($res);
                    $total_time = $firstrow['completed_time'];

                    $qur4 = "update `sg_station_event_log` set total_time = '$total_time' , is_incomplete = '0' where station_event_log_id = '$prev_seq'";
                    $result0 = mysqli_query($db, $qur4);


                    $sql0 = "INSERT INTO `sg_station_event_log`(`station_event_id` ,`event_seq`, `event_type_id`,`event_cat_id`, `event_status` , `created_on` ,`created_by`) VALUES ('$station_event_id','$next_seq','$event_type_id','$event_cat_id',1,'$chicagotime','$user_id')";
                    $result0 = mysqli_query($db, $sql0);




                    $message_stauts_class = 'alert-success';
                    $import_status_message = 'Station Event Created successfully.';
                } else {
                    $message_stauts_class = 'alert-danger';
                    $import_status_message = 'Error: Please Insert valid data';
                }

            }
        }
    }
}else{
    $station_id = $event_line;
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
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-base.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-data-adapter.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-ui.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-exports.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-pareto.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-core.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-circular-gauge.min.js"></script>
    <link href="https://cdn.anychart.com/releases/8.11.0/css/anychart-ui.min.css" type="text/css" rel="stylesheet">
    <link href="https://cdn.anychart.com/releases/8.11.0/fonts/css/anychart-font.min.css" type="text/css"
          rel="stylesheet">
    <!-- /global stylesheets -->
    <!-- Theme JS files -->
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
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/components_modals.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/form_bootstrap_select.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/form_layouts.js"></script>
    <script type="text/javascript" src="assets/js/time_display.js"></script>
    <script>
        $(document).ready(function () {

            $('.e_progress .circle').removeClass().addClass('circle');
            $('.e_progress .bar').removeClass().addClass('bar');
            $(".circle").first().addClass("active");

            var timer = setInterval(increment, 1000);

            function increment() {
                $(".circle:not(.done)").first().removeClass("active").addClass("done").children(":first-child").html("&#10003;");
                $(".circle:not(.done)").first().addClass("active");
                $(".circle.done").next().addClass("done");
                if ($(".active").find(".title").text() == $("tr:last-child").find("span").text()) {
                    clearInterval(timer);
                }
            }
        });
    </script>

</head>
<script>
    $('#eff_container').load('../gbp_dashboard.php #eff_container');
</script>
<!--chart -->
<style>
    .panel-body>.heading-elements{
        z-index: 0;
    }
    .panel[class*=bg-]>.panel-body {
        background-color: inherit;
        height: 230px!important;
    }
    tbody, td, th, thead, tr {

        font-size: 14px;
    }
    .col-lg-3 {
        /*font-size: 12px!important;*/
    }
    .open > .dropdown-menu {
        min-width: 210px !important;
    }

    td {
        /*width: 50% !important;*/
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
    .overlay {
        height: 100%;
        width: 100%;
        display: none;
        position: fixed;
        z-index: 1;
        top: 0;
        left: 0;
        background-color: rgb(0,0,0);
        /*background-color: rgba(0,0,0, 0.9);*/
    }

    .overlay-content {
        position: relative;
        /*top: 25%;*/
        width: 100%;
        text-align: center;
        margin-top: 30px;
    }

    .overlay a {
        /*padding: 8px;*/
        /*text-decoration: none;*/
        /*font-size: 36px;*/
        /*color: #818181;*/
        /*display: block;*/
        /*transition: 0.3s;*/
    }

    .overlay a:hover, .overlay a:focus {
        color: #f1f1f1;
    }

    .overlay .closebtn {
        position: absolute;
        top: -20px;
        right: 45px;
        font-size: 60px;
    }

    @media screen and (max-height: 450px) {
        .overlay a {font-size: 14px}
        .overlay .closebtn {
            font-size: 40px;
            top: 0px;
            right: 30px;
        }
    }

    .dataTable {
        width: 100%!important;
    }
    .datatable-footer>div:first-child, .datatable-header>div:first-child {
        margin-left: 20px;
    }
    .dataTables_length {
        margin: 0 30px 18px 37px!important;
    }
    .create {
        float: right;
        padding: 38px;
        margin-top: 0px;
    }
</style>    <!-- /theme JS files -->
<style>
    /* HTML5 display-role reset for older browsers */
    article, aside, details, figcaption, figure,
    footer, header, hgroup, menu, nav, section, main {
        display: block;
    }

    /* --------------------------------
    --------------------

    Main components

    -------------------------------- */

    .cd-popup-trigger {
        display: block;
        width: 246px;
        height: 50px;
        line-height: 50px;
        margin: 3em auto;
        text-align: center;
        color: #FFF;
        font-size: 14px;
        font-weight: bold;
        text-transform: uppercase;
        border-radius: 50em;
        background: #191e3a;
        box-shadow: 0 3px 0 rgba(0, 0, 0, 0.07);
    }
    /* --------------------------------

    xpopup

    -------------------------------- */
    .cd-popup {
        position: fixed;
        left: 0;
        top: 0;
        height: 100%;
        width: 100%;
        background-color: rgba(94, 110, 141, 0.9);
        opacity: 0;
        visibility: hidden;
        -webkit-transition: opacity 0.3s 0s, visibility 0s 0.3s;
        -moz-transition: opacity 0.3s 0s, visibility 0s 0.3s;
        transition: opacity 0.3s 0s, visibility 0s 0.3s;
    }
    .cd-popup.is-visible {
        opacity: 1;
        visibility: visible;
        -webkit-transition: opacity 0.3s 0s, visibility 0s 0s;
        -moz-transition: opacity 0.3s 0s, visibility 0s 0s;
        transition: opacity 0.3s 0s, visibility 0s 0s;
    }

    .cd-popup-container {
        position: relative;
        width: 100%;
        height:100%;
        background: #060818;
        border-radius: .25em .25em .4em .4em;
        text-align: center;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        -webkit-transform: translatex(-400px);
        -moz-transform: translatex(-400px);
        -ms-transform: translatex(-400px);
        -o-transform: translatex(-400px);
        transform: translatex(-400px);
        /* Force Hardware Acceleration in WebKit */
        -webkit-backface-visibility: hidden;
        -webkit-transition-property: -webkit-transform;
        -moz-transition-property: -moz-transform;
        transition-property: transform;
        -webkit-transition-duration: 0.5s;
        -moz-transition-duration: 0.5s;
        transition-duration: 0.5s;
        overflow: scroll;
    }
    .cd-popup-container p {
        padding: 0px;
        margin:0px;
    }

    .cd-popup-container .cd-popup-close {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 30px;
        height: 30px;
    }
    .cd-popup-container .cd-popup-close::before, .cd-popup-container .cd-popup-close::after {
        content: '';
        position: absolute;
        top: 12px;
        width: 14px;
        height: 3px;
        background-color: #8f9cb5;
    }
    .cd-popup-container .cd-popup-close::before {
        -webkit-transform: rotate(45deg);
        -moz-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        -o-transform: rotate(45deg);
        transform: rotate(45deg);
        left: 8px;
    }
    .cd-popup-container .cd-popup-close::after {
        -webkit-transform: rotate(-45deg);
        -moz-transform: rotate(-45deg);
        -ms-transform: rotate(-45deg);
        -o-transform: rotate(-45deg);
        transform: rotate(-45deg);
        right: 8px;
    }
    .is-visible .cd-popup-container {
        -webkit-transform: translateX(0);
        -moz-transform: translateX(0);
        -ms-transform: translateX(0);
        -o-transform: translateX(0);
        transform: translateX(0);
    }
    .10x_content_img {
           width: 113px;
           float: left;
           margin-right: 5px;
           border: 1px solid gray;
           border-radius: 3px;
           padding: 5px;
           margin-top: 10px;
       }

    /* Delete */
    .10x_content_img span {
           border: 2px solid red;
           display: inline-block;
           width: 99%;
           text-align: center;
           color: red;
       }

    .10x_content_img span:hover {
           cursor: pointer;
       }

    .mat_content_img {
        width: 113px;
        float: left;
        margin-right: 5px;
        border: 1px solid gray;
        border-radius: 3px;
        padding: 5px;
        margin-top: 10px;
    }

    /* Delete */
    .mat_content_img span {
        border: 2px solid red;
        display: inline-block;
        width: 99%;
        text-align: center;
        color: red;
    }

    .mat_content_img span:hover {
        cursor: pointer;
    }
    iframe {
        width: 90%;
        border: 0;
        height: 100%;
    }
</style>

</head>
<body>
<!-- Main navbar -->
<!-- /main navbar -->
<?php
$c_name = $_GET['c_name'];
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
        $qur01 = mysqli_query($db, "SELECT pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,pf.pm_part_family_id as pf_no, et.event_type_name as e_name ,et.color_code as color_code , sg_events.modified_on as updated_time ,sg_events.station_event_id as station_event_id , sg_events.event_status as event_status , sg_events.created_on as e_start_time FROM sg_station_event as sg_events inner join event_type as et on sg_events.event_type_id=et.event_type_id Inner Join pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on sg_events.part_number_id=pn.pm_part_number_id where sg_events.line_id= '$line' ORDER by sg_events.created_on DESC LIMIT 1");
        $rowc01 = mysqli_fetch_array($qur01);
        if ($rowc01 != null) {
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
                    <div id="myNav" class="overlay">
                        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                        <div class="overlay-content">
                            <div class="row">
                                <?php if ($event_status != '0' && $event_status != '') { ?>
                                    <div class="col-sm-4">
                                        <a href="#0" id="pop1btn" class="cd-popup-trigger" onclick="openpopup('pop1')">Good & Bad Piece</a>
                                        <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop2')" >Material Tracability</a>
                                        <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop3')" >View Material Tracability</a>
                                        <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop4')" >Submit 10X</a>
                                        <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop5')" >View 10X</a>
                                    </div>
                                <?php } ?>
                                <div class="col-sm-4">
                                    <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop6')" >View Station Status</a>
                                    <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop7')" >Add / Update Events</a>
                                    <?php if (($_SESSION['role_id'] == 'admin') || ($_SESSION['role_id'] == 'super')) { ?>
                                        <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop8')" >Create Form</a>
                                    <?php } ?>
                                </div>
                                <div class="col-sm-4">
                                    <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop9')" >Submit Form</a>
                                    <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop10')" >Assign / Unassign Crew</a>
                                    <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop11')" >View Assigned Crew</a>
                                    <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop12')" >View Document</a>
                                    <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop12')" >Submit Station Assets</a>
                                </div>
                            </div>

                            <div id="pop1" class="cd-popup" role="alert">
                                <div class="cd-popup-container station_event_id" value="<?php echo $station_event_id; ?>">
                                    <iframe id='iframe' src="<?php echo $siteURL; ?>events_module/good_bad_piece.php?station_event_id=<?php echo $station_event_id; ?>">

                                    </iframe>
                                    <a href="#0" class="cd-popup-close"></a>
                                </div> <!-- cd-popup-container -->
                            </div> <!-- cd-popup -->

                            <div id="pop2" class="cd-popup" role="alert">
                                <div class="cd-popup-container">
                                    <iframe id='iframe' src="<?php echo $siteURL; ?>material_tracability/material_tracability.php?station=<?php echo $line; ?>&station_event_id=<?php echo $station_event_id; ?>">

                                    </iframe>
                                    <a href="#0" class="cd-popup-close"></a>
                                </div> <!-- cd-popup-container -->
                            </div> <!-- cd-popup -->

                            <div id="pop3" class="cd-popup" role="alert">
                                <div class="cd-popup-container">
                                    <iframe id='iframe' src="<?php echo $siteURL; ?>material_tracability/material_search.php?station=<?php echo $line; ?>&station_event_id=<?php echo $station_event_id; ?>">

                                    </iframe>
                                    <a href="#0" class="cd-popup-close"></a>
                                </div> <!-- cd-popup-container -->
                            </div> <!-- cd-popup -->

                            <div id="pop4" class="cd-popup" role="alert">
                                <div class="cd-popup-container">
                                    <iframe id='iframe' src="<?php echo $siteURL; ?>10x/10x.php?station=<?php echo $line; ?>&station_event_id=<?php echo $station_event_id; ?>">

                                    </iframe>
                                    <a href="#0" class="cd-popup-close"></a>
                                </div> <!-- cd-popup-container -->
                            </div> <!-- cd-popup -->

                            <div id="pop5" class="cd-popup" role="alert">
                                <div class="cd-popup-container">
                                    <iframe id='iframe' src="<?php echo $siteURL; ?>10x/10x_search.php?station=<?php echo $line; ?>&station_event_id=<?php echo $station_event_id; ?>">

                                    </iframe>
                                    <a href="#0" class="cd-popup-close"></a>
                                </div> <!-- cd-popup-container -->
                            </div> <!-- cd-popup -->

                            <div id="pop6" class="cd-popup" role="alert">
                                <div class="cd-popup-container">
                                    <iframe id='iframe' src="<?php echo $siteURL; ?>view_station_status.php?station=<?php echo $line; ?>">

                                    </iframe>

                                    <a href="#0" class="cd-popup-close"></a>
                                </div> <!-- cd-popup-container -->
                            </div> <!-- cd-popup -->

                            <div id="pop7" class="cd-popup" role="alert">
                                <div class="cd-popup-container">
                                    <iframe id='iframe' src="<?php echo $siteURL; ?>events_module/station_events.php">

                                    </iframe>
                                    <a href="#0" class="cd-popup-close"></a>
                                </div> <!-- cd-popup-container -->
                            </div> <!-- cd-popup -->

                            <div id="pop8" class="cd-popup" role="alert">
                                <div class="cd-popup-container">
                                    <iframe id='iframe' src="<?php echo $siteURL; ?>form_module/form_settings.php?station=<?php echo $line; ?>">

                                    </iframe>
                                    <a href="#0" class="cd-popup-close"></a>
                                </div> <!-- cd-popup-container -->
                            </div> <!-- cd-popup -->

                            <div id="pop9" class="cd-popup" role="alert">
                                <div class="cd-popup-container">
                                    <p>Are you sure you want to delete this element 9 ?</p>
                                    <a href="#0" class="cd-popup-close"></a>
                                </div> <!-- cd-popup-container -->
                            </div> <!-- cd-popup -->

                            <div id="pop10" class="cd-popup" role="alert">
                                <div class="cd-popup-container">
                                    <p>Are you sure you want to delete this element 10 ?</p>
                                    <a href="#0" class="cd-popup-close"></a>
                                </div> <!-- cd-popup-container -->
                            </div> <!-- cd-popup -->

                            <div id="pop11" class="cd-popup" role="alert">
                                <div class="cd-popup-container">
                                    <p>Are you sure you want to delete this element 11 ?</p>
                                    <a href="#0" class="cd-popup-close"></a>
                                </div> <!-- cd-popup-container -->
                            </div> <!-- cd-popup -->

                            <div id="pop12" class="cd-popup" role="alert">
                                <div class="cd-popup-container">
                                    <p>Are you sure you want to delete this element 12 ?</p>
                                    <a href="#0" class="cd-popup-close"></a>
                                </div> <!-- cd-popup-container -->
                            </div> <!-- cd-popup -->


                        </div>

                    </div>

                    <span style="font-size:30px;cursor:pointer;float: right;margin-top: -10px;" onclick="openNav()">&#9776;</span>
                    <h3 class="no-margin dashboard_line_heading"><?php echo $rowc_new["line_name"]; ?></h3>
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
                        function calcTime(city, offset) {
                            d = new Date();
                            utc = d.getTime() + (d.getTimezoneOffset() * 60000);
                            nd = new Date(utc + (3600000 * offset));
                            return nd;
                        }

                        // Set the date we're counting down to
                        var iddd<?php echo $countervariable; ?> = $("#id<?php echo $countervariable; ?>").val();
                        console.log(iddd<?php echo $countervariable; ?>);
                        var countDownDate<?php echo $countervariable; ?> = new Date(iddd<?php echo $countervariable; ?>).getTime();
                        // Update the count down every 1 second
                        var x = setInterval(function () {
                            // Get today's date and time
                            var now = calcTime('Chicago', '-6');
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
                <div id="myNav" class="overlay">
                    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                    <div class="overlay-content">
                        <div class="row">
                            <div class="col-sm-4">
                                <a href="#0" id="pop1btn" class="cd-popup-trigger" onclick="openpopup('pop1')">Good & Bad Piece</a>
                                <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop2')" >Material Tracability</a>
                                <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop3')" >View Material Tracability</a>
                                <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop4')" >Submit 10X</a>
                            </div>
                            <div class="col-sm-4">
                                <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop5')" >View 10X</a>
                                <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop6')" >View Station Status</a>
                                <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop7')" >Add / Update Events</a>
                                <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop8')" >Create Form</a>
                            </div>
                            <div class="col-sm-4">
                                <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop9')" >Submit Form</a>
                                <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop10')" >Assign / Unassign Crew</a>
                                <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop11')" >View Assigned Crew</a>
                                <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop12')" >View Document</a>
                                <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop12')" >Submit Station Assets</a>
                            </div>
                        </div>

                        <div id="pop1" class="cd-popup" role="alert">
                            <div class="cd-popup-container station_event_id" value="<?php echo $station_event_id; ?>">
                                <iframe id='iframe' src="<?php echo $siteURL; ?>events_module/good_bad_piece.php?station_event_id=<?php echo $station_event_id; ?>">

                                </iframe>
                                <a href="#0" class="cd-popup-close"></a>
                            </div> <!-- cd-popup-container -->
                        </div> <!-- cd-popup -->

                        <div id="pop2" class="cd-popup" role="alert">
                            <div class="cd-popup-container">
                                <iframe id='iframe' src="<?php echo $siteURL; ?>material_tracability/material_tracability.php?station=<?php echo $line; ?>&station_event_id=<?php echo $station_event_id; ?>">

                                </iframe>
                                <a href="#0" class="cd-popup-close"></a>
                            </div> <!-- cd-popup-container -->
                        </div> <!-- cd-popup -->

                        <div id="pop3" class="cd-popup" role="alert">
                            <div class="cd-popup-container">
                                <iframe id='iframe' src="<?php echo $siteURL; ?>material_tracability/material_search.php?station=<?php echo $line; ?>&station_event_id=<?php echo $station_event_id; ?>">

                                </iframe>
                                <a href="#0" class="cd-popup-close"></a>
                            </div> <!-- cd-popup-container -->
                        </div> <!-- cd-popup -->

                        <div id="pop4" class="cd-popup" role="alert">
                            <div class="cd-popup-container">
                                <iframe id='iframe' src="<?php echo $siteURL; ?>10x/10x.php?station=<?php echo $line; ?>&station_event_id=<?php echo $station_event_id; ?>">

                                </iframe>
                                <a href="#0" class="cd-popup-close"></a>
                            </div> <!-- cd-popup-container -->
                        </div> <!-- cd-popup -->

                        <div id="pop5" class="cd-popup" role="alert">
                            <div class="cd-popup-container">
                                <iframe id='iframe' src="<?php echo $siteURL; ?>10x/10x_search.php?station=<?php echo $line; ?>&station_event_id=<?php echo $station_event_id; ?>">

                                </iframe>
                                <a href="#0" class="cd-popup-close"></a>
                            </div> <!-- cd-popup-container -->
                        </div> <!-- cd-popup -->

                        <div id="pop6" class="cd-popup" role="alert">
                            <div class="cd-popup-container">
                                <iframe id='iframe' src="<?php echo $siteURL; ?>view_station_status.php?station=<?php echo $line; ?>">

                                </iframe>

                                <a href="#0" class="cd-popup-close"></a>
                            </div> <!-- cd-popup-container -->
                        </div> <!-- cd-popup -->

                        <div id="pop7" class="cd-popup" role="alert">
                            <div class="cd-popup-container">
                                <iframe id='iframe' src="<?php echo $siteURL; ?>events_module/station_events.php">

                                </iframe>
                                <a href="#0" class="cd-popup-close"></a>
                            </div> <!-- cd-popup-container -->
                        </div> <!-- cd-popup -->

                        <div id="pop8" class="cd-popup" role="alert">
                            <div class="cd-popup-container">
                                <iframe id='iframe' src="<?php echo $siteURL; ?>form_module/form_settings.php?station=<?php echo $line; ?>">

                                </iframe>
                                <a href="#0" class="cd-popup-close"></a>
                            </div> <!-- cd-popup-container -->
                        </div> <!-- cd-popup -->

                        <div id="pop9" class="cd-popup" role="alert">
                            <div class="cd-popup-container">
                                <p>Are you sure you want to delete this element 9 ?</p>
                                <a href="#0" class="cd-popup-close"></a>
                            </div> <!-- cd-popup-container -->
                        </div> <!-- cd-popup -->

                        <div id="pop10" class="cd-popup" role="alert">
                            <div class="cd-popup-container">
                                <p>Are you sure you want to delete this element 10 ?</p>
                                <a href="#0" class="cd-popup-close"></a>
                            </div> <!-- cd-popup-container -->
                        </div> <!-- cd-popup -->

                        <div id="pop11" class="cd-popup" role="alert">
                            <div class="cd-popup-container">
                                <p>Are you sure you want to delete this element 11 ?</p>
                                <a href="#0" class="cd-popup-close"></a>
                            </div> <!-- cd-popup-container -->
                        </div> <!-- cd-popup -->

                        <div id="pop12" class="cd-popup" role="alert">
                            <div class="cd-popup-container">
                                <p>Are you sure you want to delete this element 12 ?</p>
                                <a href="#0" class="cd-popup-close"></a>
                            </div> <!-- cd-popup-container -->
                        </div> <!-- cd-popup -->


                    </div>

                </div>

                <span style="font-size:30px;cursor:pointer;float: right;margin-top: -10px;" onclick="openNav()">&#9776;</span>
                <h3 class="no-margin dashboard_line_heading"><?php echo $rowc_new["line_name"]; ?></h3>
                <hr/>

                <table style="width:100%" id="t01">
                    <tr>
                        <td>
                            <div style="padding-top: 5px;font-size: initial; ">Part Family :</div>
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
                    function calcTime(city, offset) {
                        d = new Date();
                        utc = d.getTime() + (d.getTimezoneOffset() * 60000);
                        nd = new Date(utc + (3600000 * offset));
                        return nd;
                    }

                    // Set the date we're counting down to
                    var iddd<?php echo $countervariable; ?> = $("#id<?php echo $countervariable; ?>").val();
                    console.log(iddd<?php echo $countervariable; ?>);
                    var countDownDate<?php echo $countervariable; ?> = new Date(iddd<?php echo $countervariable; ?>).getTime();
                    // Update the count down every 1 second
                    var x = setInterval(function () {
                        // Get today's date and time
                        var now = calcTime('Chicago', '-6');
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

            $event_status = '';
            $line_status_text = '';
            $buttonclass = '#000';
            $p_num = '';
            $p_name = '';
            $pf_name = '';
            $time = '';
            $countervariable++;
            $qur01 = mysqli_query($db, "SELECT sg_events.line_id,pn.part_number as p_num, pn.pm_part_number_id as p_no, pn.part_name as p_name , pf.part_family_name as pf_name,pf.pm_part_family_id as pf_no, et.event_type_name as e_name ,et.color_code as color_code , sg_events.modified_on as updated_time ,sg_events.station_event_id as station_event_id , sg_events.event_status as event_status , sg_events.created_on as e_start_time FROM sg_station_event as sg_events inner join event_type as et on sg_events.event_type_id=et.event_type_id Inner Join pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on sg_events.part_number_id=pn.pm_part_number_id where sg_events.line_id= '$line' ORDER by sg_events.created_on DESC LIMIT 1");
            $rowc01 = mysqli_fetch_array($qur01);
            if ($rowc01 != null) {
                $station_id = $rowc01['line_id'];
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
            $query_new = sprintf("SELECT line_id,line_name FROM  cam_line where line_id = '$station_id'");
            $qur_new = mysqli_query($db, $query_new);
            $rowc_new = mysqli_fetch_array($qur_new);



            if ($countervariable % 4 == 0) {
                ?>
                <!--								<div class="row">-->
                <div class="col-lg-3">
                    <div class="panel bg-blue-400">
                        <div class="panel-body">
                            <div id="myNav" class="overlay">
                                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                                <div class="overlay-content">
                                    <div class="row">
                                        <?php if ($event_status != '0' && $event_status != '') { ?>
                                            <div class="col-sm-4">
                                                <a href="#0" id="pop1btn" class="cd-popup-trigger" onclick="openpopup('pop1')">Good & Bad Piece</a>
                                                <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop2')" >Material Tracability</a>
                                                <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop3')" >View Material Tracability</a>
                                                <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop4')" >Submit 10X</a>
                                                <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop5')" >View 10X</a>
                                            </div>
                                        <?php } ?>
                                        <div class="col-sm-4">

                                            <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop6')" >View Station Status</a>
                                            <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop7')" >Add / Update Events</a>
                                            <?php if (($_SESSION['role_id'] == 'admin') || ($_SESSION['role_id'] == 'super')) { ?>
                                                <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop8')" >Create Form</a>
                                            <?php } ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop9')" >Submit Form</a>
                                            <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop10')" >Assign / Unassign Crew</a>
                                            <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop11')" >View Assigned Crew</a>
                                            <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop12')" >View Document</a>
                                            <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop12')" >Submit Station Assets</a>
                                        </div>
                                    </div>

                                    <div id="pop1" class="cd-popup" role="alert">
                                        <div class="cd-popup-container station_event_id" value="<?php echo $station_event_id; ?>">
                                            <iframe id='iframe' src="<?php echo $siteURL; ?>events_module/good_bad_piece.php?station_event_id=<?php echo $station_event_id; ?>">

                                            </iframe>
                                            <a href="#0" class="cd-popup-close"></a>
                                        </div> <!-- cd-popup-container -->
                                    </div> <!-- cd-popup -->

                                    <div id="pop2" class="cd-popup" role="alert">
                                        <div class="cd-popup-container">
                                            <iframe id='iframe' src="<?php echo $siteURL; ?>material_tracability/material_tracability.php?station=<?php echo $line; ?>&station_event_id=<?php echo $station_event_id; ?>">

                                            </iframe>
                                            <a href="#0" class="cd-popup-close"></a>
                                        </div> <!-- cd-popup-container -->
                                    </div> <!-- cd-popup -->

                                    <div id="pop3" class="cd-popup" role="alert">
                                        <div class="cd-popup-container">
                                            <iframe id='iframe' src="<?php echo $siteURL; ?>material_tracability/material_search.php?station=<?php echo $line; ?>&station_event_id=<?php echo $station_event_id; ?>">

                                            </iframe>
                                            <a href="#0" class="cd-popup-close"></a>
                                        </div> <!-- cd-popup-container -->
                                    </div> <!-- cd-popup -->

                                    <div id="pop4" class="cd-popup" role="alert">
                                        <div class="cd-popup-container">
                                            <iframe id='iframe' src="<?php echo $siteURL; ?>10x/10x.php?station=<?php echo $line; ?>&station_event_id=<?php echo $station_event_id; ?>">

                                            </iframe>
                                            <a href="#0" class="cd-popup-close"></a>
                                        </div> <!-- cd-popup-container -->
                                    </div> <!-- cd-popup -->

                                    <div id="pop5" class="cd-popup" role="alert">
                                        <div class="cd-popup-container">
                                            <iframe id='iframe' src="<?php echo $siteURL; ?>10x/10x_search.php?station=<?php echo $line; ?>&station_event_id=<?php echo $station_event_id; ?>">

                                            </iframe>
                                            <a href="#0" class="cd-popup-close"></a>
                                        </div> <!-- cd-popup-container -->
                                    </div> <!-- cd-popup -->

                                    <div id="pop6" class="cd-popup" role="alert">
                                        <div class="cd-popup-container">
                                            <iframe id='iframe' src="<?php echo $siteURL; ?>view_station_status.php?station=<?php echo $line; ?>">

                                            </iframe>

                                            <a href="#0" class="cd-popup-close"></a>
                                        </div> <!-- cd-popup-container -->
                                    </div> <!-- cd-popup -->

                                    <div id="pop7" class="cd-popup" role="alert">
                                        <div class="cd-popup-container">
                                            <iframe id='iframe' src="<?php echo $siteURL; ?>events_module/station_events.php">

                                            </iframe>
                                            <a href="#0" class="cd-popup-close"></a>
                                        </div> <!-- cd-popup-container -->
                                    </div> <!-- cd-popup -->

                                    <div id="pop8" class="cd-popup" role="alert">
                                        <div class="cd-popup-container">
                                            <iframe id='iframe' src="<?php echo $siteURL; ?>form_module/form_settings.php?station=<?php echo $line; ?>">

                                            </iframe>
                                            <a href="#0" class="cd-popup-close"></a>
                                        </div> <!-- cd-popup-container -->
                                    </div> <!-- cd-popup -->

                                    <div id="pop9" class="cd-popup" role="alert">
                                        <div class="cd-popup-container">
                                            <p>Are you sure you want to delete this element 9 ?</p>
                                            <a href="#0" class="cd-popup-close"></a>
                                        </div> <!-- cd-popup-container -->
                                    </div> <!-- cd-popup -->

                                    <div id="pop10" class="cd-popup" role="alert">
                                        <div class="cd-popup-container">
                                            <p>Are you sure you want to delete this element 10 ?</p>
                                            <a href="#0" class="cd-popup-close"></a>
                                        </div> <!-- cd-popup-container -->
                                    </div> <!-- cd-popup -->

                                    <div id="pop11" class="cd-popup" role="alert">
                                        <div class="cd-popup-container">
                                            <p>Are you sure you want to delete this element 11 ?</p>
                                            <a href="#0" class="cd-popup-close"></a>
                                        </div> <!-- cd-popup-container -->
                                    </div> <!-- cd-popup -->

                                    <div id="pop12" class="cd-popup" role="alert">
                                        <div class="cd-popup-container">
                                            <p>Are you sure you want to delete this element 12 ?</p>
                                            <a href="#0" class="cd-popup-close"></a>
                                        </div> <!-- cd-popup-container -->
                                    </div> <!-- cd-popup -->


                                </div>

                            </div>

                            <span style="font-size:30px;cursor:pointer;float: right;margin-top: -10px;" onclick="openNav()">&#9776;</span>
                            <h3 class="no-margin dashboard_line_heading"><?php echo $rowc_new["line_name"]; ?></h3>
                            <hr/>

                            <table style="width:100%" id="t01">
                                <tr>
                                    <td>
                                        <div style="padding-top: 5px;font-size: initial;">Part Family :
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
                                function calcTime(city, offset) {
                                    d = new Date();
                                    utc = d.getTime() + (d.getTimezoneOffset() * 60000);
                                    nd = new Date(utc + (3600000 * offset));
                                    return nd;
                                }

                                // Set the date we're counting down to
                                var iddd<?php echo $countervariable; ?> = $("#id<?php echo $countervariable; ?>").val();
                                console.log(iddd<?php echo $countervariable; ?>);
                                var countDownDate<?php echo $countervariable; ?> = new Date(iddd<?php echo $countervariable; ?>).getTime();
                                // Update the count down every 1 second
                                var x = setInterval(function () {
                                    // Get today's date and time
                                    var now = calcTime('Chicago', '-6');
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
                            <div id="myNav" class="overlay">
                                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                                <div class="overlay-content">
                                    <div class="row">
                                        <?php if ($event_status != '0' && $event_status != '') { ?>
                                            <div class="col-sm-4">
                                                <a href="#0" id="pop1btn" class="cd-popup-trigger" onclick="openpopup('pop1')">Good & Bad Piece</a>
                                                <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop2')" >Material Tracability</a>
                                                <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop3')" >View Material Tracability</a>
                                                <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop4')" >Submit 10X</a>
                                                <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop5')" >View 10X</a>
                                            </div>
                                        <?php } ?>
                                        <div class="col-sm-4">

                                            <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop6')" >View Station Status</a>
                                            <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop7')" >Add / Update Events</a>
                                            <?php if (($_SESSION['role_id'] == 'admin') || ($_SESSION['role_id'] == 'super')) { ?>
                                                <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop8')" >Create Form</a>
                                            <?php } ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop9')" >Submit Form</a>
                                            <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop10')" >Assign / Unassign Crew</a>
                                            <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop11')" >View Assigned Crew</a>
                                            <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop12')" >View Document</a>
                                            <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop12')" >Submit Station Assets</a>
                                        </div>
                                    </div>

                                    <div id="pop1" class="cd-popup" role="alert">
                                        <div class="cd-popup-container station_event_id" value="<?php echo $station_event_id; ?>">
                                            <iframe id='iframe' src="<?php echo $siteURL; ?>events_module/good_bad_piece.php?station_event_id=<?php echo $station_event_id; ?>">

                                            </iframe>
                                            <a href="#0" class="cd-popup-close"></a>
                                        </div> <!-- cd-popup-container -->
                                    </div> <!-- cd-popup -->

                                    <div id="pop2" class="cd-popup" role="alert">
                                        <div class="cd-popup-container">
                                            <iframe id='iframe' src="<?php echo $siteURL; ?>material_tracability/material_tracability.php?station=<?php echo $line; ?>&station_event_id=<?php echo $station_event_id; ?>">

                                            </iframe>
                                            <a href="#0" class="cd-popup-close"></a>
                                        </div> <!-- cd-popup-container -->
                                    </div> <!-- cd-popup -->

                                    <div id="pop3" class="cd-popup" role="alert">
                                        <div class="cd-popup-container">
                                            <iframe id='iframe' src="<?php echo $siteURL; ?>material_tracability/material_search.php?station=<?php echo $line; ?>&station_event_id=<?php echo $station_event_id; ?>">

                                            </iframe>
                                            <a href="#0" class="cd-popup-close"></a>
                                        </div> <!-- cd-popup-container -->
                                    </div> <!-- cd-popup -->

                                    <div id="pop4" class="cd-popup" role="alert">
                                        <div class="cd-popup-container">
                                            <iframe id='iframe' src="<?php echo $siteURL; ?>10x/10x.php?station=<?php echo $line; ?>&station_event_id=<?php echo $station_event_id; ?>">

                                            </iframe>
                                            <a href="#0" class="cd-popup-close"></a>
                                        </div> <!-- cd-popup-container -->
                                    </div> <!-- cd-popup -->

                                    <div id="pop5" class="cd-popup" role="alert">
                                        <div class="cd-popup-container">
                                            <iframe id='iframe' src="<?php echo $siteURL; ?>10x/10x_search.php?station=<?php echo $line; ?>&station_event_id=<?php echo $station_event_id; ?>">

                                            </iframe>
                                            <a href="#0" class="cd-popup-close"></a>
                                        </div> <!-- cd-popup-container -->
                                    </div> <!-- cd-popup -->

                                    <div id="pop6" class="cd-popup" role="alert">
                                        <div class="cd-popup-container">
                                            <iframe id='iframe' src="<?php echo $siteURL; ?>view_station_status.php?station=<?php echo $line; ?>">

                                            </iframe>

                                            <a href="#0" class="cd-popup-close"></a>
                                        </div> <!-- cd-popup-container -->
                                    </div> <!-- cd-popup -->

                                    <div id="pop7" class="cd-popup" role="alert">
                                        <div class="cd-popup-container">
                                            <iframe id='iframe' src="<?php echo $siteURL; ?>events_module/station_events.php">

                                            </iframe>
                                            <a href="#0" class="cd-popup-close"></a>
                                        </div> <!-- cd-popup-container -->
                                    </div> <!-- cd-popup -->

                                    <div id="pop8" class="cd-popup" role="alert">
                                        <div class="cd-popup-container">
                                            <iframe id='iframe' src="<?php echo $siteURL; ?>form_module/form_settings.php?station=<?php echo $line; ?>">

                                            </iframe>
                                            <a href="#0" class="cd-popup-close"></a>
                                        </div> <!-- cd-popup-container -->
                                    </div> <!-- cd-popup -->

                                    <div id="pop9" class="cd-popup" role="alert">
                                        <div class="cd-popup-container">
                                            <p>Are you sure you want to delete this element 9 ?</p>
                                            <a href="#0" class="cd-popup-close"></a>
                                        </div> <!-- cd-popup-container -->
                                    </div> <!-- cd-popup -->

                                    <div id="pop10" class="cd-popup" role="alert">
                                        <div class="cd-popup-container">
                                            <p>Are you sure you want to delete this element 10 ?</p>
                                            <a href="#0" class="cd-popup-close"></a>
                                        </div> <!-- cd-popup-container -->
                                    </div> <!-- cd-popup -->

                                    <div id="pop11" class="cd-popup" role="alert">
                                        <div class="cd-popup-container">
                                            <p>Are you sure you want to delete this element 11 ?</p>
                                            <a href="#0" class="cd-popup-close"></a>
                                        </div> <!-- cd-popup-container -->
                                    </div> <!-- cd-popup -->

                                    <div id="pop12" class="cd-popup" role="alert">
                                        <div class="cd-popup-container">
                                            <p>Are you sure you want to delete this element 12 ?</p>
                                            <a href="#0" class="cd-popup-close"></a>
                                        </div> <!-- cd-popup-container -->
                                    </div> <!-- cd-popup -->


                                </div>

                            </div>

                            <span style="font-size:30px;cursor:pointer;float: right;margin-top: -10px;" onclick="openNav()">&#9776;</span>

                            <h3 class="no-margin dashboard_line_heading"><?php echo $rowc_new['line_name']; ?></h3>
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
                                <tr>
                                    <td>
                                        <div style="padding-top: 5px;font-size: initial;">Part Name :</div>
                                    </td>
                                    <td><span><?php echo $p_name;
                                            $p_name = ''; ?></span></td>
                                </tr>
                            </table>
                        </div>
                        </main>
                        <?php
                        $variable123 = $time;
                        if ($variable123 != "") {
                            ?>
                            <script>
                                function calcTime(city, offset) {
                                    d = new Date();
                                    utc = d.getTime() + (d.getTimezoneOffset() * 60000);
                                    nd = new Date(utc + (3600000 * offset));
                                    return nd;
                                }
                                // Set the date we're counting down to
                                var iddd<?php echo $countervariable; ?> = $("#id<?php echo $countervariable; ?>").val();
                                console.log(iddd<?php echo $countervariable; ?>);
                                var countDownDate<?php echo $countervariable; ?> = new Date(iddd<?php echo $countervariable; ?>).getTime();
                                // Update the count down every 1 second
                                var x = setInterval(function () {
                                    // Get today's date and time
                                    var now = calcTime('Chicago', '-6');
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
                </div>

                <?php
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
    function openNav() {
        document.getElementById("myNav").style.display = "block";
    }

    function closeNav() {
        document.getElementById("myNav").style.display = "none";
    }
</script>
<script>
    jQuery(document).ready(function($){

        //close popup
        $('.cd-popup').on('click', function(event){
            if( $(event.target).is('.cd-popup-close') || $(event.target).is('.cd-popup') ) {
                event.preventDefault();
                $(this).removeClass('is-visible');
            }
        });
        //close popup when clicking the esc keyboard button
        $(document).keyup(function(event){
            if(event.which=='27'){
                $('.cd-popup').removeClass('is-visible');
            }
        });
    });

    //open popup
    function openpopup(id) {
        event.preventDefault();
        $("#"+id+"").addClass('is-visible');
    }
</script>



<script>
    document.getElementById('material_type').onchange = function () {
        var sel_val = this.value.split('_');
        var isDis = sel_val[1];
        var rr = document.getElementById("serial_num");
        if(isDis == 0){
            rr.innerHTML = "";
            document.getElementById("serial_num").style.display = 'none';
            document.getElementById("material_file").required = false;
        }else{
            rr.innerHTML = "<label class=\"col-lg-2 control-label\" style=\"padding-top: 10px;\">Serial Number\n" +
                "                                    : </label>\n" +
                "                                <div class=\"col-md-6\">\n" +
                "                                    <input type=\"text\" size=\"30\" name=\"serial_number\" id=\"serial_number\"\n" +
                "                                           class=\"form-control\" required/>\n" +
                "                                </div>\n" ;
            // "                                <div id=\"error1\" class=\"red\">Enter valid Serial Number</div>";
            document.getElementById("serial_num").style.display = 'block';
            document.getElementById("material_file").required = true;
        }

    }
</script>

<script>
    $("input[name$='material_status']").click(function () {
        var test = $(this).val();
        //    console.log(test);
        var z = document.getElementById("rej_fail");
        if ((test === "0") && (z.style.display === "none")) {
            z.style.display = "block";
            z.innerHTML = '<div class="row desc" id="Reason0">\n' +
                '                                    <label class="col-lg-2 control-label">Reason : </label>\n' +
                '                                    <div class="col-md-6">\n' +
                '                                        <select name="reason" id="reason" required class="select form-control"\n' +
                '                                                data-style="bg-slate">\n' +
                '                                            <option value="Reject" selected >Reject</option>\n' +
                '                                            <option value="Hold" >On Hold</option>\n' +
                '                                        </select>\n' +
                '                                    </div>\n' +
                '                                </div>\n' +
                '                                <br/>\n' +
                '                                <div class="row desc" id="quantity0">\n' +
                '                                    <label class="col-lg-2 control-label"> Quantity : </label>\n' +
                '                                    <div class="col-md-6">\n' +
                '                                        <input class="form-control" name="quantity" rows="1" id="quantity" required>\n' +
                '                                    </div>\n' +
                '\n' +
                '                                </div>\n' +
                '                                <br/>';
        } else if (test === "1") {
            z.style.display = "none";
            z.innerHTML = '';
        }
    });
</script>



<script>
    // Upload

    $("#material_file").on("change", function () {
        var fd = new FormData();
        var files = $('#material_file')[0].files[0];
        fd.append('file', files);
        fd.append('request', 1);

        // AJAX request
        $.ajax({
            url: '<?php echo $siteURL; ?>material_tracability/add_delete_mat_image.php',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function (response) {

                if (response != 0) {
                    var count = $('.mat_container .mat_content_img').length;
                    count = Number(count) + 1;

                    // Show image preview with Delete button
                    $('.container').append("<div class='mat_content_img' id='mat_content_img_" + count + "' ><img src='" + response + "' width='100' height='100'><span class='delete' id='delete_" + count + "'>Delete</span></div>");
                }
            }
        });
    });


    // Remove file
    $('.mat_container').on('click', '.mat_content_img .mat_delete', function () {

        var id = this.id;
        var split_id = id.split('_');
        var num = split_id[1];
        // Get image source
        var imgElement_src = $('#mat_content_img_' + num)[0].children[0].src;
        //var deleteFile = confirm("Do you really want to Delete?");
        var succ = false;
        // AJAX request
        $.ajax({
            url: '<?php echo $siteURL; ?>material_tracability/add_delete_mat_image.php',
            type: 'post',
            data: {path: imgElement_src, request: 2},
            async: false,
            success: function (response) {
                // Remove <div >
                if (response == 1) {
                    succ = true;
                }
            }, complete: function (data) {
                if (succ) {
                    var id = 'mat_content_img_' + num;
                    // $('#content_img_'+num)[0].remove();
                    var elem = document.getElementById(id);
                    document.getElementById(id).style.display = 'none';
                    var nodes = $(".mat_container")[2].childNodes;
                    for (var i = 0; i < nodes.length; i++) {
                        var node = nodes[i];
                        if (node.id == id) {
                            node.style.display = 'none';
                        }
                    }
                }
            }
        });
    });
    $(document).on("click", ".submit_btn", function () {
        var line_number = $("#line_number").val();
        var material_type = $("#material_type").val();
        var material_status = $("#material_status").val();
    });

</script>
<script>
    $(document).on("click","#material_btn",function() {
        var data = $("#material_tracability").serialize();
        $.ajax({
            type: 'POST',
            url: '<?php echo $siteURL; ?>material_tracability/material_backend.php',
            data: data,
            success: function(data) {

            }
        });
    });
</script>

<!-- Configure a few settings and attach camera -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
<script language="JavaScript">
    Webcam.set({
        width: 290,
        height: 190,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
    var camera = document.getElementById("my_camera");
    Webcam.attach( camera );
</script>
<script language="JavaScript">
    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            var formData =  $(".10x_image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
            $.ajax({
                url: "<?php echo $siteURL; ?>10x/webcam_backend.php",
                type: "POST",
                data: formData,
                success: function (msg) {
                    window.location.reload()
                },

            });
        } );
    }


</script>

<script>
    $(document).ready(function () {
        $('.select').select2();
    });


</script>
<script>

</script>
<script>
    // Upload

    $("#10x_file").on("change", function () {
        var fd = new FormData();
        var files = $('#10x_file')[0].files[0];
        fd.append('file', files);
        fd.append('request', 1);

        // AJAX request
        $.ajax({
            url: '<?php echo $siteURL; ?>10x/add_delete_10x_image.php',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function (response) {

                if (response != 0) {
                    var count = $('.10x_container .10x_content_img').length;
                    count = Number(count) + 1;

                    // Show image preview with Delete button
                    $('.container').append("<div class='10x_content_img' id='10x_content_img_" + count + "' ><img src='" + response + "' width='100' height='100'><span class='delete' id='delete_" + count + "'>Delete</span></div>");
                }
            }
        });
    });


    // Remove file
    $('.10x_container').on('click', '.10x_content_img .delete', function () {

        var id = this.id;
        var split_id = id.split('_');
        var num = split_id[1];
        // Get image source
        var imgElement_src = $('#10x_content_img_' + num)[0].children[0].src;
        //var deleteFile = confirm("Do you really want to Delete?");
        var succ = false;
        // AJAX request
        $.ajax({
            url: '<?php echo $siteURL; ?>10x/add_delete_10x_image.php',
            type: 'post',
            data: {path: imgElement_src, request: 2},
            async: false,
            success: function (response) {
                // Remove <div >
                if (response == 1) {
                    succ = true;
                }
            }, complete: function (data) {
                if (succ) {
                    var id = '10x_content_img_' + num;
                    // $('#content_img_'+num)[0].remove();
                    var elem = document.getElementById(id);
                    document.getElementById(id).style.display = 'none';
                    var nodes = $(".10x_container")[2].childNodes;
                    for (var i = 0; i < nodes.length; i++) {
                        var node = nodes[i];
                        if (node.id == id) {
                            node.style.display = 'none';
                        }
                    }
                }
            }
        });
    });

</script>
<script>
    $(document).on('click', '.10x_remove_image', function () {
        var del_id = this.id.split("_")[2];
        var x_img_id = this.parentElement.childNodes[3].value;
        var info =  document.getElementById("10x_delete_image"+del_id);
        var info =  "id="+del_id+"&10x_id="+ x_img_id;
        $.ajax({
            type: "POST",
            url: "<?php echo $siteURL; ?>10x/delete_10x_image.php",
            data: info,
            success: function (data) {
            }
        });
        location.reload(true);
    });
</script>
<script>
    $("#slideshow > div:gt(0)").hide();

    setInterval(function() {
        $('#slideshow > div:first')
            .fadeOut(3000)
            .next()
            .fadeIn(3000)
            .end()
            .appendTo('#slideshow');
    }, 5000);

    // setTimeout(function () {
    //     //alert("reload");
    //     location.reload();
    // }, 20000);
</script>
<script>

    $("#edit_save").click(function (e) {
        if ($("#edit_station_event_form")[0].checkValidity()){

        }
        // e.preventDefault();
    });
    $(document).on('click', '#delete', function () {
        var element = $(this);
        var del_id = element.attr("data-id");
        var info = 'id=' + del_id;
        $.ajax({
            type: "POST", url: "ajax_delete.php", data: info, success: function (data) {
            }
        });
        $(this).parents("tr").animate({backgroundColor: "#003"}, "slow").animate({opacity: "hide"}, "slow");
    });
</script>
<script>
    jQuery(document).ready(function ($) {
        $(document).on('click', '#edit', function () {
            var element = $(this);
            var edit_id = $(this).data("id");
            var station = $(this).data("station");
            var part_family = $(this).data("part_family");
            var part_number = $(this).data("part_number");
            var event_type = $(this).data("event_type_id");
            var reason = $(this).data("reason");
            $("#edit_station").val(station);
            $("#edit_part_family").val(part_family);
            $("#edit_part_number").val(part_number);
            $("#edit_event_type").val(event_type);
            $("#edit_id").val(edit_id);
            $("#edit_reason").val(reason);
        });
    });
</script>

<script>
    $('#edit_event_type').on('change', function () {

        var selected_val = this.value.split("_")[1];
        if (selected_val == 3) {
            document.getElementById("reason_div").innerHTML +="<div class=\"col-md-12\">\n" +
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
            document.getElementById("reason_div").innerHTML ="";
            // document.getElementById("reason_div").required = false;
            // $("#reason_div").hide();
        }
    });
</script>


<script>
    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
    $('#generate').click(function () {
        let r = Math.random().toString(36).substring(7);
        $('#newpass').val(r);
    })

    function submitForm(url) {
        $(':input[type="button"]').prop('disabled', true);
        var data = $("#update-form").serialize();
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function (data) {
                // window.location.href = window.location.href + "?aa=Line 1";
                $(':input[type="button"]').prop('disabled', false);
                location.reload();
            }
        });
    }

    function submitForm11(url) {
        $(':input[type="button"]').prop('disabled', true);
        var data = $("#update-form").serialize();
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function (data) {
                // window.location.href = window.location.href + "?aa=Line 1";
                $(':input[type="button"]').prop('disabled', false);
                location.reload();
            }
        });
    }

    function submitForm12(url) {
        $(':input[type="button"]').prop('disabled', true);
        var data = $("#update-form").serialize();
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function (data) {
                // window.location.href = window.location.href + "?aa=Line 1";
                $(':input[type="button"]').prop('disabled', false);
                location.reload();
            }
        });
    }

    $('#choose').on('change', function () {
        var selected_val = this.value;
        if (selected_val == 4 || selected_val == 10) {
            $("#reason_div").show();
        } else {
            $("#reason_div").hide();
        }
    });


    $('#station').on('change', function (e) {
        $("#station_event_form").submit();
    });
    $('#part_family').on('change', function (e) {
        $("#station_event_form").submit();
    });
    $('#part_number').on('change', function (e) {
        $("#station_event_form").submit();
    });
    $(document).on("click",".submit_btn",function() {
        var station = $("#station").val();
        var part_family = $("#part_family").val();
        var part_number = $("#part_number").val();
        var event_type_id = $("#event_type_id").val();

    });
</script>
<script type="text/javascript">
    $(function () {
        $("#btn").bind("click", function () {
            $("#station")[0].selectedIndex = 0;
            $("#part_family")[0].selectedIndex = 0;
            $("#part_number")[0].selectedIndex = 0;
            $("#event_type_id")[0].selectedIndex = 0;
        });
    });
</script>
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
</script>



<!--<script>-->
<!--    $(document).ready(function(){-->
<!--        $(".cd-popup-trigger").click(function(){-->
<!--            $("iframe").each(function(){-->
<!--            });-->
<!--        });-->
<!--    });-->
<!--</script>-->

<script>
    iframe.onload = function() {
        // we can get the reference to the inner window
        let iframeWindow = iframe.contentWindow; // OK
        try {
            // ...but not to the document inside it
            let doc = iframe.contentDocument; // ERROR
        } catch(e) {
            alert(e); // Security Error (another origin)
        }

        // also we can't READ the URL of the page in iframe
        try {
            // Can't read URL from the Location object
            let href = iframe.contentWindow.location.href; // ERROR
        } catch(e) {
            alert(e); // Security Error
        }

        // ...we can WRITE into location (and thus load something else into the iframe)!
        iframe.contentWindow.location = '/'; // OK

        iframe.onload = null; // clear the handler, not to run it after the location change
    };
</script>
<?php include("footer.php"); ?> <!-- /page container -->
<!-- new footer here -->
</body>
</html>