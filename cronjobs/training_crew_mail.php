<?php
ini_set('display_errors', false);
include("../config.php");
$chicagotime = date('m-d-Y', strtotime('-1 days'));
$tboardName ='';
$subject = "Daily Mail Report";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';

//main query
$temp = "0";

$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->SMTPAuth = true;
$mail->Username = 'admin@plantnavigator.com';
$mail->Password = 'S@@rgummi_2022';
$mail->setFrom('admin@plantnavigator.com', 'admin@plantnavigator.com');

//mail code starts from here
    $query = sprintf("SELECT * FROM sg_email_report_config where sg_mail_report_name = 'Training Report'");
    $qur = mysqli_query($db, $query);
    while ($rowc = mysqli_fetch_array($qur)) {
        $group = explode(',', $rowc["teams"]);
        $arrusrs = explode(',', $rowc["users"]);
        $subject = $rowc["subject"];
        $message = $rowc["message"];
        $signature = $rowc["signature"];
        $mail_box = $rowc["mail_box"];
    }

    $cnt = count($arrusrs);

    $structure = '<html><body>';
    $structure .= "<br/><br/><span style='font-family: 'Source Sans Pro', sans-serif;color:#757575;font-weight:600;' > Hello,</span><br/><br/>";
    $structure .= "<span style='font-family: 'Source Sans Pro', sans-serif;color:#757575;font-weight:600;' > " . $message . "</span><br/> ";
    $structure .= "<br/><br/>";
    $structure .= '<br/><table rules="all" style="border-color: #666;" border="1" cellpadding="10">';
    $structure .= "<tr style='background: #eee;'><strong><td>Name</td><td>Joining Date</td><td>Station</td><td>Position</td><td>Total Hrs</td></strong></tr>";


    $mainquery = sprintf("SELECT * FROM `cam_users` where training = '1' ");
    $mainqur = mysqli_query($db, $mainquery);
    while ($mainrowc = mysqli_fetch_array($mainqur)) {

        $training_station = $mainrowc["training_station"];
        $training_position = $mainrowc["training_position"];
        $users_id = $mainrowc["users_id"];
        $fullname = $mainrowc["firstname"] . " " . $mainrowc["lastname"];
        $hiring_date = $mainrowc["hiring_date"];

// total time

        $qur06 = mysqli_query($db, "SELECT SEC_TO_TIME(SUM(`total_time`)) as time,SUM(`total_time`) AS sum FROM `cam_assign_crew_log` WHERE `user_id` = '$users_id' AND `station_id` = '$training_station' and `position_id` ='$training_position' ");
        $rowc06 = mysqli_fetch_array($qur06);
        $time = $rowc06["time"];
        $sum = $rowc06["sum"];

        if ($sum >= "864000") {

            $temp = "1";
//other details

            $namequr = mysqli_query($db, "SELECT * FROM  cam_line where line_id = '$training_station' ");
            $namerowc = mysqli_fetch_array($namequr);
            $line_name = $namerowc["line_name"];

            $namequr = mysqli_query($db, "SELECT * FROM  cam_position where position_id = '$training_position' ");
            $namerowc = mysqli_fetch_array($namequr);
            $position_name = $namerowc["position_name"];

            $structure .= "<tr><td>" . $fullname . "</td><td>" . $hiring_date . "</td><td>" . $line_name . "</td><td>" . $position_name . "</td><td>" . $time . "</td></tr>";

        }
    }

    $structure .= "</table>";
    $structure .= "<br/><br/>";
    $structure .= $signature;
    $structure .= "</body></html>";

    for ($i = 0; $i < $cnt;) {
        $u_name = $arrusrs[$i];
        if(!empty($u_name)) {
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
    if ($group != "") {
        $grpcnt = count($group);
        for ($i = 0; $i < $grpcnt;) {
            $grp = $group[$i];
            $query = sprintf("SELECT * FROM  sg_user_group where group_id = '$grp' ");
            $qur = mysqli_query($db, $query);
            while ($rowc = mysqli_fetch_array($qur)) {
                $u_name = $rowc['user_id'];
                if(!empty($u_name)) {
                    $query0003 = sprintf("SELECT * FROM  cam_users where users_id = '$u_name' ");
                    $qur0003 = mysqli_query($db, $query0003);
                    $rowc0003 = mysqli_fetch_array($qur0003);
                    $email = $rowc0003["email"];
                    $lasname = $rowc0003["lastname"];
                    $firstname = $rowc0003["firstname"];
                    $mail->addAddress($email, $firstname);
                }
            }
            $i++;
        }
    }
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $structure;
//    $mail->addAttachment('../daily_report/' . $chicagotime . '/' . $taskboard_name . '_Task_Log_' . $chicagotime . '.xls', $taskboard_name .'_Task_Log_' . $chicagotime . '.xls');
    //$mail->addAttachment('../daily_report/' . $chicagotime . '/Communicator_Log_' . $chicagotime . '.xls', 'Communicator_Log_' . $chicagotime . '.xls');

    if ($temp == "1") {
        if($mail_box == '1') {
        if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }else{
            echo 'success';
        }
        }

}

