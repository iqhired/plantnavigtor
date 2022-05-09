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
$_SESSION['station'] = "";
$_SESSION['part_family'] = "";
$_SESSION['part_number'] = "";
$_SESSION['material_type'] = "";


//
if (count($_POST) > 0) {
    $_SESSION['station'] = $_POST['station'];
    $_SESSION['date_from'] = $_POST['date_from'];
    $_SESSION['date_to'] = $_POST['date_to'];
    $_SESSION['button'] = $_POST['button'];
    $_SESSION['timezone'] = $_POST['timezone'];
    $_SESSION['button_event'] = $_POST['button_event'];
    $_SESSION['part_family'] = $_POST['part_family'];
    $_SESSION['part_number'] = $_POST['part_number'];
    $_SESSION['material_type'] = $_POST['material_type'];
    $button_event = $_POST['button_event'];
    $station = $_POST['station'];
    $part_family = $_POST['part_family'];
    $part_number = $_POST['part_number'];
    $material_type = $_POST['material_type'];
    $dateto = $_POST['date_to'];
    $datefrom = $_POST['date_from'];
    $button = $_POST['button'];
    $timezone = $_POST['timezone'];

	$line = $_POST['station'];
	$line_id = $_POST['station'];
	$button = $_POST['button'];
	$button_event = $_POST['button_event'];
	$event_type = $_POST['event_type'];
	$event_category = $_POST['event_category'];
	$timezone = $_POST['timezone'];

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
        label.col-lg-3.control-label {
            padding: inherit;
            padding-top: 8px;
        }
        .col-lg-2 {

            padding-top: 10px;
        }

    </style>
    <script>
       window.onload = function () {
           history.replaceState("", "", "<?php echo $scriptName; ?>log_module/material_tracability_log.php");
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
$cust_cam_page_header = "Material Tracability Log";
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
                <br action="" id="user_form" class="form-horizontal" method="post">

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
                        <div class="col-md-6 mobile">
                            <label class="col-lg-3 control-label">Part Family :</label>

                            <div class="col-lg-7">
                                <select name="part_family" id="part_family" class="select form-control"
                                        style="float: left;width: initial;">
                                    <option value="" selected disabled>--- Select Part Family ---</option>
                                    <?php $part_sql = "SELECT * FROM `pm_part_family`";
                                          $part_query = mysqli_query($db, $part_sql);
                                          while( $part_row = mysqli_fetch_array($part_query)){
                                              $part_family_id = $part_row['pm_part_family_id'];
                                              $part_family_name = $part_row['part_family_name'];

                                              echo "<option value='" . $part_family_id . "'>" . $part_family_name . "</option>";
                                              ?>


                                        <?php  }  ?>


                                </select>
                            </div>
                        </div>
                    </div>
                </br>

                    <div class="row">
                        <div class="col-md-6 mobile">
                            <label class="col-lg-3 control-label">Part Number :</label>

                            <div class="col-lg-7">
                                <select name="part_number" id="station" class="select form-control"
                                        style="float: left;width: initial;">
                                    <option value="" selected disabled>--- Select Part Number ---</option>
                                    <?php $part_number_sql = "SELECT * FROM `pm_part_number`";
                                    $part_number_query = mysqli_query($db, $part_number_sql);
                                    while( $part_number_row = mysqli_fetch_array($part_number_query)){
                                        $part_number_id = $part_number_row['pm_part_number_id'];
                                        $part_number = $part_number_row['part_number'];

                                        echo "<option value='" . $part_number_id . "'>" . $part_number . "</option>";
                                        ?>


                                    <?php  }  ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mobile">
                            <label class="col-lg-3 control-label">Material Type :</label>

                            <div class="col-lg-7">
                                <select name="station" id="station" class="select form-control"
                                        style="float: left;width: initial;">
                                    <option value="" selected disabled>--- Select Material Type ---</option>
                                    <?php $mat_sql = "SELECT * FROM `material_config`";
                                         $mat_query = mysqli_query($db, $mat_sql);
                                    while( $mat_row = mysqli_fetch_array($mat_query)){
                                        $material_id = $mat_row['material_id'];
                                        $material_type = $mat_row['material_type'];

                                        echo "<option value='" . $material_id . "'>" . $material_type . "</option>";
                                        ?>


                                    <?php  }  ?>
                                </select>
                            </div>
                        </div>
                    </div>



                    <div class="row_date">
                        <div class="col-md-6 mobile_date">
<!--                    <input type="radio" name="button" id="button1" class="form-control" value="button1"-->
<!--                 style="float: left;width: initial;" checked>-->


                            <label class="col-lg-2 control-label">Date From :</label>
                            <input type="date" name="date_from" id="date_from" class="form-control"
                                   value="<?php echo $datefrom; ?>" style="float: left;width: initial;"
                                   required>
                        </div>
                        <div class="col-md-6 mobile_date">
                            <label class="col-lg-2 control-label" >Date To:</label>
                            <input type="date" name="date_to" id="date_to" class="form-control"
                                   value="<?php echo $dateto; ?>" style="float: left;width: initial;" required>

                        </div>


                    </div>


                    <br/>
                    <?php
                    if (!empty($import_status_message)) {
                        echo '<div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
                    }
                    ?>
                    <?php
                    if (!empty($_SESSION[import_status_message])) {
                        echo '<div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
                        $_SESSION['message_stauts_class'] = '';
                        $_SESSION['import_status_message'] = '';
                    }
                    ?>
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
                        <form action="export_se_log.php" method="post" name="export_excel">
                            <button type="submit" class="btn btn-primary"
                                    style="background-color:#1e73be;width:120px;"
                                    id="export" name="export" data-loading-text="Loading...">Export Data
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="panel panel-flat">
            <table class="table datatable-basic">
                <thead>
                <tr>
                    <th>Station</th>
                    <th>Part Family</th>
                    <th>Part Number</th>

                    <th>Material Type</th>
                    <th>Created On</th>
                    <th>Total Duration</th>
                </tr>
                </thead>
                <tbody>
                <?php

                /* Default Query */
                $q = "SELECT sg_events.line_id,et.event_type_name as e_type, ( select events_cat_name from events_category where events_cat_id = e_log.event_cat_id) as cat_name ,pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name, 
e_log.total_time as total_time , e_log.created_on as created_on
from sg_station_event_log as e_log  
left join sg_station_event as sg_events on e_log.station_event_id = sg_events.station_event_id
INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id 
inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id
inner Join event_type as et on e_log.event_type_id = et.event_type_id order by e_log.station_event_log_id DESC";
                $line = $_POST['station'];

                /* If Line is selected. */
                if ($line != null) {
                    $line = $_POST['station'];
                    $q = "SELECT sg_events.line_id,et.event_type_name as e_type,( select events_cat_name from events_category where events_cat_id = e_log.event_cat_id) as cat_name ,pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name, 
e_log.total_time as total_time  , e_log.created_on as created_on
from sg_station_event_log as e_log  
left join sg_station_event as sg_events on e_log.station_event_id = sg_events.station_event_id
INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id 
inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id
inner Join event_type as et on e_log.event_type_id = et.event_type_id where
DATE_FORMAT(sg_events.created_on,'%Y-%m-%d') >= '$curdate' and DATE_FORMAT(sg_events.created_on,'%Y-%m-%d') <= '$curdate' and sg_events.line_id = '$line' order by e_log.station_event_log_id DESC";
                }

                /* Build the query to fetch the data*/
                if (count($_POST) > 0) {

                    //event type

                    $q = "SELECT sg_events.line_id,et.event_type_name as e_type, ( select events_cat_name from events_category where events_cat_id = et.event_cat_id) as cat_name ,
pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,sg_events.created_on as start_time , 
sg_events.modified_on as end_time ,e_log.total_time as total_time  , e_log.created_on as created_on
from sg_station_event_log as e_log left join sg_station_event as sg_events on e_log.station_event_id = sg_events.station_event_id
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

                    $q = $q . " ORDER BY e_log.created_on  DESC";


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
//$nt = TIMEDIFF($dateTime, $dateTime2);
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

                        <td><?php echo $rowc["cat_name"]; ?></td>

                  
                        <td><?php echo $rowc['p_num']; ?></td>
                        <td><?php echo $rowc['p_name']; ?></td>
                        <td><?php echo $rowc['pf_name']; ?></td>

                        <td><?php echo $rowc['created_on']; ?></td>
                        <td><?php echo $rowc['total_time']; ?></td>

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
