<?php
ini_set('display_errors', false);
include("config.php");
$name = $_POST['user'];
$cnt = count($name);
$subject = $_POST['subject'];
$message = $_POST['message'];
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require './vendor/autoload.php';
$mail = new PHPMailer();
$mail->isSMTP();
$mail->SMTPDebug = SMTP::DEBUG_SERVER;
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->SMTPAuth = true;
$mail->Username = EMAIL_USER;
$mail->Password = EMAIL_PASSWORD;
$mail->setFrom('admin@plantnavigator.com', 'First Last');
for ($i = 0; $i < $cnt;) {
    $u_name = $name[$i];
    $query0003 = sprintf("SELECT * FROM  cam_users where users_id = '$u_name' ");
    $qur0003 = mysqli_query($db, $query0003);
    $rowc0003 = mysqli_fetch_array($qur0003);
    $email = $rowc0003["email"];
    $lasname = $rowc0003["lastname"];
    $firstname = $rowc0003["firstname"];
    $mail->addAddress($email, $firstname);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $message;
    $mail->addAttachment('./user_images/user.png', 'user.jpg');
    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        $_SESSION['message_stauts_class'] = 'alert-success';
        $_SESSION['import_status_message'] = 'Mail-Sent Sucessfully.';
    }
    $i++;
}
function save_mail($mail) {
    $path = '{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail';
    $imapStream = imap_open($path, $mail->Username, $mail->Password);
    $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
    imap_close($imapStream);
    return $result;
}
header("Location:group_mail_module.php");
