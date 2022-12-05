<?php include("../config.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
$f_time  = date("H:i");
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

                    if($date == $curdate){
                        $sqlv = "INSERT INTO `form_frequency_data`(`form_create_id`, `form_user_data_id`, `time`,`updated_at`) VALUES ('$form_create_id','$form_user_data_id','$f_time','$curdate')";
                        $res = mysqli_query($db, $sqlv);
                        if (!$res) {
                            $_SESSION['message_stauts_class'] = 'alert-danger';
                            $_SESSION['import_status_message'] = 'Please Fill Pin';
                        }
                        else{
                            $_SESSION['message_stauts_class'] = 'alert-success';
                            $_SESSION['import_status_message'] = 'Form Frequency Updated Successfully.';
                        }
                    }

                    $qur0354 = mysqli_query($db, "select date_add(updated_at,interval 30 minute) as updated_at from `form_frequency_data` where form_create_id = '$form_create_id' order by updated_at desc limit 1");
                    $rowc0354 = mysqli_fetch_array($qur0354);
                    $updated_at = $rowc0354['updated_at'];
                    if($updated_at == $curdate)
                    {
                        require '../vendor/autoload.php';
                        $mail = new PHPMailer();
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->Port = 587;
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->SMTPAuth = true;
                        $mail->Username = EMAIL_USER;
                        $mail->Password = EMAIL_PASSWORD;
                        $mail->setFrom('admin@plantnavigator.com', 'Admin Plantnavigator');
                        $subject = "Not Fill Form Within Frequency Time Mail Report";
                        $query = sprintf("SELECT * FROM `form_create` where form_create_id = '$form_create_id'");
                        $qur = mysqli_query($db, $query);
                        while ($rowc1 = mysqli_fetch_array($qur)) {
                            $arrusrs = explode(',', $rowc1["notification_list"]);
                        }
                        $message = '<br/><table rules=\"all\" style=\"border-color: #666;\" border=\"1\" cellpadding=\"10\">';
                        $message .= "<tr><td style='background: #eee;padding: 5px 10px ;'><strong>Form Name : </strong> </td><td>" . $form_type_name . "</td></tr>";
                        $message .= "<tr><td style='background: #eee;padding: 5px 10px ;'><strong>Station : </strong> </td><td>" . $station2 . "</td></tr>";
                        $message .= "<tr><td style='background: #eee;padding: 5px 10px ;'><strong>Part Number : </strong> </td><td>" . $part_number . "</td></tr>";
                        $message .= "<tr><td style='background: #eee;padding: 5px 10px ;'><strong>Part Name : </strong> </td><td>" . $part_name . "</td></tr>";
                        $message .= "<tr><td style='background: #eee;padding: 5px 10px ;'><strong>Part Family : </strong> </td><td>" . $part_family_name . "</td></tr>";
                        $message .= "</table>";
                        $message .= "<br/>";
                        $signature = "- Plantnavigator Admin";
                        $cnt = count($arrusrs);
                        $structure = '<html><body>';
                        $structure .= "<br/><br/><span style='font-family: 'Source Sans Pro', sans-serif;color:#757575;font-weight:600;' > Hello,</span><br/><br/>";
                        $structure .= "<span style='font-family: 'Source Sans Pro', sans-serif;color:#757575;font-weight:600;' > " . $message . "</span><br/> ";
                        $structure .= "<br/><br/>";
                        $structure .= $signature;
                        $structure .= "</body></html>";
                        for ($i = 0; $i < $cnt;) {
                            $u_name = $arrusrs[$i];
                            if(!empty($u_name)){
                                $query0003 = sprintf("SELECT * FROM  cam_users where users_id = '$u_name' ");
                                $qur0003 = mysqli_query($db, $query0003);
                                $rowc0003 = mysqli_fetch_array($qur0003);
                                $email = $rowc0003["email"];
                                $lasname = $rowc0003["lastname"];
                                $firstname = $rowc0003["firstname"];
                                $mail->addAddress($email, $firstname);

                            }
                            $i++;
                        }
                        $mail->isHTML(true);
                        $mail->Subject = $subject;
                        $mail->Body = $structure;
                            if(!$mail->Send()){
                                echo "Mailer Error: " . $mail->ErrorInfo;
                            }
                            else{
                                echo "  ";
                            }

                        function save_mail($mail)
                        {
                            $path = '{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail';
                            $imapStream = imap_open($path, $mail->Username, $mail->Password);
                            $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
                            imap_close($imapStream);
                            return $result;

                        }

                    }

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
                            <div class="caption text-center">
                                <h4 style="text-align: center;padding:5px;">
                                    <?php if ($date != "") { ?>
                                        <div id="demo<?php echo $countervariable; ?>">&nbsp;</div>
                                    <?php } else { ?>
                                        <div id="demo<?php echo $countervariable; ?>">Available</div>
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
                                    document.getElementById("demo<?php echo $countervariable; ?>").style.backgroundColor = 'green';
                                    // If the count down is over, write some text
                                    if (distance <= 0) {
                                        // clearInterval(x);
                                        var workingdistance = now - countDownworkingDate<?php echo $countervariable; ?>;
                                        var workinghours = Math.floor((workingdistance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                        var workingminutes = Math.floor((workingdistance % (1000 * 60 * 60)) / (1000 * 60));
                                        var workingseconds = Math.floor((workingdistance % (1000 * 60)) / 1000);

                                        document.getElementById("demo<?php echo $countervariable; ?>").innerHTML = 'Expired: ' + workinghours + "h "
                                            + workingminutes + "m " + workingseconds + "s ";
                                        document.getElementById("demo<?php echo $countervariable; ?>").style.backgroundColor = 'red';
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

                    if($date == $curdate){
                        $sqlv = "INSERT INTO `form_frequency_data`(`form_create_id`, `form_user_data_id`, `updated_at`) VALUES ('$form_create_id','$form_user_data_id','$curdate')";
                        $res = mysqli_query($db, $sqlv);
                        if (!$res) {
                            $_SESSION['message_stauts_class'] = 'alert-danger';
                            $_SESSION['import_status_message'] = 'Please Fill Pin';
                        }
                        else{
                            $_SESSION['message_stauts_class'] = 'alert-success';
                            $_SESSION['import_status_message'] = 'Form Frequency Updated Successfully.';
                        }
                    }

                    $qur0354 = mysqli_query($db, "SELECT * FROM `form_frequency_data` where form_create_id = '$form_create_id' order by updated_at desc limit 1");
                    $rowc0354 = mysqli_fetch_array($qur0354);
                    $updated_at = $rowc0354['updated_at'];


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
                            <div class="caption text-center">
                                <h4 style="text-align: center;padding:5px;text-color:#FFFFFF;">
                                    <?php if ($date != "") { ?>
                                        <div id="demo<?php echo $countervariable; ?>" >&nbsp;</div>
                                    <?php } else { ?>
                                        <div id="demo<?php echo $countervariable; ?>" >Available</div>
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
                                document.getElementById("demo<?php echo $countervariable; ?>").style.backgroundColor = 'green';
                                // If the count down is over, write some text
                                if (distance <= 0) {
                                    // clearInterval(x);
                                    var workingdistance = now - countDownworkingDate<?php echo $countervariable; ?>;
                                    var workinghours = Math.floor((workingdistance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                    var workingminutes = Math.floor((workingdistance % (1000 * 60 * 60)) / (1000 * 60));
                                    var workingseconds = Math.floor((workingdistance % (1000 * 60)) / 1000);

                                    document.getElementById("demo<?php echo $countervariable; ?>").innerHTML = 'Expired: ' + workinghours + "h "
                                        + workingminutes + "m " + workingseconds + "s ";
                                    document.getElementById("demo<?php echo $countervariable; ?>").style.backgroundColor = 'red';

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

                    if($date == $curdate){
                        $sqlv = "INSERT INTO `form_frequency_data`(`form_create_id`, `form_user_data_id`, `updated_at`) VALUES ('$form_create_id','$form_user_data_id','$curdate')";
                        $res = mysqli_query($db, $sqlv);
                        if (!$res) {
                            $_SESSION['message_stauts_class'] = 'alert-danger';
                            $_SESSION['import_status_message'] = 'Please Fill Pin';
                        }
                        else{
                            $_SESSION['message_stauts_class'] = 'alert-success';
                            $_SESSION['import_status_message'] = 'Form Frequency Updated Successfully.';
                        }
                    }
                    $qur0354 = mysqli_query($db, "SELECT * FROM `form_frequency_data` where form_create_id = '$form_create_id' order by updated_at desc limit 1");
                    $rowc0354 = mysqli_fetch_array($qur0354);
                    $updated_at = $rowc0354['updated_at'];




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
                            <div class="caption text-center">
                                <h4 style="text-align: center;padding:5px; ">
                                    <?php if ($date != "") { ?>
                                        <div id="demo<?php echo $countervariable; ?>" >&nbsp;</div>
                                    <?php } else { ?>
                                        <div id="demo<?php echo $countervariable; ?>" >Available</div>
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
                                document.getElementById("demo<?php echo $countervariable; ?>").style.backgroundColor = 'green';
                                // If the count down is over, write some text
                                if (distance <= 0) {
                                    // clearInterval(x);
                                    var workingdistance = now - countDownworkingDate<?php echo $countervariable; ?>;
                                    var workinghours = Math.floor((workingdistance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                    var workingminutes = Math.floor((workingdistance % (1000 * 60 * 60)) / (1000 * 60));
                                    var workingseconds = Math.floor((workingdistance % (1000 * 60)) / 1000);

                                    document.getElementById("demo<?php echo $countervariable; ?>").innerHTML = 'Expired: ' + workinghours + "h "
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
    <!-- /page content -->
</div>
    <?php

    ?>
    <script>
        setTimeout(function () {
            location.reload();
        }, 5000);
    </script>
<!-- /page container -->
</body>
<?php include('../footer.php') ?>
</html>
