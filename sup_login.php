<?php
$message = "";
include("sup_config.php");
$chicagotime = date("Y-m-d H:i:s");
if (count($_POST) > 0) {
	$is_error = 0;
	$result = mysqli_query($sup_db, "SELECT * FROM sup_account_users WHERE user_name='" . $_POST["user"] . "' and u_password = '" . (md5($_POST["pass"])) . "'");
	$row = mysqli_fetch_array($result);
	if (is_array($row)) {
		$_SESSION["id"] = $row['u_id'];
		$_SESSION["user"] = $row['user_name'];
		$_SESSION["name"] = $row['user_name'];
		$_SESSION["email"] = $row['u_email'];
		$_SESSION["uu_img"] = $row['u_profile_pic'];
		$_SESSION["role_id"] = $row['role'];
		$logid = $row['u_id'];
		$_SESSION["fullname"] = $row['u_firstname'] . "&nbsp;" . $row['u_lastname'];
		$_SESSION["pin"] = $row['pin'];
		$_SESSION["pin_flag"] = $row['pin_flag'];
		$pin = $row['pin'];
		$pin_flag = $row['pin_flag'];
		mysqli_query($sup_db, "INSERT INTO `sup_session_log`(`u_id`,`created_at`) VALUES ('$logid','$chicagotime')");
	} else {
		$result = mysqli_query($sup_db, "SELECT * FROM sup_account_users WHERE u_status = '0' AND user_name='" . $_POST["user"] . "' and u_password = '" . (md5($_POST["pass"])) . "'");
		$row = mysqli_fetch_array($result);
		if (is_array($row)) {
			$message_stauts_class = $_SESSION["alert_danger_class"];
			$import_status_message = $_SESSION["error_6"];
			$is_error = 1;
		} else {
			$message_stauts_class = $_SESSION["alert_danger_class"];
			$import_status_message = $_SESSION["error_1"];
			$is_error = 1;
		}
	}
	if ($is_error == 0) {
		header("Location:./supplier/supplier_home.php");
	}
}
$tmp = $_SESSION['temp'];
$_SESSION['temp'] = "";
if ($tmp == "forgotpass_success") {
	$message_stauts_class = $_SESSION["alert_success_class"];
	$import_status_message = $_SESSION["error_2"];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?></title>
    <link rel="shortcut icon" href="assets/images/favicon.jpg">
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
          type="text/css">
    <link href="assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="assets/css/colors.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
    <!-- Core JS files -->
    <script type="text/javascript" src="assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="assets/js/core/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/core/libraries/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->
    <!-- Theme JS files -->
    <script type="text/javascript" src="assets/js/core/libraries/jquery_ui/interactions.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="assets/js/core/app.js"></script>
    <script type="text/javascript" src="assets/js/pages/form_select2.js"></script>
    <script type="text/javascript" src="assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="assets/js/pages/form_bootstrap_select.js"></script>
    <script type="text/javascript" src="assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <!-- /theme JS files -->
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
                <form action="" class="form-validate" method="post">
                    <div class="panel panel-body login-form" style="background-color:#333c;color:white;">
						<?php
						if (!empty($import_status_message)) {
							echo '<div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
						}
						?>
                        <div class="text-center">
                            <div class="icon-object border-slate-300 text-slate-300" style="background-color:white;">
                                <img src="assets/images/SGG_logo.png" alt="" style="width:100px;"/></div>
                            <h5 class="content-group">Login to your account</h5>
                        </div>
                        <div class="form-group has-feedback has-feedback-left">
                            <input type="text" class="form-control" placeholder="Username / Email" name="user"
                                   required="required" style="color:white;">
                            <div class="form-control-feedback">
                                <i class="icon-user text-muted"></i>
                            </div>
                        </div>
                        <div class="form-group has-feedback has-feedback-left">
                            <input type="password" class="form-control" placeholder="Password" name="pass"
                                   required="required" style="color:white;">
                            <div class="form-control-feedback">
                                <i class="icon-lock2 text-muted"></i>
                            </div>
                        </div>
                        <div class="form-group login-options">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" class="styled" checked="checked">
                                        Remember Me
                                    </label>
                                </div>
                                <div class="col-sm-6 text-right">
                                    <button type="submit" name="log" style="background-color:#1e73be;"
                                            class="btn bg-blue-400 sm-btn-block">Login <i
                                                class="icon-arrow-right14 position-right"></i></button>
                                </div>
                            </div>
                        </div>
                        <a href="forgotpass.php" style="color:white;">Lost your Password?</a>
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
<!-- /page container
<script>
    window.onload = function() {
        history.replaceState("", "", "<?php echo $scriptName; ?>index.php");
    }
 </script> -->
</body>
</html>
