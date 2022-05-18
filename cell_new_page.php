<?php include("config.php");
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
$station_event_id = $_GET['station_event_id'];
$sqlmain = "SELECT * FROM `sg_station_event` where `station_event_id` = '$station_event_id'";
$resultmain = $mysqli->query($sqlmain);
$rowcmain = $resultmain->fetch_assoc();
$part_family = $rowcmain['part_family_id'];
$part_number = $rowcmain['part_number_id'];
$p_line_id = $rowcmain['line_id'];

$sqlprint = "SELECT * FROM `cam_line` where `line_id` = '$p_line_id'";
$resultnumber = $mysqli->query($sqlprint);
$rowcnumber = $resultnumber->fetch_assoc();
$p_line_name = $rowcnumber['line_name'];

$sqlnumber = "SELECT * FROM `pm_part_number` where `pm_part_number_id` = '$part_number'";
$resultnumber = $mysqli->query($sqlnumber);
$rowcnumber = $resultnumber->fetch_assoc();
$pm_part_number = $rowcnumber['part_number'];
$pm_part_name = $rowcnumber['part_name'];

$sqlfamily = "SELECT * FROM `pm_part_family` where `pm_part_family_id` = '$part_family'";
$resultfamily = $mysqli->query($sqlfamily);
$rowcfamily = $resultfamily->fetch_assoc();
$pm_part_family_name = $rowcfamily['part_family_name'];

$sqlaccount = "SELECT * FROM `part_family_account_relation` where `part_family_id` = '$part_family'";
$resultaccount = $mysqli->query($sqlaccount);
$rowcaccount = $resultaccount->fetch_assoc();
$account_id = $rowcaccount['account_id'];

$sqlcus = "SELECT * FROM `cus_account` where `c_id` = '$account_id'";
$resultcus = $mysqli->query($sqlcus);
$rowccus = $resultcus->fetch_assoc();
$cus_name = $rowccus['c_name'];
$logo = $rowccus['logo'];
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
        .panel[class*=bg-]>.panel-body {
            background-color: inherit;
            height: 230px!important;
        }
        tbody, td, th, thead, tr {

            font-size: 14px;
        }
        .col-lg-3 {
            font-size: 12px!important;
        }
        .open > .dropdown-menu {
            min-width: 210px !important;
        }

        td {
            width: 50% !important;
        }

        .heading-elements {
            background-color: transparent;
        }

        .line_card {
            background-color: #181d50;
        }

        .bg-blue-400 {
            border: 1px solid white;
            /*background-color: #181d50;*/
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

        tr {
            background-color: transparent;
        }

        .dashboard_line_heading {
            color: #181d50;
            padding-top: 5px;
            font-size: 15px !important;
        }


        @media screen and (min-width: 2560px) {
            .dashboard_line_heading {
                font-size: 22px !important;
                padding-top: 5px;
            }
        }

        .thumb img:not(.media-preview) {
            height: 150px !important;
        }
        .content-section {
            display: none;
        }
        .left_container {
            width: 48%;
            height: 295px;
            float: left;
            background: #f5f5f5;
        }
        .line_container {
            width: 100%;
            padding: 20px 25px 25px 20px;
        }
        .btn_container{
            margin-left: 50%;
            height: 295px;
            background: #f5f5f5;
        }
        .right_btn.btn-group.btn-group-lg {
            padding: 20px 24px;
        }
        .section-container {
            width: 100%;
            padding: 20px 25px 25px 20px;

        }
        .multi-section{
            width: 100%;
            background-color: #f5f5f5;
            padding: 20px 25px 25px 20px;
        }
        .section-btn{
            white-space: normal;
            background-color: #2196f3!important;
            width: 30%;
            padding-left: 10px!important;
            font-size: medium;
            text-align: center;
            margin-top: 10px;
            border-radius: 10px!important;
            height: 55px;
        }
    </style>    <!-- /theme JS files -->
</head>
<body>
<div class="line_container">
    <div class="left_container">
        <div class="col-lg-12">
            <div class="panel bg-blue-400">
                <div class="panel-body">
                    <h3 class="no-margin dashboard_line_heading"><?php if($cus_name != ""){ echo $cus_name; }else{ echo "Customer Name";} ?></h3>
                    <hr/>
                    <table style="width:100%" id="t01">
                        <tr>
                            <td>
                                <div style="padding-top: 5px;font-size: initial;">Part Family :
                                </div>
                            </td>
                            <td>
                                <div><?php echo $pm_part_family_name;
                                    $pf_name = ''; ?> </div>
                                <input type="hidden" id="id<?php echo $countervariable; ?>"
                                       value="<?php echo $time; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="padding-top: 5px;font-size: initial;">Part Number :
                                </div>
                            </td>
                            <td><span><?php echo $pm_part_number;
                                    $p_num = ''; ?></span></td>
                        </tr>
                        <!--                                        <tr>-->
                        <!--                                            <td><div style="padding-top: 5px;font-size: initial;">Event Type :  </div></td>-->
                        <!--                                            <td><span>-->
                        <?php //echo $last_assignedby;	$last_assignedby = "";
                        ?><!--</span></span></td>-->
                        <!--                                        </tr>-->
                        <tr>
                            <td>
                                <div style="padding-top: 5px;font-size: initial;">Part Name :</div>
                            </td>
                            <td><span><?php echo $pm_part_name;
                                    $p_name = ''; ?></span></td>
                        </tr>
                    </table>
                </div>
                <!--                                <h4 style="text-align: center;background-color:#<?php echo $buttonclass; ?>;"><div id="txt" >&nbsp; </div></h4>
                                        -->
                <?php
                $variable123 = $time;
                if ($variable123 != "") {
                    ?>
                    <script>
                        function calcTime(city, offset) {
                            d = new Date();
                            utc = d.getTime() + (d.getTimezoneOffset() * 60000);
                            nd = new Date(utc + (3600000 * offset));
                            return nd;
                        }

                        // Set the date we're counting down to
                        var iddd<?php echo $countervariable; ?> = $("#id<?php echo $countervariable; ?>").val();
                        console.log(iddd<?php echo $countervariable; ?>);
                        var countDownDate<?php echo $countervariable; ?> = new Date(iddd<?php echo $countervariable; ?>).getTime();
                        // Update the count down every 1 second
                        var x = setInterval(function () {
                            // Get today's date and time
                            var now = calcTime('Chicago', '-5');
                            //new Date().getTime();
                            // Find the distance between now and the count down date
                            var distance = now - countDownDate<?php echo $countervariable; ?>;
                            // Time calculations for days, hours, minutes and seconds
                            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                            //console.log(days + "d " + hours + "h "+ minutes + "m " + seconds + "s ");
                            //console.log("------------------------");
                            // Output the result in an element with id="demo"
                            document.getElementById("demo<?php echo $countervariable; ?>").innerHTML = days + "d " + hours + "h "
                                + minutes + "m " + seconds + "s ";
                            // If the count down is over, write some text
                            if (distance < 0) {
                                clearInterval(x);
                                document.getElementById("demo<?php echo $countervariable; ?>").innerHTML = "EXPIRED";
                            }
                        }, 1000);
                    </script>
                <?php } ?>
                <div style="height: 100%;">
                    <h4 style="height:inherit;text-align: center;background-color:green;color: #fff;">
                        <div style="padding: 10px 0px 5px 0px;"><?php echo $line_status_text; ?> -
                            <span style="padding: 0px 0px 10px 0px;"
                                  id="demo<?php echo $countervariable; ?>">&nbsp;</span><span
                                id="server-load"></span></div>
                        <!--                                        <div style="padding: 0px 0px 10px 0px;" id="demo-->
                        <?php //echo $countervariable;
                        ?><!--" >&nbsp;</div>-->
                    </h4>
                </div>
            </div>
        </div>
    </div>
    <div class="btn_container">
        <div class="right_btn btn-group btn-group-lg">
            <button type="button" data-section="section1" class="btn btn-primary section-btn">Good & Bad Piece</button>
            <a href="material_tracability/material_tracability_new.php?station=<?php echo $p_line_id; ?>&station_event_id=<?php echo $station_event_id; ?>"">
            <button type="button" data-section="section2" class="btn btn-primary section-btn">Material Tracability</button>
            </a>
                <button type="button" data-section="section3" class="btn btn-primary section-btn">View Material Tracability</button>
            <button type="button" data-section="section4" class="btn btn-primary section-btn">Document Form</button>
            <button type="button" data-section="section5" class="btn btn-primary section-btn">View Document</button>
            <button type="button" data-section="section6" class="btn btn-primary section-btn">View Station Status</button>
            <button type="button" data-section="section7" class="btn btn-primary section-btn">Add/Update Events</button>
            <button type="button" data-section="section8" class="btn btn-primary section-btn">Create Form</button>
            <button type="button" data-section="section9" class="btn btn-primary section-btn">Submit Form</button>
            <button type="button" data-section="section10" class="btn btn-primary section-btn">Assign/Unassign Crew</button>
            <button type="button" data-section="section11" class="btn btn-primary section-btn">View Assigned Crew</button>

        </div>
    </div>
</div>


<!--<div class="section-container">-->
<!--    <div class="multi-section">-->
<!--        <div class="content-section" id="section1">-->
<!--             Content area -->
<!--          -->
<!--        </div>-->
<!--        <div class="content-section" id="section2">-->
<!---->
<!--        </div>-->
<!--        <div class="content-section" id="section3">-->
<!--            <h1> Section 3 </h1>-->
<!--            <p>Section 3 Content goes here</p>-->
<!--        </div>-->
<!--        <div class="content-section" id="section4">-->
<!--            <h1> Section 4 </h1>-->
<!--            <p>Section 4 Content goes here</p>-->
<!--        </div>-->
<!--        <div class="content-section" id="section5">-->
<!--            <h1> Section 5 </h1>-->
<!--            <p>Section 5 Content goes here</p>-->
<!--        </div>-->
<!--        <div class="content-section" id="section6">-->
<!--            <h1> Section 6 </h1>-->
<!--            <p>Section 6 Content goes here</p>-->
<!--        </div>-->
<!--        <div class="content-section" id="section7">-->
<!--            <h1> Section 7 </h1>-->
<!--            <p>Section 7 Content goes here</p>-->
<!--        </div>-->
<!--        <div class="content-section" id="section8">-->
<!--            <h1> Section 8 </h1>-->
<!--            <p>Section 8 Content goes here</p>-->
<!--        </div>-->
<!--        <div class="content-section" id="section9">-->
<!--            <h1> Section 9 </h1>-->
<!--            <p>Section 9 Content goes here</p>-->
<!--        </div>-->
<!--        <div class="content-section" id="section10">-->
<!--            <h1> Section 10 </h1>-->
<!--            <p>Section 10 Content goes here</p>-->
<!--        </div>-->
<!--        <div class="content-section" id="section11">-->
<!--            <h1> Section 11 </h1>-->
<!--            <p>Section 11 Content goes here</p>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
</body>
<script>
    $(function() {

        $(".btn").on("click", function() {
            //hide all sections
            $(".content-section").hide();
            //show the section depending on which button was clicked
            $("#" + $(this).attr("data-section")).show();
        });

    });
</script>