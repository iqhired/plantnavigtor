<?php include("../config.php");
$curdate = date('Y-m-d');

$button = "";
$temp = "";

$sql_st_202 = "SELECT line_id FROM cam_line  where enabled = 1 and is_deleted = 0 ORDER BY `cam_line`.`line_id` ASC;";
$result_st_202 = mysqli_query($db, $sql_st_202);

while ($row_st_202 = mysqli_fetch_array($result_st_202)) {
	$ll_id = $row_st_202['line_id'];
	$sql_st_22 = "SELECT MAX(station_event_id) as m_ev FROM `sg_station_event` where line_id = '$ll_id' ;";
	$result_st_22 = mysqli_query($db, $sql_st_22);
	$row_st_22 = mysqli_fetch_array($result_st_22);
	$mev = $row_st_22['m_ev'];
	$sq_update = "update `sg_station_event_log` set is_incomplete = 1 , total_time = null where station_event_id = '$mev' ORDER BY `sg_station_event_log`.`event_seq` DESC limit 1;";
	mysqli_query($db, $sq_update);

//$sql_st = "SELECT * FROM `sg_station_event_log_update` where line_id = 3 ORDER BY `sg_station_event_old_id` DESC LIMIT 1";
	$sql_st = "SELECT MAX(sg_station_event_old_id) as s_id ,(line_id) FROM `sg_station_event_log_update` where line_id = '$ll_id' group by line_id  ORDER by line_id";
	$result_st = mysqli_query($db, $sql_st);
	$row_st = mysqli_fetch_array($result_st);
	if(empty($row_st)){
		$station_event_old_id = 0;
	}else{
		$station_event_old_id = $row_st['s_id'];
	}
	$l_id = $ll_id;
	$curdate1 = date('Y-m-d', strtotime('+1 days'));
//	while () {

//	$sql0 = "SELECT * FROM sg_station_event_log where  ignore_id != '1' AND station_event_log_id > '$station_event_old_id' AND  created_on < '$curdate1%'  OR  is_incomplete = 1";
		$sql0 = "SELECT slog.station_event_log_id ,slog.event_seq , slog.station_event_id , slog.event_cat_id , slog.is_incomplete , slog.event_type_id ,slog.created_on , slog.total_time ,slog.created_by FROM sg_station_event_log AS slog inner join sg_station_event AS se on slog.station_event_id = se.station_event_id where se.line_id= '$l_id' AND (slog.ignore_id != '1' AND slog.station_event_log_id > '$station_event_old_id' AND slog.created_on < '$curdate1%' OR slog.is_incomplete = 1);";
		$result0 = mysqli_query($db, $sql0);
		while ($row = mysqli_fetch_array($result0)) {
			$station_event_log_id = $row['station_event_log_id'];
			$event_seq = $row['event_seq'];
			$is_incomplete = $row['is_incomplete'];
			$station_event_id = $row['station_event_id'];
			$sql_seid = "select `line_id` from `sg_station_event` where station_event_id = '$station_event_id' order by line_id";
			$result_seid = mysqli_query($db, $sql_seid);
			$row_see = mysqli_fetch_array($result_seid);
			$line_id = $row_see['line_id'];

			if ($line_id != $l_id) {
				continue;
			}
//			if ($line_id == 47) {
//				$sgerg = 1;
//			}
			$i = 0;
			$station_cat_id = $row['event_cat_id'];
			$station_type_id = $row['event_type_id'];
			$event_status = $row['event_status'];
			$reason = $row['reason'];
			$created_on = $row['created_on'];
			$total_time = $row['total_time'];
			$created_by = $row['created_by'];
			$current_time = date("Y-m-d H:i:s");
			$time = ($created_on);

			//Created time details
			$s_arr_1 = explode(' ', $created_on);
			$s_arr = explode(':', $s_arr_1[1]);
			$create_date = $s_arr_1[0];
			$st_time = $s_arr[0] + ($s_arr[1] / 60) + ($s_arr[2] / 3600);
			$start_time = round($st_time, 2);

			//Current time details
			$s_arr_2 = explode(' ', $current_time);
			$s_arr2 = explode(':', $s_arr_2[1]);
			$current_date = $s_arr_2[0];
			$c_time2 = $s_arr2[0] + ($s_arr2[1] / 60) + ($s_arr2[2] / 3600);
			$c_time = round($c_time2, 2);

			//If if total time is present and the record is incomplete
			if (empty($total_time) || ($is_incomplete == 1)) {
				$co_sql = "SELECT COUNT(sg_station_event_update_id)  , SUM(total_time) FROM sg_station_event_log_update where station_event_id = '$station_event_id' and  sg_station_event_old_id = '$station_event_log_id';";
				$result_sql = mysqli_query($db, $co_sql);
				$count_sql = mysqli_fetch_array($result_sql);
				$z = $count_sql[0];
				$t_sum = $count_sql[1];
				//Fetch the day sequence
				$no_rec = 0;
				if (empty($z) || ($z === 0)) {
					$z = 1;
					$no_rec = 1;
				}
				//Calculate the total time.
				$datetime1 = strtotime($current_time);
				$datetime2 = strtotime($time);

				$end_hrs_insecs = $datetime1 - $datetime2;
				$end_hrs = $end_hrs_insecs / 3600;
				$k = $end_hrs / 24;
				$end_hrs = round($end_hrs, 2);
				$tot_fu_time = $start_time + $end_hrs;

				if ($tot_fu_time < 24) {
					if (($z == 1) && ($no_rec == 1)) {
						$tt_time_1 = $end_hrs;
						$end_time2 = $current_time;
						$page = "INSERT INTO `sg_station_event_log_update`(`line_id`,`sg_station_event_old_id`,`day_seq`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`)                 
				values ('$line_id','$station_event_log_id','$z','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$created_on','$end_time2','$tt_time_1','$created_by')";
						$result1 = mysqli_query($db, $page);
					} else {
						$tt = sprintf('%02d:%02d', (int)$tot_fu_time, fmod($tot_fu_time, 1) * 60);
						$end_time2 = $create_date . ' ' . $tt;
						$tt_time_1 = $end_hrs;
						$sql_up = "update sg_station_event_log_update set total_time = '$tt_time_1' , end_time = '$current_time' where day_seq = '$z' AND station_event_id = '$station_event_id' and  sg_station_event_old_id = '$station_event_log_id'";
						$result_up = mysqli_query($db, $sql_up);
					}
				} else {
					$loop_tot_time = $end_hrs;
					$rem_day_time = 24 - $start_time;
					if (($z == 1) && ($no_rec == 1)) {
						$tt_time_1 = $rem_day_time;
						$end_time2 = $create_date . ' ' . '23:59:59';
						$next_date = $create_date;
						$page = "INSERT INTO `sg_station_event_log_update`(`line_id`,`sg_station_event_old_id`,`day_seq`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`)                 
				values ('$line_id','$station_event_log_id','$z','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$created_on','$end_time2','$tt_time_1','$created_by')";
						$result1 = mysqli_query($db, $page);
						$z++;
						$loop_tot_time = $loop_tot_time - $rem_day_time;
					} else {

						$co_sql = "SELECT created_on , end_time FROM sg_station_event_log_update where day_seq = '$z' AND line_id = '$line_id' and station_event_id = '$station_event_id' and  sg_station_event_old_id = '$station_event_log_id';";
						$result_sql = mysqli_query($db, $co_sql);
						$d_sql = mysqli_fetch_array($result_sql);
						$crea_date = explode(' ', $d_sql['created_on']);
						$etime_date = explode(' ', $d_sql['end_time']);
						$next_date = $crea_date[0];

						if($z > 1){
							$loop_tot_time = $loop_tot_time - $rem_day_time - (24 * ($z - 2));
						}else{
							$loop_tot_time = $loop_tot_time - $rem_day_time;
						}
						if ($loop_tot_time > 24) {
							$end_time2 = $crea_date[0] . ' ' . '23:59:59';
//							$datetime31 = strtotime($d_sql['created_on']);
//							$datetime32 = strtotime($end_time2);
//							$t_32 = $datetime32 - $datetime31;
//							$end_t32 = $t_32 / 3600;
//							$end_t32 = round($end_t32, 2);
//							$rem_day_time = $end_t32;
							if($rem_day_time != 0 ){
								$sql_up = "update sg_station_event_log_update set total_time = '$rem_day_time' , end_time = '$end_time2' where day_seq = '$z' AND station_event_id = '$station_event_id' and  sg_station_event_old_id = '$station_event_log_id'";
								$result_up = mysqli_query($db, $sql_up);
								$loop_tot_time = $loop_tot_time - $rem_day_time;
								$rem_day_time = 0;
							}else{
								$sql_up = "update sg_station_event_log_update set total_time = '24' , end_time = '$end_time2' where day_seq = '$z' AND station_event_id = '$station_event_id' and  sg_station_event_old_id = '$station_event_log_id'";
								$result_up = mysqli_query($db, $sql_up);
								$loop_tot_time = $loop_tot_time - 24;
							}
							$z++;
						} else {
							$end_time2 = $current_time;
							$loop_tot_time = round($loop_tot_time, 2);
							$sql_up = "update sg_station_event_log_update set total_time = '$loop_tot_time' , end_time = '$end_time2' where day_seq = '$z' AND station_event_id = '$station_event_id' and  sg_station_event_old_id = '$station_event_log_id'";
							$result_up = mysqli_query($db, $sql_up);
							$z++;
							$loop_tot_time = 0;
						}
					}

					while ($loop_tot_time > 0) {
						$next_date = date('Y-m-d', strtotime($next_date . " +1 days"));
						if ($loop_tot_time > 24) {
							$created_on = $next_date . ' ' . '00:00:00';
							$end_time2 = $next_date . ' ' . '23:59:59';
							$tt_time_1 = 24;
							$page = "INSERT INTO `sg_station_event_log_update`(`line_id`,`sg_station_event_old_id`,`day_seq`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`)                 
				values ('$line_id','$station_event_log_id','$z','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$created_on','$end_time2','$tt_time_1','$created_by')";
							$result1 = mysqli_query($db, $page);
							$z++;
							$loop_tot_time = $loop_tot_time - 24;
						} else {
							$created_on = $next_date . ' ' . '00:00:00';
							$end_time2 = $current_time;
							$tt_time_1 = round($loop_tot_time, 2);
							$page = "INSERT INTO `sg_station_event_log_update`(`line_id`,`sg_station_event_old_id`,`day_seq`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`)                 
				values ('$line_id','$station_event_log_id','$z','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$created_on','$end_time2','$tt_time_1','$created_by')";
							$result1 = mysqli_query($db, $page);
							$loop_tot_time = $loop_tot_time - 24;
						}

					}
				}
			} else if (!empty($total_time)) {
				$sql_result1 = "Update sg_station_event_log SET is_incomplete = '0' where station_event_log_id = '$station_event_log_id'";
				$sql_result2 = mysqli_query($db, $sql_result1);
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
					$page = "INSERT INTO `sg_station_event_log_update`(`line_id`,`sg_station_event_old_id`,`day_seq`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`) 
                values ('$line_id','$station_event_log_id','1','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$created_on','$end_time2','$total_time','$created_by')";
					$result1 = mysqli_query($db, $page);
				} else {

					$tt_time_1 = 24 - $start_time;
					$endtime_1 = $s_arr_1[0] . ' ' . '23:59:59';
					$z = 1;
					$page = "INSERT INTO `sg_station_event_log_update`(`line_id`,`sg_station_event_old_id`,`day_seq`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`) 
                values ('$line_id','$station_event_log_id','$z','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$created_on','$endtime_1','$tt_time_1','$created_by')";
					$result1 = mysqli_query($db, $page);
					$start_date2 = $s_arr_1[0];
					$tt_time_2 = $total_time - $tt_time_1;
					$i++;

					while ($tt_time_2 > 0) {
						$start_date2 = date('Y-m-d', strtotime($start_date2 . " +1 days"));
						$start_time2 = $start_date2 . ' ' . '00:00:00';
						$z++;
						if ($tt_time_2 < 24) {
							$tt = sprintf('%02d:%02d', (int)$tt_time_2, fmod($tt_time_2, 1) * 60);
							$end_time2 = $start_date2 . ' ' . $tt;
							$page = "INSERT INTO `sg_station_event_log_update`(`line_id`,`sg_station_event_old_id`,`day_seq`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`)                 
				values ('$line_id','$station_event_log_id','$z','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$start_time2','$end_time2','$tt_time_2','$created_by')";
							$result1 = mysqli_query($db, $page);
						} else {
							$end_time2 = $start_date2 . ' ' . '23:59:59';
							$page = "INSERT INTO `sg_station_event_log_update`(`line_id`,`sg_station_event_old_id`,`day_seq`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`)                 
				values ('$line_id','$station_event_log_id','$z','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$start_time2','$end_time2','24','$created_by')";
							$result1 = mysqli_query($db, $page);
						}
						$tt_time_2 = ($tt_time_2 - 24);
						$i++;
					}
				}
			}
		}


}
$url = "update_station_event_log_backend_page.php";
header('Location: ' . $url, true, 303);