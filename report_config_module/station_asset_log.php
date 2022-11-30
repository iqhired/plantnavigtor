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
$dfrom =   date('Y-m-d',strtotime("-1 days"));
$dateto = $curdate;
$datefrom = $dfrom;
$temp = "";

$_SESSION['station'] = "";
$_SESSION['date_from'] = "";
$_SESSION['date_to'] = "";


if (count($_POST) > 0) {
    $_SESSION['station'] = $_POST['station'];

    $_SESSION['date_from'] = $_POST['date_from'];
    $_SESSION['date_to'] = $_POST['date_to'];

    $station = $_POST['station'];
    $dateto = $_POST['date_to'];
    $datefrom = $_POST['date_from'];
}

$qurtemp = mysqli_query($db, "SELECT * FROM  cam_line where line_id = '$station' ");
while ($rowctemp = mysqli_fetch_array($qurtemp)) {
    $station1 = $rowctemp["line_name"];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?> | Asset Log</title>
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
        .col-md-6 {
            width: 32%;
        }
        .col-lg-4 {
            width: 60.333333%;
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
            history.replaceState("", "", "<?php echo $scriptName; ?>report_config_module/station_asset_log.php");
        }
    </script>

</head>

<!-- Main navbar -->
<?php
$cust_cam_page_header = "Station Asset Log";
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
            <form action="" id="10x_form" class="form-horizontal" method="post">
                <div class="panel-heading">
                    <!--							<h5 class="panel-title">Stations</h5>-->
                    <!--							<hr/>-->

                    <div class="row">
                        <div class="col-md-6 mobile">
                            <label class="col-lg-2 control-label">Station :</label>
                            <div class="col-lg-4">
                                <select name="station" id="station" class="select"
                                        style="float: left;width: initial;">
                                    <option value="" selected disabled>--- Select Station ---</option>
                                    <?php
                                    $st_dashboard = $_POST['station'];
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
                                    ?>

                                </select>
                            </div>

                        </div>
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
                    <br>
                    <div class="row">


                    </div>
                    <br/>
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

        </div>
    </div>
</div>
<div class="panel panel-flat">
    <table class="table datatable-basic">
        <thead>
        <tr>
            <th>Action</th>
            <th>Station</th>
            <th>Asset name</th>
            <th>Time</th>
        </tr>
        </thead>
        <tbody>
        <?php


        $q = ("SELECT xx.asset_name,xx.created_date,xx.submit_id  FROM  submit_assets as xx inner join cam_line as cl on xx.line_id = cl.line_id where DATE_FORMAT(xx.created_date,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(xx.created_date,'%Y-%m-%d') <= '$dateto' and cl.line_id='$station'");
        $qur = mysqli_query($db, $q);
        while ($rowc = mysqli_fetch_array($qur)) {
            ?>
            <tr>
                <?php
                $un = $rowc['line_no'];
                $qur04 = mysqli_query($db, "SELECT line_name FROM  cam_line where line_id = '$station' ");
                while ($rowc04 = mysqli_fetch_array($qur04)) {
                    $lnn = $rowc04["line_name"];
                }
                ?>
                <td>

                    <a href="<?php echo $siteURL; ?>report_config_module/view_assets_config.php?id=<?php echo $rowc['submit_id'];?>" class="btn btn-primary legitRipple" style="background-color:#1e73be;" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
                </td>
                <td><?php echo $lnn; ?></td>
                <td><?php echo $rowc['asset_name']; ?></td>
                <td><?php echo  dateReadFormat($rowc['created_date']); ?></td>

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
        $("#10x_form").submit();
    });

    $('#part_family').on('change', function (e) {
        $("#10x_form").submit();
    });
    $('#part_number').on('change', function (e) {
        $("#10x_form").submit();
    });


</script>

<!-- /dashboard content -->

<?php include('../footer.php') ?>
</body>
</html>
