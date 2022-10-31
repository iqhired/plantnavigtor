<?php
require "./vendor/autoload.php";
use \Firebase\JWT\JWT;
$message = "";
include("config.php");
$chicagotime = date("Y-m-d H:i:s");
$status = '0';
if (!empty($_POST['user']) && !empty($_POST['pass']) ){
    $user = $_POST["user"];
    $password = md5($_POST["pass"]);
    //API url
    $service_url = $rest_api_uri . "login/login.php";
    $curl = curl_init($service_url);
    $curl_post_data = array(
            'user' => $user,
            'password' => $password
    );
	$secretkey = "SupportPassHTSSgmmi";
	$payload = array(
		"author" => "Saargummi to HTS",
		"exp" => time()+1000
	);
	try{
		$jwt = JWT::encode($payload, $secretkey , 'HS256');
	}catch (UnexpectedValueException $e) {
		echo $e->getMessage();
	}
	$headers = array(
		"Accept: application/json",
		"access-token: " . $jwt . '"',
	);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
	$curl_response = curl_exec($curl);
	if ($curl_response === false) {
		$info = curl_getinfo($curl);
		curl_close($curl);
		die('error occured during curl exec. Additioanl info: ' . var_export($info));
	}
	curl_close($curl);
	$decoded = json_decode($curl_response);
	if (isset($decoded->status) && $decoded->status == 'ERROR') {
		die('error occured: ' . $decoded->errormessage);
	}
	//echo 'response ok!';
	//var_export($decoded->response);


//    $result = mysqli_query($db, "SELECT * FROM cam_users WHERE user_name='" . $_POST["user"] . "' and password = '" . (md5($_POST["pass"])) . "'");
	$row = $decoded->user;
	//console.log($row);
	if ($row != null && !empty($row)) {
		$logid = $row->users_id;
		$_SESSION['id'] = $logid;
		$_SESSION['available'] = $row->available;
		$user_nm = $row->user_name;
		$_SESSION['user'] = $user_nm;

		$_SESSION['name'] = $user_nm;
		$_SESSION['role_id'] = $row->role;
		$_SESSION['uu_img'] = $row->profile_pic;
		$_SESSION['sqq1'] = $row->s_question1;
		$status = $row->u_status;
		$_SESSION['session_user'] = $logid;
		$_SESSION['fullname'] = $row->firstname . "&nbsp;" . $row->lastname;
		$_SESSION['pin'] = $row->pin;
		$_SESSION['pin_flag'] = $row->pin_flag;
		$_SESSION['is_cust_dash'] = $row->is_cust_dash;
		$_SESSION['line_cust_dash'] = $row->line_cust_dash;
		$_SESSION['tab_station'] = null;
		$_SESSION['is_tab_user'] = null;
		$pin = $row->pin;
		$pin_flag = $row->pin_flag;
		$uip=$_SERVER['REMOTE_ADDR'];
		$host=$_SERVER['HTTP_HOST'];
		$time = date("H:i:s");
		$date = date("Y-m-d");
        $email = $row->email;

		//mysqli_query($db, "INSERT INTO `cam_session_log`(`users_id`,`created_at`) VALUES ('$logid','$chicagotime')");
		mysqli_query($db, "INSERT INTO `cam_session_log_p`(`users_id`,`created_at`,`uip`,`host`,`username`,`logoutdate`,`logouttime`) VALUES ('$logid','$chicagotime','$uip','$host','$user','$date','$time')");

	//	mysqli_query($db, "INSERT INTO `cam_session_log`(`users_id`,`created_at`) VALUES ('$logid','$chicagotime')");
		$roleid = $row->role;
		$result11 = mysqli_query($db, "SELECT * FROM `cam_role` WHERE role_id ='$roleid'");
		$row11 = mysqli_fetch_array($result11);
		$_SESSION['role_id'] = $row11['type'];
		$_SESSION['side_menu'] = $row11['side_menu'];

		$result12 = mysqli_query($db, "SELECT * FROM `sg_user_group` WHERE user_id = '$logid'");
		while ($row12 = mysqli_fetch_array($result12)) {
			$value = $row12['group_id'];
			$result14 = mysqli_query($db, "SELECT * FROM `sg_taskboard` WHERE group_id ='$value'");
			while ($row14 = mysqli_fetch_array($result14)) {
				$value1 = $row14['sg_taskboard_id'];
			}
			if ($value1 != "") {
				$_SESSION["taskavailable"] = "1";
			}
		}
	} else {
		$message_stauts_class = $_SESSION["alert_danger_class"];
		$import_status_message = $_SESSION["error_1"];
	}
	if(!empty($email)) {
		if ($status == '1') {
			header("Location:change_password.php");
			exit;
		} else {
			header("Location:line_status_grp_dashboard.php");
			exit;
		}
	}else{
		header("Location:line_status_grp_dashboard.php");
	}
	if ($pin_flag == "1") {
		if ($pin == "0") {
			$_SESSION['message_stauts_class'] = 'alert-danger';
			$_SESSION['import_status_message'] = 'Please Fill Pin';
			header("Location:profile.php");
			exit;
		} else {
			header("Location:line_status_grp_dashboard.php");
			exit;
		}
	} else {
		header("Location:line_status_grp_dashboard.php");
		exit;
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
    <script type="text/javascript">
        function disablebackbutton(){
            window.history.forward();
        }
        disablebackbutton();
    </script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $sitename; ?></title>
    <link rel="shortcut icon" href="<?php echo $siteURL; ?>assets/images/favicon.jpg">
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/colors.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $siteURL; ?>assets/css/demo.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="<?php echo $siteURL; ?>assets/js/libs/jquery-3.6.0.min.js"> </script>
    <!-- /global stylesheets -->


</head>
<body class="login-container login-cover">
<div class="form-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-offset-3 col-lg-6 col-md-offset-2 col-md-8">
                <div class="form-container">
                    <?php
                    if (!empty($import_status_message)) {
                        echo '<div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
                    }
                    ?>
                    <div class="form-icon">
                        <div class="text-center" >
                            <div class="icon-object border-slate-300 text-slate-300" style="background-color:white;"><img src="<?php echo $siteURL; ?>assets/images/SGG_logo.png" alt=""  style="width:100px;"/></div>
                            <h3 class="title">Plantnavigator</h3>
                        </div>

                    </div>
                    <form class="form-horizontal" method="post">
                        <h5 class="content-group">Login to your account</h5>
                        <div class="form-group">
                            <span class="input-icon"><i class="fa fa-envelope"></i></span>
                            <input class="form-control" type="name" placeholder="Username /Email" name="user" id="user" required="required">
                        </div>
                        <div class="form-group">
                            <span class="input-icon"><i class="fa fa-lock"></i></span>
                            <input class="form-control" type="password" placeholder="Password" name="pass" id="pass" required="required">
                        </div>

                            <label class="checkbox-inline" style="padding-top: 0px;">
                                <input type="checkbox" class="styled" checked="checked">
                                <span class="forgot-pass">Remember Me </span>
                            </label>

                        <button class="btn signin" id="signin" name="log">Login</button>
                        <span class="forgot-pass"><a href="forgotpass.php">Forgot Username/Password?</a></span>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function ($) {
        $(document).on('click', '#signin', function () {
            var element = $(this);
            var edit_id = element.attr("data-id");
            var name = $(this).data("name");
            var priority_order = $(this).data("priority_order");
            var enabled = $(this).data("enabled");
            $("#edit_name").val(name);
            $("#edit_id").val(edit_id);
            $("#edit_priority_order").val(priority_order);
            $("#edit_enabled").val(enabled);
            //alert(role);
        });
    });
</script>
</body>
</html>