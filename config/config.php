<?php
@ob_start();
session_start();
ini_set('display_errors', true);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "saargummi";

// to check whether pin is updated or not 
$actual_link = "$_SERVER[REQUEST_URI]";
if ($actual_link != "/saargummi/profile.php") {
	$pin = $_SESSION["pin"];
	$pin_flag = $_SESSION["pin_flag"];

	if ($pin_flag == "1") {
		if ($pin == "0") {
			$_SESSION['message_stauts_class'] = 'alert-danger';
			$_SESSION['import_status_message'] = 'Please Fill Pin';
			header("Location:profile.php");
		}
	}
}

$db1 = mysqli_connect('localhost', 'root', '', 'saargummi');
$mysqli = new mysqli('localhost', 'root', '', 'saargummi');

$sitename = "SaarGummi";

//error class
$_SESSION['alert_success_class'] = 'alert-success';
$_SESSION['alert_danger_class'] = 'alert-danger';

//index error
$_SESSION['error_1'] = "Error: Incorrect User-id or Password ...!";

//forgot password error
$_SESSION['error_2'] = "Success: Password is sent...!";
$_SESSION['error_3'] = "Error: Incorrect Mail-id...!";

//security question error
$_SESSION['error_4'] = "Error: Incorrect Security answers ...!";
$_SESSION['error_5'] = "Error: Incorrect Mail-id ...!";
$scriptName = "http://localhost/saargummi/";

date_default_timezone_set("America/chicago");
?>