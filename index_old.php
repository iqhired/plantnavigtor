<?php

//require "./vendor/autoload.php";
//use \Firebase\JWT\JWT;
$message = "";
include("config.php");
$chicagotime = date("Y-m-d H:i:s");
if (count($_POST) > 0){
    $user = $_POST["user"];
    $password = md5($_POST["pass"]);
    //API url
    // $service_url = $rest_api_uri . "login/login.php";
    // $curl = curl_init($service_url);
    // $curl_post_data = array(
    //         'user' => $user,
    //         'password' => $password
    // );
    // $secretkey = "SupportPassHTSSgmmi";
    // $payload = array(
    // 	"author" => "Saargummi to HTS",
    // 	"exp" => time()+1000
    // );
    // try{
    // 	$jwt = JWT::encode($payload, $secretkey);
    // }catch (UnexpectedValueException $e) {
    // 	echo $e->getMessage();
    // }
    // $headers = array(
    // 	"Accept: application/json",
    // 	"access-token: " . $jwt . '"',
    // );
    // curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($curl, CURLOPT_POST, true);
    // curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
    // $curl_response = curl_exec($curl);
    // if ($curl_response === false) {
    // 	$info = curl_getinfo($curl);
    // 	curl_close($curl);
    // 	die('error occured during curl exec. Additioanl info: ' . var_export($info));
    // }
    // curl_close($curl);
    // $decoded = json_decode($curl_response);
    // if (isset($decoded->status) && $decoded->status == 'ERROR') {
    // 	die('error occured: ' . $decoded->errormessage);
    // }

    //echo 'response ok!';
    //var_export($decoded->response);

    $result = mysqli_query($db, "SELECT * FROM cam_users WHERE user_name='" . $_POST["user"] . "' and password = '" . (md5($_POST["pass"])) . "'");
    //$row = $decoded->user;
    //console.log($row);

    $row = mysqli_fetch_array($result);
    //echo $row;
    if ($row != null && !empty($row)) {
        $logid = $row['users_id'];
        // echo ($logid);
        $_SESSION["id"] = $logid;
        $_SESSION["available"] = $row['available'];
        $_SESSION["user"] = $row['user_name'];
        $_SESSION["name"] = $row['user_name'];
        $_SESSION["role_id"] = $row['role'];
        $_SESSION["uu_img"] = $row['profile_pic'];
        $_SESSION["sqq1"] = $row['s_question1'];
        $status = $row['u_status'];
        $createdate = $row['createdate'];
        $_SESSION["session_user"] = $logid;
        $_SESSION["fullname"] = $row['firstname'] . "&nbsp;" . $row['lastname'];
        $_SESSION["pin"] = $row['pin'];
        $_SESSION["pin_flag"] = $row['pin_flag'];
        $_SESSION["is_cust_dash"] = $row['is_cust_dash'];
        $_SESSION["line_cust_dash"] = $row['line_cust_dash'];
        $_SESSION['tab_station'] = null;
        $_SESSION['is_tab_user'] = null;
        $pin = $row['pin'];
        $pin_flag = $row['pin_flag'];
        $uip = $_SERVER['REMOTE_ADDR'];
        $host = $_SERVER['HTTP_HOST'];
        $time = date("H:i:s");
        $date = date("Y-m-d");

        //mysqli_query($db, "INSERT INTO `cam_session_log`(`users_id`,`created_at`) VALUES ('$logid','$chicagotime')");
        mysqli_query($db, "INSERT INTO `cam_session_log_p`(`users_id`,`created_at`,`uip`,`host`,`username`,`logoutdate`,`logouttime`) VALUES ('$logid','$chicagotime','$uip','$host','$user','','')");

        $roleid = $row['role'];
        $result11 = mysqli_query($db, "SELECT * FROM `cam_role` WHERE role_id ='$roleid'");
        $row11 = mysqli_fetch_array($result11);
        $_SESSION["role_id"] = $row11['type'];
        $_SESSION["side_menu"] = $row11['side_menu'];

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

    header("Location:line_status_grp_dashboard.php");
    if ($pin_flag == "1") {
        if ($pin == "0") {
            $_SESSION['message_stauts_class'] = 'alert-danger';
            $_SESSION['import_status_message'] = 'Please Fill Pin';
            header("Location:profile.php");
        } else {
            header("Location:line_status_grp_dashboard.php");
        }
    } else {
        header("Location:line_status_grp_dashboard.php");
    }
    if($status == '1')
    {
        header("Location:change_password.php");
    }else {
        header("Location:line_status_grp_dashboard.php");
    }

}


/*if($status == 0)
{
    header("Location:line_status_grp_dashboard.php");
}else {
    header("Location:change_pass.php");
}*/
// $tmp = $_SESSION['temp'];
// $_SESSION['temp'] = "";
// if ($tmp == "forgotpass_success") {
// 	$message_stauts_class = $_SESSION["alert_success_class"];
// 	$import_status_message = $_SESSION["error_2"];
// }
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
    <link rel="shortcut icon" href="assets/images/favicon.jpg">
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
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
                <div style="float:right;padding: 20px;background-color: #333c;"><a href="sup_login.php" style="background-color: #1e73be;" class="btn btn-primary legitRipple" role="button">Supplier Login<span class="legitRipple-ripple" style="left: 70.8955%; top: 84.2105%; transform: translate3d(-50%, -50%, 0px); transition-duration: 0.2s, 0.5s; width: 207.886%;"></span></a></div>
                <!-- Form with validation -->
                <form action="" class="form-validate" method="post">
                    <div class="panel panel-body login-form" style="background-color:#333c;color:white;">
                        <?php
                        if (!empty($import_status_message)) {
                            echo '<div class="alert ' . $message_stauts_class . '">' . $import_status_message . '</div>';
                        }
                        ?>
                        <div class="text-center" >
                            <div class="icon-object border-slate-300 text-slate-300" style="background-color:white;"><img src="assets/images/SGG_logo.png" alt=""  style="width:100px;"/></div>
                            <h5 class="content-group">Login to your account</h5>
                        </div>
                        <div class="form-group has-feedback has-feedback-left">
                            <input type="text" class="form-control" placeholder="Username / Email" name="user" id="user" required="required" style="color:white;">
                            <div class="form-control-feedback">
                                <i class="icon-user text-muted"></i>
                            </div>
                        </div>
                        <div class="form-group has-feedback has-feedback-left">
                            <input type="password" class="form-control" placeholder="Password" name="pass" id="pass" required="required" style="color:white;">
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
                                    <button type="submit" id="signin" name="log" style="background-color:#1e73be;" class="btn bg-blue-400 sm-btn-block">Login <i class="icon-arrow-right14 position-right"></i></button>
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
