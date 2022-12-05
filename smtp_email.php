<?php
ini_set('display_errors', false);
include("config.php");
include ("email_config.php");
$chicagotime = date("Y-m-d H:i:s");
$name = $_POST['user'];
$cnt = count($name);
$subject = $_POST['subject'];
$message = $_POST['message'];
$group = $_POST['group'];
$signature = $_POST['signature'];
if ($signature == "") {
    $signature = $_SESSION["fullname"];
}
$grpcnt = count($group);
$structure = '<html><body>';
$structure .= "<br/><br/><span style='font-family: 'Source Sans Pro', sans-serif;color:#757575;font-weight:600;' > Hello,</span><br/><br/>";
$structure .= "<span style='font-family: 'Source Sans Pro', sans-serif;color:#757575;font-weight:600;' > " . $message . "</span><br/> ";
$structure .= "<br/><br/>";
$structure .= "- " . $signature;
$structure .= "</body></html>";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
if ($name != "" || $group != "") {
    if (isset($_FILES['image'])) {
        $errors = array();
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
        $file_ext = strtolower(end(explode('.', $file_name)));
        if ($file_size > 2097152) {
            $errors[] = 'File size must be excately 2 MB';
            $message_stauts_class = 'alert-danger';
            $import_status_message = 'Error: File size must be excately 2 MB';
        }
        if (empty($errors) == true) {
            move_uploaded_file($file_tmp, "mail_attachment/" . $file_name);
        }
    }
    require './vendor/autoload.php';
//Create a new PHPMailer instance
    $mail = new PHPMailer();
//Tell PHPMailer to use SMTP
    $mail->isSMTP();
//Enable SMTP debugging
//SMTP::DEBUG_OFF = off (for production use)
//SMTP::DEBUG_CLIENT = client messages
//SMTP::DEBUG_SERVER = client and server messages
//$mail->SMTPDebug = SMTP::DEBUG_SERVER;
//Set the hostname of the mail server
    $mail->Host = 'smtp.gmail.com';
//Use `$mail->Host = gethostbyname('smtp.gmail.com');`
//if your network does not support SMTP over IPv6,
//though this may cause issues with TLS
//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
    $mail->Port = 587;
//Set the encryption mechanism to use - STARTTLS or SMTPS
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
//Whether to use SMTP authentication
    $mail->SMTPAuth = true;
//Username to use for SMTP authentication - use full email address for gmail
    $mail->Username = EMAIL_USER;
//Password to use for SMTP authentication
    $mail->Password = EMAIL_PASSWORD;
//Set who the message is to be sent from
    $mail->setFrom('admin@plantnavigator.com', 'admin@plantnavigator.com');
//Set an alternative reply-to address
//$mail->addReplyTo('admin@plantnavigator.com', 'First Last');
    for ($i = 0; $i < $cnt;) {
        $u_name = $name[$i];
        $query0003 = sprintf("SELECT * FROM  cam_users where users_id = '$u_name' ");
        $qur0003 = mysqli_query($db, $query0003);
        $rowc0003 = mysqli_fetch_array($qur0003);
        $email = $rowc0003["email"];
        $lasname = $rowc0003["lastname"];
        $firstname = $rowc0003["firstname"];
        $fullnm = $firstname . " " . $lasname;
        $mail->addAddress($email, $firstname);
        $sql1 = "INSERT INTO `sg_sent_mail`(`user_id`,`subject`,`message`,`attachment_name`,`mail_sent_time`,`signature`) VALUES ('$u_name','$subject','$message','$file_name','$chicagotime','$signature')";
        mysqli_query($db, $sql1);
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
                $sql1 = "INSERT INTO `sg_sent_mail`(`user_id`,`subject`,`message`,`attachment_name`,`mail_sent_time`,`signature`) VALUES ('$u_name','$subject','$message','$file_name','$chicagotime','$signature')";
                mysqli_query($db, $sql1);
            }
            $i++;
        }
    }
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $structure;
    if ($file_name != "") {
        $mail->addAttachment('./mail_attachment/' . $file_name, $file_name);
    }
    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        $_SESSION['message_stauts_class'] = 'alert-success';
        $_SESSION['import_status_message'] = 'Mail-Sent Sucessfully.';
        $chicagotime = date("Y-m-d H:i:s");
    }
    function save_mail($mail) {
        $path = '{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail';
        $imapStream = imap_open($path, $mail->Username, $mail->Password);
        $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
        imap_close($imapStream);
        return $result;
    }
//personal name mail code ends here
//group mail code starts here
} else {
    $_SESSION['message_stauts_class'] = 'alert-danger';
    $_SESSION['import_status_message'] = 'Please Select atleast User or Group.';
}
header("Location:group_mail_module.php");
