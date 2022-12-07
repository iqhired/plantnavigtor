<?php include("../config.php");
$station = $_GET['id'];
$sql1 = "SELECT * FROM `cam_line` WHERE line_id = '$station'";
$result1 = mysqli_query($db, $sql1);
while ($cam1 = mysqli_fetch_array($result1)) {
    $station1 = $cam1['line_id'];
    $station2 = $cam1['line_name'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?> | Station Status View </title>
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
          type="text/css">
    <link href="../assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/colors.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/style_main.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-base.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-data-adapter.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-ui.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-exports.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-pareto.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-circular-gauge.min.js"></script>
    <link href="https://cdn.anychart.com/releases/8.11.0/css/anychart-ui.min.css" type="text/css" rel="stylesheet">
    <link href="https://cdn.anychart.com/releases/8.11.0/fonts/css/anychart-font.min.css" type="text/css" rel="stylesheet">
    <!-- /global stylesheets -->
    <!-- Core JS files -->
    <script type="text/javascript" src="../assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="../assets/js/libs/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->
    <!-- Theme JS files -->
    <script type="text/javascript" src="../assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>

    <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_bootstrap_select.js"></script>
    <script type="text/javascript" src="../assets/js/pages/form_layouts.js"></script>

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
            /*border: 1px solid white;*/
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
           /* padding-top: 0px !important;*/
            font-size: 15px !important;
        }
        .heading{
            margin-top: 0px !important;
        }
        hr {
            margin-top: 0px !important;
            margin-bottom: 0px !important;
            border-top: 1px solid #ddd;
        }
        .panel-body {
            padding: 7px !important;;
        }

        @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
            .dashboard_line_heading {
                font-size: 22px !important;
                padding-top: 5px;
            }
        }

        .thumb img:not(.media-preview) {
            height: 150px !important;
        }
    </style>
</head>


<!-- Main navbar -->
<?php
$cam_page_header = "Station - " . $station2;
include("../hp_header.php");
?>

<body>
<div class="container-fluid">
<form action="" id="daily_data" class="form-horizontal" enctype="multipart/form-data" method="post">
    <input type="hidden" name="station" id="station" value="<?php echo $station; ?>">
<div class="col-md-12" style="background-color: #e7e7e7;padding: 30px 10px;">
<div class="row">
    <?php
    $countervariable = 0;
    $buttonclass = '#000';
    $p_num = '';
    $p_name = '';
    $pf_name = '';
    $time = '';


    $qur01 = mysqli_query($db, "SELECT pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,pf.pm_part_family_id as pf_no, et.event_type_name as e_name ,et.color_code as color_code , sg_events.modified_on as updated_time ,sg_events.station_event_id as station_event_id , sg_events.event_status as event_status , sg_events.created_on as e_start_time FROM sg_station_event as sg_events inner join event_type as et on sg_events.event_type_id=et.event_type_id Inner Join pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on sg_events.part_number_id=pn.pm_part_number_id where sg_events.line_id= '$station1' ORDER by sg_events.created_on DESC LIMIT 1");
    $rowc01 = mysqli_fetch_array($qur01);
    if ($rowc01 != null) {
        $time = $rowc01['updated_time'];
        $station_event_id = $rowc01['station_event_id'];
        $line_status_text = $rowc01['e_name'];
        $event_status = $rowc01['event_status'];
        $p_num = $rowc01["p_num"];
        $p_no = $rowc01["p_no"];;
        $p_name = $rowc01["p_name"];
        $pf_name = $rowc01["pf_name"];
        $pf_no = $rowc01["pf_no"];
        $buttonclass = $rowc01["color_code"];
    } else {

    }

    ?>

    <div class="col-md-4">

        <div class="panel bg-blue-400">
            <div class="heading" style="height: 40px;">
                <h4 style="height:inherit;text-align: center;background-color:#181d50;color: #fff;padding-top: 5px;">
                    <div style="margin-top: fill!important;padding: 0px 0px 0px 0px;">
                        <span style="padding: 0px 0px 0px 0px;text-align: center;">&nbsp;CELL STATUS OVERVIEW</span>
                    </div>
                </h4>
            </div>
            <div class="panel-body">

                <h3 class="no-margin dashboard_line_heading"><?php echo $station2; ?></h3>
                <hr/>
                <table style="width:100%" id="t01">
                    <tr>
                        <td>
                            <div style="padding-top: 5px;font-size: initial; wi">Part Family :
                            </div>
                        </td>
                        <td>
                            <div><?php echo $pf_name;
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
                        <td><span><?php echo $p_num;
                                $p_num = ''; ?></span></td>
                    </tr>
                    <tr>
                        <td>
                            <div style="padding-top: 5px;font-size: initial;">Part Name :</div>
                        </td>
                        <td><span><?php echo $p_name;
                                $p_name = ''; ?></span></td>
                    </tr>
                </table>
            </div>
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
                        var now = calcTime('Chicago', '-6');
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
                <h4 style="height:inherit;text-align: center;background-color:<?php echo $buttonclass; ?>;color: #fff;">
                    <div style="padding: 0px 0px 0px 0px;"><?php echo $line_status_text; ?> -
                        <span style="padding: 0px 0px 0px 0px;"
                              id="demo<?php echo $countervariable; ?>">&nbsp;</span><span
                                id="server-load"></span>
                    </div>
                </h4>
            </div>
        </div>
    <?php
    $countervariable++;
    $query = sprintf("SELECT * FROM  cam_line where enabled = '1' and line_id  = '$station1'");
    $qur = mysqli_query($db, $query);
    while ($rowc = mysqli_fetch_array($qur)) {
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
        </div>
        <div class="col-md-4">
            <!--<span class="label label-info"><center></center></span>-->
            <div class="panel bg-blue-400">
                <div class="heading" style="height: 40px;">
                    <h4 style="height:inherit;text-align: center;background-color:#181d50;color: #fff;padding-top: 5px;">
                        <div style="margin-top: fill!important;padding: 0px 0px 0px 0px;">
                            <span style="padding: 0px 0px 0px 0px;text-align: center;">&nbsp;CREW STATUS OVERVIEW</span>
                        </div>
                    </h4>
                </div>
                <div class="panel-body">
                    <h3 class="no-margin dashboard_line_heading"><?php echo $station2; ?></h3>
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
                <h4 style="text-align: center;background-color:#<?php echo $buttonclass; ?>;color: #fff;">
                    <div id="demo<?php echo $countervariable; ?>" >&nbsp;</div></h4>
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
                            var now = calcTime('Chicago', '-6');
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
                <div id="server-load"></div>
            </div>
        </div>
        <?php } ?>
    <div class="col-md-4">
           <div class="panel bg-blue-400">
               <div class="heading" style="height: 40px;">
                   <h4 style="height:inherit;text-align: center;background-color:#181d50;color: #fff;padding-top: 5px;">
                       <div style="margin-top: fill!important;padding: 0px 0px 0px 0px;">
                           <span style="padding: 0px 0px 0px 0px;text-align: center;">&nbsp;STATION FORM SUBMIT STATUS</span>
                       </div>
                   </h4>
               </div>
               <div class="panel-body" style="height: 269px!important;">
                   <?php
                   $countervariable++;
                   $sql1 = "SELECT * FROM `form_user_data` WHERE `station` = '$station' and `form_type` = 4 order by created_at desc limit 1";
                   $result1 = $mysqli->query($sql1);
                   while ($rowc = $result1->fetch_assoc()) {
                   $form_create_id = $rowc["form_create_id"];
                   $form_user_data_id = $rowc["form_user_data_id"];
                   $station = $rowc["station"];
                   $form_type = $rowc["form_type"];
                   $part_family = $rowc["part_family"];
                   $part_number = $rowc["part_number"];
                   $form_submitted_by = $rowc['firstname'] . " " . $rowc['lastname'];

                   $qur = mysqli_query($db, "SELECT * FROM `form_create` where form_create_id = '$form_create_id'");
                   $row1 = mysqli_fetch_array($qur);
                   $estimateduration = $row1["frequency"];
                   $estimateduration = $row1["frequency"];
                   $time = $row1["frequency"];
                   $t11 = $row1["frequency"];
                   $color = "";

                   //retrieve the form type name from the table
                   $qur0351 = mysqli_query($db, "SELECT * FROM `form_type` where form_type_id = '$form_type'");
                   $rowc0351 = mysqli_fetch_array($qur0351);
                   $form_type_name = $rowc0351['form_type_name'];

                   //retrieve the part family name from the table
                   $qur0352 = mysqli_query($db, "SELECT * FROM `pm_part_family` where pm_part_family_id = '$part_family' ");
                   $rowc0352 = mysqli_fetch_array($qur0352);
                   $part_family_name = $rowc0352['part_family_name'];

                   //retrieve the part number and part name from the table
                   $qur0353 = mysqli_query($db, "SELECT * FROM `pm_part_number` where pm_part_number_id = '$part_number'  ");
                   $rowc0353 = mysqli_fetch_array($qur0353);
                   $part_number = $rowc0353['part_number'];
                   $part_name = $rowc0353['part_name'];

                   $arrteam1 = explode(':', $t11);
                   $hours = $arrteam1[0];
                   $minutes = $arrteam1[1];
                   $hours1 = $hours * 60;
                   $minutes1 = $minutes + $hours1;
                   $date = $rowc["created_at"];
                   $date = strtotime($date);
                   $date = strtotime("+" . $minutes1 . " minute", $date);
                   $date = date('Y-m-d H:i:s', $date);
                   $working_from_time = $rowc["created_at"];
                   $calcdatet = strtotime($date);
                   $calccurrdate = strtotime($curdate);
                   ?>
                   <h3 class="no-margin dashboard_line_heading">First Piece Sheet Lab</h3>
                       <input type="hidden" id="id<?php echo $countervariable; ?>" value="<?php echo $date; ?>">
                       <input type="hidden" id="working_from_time<?php echo $countervariable; ?>" value="<?php echo $working_from_time; ?>">
                   <div class="caption text-center">
                       <h4 style="text-align: center;padding:5px;color: #FFFFFF">
                           <?php if ($date != "") { ?>
                               <div id="demo<?php echo $countervariable; ?>">&nbsp;</div>
                           <?php } else { ?>
                               <div id="demo<?php echo $countervariable; ?>">Available</div>
                           <?php } ?>
                       </h4>
                   </div><hr/>
                       <script>
                           function calcTime(city, offset) {
                               d = new Date();
                               utc = d.getTime() + (d.getTimezoneOffset() * 60000);
                               nd = new Date(utc + (3600000 * offset));
                               return nd;
                           }
                           // Set the date we're counting down to
                           var iddd<?php echo $countervariable; ?> = $("#id<?php echo $countervariable; ?>").val();

                           var working_from_time<?php echo $countervariable; ?> = $("#working_from_time<?php echo $countervariable; ?>").val();

                           //console.log(iddd<?php /* echo $countervariable;*/ ?>);
                           var countDownDate<?php echo $countervariable; ?> = new Date(iddd<?php echo $countervariable; ?>).getTime();

                           var countDownworkingDate<?php echo $countervariable; ?> = new Date(working_from_time<?php echo $countervariable; ?>).getTime();

                           // Update the count down every 1 second
                           var x = setInterval(function () {
                               // Get today's date and time
                               // var now = new Date().getTime();
                               var now = calcTime('Chicago', '-6');
                               // Find the distance between now and the count down date
                               //aaya change karvano che
                               var distance = countDownDate<?php echo $countervariable; ?> - now;
                               // Time calculations for days, hours, minutes and seconds
                               var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                               var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                               var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                               var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                               // console.log(days + "d " + hours + "h " + minutes + "m " + seconds + "s ");
                               //  console.log("------------------------");
                               // Output the result in an element with id="demo"
                               document.getElementById("demo<?php echo $countervariable; ?>").innerHTML = 'Submit in: ' + hours + "h "
                                   + minutes + "m " + seconds + "s ";
                               document.getElementById("demo<?php echo $countervariable; ?>").style.backgroundColor = 'green';
                               // If the count down is over, write some text
                               if (distance <= 0) {
                                   // clearInterval(x);
                                   var workingdistance = now - countDownworkingDate<?php echo $countervariable; ?>;
                                   var workingdays = Math.floor(workingdistance / (1000 * 60 * 60 * 24));
                                   var workinghours = Math.floor((workingdistance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                   var workingminutes = Math.floor((workingdistance % (1000 * 60 * 60)) / (1000 * 60));
                                   var workingseconds = Math.floor((workingdistance % (1000 * 60)) / 1000);

                                   document.getElementById("demo<?php echo $countervariable; ?>").innerHTML = 'Expired: ' + workingdays + "d " + workinghours + "h "
                                       + workingminutes + "m " + workingseconds + "s ";
                                   document.getElementById("demo<?php echo $countervariable; ?>").style.backgroundColor = 'red';
                               }
                           }, 1000);
                       </script>
                       <?php
                       $form_type_name = "";
                       $part_family_name = "";
                       $part_number = "";
                       $part_name = "";
                       $buttonclass = "218838";
                       $date = "";
                       ?>
                       <?php
                       $ratecheck = "";
                   }
                   ?>
                   <?php
                   $countervariable++;
                   $sql1 = "SELECT * FROM `form_user_data` WHERE `station` = '$station' and `form_type` = 5 order by created_at desc limit 1";
                   $result1 = $mysqli->query($sql1);
                   while ($rowc = $result1->fetch_assoc()) {
                   $form_create_id = $rowc["form_create_id"];
                   $form_user_data_id = $rowc["form_user_data_id"];
                   $station = $rowc["station"];
                   $form_type = $rowc["form_type"];
                   $part_family = $rowc["part_family"];
                   $part_number = $rowc["part_number"];
                   $form_submitted_by = $rowc['firstname'] . " " . $rowc['lastname'];

                   $qur = mysqli_query($db, "SELECT * FROM `form_create` where form_create_id = '$form_create_id'");
                   $row1 = mysqli_fetch_array($qur);
                   $estimateduration = $row1["frequency"];
                   $estimateduration = $row1["frequency"];
                   $time = $row1["frequency"];
                   $t11 = $row1["frequency"];
                   $color = "";

                   //retrieve the form type name from the table
                   $qur0351 = mysqli_query($db, "SELECT * FROM `form_type` where form_type_id = '$form_type'");
                   $rowc0351 = mysqli_fetch_array($qur0351);
                   $form_type_name = $rowc0351['form_type_name'];

                   //retrieve the part family name from the table
                   $qur0352 = mysqli_query($db, "SELECT * FROM `pm_part_family` where pm_part_family_id = '$part_family' ");
                   $rowc0352 = mysqli_fetch_array($qur0352);
                   $part_family_name = $rowc0352['part_family_name'];

                   //retrieve the part number and part name from the table
                   $qur0353 = mysqli_query($db, "SELECT * FROM `pm_part_number` where pm_part_number_id = '$part_number'  ");
                   $rowc0353 = mysqli_fetch_array($qur0353);
                   $part_number = $rowc0353['part_number'];
                   $part_name = $rowc0353['part_name'];

                   $arrteam1 = explode(':', $t11);
                   $hours = $arrteam1[0];
                   $minutes = $arrteam1[1];
                   $hours1 = $hours * 60;
                   $minutes1 = $minutes + $hours1;
                   $date = $rowc["created_at"];
                   $date = strtotime($date);
                   $date = strtotime("+" . $minutes1 . " minute", $date);
                   $date = date('Y-m-d H:i:s', $date);
                   $working_from_time = $rowc["created_at"];
                   $calcdatet = strtotime($date);
                   $calccurrdate = strtotime($curdate);
                   ?>
                   <h3 class="no-margin dashboard_line_heading">First Piece Sheet Op</h3>
                       <input type="hidden" id="id<?php echo $countervariable; ?>" value="<?php echo $date; ?>">
                       <input type="hidden" id="working_from_time<?php echo $countervariable; ?>" value="<?php echo $working_from_time; ?>">
                       <div class="caption text-center">
                           <h4 style="text-align: center;padding:5px;color: #FFFFFF">
                               <?php if ($date != "") { ?>
                                   <div id="demo<?php echo $countervariable; ?>">&nbsp;</div>
                               <?php } else { ?>
                                   <div id="demo<?php echo $countervariable; ?>">Available</div>
                               <?php } ?>
                           </h4>
                       </div><hr/>
                       <script>
                           function calcTime(city, offset) {
                               d = new Date();
                               utc = d.getTime() + (d.getTimezoneOffset() * 60000);
                               nd = new Date(utc + (3600000 * offset));
                               return nd;
                           }
                           // Set the date we're counting down to
                           var iddd<?php echo $countervariable; ?> = $("#id<?php echo $countervariable; ?>").val();

                           var working_from_time<?php echo $countervariable; ?> = $("#working_from_time<?php echo $countervariable; ?>").val();

                           //console.log(iddd<?php /* echo $countervariable;*/ ?>);
                           var countDownDate<?php echo $countervariable; ?> = new Date(iddd<?php echo $countervariable; ?>).getTime();

                           var countDownworkingDate<?php echo $countervariable; ?> = new Date(working_from_time<?php echo $countervariable; ?>).getTime();

                           // Update the count down every 1 second
                           var x = setInterval(function () {
                               // Get today's date and time
                               // var now = new Date().getTime();
                               var now = calcTime('Chicago', '-6');
                               // Find the distance between now and the count down date
                               //aaya change karvano che
                               var distance = countDownDate<?php echo $countervariable; ?> - now;
                               // Time calculations for days, hours, minutes and seconds
                               var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                               var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                               var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                               var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                               // console.log(days + "d " + hours + "h " + minutes + "m " + seconds + "s ");
                               //  console.log("------------------------");
                               // Output the result in an element with id="demo"
                               document.getElementById("demo<?php echo $countervariable; ?>").innerHTML = 'Submit in: ' + hours + "h "
                                   + minutes + "m " + seconds + "s ";
                               document.getElementById("demo<?php echo $countervariable; ?>").style.backgroundColor = 'green';
                               // If the count down is over, write some text
                               if (distance <= 0) {
                                   // clearInterval(x);
                                   var workingdistance = now - countDownworkingDate<?php echo $countervariable; ?>;
                                   var workingdays = Math.floor(workingdistance / (1000 * 60 * 60 * 24));
                                   var workinghours = Math.floor((workingdistance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                   var workingminutes = Math.floor((workingdistance % (1000 * 60 * 60)) / (1000 * 60));
                                   var workingseconds = Math.floor((workingdistance % (1000 * 60)) / 1000);

                                   document.getElementById("demo<?php echo $countervariable; ?>").innerHTML = 'Expired: ' + workingdays + "d " + workinghours + "h "
                                       + workingminutes + "m " + workingseconds + "s ";
                                   document.getElementById("demo<?php echo $countervariable; ?>").style.backgroundColor = 'red';
                               }
                           }, 1000);
                       </script>
                       <?php
                       $form_type_name = "";
                       $part_family_name = "";
                       $part_number = "";
                       $part_name = "";
                       $buttonclass = "218838";
                       $date = "";
                       ?>
                       <?php
                       $ratecheck = "";
                   }
                   ?>
                   <?php
                   $countervariable++;
                   $sql1 = "SELECT * FROM `form_user_data` WHERE `station` = '$station' and `form_type` = 3 order by created_at desc limit 1";
                   $result1 = $mysqli->query($sql1);
                   while ($rowc = $result1->fetch_assoc()) {
                       $form_create_id = $rowc["form_create_id"];
                       $form_user_data_id = $rowc["form_user_data_id"];
                       $station = $rowc["station"];
                       $form_type = $rowc["form_type"];
                       $part_family = $rowc["part_family"];
                       $part_number = $rowc["part_number"];

                       $qur = mysqli_query($db, "SELECT * FROM `form_create` where form_create_id = '$form_create_id'");
                       $row1 = mysqli_fetch_array($qur);
                       $estimateduration = $row1["frequency"];
                       $time = $row1["frequency"];
                       $t11 = $row1["frequency"];
                       $color = "";

                       //retrieve the form type name from the table
                       $qur0351 = mysqli_query($db, "SELECT * FROM `form_type` where form_type_id = '$form_type'");
                       $rowc0351 = mysqli_fetch_array($qur0351);
                       $form_type_name = $rowc0351['form_type_name'];

                       //retrieve the part family name from the table
                       $qur0352 = mysqli_query($db, "SELECT * FROM `pm_part_family` where pm_part_family_id = '$part_family' ");
                       $rowc0352 = mysqli_fetch_array($qur0352);
                       $part_family_name = $rowc0352['part_family_name'];

                       //retrieve the part number and part name from the table
                       $qur0353 = mysqli_query($db, "SELECT * FROM `pm_part_number` where pm_part_number_id = '$part_number'  ");
                       $rowc0353 = mysqli_fetch_array($qur0353);
                       $part_number = $rowc0353['part_number'];
                       $part_name = $rowc0353['part_name'];

                       $arrteam1 = explode(':', $t11);
                       $hours = $arrteam1[0];
                       $minutes = $arrteam1[1];
                       $hours1 = $hours * 60;
                       $minutes1 = $minutes + $hours1;
                       $date = $rowc["created_at"];
                       $date = strtotime($date);
                       $date = strtotime("+" . $minutes1 . " minute", $date);
                       $date = date('Y-m-d H:i:s', $date);
                       $working_from_time = $rowc["created_at"];
                       $calcdatet = strtotime($date);
                       $calccurrdate = strtotime($curdate);
                   ?>
                       <h3 class="no-margin dashboard_line_heading">Parameter Sheet</h3>
                       <input type="hidden" id="id<?php echo $countervariable; ?>" value="<?php echo $date; ?>">
                       <input type="hidden" id="working_from_time<?php echo $countervariable; ?>" value="<?php echo $working_from_time; ?>">
                       <div class="caption text-center"><!--style="border: 1px solid lightgray;"-->

                           <h4 style="text-align: center;padding:5px; color: #FFFFFF"">
                           <?php if ($date != "") { ?>
                               <div id="demo<?php echo $countervariable; ?>" >&nbsp;</div>
                           <?php } else { ?>
                               <div id="demo<?php echo $countervariable; ?>" >Available</div>
                           <?php } ?>
                           </h4>
                       </div>
                       <script>
                           function calcTime(city, offset) {
                               d = new Date();
                               utc = d.getTime() + (d.getTimezoneOffset() * 60000);
                               nd = new Date(utc + (3600000 * offset));
                               return nd;
                           }
                           // Set the date we're counting down to
                           var iddd<?php echo $countervariable; ?> = $("#id<?php echo $countervariable; ?>").val();

                           var working_from_time<?php echo $countervariable; ?> = $("#working_from_time<?php echo $countervariable; ?>").val();

                           //console.log(iddd<?php /* echo $countervariable;*/ ?>);
                           var countDownDate<?php echo $countervariable; ?> = new Date(iddd<?php echo $countervariable; ?>).getTime();

                           var countDownworkingDate<?php echo $countervariable; ?> = new Date(working_from_time<?php echo $countervariable; ?>).getTime();

                           // Update the count down every 1 second
                           var x = setInterval(function () {
                               // Get today's date and time
                               // var now = new Date().getTime();
                               var now = calcTime('Chicago', '-6');
                               // Find the distance between now and the count down date
                               //aaya change karvano che
                               var distance = countDownDate<?php echo $countervariable; ?> - now;
                               // Time calculations for days, hours, minutes and seconds
                               var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                               var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                               var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                               var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                               // console.log(days + "d " + hours + "h " + minutes + "m " + seconds + "s ");
                               //  console.log("------------------------");
                               // Output the result in an element with id="demo"
                               document.getElementById("demo<?php echo $countervariable; ?>").innerHTML = 'Submit in: ' + hours + "h "
                                   + minutes + "m " + seconds + "s ";
                               document.getElementById("demo<?php echo $countervariable; ?>").style.backgroundColor = 'green';
                               // If the count down is over, write some text
                               if (distance <= 0) {
                                   // clearInterval(x);
                                   var workingdistance = now - countDownworkingDate<?php echo $countervariable; ?>;
                                   var workingdays = Math.floor(workingdistance / (1000 * 60 * 60 * 24));
                                   var workinghours = Math.floor((workingdistance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                   var workingminutes = Math.floor((workingdistance % (1000 * 60 * 60)) / (1000 * 60));
                                   var workingseconds = Math.floor((workingdistance % (1000 * 60)) / 1000);

                                   document.getElementById("demo<?php echo $countervariable; ?>").innerHTML = 'Expired: ' + workingdays + "d " + workinghours + "h "
                                       + workingminutes + "m " + workingseconds + "s ";
                                   document.getElementById("demo<?php echo $countervariable; ?>").style.backgroundColor = 'red';
                               }
                           }, 1000);
                       </script>
                       <?php
                       $form_type_name = "";
                       $part_family_name = "";
                       $part_number = "";
                       $part_name = "";
                       $buttonclass = "218838";
                       $date = "";
                       ?>
                       <?php
                       $ratecheck = "";
                   }
                   ?>
               </div>
           </div>
       </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="heading" style="height: 40px;">
            <h4 style="height:inherit;text-align: center;background-color:#181d50;color: #fff;padding-top: 5px;">
                <div style="margin-top: fill!important;padding: 0px 0px 0px 0px;">
                    <span style="padding: 0px 0px 0px 0px;text-align: center;">&nbsp;LINE UTILIZATION STATUS</span>
                </div>
            </h4>
        </div>
        <div id="container" style="height: 350px;" > </div>
    </div>
    <div class="col-md-4">
        <div class="heading" style="height: 40px;">
            <h4 style="height:inherit;text-align: center;background-color:#181d50;color: #fff;padding-top: 5px;">
                <div style="margin-top: fill!important;padding: 0px 0px 0px 0px;">
                    <span style="padding: 0px 0px 0px 0px;text-align: center;">&nbsp;GOOD PIECES , BAD PIECES & REWORK</span>
                </div>
            </h4>
        </div>
        <div id="sgf_container" style="height: 350px;" > </div>
    </div>
    <div class="col-md-4">
        <div class="heading" style="height: 40px;">
            <h4 style="height:inherit;text-align: center;background-color:#181d50;color: #fff;padding-top: 5px;">
                <div style="margin-top: fill!important;padding: 0px 0px 0px 0px;">
                    <span style="padding: 0px 0px 0px 0px;text-align: center;">&nbsp;CURRENT STAFF EFFICIENCY</span>

                </div>
            </h4>
        </div>
        <div id="eff_container" style="height: 350px;"> </div>
    </div>
</div>
</div>
</form>
</div>
<script>
    //daily data
    anychart.onDocumentReady(function () {
        var data = $("#daily_data").serialize();
        $.ajax({
            type: 'POST',
            url: 'line_count_daily.php',
            data: data,
            success: function (data1) {
                var data = JSON.parse(data1);
                // console.log(data);
                var line_up = data.posts.map(function (elem) {
                    return elem.line_up;
                });
                var line_down = data.posts.map(function (elem) {
                    return elem.line_down;
                });
                var eof = data.posts.map(function (elem) {
                    return elem.eof;
                });
                var others = data.posts.map(function (elem) {
                    return elem.others;
                });
                var d = data.posts.map(function (elem) {
                    return elem.d;
                });
                var dh = data.posts.map(function (elem) {
                    return elem.dh;
                });

                var data = [
                    {x: 'Line-Up', value: line_up, fill: '#177b09'},
                    {x: 'Line-Down', value: line_down, fill: '#FF0000'},
                    {x: 'Eop', value: eof, fill: '#000000'},
                    {x: 'Others', value: others, fill: '#E7BF23'},
                ];
                // create pareto chart with data
                var chart = anychart.pie();


                // enable html for the legend
                chart.legend().useHtml(true);

                // configure the format of legend items
                chart.legend().itemsFormat(
                    "<span style='color:#455a64;font-weight:600'>" +
                    "{%x}:</span> {%value}Hr"
                );

                // set the chart title
                chart.title("Daily Utilization Data " + '<div style=\'color:#333; font-size: 14px;\'>Date : <span style="color:#009900; font-size: 12px;"><strong> ' +d+' </strong></span></div><br>'  +
                    '<div style=\'color:#333; font-size: 14px;\'>Total Hours: <span style="color:#009900; font-size: 12px;"><strong> ' +dh+' </strong></span>Hrs</div>');

                chart
                    .title()
                    .useHtml(true)
                    .padding(0)
                    .fontColor('#212121')
                    .hAlign('center')
                    .margin([0, 0, 10, 0]);

                // add the data
                chart.data(data);

                // set legend position
                chart.legend().position("right");
                // set items layout
                chart.legend().itemsLayout("vertical");

                // display the chart in the container
                chart.container('container');
                chart.draw();
            }
        });

    });
    //Top 5 Defect Details
    anychart.onDocumentReady(function () {
        var data = $("#daily_data").serialize();
        $.ajax({
            type: 'POST',
            url: 'good_bad_piece_count.php',
            // dataType: 'good_bad_piece_fa.php',
            data: data,
            success: function (data1) {
                var data = JSON.parse(data1);
                // console.log(data);
                var good_pieces = data.posts.map(function (elem) {
                    return elem.good_pieces;
                });
                // console.log(goodpiece);
                var bad_pieces = data.posts.map(function (elem) {
                    return elem.bad_pieces;
                });
                var rework = data.posts.map(function (elem) {
                    return elem.rework;
                });
                var bsr = data.posts.map(function (elem) {
                    return elem.bsr;
                });
                var actual_bsr = data.posts.map(function (elem) {
                    return elem.actual_bsr;
                });
                var data = [
                    {x: 'Good', value: good_pieces, fill: '#177b09'},
                    {x: 'Bad', value: bad_pieces, fill: '#BE0E31'},
                    {x: 'Rework', value: rework, fill: '#2643B9'},

                ];
                // create pareto chart with data
                var chart = anychart.column(data);
                // set chart title text settings
                // chart.title('Good Pieces & Bad Pieces');
                chart.title().enabled(true).useHtml(true).text('<div style=\'color:#000000; font-size: 14px;\'>Budget Scrap Rate -  <span style="color:#000000; font-size: 14px;"><strong>'+bsr  + '</strong>%</span></div><br><div style=\'color:#000000; font-size: 14px;\'>Actual Scrap Rate - <span style="color:#000000; font-size: 14px;"><strong>'+actual_bsr +'</strong>%</span></div>').hAlign("left");

                // disable x axis title
                chart.xAxis().title().enabled(false);

                 /* var title = chart.title();
                  title.enabled(true);
  //enables HTML tags
                  title.useHtml(true);
                  title.text(
                      "<br><div style=\'color:#333; font-size: 14px; text-align: left;\'>Budget Scrap Rate - </div><br>"+bsr
                  );*/

                // set measure y axis title
                // chart.yAxis(0).title('Numbers');
                // cumulative percentage y axis title
                // chart.yAxis(1).title(' Percentage');
                // set interval
                // chart.yAxis(1).scale().ticks().interval(10);

                // get pareto column series and set settings
                var column = chart.getSeriesAt(0);

                column.labels().enabled(true).format('{%Value}');
                column.tooltip().format('Value: {%Value}');

                var labels = column.labels();
                labels.fontFamily("Courier");
                labels.fontSize(24);
                labels.fontColor("#125393");
                labels.fontWeight("bold");
                labels.useHtml(false);
                // // background border color
                // column.labels().background().stroke("#663399");
                // column.labels().background().enabled(true).stroke("Green");

                var xLabelsBackground = column.labels().background();
                xLabelsBackground.enabled(true);
                xLabelsBackground.stroke("#cecece");
                xLabelsBackground.cornerType("round");
                xLabelsBackground.corners(5);


                var labels = chart.xAxis().labels();
                labels.fontFamily("Courier");
                labels.fontSize(18);
                labels.fontColor("#125393");
                labels.fontWeight("bold");
                labels.useHtml(false);
                // // background border color
                // column.labels().background().stroke("#663399");
                // column.labels().background().enabled(true).stroke("Green");

                var xLabelsBackground = chart.xAxis().labels().background();
                xLabelsBackground.enabled(true);
                xLabelsBackground.stroke("#cecece");
                xLabelsBackground.cornerType("round");
                xLabelsBackground.corners(5);

                //
                // // get pareto line series and set settings
                // var line = chart.getSeriesAt(1);
                // line
                //     .tooltip()
                //     // .format('Good Pieces: {%CF}% \n Bad Pieces: {%RF}%');
                //     .format('Percent : {%RF}%');
                //
                // // turn on the crosshair and set settings
                // chart.crosshair().enabled(true).xLabel(false);
                // chart.xAxis().labels().rotation(-90);

                // set container id for the chart
                chart.container('sgf_container');
                // initiate chart drawing
                chart.draw();
            }
        });
    });

    //Efficiency
    anychart.onDocumentReady(function () {
        var data = $("#daily_data").serialize();
        $.ajax({
            type: 'POST',
            url: 'station_staff_eff.php',
            // dataType: 'good_bad_piece_fa.php',
            data: data,
            success: function (data1) {
                var data = JSON.parse(data1);
                // console.log(data);
                var target_eff = data.posts.map(function (elem) {
                    return elem.target_eff;
                });
                // console.log(goodpiece);
                // var avg_npr = data.posts.map(function (elem) {
                //     return elem.avg_npr;
                // });
                var actual_eff = data.posts.map(function (elem) {
                    return elem.actual_eff;
                });

                var eff = data.posts.map(function (elem) {
                    return elem.eff;
                });
                // var range1 = avg_npr;
                var range1 = actual_eff;
                var range2 = target_eff;
                var range3 = eff;

                var fill3 = '#009900 0.8';
                var fill2 = '#B31B1B 0.8';
                var fill1 = '#B31B1B 0.8';

                var maxr3 =  parseFloat(range2) + parseFloat(range2 * .2)


                if((actual_eff >= target_eff)){
                    range1 = target_eff;
                    // range2 = avg_npr;
                    range2 = actual_eff;
                    fill1 = '#009900 0.8';
                    fill2 = '#009900 0.8';
                    fill3 = '#B31B1B 0.8';
                    maxr3 =  parseFloat(target_eff) + parseFloat(target_eff * .2)
                }

                var gauge = anychart.gauges.circular();
                gauge
                    .fill('#fff')
                    .stroke(null)
                    .padding(40)
                    .margin(0)
                    .startAngle(270)
                    .sweepAngle(180);

                gauge
                    .axis()
                    .labels()
                    .padding(5)
                    .fontSize(20)
                    .position('outside')
                    .format('{%Value}');

                gauge.data([actual_eff]);
                gauge
                    .axis()
                    .scale()
                    .minimum(0)
                    .maximum(maxr3)
                    .ticks({ interval: 1 })
                    .minorTicks({ interval: 1 });

                gauge
                    .axis()
                    .fill('#545f69')
                    .width(1)
                    .ticks({ type: 'line', fill: 'white', length: 2 });

                gauge.title(
                    '<div style=\'color:#333; font-size: 20px;\'>Target Pieces: <span style="color:#009900; font-size: 22px;"><strong> ' +target_eff+' </strong><l/span></div>' +
                    '<br/><br/><div style=\'color:#333; font-size: 20px;\'>Actual Pieces: <span style="color:#009900; font-size: 22px;"><strong> ' +actual_eff+' </strong></span></div><br/><br/>' +
                    '<div style=\'color:#333; font-size: 20px;\'>Efficiency: <span style="color:#009900; font-size: 22px;"><strong> ' +eff+' </strong>%</span></div><br/><br/>'
                );
                gauge
                    .title()
                    .useHtml(true)
                    .padding(0)
                    .fontColor('#212121')
                    .hAlign('center')
                    .margin([0, 0, 10, 0]);

                gauge
                    .needle()
                    .stroke('2 #545f69')
                    .startRadius('5%')
                    .endRadius('90%')
                    .startWidth('0.1%')
                    .endWidth('0.1%')
                    .middleWidth('0.1%');

                gauge.cap().radius('3%').enabled(true).fill('#545f69');

                gauge.range(0, {
                    from: 0,
                    to: range1,
                    position: 'inside',
                    fill: fill1,
                    startSize: 50,
                    endSize: 50,
                    radius: 98
                });

                gauge.range(1, {
                    from: range1,
                    to: range2,
                    position: 'inside',
                    fill: fill2,
                    startSize: 50,
                    endSize: 50,
                    radius: 98
                });

                gauge.range(2, {
                    from: range2,
                    to: (maxr3),
                    position: 'inside',
                    fill: '#009900 0.8',
                    startSize: 50,
                    endSize: 50,
                    radius: 98

                });

                gauge
                    .label(1)
                    .text('')
                    .fontColor('#212121')
                    .fontSize(20)
                    .offsetY('68%')
                    .offsetX(25)
                    .anchor('center');
                gauge
                    .label(2)
                    .text('')
                    .fontColor('#212121')
                    .fontSize(20)
                    .offsetY('68%')
                    .offsetX(90)
                    .anchor('center');

                gauge
                    .label(3)
                    .text('')
                    .fontColor('#212121')
                    .fontSize(20)
                    .offsetY('68%')
                    .offsetX(155)
                    .anchor('center');


                // set container id for the chart
                gauge.container('eff_container');
                // initiate chart drawing
                gauge.draw();
            }
        });
    });
</script>
<script>
    setTimeout(function () {
        //alert("reload");
        location.reload();
    }, 60000);
</script>
<?php include("footer.php"); ?>
</body>
</html>
