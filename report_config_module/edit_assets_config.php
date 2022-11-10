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
$asset_ide = $_GET['asset_id'];

if(empty($_SESSION['$asset_id'])){
    $_SESSION['timestamp_id'] = time();
}
$id = $_GET['id'];
if(isset($_POST['submit'])){
    $notes = $_POST['notes'];
    $sql = "update `station_assests` set notes = '$notes' where asset_id = '$id'";
    $result = mysqli_query($db, $sql);

    $sql1 = "SELECT slno as a_id FROM  station_assests where asset_id = '$id' ORDER BY `slno` DESC LIMIT 1";
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
        $_SESSION['import_status_message'] = 'Assets Updated Sucessfully.';
        header('Location:assets_config.php');
    } else {
        $_SESSION['message_stauts_class'] = 'alert-danger';
        $_SESSION['import_status_message'] = 'Please retry';
        header('Location:edit_assets_config.php');

    }

}
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
    <script type="text/javascript" src="instascan.min.js"></script>
    <!--scan the qrcode -->
    <script>
        var loadFile = function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        };
    </script>
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
        #results { padding:20px; border:1px solid; background:#ccc; }
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
                              class="form-horizontal" method="post">
                            <?php
                            $querymain = sprintf("SELECT * FROM `station_assests` where asset_id = '$id' ");
                            $qurmain = mysqli_query($db, $querymain);
                            while ($rowcmain = mysqli_fetch_array($qurmain)) {
                            $slno = $rowcmain['slno'];
                            $asset_name = $rowcmain['asset_name'];
                            $line_id = $rowcmain['line_id'];
                            $created_date = $rowcmain['created_date'];
                            $created_time = $rowcmain['created_time'];
                            $created_by = $rowcmain['created_by'];
                            $qrcode = $rowcmain['qrcode'];
                            ?>
                                <div class="row">
                                    <label class="col-lg-2 control-label">Asset Name : </label>
                                    <div class="col-md-6">
                                        <input type="text" name="asset_name" id="asset_name" class="form-control"
                                               value="<?php echo $asset_name; ?>"
                                               disabled></div>
                                </div>
                                <br/>
                                <div class="row">
                                    <label class="col-lg-2 control-label">Station Name : </label>
                                    <div class="col-md-6">
                                        <?php
                                        $qurtemp = mysqli_query($db, "SELECT * FROM cam_line where line_id = '$line_id' ");
                                        $rowctemp = mysqli_fetch_array($qurtemp);
                                        $line_name = $rowctemp["line_name"];
                                        ?>
                                        <input type="text" name="station" id="station" class="form-control"
                                               value="<?php echo $line_name; ?>"
                                               disabled></div>
                                </div>
                                <br/>
                                <div class="row">
                                    <label class="col-lg-2 control-label">Created Date : </label>
                                    <div class="col-md-6">
                                        <input type="text" name="c_date" id="c_date" class="form-control"
                                               value="<?php echo $created_date .' - '. $created_time; ?>"
                                               disabled></div>
                                </div>
                                <br/>
                                <div class="row">
                                    <label class="col-lg-2 control-label">Created By : </label>
                                    <div class="col-md-6">
                                        <?php
                                        $qurtemp1 = mysqli_query($db, "SELECT * FROM cam_users where users_id = '$created_by' ");
                                        $rowctemp1 = mysqli_fetch_array($qurtemp1);
                                        $user_name = $rowctemp1["firstname"] .' - '. $rowctemp1["lastname"];
                                        ?>
                                        <input type="text" name="c_by" id="c_by" class="form-control"
                                               value="<?php echo $user_name; ?>"
                                               disabled></div>
                                </div>
                                <br/>
                                <div class="row">
                                    <label class="col-lg-2 control-label">QR Code : </label>
                                    <div class="col-md-6">
                                        <?php echo '<img src="data:image/gif;base64,' . $qrcode . '" style="height:150px;width:150px;" />'; ?>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <label class="col-lg-2 control-label">Previous Image : </label>
                                    <div class="col-md-6">
                                        <?php
                                        $query1 = sprintf("SELECT * FROM station_assets_images where station_asset_id = '$slno'");
                                        $qurimage = mysqli_query($db, $query1);
                                        $i =0 ;
                                        while ($rowcimage1 = mysqli_fetch_array($qurimage)) {
                                            $station_asset_id = $rowcimage1['station_asset_id'];
                                            $station_asset_image = $rowcimage1['station_asset_image'];
                                            $mime_type = "image/gif";
                                            $file_content = file_get_contents("$station_asset_image");
                                            $d_tag = "delete_image_" . $i;
                                            $r_tag = "remove_image_" . $i;
                                            ?>

                                            <div class="col-lg-3 col-sm-6">
                                                <div class="thumbnail">
                                                    <div class="thumb">
                                                        <?php echo '<img src="data:image/gif;base64,' . $station_asset_image . '" style="height:50px;width:150px;border: 1px solid #555;" alt=""/>'; ?>
                                                        <input type="hidden"  id="<?php echo $d_tag; ?>" name="<?php echo $d_tag; ?>" class="<?php echo $d_tag; ?>>" value="<?php echo $rowcimage1['station_asset_id']; ?>">
                                                        <span class="remove remove_image" id="<?php echo $r_tag; ?>">Remove Image </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $i++;}
                                        ?>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <label class="col-lg-2 control-label">Image : </label>
                                    <div class="col-md-6">
                                        <input type="file" name="image[]" id="update-input" class="form-control" multiple>
                                        <div class="container"></div>
                                    </div>

                                </div>
                                <br/>
                            <div class="row">
                                <label class="col-lg-2 control-label">Notes : </label>
                                <div class="col-md-6">
                                    <textarea id="notes"   name="notes"   rows="4"    placeholder="Enter Notes..." class="form-control"></textarea>
                                </div>
                            </div>


                            <?php } ?>
                    </div>
                </div>
            </div>


            <div class="panel-footer p_footer">

                <button type="submit" name="submit" id="submit" class="btn btn-primary submit_btn"
                        style="background-color:#1e73be;">Update
                </button>

            </div>
                        </form>
            </div>
        </div>

    </div>
<script>
    $("#update-input").on("change", function () {
        var fd = new FormData();
        var files = $('#update-input')[0].files[0];
        fd.append('file', files);

        fd.append('request', 1);

        // AJAX request
        $.ajax({
            url: 'edit_delete_asset_image.php',
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
            url: 'edit_delete_asset_image.php',
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
<script>
    $(document).on('click', '.remove_image', function () {
        var del_id = this.id.split("_")[2];
        var x_img_id = this.parentElement.childNodes[3].value;
        var info =  document.getElementById("delete_image"+del_id);
        var info =  "id="+del_id+"&station_asset_id="+ x_img_id;
        $.ajax({
            type: "POST",
            url: "delete_create_asset_image.php",
            data: info,
            success: function (data) {
            }
        });
        location.reload(true);
    });
</script>
<script>
    $(document).ready(function () {
        $('.select').select2();
    });
</script>
    <?php include ('../footer.php') ?>
</body>
</html>

