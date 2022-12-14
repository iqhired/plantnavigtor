<?php
include("../config.php");
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
//if ($i != "super" && $i != "admin") {
//    header('location: ../dashboard.php');
//}
$station_event_id = $_GET['station_event_id'];

if(empty($_SESSION['$station_event_id'])){
    $_SESSION['good_timestamp_id'] = time();
}


$gp_timestamp = time();
$idd = preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo
|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i"
    , $_SERVER["HTTP_USER_AGENT"]);
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $sitename; ?> |view Bad piece</title>
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
        <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/pages/gallery.js"></script>


        <!--scan the qrcode -->

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
                .thumbnail {
                    width: 150px!important;
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


        </style>
    </head>
    <body onload="openScanner()">
    <!-- Main navbar -->
    <?php
    $cust_cam_page_header = "View Bad Piece";
    include("../header_folder.php");
    include("../admin_menu.php");
    include("../heading_banner.php");
    ?>
    <!-- /main navbar -->
    <!-- Page container -->
    <div class="page-container">
        <!-- Page content -->
        <?php
        $station_event_id = $_GET['station_event_id'];
        $bad_pieces_id = $_GET['bad_pieces_id'];
        $query = sprintf("SELECT gbpd.bad_pieces_id as bad_pieces_id , gbpd.good_pieces as good_pieces, gbpd.defect_name as defect_name, gbpd.bad_pieces as bad_pieces ,gbpd.rework as rework FROM good_bad_pieces_details as gbpd where gbpd.station_event_id  = '$station_event_id' AND gbpd.bad_pieces_id = '$bad_pieces_id' order by gbpd.bad_pieces_id DESC");
        $qur = mysqli_query($db, $query);
        while ($result_good = mysqli_fetch_array($qur)) {
            $good_pieces = $result_good['good_pieces'];
            $good_bad_pieces_id = $result_good['good_bad_pieces_id'];
            $bad_pieces_id = $result_good['bad_pieces_id'];
            $defect_name = $result_good['defect_name'];
            $bad_pieces = $result_good['bad_pieces'];

            ?>
            <!-- Content area -->
            <div class="content">
                <!-- Main charts -->
                <!-- Basic datatable -->
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title">View Bad Piece</h5><br/>
                        <div class="row">
                            <div class="col-md-12" id="goodpiece">
                                <form action="" id="view_bad_page" enctype="multipart/form-data"
                                      class="form-horizontal" method="post">
                                    <input type="hidden" name="station_event_id" id="station_event_id" class="form-control"
                                           value="<?php echo $station_event_id; ?>" >
                                    <input type="hidden" name="bad_pieces_id" id="bad_pieces_id" class="form-control"
                                           value="<?php echo $bad_pieces_id; ?>" >

                                    <div class="row" id="badpiece">
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Defect Name * : </label>
                                            <div class="col-md-6">
                                                <input type="text" name="editdefect_name" id="editdefect_name" class="form-control" value="<?php echo $defect_name; ?>"  required readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row"  id="badpiece1">
                                        <label class="col-lg-2 control-label">Bad Pieces * : : </label>
                                        <div class="col-md-6">
                                            <input type="number" name="editbad_name" min="1" id="editbad_name" class="form-control" placeholder="Enter Pieces..." value="<?php echo $bad_pieces; ?>" readonly>
                                        </div>
                                    </div>
                                    <br/>

                                    <div class="row">
                                        <label class="col-lg-2 control-label">Defect Image : </label>
                                        <div class="col-md-6">
                                            <?php
                                            $time_stamp = $_SESSION['good_timestamp_id'];
                                            if(!empty($time_stamp)){
                                                $query2 = sprintf("SELECT * FROM good_piece_images where bad_piece_id = '$bad_pieces_id'");

                                                $qurimage = mysqli_query($db, $query2);
                                                $i =0 ;
                                                while ($rowcimage = mysqli_fetch_array($qurimage)) {
                                                    $image = $rowcimage['good_image_name'];
                                                    $mime_type = "image/gif";
                                                    $file_content = file_get_contents("$image");
                                                    $d_tag = "delete_image_" . $i;
                                                    $r_tag = "remove_image_" . $i;
                                                    ?>

                                                    <div class="col-lg-3 col-sm-6">
                                                        <div class="thumbnail">
                                                            <div class="thumb">
                                                                <?php echo '<img src="' . $image . '" style="" />'; ?>
                                                                <div class="caption-overflow">
														        <span>
														     	<a href="<?php echo $image; ?>"
                                                                   data-popup="lightbox" rel="gallery"
                                                                   class="btn border-white text-white btn-flat btn-icon btn-rounded">
                                                                    <i class="icon-plus3"></i></a>
													         	</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    $i++;}
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <br/>
                                    <hr/>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        <?php } ?>
    </div>
    <script>
        $(document).ready(function () {
            $('.select').select2();
        });


    </script>
    <script>
        window.onload = function() {
            history.replaceState("", "", "<?php echo $scriptName; ?>events_module/view_bad_piece.php?station_event_id=<?php echo $station_event_id; ?>&bad_pieces_id=<?php echo $bad_pieces_id; ?>");
        }
    </script>

    <?php include ('../footer.php') ?>
    </body>
    </html>

<?php
