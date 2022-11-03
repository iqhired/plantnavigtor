<?php include("../config.php");
include('./../assets/lib/phpqrcode/qrlib.php');
$chicagodate = date("Y-m-d");
$chicagotime = date("H:i:s");
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
    $asset_name = $_POST['asset_name'];
    $assets_id = uniqid() . '~' . $station . '~' . $asset_name;

    //store the qr code to directory and database
    $text = "sample";

    // $path variable store the location where to
    // store image and $file creates directory name
    // of the QR code file by using 'uniqid'
    // uniqid creates unique id based on microtime
    $path = '../assets/images/qrCode/';
    $file = $path.uniqid() . '~' . $station . '~' . $asset_name.".png";

    // $ecc stores error correction capability('L')
    $ecc = 'L';
    $pixel_Size = 10;
    $frame_Size = 10;

    // Generates QR Code and Stores it in directory given
    QRcode::png($text, $file, $ecc, $pixel_Size, $frame_Size);

    $img = file_get_contents($file);

// Encode the image string data into base64
    $data = base64_encode($img);

    //upload the image
    $data1 = file_get_contents($_FILES['image']['tmp_name']);
    $data1 = base64_encode($data1);

    $sql2 = "INSERT INTO `station_assests`(`asset_id`, `line_id`, `asset_name`, `image`, `qrcode`, `created_date`, `created_time`, `created_by`, `is_deleted`) VALUES ('$assets_id','$station','$asset_name','$data1','$data','$chicagodate','$chicagotime','$created_by', '1')";
    $result2 = mysqli_query($db, $sql2);
    if ($result2) {
        $message_status_class = 'alert-success';
        $import_status_message = 'Assets create successfully!';
        header("Location:assets_config.php");
    }else {
            $message_status_class = 'alert-danger';
            $import_status_message = 'Error: Please Retry...';
    }
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
                <?php
                if (!empty($import_status_message)) {
                    echo '<br/><div class="alert ' . $message_status_class . '">' . $import_status_message . '</div>';
                }
                ?>
                <?php
                if (!empty($_SESSION['import_status_message'])) {
                    echo '<br/><div class="alert ' . $_SESSION['message_status_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
                    $_SESSION['message_status_class'] = '';
                    $_SESSION['import_status_message'] = '';
                }
                ?>
                <h5 class="panel-title">Station Assets Config</h5><br/>
                    <div class="row">
                        <div class="col-md-12">
                            <form action="" id="asset_create" enctype="multipart/form-data"  class="form-horizontal" method="post">
                                <?php $id = $_GET['id']; ?>
                                <div class="row">
                                    <label class="col-sm-2 control-label">Station : </label>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="station" id="station" class="select form-control" data-style="bg-slate">
                                                <option value="" selected disabled>--- Select Station ---</option>
                                                <?php
                                                    $st_dashboard = $_POST['station'];
                                                    $station22 = $st_dashboard;
                                                    $sql1 = "SELECT * FROM `cam_line`  where enabled = '1' and is_deleted != 1 ORDER BY `line_name` ASC";
                                                    $result1 = $mysqli->query($sql1);
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
                                    <label class="col-sm-2 control-label" style="margin-left: 10px;">Asset Name : </label>
                                    <div class="col-md-3">
                                        <input type="text" name="asset_name" id="asset_name" class="form-control" placeholder="Enter Asset Name" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 control-label">Image : </label>
                                    <div class="col-md-4">
                                        <input type="file" name="image" id="image" multiple="multiple"/>
                                    </div>
                                </div>
                    </div>
            </div>
                <div class="panel-footer p_footer">
                    <button type="submit" class="btn btn-primary" style="background-color:#1e73be;">Create</button>
                </div>

                </form>
        </div>

    </div>
        <div class="panel panel-flat" >
            <table class="table datatable-basic">
                <thead>
                <tr>
                    <th>Slno</th>
                    <th>Asset Name</th>
                    <th>Station</th>
                    <th>Created Date</th>
                    <th>Image</th>
                    <th>QR Code</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $query4  = mysqli_query($db, "SELECT * FROM `station_assests` where is_deleted != 0");
                while ($rowc08 = mysqli_fetch_array($query4)) {
                    //$rowc4 = mysqli_fetch_assoc($query4);
                    $asset_id = $rowc08["asset_id"];
                    $line_id = $rowc08["line_id"];
                    $asset_name = $rowc08["asset_name"];
                    $created_date = $rowc08["created_date"];
                    $qrcode = $rowc08["qrcode"];
                    $image = $rowc08["image"];

                    $mime_type = "image/gif";
                    $file_content = file_get_contents("$image");

                    $qur1 = mysqli_query($db, "SELECT line_name  FROM `cam_line` where line_id = '$line_id'");
                    $rowc1 = mysqli_fetch_array($qur1);
                    $line_name = $rowc1['line_name'];
                    ?>
                    <tr>
                        <td><?php echo ++$counter;; ?></td>
                        <td><?php echo $asset_name; ?></td>
                        <td><?php echo $line_name; ?></td>
                        <td><?php echo $created_date; ?></td>
                        <td><?php echo '<img src="data:image/gif;base64,' . $image . '" style="height:50px;width:50px;" />'; ?></td>
                        <td><?php echo '<img src="data:image/gif;base64,' . $qrcode . '" style="height:50px;width:50px;" />'; ?></td>
                       <!-- <td>
                            <button type="button" name="remove_btn"
                                    class="btn btn-danger btn-xs remove_btn"
                                    id="btn_id<?php /*echo $asset_id; */?>"
                                    data-id="<?php /*echo $asset_id; */?>">-
                            </button>
                        </td>-->
                        <td>
                            <input type="hidden" name="asset_id" id="asset_id" value="<?php echo $asset_id; ?>">
                            <a href="edit_assets_config.php?id=<?php echo $rowc08["asset_id"]; ?>&optional=<?php echo $asset_id; ?>" class="btn btn-primary" style="background-color:#1e73be;"><i class="fa fa-edit" aria-hidden="true"></i></a>
                        </td>
                       <td>
                           <ul class="icons-list">
                               <li class="text-primary-600"><button type="button" data-popup="tooltip" title="Edit" id="edit1" data-id1="<?php echo $rowc['tm_equipment_id']; ?>" data-name1="<?php echo $rowc['tm_equipment_name']; ?>" data-toggle="modal"  data-target="#edit_modal_theme_primary1"><i class="icon-pencil7"></i></button>
                               </li>&nbsp; <li class="text-danger-600"><button type="button" id="delete" data-name="equipment" data-id="<?php echo $asset_id; ?>"><i class="icon-trash"></i></button></li>
                           </ul>
                       </td>
                    </tr>
                <?php }
                 ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- /page container -->
<script> $(document).on('click', '#delete', function () {
        var element = $(this);
        var seq_id = element.attr("data-id");

        $.ajax({type: "POST",
            url: "del_assets.php",
            data:{
                info:seq_id,
            },
            success: function (data) {
                //alert(data);

            }});
        $(this).parents("tr").animate({backgroundColor: "#003"}, "slow").animate({opacity: "hide"}, "slow");

    });</script>
<!--<script>
    $(document).on("click", ".remove_btn", function () {
        var row_id = $(this).attr("data-id");
        var info = 'seq_id=' + row_id;
        $.ajax({
            type: "POST", url: "del_assets.php", data: info, success: function (data) {
            }
        });
        window.location.reload();
    });
</script>-->
<script>
    $(document).on("click", ".edi_btn", function () {
        var row_id1 = $(this).attr("data-id");
        var info = 'seq_id1=' + row_id1;
        $.ajax({
            type: "POST", url: "edit_assets_config.php", data: info, success: function (data) {
            }
        });
        window.location.reload();
    });
</script>
<script>
    window.onload = function() {
        history.replaceState("", "", "<?php echo $scriptName; ?>report_config_module/assets_config.php");
    }
</script>
<?php include ('../footer.php') ?>
</body>
</html>

