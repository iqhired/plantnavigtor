<?php
@ob_start();
ini_set('display_errors', FALSE);
$message = "";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require './vendor/autoload.php';
include("config.php");
if (count($_POST) > 0) {
    $email = $_POST['email'];
    $result = mysqli_query($db, "SELECT * FROM cam_users WHERE email='" . $_POST["email"] . "'");
    $row = mysqli_fetch_array($result);
    if (is_array($row)) {
        $id = $row['users_id'];
        $name = $row['user_name'];
        $password = "PW" . rand(10000, 500000);
        $pp = md5($password);
        $link = $siteURL;
        $msg = "Note: This is one time password once you login system ask to change password.";
        $msg .= "<br>";
        $msg .= "Your new password is :-" . $password;
        $msg .= "<br>";
        $msg .= "Click to login the page :-" .$link;
        $sql = "update `cam_users` set `password` = '$pp' where `users_id`='$id'";
        mysqli_query($db, $sql);
        $sql1 = "update `cam_users` set u_status = '1' where `users_id`='$id'";
        mysqli_query($db, $sql1);
        $mail = new PHPMailer();
        $mail->isSMTP();
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->SMTPAuth = true;
        $mail->Username = EMAIL_USER;
        $mail->Password = EMAIL_PASSWORD;
        $mail->setFrom('admin@plantnavigator.com', 'Admin Plantnavigator');
        $email = $row["email"];
        $lasname = $row["lastname"];
        $firstname = $row["firstname"];
        $mail->addAddress($email, $firstname);
        $signature = '- Plantnavigator Admin';

        $structure = '<html><body>';
        $structure .= "<br/><br/><span style='font-family: 'Source Sans Pro', sans-serif;color:#757575;font-weight:600;' > Hello " . $firstname ." " . $lasname.",</span><br/><br/>";
        $structure .= "<span style='font-family: 'Source Sans Pro', sans-serif;color:#757575;font-weight:600;' > " . $msg . "</span><br/> ";
//        $structure .= "<span style='font-family: 'Source Sans Pro', sans-serif;color:#757575;font-weight:600;' > " . $message . "</span><br/> ";
        $structure .= "<br/><br/>";
        $structure .= $signature;
        $structure .= "</body></html>";


        $subject = "Password Recovery";
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $structure;
        if (!$mail->send()) {
        }

        $_SESSION['temp'] = "forgotpass_success";
        header("Location:index.php");
    } else {
        $message_stauts_class = $_SESSION["alert_danger_class"];
        $import_status_message = $_SESSION["error_3"];
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?> | Forgot Password</title>
    <link rel="shortcut icon" href="assets/images/favicon.jpg">
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
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
    <!--<script type="text/javascript" src="assets/js/plugins/forms/validation/validate.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>-->
    <!--        <script type="text/javascript" src="assets/js/core/app.js"></script>-->
    <script type="text/javascript" src="assets/js/plugins/ui/ripple.min.js"></script>
    <!-- /theme JS files -->
    <script type="text/javascript" src="assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="assets/js/pages/form_bootstrap_select.js"></script>
</head>
<body class="login-container login-cover">
<!-- Page container -->
<div class="page-container">
    <!-- Page content -->
    <div class="page-content">
        <!-- Main content -->
        <div class="content-wrapper">
            <!-- Content area -->
            <form action="" name="form" id="form" class="form-validate" method="post">
                <div class="panel panel-body login-form" style="background-color:#333c;color:white;">
                    <?php
                    if (!empty($import_status_message)) {
                        echo '<div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
                    }
                    ?>
                    <div class="text-center" >
                        <div class="icon-object border-slate-300 text-slate-300" style="background-color:white;"><img src="assets/images/SGG_logo.png" alt=""  style="width:100px;"/></div>
                        <h5 class="content-group">Forgot Password</h5>
                    </div>
                    <div class="form-group has-feedback has-feedback-left">
                        <input type="email" class="form-control" placeholder="Enter your Email" name="email" id="email" required="required" style="color:white;">
                        <div class="form-control-feedback">
                            <i class="icon-user text-muted"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="log" class="btn bg-pink-200 btn-block" style="background-color:#1e73be;">Send Password<i class="icon-arrow-right14 position-right"></i></button>
                        <!--                                    <a href="security_questions.php" class="btn bg-pink-400 btn-block" style="background-color:#1e73be;">Reset With Security Questions<i class="icon-arrow-right14 position-right"></i></a>	-->
                    </div>
                    <div class="text-center" >
                        <h8 class="content-group"><u>Note:</u> If you don't have email kindly contact your admin to change password</h8>
                    </div>
                </div>
            </form>
            <!-- /content area -->
        </div>
        <!-- /main content -->
    </div>
    <!-- /page content -->
</div>
<!-- /page container -->
<script>
    window.onload = function () {
        history.replaceState("", "", "<?php echo $scriptName; ?>forgotpass.php");
    }
    $(document).ready(function () {
        $("form").submit(function () {
            var aa = document.getElementById("email").value;
            if (aa == "") {
                alert("Email Cant be Empty");
                return false;
            }
        });
    });
</script>
</body>
</html>
