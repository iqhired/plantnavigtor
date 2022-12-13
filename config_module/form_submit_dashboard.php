<?php include("../config.php");
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
//Set the time of the user's last activity
$_SESSION['LAST_ACTIVITY'] = $time;

$i = $_SESSION["role_id"];
if ($i != "super" && $i != "admin" && $i != "pn_user" && $_SESSION['is_tab_user'] != 1 && $_SESSION['is_cell_login'] != 1 ) {
    header('location: ../line_status_overview_dashboard.php');
}
$user_id = $_SESSION["id"];
$chicagotime = date("Y-m-d H:i:s");
//$line = "<b>-</b>";
$line = "";


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?>
        | Station Dashboard</title>
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
    <script type="text/javascript" src="../assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="../assets/js/libs/jquery-3.6.0.min.js"> </script>
    <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->
    <!-- Theme JS files -->
    <script type="text/javascript" src="../assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"> </script>
    <script type="text/javascript" src="../assets/js/plugins/notifications/sweet_alert.min.js"> </script>
    <script type="text/javascript" src="../assets/js/pages/components_modals.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_bootstrap_select.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_layouts.js"></script>
    <style> .sidebar-default .navigation li > a {
            color: #f5f5f5
        }

        ;
        a:hover {
            background-color: #20a9cc;
        }

        .sidebar-default .navigation li > a:focus, .sidebar-default .navigation li > a:hover {
            background-color: #20a9cc;
        }

        .content-wrapper {
            display: block !important;
            vertical-align: top;
            padding: 20px !important;
        }



        .bg-primary {
            background-color: #606060!important;
        }
        .col-md-3 {
            width: 25%;
            padding-top: 10px;
        }


        .red {
            color: red;
            display: none;
        }
        @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
            .col-md-3 {
                width: 100%;
                padding-top: 10px;
            }
        }
    </style>
</head>
<body>
<!-- Main navbar -->
<?php
$cam_page_header = "Station Dashboard";
include("../header_folder.php");
if ($is_tab_login || ($_SESSION["role_id"] == "pn_user")) {
    include("../tab_menu.php");
} else {
    include("../admin_menu.php");
}

?>
<!-- Content area -->
<div class="content">

    <div class="panel panel-flat">

        <div class="panel-heading" style="padding: 50px;">
            <div class="row">
                <div class="search_container"  style="margin-right:10px;">
                    <input id="search" class="search__input"  type="text" placeholder="Search Station" style="margin-left: 15px;padding: 12px 24px;background-color: transparent;transition: transform 250ms ease-in-out;line-height: 18px;color: #000000;font-size: 18px;background-color: transparent; background-repeat: no-repeat;
        background-size: 18px 18px;
        background-position: 95% center;
        border-radius: 50px;
        border: 1px solid #575756;
        transition: all 250ms ease-in-out;
        backface-visibility: hidden;
        transform-style: preserve-3d;
        " >
                </div>
            </div>

            </br>

            <div class="row">
                <div class="col-md-6"  style="width: 100%;border: groove;padding: 10px;">
                    <?php
                    $sql1 = "SELECT * FROM `cam_line` WHERE `enabled` = 1 AND `is_deleted` != 1";
                    $result1 = $mysqli->query($sql1);
                    while ($row1 = mysqli_fetch_array($result1)) {
                    $line_name = $row1['line_name'];
                    $line_id = $row1['line_id'];
                    $sql2 = "SELECT count(*) as a  FROM `sg_station_event` where line_id = '$line_id' and event_status = '1' and event_type_id != 7";
                    $result2 = $mysqli->query($sql2);
                    while ($row2 = mysqli_fetch_array($result2)) {
                        $a = $row2['a'];

                            ?>

                            <?php    if($a > 0){ ?>
                                <div class="col-md-3">
                                    <a target="_blank" href="<?php echo $siteURL; ?>config_module/line_wise_form_submit_dashboard.php?id=<?php echo $line_id ?>"> <button type="button" class="btn btn-primary view_gpbp" style="white-space: normal;background-color:#008000 !important;width:98% ; padding-top: 1vh; font-size: medium; text-align: center;"><?php echo $line_name ?></button></a>
                                </div>
                            <?php } else{  }
                       }
                    } ?>
                    </div>
                <div class="col-md-6"  style="width: 100%;border: groove;padding: 10px;">
                 <?php
                $sql1 = "SELECT * FROM `cam_line` WHERE `enabled` = 1 AND `is_deleted` != 1";
                $result1 = $mysqli->query($sql1);
                while ($row1 = mysqli_fetch_array($result1)) {
                    $line_name = $row1['line_name'];
                    $line_id = $row1['line_id'];
                    $sql2 = "SELECT count(*) as a  FROM `sg_station_event` where line_id = '$line_id' and event_status = '1' and event_type_id != 7";
                    $result2 = $mysqli->query($sql2);
                    while ($row2 = mysqli_fetch_array($result2)) {
                        $a = $row2['a'];
                        if($a > 0){  } else{ ?>

                                <div class="col-md-3">
                                    <a target="_blank" href="<?php echo $siteURL; ?>view_form_status.php?station=<?php echo $line_id ?>"> <button type="button" class="btn btn-primary view_gpbp" style="white-space: normal;background-color:#020d7ce6 !important;width:98% ; padding-top: 1vh; font-size: medium; text-align: center;"><?php echo $line_name ?></button></a>
                                </div>



                        <?php }
                    }
                } ?>
                </div>
            </div>
        </div>

    </div>
    <!-- Basic datatable -->

</div>
<!-- /content area -->

<script>
    $("#search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".view_gpbp").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

</script>


<?php include('../footer.php') ?>

</body>
</html>