<?php include("../config.php");
$curdate  = date("Y-m-d H:i:s");
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
    <title><?php echo $sitename; ?> | Taskboard Crew</title>
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
    <script type="text/javascript" src="../assets/js/libs/jquery-3.6.0.min.js"> </script>
    <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->
    <!-- Theme JS files -->
    <script type="text/javascript" src="../assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="../assets/js/pages/components_modals.js"></script>
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
            padding-top: 5px;
            font-size: 15px !important;
        }
        .heading{
            margin-top: 0px !important;
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
<!-- Page container -->
<div class="page-container">
    <!-- Page content -->
    <div class="page-content">
        <div class="panel panel-flat panel-full-height padding_top_50px">
            <div class="panel-heading">
                <div class="row">
                    <?php
                    $countervariable = 0;
                    //select the form based on station
                    $sql1 = "SELECT * FROM `form_user_data` WHERE `station` = '$station' and `form_type` = 4 order by created_at desc limit 1";
                    $result1 = $mysqli->query($sql1);
                    while ($rowc = $result1->fetch_assoc()) {
                    $form_create_id = $rowc["form_create_id"];
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
                    $buttonclass = "218838";

                            ?>
                    <div class="col-lg-3">
                        <div class="panel bg-blue-400">
                            <div class="panel-body">

                                <h3 class="no-margin dashboard_line_heading"><?php echo $form_type_name; ?></h3>
                                <hr/>
                                <input type="hidden" id="id<?php echo $countervariable; ?>" value="<?php echo $date; ?>">
                                <input type="hidden" id="working_from_time<?php echo $countervariable; ?>" value="<?php echo $working_from_time; ?>">
                                <table style="width:100%" id="t01">
                                    <tr>
                                        <td>
                                            <div style="padding-top: 5px;font-size: initial; wi">Part Family :
                                            </div>
                                        </td>
                                        <td>
                                            <div><?php echo $part_family_name;
                                                $pf_name = ''; ?> </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div style="padding-top: 5px;font-size: initial;">Part Number :
                                            </div>
                                        </td>
                                        <td><span><?php echo $part_number;
                                                $p_num = ''; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div style="padding-top: 5px;font-size: initial;">Part Name :</div>
                                        </td>
                                        <td><span><?php echo $part_name;
                                                $p_name = ''; ?></span></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="caption text-center" style="background-color:#122c5a;">
                                <h4 style="text-align: center;padding:5px; background-color:#<?php echo $buttonclass; ?>">
                                    <?php if ($date != "") { ?>
                                        <div id="demo<?php echo $countervariable; ?>" style="color: #d6d8db;">&nbsp;</div>
                                    <?php } else { ?>
                                        <div id="demo<?php echo $countervariable; ?>" style="color: #d6d8db">Available</div>
                                    <?php } ?>
                                </h4>
                            </div>
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
                                    // If the count down is over, write some text
                                    if (distance <= 0) {
                                        // clearInterval(x);
                                        var workingdistance = now - countDownworkingDate<?php echo $countervariable; ?>;
                                        var workinghours = Math.floor((workingdistance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                        var workingminutes = Math.floor((workingdistance % (1000 * 60 * 60)) / (1000 * 60));
                                        var workingseconds = Math.floor((workingdistance % (1000 * 60)) / 1000);

                                        document.getElementById("demo<?php echo $countervariable; ?>").innerHTML = 'Expired: ' + workinghours + "h "
                                            + workingminutes + "m " + workingseconds + "s ";
                                    }
                                }, 1000);
                            </script>
                            <?php  $countervariable++; ?>
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
                    <?php
                    //select the form based on station
                    $sql1 = "SELECT * FROM `form_user_data` WHERE `station` = '$station' and `form_type` = 5 order by created_at desc limit 1";
                    $result1 = $mysqli->query($sql1);
                    while ($rowc = $result1->fetch_assoc()) {
                    $form_create_id = $rowc["form_create_id"];
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
                    $buttonclass = "218838";

                    ?>
                    <div class="col-lg-3">
                        <div class="panel bg-blue-400">
                            <div class="panel-body">
                                <h3 class="no-margin dashboard_line_heading"><?php echo $form_type_name; ?></h3>
                                <hr/>
                                <input type="hidden" id="id<?php echo $countervariable; ?>" value="<?php echo $date; ?>">
                                <input type="hidden" id="working_from_time<?php echo $countervariable; ?>" value="<?php echo $working_from_time; ?>">
                                <table style="width:100%" id="t01">
                                    <tr>
                                        <td>
                                            <div style="padding-top: 5px;font-size: initial; wi">Part Family :
                                            </div>
                                        </td>
                                        <td>
                                            <div><?php echo $part_family_name;
                                                $pf_name = ''; ?> </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div style="padding-top: 5px;font-size: initial;">Part Number :
                                            </div>
                                        </td>
                                        <td><span><?php echo $part_number;
                                                $p_num = ''; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div style="padding-top: 5px;font-size: initial;">Part Name :</div>
                                        </td>
                                        <td><span><?php echo $part_name;
                                                $p_name = ''; ?></span></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="caption text-center" style="background-color:#122c5a;">
                                <h4 style="text-align: center;padding:5px; background-color:#<?php echo $buttonclass; ?>">
                                    <?php if ($date != "") { ?>
                                        <div id="demo<?php echo $countervariable; ?>" style="color: #d6d8db;">&nbsp;</div>
                                    <?php } else { ?>
                                        <div id="demo<?php echo $countervariable; ?>" style="color: #d6d8db">Available</div>
                                    <?php } ?>
                                </h4>
                            </div>
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
                                // If the count down is over, write some text
                                if (distance <= 0) {
                                    // clearInterval(x);
                                    var workingdistance = now - countDownworkingDate<?php echo $countervariable; ?>;
                                    var workinghours = Math.floor((workingdistance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                    var workingminutes = Math.floor((workingdistance % (1000 * 60 * 60)) / (1000 * 60));
                                    var workingseconds = Math.floor((workingdistance % (1000 * 60)) / 1000);

                                    document.getElementById("demo<?php echo $countervariable; ?>").innerHTML = 'Expired: ' + workinghours + "h "
                                        + workingminutes + "m " + workingseconds + "s ";

                                }
                            }, 1000);
                        </script>
                        <?php  $countervariable++; ?>
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
                    <?php
                    //select the form based on station
                    $sql1 = "SELECT * FROM `form_user_data` WHERE `station` = '$station' and `form_type` = 3 order by created_at desc limit 1";
                    $result1 = $mysqli->query($sql1);
                    while ($rowc = $result1->fetch_assoc()) {
                    $form_create_id = $rowc["form_create_id"];
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
                    $buttonclass = "218838";

                    ?>
                    <div class="col-lg-3">
                        <div class="panel bg-blue-400">
                            <div class="panel-body">

                                <h3 class="no-margin dashboard_line_heading"><?php echo $form_type_name; ?></h3>
                                <hr/>
                                <input type="hidden" id="id<?php echo $countervariable; ?>" value="<?php echo $date; ?>">
                                <input type="hidden" id="working_from_time<?php echo $countervariable; ?>" value="<?php echo $working_from_time; ?>">
                                <table style="width:100%" id="t01">
                                    <tr>
                                        <td>
                                            <div style="padding-top: 5px;font-size: initial; wi">Part Family :
                                            </div>
                                        </td>
                                        <td>
                                            <div><?php echo $part_family_name;
                                                $pf_name = ''; ?> </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div style="padding-top: 5px;font-size: initial;">Part Number :
                                            </div>
                                        </td>
                                        <td><span><?php echo $part_number;
                                                $p_num = ''; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div style="padding-top: 5px;font-size: initial;">Part Name :</div>
                                        </td>
                                        <td><span><?php echo $part_name;
                                                $p_name = ''; ?></span></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="caption text-center" style="background-color:#122c5a;">
                                <h4 style="text-align: center;padding:5px; background-color:#<?php echo $buttonclass; ?>">
                                    <?php if ($date != "") { ?>
                                        <div id="demo<?php echo $countervariable; ?>" style="color: #d6d8db">&nbsp;</div>
                                    <?php } else { ?>
                                        <div id="demo<?php echo $countervariable; ?>" style="color: #d6d8db">Available</div>
                                    <?php } ?>
                                </h4>
                            </div>
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
                                // If the count down is over, write some text
                                if (distance <= 0) {
                                    // clearInterval(x);
                                    var workingdistance = now - countDownworkingDate<?php echo $countervariable; ?>;
                                    var workinghours = Math.floor((workingdistance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                    var workingminutes = Math.floor((workingdistance % (1000 * 60 * 60)) / (1000 * 60));
                                    var workingseconds = Math.floor((workingdistance % (1000 * 60)) / 1000);

                                    document.getElementById("demo<?php echo $countervariable; ?>").innerHTML = 'Expired: ' + workinghours + "h "
                                        + workingminutes + "m " + workingseconds + "s ";
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
    <!-- /page content -->
</div>
    <!--<script>
        setTimeout(function () {
            //alert("reload");
            location.reload();
        }, 30000);
    </script>-->
<!-- /page container -->
</body>
<?php include('../footer.php') ?>
</html>
