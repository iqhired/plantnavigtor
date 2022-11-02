<?php
include("../config.php");
include ('./../assets/lib/phpqrcode/qrlib.php');
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
$created_by = $_SESSION['id'];
if (count($_POST) > 0) {
    $station = $_POST['station'];
    $part_family = $_POST['part_family'];
    $part_number = $_POST['part_number'];
    $asset_name = $_POST['asset_name'];
    $assets_id = uniqid() . '~' . $station . '~' . $part_family . '~' . $part_number . '~' . $asset_name;
    if (isset($_FILES['image'])) {
        $errors = array();
        $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['image']['name'];
        $file_ext = strtolower(end(explode('.', $file_name)));
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        echo $file_tmp;
        echo "<br>";

        $type = pathinfo($file_tmp, PATHINFO_EXTENSION);
        $data = file_get_contents($file_ext);
        // $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

// Encode the image string data into base64
        $data = base64_encode($file_name);


        if (in_array($file_ext, $allowed_ext) === false) {
            $errors[] = 'Extension not allowed';
        }

        if ($file_size > 2097152) {
            $errors[] = 'File size must be under 2mb';

        }
        if (empty($errors)) {
            $sql2 = "INSERT INTO `station_assests`(`asset_id`, `line_id`, `part_family`, `part_number`, `asset_name`, `image`, `qrcode`, `created_on`, `created_by`) VALUES ('$assets_id','$station','$part_family','$part_number','$asset_name','$data','','$chicagotime','$created_by')";
            $result2 = mysqli_query($db, $sql2);
            if ($result2) {
                $message_stauts_class = 'alert-success';
                $import_status_message = 'Data Updated successfully.';
            }

        } else {
            foreach ($errors as $error) {
                $message_stauts_class = 'alert-danger';
                $import_status_message = 'Error: Please Retry...';
            }
        }
    }
    $text = "sample";

// $path variable store the location where to
// store image and $file creates directory name
// of the QR code file by using 'uniqid'
// uniqid creates unique id based on microtime
    $path = './../assets/images/qrCode/';
    $file = $path.uniqid().".png";

// $ecc stores error correction capability('L')
    $ecc = 'L';
    $pixel_Size = 10;
    $frame_Size = 10;

// Generates QR Code and Stores it in directory given
    QRcode::png($text, $file, $ecc, $pixel_Size, $frame_Size);

// Displaying the stored QR code from directory
    echo "<center><img src='".$file."'></center>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?> |Station Assets Config</title>
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
$cust_cam_page_header = "Station Assets Config";
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
                <h5 class="panel-title">Station Assets Config</h5><br/>
                    <div class="row">
                        <div class="col-md-12">
                            <form action="" id="user_form" enctype="multipart/form-data"  class="form-horizontal" method="post">
                                <?php $id = $_GET['id']; ?>
                                <div class="row">
                                    <label class="col-lg-2 control-label">Station : </label>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select name="station" id="station" class="select form-control" data-style="bg-slate">
                                                <option value="" selected disabled>--- Select Station ---</option>
                                                <?php
                                                    $st_dashboard = $_POST['station'];
                                                    $sql1 = "SELECT * FROM `cam_line`  where enabled = '1' and is_deleted != 1 ORDER BY `line_name` ASC";
                                                    $result1 = $mysqli->query($sql1);
                                                    //                                            $entry = 'selected';
                                                    while ($row1 = $result1->fetch_assoc()) {
                                                        if($st_dashboard == $row1['line_id'])
                                                        {
                                                            $entry = 'selected disabled';
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
                                </div>
                                <div class="row">
                                    <label class="col-lg-2 control-label">Part family : </label>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select name="part_family" id="part_family" class="select form-control"  data-style="bg-slate">
                                                <option value="" selected disabled>--- Select Part Family ---</option>
                                                <?php
                                                $st_dashboard = $_GET['station'];
                                                $sql1 = "SELECT * FROM `pm_part_family`  where is_deleted != 1";
                                                $result1 = $mysqli->query($sql1);
                                                //                                            $entry = 'selected';
                                                while ($row1 = $result1->fetch_assoc()) {
                                                    echo "<option value='" . $row1['pm_part_family_id'] . "'  >" . $row1['part_family_name'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-lg-2 control-label">Part Number : </label>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select name="part_number" id="part_number" class="select form-control" data-style="bg-slate">
                                                <option value="" selected disabled>--- Select Part Number ---</option>
                                                <?php
                                                $sql1 = "SELECT * FROM `pm_part_number` where is_deleted != 1";
                                                $result1 = $mysqli->query($sql1);
                                                while ($row1 = $result1->fetch_assoc()) {
                                                    $station = $row1['station'];
                                                    $row_station ="select line_id,line_name from cam_line where line_id = '$station' and is_deleted != 1";
                                                    $sta_row = mysqli_query($db,$row_station);
                                                    $row = mysqli_fetch_assoc($sta_row);
                                                    $line_name = $row['line_name'];
                                                    echo "<option value='" . $row1['pm_part_number_id'] . "'  >" . $row1['part_number']." - ".$row1['part_name']." - ".$line_name. "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-lg-2 control-label" >Asset Name : </label>
                                    <div class="col-md-6">
                                        <input type="text" name="asset_name" id="asset_name" class="form-control" placeholder="Enter Asset Name" required>
                                    </div>
                                </div><br/>
                                <div class="row">
                                    <label class="col-lg-2 control-label">Image : </label>
                                    <div class="col-md-6">
                                        <input type="file" name="image" id="image" multiple="multiple" required/>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <label class="col-lg-2 control-label">QR Code : </label>
                                    <div class="col-md-6">
                                    </div>
                                </div>
                                <br/>

                        </div>
                    </div>
            </div>
            <div class="panel-footer p_footer">
                <button type="submit" class="btn btn-primary" style="background-color:#1e73be;">Create</button>
            </div>

            </form>
        </div>
        <!-- /main charts -->
        <!-- edit modal -->
        <!-- Dashboard content -->
        <!-- /dashboard content -->

    </div>

</div>
<!-- /page container -->

<script>
    window.onload = function() {
        history.replaceState("", "", "<?php echo $scriptName; ?>report_config_module/assets_config.php");
    }
</script>
<script>
    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
    function group1()
    {
        $("#teams").select2("open");
    }
    function group2()
    {
        $("#users").select2("open");
    }
</script>
<?php include ('../footer.php') ?>
</body>
</html>

