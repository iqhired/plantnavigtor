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
    <title>
        <?php echo $sitename; ?> |SPC Analytics</title>
    <!-- Global stylesheets -->


    <link href="../assets/css/core.css" rel="stylesheet" type="text/css">


    <!-- /global stylesheets -->
    <!-- Core JS files -->
    <!--    <script type="text/javascript" src="../assets/js/libs/jquery-3.6.0.min.js"> </script>-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- Theme JS files -->
    <script type="text/javascript" src="../assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="../assets/js/core/libraries/jquery_ui/interactions.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_bootstrap_select.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_layouts.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>

    <!--Internal  Datetimepicker-slider css -->
    <link href="<?php echo $siteURL; ?>assets/css/form_css/amazeui.datetimepicker.css" rel="stylesheet">
    <link href="<?php echo $siteURL; ?>assets/css/form_css/jquery.simple-dtpicker.css" rel="stylesheet">
    <link href="<?php echo $siteURL; ?>assets/css/form_css/picker.min.css" rel="stylesheet">
    <!--Bootstrap-datepicker css-->
    <link rel="stylesheet" href="<?php echo $siteURL; ?>assets/css/form_css/bootstrap-datepicker.css">
    <!-- Internal Select2 css -->
    <link href="<?php echo $siteURL; ?>assets/css/form_css/select2.min.css" rel="stylesheet">
    <!-- STYLES CSS -->
    <link href="<?php echo $siteURL; ?>assets/css/form_css/style.css" rel="stylesheet">
    <link href="<?php echo $siteURL; ?>assets/css/form_css/style-dark.css" rel="stylesheet">
    <link href="<?php echo $siteURL; ?>assets/css/form_css/style-transparent.css" rel="stylesheet">
    <!---Internal Fancy uploader css-->
    <link href="<?php echo $siteURL; ?>assets/css/form_css/fancy_fileupload.css" rel="stylesheet" />
    <!--Internal  Datepicker js -->
    <script src="<?php echo $siteURL; ?>assets/js/form_js/datepicker.js"></script>
    <!-- Internal Select2.min js -->
    <!--Internal  jquery.maskedinput js -->
    <script src="<?php echo $siteURL; ?>assets/js/form_js/jquery.maskedinput.js"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="<?php echo $siteURL; ?>assets/js/form_js/spectrum.js"></script>
    <!--Internal  jquery-simple-datetimepicker js -->
    <script src="<?php echo $siteURL; ?>assets/js/form_js/datetimepicker.min.js"></script>
    <!-- Ionicons js -->
    <script src="<?php echo $siteURL; ?>assets/js/form_js/jquery.simple-dtpicker.js"></script>
    <!--Internal  pickerjs js -->
    <script src="<?php echo $siteURL; ?>assets/js/form_js/picker.min.js"></script>
    <!--internal color picker js-->
    <script src="<?php echo $siteURL; ?>assets/js/form_js/pickr.es5.min.js"></script>
    <script src="<?php echo $siteURL; ?>assets/js/form_js/colorpicker.js"></script>
    <!--Bootstrap-datepicker js-->
    <script src="<?php echo $siteURL; ?>assets/js/form_js/bootstrap-datepicker.js"></script>
    <script src="<?php echo $siteURL; ?>assets/js/form_js/select2.min.js"></script>
    <!-- Internal form-elements js -->
    <script src="<?php echo $siteURL; ?>assets/js/form_js/form-elements.js"></script>
    <link href="<?php echo $siteURL; ?>assets/js/form_js/demo.css" rel="stylesheet"/>

    <style>
        .navbar {

            padding-top: 0px!important;
        }
        .dropdown .arrow {

            margin-top: -25px!important;
            width: 1.5rem!important;
        }
        #ic .arrow {
            margin-top: -22px!important;
            width: 1.5rem!important;
        }
        .fs-6 {
            font-size: 1rem!important;
        }

        .content_img {
            width: 113px;
            float: left;
            margin-right: 5px;
            border: 1px solid gray;
            border-radius: 3px;
            padding: 5px;
            margin-top: 10px;
        }

        /* Delete */
        .content_img span {
            border: 2px solid red;
            display: inline-block;
            width: 99%;
            text-align: center;
            color: red;
        }
        .remove_btn{
            float: right;
        }
        .contextMenu{ position:absolute;  width:min-content; left: 204px; background:#e5e5e5; z-index:999;}
        .collapse.in {
            display: block!important;
        }
        .file-image-1 .icons li a {
            height: 30px;
            width: 30px;
        }
        .remove {
            display: block;
            background: #444;
            border: 1px solid black;
            color: white;
            text-align: center;
            cursor: pointer;
        }
        .remove:hover {
            background: white;
            color: black;
        }
        input[type="file"] {
            display: block;
        }
        .imageThumb {
            max-height: 100px;
            border: 2px solid;
            padding: 1px;
            cursor: pointer;
        }
        .pip {
            display: inline-block;
            margin: 10px 10px 0 0;
        }

        button.remove {
            margin-left: 15px;
        }
        .row-body {
            display: flex;
            flex-wrap: wrap;
            margin-left: -8.75rem;
            margin-right: 6.25rem;
        }
        @media (min-width: 320px) and (max-width: 480px) {
            .row-body {

                margin-left: 0rem;
                margin-right: 0rem;
            }
        }

        @media (min-width: 481px) and (max-width: 768px) {
            .row-body {

                margin-left: -15rem;
                margin-right: 0rem;
            }
            .col-md-1 {
                flex: 0 0 8.33333%;
                max-width: 10.33333%!important;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .row-body {

                margin-left:-15rem;
                margin-right: 0rem;
            }

        }
        .red-star {
            color: red;
        }
        #sub_app {
            padding: 20px 40px;
            color: red;
            font-size: initial;
        }


    </style>
</head>
<!-- Main navbar -->
<?php
include("../header.php");
include("../admin_menu.php");
?>
<body class="ltr main-body app sidebar-mini">
<div class="main-content app-content">
    <div class="row-body row-sm">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="breadcrumb-header justify-content-between">
                <div class="left-content">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Logs</a></li>
                        <li class="breadcrumb-item active" aria-current="page">SPC Analytics</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <form action="" id="user_form" class="form-horizontal" method="post" autocomplete="off">
    <div class="row-body row-sm">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card  box-shadow-0">
                <div class="card-header">
                    <span class="main-content-title mg-b-0 mg-b-lg-1">SPC Analytics</span>
                </div>
                <div class="card-body pt-0">
                    <div class="pd-30 pd-sm-20">
                        <div class="row row-xs align-items-center mg-b-20">
                            <div class="col-md-2">
                                <label class="form-label mg-b-0">Station * : </label>
                            </div>
                            <div class="col-md-4 mg-t-5 mg-md-t-0">
                                <select  name="station" id="station" class="form-control form-select select2" data-bs-placeholder="Select Country">
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
                            </div>
                            <div class="col-md-2">
                                <label class="form-label mg-b-0">Part Family : </label>
                            </div>
                            <div class="col-md-4 mg-t-5 mg-md-t-0">
                                <select  name="part_family" id="part_family" class="form-control form-select select2" data-bs-placeholder="Select Country">
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
                            </div>
                        </div>
                        <div class="row row-xs align-items-center mg-b-20">
                            <div class="col-md-2">
                                <label class="form-label mg-b-0">Part Number  : </label>
                            </div>
                            <div class="col-md-4 mg-t-5 mg-md-t-0">
                                <select  name="part_number" id="part_number" class="form-control form-select select2" data-bs-placeholder="Select Country">
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
                            </div>
                            <div class="col-md-2">
                                <label class="form-label mg-b-0">Form Type : </label>
                            </div>
                            <div class="col-md-4 mg-t-5 mg-md-t-0">
                                <select  name="form_type" id="form_type" class="form-control form-select select2" data-bs-placeholder="Select Country">
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
                            </div>
                        </div>
                        <div class="row row-xs align-items-center mg-b-20">
                            <div class="col-md-2">
                                <label class="form-label mg-b-0">Date From : &nbsp;</label>
                            </div>
                            <div class="col-md-4 mg-t-5 mg-md-t-0">
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input class="form-control fc-datepicker"  name="date_from" id="date_from" placeholder="MM/DD/YYYY" value="<?php echo $datefrom; ?>" type="text">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label mg-b-0">Date To: &nbsp;&nbsp;</label>
                            </div>
                            <div class="col-md-4 mg-t-5 mg-md-t-0">
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input class="form-control fc-datepicker"  name="date_to" id="date_to" placeholder="MM/DD/YYYY" value="<?php echo $dateto; ?>" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row row-xs align-items-center mg-b-20">
                            <div class="row row-xs">
                                 <button type="submit" class="btn btn-primary pd-x-30 mg-r-5 mg-t-5 submit_btn">Submit</button>
                                <button type="button" class="btn btn-primary pd-x-30 mg-r-5 mg-t-5" onclick='window.location.reload();'>Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
    <?php
    if(count($_POST) > 0)
    {
    ?>
    <div class="row-body row-sm">
            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                <div class="card  box-shadow-0">
                    <div class="card-body pt-0">
                        <div class="pd-30 pd-sm-20">
                            <div class="table-responsive">
                                <table class="table  table-bordered text-nowrap mb-0" id="example2">
                                    <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Form Name</th>
                                        <th>Form Type</th>
                                        <th>Action</th>
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

                                            if ($station != "" && $datefrom != "" && $dateto != "") {
                                                $result = "SELECT `form_create_id`,`name`,`form_type`,`station`,`part_family`,`part_number`,`created_by` FROM `form_create` WHERE DATE_FORMAT(`created_by`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`created_by`,'%Y-%m-%d') <= '$dateto' and station = '$station' " . $q_str . "ORDER BY form_create_id DESC";
                                                $qur = mysqli_query($db, $result);
                                            } else if ($station != "" && $user != "" && $datefrom == "" && $dateto == "") {
                                                $qur = mysqli_query($db, "SELECT `form_create_id`,`name`,`form_type`,`station`,`part_family`,`part_number`,`created_by` FROM `form_create` WHERE station = '$station' ");
                                            } else if ($station != "" && $user == "" && $datefrom != "" && $dateto != "") {
                                                $qur = mysqli_query($db, "SELECT `form_create_id`,`name`,`form_type`,`station`,`part_family`,`part_number`,`created_by` FROM `form_create` WHERE DATE_FORMAT(`created_by`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`created_by`,'%Y-%m-%d') <= '$dateto' and station = '$station' " . $q_str . "ORDER BY form_create_id DESC");
                                            } else if ($station != "" && $user == "" && $datefrom == "" && $dateto == "") {
                                                $qur = mysqli_query($db, "SELECT `form_create_id`,`name`,`form_type`,`station`,`part_family`,`part_number`,`created_by` FROM `form_create` WHERE station = '$station'");
                                            } else if ($station == "" && $user != "" && $datefrom != "" && $dateto != "") {
                                                $qur = mysqli_query($db, "SELECT `form_create_id`,`name`,`form_type`,`station`,`part_family`,`part_number`,`created_by` FROM `form_create` WHERE DATE_FORMAT(`created_by`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`created_by`,'%Y-%m-%d') <= '$dateto' and station = '$station' " . $q_str . "ORDER BY form_create_id DESC");
                                            } else if ($station == "" && $user != "" && $datefrom == "" && $dateto == "") {
                                                $qur = mysqli_query($db, "SELECT `form_create_id`,`name`,`form_type`,`station`,`part_family`,`part_number`,`created_by` FROM `form_create` WHERE station = '$station'");
                                            } else if ($station == "" && $user == "" && $datefrom != "" && $dateto != "") {
                                                $qur = mysqli_query($db, "SELECT `form_create_id`,`name`,`form_type`,`station`,`part_family`,`part_number`,`created_by` FROM `form_create` WHERE DATE_FORMAT(`created_by`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`created_by`,'%Y-%m-%d') <= '$dateto'");
                                            }


                                    while ($rowc = mysqli_fetch_array($qur)) {
                                        $form_create_id = $rowc["form_create_id"];
                                        $form_type = $rowc["form_type"];
                                        $query1  = mysqli_query($db, "SELECT form_create_id,created_at as created_at FROM  form_user_data where form_create_id = '$form_create_id' and DATE_FORMAT(`created_at`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`created_at`,'%Y-%m-%d') <= '$dateto'");
                                        $rowc1 = mysqli_fetch_array($query1);
                                        $form_create_id = $rowc1['form_create_id'];
                                        $query3  = mysqli_query($db, "SELECT form_type_name FROM  form_type where form_type_id  = '$form_type'");
                                        $rowc3 = mysqli_fetch_array($query3);
                                        $form_type_name = $rowc3["form_type_name"];

                                        $query2  = mysqli_query($db, "SELECT optional,form_item_id FROM  form_item where form_create_id  = '$form_create_id'");
                                        $rowc2 = mysqli_fetch_array($query2);
                                        $optional = $rowc2["optional"];
                                        ?>

                                        <tr <?php echo $style; ?>>
                                            <td><?php echo ++$counter; ?></td>
                                            <td><?php echo $rowc["name"]; ?></td>
                                            <td><?php echo $form_type_name; ?></td>

                                            <td>
                                                <a href="form_item_data_view.php?id=<?php echo $rowc['form_create_id']; ?>&station=<?php echo $station; ?>&form_type=<?php echo $form_type; ?>&date_from=<?php echo $datefrom; ?>&date_to=<?php echo $dateto; ?>"
                                                   class="btn btn-primary" style="background-color:#1e73be;" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-forward" viewBox="0 0 16 16">
                                                        <path d="M9.502 5.513a.144.144 0 0 0-.202.134V6.65a.5.5 0 0 1-.5.5H2.5v2.9h6.3a.5.5 0 0 1 .5.5v1.003c0 .108.11.176.202.134l3.984-2.933a.51.51 0 0 1 .042-.028.147.147 0 0 0 0-.252.51.51 0 0 1-.042-.028L9.502 5.513zM8.3 5.647a1.144 1.144 0 0 1 1.767-.96l3.994 2.94a1.147 1.147 0 0 1 0 1.946l-3.994 2.94a1.144 1.144 0 0 1-1.767-.96v-.503H2a.5.5 0 0 1-.5-.5v-3.9a.5.5 0 0 1 .5-.5h6.3v-.503z"/>
                                                    </svg></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
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
    $('#date_to').datepicker({ dateFormat: 'yy-mm-dd' });
    $('#date_from').datepicker({ dateFormat: 'yy-mm-dd' });
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
    });

</script>
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
<script>
    window.onload = function () {
        history.replaceState("", "", "<?php echo $scriptName; ?>form_module/form_graph.php");
    }
</script>
<?php include ('../footer.php') ?>
</body>