<?php
include("../config.php");
$button_event = "button3";
$curdate = date('Y-m-d');
//$dateto = $curdate;
//$datefrom = $curdate;
$button = "";
$temp = "";
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
//	header('location: ../logout.php');
    exit;
}
//Set the time of the user's last activity
$_SESSION['LAST_ACTIVITY'] = $time;

$_SESSION['station'] = "";
$_SESSION['date_from'] = "";
$_SESSION['date_to'] = "";
$_SESSION['button'] = "";
$_SESSION['timezone'] = "";
$_SESSION['button_event'] = "";
$_SESSION['event_type'] = "";
$_SESSION['event_category'] = "";

if (count($_POST) > 0) {
    $_SESSION['station'] = $_POST['station'];
    $_SESSION['date_from'] = $_POST['date_from'];
    $_SESSION['date_to'] = $_POST['date_to'];
    $_SESSION['button'] = $_POST['button'];
    $_SESSION['timezone'] = $_POST['timezone'];
    $_SESSION['button_event'] = $_POST['button_event'];
    $_SESSION['event_type'] = $_POST['event_type'];
    $_SESSION['event_category'] = $_POST['event_category'];
    $_SESSION['time_from'] = $_POST['time_from'];
    $_SESSION['time_to'] = $_POST['time_to'];
    $button_event = $_POST['button_event'];
    $event_type = $_POST['event_type'];
    $event_category = $_POST['event_category'];
    $station = $_POST['station'];
    $dateto = $_POST['date_to'];
    $datefrom = $_POST['date_from'];
    $button = $_POST['button'];
    $time_from = $_POST['time_from'];
    $time_to = $_POST['time_to'];
    $time_from_min = $_POST['time_from_min'];
    $time_to_min = $_POST['time_to_min'];

}
if (count($_POST) > 0) {
    $station1 = $_POST['station'];
    $qurtemp = mysqli_query($db, "SELECT * FROM  cam_line where line_id = '$station1' ");
    while ($rowctemp = mysqli_fetch_array($qurtemp)) {
        $station1 = $rowctemp["line_name"];
    }
}
if(empty($dateto)){
    $curdate = date('Y-m-d');
    $dateto = $curdate;
}


if(empty($datefrom)){
    $yesdate = date('Y-m-d',strtotime("-1 days"));
    $datefrom = $yesdate;
}

//if(empty($time_to)){
//    $curtime = date('H');
//    $time_to = $curtime;
//}
//
//
//if(empty($time_from)){
//    $yestime =  date('H', strtotime('-1 hour'));
//    $time_from = $yestime;
//}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?> | Station Events Log</title>
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
          type="text/css">
    <link href="../assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/colors.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/style_main.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
    <!-- Core JS files -->
    <script type="text/javascript" src="../assets/js/libs/jquery-3.6.0.min.js"> </script>
    <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->
    <!-- Theme JS files -->
    <script type="text/javascript" src="../assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_bootstrap_select.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_layouts.js"></script>
    <style>
        .datatable-scroll {
            width: 100%;
            overflow-x: scroll;
        }
        .col-md-2{
            width:auto!important;
            float: left;
        }
        .col-lg-2 {
            max-width: 30%!important;
            float: left;
        }
        .row_date {
            padding-top: 22px;
            margin-left: -9px;
            padding-bottom: 20px;

        }
        .event_radio{
            width: 18%;
        }

        @media
        only screen and (max-width: 760px),
        (min-device-width: 768px) and (max-device-width: 1024px) {

            .select2-container{
                width: 100%!important;
            }
            .col-md-8 {
                width: 100%;
            }
            input[type=checkbox], input[type=radio]{
                margin: 4px 19px 0px;
            }
            .col-lg-1 {
                width: 5%;
                float: left;
            }
            .col-lg-7 {
                float: right;
                width: 65%;
            }
        }

    </style>
    <script>
        window.onload = function () {
            history.replaceState("", "", "<?php echo $scriptName; ?>log_module/station_events_log_new.php");
        }
    </script>

    <?php
    if ($button == "button2") {
        ?>
        <script>
            $(function () {
                $('#date_from').prop('disabled', true);
                $('#date_to').prop('disabled', true);
                $('#timezone').prop('disabled', false);
            });
        </script>
    <?php
    } else {
    ?>
        <script>
            $(function () {
                $('#date_from').prop('disabled', false);
                $('#date_to').prop('disabled', false);
                $('#timezone').prop('disabled', true);
            });
        </script>
        <?php
    }
    ?>

    <!-- event -->
    <?php
    if ($button_event == "button4") {
        ?>
        <script>
            $(function () {
                $('#event_type').prop('disabled', true);
                $('#event_category').prop('disabled', false);
            });
        </script>
    <?php
    } else {
    ?>
        <script>
            $(function () {
                $('#event_type').prop('disabled', false);
                $('#event_category').prop('disabled', true);
            });
        </script>
        <?php
    }
    ?>


</head>

<!-- Main navbar -->
<?php
$cust_cam_page_header = "Station Events Log";
include("../header.php");

include("../admin_menu.php");
include("../heading_banner.php");
?>
<body class="alt-menu sidebar-noneoverflow">
<!-- /main navbar -->
<!-- Page container -->
<div class="page-container">
    <!-- Page content -->

    <!-- Content area -->
    <div class="content">
        <!-- Main charts -->
        <!-- Basic datatable -->
        <div class="panel panel-flat">
            <div class="panel-heading">
                <!--							<h5 class="panel-title">Stations</h5>-->
                <!--							<hr/>-->
                <form action="" id="user_form" class="form-horizontal" method="post">

                    <div class="row">
                        <div class="col-md-6 mobile">
                            <label class=" col-lg-3 control-label event_radio">Event Type :</label>
                            <?php
                            if ($button_event == "button3") {
                                $checked = "checked";
                            } else {
                                $checked = "";
                            }
                            ?>
                            <div class="col-lg-1">
                                <input type="radio" name="button_event" id="button3" value="button3"
                                       class="form-control"
                                       style="float: left;width: initial;" <?php echo $checked; ?>>
                            </div>
                            <div class="col-lg-7">

                                <select name="event_type" id="event_type" class="select form-control"
                                        style="float: left;width: 60%;">
                                    <option value="" selected disabled>--- Select Event Type ---</option>
                                    <?php
                                    $ev_ty_post = $_POST['event_type'];
                                    $sql1 = "SELECT * FROM `event_type` ";
                                    $result1 = $mysqli->query($sql1);
                                    //                                            $entry = 'selected';
                                    while ($row1 = $result1->fetch_assoc()) {
                                        $lin = $row1['event_type_id'];

                                        if ($lin == $ev_ty_post) {
                                            $entry = 'selected';
                                        } else {
                                            $entry = '';
                                        }
                                        echo "<option value='" . $row1['event_type_id'] . "' $entry >" . $row1['event_type_name'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                        </div>
                        <div class="col-md-6 mobile">

                            <label class="col-lg-3 control-label event_radio" >Event Catagory :</label>

                            <?php
                            if ($button_event == "button4") {
                                $checked = "checked";
                            } else {
                                $checked = "";
                            }
                            ?>
                            <div class="col-lg-1">
                                <input type="radio" name="button_event" id="button4" value="button4"
                                       class="form-control"  style="float: left;width: initial;" <?php echo $checked; ?>>
                            </div>
                            <div class="col-lg-7">
                                <select name="event_category" id="event_category" class="select form-control"
                                        style="float: left;width: 60%;">
                                    <option value="" selected disabled>--- Select Event Catagory ---</option>
                                    <?php
                                    $ev_cat_post = $_POST['event_category'];
                                    $sql1 = "SELECT * FROM `events_category` ";
                                    $result1 = $mysqli->query($sql1);
                                    //                                            $entry = 'selected';
                                    while ($row1 = $result1->fetch_assoc()) {
                                        $lin = $row1['events_cat_id'];

                                        if ($lin == $ev_cat_post) {
                                            $entry = 'selected';
                                        } else {
                                            $entry = '';
                                        }
                                        echo "<option value='" . $row1['events_cat_id'] . "' $entry >" . $row1['events_cat_name'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-6 mobile">
                            <label class="col-lg-3 control-label">Station :</label>

                            <div class="col-lg-7">
                                <select name="station" id="station" class="select form-control"
                                        style="float: left;width: initial;">
                                    <option value="" selected disabled>--- Select Station ---</option>
                                    <?php
                                    $sql1 = "SELECT * FROM `cam_line` ";
                                    $result1 = $mysqli->query($sql1);
                                    //                                            $entry = 'selected';
                                    while ($row1 = $result1->fetch_assoc()) {
                                        $lin = $row1['line_id'];

                                        if ($lin == $station) {
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
                    </div>
                    <div class="row_date">
                        <div class="col-md-6 mobile_date">

                            <?php
                            if ($button != "button2") {
                                $checked = "checked";
                            } else {
                                $checked == "";
                            }
                            ?>

                            <label class="col-lg-3 control-label">Date From :</label>
                            <div class="col-lg-7">
                            <input type="date" name="date_from" id="date_from" class="form-control"
                                   value="<?php echo $datefrom; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6 mobile_date">
                            <label class="col-lg-3 control-label" >Date To:</label>
                            <div class="col-lg-7">
                                <input type="date" name="date_to" id="date_to" class="form-control"
                                   value="<?php echo $dateto; ?>" required>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <br/>
<!--                    <div class="row">-->
<!--                        <div class="col-md-6 mobile">-->
<!--                            <label class="col-lg-3 control-label">Time From:</label>-->
<!--                            <div class="col-lg-4">-->
<!--                                <select name="time_from" id="time_from" class="select form-control"-->
<!--                                        style="float: left;width: initial;" value="--><?php //echo $time_from; ?><!--">-->
<!--                                    <option value="" selected >--><?php //if(empty($time_from)){echo '--- Select Time(Hrs) ---';}else{echo $time_from;} ?><!--</option>-->
<!--                                    <option value="00">00</option>-->
<!--                                    <option value="01">01</option>-->
<!--                                    <option value="02">02</option>-->
<!--                                    <option value="03">03</option>-->
<!--                                    <option value="04">04</option>-->
<!--                                    <option value="05">05</option>-->
<!--                                    <option value="06">06</option>-->
<!--                                    <option value="07">07</option>-->
<!--                                    <option value="08">08</option>-->
<!--                                    <option value="09">09</option>-->
<!--                                    <option value="10">10</option>-->
<!--                                    <option value="11">11</option>-->
<!--                                    <option value="12">12 </option>-->
<!--                                    <option value="13">13</option>-->
<!--                                    <option value="14">14</option>-->
<!--                                    <option value="15">15</option>-->
<!--                                    <option value="16">16</option>-->
<!--                                    <option value="17">17</option>-->
<!--                                    <option value="18">18</option>-->
<!--                                    <option value="19">19</option>-->
<!--                                    <option value="20">20</option>-->
<!--                                    <option value="21">21</option>-->
<!--                                    <option value="22">22</option>-->
<!--                                    <option value="23">23</option>-->
<!--                                </select>-->
<!--                            </div>-->
<!--                            <div class="col-lg-4">-->
<!--                                <select name="time_from" id="time_from" class="select form-control"-->
<!--                                        style="float: left;width: initial;" value="--><?php //echo $time_from_min; ?><!--">-->
<!--                                    <option value="" selected >--><?php //if(empty($time_from_min)){echo '--- Select Time(Mins) ---';}else{echo $time_from_min;} ?><!--</option>-->
<!--                                    <option value="15">15 Mins</option>-->
<!--                                    <option value="30">30 Mins</option>-->
<!--                                    <option value="45">45 Mins</option>-->
<!--                                    <option value="00">00 Mins</option>-->
<!---->
<!--                                </select>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="col-md-6 mobile">-->
<!--                            <label class="col-lg-3 control-label">Time To:</label>-->
<!--                            <div class="col-lg-4">-->
<!--                                <select name="time_to" id="time_to" class="select form-control"-->
<!--                                        style="float: left;width: initial;" value="--><?php //echo $time_to; ?><!--">-->
<!--                                    <option value="" selected >--><?php //if(empty($time_to)){echo '--- Select Time(Hrs) ---';}else{echo $time_to;} ?><!--</option>-->
<!--                                    <option value="01">01</option>-->
<!--                                    <option value="02">02</option>-->
<!--                                    <option value="03">03</option>-->
<!--                                    <option value="04">04</option>-->
<!--                                    <option value="05">05</option>-->
<!--                                    <option value="06">06</option>-->
<!--                                    <option value="07">07</option>-->
<!--                                    <option value="08">08</option>-->
<!--                                    <option value="09">09</option>-->
<!--                                    <option value="10">10</option>-->
<!--                                    <option value="11">11</option>-->
<!--                                    <option value="12">12 </option>-->
<!--                                    <option value="13">13</option>-->
<!--                                    <option value="14">14</option>-->
<!--                                    <option value="15">15</option>-->
<!--                                    <option value="16">16</option>-->
<!--                                    <option value="17">17</option>-->
<!--                                    <option value="18">18</option>-->
<!--                                    <option value="19">19</option>-->
<!--                                    <option value="20">20</option>-->
<!--                                    <option value="21">21</option>-->
<!--                                    <option value="22">22</option>-->
<!--                                    <option value="23">23</option>-->
<!--                                    <option value="00">00</option>-->
<!--                                </select>-->
<!--                            </div>-->
<!--                            <div class="col-lg-4">-->
<!--                                <select name="time_to" id="time_to" class="select form-control"-->
<!--                                        style="float: left;width: initial;" value="--><?php //echo $time_to_min; ?><!--">-->
<!--                                    <option value="" selected >--><?php //if(empty($time_to_min)){echo '--- Select Time(Mins) ---';}else{echo $time_to_min;} ?><!--</option>-->
<!--                                    <option value="15">15 Mins</option>-->
<!--                                    <option value="30">30 Mins</option>-->
<!--                                    <option value="45">45 Mins</option>-->
<!--                                    <option value="00">00 Mins</option>-->
<!--                                </select>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
                    <br>



<!--                    <br/>-->
<!--                    							--><?php
//                    							if (!empty($import_status_message)) {
//                    								echo '<div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
//                    							}
//                    							?>
<!--                    							--><?php
//                    							if (!empty($_SESSION[import_status_message])) {
//                    								echo '<div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
//                    								$_SESSION['message_stauts_class'] = '';
//                    								$_SESSION['import_status_message'] = '';
//                    							}
//                    							?>
            </div>
            <div class="panel-footer p_footer">
                <div class="row">
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary"
                                style="width:120px;margin-right: 20px;background-color:#1e73be;">
                            Search
                        </button>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-primary" onclick='window.location.reload();'
                                style="background-color:#1e73be;margin-right: 20px;width:120px;">Reset
                        </button>
                    </div>
                    </form>
                    <div class="col-md-2">
                        <form action="export_se_log_new.php" method="post" name="export_excel">
                            <button type="submit" class="btn btn-primary"
                                    style="background-color:#1e73be;width:120px;"
                                    id="export" name="export" data-loading-text="Loading...">Export Data
                            </button>
                        </form>
                    </div>
<!--                    <div class="col-md-2">-->
<!--                        <form action="export_time_log.php" method="post" name="export_excel">-->
<!--                            <button type="submit" class="btn btn-primary"-->
<!--                                    style="background-color:#1e73be;width:145px;"-->
<!--                                    id="export" name="export" data-loading-text="Loading...">Export Data Time-->
<!--                            </button>-->
<!--                        </form>-->
<!--                    </div>-->
                </div>
            </div>
        </div>


        <div class="panel panel-flat">
            <table class="table datatable-basic">
                <thead>
                <tr>
                    <th>Station</th>
                    <th>Event Type</th>
                    <th>Event Category</th>
                    <!--                            <th>Start Time</th>-->
                    <th>Part Number</th>
                    <th>Part Name</th>
                    <th>Part Family</th>
                    <!--                            <th>Completion Time</th>-->
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Total Duration</th>
                </tr>
                </thead>
                <tbody>
                <?php

                /* Default Query */
                $q = "SELECT sg_events.line_id,et.event_type_name as e_type, ( select events_cat_name from events_category where events_cat_id = e_log.event_cat_id) as cat_name ,pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name, 
e_log.total_time as total_time , e_log.created_on as created_on
from sg_station_event_log_update as e_log  
left join sg_station_event as sg_events on e_log.station_event_id = sg_events.station_event_id
INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id 
inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id
inner Join event_type as et on e_log.event_type_id = et.event_type_id where DATE_FORMAT(e_log.created_on,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(e_log.created_on,'%Y-%m-%d') <= '$dateto'order by e_log.sg_station_event_update_id  DESC";
                $line = $_POST['station'];

                /* If Line is selected. */
                if ($line != null) {
                    $line = $_POST['station'];
                    $q = "SELECT sg_events.line_id,et.event_type_name as e_type,( select events_cat_name from events_category where events_cat_id = e_log.event_cat_id) as cat_name ,pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name, 
e_log.total_time as total_time  , e_log.created_on as created_on
from sg_station_event_log_update as e_log  
left join sg_station_event as sg_events on e_log.station_event_id = sg_events.station_event_id
INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id 
inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id
inner Join event_type as et on e_log.event_type_id = et.event_type_id where
DATE_FORMAT(sg_events.created_on,'%Y-%m-%d') >= '$curdate' and DATE_FORMAT(sg_events.created_on,'%Y-%m-%d') <= '$curdate' and sg_events.line_id = '$line' order by e_log.sg_station_event_update_id DESC";
                }

                /* Build the query to fetch the data*/
                if (count($_POST) > 0) {
                    $line = $_POST['station'];
                    $line_id = $_POST['station'];
                    $dateto = $_POST['date_to'];
                    $datefrom = $_POST['date_from'];
                    $button = $_POST['button'];
                    $button_event = $_POST['button_event'];
                    $event_type = $_POST['event_type'];
                    $event_category = $_POST['event_category'];
                    $timezone = $_POST['timezone'];
                    //event type

                    $q = "SELECT sg_events.line_id,et.event_type_name as e_type, ( select events_cat_name from events_category where events_cat_id = et.event_cat_id) as cat_name ,
pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,e_log.created_on as start_time , 
e_log.end_time as end_time ,e_log.total_time as total_time  from sg_station_event_log_update as e_log left join sg_station_event as sg_events on e_log.station_event_id = sg_events.station_event_id
INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id 
inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id 
inner join event_type as et on e_log.event_type_id = et.event_type_id 
where 1 ";

                    /* If Line is selected. */
                    if ($line_id != null) {
                        $q = $q . " and sg_events.line_id = '$line_id' ";
                    }


                    if($datefrom != "" && $dateto != ""){
                        $q = $q . " AND DATE_FORMAT(e_log.created_on,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(e_log.created_on,'%Y-%m-%d') <= '$dateto' ";
                    }else if($datefrom != "" && $dateto == ""){
                        $q = $q . " AND DATE_FORMAT(e_log.created_on,'%Y-%m-%d') >= '$datefrom' ";
                    }else if($datefrom == "" && $dateto != ""){
                        $q = $q . " AND DATE_FORMAT(e_log.created_on,'%Y-%m-%d') <= '$dateto' ";
                    }

//                    if($time_from != "" && $time_to != ""){
//                        $q = $q . "AND DATE_FORMAT(e_log.created_on,'%H') BETWEEN '$time_from' and  '$time_to' AND DATE_FORMAT(e_log.created_on,'%i') BETWEEN '$time_from_min' and  '$time_to_min'  AND DATE_FORMAT(e_log.created_on,'%i') BETWEEN '00' and  '59'";
//                    }else if($time_from != "" && $time_to == ""){
//                        $q = $q . " AND DATE_FORMAT(e_log.created_on,'%H') >= '$time_from' AND DATE_FORMAT(e_log.created_on,'%i') > '$time_from_min' AND DATE_FORMAT(e_log.created_on,'%i') BETWEEN '00' and  '59'";
//                    }else if($time_from == "" && $time_to != ""){
//                        $q = $q . " DATE_FORMAT(e_log.created_on,'%H') < '$time_to'  AND DATE_FORMAT(e_log.created_on,'%i') < '$time_to_min' AND DATE_FORMAT(e_log.created_on,'%i') BETWEEN '00' and  '59'";
//                    }


                    if ($event_type != "") {
                        if ($station != "" ) {
                            $q = $q . "  and sg_events.line_id = '$station' and e_log.event_type_id = '$event_type' ";
                        } else if ($station == "") {
                            $query = " and e_log.event_type_id = '$event_type'";
                        }
                    }

                    if ($event_category != "") {
                        if ($station != "") {
                            $q = $q . " AND sg_events.line_id = '$station'  and e_log.event_cat_id = '$event_category'";
                        } else if ($station == "") {
                            $q = $q . " AND  e_log.event_cat_id ='$event_category'";
                        }
                    }

                    $q = $q . " ORDER BY e_log.sg_station_event_update_id  DESC";


//							if ($event_type != "") {
//							    /* If Data Range is selected */
//								if ($button == "button1") {
//									if ($station != "" && $datefrom != "" && $dateto != "") {
////									$qur = mysqli_query($db, );
//										$query = $q . " DATE_FORMAT(e_log.created_on,'%Y-%m-%d') >= '$datefrom'
//and DATE_FORMAT(e_log.created_on,'%Y-%m-%d') <= '$dateto' and sg_events.line_id = '$station' and e_log.event_type_id = '$event_type' ";
//									} else if ($station != "" && $datefrom == "" && $dateto == "") {
////									$qur = mysqli_query($db, "SELECT line_id,pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,sg_events.created_on as start_time , sg_events.modified_on as end_time ,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(sg_events.modified_on ,sg_events.created_on))) as total_time from sg_station_event as sg_events INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id where event_status = 0 AND  `sg_events.line_id` = '$station' and `sg_events.event_type_id` = '$event_type'");
//										$query = "SELECT sg_events.line_id,et.event_type_name as e_type, ( select events_cat_name from events_category where events_cat_id = '$event_category') as cat_name ,
//pn.part_number as p_num,pn.part_name as p_name , pf.part_family_name as pf_name,sg_events.created_on as start_time ,
//sg_events.modified_on as end_time ,e_log.total_time as total_time
//from sg_station_event_log as e_log left join sg_station_event as sg_events on e_log.station_event_id = sg_events.station_event_id
//INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id
//inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id
//inner join event_type as et on e_log.event_type_id = et.event_type_id
//where e_log.line_id = '$station' and e_log.event_type_id = '$event_type'";
//									} else if ($station == "" && $datefrom != "" && $dateto != "") {
////									$qur = mysqli_query($db, "SELECT line_id,pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,sg_events.created_on as start_time , sg_events.modified_on as end_time ,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(sg_events.modified_on ,sg_events.created_on))) as total_time from sg_station_event as sg_events INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id where event_status = 0 AND DATE_FORMAT(`created_on`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`created_on`,'%Y-%m-%d') <= '$dateto' and `event_type_id` = '$event_type'");
//										$query = "SELECT sg_events.line_id,et.event_type_name as e_type, ( select events_cat_name from events_category where events_cat_id = '$event_category') as cat_name ,
//pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,
//sg_events.created_on as start_time , sg_events.modified_on as end_time ,e_log.total_time as total_time
//from sg_station_event_log as e_log left join sg_station_event as sg_events on e_log.station_event_id = sg_events.station_event_id
//INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id
//inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id
//inner join event_type as et on e_log.event_type_id = et.event_type_id
//where DATE_FORMAT(e_log.created_on,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(e_log.created_on,'%Y-%m-%d') <= '$dateto' and e_log.event_type_id = '$event_type'";
//									}
//
//								} else {
//								    /* If Date Period is Selected */
//									$curdate = date('Y-m-d');
//									if ($timezone == "7") {
//										$countdate = date('Y-m-d', strtotime('-7 days'));
//									} else if ($timezone == "1") {
//										$countdate = date('Y-m-d', strtotime('-1 days'));
//									} else if ($timezone == "30") {
//										$countdate = date('Y-m-d', strtotime('-30 days'));
//									} else if ($timezone == "90") {
//										$countdate = date('Y-m-d', strtotime('-90 days'));
//									} else if ($timezone == "180") {
//										$countdate = date('Y-m-d', strtotime('-180 days'));
//									} else if ($timezone == "365") {
//										$countdate = date('Y-m-d', strtotime('-365 days'));
//									}
//									if ($station != "" && $timezone != "") {
////									$qur = mysqli_query($db, "SELECT line_id,pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,sg_events.created_on as start_time , sg_events.modified_on as end_time ,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(sg_events.modified_on ,sg_events.created_on))) as total_time from sg_station_event as sg_events INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id where event_status = 0 AND DATE_FORMAT(`created_on`,'%Y-%m-%d') >= '$countdate' and DATE_FORMAT(`created_on`,'%Y-%m-%d') <= '$curdate' and `line_id` = '$station' and `event_type_id` = '$event_type'");
//										$query = "SELECT sg_events.line_id,et.event_type_name as e_type, ( select events_cat_name from events_category where events_cat_id = '$event_category') as cat_name ,
//pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,sg_events.created_on as start_time ,
//sg_events.modified_on as end_time ,e_log.total_time as total_time
//from sg_station_event_log as e_log left join sg_station_event as sg_events on e_log.station_event_id = sg_events.station_event_id
//INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id
//inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id
//inner join event_type as et on sg_events.event_type_id = et.event_type_id
//where DATE_FORMAT(`created_on`,'%Y-%m-%d') >= '$countdate'
//and DATE_FORMAT(e_log.created_on,'%Y-%m-%d') <= '$curdate' and `line_id` = '$station' and `event_type_id` = '$event_type'";
//									} else if ($station != "" && $timezone == "") {
////									$qur = mysqli_query($db, "SELECT line_id,pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,sg_events.created_on as start_time , sg_events.modified_on as end_time ,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(sg_events.modified_on ,sg_events.created_on))) as total_time from sg_station_event as sg_events INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id where event_status = 0 AND  `line_id` = '$station' and `event_type_id` = '$event_type'");
//										$query = "SELECT sg_events.line_id,et.event_type_name as e_type, ( select events_cat_name from events_category where events_cat_id = '$event_category') as cat_name ,
//pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,sg_events.created_on as start_time ,
//sg_events.modified_on as end_time ,e_log.total_time as total_time
//from sg_station_event_log as e_log left join sg_station_event as sg_events on e_log.station_event_id = sg_events.station_event_id
//INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id
//inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id
//inner join event_type as et on sg_events.event_type_id = et.event_type_id
//where  sg_events.line_id = '$station' and e_log.event_type_id = '$event_type'";
//									} else if ($taskboard == "" && $timezone != "") {
////									$qur = mysqli_query($db, "SELECT line_id,pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,sg_events.created_on as start_time , sg_events.modified_on as end_time ,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(sg_events.modified_on ,sg_events.created_on))) as total_time from sg_station_event as sg_events INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id where event_status = 0 AND DATE_FORMAT(`created_on`,'%Y-%m-%d') >= '$countdate' and DATE_FORMAT(`created_on`,'%Y-%m-%d') <= '$curdate' and `event_type_id` = '$event_type'");
//										$query = "SELECT sg_events.line_id,et.event_type_name as e_type, ( select events_cat_name from events_category where events_cat_id = '$event_category') as cat_name ,
//pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,sg_events.created_on as start_time ,
//sg_events.modified_on as end_time ,e_log.total_time as total_time
//from sg_station_event_log as e_log left join sg_station_event as sg_events on e_log.station_event_id = sg_events.station_event_id
//INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id
//inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id
//inner join event_type as et on sg_events.event_type_id = et.event_type_id
//where DATE_FORMAT(e_log.created_on,'%Y-%m-%d') >= '$countdate' and DATE_FORMAT(e_log.created_on,'%Y-%m-%d') <= '$curdate' and e_log.event_type_id = '$event_type'";
//									}
//								}
//
//							}

//							//event category
//							if ($event_category != "") {
//								if ($button == "button1") {
//									if ($station != "" && $datefrom != "" && $dateto != "") {
////									$qur = mysqli_query($db, "SELECT pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,sg_events.created_on as start_time , sg_events.modified_on as end_time ,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(sg_events.modified_on ,sg_events.created_on))) as total_time from sg_station_event as sg_events INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id where event_status = 0 AND DATE_FORMAT(`created_on`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`created_on`,'%Y-%m-%d') <= '$dateto' and `line_id` = '$station' and `event_category_id` = '$event_category' ");
//										$query = "SELECT sg_events.line_id,et.event_type_name as e_type, ( select events_cat_name from events_category where events_cat_id = '$event_category') as cat_name ,
//pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,sg_events.created_on as start_time ,
//sg_events.modified_on as end_time ,e_log.total_time as total_time
//from sg_station_event_log as e_log left join sg_station_event as sg_events on e_log.station_event_id = sg_events.station_event_id
//INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id
//inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id
//inner join event_type as et on sg_events.event_type_id = et.event_type_id
//where DATE_FORMAT(e_log.created_on,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(e_log.created_on,'%Y-%m-%d') <= '$dateto'
//and sg_events.line_id = '$station'  and e_log.event_cat_id = '$event_category'";
//									} else if ($station != "" && $datefrom == "" && $dateto == "") {
////									$qur = mysqli_query($db, "SELECT line_id,pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,sg_events.created_on as start_time , sg_events.modified_on as end_time ,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(sg_events.modified_on ,sg_events.created_on))) as total_time from sg_station_event as sg_events INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id where event_status = 0 AND  `line_id` = '$station' and `event_category_id` = '$event_category'");
//										$query = "SELECT sg_events.line_id,et.event_type_name as e_type, ( select events_cat_name from events_category where events_cat_id = '$event_category') as cat_name ,
//pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,sg_events.created_on as start_time ,
// sg_events.modified_on as end_time ,e_log.total_time as total_time
// from sg_station_event_log as e_log left join sg_station_event as sg_events on e_log.station_event_id = sg_events.station_event_id
// INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id
// inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id
//inner join event_type as et on sg_events.event_type_id = et.event_type_id where
//sg_events.line_id = '$station' and e_log.event_cat_id  = '$event_category'";
//									} else if ($station == "" && $datefrom != "" && $dateto != "") {
////									$qur = mysqli_query($db, "SELECT line_id,pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,sg_events.created_on as start_time , sg_events.modified_on as end_time ,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(sg_events.modified_on ,sg_events.created_on))) as total_time from sg_station_event as sg_events INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id where event_status = 0 AND DATE_FORMAT(`created_on`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`created_on`,'%Y-%m-%d') <= '$dateto' and `event_category_id` = '$event_category'");
//										$query = "SELECT sg_events.line_id,et.event_type_name as e_type, ( select events_cat_name from events_category where events_cat_id = '$event_category') as cat_name ,
//pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,sg_events.created_on as start_time ,
//sg_events.modified_on as end_time ,e_log.total_time as total_time
//from sg_station_event_log as e_log left join sg_station_event as sg_events on e_log.station_event_id = sg_events.station_event_id
//INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id
//inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id
//inner join event_type as et on sg_events.event_type_id = et.event_type_id
//where  DATE_FORMAT(e_log.created_on,'%Y-%m-%d') >= '$datefrom'
//and DATE_FORMAT(e_log.created_on,'%Y-%m-%d') <= '$dateto' and e_log.event_cat_id ='$event_category'";
//									}
//
//								} else {
//									$curdate = date('Y-m-d');
//									if ($timezone == "7") {
//										$countdate = date('Y-m-d', strtotime('-7 days'));
//									} else if ($timezone == "1") {
//										$countdate = date('Y-m-d', strtotime('-1 days'));
//									} else if ($timezone == "30") {
//										$countdate = date('Y-m-d', strtotime('-30 days'));
//									} else if ($timezone == "90") {
//										$countdate = date('Y-m-d', strtotime('-90 days'));
//									} else if ($timezone == "180") {
//										$countdate = date('Y-m-d', strtotime('-180 days'));
//									} else if ($timezone == "365") {
//										$countdate = date('Y-m-d', strtotime('-365 days'));
//									}
//									if ($station != "" && $timezone != "") {
////									$qur = mysqli_query($db, "SELECT line_id,pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,sg_events.created_on as start_time , sg_events.modified_on as end_time ,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(sg_events.modified_on ,sg_events.created_on))) as total_time from sg_station_event as sg_events INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id where event_status = 0 AND DATE_FORMAT(`created_on`,'%Y-%m-%d') >= '$countdate' and DATE_FORMAT(`created_on`,'%Y-%m-%d') <= '$curdate' and `line_id` = '$station' and `event_category_id` = '$event_category'");
//										$query = "SELECT sg_events.line_id,et.event_type_name as e_type, ( select events_cat_name from events_category where events_cat_id = '$event_category') as cat_name ,
//pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,sg_events.created_on as start_time ,
//sg_events.modified_on as end_time ,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(sg_events.modified_on ,sg_events.created_on))) as total_time
//from sg_station_event_log as e_log left join sg_station_event as sg_events on e_log.station_event_id = sg_events.station_event_id
//INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id
//inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id
//inner join event_type as et on sg_events.event_type_id = et.event_type_id
//where DATE_FORMAT(e_log.created_on,'%Y-%m-%d') >= '$countdate'
//and DATE_FORMAT(e_log.created_on,'%Y-%m-%d') <= '$curdate' and sg_events.line_id = '$station' and e_log.event_cat_id = '$event_category'";
//									} else if ($station != "" && $timezone == "") {
////									$qur = mysqli_query($db, "SELECT line_id,pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,sg_events.created_on as start_time , sg_events.modified_on as end_time ,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(sg_events.modified_on ,sg_events.created_on))) as total_time from sg_station_event as sg_events INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id where event_status = 0 AND  `line_id` = '$station' and `event_category_id` = '$event_category'");
//										$query = "SELECT sg_events.line_id,et.event_type_name as e_type, ( select events_cat_name from events_category where events_cat_id = '$event_category') as cat_name ,
//pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,sg_events.created_on as start_time ,
//sg_events.modified_on as end_time ,e_log.total_time as total_time
//from sg_station_event_log as e_log left join sg_station_event as sg_events on e_log.station_event_id = sg_events.station_event_id
//INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id
//inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id
//inner join event_type as et on sg_events.event_type_id = et.event_type_id
//where sg_events.line_id = '$station' and e_log.event_cat_id = '$event_category'";
//									} else if ($taskboard == "" && $timezone != "") {
////									$qur = mysqli_query($db, "SELECT line_id,pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,sg_events.created_on as start_time , sg_events.modified_on as end_time ,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(sg_events.modified_on ,sg_events.created_on))) as total_time from sg_station_event as sg_events INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id where event_status = 0 AND DATE_FORMAT(`created_on`,'%Y-%m-%d') >= '$countdate' and DATE_FORMAT(`created_on`,'%Y-%m-%d') <= '$curdate' and `event_category_id` = '$event_category'");
//										$query = "SELECT sg_events.line_id,et.event_type_name as e_type, ( select events_cat_name from events_category where events_cat_id = '$event_category') as cat_name ,
//pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,sg_events.created_on as start_time ,
//sg_events.modified_on as end_time ,e_log.total_time as total_time
//from sg_station_event_log as e_log left join sg_station_event as sg_events on e_log.station_event_id = sg_events.station_event_id
//INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id
//inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id
//inner join event_type as et on sg_events.event_type_id = et.event_type_id where DATE_FORMAT(e_log.created_on,'%Y-%m-%d') >= '$countdate'
//and DATE_FORMAT(e_log.created_on,'%Y-%m-%d') <= '$curdate' and e_log.event_cat_id = '$event_category'";
//									}
//								}
//
//							}

                }

                /* Execute the Query Built*/
                $qur = mysqli_query($db, $q);
                while ($rowc = mysqli_fetch_array($qur)) {
                    $dateTime = $rowc["assign_time"];
                    $dateTime2 = $rowc["unassign_time"];
                    ?>
                    <tr>
                        <?php
                        $un = $rowc['line_id'];
                        $qur04 = mysqli_query($db, "SELECT line_name FROM  cam_line where line_id = '$un' ");
                        while ($rowc04 = mysqli_fetch_array($qur04)) {
                            $lnn = $rowc04["line_name"];
                        }
                        ?>
                        <td><?php echo $lnn; ?></td>
                        <td><?php echo $rowc["e_type"]; ?></td>
                        <td><?php echo $rowc["cat_name"]; ?></td>


                        <td><?php echo $rowc['p_num']; ?></td>
                        <td><?php echo $rowc['p_name']; ?></td>
                        <td><?php echo $rowc['pf_name']; ?></td>

                        <td><?php echo $rowc['start_time']; ?></td>
                        <td><?php echo $rowc['end_time']; ?></td>
                        <td><?php
                            $total_time = '0 hrs';
                            $tt = $rowc['total_time'];
                            if(!empty($tt)){
                                $t_arr = explode(':',$tt);
                                $tot_time = $t_arr[0] + ($t_arr[1] / 60) + ($t_arr[2] /3600);
                                echo round($tot_time, 3) .'  hrs';
                            }else{
                                echo $total_time;
                            }

                            ?></td>

                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- /basic datatable -->

        <!-- /dashboard content -->
        <script>
            $(function () {
                $('input:radio').change(function () {
                    var abc = $(this).val()
                    //  alert(abc);
                    if (abc == "button1") {
                        $('#date_from').prop('disabled', false);
                        $('#date_to').prop('disabled', false);
                        $('#timezone').prop('disabled', true);
                    } else if (abc == "button2") {
                        $('#date_from').prop('disabled', true);
                        $('#date_to').prop('disabled', true);
                        $('#timezone').prop('disabled', false);
                    } else if (abc == "button3") {
                        $('#event_category').prop('disabled', true);
                        $('#event_type').prop('disabled', false);
                    } else if (abc == "button4") {
                        $('#event_type').prop('disabled', true);
                        $('#event_category').prop('disabled', false);
                    }


                });
            });
        </script>
    </div>
    <!-- /content area -->

</div>
<!-- /page container -->
<?php include('../footer.php') ?>
<script type="text/javascript" src="../assets/js/core/app.js"></script>
</body>
</html>
