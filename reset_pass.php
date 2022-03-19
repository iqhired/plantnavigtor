<?php
@ob_start();
ini_set('display_errors', FALSE);
$message = "";
include("config.php");
if (count($_POST) > 0) {
    $mob = $_SESSION['reset_user'];
    $sql1 = "UPDATE `users` SET password='" . md5($_POST['newpass']) . "' where user_name = '$mob'";
    if (!mysqli_query($db, $sql1)) {
        echo "Invalid Data";
    } else {
        $_SESSION['temp'] = "Your Password has been changed";
        header("Location: index.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $sitename; ?> | Reset Password</title>
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
        <script type="text/javascript" src="assets/js/core/app.js"></script>
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
                    <div class="content pb-20">
                        <!-- Form with validation -->
                        <form action="" name="form" id="form" class="form-validate" method="post">
                            <div class="panel panel-body login-form" style="background-color:#333c;color:white;">
                                <?php if ($_SESSION['temp1'] != "") { ?>
                                    <div class="alert alert-danger no-border">
                                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                                        <?php
                                        echo $_SESSION['temp1'];
                                        $_SESSION['temp1'] = "";
                                        ?>
                                    </div>
                                <?php } ?>
                                <div class="text-center" >
                                    <div class="icon-object border-slate-300 text-slate-300" style="background-color:white;"><img src="assets/images/SGG_logo.png" alt=""  style="width:100px;"/></div>
                                    <h5 class="content-group">Reset Password</h5>
                                </div>
                                <div class="form-group has-feedback has-feedback-left">
                                    <input type="text" class="form-control" placeholder="Enter your New Password" name="newpass" id="newpass" required="required" style="color:white;">
                                    <div class="form-control-feedback">
                                        <i class="icon-user text-muted"></i>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="log" class="btn bg-pink-400 btn-block" style="background-color:#1e73be;">Reset Password<i class="icon-arrow-right14 position-right"></i></button>	
                            <!--	<a href="security_questions.php" class="btn bg-pink-400 btn-block" style="background-color:#1e73be;">Reset With Security Questions<i class="icon-arrow-right14 position-right"></i></a>	
                            --s></div>
                            </div>
            </form>
                                    <!-- /form with validation -->
                                </div>
                                <!-- /content area -->
                            </div>
                            <!-- /main content -->
                    </div>
                    <!-- /page content -->
                </div>
                <!-- /page container -->
                <script>
                    window.onload = function () {
                        history.replaceState("", "", "<?php echo $scriptName; ?>reset_pass.php");
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
