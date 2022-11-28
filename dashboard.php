<?php
include("config.php");
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
        <title><?php echo $sitename; ?> | Dashboard</title>
        <!-- Global stylesheets -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
              type="text/css">
        <link href="assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
        <link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="assets/css/core.css" rel="stylesheet" type="text/css">
        <link href="assets/css/components.css" rel="stylesheet" type="text/css">
        <link href="assets/css/colors.css" rel="stylesheet" type="text/css">
        <link href="assets/css/style_main.css" rel="stylesheet" type="text/css">
        <!-- /global stylesheets -->
        <!-- Core JS files -->
        <script type="text/javascript" src="assets/js/plugins/loaders/pace.min.js"></script>
        <script type="text/javascript" src="assets/js/core/libraries/jquery.min.js"></script>
        <script type="text/javascript" src="assets/js/core/libraries/bootstrap.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/loaders/blockui.min.js"></script>
        <!-- /core JS files -->
        <!-- Theme JS files -->
        <script type="text/javascript" src="assets/js/plugins/tables/datatables/datatables.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/forms/selects/select2.min.js"></script>
        <script type="text/javascript" src="assets/js/core/app.js"></script>
        <script type="text/javascript" src="assets/js/pages/datatables_basic.js"></script>
        <script type="text/javascript" src="assets/js/plugins/ui/ripple.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/notifications/sweet_alert.min.js"></script>
        <script type="text/javascript" src="assets/js/pages/components_modals.js"></script>
        <script type="text/javascript" src="assets/js/plugins/ui/ripple.min.js"></script>
       <!--chart -->
        <style>
            .heading-elements {
                background-color: transparent;
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
            .dashboard_line_heading {

                padding-top: 5px;
                font-size: 15px !important;
                color: #191e3a;
            }
            @media screen and (min-width:2560px)  {
            .dashboard_line_heading {
                font-size: 22px !important;
                padding-top: 5px;
            }
            }

            .thumb img:not(.media-preview) {
                height: 150px !important;
            }
        </style>    <!-- /theme JS files -->
    </head>
        <!-- Main navbar -->
        <!-- /main navbar -->
        <?php
        $cust_cam_page_header = "Crew Status Overview";
        include("header.php");
        include("admin_menu.php");
        include("heading_banner.php");
        ?>

         <body class="alt-menu sidebar-noneoverflow">
                    <!-- Content area -->
                    <div class="content">
                        <div class="row">
                            <?php
                            $query = sprintf("SELECT * FROM  cam_line where enabled = '1'");
                            $qur = mysqli_query($db, $query);
                            $countervariable = 0;
                            while ($rowc = mysqli_fetch_array($qur)) {
                                $countervariable++;
                                $line = $rowc["line_id"];
                                $buttonclass = "";
                                $qur01 = mysqli_query($db, "SELECT count(*) as star1 FROM  cam_station_pos_rel where line_id = '$line'");
                                $rowc01 = mysqli_fetch_array($qur01);
                                $star1 = $rowc01["star1"];
                                $qur02 = mysqli_query($db, "SELECT count(*) as star2 FROM  cam_assign_crew where line_id = '$line' and resource_type = 'regular'");
                                $rowc02 = mysqli_fetch_array($qur02);
                                $star2 = $rowc02["star2"];
                                if ($star1 > $star2) {
                                    $buttonclass = "dc6805";
                                } else if ($star1 == $star2) {
                                    $buttonclass = "218838";
                                }
                                if ($star2 == "0") {
                                    $buttonclass = "1F449C";
                                }
                                $time = "";
                                $qur03 = mysqli_query($db, "SELECT * FROM  cam_log where line_id = '$line' and flag = '1'");
                                while ($rowc03 = mysqli_fetch_array($qur03)) {
                                    $notific = $rowc03["email_notification"];
                                    if ($notific == "1") {
                                        $buttonclass = "c9302c";
                                    }
                                    $time = $rowc03["created_at"];
                                }
                                $qur04 = mysqli_query($db, "SELECT * FROM  cam_assign_crew_log where station_id = '$line' and status = '1' ORDER BY `assign_time` ASC ");
                                while ($rowc04 = mysqli_fetch_array($qur04)) {
                                    $last_assignedby = $rowc04["last_assigned_by"];
                                }
                                $qur05 = mysqli_query($db, "SELECT * FROM  cam_assign_crew_log where station_id = '$line' and status = '0' ORDER BY `unassign_time` ASC ");
                                while ($rowc05 = mysqli_fetch_array($qur05)) {
                                    $last_un_assignedby = $rowc05["last_unassigned_by"];
                                }
                                ?>
                                <div class="col-lg-3">
                                    <div class="panel bg-blue-400">
                                        <div class="panel-body">
                                            <div class="heading-elements" >
                                                <ul class="icons-list">
                                                    <li class="dropdown">
                                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" >
                                                            <i class="icon-cog3"></i> <span class="caret" style="color:white;"></span></a>
                                                        <ul class="dropdown-menu dropdown-menu-right">
                                                            <li><a href="view_assigned_crew.php?station=<?php echo $rowc["line_id"]; ?>" target="_BLANK"><i class="fa fa-eye"></i> View Assigned Crew</a></li>
                                                            <li><a href="assignment_module/assign_crew.php?line=<?php echo $rowc["line_id"]; ?>" target="_BLANK"><i class="icon-sync"></i>Assign/Unassign</a></li>
                                                            <li><a href="log_module/assign_crew_log.php?line=<?php echo $rowc["line_id"]; ?>" target="_BLANK"><i class="icon-pie5"></i> Assign Crew Log</a></li>
<!--                                                            <li><a href="form_module/form_settings.php?station=--><?php //echo $rowc["line_id"]; ?><!--" target="_BLANK"><i class="icon-pie5"></i> Create Form</a></li>-->
<!--                                                            <li><a href="form_module/options.php?station=--><?php //echo $rowc["line_id"]; ?><!--" target="_BLANK"><i class="icon-pie5"></i> Submit Form</a></li>-->
                                                    <!--    <li><a href="#"><i class="icon-cross3"></i> Clear list</a></li> -->
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </div>
                                            <h3 class="no-margin dashboard_line_heading"><?php echo $rowc["line_name"]; ?></h3>
                                            <hr/>
                                            <div style="padding-top: 5px;font-size: initial;">Position Assigned : <?php echo $star2; ?> / <?php echo $star1; ?> </div>
                                            <input type="hidden" id="id<?php echo $countervariable; ?>" value="<?php echo $time; ?>">
                                            <div style="padding-top: 5px;font-size: initial;">Last Assigned by :  </div>
                                            <div><?php
                                                echo $last_assignedby;
                                                $last_assignedby = "";
                                                ?> &nbsp;</div>
                                            <div style="padding-top: 5px;font-size: initial;">Last Unassigned by :  </div>
                                            <div><?php
                                                echo $last_un_assignedby;
                                                $last_un_assignedby = "";
                                                ?> &nbsp;</div>
                                        </div>
    <!--                                <h4 style="text-align: center;background-color:#<?php echo $buttonclass; ?>;"><div id="txt" >&nbsp; </div></h4>
                                        -->                             <h4 style="text-align: center;background-color:#<?php echo $buttonclass; ?>;color: #fff;">
                                            <div id="demo<?php echo $countervariable; ?>" >&nbsp;</div></h4>
                                        <?php
                                        $variable123 = $time;
                                        if ($variable123 != "") {
                                            //include the timing configuration file
                                            include("timings_config.php");
                                            ?>
                                            <!--<script>
                                                function calcTime(city, offset) {
                                                    d = new Date();
                                                    utc = d.getTime() + (d.getTimezoneOffset() * 60000);
                                                    nd = new Date(utc + (3600000 * offset));
                                                    return nd;
                                                }
                                                // Set the date we're counting down to
                                                var iddd<?php /*echo $countervariable; */?> = $("#id<?php /*echo $countervariable; */?>").val();
                                                console.log(iddd<?php /*echo $countervariable; */?>);
                                                var countDownDate<?php /*echo $countervariable; */?> = new Date(iddd<?php /*echo $countervariable; */?>).getTime();
                                                // Update the count down every 1 second
                                                var x = setInterval(function () {
                                                    // Get today's date and time
                                                    var now = calcTime('Chicago', '-6');
                                                    //new Date().getTime();
                                                    // Find the distance between now and the count down date
                                                    var distance = now - countDownDate<?php /*echo $countervariable; */?>;
                                                    // Time calculations for days, hours, minutes and seconds
                                                    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        //console.log(days + "d " + hours + "h "+ minutes + "m " + seconds + "s ");
        //console.log("------------------------");
                                                    // Output the result in an element with id="demo"
                                                    document.getElementById("demo<?php /*echo $countervariable; */?>").innerHTML = days + "d " + hours + "h "
                                                            + minutes + "m " + seconds + "s ";
                                                    // If the count down is over, write some text 
                                                    if (distance < 0) {
                                                        clearInterval(x);
                                                        document.getElementById("demo<?php /*echo $countervariable; */?>").innerHTML = "EXPIRED";
                                                    }
                                                }, 1000);
                                            </script>-->
                                        <?php } ?>
                                        <div id="server-load"></div>
                                    </div>
                                </div>                      
                                <?php
                            }
                            ?>                  
                        </div>
                    </div>

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
<!--        <script>-->
<!--            setTimeout(function () {-->
<!--                //alert("reload");-->
<!--                location.reload();-->
<!--            }, 60000);-->
<!--        </script>-->
        <?php include("footer.php"); ?> <!-- /page container -->
        <!-- new footer here -->
 </body>
</html>