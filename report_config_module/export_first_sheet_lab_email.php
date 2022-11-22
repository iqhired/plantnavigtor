<?php
ini_set('display_errors', false);
include("../config.php");
$chicagotime = date('m-d-Y', strtotime('-1 days'));
$subject = "Daily Mail Report";
require '../vendor/autoload.php';
include ("../email_config.php");
$query = sprintf("SELECT * FROM sg_email_report_config where sg_mail_report_name = 'First Piece Sheet Report'");
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
    $structure .= "- " . $signature;
    $structure .= "</body></html>";
    for ($i = 0; $i < $cnt;) {
        $u_name = $arrusrs[$i];
        $query0003 = sprintf("SELECT * FROM  cam_users where users_id = '$u_name' ");
        $qur0003 = mysqli_query($db, $query0003);
        $rowc0003 = mysqli_fetch_array($qur0003);
        $email = $rowc0003["email"];
        $lasname = $rowc0003["lastname"];
        $firstname = $rowc0003["firstname"];
        $mail->addAddress($email, $firstname);
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
    }
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $structure;
//$mail->addAttachment('./daily_report/'.$chicagotime.'/Communicator_Log_'.$chicagotime.'.xls', 'Communicator_Log_'.$chicagotime.'.xls');
    $mail->addAttachment("../daily_report/" . $chicagotime . "/First_Piece_Sheet_Submit_Log_" . $chicagotime . ".xls");
if($mail_box == '1') {
    if(!$mail->Send()){
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
    else{
        echo "Message has been sent";
    }
}
    function save_mail($mail)
    {
        $path = '{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail';
        $imapStream = imap_open($path, $mail->Username, $mail->Password);
        $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
        imap_close($imapStream);
        return $result;

}
