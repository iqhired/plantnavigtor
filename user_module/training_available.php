<?php
include("../config.php");
$available_var = $_POST['available_var'];
$id = $_POST['edit_id'];
if ($available_var == '0') {
    $opposval = '1';
} else {
    $opposval = '0';
}
$sqltra = "update cam_users SET `training` = '$opposval' where users_id = '$id'";
$resulttra = mysqli_query($db, $sqltra);
//$_SESSION['available'] = $opposval;
?>