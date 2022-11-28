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
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_bootstrap_select.js"></script>
    <script type="text/javascript" src="assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="assets/js/pages/components_modals.js"></script>
    <script type="text/javascript" src="assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src = "./assets/js/jquery.min.js"></script>
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
        .overlay {
            height: 100%;
            width: 100%;
            display: none;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0, 0.9);
        }

        .overlay-content {
            position: relative;
            top: 6%;
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
            top: 20px;
            right: 45px;
            font-size: 60px;
        }

        @media screen and (max-height: 450px) {
            .overlay a {font-size: 14px}
            .overlay .closebtn {
                font-size: 40px;
                top: 15px;
                right: 35px;
            }
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
            background: #35a785;
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
            background: #FFF;
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
    </style>

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
            $qur01 = mysqli_query($db, "SELECT pn.part_number as p_num, pn.pm_part_number_id as p_no, pn.part_name as p_name , pf.part_family_name as pf_name,pf.pm_part_family_id as pf_no, et.event_type_name as e_name ,et.color_code as color_code , sg_events.modified_on as updated_time ,sg_events.station_event_id as station_event_id , sg_events.event_status as event_status , sg_events.created_on as e_start_time FROM sg_station_event as sg_events inner join event_type as et on sg_events.event_type_id=et.event_type_id Inner Join pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on sg_events.part_number_id=pn.pm_part_number_id where sg_events.line_id= '$line' ORDER by sg_events.created_on DESC LIMIT 1");
            $rowc01 = mysqli_fetch_array($qur01);
            if ($rowc01 != null) {
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
                                        <div class="col-sm-4">
                                            <a href="#0" id="pop1btn" class="cd-popup-trigger" onclick="openpopup('pop1')">Good & Bad Piece</a>
                                            <a href="#0" id="pop1btn" class="cd-popup-trigger" onclick="openpopup('pop2')">Material Tracability</a>
                                            <a href="#0" id="pop1btn" class="cd-popup-trigger" onclick="openpopup('pop3')">View Material Tracabilty </a>
                                            <a href="#0" id="pop1btn" class="cd-popup-trigger" onclick="openpopup('pop4')">View Assigned Crew</a>
                                            <a href="#0" id="pop1btn" class="cd-popup-trigger" onclick="openpopup('pop5')">View Document</a>
                                        </div>
                                        <div class="col-sm-4">
                                            <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop2')" >Submit 10X</a>
                                            <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop2')" >View 10X</a>
                                            <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop2')" >View Station Status</a>
                                            <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop2')" >Assign / Unassign Crew</a>
                                            <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop2')" >Submit Station Assets</a>
                                        </div>
                                        <div class="col-sm-4">
                                            <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop3')" >Add/Update Events</a>
                                            <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop3')" >Create Form</a>
                                            <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop3')" >Submit Form</a>
                                            <a href="#0" class="cd-popup-trigger" onclick="openpopup('pop3')" >Form Submit Dashboard</a>
                                        </div>
                                    </div>


                                </div>

                                <div id="pop1" class="cd-popup" role="alert">
                                    <div class="cd-popup-container">
                                        <?php
                                        $user_id = $_SESSION["id"];
                                        $def_ch = $_POST['def_ch'];
                                        $chicagotime = date("Y-m-d H:i:s");
                                        //$line = "<b>-</b>";
                                        $line = "";
                                        $station_event_id = $rowc01['station_event_id'];
                                        $sqlmain = "SELECT * FROM `sg_station_event` where `station_event_id` = '$station_event_id'";
                                        $resultmain = $mysqli->query($sqlmain);
                                        $rowcmain = $resultmain->fetch_assoc();
                                        $part_family = $rowcmain['part_family_id'];
                                        $part_number = $rowcmain['part_number_id'];
                                        $p_line_id = $rowcmain['line_id'];

                                        $sqlprint = "SELECT * FROM `cam_line` where `line_id` = '$p_line_id'";
                                        $resultnumber = $mysqli->query($sqlprint);
                                        $rowcnumber = $resultnumber->fetch_assoc();
                                        $printenabled = $rowcnumber['print_label'];
                                        $p_line_name = $rowcnumber['line_name'];
                                        $individualenabled = $rowcnumber['indivisual_label'];

                                        $idddd = preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo
                                            |fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i"
                                            , $_SERVER["HTTP_USER_AGENT"]);

                                        $sqlnumber = "SELECT * FROM `pm_part_number` where `pm_part_number_id` = '$part_number'";
                                        $resultnumber = $mysqli->query($sqlnumber);
                                        $rowcnumber = $resultnumber->fetch_assoc();
                                        $pm_part_number = $rowcnumber['part_number'];
                                        $pm_part_name = $rowcnumber['part_name'];
                                        $pm_npr= $rowcnumber['npr'];
                                        if(empty($pm_npr))
                                        {
                                            $npr = 0;
                                            $pm_npr = 0;
                                        }else{
                                            $npr = $pm_npr;
                                        }
                                        $sqlfamily = "SELECT * FROM `pm_part_family` where `pm_part_family_id` = '$part_family'";
                                        $resultfamily = $mysqli->query($sqlfamily);
                                        $rowcfamily = $resultfamily->fetch_assoc();
                                        $pm_part_family_name = $rowcfamily['part_family_name'];

                                        $sqlaccount = "SELECT * FROM `part_family_account_relation` where `part_family_id` = '$part_family'";
                                        $resultaccount = $mysqli->query($sqlaccount);
                                        $rowcaccount = $resultaccount->fetch_assoc();
                                        $account_id = $rowcaccount['account_id'];

                                        $sqlcus = "SELECT * FROM `cus_account` where `c_id` = '$account_id'";
                                        $resultcus = $mysqli->query($sqlcus);
                                        $rowccus = $resultcus->fetch_assoc();
                                        $cus_name = $rowccus['c_name'];
                                        $logo = $rowccus['logo'];

                                        $sql2 = "SELECT SUM(good_pieces) AS good_pieces,SUM(bad_pieces)AS bad_pieces,SUM(rework) AS rework FROM `good_bad_pieces`  INNER JOIN sg_station_event ON good_bad_pieces.station_event_id = sg_station_event.station_event_id where sg_station_event.line_id = '$p_line_id' and sg_station_event.event_status = 1" ;
                                        $result2 = mysqli_query($db,$sql2);
                                        $total_time = 0;
                                        $row2=$result2->fetch_assoc();
                                        $total_gp =  $row2['good_pieces'] + $row2['rework'];

                                        $sql3 = "SELECT * FROM `sg_station_event_log` where 1 and event_status = 1 and station_event_id = '$station_event_id' and event_cat_id in (SELECT events_cat_id FROM `events_category` where npr = 1)" ;
                                        $result3 = mysqli_query($db,$sql3);
                                        $ttot = null;
                                        $tt = null;
                                        while ($row3 = $result3->fetch_assoc()) {
                                            $ct = $row3['created_on'];
                                            $tot = $row3['total_time'];
                                            if(!empty($row3['total_time'])){
                                                $ttot = explode(':' , $row3['total_time']);
                                                $i = 0;
                                                foreach($ttot as $t_time) {
                                                    if($i == 0){
                                                        $total_time += ( $t_time * 60 * 60 );
                                                    }else if( $i == 1){
                                                        $total_time += ( $t_time * 60 );
                                                    }else{
                                                        $total_time += $t_time;
                                                    }
                                                    $i++;
                                                }
                                            }else{
                                                $total_time +=  strtotime($chicagotime) - strtotime($ct);
                                            }
                                        }
                                        $total_time = (($total_time/60)/60);
                                        $b = round($total_time);
                                        $target_eff = round($pm_npr * $b);
                                        $actual_eff = $total_gp;
                                        if( $actual_eff ===0 || $target_eff === 0 || $target_eff === 0.0){
                                            $eff = 0;
                                        }else{
                                            $eff = round(100 * ($actual_eff/$target_eff));
                                        }

                                        ?>
                                        <div style="background-color: #fff;padding-bottom: 50px; margin-left:0px !important; margin-right: 0px !important;" class="row">
                                            <div class="col-lg-6 col-md-8 graph_media">
                                                <div class="media">
                                                    <h5 style="font-size: xx-large;background-color: #009688; color: #ffffff;padding : 5px; text-align: center;" class="text-semibold no-margin"><?php if($cus_name != ""){ echo $cus_name; }else{ echo "Customer Name";} ?> </h5>

                                                    <div class="media-left">
                                                        <!--                                    <a target="_blank" href="../supplier_logo/--><?php //if($logo != ""){ echo $logo; }else{ echo "user.png"; } ?><!--" data-popup="lightbox">-->
                                                        <img src="../supplier_logo/<?php if($logo != ""){ echo $logo; }else{ echo "user.png"; } ?>" style=" height: 20vh;width:20vh;margin : 15px 25px 5px 5px;background-color: #ffffff;" class="img-circle" alt="">
                                                        <!--                                    </a>-->
                                                    </div>
                                                    <div class="media-body">
                                                        <small style="font-size: 22px; margin-top: 15px;" class="display-block"><b>Part Family :-</b> <?php echo $pm_part_family_name; ?></small>
                                                        <small style="font-size: 22px;" class="display-block"><b>Part Number :-</b> <?php echo $pm_part_number; ?></small>
                                                        <small style="font-size: 22px;" class="display-block"><b>Part Name :-</b> <?php echo $pm_part_name; ?></small>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-8 graph_media">
                                                <div class="media">
                                                    <h5 style="font-size: xx-large;background-color: #009688; color: #ffffff;padding : 5px; text-align: center;" class="text-semibold no-margin">Current Staff Efficiency</h5>
                                                    <div class="media-left">
                                                        <!--                                    <a target="_blank" href="../supplier_logo/--><?php //if($logo != ""){ echo $logo; }else{ echo "user.png"; } ?><!--" data-popup="lightbox">-->
                                                        <div id="eff_container" class="img-circle"></div>                                                        <!--                                    </a>-->
                                                    </div>
                                                    <div class="media_details">
                                                    <div class="media-body">
                                                        <small style="font-size: 22px ;margin-top: 15px;padding-left: 14px;"><b>Target Pieces :-</b> <?php echo $target_eff; ?></small>
                                                        <small style="font-size: 22px;padding-left: 17px;" ><b>Actual Pieces :-</b> <?php echo $actual_eff; ?></small>
                                                        <small style="font-size: 22px;padding-left: 17px;"><b>Efficiency :-</b> <?php echo $eff; ?>%</small>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        if (!empty($import_status_message)) {
                                            echo '<div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
                                        }
                                        ?>
                                        <?php
		                                if (!empty($_SESSION['import_status_message'])) {
			                            echo '<div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
			                            $_SESSION['message_stauts_class'] = '';
			                            $_SESSION['import_status_message'] = '';
		                                 } ?>
                                        <div class="panel panel-flat">
                                            <?php
                                            $sql = "select SUM(good_pieces) as good_pieces,SUM(bad_pieces) AS bad_pieces,SUM(rework) as rework from good_bad_pieces where station_event_id ='$station_event_id' ";
                                            $result1 = mysqli_query($db, $sql);
                                            $rowc = mysqli_fetch_array($result1);
                                            $gp = $rowc['good_pieces'];
                                            if(empty($gp)){
                                                $g = 0;
                                            }else{
                                                $g = $gp;
                                            }
                                            $bp = $rowc['bad_pieces'];
                                            if(empty($bp)){
                                                $b = 0;
                                            }else{
                                                $b = $bp;
                                            }
                                            $rwp = $rowc['rework'];
                                            if(empty($rwp)){
                                                $r = 0;
                                            }else{
                                                $r = $rwp;
                                            }
                                            $tp = $gp + $bp+ $rwp;
                                            if(empty($tp)){
                                                $t = 0;
                                            }else{
                                                $t = $tp;
                                            }
                                            ?>
                                            <div class="row" style="background-color: #f3f3f3;margin: 0px">
                                                <div class="col-md-3" style="height: 10vh; padding-top: 3vh; font-size: x-large; text-align: center;">
                                                    <span>Total Pieces : <?php echo $t ?></span>
                                                </div>
                                                <div class="col-md-3" style="height: 10vh; padding-top: 3vh; padding-bottom: 3vh; font-size: x-large; text-align: center;background-color:#a8d8a8;">
                                                    <span>Total Good Pieces : <?php echo $g ?></span>
                                                </div>
                                                <div class="col-md-3" style="height: 10vh; padding-top: 3vh; padding-bottom: 3vh; font-size: x-large; text-align: center;background-color:#eca9a9;">
                                                    <span>Total Bad Pieces : <?php echo $b ?></span>
                                                </div>
                                                <div class="col-md-3" style="height: 10vh; padding-top: 3vh; padding-bottom: 3vh; font-size: x-large; text-align: center;background-color:#b1cdff;">
                                                    <span>Rework : <?php echo $r ?></span>
                                                </div>
                                            </div>
                                            <div class="panel-heading" style="padding: 50px;">
                                                <div class="row">
                                                    <div class="search_container"  style="margin-right:10px;">
                                                        <input id="search" class="search__input"  type="text" placeholder="Search Defect" style="margin-left: 15px;padding: 12px 24px;background-color: transparent;transition: transform 250ms ease-in-out;line-height: 18px;color: #000000;font-size: 18px;background-color: transparent; background-repeat: no-repeat;
        background-size: 18px 18px;
        background-position: 95% center;
        border-radius: 50px;
        border: 1px solid #575756;
        transition: all 250ms ease-in-out;
        backface-visibility: hidden;
        transform-style: preserve-3d;
        " >
                                                    </div>
                                                </div>
                                                </br>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <?php if(($idddd != 0) && ($printenabled == 1)){?>
                                                            <iframe height="100" id="resultFrame" style="display: none;" src="./pp.php"></iframe>
                                                        <?php }?>
                                                        <!--                    <button type="button" data-toggle="modal" data-target="#view_good_modal_theme_primary"  class="btn btn-primary" style="background-color:#177b09 !important;margin-top: 10px;width: 100%;height: 10vh; padding-top: 3vh; font-size: large; text-align: center;"> IN-SPEC</button>-->
                                                        <a href="<?php echo $siteURL; ?>events_module/add_good_piece.php?station_event_id=<?php echo $station_event_id; ?>"  class="btn btn-primary" style="background-color:#177b09 !important;margin-top: 10px;width: 100%;height: 10vh; padding-top: 3vh; font-size: large; text-align: center;"> IN-SPEC</a>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <?php
                                                    $i = 1;
                                                    $def_list_arr = array();
                                                    $sql1 = "SELECT * FROM `defect_list` ORDER BY `defect_list_name` ASC";
                                                    $result1 = $mysqli->query($sql1);
                                                    while ($row1 = $result1->fetch_assoc()) {
                                                        $pnums = $row1['part_number_id'];
                                                        $arr_pnums = explode(',', $pnums);
                                                        if (in_array($part_number, $arr_pnums)) {
                                                            array_push($def_list_arr, $row1['defect_list_id']);
                                                        }
                                                    }

                                                    $sql1 = "SELECT sdd.defect_list_id as dl_id FROM sg_defect_group as sdg inner join sg_def_defgroup as sdd on sdg.d_group_id = sdd.d_group_id WHERE FIND_IN_SET('$part_number',sdg.part_number_id) > 0";
                                                    $result1 = $mysqli->query($sql1);
                                                    while ($row1 = $result1->fetch_assoc()) {
                                                        array_push($def_list_arr, $row1['dl_id']);
                                                    }
                                                    $def_list_arr = array_unique($def_list_arr);
                                                    $def_lists = implode("', '", $def_list_arr);
                                                    $sql1 = "SELECT * FROM `defect_list` where  defect_list_id IN ('$def_lists') ORDER BY `defect_list_name` ASC";
                                                    $result1 = $mysqli->query($sql1);
                                                    while ($row1 = $result1->fetch_assoc()) {
                                                        ?>
                                                        <div class="col-md-3" style="padding-top: 10px;">
                                                            <a  href="<?php echo $siteURL; ?>events_module/add_bad_piece.php?station_event_id=<?php echo $station_event_id; ?>&defect_list_id=<?php echo $row1['defect_list_id']; ?>" class="btn btn-primary view_gpbp"  data-buttonid="<?php echo $row1['defect_list_id']; ?>"
                                                                data-defect_name="<?php echo $row1['defect_list_name']; ?>" style="white-space: normal;background-color:#BE0E31 !important;height: 8vh; width:98% ; padding-top: 2vh; font-size: medium; text-align: center;" target="_blank">
                                                                <?php echo $row1['defect_list_name']; ?></a>

                                                        </div>
                                                        <?php
                                                        if($i == 4)
                                                        {
                                                            echo "<br/>";
                                                            echo "<br/>";
                                                            echo "<br/>";
                                                            $i = 0;
                                                        }

                                                        $i++;
                                                    }
                                                    ?>

                                                </div>
                                            </div>


                                        </div>
                                        <form action="delete_good_bad_piece.php" method="post" class="form-horizontal">
                                            <input type="hidden" name="station_event_id" value="<?php echo $_GET['station_event_id']; ?>">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <button type="submit" class="btn btn-primary" style="background-color:#1e73be;" >Delete</button>
                                                </div>
                                            </div>
                                            <br/>
                                            <div class="panel panel-flat">
                                                <table class="table datatable-basic">
                                                    <thead>
                                                    <tr>
                                                        <th><input type="checkbox" id="checkAll" ></th>
                                                        <th>S.No</th>
                                                        <th>Good Pieces</th>
                                                        <th>Defect Name</th>
                                                        <th>Bad Pieces</th>
                                                        <th>Re-Work</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $station_event_id = $_GET['station_event_id'];
                                                    $query = sprintf("SELECT gbpd.bad_pieces_id as bad_pieces_id , gbpd.good_pieces as good_pieces, gbpd.defect_name as defect_name, gbpd.bad_pieces as bad_pieces ,gbpd.rework as rework FROM good_bad_pieces_details as gbpd where gbpd.station_event_id  = '$station_event_id' order by gbpd.bad_pieces_id DESC");
                                                    $qur = mysqli_query($db, $query);
                                                    while ($rowc = mysqli_fetch_array($qur)) {
                                                        $bad_pieces_id = $rowc['bad_pieces_id'];
                                                        $good_pieces = $rowc['good_pieces'];
                                                        $bad_pieces = $rowc['bad_pieces'];
                                                        $rework = $rowc['rework'];
                                                        $style = "";
                                                        if($rowc['good_pieces'] != ""){
                                                            $style = "style='background-color:#a8d8a8;'";
                                                        }
                                                        if($rowc['bad_pieces'] != ""){
                                                            $style = "style='background-color:#eca9a9;'";
                                                        }
                                                        if($rowc['rework'] != ""){
                                                            $style = "style='background-color:#b1cdff;'";
                                                        }
                                                        ?>
                                                        <tr <?php echo $style; ?>>
                                                            <td><input type="checkbox" id="delete_check[]" name="delete_check[]" value="<?php echo $rowc["bad_pieces_id"]; ?>"></td>
                                                            <td><?php echo ++$counter; ?></td>
                                                            <td><?php if($rowc['good_pieces'] != ""){echo $rowc['good_pieces']; }else{ echo $line; } ?></td>
                                                            <td><?php $un = $rowc['defect_name']; if($un != ""){ echo $un; }else{ echo $line; } ?></td>
                                                            <td><?php if($rowc['bad_pieces'] != ""){echo $rowc['bad_pieces'];}else{ echo $line; } ?></td>
                                                            <td><?php if($rowc['rework'] != ""){echo $rowc['rework']; }else{ echo $line; } ?></td>
                                                            <?php
                                                            $qur04 = mysqli_query($db, "SELECT * FROM  good_bad_pieces where station_event_id= '$station_event_id' ORDER BY `good_bad_pieces_id` DESC LIMIT 1");
                                                            $rowc04 = mysqli_fetch_array($qur04);
                                                            $good_trace_id = $rowc04["good_bad_pieces_id"];

                                                            $query1 = sprintf("SELECT good_bad_pieces_id,good_image_name FROM  good_piece_images where good_bad_pieces_id = '$good_trace_id'");
                                                            $qur1 = mysqli_query($db, $query1);
                                                            $rowc1 = mysqli_fetch_array($qur1);
                                                            $item_id = $rowc1['good_bad_pieces_id'];
                                                            $image_name = $rowc1['good_image_name'];

                                                            ?>
                                                            <td>
                                                                <!--                            <button type="button" id="edit" class="btn btn-info btn-xs"-->
                                                                <!--                                    data-id="--><?php //echo $rowc['good_bad_pieces_id']; ?><!--"-->
                                                                <!--                                    data-gbid="--><?php //echo $rowc['bad_pieces_id']; ?><!--"-->
                                                                <!--                                    data-seid="--><?php //echo $station_event_id; ?><!--"-->
                                                                <!--                                    data-good_pieces="--><?php //echo $rowc['good_pieces']; ?><!--"-->
                                                                <!--                                    data-defect_name="--><?php //echo $rowc['defect_name']; ?><!--"-->
                                                                <!--                                    data-bad_pieces="--><?php //echo $rowc['bad_pieces']; ?><!--"-->
                                                                <!--                                    data-re_work="--><?php //echo $rowc['rework']; ?><!--"-->
                                                                <!--                                    data-image="--><?php //echo $item_id; ?><!--"-->
                                                                <!--                                    data-image_name="--><?php //echo $image_name; ?><!--"-->
                                                                <!--                                    data-toggle="modal" style="background-color:#1e73be;"-->
                                                                <!--                                    data-target="#edit_modal_theme_primary">Edit </button>-->
                                                                <?php   if($rowc['good_pieces'] != ""){ ?>
                                                                    <a  href="<?php echo $siteURL; ?>events_module/edit_good_piece.php?station_event_id=<?php echo $station_event_id; ?>&bad_pieces_id=<?php echo $bad_pieces_id;?>"" data-id="<?php echo $rowc['good_bad_pieces_id']; ?>" data-gbid="<?php echo $rowc['bad_pieces_id']; ?>" data-seid="<?php echo $station_event_id; ?>" data-good_pieces="<?php echo $rowc['good_pieces']; ?>"
                                                                    data-defect_name="<?php echo $rowc['defect_name']; ?>" data-bad_pieces="<?php echo $rowc['bad_pieces']; ?>" data-re_work="<?php echo $rowc['rework']; ?>" data-image="<?php echo $item_id; ?>"
                                                                    data-image_name="<?php echo $image_name; ?>" class="btn btn-info btn-xs" id="edit">Edit
                                                                    </a> <?php } elseif($rowc['bad_pieces'] != ""){?>
                                                                    <a href="<?php echo $siteURL; ?>events_module/edit_bad_piece.php?station_event_id=<?php echo $station_event_id; ?>&bad_pieces_id=<?php echo $bad_pieces_id;?>"" data-id="<?php echo $rowc['good_bad_pieces_id']; ?>" data-gbid="<?php echo $rowc['bad_pieces_id']; ?>" data-seid="<?php echo $station_event_id; ?>" data-good_pieces="<?php echo $rowc['good_pieces']; ?>"
                                                                    data-defect_name="<?php echo $rowc['defect_name']; ?>" data-bad_pieces="<?php echo $rowc['bad_pieces']; ?>" data-re_work="<?php echo $rowc['rework']; ?>" data-image="<?php echo $item_id; ?>"
                                                                    data-image_name="<?php echo $image_name; ?>" class="btn btn-info btn-xs" id="edit">Edit
                                                                    </a>
                                                                <?php } else{ ?>
                                                                    <a href="<?php echo $siteURL; ?>events_module/rework_piece.php?station_event_id=<?php echo $station_event_id; ?>&bad_pieces_id=<?php echo $bad_pieces_id;?>"" data-id="<?php echo $rowc['good_bad_pieces_id']; ?>" data-gbid="<?php echo $rowc['bad_pieces_id']; ?>" data-seid="<?php echo $station_event_id; ?>" data-good_pieces="<?php echo $rowc['good_pieces']; ?>"
                                                                    data-defect_name="<?php echo $rowc['defect_name']; ?>" data-bad_pieces="<?php echo $rowc['bad_pieces']; ?>" data-re_work="<?php echo $rowc['rework']; ?>" data-image="<?php echo $item_id; ?>"
                                                                    data-image_name="<?php echo $image_name; ?>" class="btn btn-info btn-xs" id="edit">Edit
                                                                    </a>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </form>
                                        <a href="#0" class="cd-popup-close"></a>
                                    </div> <!-- cd-popup-container -->
                                </div> <!-- cd-popup -->

                                <div id="pop2" class="cd-popup" role="alert">
                                    <div class="cd-popup-container">
                                        <?php
                                        $st = $_REQUEST['station'];
                                        //$st_dashboard = base64_decode(urldecode($st));
                                        $sql1 = "SELECT * FROM `cam_line` where line_id = '$st'";
                                        $result1 = $mysqli->query($sql1);
                                        //                                            $entry = 'selected';
                                        while ($row1 = $result1->fetch_assoc()) {
                                            $line_name = $row1['line_name'];
                                            $line_no = $row1['line_id'];


                                        }
                                        ?>
                                        <div class="panel panel-flat">
                                            <div class="panel-heading">

                                                <?php if ($temp == "one") { ?>
                                                    <br/>
                                                    <div class="alert alert-success no-border">
                                                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span
                                                                    class="sr-only">Close</span></button>
                                                        <span class="text-semibold">Material Tracability.</span> Created Successfully.
                                                    </div>
                                                <?php } ?>
                                                <?php if ($temp == "two") { ?>
                                                    <br/>
                                                    <div class="alert alert-success no-border">
                                                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span
                                                                    class="sr-only">Close</span></button>
                                                        <span class="text-semibold">Material Tracability.</span> Updated Successfully.
                                                    </div>
                                                <?php } ?>
                                                <?php
                                                if (!empty($import_status_message)) {
                                                    echo '<br/><div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
                                                }
                                                ?>
                                                <?php
                                                if (!empty($_SESSION[import_status_message])) {
                                                    echo '<br/><div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
                                                    $_SESSION['message_stauts_class'] = '';
                                                    $_SESSION['import_status_message'] = '';
                                                }
                                                ?>


                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <form action="material_backend.php" id="material_setting" enctype="multipart/form-data"
                                                              class="form-horizontal" method="post">
                                                            <div class="row">
                                                                <label class="col-lg-2 control-label" style="padding-top: 10px;">Station : </label>
                                                                <div class="col-md-6">
                                                                    <?php $form_id = $_GET['id'];
                                                                    //$station_event_id = base64_decode(urldecode($station_event_id)); ?>
                                                                    <input type="hidden" name="station_event_id"
                                                                           value="<?php echo $station_event_id ?>">
                                                                    <input type="hidden" name="customer_account_id" value="<?php echo $account_id ?>">
                                                                    <input type="hidden" name="station" value="<?php echo $st; ?>">
                                                                    <input type="hidden" name="line_number" value="<?php echo $line_no; ?>">
                                                                    <input type="text" name="line_number1" id="line_number"
                                                                           value="<?php echo $line_name ?>" class="form-control"
                                                                           placeholder="Enter Line Number">
                                                                </div>
                                                            </div>
                                                            <br/>
                                                            <div class="row">
                                                                <label class="col-lg-2 control-label" style="padding-top: 10px;">Part Number : </label>
                                                                <div class="col-md-6">
                                                                    <input type="hidden" name="part_number" value="<?php echo $part_number; ?>">
                                                                    <input type="text" name="part_number1" id="part_number"
                                                                           value="<?php echo $pm_part_number; ?>" class="form-control"
                                                                           placeholder="Enter Part Number">
                                                                </div>
                                                            </div>
                                                            <br/>
                                                            <div class="row">
                                                                <label class="col-lg-2 control-label" style="padding-top: 10px;">Part Family : </label>
                                                                <div class="col-md-6">
                                                                    <input type="hidden" name="part_family" value="<?php echo $part_family; ?>">
                                                                    <input type="text" name="part_family1" id="part_family"
                                                                           value="<?php echo $pm_part_family_name; ?>" class="form-control"
                                                                           placeholder="Enter Part Family">
                                                                </div>
                                                            </div>
                                                            <br/>
                                                            <div class="row">
                                                                <label class="col-lg-2 control-label" style="padding-top: 10px;">Part Name : </label>
                                                                <div class="col-md-6">
                                                                    <!--                                    <input type="hidden" name="part_name" value="-->
                                                                    <?php //echo $part_family; ?><!--">-->
                                                                    <input type="text" name="part_name" id="part_name"
                                                                           value="<?php echo $pm_part_name; ?>" class="form-control"
                                                                           placeholder="Enter Part Name">
                                                                </div>
                                                            </div>
                                                            <br/>


                                                            <div class="row">
                                                                <label class="col-lg-2 control-label">Material type : </label>
                                                                <div class="col-md-6">
                                                                    <select name="material_type" id="material_type" class="select" data-style="bg-slate" required >
                                                                        <option value="" selected disabled>--- Select material Type ---</option>
                                                                        <?php
                                                                        $sql1 = "SELECT material_id, material_type,serial_num_required FROM `material_config`";
                                                                        $result1 = mysqli_query($db, $sql1);
                                                                        while ($row1 = $result1->fetch_assoc()) {

                                                                            echo "<option value=" . $row1['material_id'] . "_" . $row1['serial_num_required'] . ">" . $row1['material_type'] . "</option>";

                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div id="error6" class="red">Please Enter Material Type</div>
                                                            <br/>
                                                            <div class="row">
                                                                <label class="col-lg-2 control-label">Image : </label>

                                                                <div class="col-md-6">
                                                                    <input type="file" id="file" name="file" class="form-control"/>
                                                                    <div class="container"></div>
                                                                </div>


                                                            </div>
                                                            <br/>
                                                            <?php


                                                            $m_type = $_POST['material_type'];

                                                            $sql = "SELECT serial_num_required FROM `material_config` where material_type = '$m_type'";
                                                            $row = mysqli_query($db, $sql);
                                                            $se_row = mysqli_fetch_assoc($row);

                                                            $serial = $se_row['serial_num_required'];

                                                            ?>
                                                            <div class="row" id = "serial_num">

                                                            </div>
                                                            <br/>

                                                            <div class="row">
                                                                <label class="col-lg-2 control-label">Material Status : </label>
                                                                <div class="col-md-6">
                                                                    <div class="form-check form-check-inline">
                                                                        <input type="radio" id="pass" name="material_status" value="1"
                                                                               class="form-check-input" checked required>
                                                                        <label for="pass" class="item_label">Pass</label>

                                                                        <input type="radio" id="fail" name="material_status" value="0"
                                                                               class="form-check-input reject" required>
                                                                        <label for="fail" class="item_label">Fail</label>


                                                                    </div>

                                                                </div>
                                                                <div id="error7" class="red">Please Enter material Status</div>

                                                            </div>
                                                            <br/>
                                                            <div id="rej_fail" style="display: none;">

                                                            </div>
                                                            <div class="row">
                                                                <label class="col-lg-2 control-label">Notes : </label>
                                                                <div class="col-md-6">
                                                                                                                                                                                                                                                                                    <textarea
                                                                                                                                                                                                                                                                                            id="notes"
                                                                                                                                                                                                                                                                                            name="material_notes"
                                                                                                                                                                                                                                                                                            rows="4"
                                                                                                                                                                                                                                                                                            placeholder="Enter Notes..."
                                                                                                                                                                                                                                                                                            class="form-control"></textarea>
                                                                </div>
                                                            </div>
                                                            <br/>
                                                            <hr/>
                                                            <br/>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="panel-footer p_footer">

                                                <button type="submit" id="form_submit_btn" class="btn btn-primary submit_btn"
                                                        style="background-color:#1e73be;">Submit
                                                </button>

                                            </div>
                                            </form>


                                        </div>
                                        <a href="#0" class="cd-popup-close"></a>
                                    </div> <!-- cd-popup-container -->
                                </div> <!-- cd-popup -->
                            </div>

                            <span style="font-size:30px;cursor:pointer;float: right;margin-top: -10px;" onclick="openNav()">&#9776;</span>

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
    $(document).ready(function () {
        $('.select').select2();
    });


</script>


<script>
    document.getElementById('material_type').onchange = function () {
        var sel_val = this.value.split('_');
        var isDis = sel_val[1];
        var rr = document.getElementById("serial_num");
        if(isDis == 0){
            rr.innerHTML = "";
            document.getElementById("serial_num").style.display = 'none';
            document.getElementById("file").required = false;
        }else{
            rr.innerHTML = "<label class=\"col-lg-2 control-label\" style=\"padding-top: 10px;\">Serial Number\n" +
                "                                    : </label>\n" +
                "                                <div class=\"col-md-6\">\n" +
                "                                    <input type=\"text\" size=\"30\" name=\"serial_number\" id=\"serial_number\"\n" +
                "                                           class=\"form-control\" required/>\n" +
                "                                </div>\n" +
                "                                <div id=\"error1\" class=\"red\">Enter valid Serial Number</div>";
            document.getElementById("serial_num").style.display = 'block';
            document.getElementById("file").required = true;
        }

    }
</script>
<script>
    // Upload
    $("#file").on("change", function () {
        var fd = new FormData();
        var files = $('#file')[0].files[0];
        fd.append('file', files);
        fd.append('request', 1);

        // AJAX request
        $.ajax({
            url: 'add_delete_mat_image.php',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response != 0) {
                    var count = $('.container .content_img').length;
                    count = Number(count) + 1;

                    // Show image preview with Delete button
                    $('.container').append("<div class='content_img' id='content_img_" + count + "' ><img src='" + response + "' width='100' height='100'><span class='delete' id='delete_" + count + "'>Delete</span></div>");
                }
            }
        });
    });


    // Remove file
    $('.container').on('click', '.content_img .delete', function () {
        var id = this.id;
        var split_id = id.split('_');
        var num = split_id[1];
        // Get image source
        var imgElement_src = $('#content_img_' + num)[0].children[0].src;
        //var deleteFile = confirm("Do you really want to Delete?");
        var succ = false;
        // AJAX request
        $.ajax({
            url: 'add_delete_mat_image.php',
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
                    var id = 'content_img_' + num;
                    // $('#content_img_'+num)[0].remove();
                    var elem = document.getElementById(id);
                    document.getElementById(id).style.display = 'none';
                    var nodes = $(".container")[2].childNodes;
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

<?php include("footer.php"); ?> <!-- /page container -->
<!-- new footer here -->
</body>
</html>