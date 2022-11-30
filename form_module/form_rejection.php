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
$is_tab_login = $_SESSION['is_tab_user'];
$is_cell_login = $_SESSION['is_cell_login'];
//Set the time of the user's last activity
$_SESSION['LAST_ACTIVITY'] = $time;
$i = $_SESSION["role_id"];
if ($i != "super" && $i != "admin" && $i != "pn_user" && $_SESSION['is_tab_user'] != 1 && $_SESSION['is_cell_login'] != 1 ) {
    header('location: ../dashboard.php');
}
if (count($_POST) > 0) {

    $dateto = $_POST['date_to'];
    $datefrom = $_POST['date_from'];
    $button = $_POST['button'];

    $_SESSION['station_1'] = $_POST['station'];
    $_SESSION['part_family_1'] = $_POST['part_family'];
    $_SESSION['part_number_1'] = $_POST['part_number'];
    $_SESSION['form_type_1'] = $_POST['form_type'];
    $_SESSION['date_from_1'] = $_POST['date_from'];
    $_SESSION['date_to_1'] = $_POST['date_to'];
    $_SESSION['timezone_1'] = $_POST['timezone'];
}else{
    $curdate = date('Y-m-d');
    $dateto = $curdate;
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
    <title><?php echo $sitename; ?> | View Rejected Form(s)</title>
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">


    <link href="<?php echo $siteURL; ?>assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/colors.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/style_main.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
    <!-- Core JS files -->
    <script type="text/javascript" src="../assets/js/libs/jquery-3.6.0.min.js"> </script>
    <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->
    <!-- Theme JS files -->
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/core/app.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/components_modals.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/form_bootstrap_select.js"></script>
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/form_layouts.js"></script>
    <style>
        .tooltip {
            position: relative;
            display: inline-block;
            /*border-bottom: 1px dotted black;*/
            opacity: 1!important;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 120px;
            background-color: #d6d8db;
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
        .col-md-6.date {
            width: 25%;
        }


        @media
        only screen and (max-width: 760px),
        (min-device-width: 768px) and (max-device-width: 1024px)  {

            .form_mob{
                display: none;
            }
            .form_create{
                display: none;
            }




        }
        @media
        only screen and (max-width: 400px),
        (min-device-width: 400px) and (max-device-width: 670px)  {

            .form_mob{
                display: none;
            }
            .form_create{
                display: none;
            }
            .col-md-6.date {
                width: 100%;
                float: right;
            }





        }
    </style>

</head>
<body>
<!-- Main navbar -->
<?php $cust_cam_page_header = "View Rejection Form";
include("../header.php");

if (($is_tab_login || $is_cell_login)) {
    include("../tab_menu.php");
} else {
    include("../admin_menu.php");
}
include("../heading_banner.php");
?>
<body class="alt-menu sidebar-noneoverflow">
<div class="page-container">
    <!-- Content area -->
    <div class="content">
        <!-- Main charts -->
        <!-- Basic datatable -->
        <div class="panel panel-flat">
            <div class="panel-heading">
                <!--							<h5 class="panel-title">Job-Title List</h5>-->
                <!--							<hr/>-->

                <form action="" id="user_form" class="form-horizontal" method="post" autocomplete="off">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6 mobile">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Station * : </label>
                                        <div class="col-lg-7">
                                            <select name="station" id="station" class="select form-control" data-style="bg-slate" >
                                                <option value="" selected disabled>--- Select Station ---</option>
                                                <?php
                                                $st_dashboard = $_GET['station'];
                                                if($is_tab_login){
                                                    $sql1 = "SELECT line_id,line_name FROM `cam_line`  where enabled = '1' and line_id = '$tab_line' and is_deleted != 1 ORDER BY `line_name` ASC";
                                                    $result1 = $mysqli->query($sql1);
                                                    //                                            $entry = 'selected';
                                                    while ($row1 = $result1->fetch_assoc()) {
                                                        $entry = 'selected';
                                                        echo "<option value='" . $row1['line_id'] . "'  $entry>" . $row1['line_name'] . "</option>";
                                                    }
                                                }else if($is_cell_login){
                                                    $c_stations = implode("', '", $c_login_stations_arr);
                                                    $sql1 = "SELECT line_id,line_name FROM `cam_line`  where enabled = '1' and line_id IN ('$c_stations') and is_deleted != 1 ORDER BY `line_name` ASC";
                                                    $result1 = $mysqli->query($sql1);
//													                $                        $entry = 'selected';
                                                    $i = 0;

//														$entry = 'selected';
                                                    if(empty($_REQUEST) && empty($_REQUEST['station'])){
                                                        while ($row1 = $result1->fetch_assoc()) {
                                                            if($i == 0 ){
                                                                $entry = 'selected';
                                                                echo "<option value='" . $row1['line_id'] . "'  $entry>" . $row1['line_name'] . "</option>";
                                                                $c_station = $row1['line_id'];
                                                            }else{
                                                                echo "<option value='" . $row1['line_id'] . "'  >" . $row1['line_name'] . "</option>";

                                                            }
                                                            $i++;
                                                        }
                                                    }else{
                                                        while ($row1 = $result1->fetch_assoc()) {
                                                            if($row1['line_id'] == $_REQUEST['station'] ){
                                                                $entry = 'selected';
                                                                echo "<option value='" . $row1['line_id'] . "'  $entry>" . $row1['line_name'] . "</option>";
                                                                $c_station = $row1['line_id'];
                                                            }else{
                                                                echo "<option value='" . $row1['line_id'] . "'  >" . $row1['line_name'] . "</option>";

                                                            }
                                                            $i++;
                                                        }
                                                    }


                                                }else{
                                                    $st_dashboard = $_POST['station'];
                                                    $station22 = $st_dashboard;
                                                    $sql1 = "SELECT * FROM `cam_line` where enabled = '1' and is_deleted != 1 ORDER BY `line_name` ASC ";
                                                    $result1 = $mysqli->query($sql1);
                                                    //                                            $entry = 'selected';
                                                    while ($row1 = $result1->fetch_assoc()) {
                                                        if($st_dashboard == $row1['line_id'])
                                                        {
                                                            $entry = 'selected';
                                                        }
                                                        else
                                                        {
                                                            $entry = '';

                                                        }
                                                        echo "<option value='" . $row1['line_id'] . "'  $entry>" . $row1['line_name'] . "</option>";
                                                    }
                                                }

                                                ?>
                                            </select>
                                            <!-- <div id="error1" class="red">Please Select Station</div> -->

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mobile">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Part Family : </label>
                                        <div class="col-lg-7">
                                            <select name="part_family" id="part_family" class="select form-control" data-style="bg-slate" >
                                                <option value="" selected disabled>--- Select Part Family ---</option>
                                                <?php
                                                if(empty($_POST)){
                                                    if($_SESSION['is_tab_user'] == 1 ){
                                                        $station22 = $_SESSION['tab_station'];
                                                    }
                                                }
                                                $st_dashboard = $_POST['part_family'];
                                                if(empty($station22)){
                                                    $station22 = $_POST['station'];
                                                }

                                                if(empty($station22) && ($is_cell_login == 1) && !empty($c_station)){
                                                    $station22 = $c_station;
                                                }
                                                $part_family_name = $_POST['part_family_name'];
                                                $sql1 = "SELECT * FROM `pm_part_family` where is_deleted != 1 and station = '$station22' ";
                                                $result1 = $mysqli->query($sql1);
                                                //                                            $entry = 'selected';
                                                while ($row1 = $result1->fetch_assoc()) {
                                                    if($st_dashboard == $row1['pm_part_family_id'])
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
                                            <!-- <div id="error2" class="red">Please Select Part Family</div> -->
                                        </div>
                                    </div>
                                </div>

                            </div><br/>
                            <div class="row">

                                <div class="col-md-6 mobile">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Part Number  : </label>
                                        <div class="col-lg-7">
                                            <select name="part_number" id="part_number" class="select form-control" data-style="bg-slate" >
                                                <option value="" selected disabled>--- Select Part Number ---</option>
                                                <?php
                                                $st_dashboard = $_POST['part_number'];
                                                $part_family = $_POST['part_family'];

                                                $sql1 = "SELECT * FROM `pm_part_number` where part_family = '$part_family' and is_deleted != 1 ";
                                                $result1 = $mysqli->query($sql1);
                                                //                                            $entry = 'selected';
                                                while ($row1 = $result1->fetch_assoc()) {
                                                    if($st_dashboard == $row1['pm_part_number_id'])
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
                                            <!-- <div id="error3" class="red">Please Select Part Number</div> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mobile">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Form Type : </label>
                                        <div class="col-lg-7">
                                            <select name="form_type" id="form_type" class="select form-control" data-style="bg-slate" >
                                                <option value="" selected disabled>--- Select Form Type ---</option>
                                                <?php
                                                $st_dashboard = $_POST['form_type'];

                                                $sql1 = "SELECT * FROM `form_type` where is_deleted != 1 ";
                                                $result1 = $mysqli->query($sql1);
                                                //                                            $entry = 'selected';
                                                while ($row1 = $result1->fetch_assoc()) {
                                                    if($st_dashboard == $row1['form_type_id'])
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
                                            <!-- <div id="error4" class="red">Please Select Form Type</div> -->
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 date">
                                    <!--                                            <label class="control-label" style="float: left;padding: 10px 110px 10px 2px; font-weight: 500;">Date Range : &nbsp;&nbsp;</label>-->
                                    <?php
                                    $myDate = date("m/d/y h:i:s");

                                    ?>

                                    <input type="radio" name="button" id="button1" class="form-control" value="button1" style="float: left;width: initial; display: none;" checked>

                                    <label class="control-label" style="float: left;padding-top: 10px; font-weight: 500;">&nbsp;&nbsp;&nbsp;&nbsp;Date From : &nbsp;&nbsp;</label>
                                    <input type="date" name="date_from" id="date_from" class="form-control" value="<?php echo $datefrom; ?>" style="float: left;width: initial;" required>
                                </div>
                                <div class="col-md-6 date">
                                    <label class="control-label" style="float: left;padding-top: 10px; font-weight: 500;">&nbsp;&nbsp;&nbsp;&nbsp;Date To: &nbsp;&nbsp;</label>
                                    <input type="date" name="date_to" id="date_to" class="form-control" value="<?php echo $dateto; ?>" style="float: left;width: initial;" required>
                                </div>

                            </div><br/>

                        </div>
                    </div>

                </form>




            </div>
            <div class="panel-footer p_footer">
                <div class="row">
                    <div class="col-md-2">
                        <button type="submit" id="submit_btn" class="btn btn-primary submit_btn"  style="width:120px;background-color:#1e73be;">Submit</button>
                    </div>
                    <div class="col-md-2">
                        <button type="clear" id="btn" class="btn btn-primary"
                                style="background-color:#1e73be;width:120px;" onclick="location.reload();">Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if(count($_POST) > 0)
        {
            ?>

            <div class="panel panel-flat" >
                <table class="table datatable-basic">
                    <thead>
                    <tr>
                        <th>Sl. No</th>
                        <th>Action</th>
                        <th>Form Name</th>
                        <th>Part</th>
                        <th>Part family</th>
                        <th>Form status</th>
                        <th>Created at</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $station = $_POST['station'];
                    $part_number = $_POST['part_number'];
                    $part_family = $_POST['part_family'];
                    $form_type = $_POST['form_type'];
                    $dateto = $_POST['date_to'];
                    $datefrom = $_POST['date_from'];
                    $button = $_POST['button'];
                    if(!empty($part_number)){
                        $q_str = "and part_number = '$part_number' ";
                    }
                    if(!empty($part_family)){
                        $q_str .= "and part_family = '$part_family' ";
                    }
                    if(!empty($form_type)){
                        $q_str .= "and form_type = '$form_type' ";
                    }

                    if ($button == "button1") {
                        if ($station != "" && $datefrom != "" && $dateto != "") {
                            $result = "SELECT `form_user_data_id`,`tracker_id`,`formname`,`partfamily`,`partnumber`,`form_type`,`form_create_id`,`created_at`,`updated_at`,`r_flag` FROM `form_rejection_data` WHERE DATE_FORMAT(`created_at`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`created_at`,'%Y-%m-%d') <= '$dateto' and station = '$station' " . $q_str . "ORDER BY form_user_data_id DESC";
                            $qur = mysqli_query($db,$result);
                        } else if ($station != "" && $user != "" && $datefrom == "" && $dateto == "") {
                            $qur = mysqli_query($db, "SELECT `form_user_data_id`,`tracker_id`,`formname`,`partfamily`,`partnumber`,`form_type`,`form_create_id`,`created_at`,`updated_at`,`r_flag` FROM `form_rejection_data` WHERE  station = '$station' ");
                        } else if ($station != "" && $user == "" && $datefrom != "" && $dateto != "") {
                            $qur = mysqli_query($db, "SELECT `form_user_data_id`,`tracker_id`,`formname`,`partfamily`,`partnumber`,`form_type`,`form_create_id`,`created_at`,`updated_at`,`r_flag` FROM `form_rejection_data` WHERE DATE_FORMAT(`created_at`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`created_at`,'%Y-%m-%d') <= '$dateto' and station = '$station' " . $q_str . "ORDER BY form_user_data_id DESC ");
                        } else if ($station != "" && $user == "" && $datefrom == "" && $dateto == "") {
                            $qur = mysqli_query($db, "SELECT `form_user_data_id`,`tracker_id`,`formname`,`partfamily`,`partnumber`,`form_type`,`form_create_id`,`created_at`,`updated_at`,`r_flag` FROM `form_rejection_data` WHERE station = '$station'");
                        } else if ($station == "" && $user != "" && $datefrom != "" && $dateto != "") {
                            $qur = mysqli_query($db, "SELECT `form_user_data_id`,`tracker_id`,`formname`,`partfamily`,`partnumber`,`form_type`,`form_create_id`,`created_at`,`updated_at`,`r_flag` FROM `form_rejection_data` WHERE DATE_FORMAT(`created_at`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`created_at`,'%Y-%m-%d') <= '$dateto' and station = '$station' " . $q_str . "ORDER BY form_user_data_id DESC");
                        } else if ($station == "" && $user != "" && $datefrom == "" && $dateto == "") {
                            $qur = mysqli_query($db, "SELECT `form_user_data_id`,`tracker_id`,`formname`,`partfamily`,`partnumber`,`form_type`,`form_create_id`,`created_at`,`updated_at`,`r_flag` FROM `form_rejection_data` WHERE  station = '$station'");
                        } else if ($station == "" && $user == "" && $datefrom != "" && $dateto != "") {
                            $qur = mysqli_query($db, "SELECT `form_user_data_id`,`tracker_id`,`formname`,`partfamily`,`partnumber`,`form_type`,`form_create_id`,`created_at`,`updated_at`,`r_flag` FROM `form_rejection_data` WHERE DATE_FORMAT(`created_at`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`created_at`,'%Y-%m-%d') <= '$dateto' ");
                        }

                    }else {
                        $curdate = date('Y-m-d');
                        if ($timezone == "7") {
                            $countdate = date('Y-m-d', strtotime('-7 days'));
                        } else if ($timezone == "1") {
                            $countdate = date('Y-m-d', strtotime('-1 days'));
                        } else if ($timezone == "30") {
                            $countdate = date('Y-m-d', strtotime('-30 days'));
                        } else if ($timezone == "90") {
                            $countdate = date('Y-m-d', strtotime('-90 days'));
                        } else if ($timezone == "180") {
                            $countdate = date('Y-m-d', strtotime('-180 days'));
                        } else if ($timezone == "365") {
                            $countdate = date('Y-m-d', strtotime('-365 days'));
                        }
                        if ($station != "" && $timezone != "") {
                            $qur = mysqli_query($db, "SELECT `form_user_data_id`,`tracker_id`,`formname`,`partfamily`,`partnumber`,`form_type`,`form_create_id`,`created_at`,`updated_at`,`r_flag` FROM `form_rejection_data` WHERE DATE_FORMAT(`created_at`,'%Y-%m-%d') >= '$countdate' and DATE_FORMAT(`created_at`,'%Y-%m-%d') <= '$curdate' and station = '$station'" . $q_str . "ORDER BY form_user_data_id DESC");
                        } else if ($station != "" && $timezone == "") {
                            $qur = mysqli_query($db, "SELECT `form_user_data_id`,`tracker_id`,`formname`,`partfamily`,`partnumber`,`form_type`,`form_create_id`,`created_at`,`updated_at`,`r_flag` FROM `form_rejection_data` WHERE  station = '$station' and `assign_to` = '$user'");
                        } else if ($station != "" && $timezone != "") {
                            $qur = mysqli_query($db, "SELECT `form_user_data_id`,`tracker_id`,`formname`,`partfamily`,`partnumber`,`form_type`,`form_create_id`,`created_at`,`updated_at`,`r_flag` FROM `form_rejection_data` WHERE DATE_FORMAT(`created_at`,'%Y-%m-%d') >= '$countdate' and DATE_FORMAT(`created_at`,'%Y-%m-%d') <= '$curdate' and station = '$station'" . $q_str . "ORDER BY form_user_data_id DESC");
                        } else if ($station != "" && $timezone == "") {
                            $qur = mysqli_query($db, "SELECT `form_user_data_id`,`tracker_id`,`formname`,`partfamily`,`partnumber`,`form_type`,`form_create_id`,`created_at`,`updated_at`,`r_flag` FROM `form_rejection_data` WHERE  station = '$station'");
                        } else if ($station != "" && $timezone != "") {
                            $qur = mysqli_query($db, "SELECT `form_user_data_id`,`tracker_id`,`formname`,`partfamily`,`partnumber`,`form_type`,`form_create_id`,`created_at`,`updated_at`,`r_flag` FROM `form_rejection_data` WHERE DATE_FORMAT(`created_at`,'%Y-%m-%d') >= '$countdate' and DATE_FORMAT(`created_at`,'%Y-%m-%d') <= '$curdate' and station = '$station'" . $q_str . "ORDER BY form_user_data_id DESC");
                        } else if ($station != "" && $timezone == "") {
                            $qur = mysqli_query($db, "SELECT `form_user_data_id`,`tracker_id`,`formname`,`partfamily`,`partnumber`,`form_type`,`form_create_id`,`created_at`,`updated_at`,`r_flag` FROM `form_rejection_data` WHERE station = '$station' ");
                        } else if ($station != "" && $timezone != "") {
                            $qur = mysqli_query($db, "SELECT `form_user_data_id`,`tracker_id`,`formname`,`partfamily`,`partnumber`,`form_type`,`form_create_id`,`created_at`,`updated_at`,`r_flag` FROM `form_rejection_data` WHERE DATE_FORMAT(`created_at`,'%Y-%m-%d') >= '$countdate' and DATE_FORMAT(`created_at`,'%Y-%m-%d') <= '$curdate' ");
                        }
                    }

                    while ($rowc = mysqli_fetch_array($qur)) {
                        $form_id = $rowc["form_user_data_id"];
                        $partfamily = $rowc["partfamily"];
                        $pno = $rowc["partnumber"];
                        $r_flag = $rowc["r_flag"];
                        if($r_flag == '1'){
                            $rflag = 'In progress';
                        }else{
                            $rflag = 'Closed';
                            $style = "style='background-color:rgb(67, 160, 71);'";
                        }

                        $query1  = mysqli_query($db, "SELECT partnumber,created_at,form_create_id FROM `form_rejection_data` where form_user_data_id = ' $form_id' LIMIT 1");

                        $rowc1 = mysqli_fetch_array($query1);
                       // $pno = $rowc1['partnumber'];
                        $query2  = mysqli_query($db, "SELECT part_number,part_name FROM `pm_part_number` where pm_part_number_id = '$pno'");

                        $rowc2 = mysqli_fetch_array($query2);


                        $query4  = mysqli_query($db, "SELECT part_family_name FROM `pm_part_family` WHERE `pm_part_family_id` = '$partfamily' LIMIT 1");

                        $rowc4 = mysqli_fetch_array($query4);

                        $datetime = $rowc1["created_at"];
                        $date_time = strtotime($datetime);


                        $form_create_id = $rowc1["form_create_id"];

                        $qur0554 = mysqli_query($db, "SELECT form_classification FROM `form_create` where form_create_id =  '$form_create_id' ");
                        $rowc0554 = mysqli_fetch_array($qur0554);
                        $is_general = false;
                        if($rowc0554['form_classification'] == 'general' ){
                            $is_general = true;
                        }
                        if(!$is_general) {
                            $qur05 = mysqli_query($db, "SELECT SUM(approval_status) as app_status, SUM(reject_status) as rej_status FROM  form_approval where form_user_data_id = '$form_id' ");
                            $rowc05 = mysqli_fetch_array($qur05);


                            $approval_status = (int)$rowc05["app_status"];
                            $reject_status = (int)$rowc05["rej_status"];
                            $style = "";
                            if ($reject_status >= 1) {
                                $form_status = "Rejected";
                                $style = "style='background-color:white;'";
                            } else if ($approval_status >= 1) {
                                $form_status = "Approved";
                                $style = "style='background-color:#90EE90;'";
                            }


                        }

                        ?>

                        <tr <?php if ($r_flag != '1') {  ?> style='background-color:#90ee908f;' <?php  } ?>>

                            <td><?php echo ++$counter; ?></td>

                            <?php

                            $opt_sub = mysqli_query($db, "SELECT form_create_id FROM  form_rejection_data");

                            while ($rowcopt = mysqli_fetch_array($opt_sub)) {
                                $opt_id = $rowcopt["form_create_id"];
                            }

                            $option_submit = mysqli_query($db, "SELECT count(optional) as optional FROM  form_item where form_create_id  = '$opt_id' and optional = 1");
                            while ($rowcoptional = mysqli_fetch_array($option_submit)) {

                                $option = $rowcoptional["optional"];
                                if($rowcoptional["optional"] > 0){
                                    $option = 1;
                                }
                            }
                            // echo $opt_id;

                            ?>
                            <?php if($r_flag != '1'){ ?>
                                    <td class="tooltip">
                                        <!--<input type="button" value="✓" />-->
                                        <a href="view_closed_form.php?id=<?php echo $rowc['form_user_data_id']; ?>&optional=<?php echo $option; ?>" class="btn btn-primary" style="background-color:#1e73be;"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                        <!--<span class="tooltiptext">Edit User Form</span>-->
                                    </td>
                                            <?php }else if($r_flag == '1'){ ?>
                                        <td class="tooltip">

                                            <a href="edit_rejection.php?id=<?php echo $rowc['form_user_data_id']; ?>&optional=<?php echo $option; ?>" class="btn btn-primary" style="background-color:#1e73be;"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                            <!--<span class="tooltiptext">Edit User Form</span>-->
                                        </td>
                                <?php }
                             ?>
                            <td><?php echo $rowc["formname"]; ?></td>
                            <td><?php echo $rowc2["part_number"] .'-'. $rowc2["part_name"]; ?></td>
                            <td><?php echo $rowc4["part_family_name"]; ?></td>
                            <td><?php echo $rflag; ?></td>
                            <td><?php echo dateReadFormat($rowc["created_at"]); ?></td>

                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                </form>
            </div>

            <?php
        }
        ?>

    </div>
</div>
<!-- Dashboard content -->
<!-- /dashboard content -->

<script>
    function checkAvailability() {
        $("#loaderIcon").show();
        jQuery.ajax({
            url: "check_availability.php",
            data:'username='+$("#username").val(),
            type: "POST",
            success:function(data){
                $("#user-availability-status").html(data);
                $("#loaderIcon").hide();
            },
            error:function (){}
        });
    }
</script>

<script> $(document).on('click', '#delete', function () {
        var element = $(this);
        var del_id = element.attr("data-id");
        var info = 'id=' + del_id;
        $.ajax({type: "POST", url: "ajax_job_title_delete.php", data: info, success: function (data) { }});
        $(this).parents("tr").animate({backgroundColor: "#003"}, "slow").animate({opacity: "hide"}, "slow");
    });</script>
<script>
    jQuery(document).ready(function ($) {
        $(document).on('click', '#edit', function () {
            var element = $(this);
            var edit_id = element.attr("data-id");
            var name = $(this).data("name");
            $("#edit_name").val(name);
            $("#edit_id").val(edit_id);
            //alert(role);
        });
    });
</script>
<script>
    $(function () {
        $('input:radio').change(function () {
            var abc = $(this).val()
            //alert(abc)
            if (abc == "button1")
            {
                $('#date_from').prop('disabled', false);
                $('#date_to').prop('disabled', false);
                $('#timezone').prop('disabled', true);
            }
        });
    });
</script>
</div>
<!-- /content area -->


<script>

    $('#station').on('change', function (e) {
        $("#user_form").submit();
    });
    $('#part_family').on('change', function (e) {
        $("#user_form").submit();
    });
</script>
<script>
    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $(document).on("click","#submit_btn",function() {

        var station = $("#station").val();
        var part_family = $("#part_family").val();
        var part_number = $("#part_number").val();
        var form_type = $("#form_type").val();
        $("#user_form").submit();
        // var flag= 0;
        // if(station == null){
        //     $("#error1").show();
        //     var flag= 1;
        // }
        // if(part_family == null){
        //     $("#error2").show();
        //     var flag= 1;
        // }
        // if(part_number == null){
        //     $("#error3").show();
        //     var flag= 1;
        // }
        // if(form_type == null){
        //     $("#error4").show();
        //     var flag= 1;
        // }
        // if (flag == 1) {
        //     return false;
        // }

    });

</script>

<!-- <script>
	function clearForm()
{
document.getElementById("user_form").reset();

}
	</script> -->
<script type="text/javascript">
    $(function () {
        $("#btn").bind("click", function () {
            $("#station")[0].selectedIndex = 0;
            $("#part_family")[0].selectedIndex = 0;
            $("#part_number")[0].selectedIndex = 0;
            $("#form_type")[0].selectedIndex = 0;
        });
    });
</script>
<script>
    $(function(){
        var dtToday = new Date();

        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if(month < 10)
            month = '0' + month.toString();
        if(day < 10)
            day = '0' + day.toString();

        var maxDate = year + '-' + month + '-' + day;

        $('#date_to').attr('max', maxDate);
        $('#date_from').attr('max', maxDate);
    });
</script>
<?php include ('../footer.php') ?>
</body>
</html>

