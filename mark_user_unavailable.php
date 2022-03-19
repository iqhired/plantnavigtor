<?php
include("config.php");
$time = date("Y-m-d H:i:s");

$qur04 = mysqli_query($db, "SELECT * FROM  cam_users where `available`='1' ");
while($rowc04 = mysqli_fetch_array($qur04))
{
    $available_time = $rowc04["available_time"];
	
if($available_time != "")
{
	$new_time = date("Y-m-d H:i:s", strtotime('+8 hours', strtotime($available_time))); // $now + 3 hours
	$id = $rowc04["users_id"];
	if($time > $new_time)
	{
	$qur05 = mysqli_query($db, "SELECT * FROM `tm_task` WHERE `status` = '1' and assign_to = '$id'");
$rowc05 = mysqli_fetch_array($qur05);
		$task_id = $rowc05["tm_task_id"];
		if($task_id != "")
		{}
		else
		{
$sqltra = "update cam_users SET `available` = '0', available_time = '$time' where users_id = '$id'";
$resulttra = mysqli_query($db, $sqltra);			
		}

	}
	else
	{
		
	}
}
}

?>