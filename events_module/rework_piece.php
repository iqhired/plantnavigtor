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
if ($i != "super" && $i != "admin") {
    header('location: ../dashboard.php');
}
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
        <title><?php echo $sitename; ?> |update rework piece</title>
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
    <body onload="openScanner()">
    <!-- Main navbar -->
    <?php
    $cust_cam_page_header = "Update Rework Piece";
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
            $rework = $result_good['rework'];

            ?>
            <!-- Content area -->
            <div class="content">
                <!-- Main charts -->
                <!-- Basic datatable -->
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title">Update Rework Piece</h5><br/>
                        <div class="row">
                            <div class="col-md-12" id="goodpiece">
                                <form action="create_good_bad_piece.php" id="asset_update" enctype="multipart/form-data"
                                      class="form-horizontal" method="post">

                                    <input type="hidden" name="station_event_id" id="station_event_id" class="form-control"
                                           value="<?php echo $station_event_id; ?>" >

                                    <div class="row" id="badpiece">
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Defect Name * : </label>
                                            <div class="col-md-6">
                                                <input type="text" name="editdefect_name" id="editdefect_name" class="form-control" value="<?php echo $defect_name; ?>"  required readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row"  id="badpiece1">
                                        <label class="col-lg-2 control-label">Rework Pieces * : : </label>
                                        <div class="col-md-6">
                                            <input type="number" name="editre_work" min="1" id="editre_work" class="form-control" placeholder="Enter Pieces..." value="<?php echo $rework; ?>" >
                                        </div>
                                    </div>
                                    <br/>

                                    <input type="hidden" name="edit_id" id="edit_id" value="<?php echo $good_bad_pieces_id; ?>">
                                    <input type="hidden" name="edit_gbid" id="edit_gbid" value="<?php echo $result_good['bad_pieces_id']; ?>">
                                    <input type="hidden" name="edit_seid" id="edit_seid" value="<?php echo $station_event_id; ?>">
                                    <input type="hidden" name="good_bad_piece_id" id="good_bad_piece_id" value="<?php echo $good_bad_pieces_id; ?>">

                                    <hr/>

                            </div>
                        </div>
                    </div>


                    <div class="panel-footer p_footer">
                        <button type="submit" id="form_submit_btn" class="btn btn-primary submit_btn"
                                style="background-color:#1e73be;">Submit
                        </button>
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
            history.replaceState("", "", "<?php echo $scriptName; ?>events_module/rework_piece.php?station_event_id=<?php echo $station_event_id; ?>&bad_pieces_id=<?php echo $bad_pieces_id; ?>");
        }
    </script>

    <?php include ('../footer.php') ?>
    </body>
    </html>

<?php
