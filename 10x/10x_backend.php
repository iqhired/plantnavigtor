<?php
include("../config.php");

$x_trace_id = 0;
if (count($_POST) > 0) {
	$station_event_id = $_POST['station_event_id'];
	$station = $_POST['station'];
	$line_number = $_POST['station'];
	$part_number = $_POST['part_number'];
	$part_family = $_POST['part_family'];
	$part_name = $_POST['part_name'];

	$notes = $_POST['10x_notes'];
	$created_by = date("Y-m-d H:i:s");
	$created_by_user = $_SESSION['id'];


	$sql0 = "INSERT INTO `10x`(`station_event_id`,`line_no`,`part_no`,`part_family_id`,`part_name`,`notes`,`created_at`,`created_by`) VALUES 
	        	('$station_event_id','$line_number' , ' $part_number' ,'$part_family',' $part_name','$notes','$created_by' , '$created_by_user')";
	$result0 = mysqli_query($db, $sql0);

	$sql1 = "SELECT 10x_id as x_id FROM  10x where line_no= '$line_number' ORDER BY `10x_id` DESC LIMIT 1";
	$result1 = mysqli_query($db, $sql1);
	$rowc04 = mysqli_fetch_array($result1);
	$x_trace_id = $rowc04["x_id"];
	$ts = $_SESSION['timestamp_id'];
	$folderPath =  "../assets/images/10x/".$ts;
	$newfolder = "../assets/images/10x/".$x_trace_id;
	if ($result0) {
		rename( $folderPath, $newfolder) ;
		$sql = "update `10x_images` SET 10x_id = '$x_trace_id' where 10x_id = '$ts'";
		$result1 = mysqli_query($db, $sql);
		$_SESSION['timestamp_id'] = "";
		$_SESSION['message_stauts_class'] = 'alert-success';
		$_SESSION['import_status_message'] = '10x Created Sucessfully.';
	} else {
		$_SESSION['message_stauts_class'] = 'alert-danger';
		$_SESSION['import_status_message'] = 'Please retry';

	}
}

$page = "10x.php?station=$station&station_event_id=$station_event_id&f_type=n";
header('Location: ' . $page, true, 303);

