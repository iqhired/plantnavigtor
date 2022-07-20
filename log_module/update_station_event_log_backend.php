<?php
include("../config.php");
$curdate = date('Y-m-d');

$button = "";
$temp = "";
if (!isset($_SESSION['user'])) {
	header('location: logout.php');
}
if (count($_POST) > 0) {

	$page_from = $_POST['id_from'];
	$page_to = $_POST['id_to'];
}
$sql0 = "select * from sg_station_event_log WHERE station_event_log_id BETWEEN '$page_from' AND '$page_to'";

$result0 = mysqli_query($db, $sql0);
while ($row = mysqli_fetch_array($result0)) {
	$station_event_log_id = $row['station_event_log_id'];
	$event_seq = $row['event_seq'];
	$station_event_id = $row['station_event_id'];
	$station_cat_id = $row['event_cat_id'];
	$station_type_id = $row['event_type_id'];
	$event_status = $row['event_status'];
	$reason = $row['reason'];
	$created_on = $row['created_on'];
	$total_time = $row['total_time'];
	$created_by = $row['created_by'];

	$time = ($created_on);
	if (!empty($time)) {
		$s_arr_1 = explode(' ', $time);
		$s_arr = explode(':', $s_arr_1[1]);
		$st_time = $s_arr[0] + ($s_arr[1] / 60) + ($s_arr[2] / 3600);
		$start_time = round($st_time, 2);
	}
	if (!empty($total_time)) {
		$t_arr = explode(':', $total_time);
		$tot_time = $t_arr[0] + ($t_arr[1] / 60) + ($t_arr[2] / 3600);
		$total_time = round($tot_time, 2);
		$total_time = $total_time;
		$end_hrs = $start_time + $total_time;
		$tt = sprintf('%02d:%02d', (int)$start_time, fmod($start_time, 1) * 60);
		if ($end_hrs < 24) {
			$tt = sprintf('%02d:%02d', (int)$end_hrs, fmod($end_hrs, 1) * 60);
			$end_time2 = $s_arr_1[0] . ' ' . $tt;
			$page = "INSERT INTO `sg_station_event_log_update`(`sg_station_event_old_id`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`) 
                values ('$station_event_log_id','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$created_on','$end_time2','$total_time','$created_by')";
			$result1 = mysqli_query($db, $page);
		}else{
			$tt_time_1 = 24 - $start_time;
			$endtime_1 = $s_arr_1[0] . ' ' . '23:59:59';
			$page = "INSERT INTO `sg_station_event_log_update`(`sg_station_event_old_id`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`) 
                values ('$station_event_log_id','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$created_on','$endtime_1','$tt_time_1','$created_by')";
			$result1 = mysqli_query($db, $page);
			$start_date2 = $s_arr_1[0];
			$tt_time_2 = $total_time - $tt_time_1;
			while($tt_time_2 > 0){
				$start_date2 = date('Y-m-d', strtotime($start_date2 . " +1 days"));
				$start_time2 = $start_date2 . ' ' . '00:00:00';
				if($tt_time_2 < 24){
					$tt = sprintf('%02d:%02d', (int)$tt_time_2, fmod($tt_time_2, 1) * 60);
					$end_time2 = $start_date2 . ' ' . $tt;
					$page = "INSERT INTO `sg_station_event_log_update`(`sg_station_event_old_id`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`)                 
				values ('$station_event_log_id','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$start_time2','$end_time2','$tt_time_2','$created_by')";
					$result1 = mysqli_query($db, $page);
				}else{
					$end_time2 = $start_date2 . ' ' . '23:59:59';
					$page = "INSERT INTO `sg_station_event_log_update`(`sg_station_event_old_id`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`)                 
				values ('$station_event_log_id','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$start_time2','$end_time2','24','$created_by')";
					$result1 = mysqli_query($db, $page);
				}
				$tt_time_2 = ($tt_time_2 - 24);
			}
		}
	}else{

		$page_tot = "INSERT INTO `sg_station_event_log_update`(`sg_station_event_old_id`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`check_total_time`,`created_by`) 
                values ('$station_event_log_id','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$created_on','1','$created_by')";
		$result_tot = mysqli_query($db, $page_tot);
	}
}


if ($result0) {
	$_SESSION['message_stauts_class'] = 'alert-success';
	$_SESSION['import_status_message'] = 'Form Created Sucessfully.';
} else {
	$_SESSION['message_stauts_class'] = 'alert-danger';
	$_SESSION['import_status_message'] = 'Please retry';
}

$url = "update_station_event_log.php";
header('Location: ' . $url, true, 303);

?>
