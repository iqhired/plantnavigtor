<?php
ini_set('display_errors', false);
include("../config.php");
$chicagotime = date('d-m-Y', strtotime('-1 days'));
$tboardName ='';
$subject = "Daily Mail Report";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';
//main query
$mainquery = sprintf("SELECT * FROM  tm_task_log_config ");
$mainqur = mysqli_query($db, $mainquery);
while ($mainrowc = mysqli_fetch_array($mainqur)) {
	$mail = new PHPMailer();
	$mail->isSMTP();
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 587;
	$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
	$mail->SMTPAuth = true;
	$mail->Username = EMAIL_USER;
	$mail->Password = EMAIL_PASSWORD;
	$mail->setFrom('admin@plantnavigator.com', 'admin@plantnavigator.com');

	$taskboard_id = $mainrowc["taskboard"];
// taskboard name
    $namequr = mysqli_query($db, "SELECT * FROM `sg_taskboard` where sg_taskboard_id = '$taskboard_id' ");
    $namerowc = mysqli_fetch_array($namequr);
    $taskboard_name = $namerowc["taskboard_name"];
//mail code starts from here
    $query = sprintf("SELECT * FROM  tm_task_log_config where taskboard = '$taskboard_id' ");
    $qur = mysqli_query($db, $query);
    while ($rowc = mysqli_fetch_array($qur)) {
        $group = explode(',', $rowc["teams"]);
        $arrusrs = explode(',', $rowc["users"]);
        $subject = $rowc["subject"];
        $message = $rowc["message"];
        $signature = $rowc["signature"];
    }
    $cnt = count($arrusrs);
    $structure = '<html><body>';
    $structure .= "<br/><br/><span style='font-family: 'Source Sans Pro', sans-serif;color:#757575;font-weight:600;' > Hello,</span><br/><br/>";
    $structure .= "<span style='font-family: 'Source Sans Pro', sans-serif;color:#757575;font-weight:600;' > " . $message . "</span><br/> ";
    $structure .= "<br/><br/>";
    $structure .= "- " . $signature;
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
    $mail->addAttachment('../daily_report/' . $chicagotime . '/' . $taskboard_name . '_Task_Log_' . $chicagotime . '.xls', $taskboard_name .'_Task_Log_' . $chicagotime . '.xls');
    //$mail->addAttachment('../daily_report/' . $chicagotime . '/Communicator_Log_' . $chicagotime . '.xls', 'Communicator_Log_' . $chicagotime . '.xls');

    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }
  
}
