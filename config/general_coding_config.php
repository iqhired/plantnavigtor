<?php

// to check whether pin is updated or not 
$actual_link = "$_SERVER[REQUEST_URI]";
$rest_api_uri = "http://restapi:8888/api/v1/";
if($actual_link != "/profile.php")
{
$pin = $_SESSION["pin"];
$pin_flag = $_SESSION["pin_flag"];

if($pin_flag == "1")
{
if($pin == "0"){
	$_SESSION['message_stauts_class'] = 'alert-danger';
	$_SESSION['import_status_message'] = 'Please Fill Pin';
	header("Location:profile.php");
}
}
}
$auto_logout_duration = 10800;
$redirect_logout_path = 'location:'. $siteURL . 'logout.php';
$redirect_tab_logout_path = 'location:'. $siteURL . 'tab_logout.php';
?>