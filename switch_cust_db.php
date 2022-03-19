<?php
include("config.php");
$is_cust_dash = $_POST['is_cust_dash'];
$available_time = date("Y-m-d H:i:s");
$id = $_SESSION["id"];
if ($is_cust_dash == '0') {
	$opposval = '1';
} else {
	$opposval = '0';
}
//$sqltra = "update cam_users SET `available` = '$opposval', available_time = '$available_time' where users_id = '$id'";
$sqltra = "update cam_users SET `is_cust_dash` = '$opposval' where users_id = '$id'";
$resulttra = mysqli_query($db, $sqltra);
$_SESSION['is_cust_dash'] = $opposval;
?>