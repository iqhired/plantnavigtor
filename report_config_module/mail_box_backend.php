<?php
include("../config.php");
$mail_box_check = $_POST['mail_box'];
$mail_box_is_checked = $_POST['isChecked'];
if ($mail_box_check != "") {
    if($mail_box_is_checked =='true') {
        $sql1 = "UPDATE  `sg_email_report_config` set  mail_box = 1  WHERE `sg_mail_report_config_id`='$mail_box_check'";
    }else{
        $sql1 = "UPDATE  `sg_email_report_config` set  mail_box = 0  WHERE `sg_mail_report_config_id`='$mail_box_check'";
    }
    if (mysqli_query($db, $sql1)) {
        $_SESSION['message_stauts_class'] = 'alert-success';
        $_SESSION['import_status_message'] = 'Required Sucessfully';
    } else {
        $_SESSION['message_stauts_class'] = 'alert-danger';
        $_SESSION['import_status_message'] = 'please retry.';
    }
}

header("Location:line.php");
?>
