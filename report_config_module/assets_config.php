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
    $text = $assets_id;

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


    $sql2 = "INSERT INTO `station_assests`(`asset_id`, `line_id`, `asset_name`, `qrcode`, `created_date`, `created_time`, `created_by`,`notes`,`is_deleted`) VALUES ('$assets_id','$station','$asset_name','$data','$chicagodate','$chicagotime','$created_by','','1')";
    $result2 = mysqli_query($db, $sql2);

    $sql1 = "SELECT slno as a_id FROM  station_assests where line_id = '$station' ORDER BY `slno` DESC LIMIT 1";
    $result1 = mysqli_query($db, $sql1);
    $rowc04 = mysqli_fetch_array($result1);
    $a_trace_id = $rowc04["a_id"];
    $ts = $_SESSION['assets_timestamp_id'];
    $folderPath =  "../assets/images/assets_images/".$ts;
    $newfolder = "../assets/images/assets_images/".$a_trace_id;
    if ($result1) {
        rename( $folderPath, $newfolder) ;
        $sql = "update `station_assets_images` SET station_asset_id = '$a_trace_id' where station_asset_id = '$ts'";
        $result1 = mysqli_query($db, $sql);
        $_SESSION['timestamp_id'] = "";
        $_SESSION['message_stauts_class'] = 'alert-success';
        $_SESSION['import_status_message'] = 'Assets Created Sucessfully.';
    } else {
        $_SESSION['message_stauts_class'] = 'alert-danger';
        $_SESSION['import_status_message'] = 'Please retry';

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
                    echo '<br/><div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
                }
                ?>
                <?php
                if (!empty($_SESSION['import_status_message'])) {
                    echo '<br/><div class="alert ' . $_SESSION['message_stauts_class'] . '">' . $_SESSION['import_status_message'] . '</div>';
                    $_SESSION['message_stauts_class'] = '';
                    $_SESSION['import_status_message'] = '';
                }
                ?>
                <h5 class="panel-title">Station Assets Config</h5><br/>
                <div class="row">
                    <div class="col-md-12">
                        <form action="" id="asset_create" enctype="multipart/form-data"  class="form-horizontal" method="post">
                            <?php $id = $_GET['id']; ?>
                            <div class="row">
                                <div class="col-md-4 mob_user_rating">
                                    <div class="form-group">
                                        <label class="col-lg-3 mob_user_rating control-label">Station* : </label>
                                        <div class="col-lg-9 mob_user_rating">
                                        <select name="station" id="station" class="select form-control" data-style="bg-slate" required>
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
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mob_user_rating">
                                    <div class="form-group">
                                        <label class="col-lg-3 mob_user_rating control-label">Asset Name : </label>
                                        <div class="col-lg-9 mob_user_rating">
                                        <input type="text" name="asset_name" id="asset_name" class="form-control" placeholder="Enter Asset Name" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mob_user_rating">
                                    <div class="form-group">
                                        <label class="col-lg-3 mob_user_rating control-label">Image : </label>
                                        <div class="col-lg-9 mob_user_rating">
                                        <input type="file" name="image[]" id="image-input" class="form-control" multiple>
                                        <div class="container"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <br/>
                            <div class="panel-footer p_footer">
                                <button type="submit" class="btn btn-primary" style="background-color:#1e73be;">Create</button>
                            </div>
                        </form>
                        <script>
                            $("#image-input").on("change", function () {
                                var fd = new FormData();
                                var files = $('#image-input')[0].files[0];
                                fd.append('file', files);
                                //  fd.append('a', counter++);
                                fd.append('request', 1);

                                // AJAX request
                                $.ajax({
                                    url: 'create_delete_asset_image.php',
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
                                console.log(imgElement_src);
                                var succ = false;
                                // AJAX request
                                $.ajax({
                                    url: 'create_delete_asset_image.php',
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
                        </script>
                    </div>
                </div>

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
                    <!--<th>Image</th>-->
                    <th>QR Code</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $query4  = mysqli_query($db, "SELECT * FROM `station_assests` where is_deleted != 0");
                while ($rowc08 = mysqli_fetch_array($query4)) {
                    $slno = $rowc08["slno"];
                    $asset_id = $rowc08["asset_id"];
                    $line_id = $rowc08["line_id"];
                    $asset_name = $rowc08["asset_name"];
                    $created_date = $rowc08["created_date"];
                    $qrcode = $rowc08["qrcode"];

                    $qur1 = mysqli_query($db, "SELECT line_name  FROM `cam_line` where line_id = '$line_id'");
                    $rowc1 = mysqli_fetch_array($qur1);
                    $line_name = $rowc1['line_name'];
                    ?>

                    <tr>
                        <td><?php echo ++$counter;; ?></td>
                        <td><?php echo $asset_name; ?></td>
                        <td><?php echo $line_name; ?></td>
                        <td><?php echo dateReadFormat($created_date); ?></td>
                        <!--<td>
                            <?php
/*                            $query2 = sprintf("SELECT * FROM station_assets_images where station_asset_id = '$slno'");
                            $qurimage = mysqli_query($db, $query2);
                            $i =0 ;
                            while ($rowcimage = mysqli_fetch_array($qurimage)) {
                                $station_asset_image = $rowcimage['station_asset_image'];
                                $mime_type = "image/gif";
                                $file_content = file_get_contents("$station_asset_image");
                                */?>
                                <?php /*echo '<img src="data:image/gif;base64,' . $station_asset_image . '" style="height:50px;width:50px;" />'; */?>
                                <?php
/*                                $i++;}
                            */?>
                        </td>-->
                        <td><?php echo '<img src="data:image/gif;base64,' . $qrcode . '" style="height:50px;width:50px;" />'; ?>
                            <a class="btn btn-primary btn-xs" style="background-color:#1e73be;" href= data:image/png;base64,<?php echo $qrcode ?> download><i class="fa fa-download"></i></a>
                        </td>
                        <td>
                            <a href="edit_assets_config.php?id=<?php echo $asset_id ?>" class="btn btn-primary btn-xs" style="background-color:#1e73be;"><i class="fa fa-edit"></i></a>
                            <a href="del_assets.php?id=<?php echo $asset_id ?>"  class="btn btn-danger btn-xs remove_btn"><i class="glyphicon">-</i></a>
                        </td>
                    </tr>
                <?php }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include ('../footer.php') ?>
</body>
</html>

