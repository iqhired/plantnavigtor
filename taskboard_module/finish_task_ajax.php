<?php
include("../config.php");
$id = $_POST['id'];
$finished_time = date("Y-m-d H:i:s");
$finished_by = $_SESSION["id"];
$sql1 = "UPDATE `tm_task` SET `finished_time` = '$finished_time' , `finished_by` = '$finished_by' , `status` = '0' WHERE `tm_task_id` = '$id' ";
if (!mysqli_query($db, $sql1)) {
    echo "Invalid Data";
} else {

$qur04 = mysqli_query($db, "SELECT * FROM  cam_users where `users_id` = '$finished_by' ");
$rowc04 = mysqli_fetch_array($qur04);
$assign_fullname = $rowc04["firstname"]." ".$rowc04["lastname"];

$sql11 = "UPDATE `tm_task_log` SET `finished_time` = '$finished_time' , `finished_by` = '$finished_by' , `finished_by_name` = '$assign_fullname' , `status` = '0' WHERE `tm_task_log_id` = '$id' ";
mysqli_query($db, $sql11);
	
    echo "Record Updated";
}
?>
