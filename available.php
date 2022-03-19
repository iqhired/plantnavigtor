<?php
include("config.php");
$available_var = $_POST['available_var'];
    $available_time = date("Y-m-d H:i:s");
$id = $_SESSION["id"];
if ($available_var == '0') {
    $opposval = '1';
} else {
    $opposval = '0';
}
$sqltra = "update cam_users SET `available` = '$opposval', available_time = '$available_time' where users_id = '$id'";
$resulttra = mysqli_query($db, $sqltra);
$_SESSION['available'] = $opposval;
?>