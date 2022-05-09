<?php include("../config.php");
$curdate = date('Y-m-d');
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
$button_event = "button3";
$curdate = date('Y-m-d');
$dateto = $curdate;
$datefrom = $curdate;
$temp = "";

$_SESSION['station'] = "";
$_SESSION['date_from'] = "";
$_SESSION['date_to'] = "";
$_SESSION['timezone'] = "";
$_SESSION['part_family'] = "";
$_SESSION['part_number'] = "";
$_SESSION['material_type'] = "";

if (count($_POST) > 0) {
    $_SESSION['station'] = $_POST['station'];
    $_SESSION['material_type'] = $_POST['part_family'];
    $_SESSION['material_type'] = $_POST['part_number'];
    $_SESSION['material_type'] = $_POST['material_type'];
    $_SESSION['date_from'] = $_POST['date_from'];
    $_SESSION['date_to'] = $_POST['date_to'];
    $_SESSION['timezone'] = $_POST['timezone'];

    $station = $_POST['station'];
    $pf = $_POST['part_family'];
    $pn = $_POST['part_number'];
    $mt = $_POST['material_type'];
    $dateto = $_POST['date_to'];
    $datefrom = $_POST['date_from'];
    $timezone = $_POST['timezone'];
}

$qurtemp = mysqli_query($db, "SELECT * FROM  cam_line where line_id = '$station' ");
while ($rowctemp = mysqli_fetch_array($qurtemp)) {
    $station1 = $rowctemp["line_name"];
}


if(empty($dateto)){
    $curdate = date('Y-m-d');
    $dateto = $curdate;
}

if(empty($datefrom)){
    $yesdate = date('Y-m-d',strtotime("-1 days"));
    $datefrom = $yesdate;
}

$wc = '';

if(isset($station)){
    $wc = $wc . " and sg_station_event.line_id = '$station'";
}
if(isset($pf)){
    $_SESSION['pf'] = $pf;
    $wc = $wc . " and sg_station_event.part_family_id = '$pf'";
}
if(isset($pn)){
    $_SESSION['pn'] = $pn;
    $wc = $wc . " and sg_station_event.part_number_id = '$pn'";
}
if(isset($mt)){
    $_SESSION['pn'] = $pn;
    $wc = $wc . " and sg_station_event.part_number_id = '$pn'";
}

/* If Data Range is selected */
if(isset($datefrom)){
    $wc = $wc . " and DATE_FORMAT(`created_at`,'%Y-%m-%d') >= '$datefrom' ";
}
if(isset($dateto)){
    $wc = $wc . " and DATE_FORMAT(`created_at`,'%Y-%m-%d') <= '$dateto' ";
}

$wc = $wc . " and DATE_FORMAT(`created_at`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`created_at`,'%Y-%m-%d') <= '$dateto' ";


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?> | Material Tracability Log</title>
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
            .col-md-3 {
                width: 30%;
                float: left;
            }
            .col-md-2 {
                width: 20%;
                float: left;
            }
            .col-lg-8 {
                float: right;
                width: 58%;
            }
            label.col-lg-3.control-label {
                width: 42%;
            }
            .col-md-6.date {
                width: 100%;
                float: left;
            }
            .col-md-2 {
                width: 30%!important;
                float: left;
            }
        }
    </style>
    <script>
        window.onload = function () {
            history.replaceState("", "", "<?php echo $scriptName; ?>log_module/material_tracability_log.php");
        }
    </script>

</head>

<!-- Main navbar -->
<?php
$cust_cam_page_header = "Material Tracability Log";
include("../header_folder.php");

include("../admin_menu.php");
include("../heading_banner.php");
?>
<body class="alt-menu sidebar-noneoverflow">
<!-- /main navbar -->
<!-- Page container -->
<div class="page-container">

    <!-- Content area -->
    <div class="content">
        <!-- Main charts -->
        <!-- Basic datatable -->
        <div class="panel panel-flat">
            <div class="panel-heading">
                <!--							<h5 class="panel-title">Stations</h5>-->
                <!--							<hr/>-->
                <form action="" id="material_form" class="form-horizontal" method="post">
                    <div class="row">
                        <div class="col-md-6 mobile">


                            <label class="col-lg-2 control-label">Station :</label>

                            <div class="col-lg-8">
                                <select name="station" id="station" class="select"
                                        style="float: left;width: initial;">
                                    <option value="" selected disabled>--- Select Station ---</option>
                                    <?php
                                    $st_dashboard = $_POST['station'];
                                    $sql1 = "SELECT * FROM `cam_line` where enabled = '1' ORDER BY `line_name` ASC ";
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
                                    ?>

                                </select>
                            </div>

                        </div>
                        <div class="col-md-6 mobile">

                            <label class="col-lg-3 control-label" >Part Family *  :</label>

                            <div class="col-lg-8">
                                <select name="part_family" id="part_family" class="select" data-style="bg-slate" >
                                    <option value="" selected disabled>--- Select Part Family ---</option>
                                    <?php
                                    $st_dashboard = $_POST['part_family'];
                                    $station = $_POST['station'];
                                    $ss = (isset($station)?' and station = ' . $station : '');
                                    $sql1 = "SELECT * FROM `pm_part_family` where is_deleted = 0" . $ss;
                                    $result1 = $mysqli->query($sql1);
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
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6 mobile">


                            <label class="col-lg-3 control-label">Part Number *  :</label>

                            <div class="col-lg-8">
                                <select name="part_number" id="part_number" class="select" data-style="bg-slate" >
                                    <option value="" selected disabled>--- Select Part Number ---</option>
                                    <?php
                                    $st_dashboard = $_POST['part_number'];
                                    $part_family = $_POST['part_family'];
                                    $sql1 = "SELECT * FROM `pm_part_number` where part_family = '$part_family' and is_deleted = 0 ";
                                    $result1 = $mysqli->query($sql1);
                                    while ($row1 = $result1->fetch_assoc()) {
                                        if($st_dashboard == $row1['pm_part_number_id'])
                                        {
                                            $entry = 'selected';
                                        }
                                        else
                                        {
                                            $entry = '';

                                        }
                                        echo "<option value='" . $row1['pm_part_number_id'] . "' $entry >" . $row1['part_number'] ." - ".$row1['part_name'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mobile">


                            <label class="col-lg-3 control-label">Material Type *  :</label>

                            <div class="col-lg-8">
                                <select name="material_type" id="material_type" class="select" data-style="bg-slate" >
                                    <option value="" selected disabled>--- Select Material Type ---</option>
                                    <?php
                                    $material = $_POST['material_type'];
                                    $p_number = $_POST['part_number'];
                                    $sql1 = "SELECT * FROM `material_tracability` where part_no = '$p_number' ";
                                    $result1 = $mysqli->query($sql1);
                                    while ($row1 = $result1->fetch_assoc()) {
                                        if($material == $row1['material_type'])
                                        {
                                            $entry = 'selected';
                                        }
                                        else
                                        {
                                            $entry = '';

                                        }

                                        $sqlnumber = "SELECT * FROM `material_config` where `material_id` = '$material'";
                                        $resultnumber = mysqli_query($db,$sqlnumber);
                                        $rowcnumber = mysqli_fetch_array($resultnumber);
                                        $material_type = $rowcnumber['material_type'];
                                        echo "<option value='" . $row1['material_type'] . "' $entry >" . $row1['material_type'] . "</option>";


                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6 date">

                            <label class="control-label"
                                   style="float: left;padding-top: 10px; font-weight: 500;">&nbsp;&nbsp;&nbsp;&nbsp;Date
                                From : &nbsp;&nbsp;</label>
                            <input type="date" name="date_from" id="date_from" class="form-control"
                                   value="<?php echo $datefrom; ?>" style="float: left;width: initial;"
                                   required>
                        </div>
                        <div class="col-md-6 date">
                            <label class="control-label"
                                   style="float: left;padding-top: 10px; font-weight: 500;">&nbsp;&nbsp;&nbsp;&nbsp;Date
                                To: &nbsp;&nbsp;</label>
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
                                style="background-color:#1e73be;">
                            Submit
                        </button>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-primary" onclick='window.location.reload();'
                                style="background-color:#1e73be;">Reset
                        </button>
                    </div>
                    </form>


                    <div class="col-md-2">
                        <form action="export_material.php" method="post" name="export_excel">
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
                    <th>Part Number</th>
                    <th>Part Family</th>
                    <th>Material Type</th>
                    <th>Created On</th>
                    <th>Total Duration</th>
                </tr>
                </thead>
                <tbody>
                <?php

                /* Default Query */
                $q = "SELECT line_no,pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,mat.created_at as total_time from material_tracability as mat INNER JOIN pm_part_family as pf on mat.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on mat.part_no = pn.pm_part_number_id DATE_FORMAT(`created_at`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`created_on`,'%Y-%m-%d') <= '$dateto' and `line_no` = '$station' DESC";

                /* Execute the Query Built*/
                $qur = mysqli_query($db, $q);
                while ($rowc = mysqli_fetch_array($qur)) {
                    $dateTime = $rowc["created_at"];

                    ?>
                    <tr>
                        <?php
                        $un = $rowc['line_no'];
                        $qur04 = mysqli_query($db, "SELECT line_name FROM  cam_line where line_id = '$un' ");
                        while ($rowc04 = mysqli_fetch_array($qur04)) {
                            $lnn = $rowc04["line_name"];
                        }
                        ?>
                        <td><?php echo $lnn; ?></td>
                        <td><?php echo $rowc['part_no']; ?></td>
                        <td><?php echo $rowc['part_family_id']; ?></td>
                        <td><?php echo $rowc['part_name']; ?></td>
                        <td><?php echo $rowc['material_type']; ?></td>
                        <td><?php echo $rowc['created_at']; ?></td>

                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- /content area -->

</div>
<!-- /main content -->

<!-- /page content -->

<script>
    $('#station').on('change', function (e) {
        $("#material_form").submit();
    });

    $('#part_family').on('change', function (e) {
        $("#material_form").submit();
    });
    $('#part_number').on('change', function (e) {
        $("#material_form").submit();
    });


</script>

<!-- /dashboard content -->

<?php include('../footer.php') ?>
</body>
</html>
