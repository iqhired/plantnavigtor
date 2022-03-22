<?php
include("../config.php");
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
$timestamp = date('H:i:s');
$message = date("Y-m-d H:i:s");
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $sitename; ?> | Taskboard</title>
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
        <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
        <script type="text/javascript" src="../assets/js/core/app.js"></script>
        <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/notifications/sweet_alert.min.js"></script>
        <script type="text/javascript" src="../assets/js/pages/components_modals.js"></script>
        <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>

        <style>
            .heading-elements {
                background-color: transparent;
            }
            .bg-blue-400 {
                background-color: #f5f5f5;
                color : #27326d
            }
            .bg-orange-400 {
                background-color: #dc6805;
            }
            .bg-teal-400 {
                background-color: #218838;
            }
            .bg-pink-400 {
                background-color: #c9302c;
            }
            h3.no-margin {
                color: #343d73;
            }
        </style>	<!-- /theme JS files -->
    </head>

<?php
$cust_cam_page_header = "Taskboard Overview";
?>
<?php
include("../header.php");
include("../admin_menu.php");
include("../heading_banner.php");?>
<body class="alt-menu sidebar-noneoverflow">
           <!-- Content area -->
                        <div class="content">
                            <div class="row">
                                <?php
                                $query = sprintf("SELECT * FROM  sg_taskboard ");
                                $qur = mysqli_query($db, $query);
                                $countervariable = 0;
                                while ($rowc = mysqli_fetch_array($qur)) {
                                    $countervariable++;
                                    $userassign = 0;
                                    $useravailable = 0;
                                    $group_id = $rowc["group_id"];
                                    $buttonclass = "";
                                    $qur01 = mysqli_query($db, "SELECT count(*) as star1 FROM  sg_user_group where group_id = '$group_id'");
                                    $rowc01 = mysqli_fetch_array($qur01);
                                    $usrcount = $rowc01["star1"];
                                    $qur01q = mysqli_query($db, "SELECT * FROM  sg_group where group_id = '$group_id'");
                                    $rowc01q = mysqli_fetch_array($qur01q);
                                    $group_name = $rowc01q["group_name"];
                                    $qur04 = mysqli_query($db, "SELECT * FROM  cam_assign_crew_log where station_id = '$line' and status = '1' ORDER BY `assign_time` ASC ");
                                    while ($rowc04 = mysqli_fetch_array($qur04)) {
                                        $last_assignedby = $rowc04["last_assigned_by"];
                                    }
                                    $qur05 = mysqli_query($db, "SELECT * FROM  cam_assign_crew_log where station_id = '$line' and status = '0' ORDER BY `unassign_time` ASC ");
                                    while ($rowc05 = mysqli_fetch_array($qur05)) {
                                        $last_un_assignedby = $rowc05["last_unassigned_by"];
                                    }
                                    $qur06 = mysqli_query($db, "SELECT * FROM  sg_user_group where group_id = '$group_id' ");
                                    while ($rowc06 = mysqli_fetch_array($qur06)) {
                                        $u1 = $rowc06["user_id"];
                                        $qur07 = mysqli_query($db, "SELECT * FROM  tm_task where assign_to = '$u1' and status = '1' ");
                                        while ($rowc07 = mysqli_fetch_array($qur07)) {
                                            $userassign++;
                                        }
                                        $qur08 = mysqli_query($db, "SELECT * FROM  cam_users where users_id = '$u1' and available = '1' ");
                                        while ($rowc08 = mysqli_fetch_array($qur08)) {
                                            $useravailable++;
                                        }
                                    }
                                    $total = $useravailable - $userassign;
                                    ?>
                                    <div class="col-lg-4">
                                        <div class="panel bg-blue-400">
                                            <div class="panel-body">
                                                <div class="heading-elements" >
                                                    <ul class="icons-list">
                                                        <li class="dropdown">
                                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" ><i class="icon-cog3"></i> <span class="caret" style="color:#191e3a;"></span></a>
                                                            <ul class="dropdown-menu dropdown-menu-right">
                                                                <li><a href="view_taskboard_crew.php?group_id=<?php echo $rowc["group_id"]; ?>&taskboard=<?php echo $rowc["taskboard_name"]; ?>" ><i class="icon-pie5"></i> Dashboard</a></li>
                                                                <li><a href="create_task.php?taskboard=<?php echo $rowc["sg_taskboard_id"]; ?>" ><i class="icon-sync"></i>Create / Edit Task</a></li>
                                                                <li><a href="taskboard_users_list.php?group_id=<?php echo $rowc["group_id"]; ?>&taskboard=<?php echo $rowc["taskboard_name"]; ?>" ><i class="icon-cross3"></i> Users list</a></li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <h3 class="no-margin"><?php echo $rowc["taskboard_name"]; ?></h3>
                                                <hr/>
                                                <div style="padding-top: 5px;font-size: initial;">Total User : <?php echo $usrcount; ?> </div>
                                                <div style="padding-top: 5px;font-size: initial;">Available User : <?php echo $total; ?>/<?php echo $useravailable; ?> </div>
                                                <div style="padding-top: 5px;font-size: initial;">Group Name : <?php echo $group_name; ?> </div>
                                            </div>
                                            <!--								<h4 style="text-align: center;background-color:#<?php echo $buttonclass; ?>;"><div id="txt" >&nbsp; </div></h4>
                                        -->							</div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>

                    <!-- /main content -->


            <!-- /page container -->


            <?php
            $i = $_SESSION["sqq1"];
            if ($i == "") {
                ?>
                <script>
                    $(document).ready(function () {
                        $('#modal_theme_primarydash').modal('show');
                    });
                </script>
            <?php }
            ?>
            <script>
                // setTimeout(function () {
                //     //alert("reload");
                //     location.reload();
                // }, 60000);
            </script>




            <?php include ('../footer.php') ?>


<!-- END MAIN CONTAINER -->

</body>
</html>
