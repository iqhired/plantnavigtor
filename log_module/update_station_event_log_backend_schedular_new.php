<?php
include("../config.php");
$curdate = date('Y-m-d');

$button = "";
$temp = "";
if (!isset($_SESSION['user'])) {
	header('location: logout.php');
}
//$chicagotime1 = date('Y-m-d', strtotime('-1 days'));
//$sql_st = "SELECT * FROM `sg_station_event_log_update` ORDER BY `sg_station_event_old_id` DESC LIMIT 1 ";
//
//$result_st = mysqli_query($db,$sql_st);
//$row_st =  mysqli_fetch_array($result_st);
//$station_event_old_id = $row_st['sg_station_event_old_id'];

$sql0 = "SELECT * FROM sg_station_event_log_update where created_on like '$curdate%'";
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
	$current_time = date("Y-m-d H:i:s");
	$time = ($created_on);

//    $yesdate = date('Y-m-d H:i:s',strtotime("+2 days"));
//    $current_time = $yesdate;

	if (empty($total_time)) {
		$datetime1 = strtotime($current_time);
		$datetime2 = strtotime($time);

		$end_hrs_insecs = $datetime1 - $datetime2;
		$end_hrs = $end_hrs_insecs/3600;
		$k = $end_hrs/24;

        $s_arr_1 = explode(' ', $time);
        $s_arr = explode(':', $s_arr_1[1]);
        $st_time = $s_arr[0] + ($s_arr[1] / 60) + ($s_arr[2] / 3600);
        $start_time = round($st_time, 2);

        $c_arr_1 = explode(' ',$current_time);
        $c_arr = explode(':', $c_arr_1[1]);
        $cu_time = $c_arr[0] + ($c_arr[1] / 60) + ($c_arr[2] / 3600);
        $curr_time = round($cu_time, 2);




//        $end_hrs = ($current_time - $time) / 60;
		// $tt = sprintf('%02d:%02d', (int)$current_time, fmod($current_time, 1) * 60);
		if ($end_hrs < 24) {
			$tt = sprintf('%02d:%02d', (int)$end_hrs, fmod($end_hrs, 1) * 60);
			$end_time2 = $s_arr_1[0] . ' ' . $tt;

            $total_time = $curr_time - $start_time;

//			$page = "INSERT INTO `sg_station_event_log_update`(`sg_station_event_old_id`,`day_seq`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`)
//                values ('$station_event_log_id','1','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$created_on','$end_time2','$total_time','$created_by')";
            $page = "update sg_station_event_log_update set end_time ='$end_time2',total_time = '$total_time'";
			$result1 = mysqli_query($db, $page);

		}else{

			$co_sql = "SELECT COUNT(sg_station_event_update_id) FROM sg_station_event_log_update where station_event_id = '$station_event_id';";
			$result_sql = mysqli_query($db, $co_sql);
			$count_sql = mysqli_fetch_array($result_sql);
			$j = $count_sql[0];
			$i = 1;

 //			$co_sql = "SELECT sg_station_event_update_id, end_time FROM sg_station_event_log_new ORDER BY sg_station_event_update_id DESC LIMIT 1;";
//			$result_sql = mysqli_query($db, $co_sql);
//			$count_sql = mysqli_fetch_array($result_sql);
//			//  $j = $count_sql[0];
//			$j = $count_sql['sg_station_event_update_id'];
//			$en_time_new = $count_sql['end_time'];


			if($i > $j){
				$tt_time_1 = 24 - $start_time;
				$endtime_1 = $s_arr_1[0] . ' ' . '23:59:59';


				$page = "INSERT INTO `sg_station_event_log_update`(`sg_station_event_old_id`,`day_seq`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`)
                values ('$station_event_log_id','$i','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$created_on','$endtime_1','$tt_time_1','$created_by')";
				$result1 = mysqli_query($db, $page);
			}

			$start_date2 = $s_arr_1[0];
			$tt_time_2 = $end_hrs - $tt_time_1;

			$i = 2;
			$end_date_se ='';
			$start_date21 ='';
			$start_time21='';
			while($tt_time_2 > 0){

				if(($i == $j) && ( $i<$k)){
					$sql_se = "select end_time from sg_station_event_log_update where day_seq = '$i' AND station_event_id = '$station_event_id' ";
					$result_se = mysqli_query($db,$sql_se);
					$row_se = mysqli_fetch_array($result_se);
					$end_time_se = $row_se['end_time'];

					$end_time_se = explode(' ', $end_time_se);
					$end_date_se = $end_time_se[0];

					$end_se = $end_date_se . ' ' . '23:59:59';

					$sql_up = "update sg_station_event_log_update set total_time = '24' , end_time = '$end_se' where day_seq = '$i' AND station_event_id = '$station_event_id'";
					$result_up = mysqli_query($db,$sql_up);
				}
				if(($i > $j) && ( $j !=0)) {
					if(empty($start_date21)){
						$start_date21 = date('Y-m-d', strtotime($end_date_se . " +1 days"));
						$start_time21 = $start_date21 . ' ' . '00:00:00';
					}else{
						$start_date21 = date('Y-m-d', strtotime($start_date21 . " +1 days"));
						$start_time21 = $start_date21 . ' ' . '00:00:00';
					}

					if ($tt_time_2 < 24) {
						$tt = sprintf('%02d:%02d', (int)$tt_time_2, fmod($tt_time_2, 1) * 60);
						$end_time2 = $start_date21 . ' ' . $tt;
						$page = "INSERT INTO `sg_station_event_log_update`(`sg_station_event_old_id`,`day_seq`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`)                 
				values ('$station_event_log_id','$i','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$start_time21','$end_time2','$tt_time_2','$created_by')";
						$result1 = mysqli_query($db, $page);
					} else {
						$end_time2 = $start_date21 . ' ' . '23:59:59';
						$page = "INSERT INTO `sg_station_event_log_update`(`sg_station_event_old_id`,`day_seq`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`)                 
				values ('$station_event_log_id','$i','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$start_time21','$end_time2','24','$created_by')";
						$result1 = mysqli_query($db, $page);
					}
				}else if(empty($j)){
					$start_date2 = date('Y-m-d', strtotime($start_date2 . " +1 days"));
					$start_time2 = $start_date2 . ' ' . '00:00:00';

					if ($tt_time_2 < 24) {
						$tt = sprintf('%02d:%02d', (int)$tt_time_2, fmod($tt_time_2, 1) * 60);
						$end_time2 = $start_date2 . ' ' . $tt;
						$page = "INSERT INTO `sg_station_event_log_update`(`sg_station_event_old_id`,`day_seq`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`)                 
				values ('$station_event_log_id','$i','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$start_time2','$end_time2','$tt_time_2','$created_by')";
						$result1 = mysqli_query($db, $page);
					} else {
						$end_time2 = $start_date2 . ' ' . '23:59:59';
						$page = "INSERT INTO `sg_station_event_log_update`(`sg_station_event_old_id`,`day_seq`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`)                 
				values ('$station_event_log_id','$i','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$start_time2','$end_time2','24','$created_by')";
						$result1 = mysqli_query($db, $page);
					}
				}
				$tt_time_2 = ($tt_time_2 - 24);
				$i++;
			}
		}
	}else if(!empty($total_time)) {

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
//			$page = "INSERT INTO `sg_station_event_log_update`(`sg_station_event_old_id`,`day_seq`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`)
//                values ('$station_event_log_id','1','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$created_on','$end_time2','$total_time','$created_by')";
            $page = "update sg_station_event_log_update set end_time ='$end_time2',total_time = '$total_time'";
            $result1 = mysqli_query($db, $page);
		}else{

			$tt_time_1 = 24 - $start_time;
			$endtime_1 = $s_arr_1[0] . ' ' . '23:59:59';
			$page = "INSERT INTO `sg_station_event_log_update`(`sg_station_event_old_id`,`day_seq`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`) 
                values ('$station_event_log_id','1','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$created_on','$endtime_1','$tt_time_1','$created_by')";
			$result1 = mysqli_query($db, $page);
			$start_date2 = $s_arr_1[0];
			$tt_time_2 = $total_time - $tt_time_1;
			$i = 2;
			while($tt_time_2 > 0){
				$start_date2 = date('Y-m-d', strtotime($start_date2 . " +1 days"));
				$start_time2 = $start_date2 . ' ' . '00:00:00';
				if($tt_time_2 < 24){
					$tt = sprintf('%02d:%02d', (int)$tt_time_2, fmod($tt_time_2, 1) * 60);
					$end_time2 = $start_date2 . ' ' . $tt;
					$page = "INSERT INTO `sg_station_event_log_update`(`sg_station_event_old_id`,`day_seq`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`)                 
				values ('$station_event_log_id','$i','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$start_time2','$end_time2','$tt_time_2','$created_by')";
					$result1 = mysqli_query($db, $page);
				}else{
					$end_time2 = $start_date2 . ' ' . '23:59:59';
					$page = "INSERT INTO `sg_station_event_log_update`(`sg_station_event_old_id`,`day_seq`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`)                 
				values ('$station_event_log_id','$i','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$start_time2','$end_time2','24','$created_by')";
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

$url = "update_station_event_log_backend_page.php";
header('Location: ' . $url, true, 303);