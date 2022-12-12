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
$sql0 = "select * from cam_assign_crew_log WHERE assign_crew_log_id BETWEEN '$page_from' AND '$page_to'";
$result0 = mysqli_query($db, $sql0);
while ($row = mysqli_fetch_array($result0)) {
	$assign_crew_log_id = $row['assign_crew_log_id'];
	$station = $row['station'];
	$station_id = $row['station_id'];
	$position = $row['position'];
	$position_id = $row['position_id'];
	$user = $row['user'];
	$user_id = $row['user_id'];
	$assign_crew_transaction_id = $row['assign_crew_transaction_id'];
	$status = $row['status'];
	$email_notification = $row['email_notification'];
	$assign_time = $row['assign_time'];
	$unassign_time = $row['unassign_time'];
	$resource_type = $row['resource_type'];
	$total_time = $row['total_time'];
	$first_assign_log_id = $row['first_assign_log_id'];
	$last_assigned_by = $row['last_assigned_by'];
	$last_unassigned_by = $row['last_unassigned_by'];
	$time = ($assign_time);


	if (empty($total_time)) {

		$s_arr_1 = explode(' ', $time);
		$s_arr = explode(':', $s_arr_1[1]);
		$st_time = $s_arr[0] + ($s_arr[1] / 60) + ($s_arr[2] / 3600);
		$start_time = round($st_time, 2);

		$datetime1 = strtotime($unassign_time);
		$datetime2 = strtotime($time);
		$totalSecondsDiff = $datetime1 - $datetime2;
		$total_time = $totalSecondsDiff / 3600;
		$total_time = round($total_time,2);

		$end_hrs = $start_time + $total_time;
		$tt = sprintf('%02d:%02d', (int)$start_time, fmod($start_time, 1) * 60);
		if ($end_hrs < 24) {
			$tt = sprintf('%02d:%02d', (int)$end_hrs, fmod($end_hrs, 1) * 60);
			$end_time2 = $s_arr_1[0] . ' ' . $tt;
			$page = "INSERT INTO `cam_assign_crew_log_update`(`assign_crew_log_old_id`,`day_seq`,`station`,`station_id`,`position`,`position_id`,`user`,`user_id`,`assign_crew_transaction_id` ,`status`,`email_notification`,`assign_time`,`unassign_time`,`resource_type`,`total_time`,`first_assign_log_id`,`last_assigned_by`,`last_unassigned_by`) 
                values ('$assign_crew_log_id','1','$station','$station_id','$position','$position_id','$user','$user_id','$assign_crew_transaction_id','$status','$email_notification','$assign_time','$unassign_time','$resource_type','$total_time','$first_assign_log_id','$last_assigned_by','$last_unassigned_by')";
			$result1 = mysqli_query($db, $page);
		} else {

			$tt_time_1 = 24 - $assign_time;
			$endtime_1 = $s_arr_1[0] . ' ' . '23:59:59';
			$page = "INSERT INTO `cam_assign_crew_log_update`(`assign_crew_log_old_id`,`day_seq`,`station`,`station_id`,`position`,`position_id`,`user`,`user_id`,`assign_crew_transaction_id` ,`status`,`email_notification`,`assign_time`,`unassign_time`,`resource_type`,`total_time`,`first_assign_log_id`,`last_assigned_by`,`last_unassigned_by`) 
                values ('$assign_crew_log_id','1','$station','$station_id','$position','$position_id','$user','$user_id','$assign_crew_transaction_id','$status','$email_notification','$assign_time','$endtime_1','$resource_type','$tt_time_1','$first_assign_log_id','$last_assigned_by','$last_unassigned_by')";
			$result1 = mysqli_query($db, $page);
			$start_date2 = $s_arr_1[0];
			$tt_time_2 = $total_time - $tt_time_1;
			$i = 2;
			while ($tt_time_2 > 0) {
				$start_date2 = date('Y-m-d', strtotime($start_date2 . " +1 days"));
				$start_time2 = $start_date2 . ' ' . '00:00:00';
				if ($tt_time_2 < 24) {
					$tt = sprintf('%02d:%02d', (int)$tt_time_2, fmod($tt_time_2, 1) * 60);
					$end_time2 = $start_date2 . ' ' . $tt;
					$page = "INSERT INTO `cam_assign_crew_log_update`(`assign_crew_log_old_id`,`day_seq`,`station`,`station_id`,`position`,`position_id`,`user`,`user_id`,`assign_crew_transaction_id` ,`status`,`email_notification`,`assign_time`,`unassign_time`,`resource_type`,`total_time`,`first_assign_log_id`,`last_assigned_by`,`last_unassigned_by`)                 
				values ('$assign_crew_log_id','$i','$station','$station_id','$position','$position_id','$user','$user_id','$assign_crew_transaction_id','$status','$email_notification','$start_time2','$end_time2','$resource_type','$tt_time_2','$first_assign_log_id','$last_assigned_by','$last_unassigned_by')";
					$result1 = mysqli_query($db, $page);
				} else {
					$end_time2 = $start_date2 . ' ' . '23:59:59';
					$page = "INSERT INTO `cam_assign_crew_log_update`(`assign_crew_log_old_id`,`day_seq`,`station`,`station_id`,`position`,`position_id`,`user`,`user_id`,`assign_crew_transaction_id` ,`status`,`email_notification`,`assign_time`,`unassign_time`,`resource_type`,`total_time`,`first_assign_log_id`,`last_assigned_by`,`last_unassigned_by`)                 
				values ('$assign_crew_log_id','$i','$station','$station_id','$position','$position_id','$user','$user_id','$assign_crew_transaction_id','$status','$email_notification','$start_time2','$end_time2','$resource_type','24','$first_assign_log_id','$last_assigned_by','$last_unassigned_by')";
					$result1 = mysqli_query($db, $page);
				}
				$tt_time_2 = ($tt_time_2 - 24);
				$i++;
			}
		}
	}
	else if (!empty($total_time)) {

		$s_arr_1 = explode(' ', $time);
		$s_arr = explode(':', $s_arr_1[1]);
		$st_time = $s_arr[0] + ($s_arr[1] / 60) + ($s_arr[2] / 3600);
		$start_time = round($st_time, 2);

		$t_arr = explode(':', $total_time);
		$tot_time = $t_arr[0] + ($t_arr[1] / 60) + ($t_arr[2] / 3600);
		$total_time = round($tot_time, 2);

		$total_time = $total_time;
		$end_hrs = $start_time + $total_time;

		$tt = sprintf('%02d:%02d', (int)$start_time, fmod($start_time, 1) * 60);
		if ($end_hrs < 24) {
			$tt = sprintf('%02d:%02d', (int)$end_hrs, fmod($end_hrs, 1) * 60);
			$end_time2 = $s_arr_1[0] . ' ' . $tt;
			$page = "INSERT INTO `cam_assign_crew_log_update`(`assign_crew_log_old_id`,`day_seq`,`station`,`station_id`,`position`,`position_id`,`user`,`user_id`,`assign_crew_transaction_id` ,`status`,`email_notification`,`assign_time`,`unassign_time`,`resource_type`,`total_time`,`first_assign_log_id`,`last_assigned_by`,`last_unassigned_by`) 
                values ('$assign_crew_log_id','1','$station','$station_id','$position','$position_id','$user','$user_id','$assign_crew_transaction_id','$status','$email_notification','$assign_time','$unassign_time','$resource_type','$total_time','$first_assign_log_id','$last_assigned_by','$last_unassigned_by')";
			$result1 = mysqli_query($db, $page);
		} else {

			$tt_time_1 = 24 - $start_time;
			$endtime_1 = $s_arr_1[0] . ' ' . '23:59:59';
			$page = "INSERT INTO `cam_assign_crew_log_update`(`assign_crew_log_old_id`,`day_seq`,`station`,`station_id`,`position`,`position_id`,`user`,`user_id`,`assign_crew_transaction_id` ,`status`,`email_notification`,`assign_time`,`unassign_time`,`resource_type`,`total_time`,`first_assign_log_id`,`last_assigned_by`,`last_unassigned_by`) 
                values ('$assign_crew_log_id','1','$station','$station_id','$position','$position_id','$user','$user_id','$assign_crew_transaction_id','$status','$email_notification','$assign_time','$endtime_1','$resource_type','$tt_time_1','$first_assign_log_id','$last_assigned_by','$last_unassigned_by')";
			$result1 = mysqli_query($db, $page);
			$start_date2 = $s_arr_1[0];
			$tt_time_2 = $total_time - $tt_time_1;
			$i = 2;
			while ($tt_time_2 > 0) {
				$start_date2 = date('Y-m-d', strtotime($start_date2 . " +1 days"));
				$start_time2 = $start_date2 . ' ' . '00:00:00';
				if ($tt_time_2 < 24) {
					$tt = sprintf('%02d:%02d', (int)$tt_time_2, fmod($tt_time_2, 1) * 60);
					$end_time2 = $start_date2 . ' ' . $tt;
					$page = "INSERT INTO `cam_assign_crew_log_update`(`assign_crew_log_old_id`,`day_seq`,`station`,`station_id`,`position`,`position_id`,`user`,`user_id`,`assign_crew_transaction_id` ,`status`,`email_notification`,`assign_time`,`unassign_time`,`resource_type`,`total_time`,`first_assign_log_id`,`last_assigned_by`,`last_unassigned_by`)                 
				values ('$assign_crew_log_id','$i','$station','$station_id','$position','$position_id','$user','$user_id','$assign_crew_transaction_id','$status','$email_notification','$start_time2','$end_time2','$resource_type','$tt_time_2','$first_assign_log_id','$last_assigned_by','$last_unassigned_by')";
					$result1 = mysqli_query($db, $page);
				} else {
					$end_time2 = $start_date2 . ' ' . '23:59:59';
					$page = "INSERT INTO `cam_assign_crew_log_update`(`assign_crew_log_old_id`,`day_seq`,`station`,`station_id`,`position`,`position_id`,`user`,`user_id`,`assign_crew_transaction_id` ,`status`,`email_notification`,`assign_time`,`unassign_time`,`resource_type`,`total_time`,`first_assign_log_id`,`last_assigned_by`,`last_unassigned_by`)                 
				values ('$assign_crew_log_id','$i','$station','$station_id','$position','$position_id','$user','$user_id','$assign_crew_transaction_id','$status','$email_notification','$start_time2','$end_time2','$resource_type','24','$first_assign_log_id','$last_assigned_by','$last_unassigned_by')";
					$result1 = mysqli_query($db, $page);
				}
				$tt_time_2 = ($tt_time_2 - 24);
				$i++;
			}
		}
	}

}
if ($result0) {

	$_SESSION['message_stauts_class'] = 'alert-success';
	$_SESSION['import_status_message'] = 'Form Created Sucessfully.';
} else {
	$_SESSION['message_stauts_class'] = 'alert-danger';
	$_SESSION['import_status_message'] = 'Please retry';
}

$url = "update_crew_assign_log.php";
header('Location: ' . $url, true, 303);

?>

