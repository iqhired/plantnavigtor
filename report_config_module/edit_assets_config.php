<?php
include("../config.php");
include('./../assets/lib/phpqrcode/qrlib.php');
$chicagotime = date("Y-m-d H:i:s");
$temp = "";
if (!isset($_SESSION['user'])) {
    header('location: ../logout.php');
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

$i = $_SESSION["role_id"];
if ($i != "super" && $i != "admin") {
    header('location: ../dashboard.php');
}

$id = $_SESSION['asset_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?> |Edit Station Assets Config</title>
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="../assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/colors.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/style_main.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
    <!-- Core JS files -->
    <script type="text/javascript" src="../assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="../assets/js/core/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="../assets/js/core/libraries/bootstrap.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->
    <!-- Theme JS files -->
    <script type="text/javascript" src="../assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="../assets/js/core/libraries/jquery_ui/interactions.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/core/app.js"></script>
    <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_select2.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_bootstrap_select.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_layouts.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <style>
        .sidebar-default .navigation li>a{color:#f5f5f5};
        a:hover {
            background-color: #20a9cc;
        }
        .sidebar-default .navigation li>a:focus, .sidebar-default .navigation li>a:hover {
            background-color: #20a9cc;
        }
        .form-control:focus {
            border-color: transparent transparent #1e73be !important;
            -webkit-box-shadow: 0 1px 0 #1e73be;
            box-shadow: 0 1px 0 #1e73be !important;
        }
        .form-control {
            border-color: transparent transparent #1e73be;
            border-radius: 0;
            -webkit-box-shadow: none;
            box-shadow: none;
        }  @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
            .col-sm-2 {
                width: 10.66666667%;
            }
            .col-lg-2 {
                width: 28%!important;
                float: left;
            }
            .col-md-6 {
                width: 60%;
                float: left;
            }
            .col-lg-1 {
                width: 12%;
                float: right;
            }
        }
        input[type="file"] {
            display: block;
        }

        .container {
            margin: 0 auto;
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

        .content_img span:hover {
            cursor: pointer;
        }

    </style>
</head>
<body>
<!-- Main navbar -->
<?php
$cust_cam_page_header = "Edit Station Assets Config";
include("../header_folder.php");
include("../admin_menu.php");
include("../heading_banner.php");
?>
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
                <h5 class="panel-title">Edit Station Assets Config</h5><br/>
                <div class="row">
                    <div class="col-md-12">
                        <form action="" id="asset_update" enctype="multipart/form-data"
                              class="form-horizontal" method="post" autocomplete="off" style="padding-top: 30px;">
                            <?php

                            $querymain = sprintf("SELECT * FROM `station_assests` where asset_id = '$id' ");
                            $qurmain = mysqli_query($db, $querymain);

                            while ($rowcmain = mysqli_fetch_array($qurmain)) {
                            $asset_name = $rowcmain['asset_name'];
                            $qrcode = $rowcmain['qrcode'];
                            ?>
                            <div class="row">
                                <label class="col-sm-2 control-label">Station : </label>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                        $station = $rowcmain['line_id'];
                                        if ($station != '') {
                                            $disabled = 'disabled';
                                        } else {
                                            $disabled = '';
                                        }
                                        ?>

                                        <input type="hidden" name="station" id="station"
                                               value="<?php echo $station; ?>">
                                        <select name="station" id="station"
                                                class="select-border-color form-control" <?php echo $disabled; ?>>
                                            <option value="" selected disabled>--- Select Station ---</option>
                                            <?php
                                            $sql1 = "SELECT * FROM `cam_line` where enabled = '1' ORDER BY `line_name` ASC ";
                                            $result1 = $mysqli->query($sql1);
                                            //                                            $entry = 'selected';
                                            while ($row1 = $result1->fetch_assoc()) {
                                                if ($station == $row1['line_id']) {
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
                                <div class="row">
                                <label class="col-sm-2 control-label" style="margin-left: 10px;">Asset Name : </label>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="asset_name" id="asset_name"
                                               value="<?php echo $asset_name; ?>" disabled/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 control-label">QR Code : </label>
                                <div class="col-md-4">
                                    <div class="form-group">

                                        <input type="text" name="qrcode" id="qrcode"
                                               value="<?php echo '<img src="data:image/gif;base64,' . $qrcode . '" style="height:50px;width:50px;" />'; ?>" disabled/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 control-label">Image : </label>
                                <div class="col-md-4">
                                    <input type="file" name="image" id="image"/>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="panel-footer p_footer">
                    <button type="submit" class="btn btn-primary" style="background-color:#1e73be;">Update</button>
                </div>
                <?php
                } ?>
                </form>
            </div>
        </div>

    </div>
    <!-- /page container -->

    <script>
        window.onload = function() {
            history.replaceState("", "", "<?php echo $scriptName; ?>report_config_module/edit_assets_config.php");
        }
    </script>
    <?php include ('../footer.php') ?>
</body>
</html>

