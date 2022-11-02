<?php
include("../config.php");
$curdate = date('Y-m-d');

$button = "";
$temp = "";

$sql_st_22 = "SELECT MAX(station_event_id) as m_ev, line_id FROM `sg_station_event` where line_id != 0 group by line_id ORDER by line_id;";
$result_st_22 = mysqli_query($db,$sql_st_22);
while ($row_st_22 = mysqli_fetch_array($result_st_22)){
	$mev = $row_st_22['m_ev'];
	$sq_update = "update `sg_station_event_log` set is_incomplete = 1 , total_time = null where station_event_id = '$mev' ORDER BY `sg_station_event_log`.`event_seq` DESC limit 1;";
	mysqli_query($db,$sq_update);
}
//$sql_st = "SELECT * FROM `sg_station_event_log_update` where line_id = 3 ORDER BY `sg_station_event_old_id` DESC LIMIT 1";
$sql_st = "SELECT MAX(sg_station_event_old_id) as s_id ,(line_id) FROM `sg_station_event_log_update` where line_id != 0 group by line_id  ORDER by line_id";
$result_st = mysqli_query($db,$sql_st);

$curdate1 = date('Y-m-d', strtotime('+1 days'));
while ($row_st = mysqli_fetch_array($result_st)){
	$station_event_old_id = $row_st['s_id'];
	$l_id = $row_st['line_id'];
	$sql0 = "SELECT * FROM sg_station_event_log where  ignore_id != '1' AND station_event_log_id > '$station_event_old_id' AND  created_on < '$curdate1%'  OR  is_incomplete = 1";
	$result0 = mysqli_query($db, $sql0);
	while ($row = mysqli_fetch_array($result0)) {
		$station_event_log_id = $row['station_event_log_id'];
		$event_seq = $row['event_seq'];
		$is_incomplete = $row['is_incomplete'];
		$station_event_id = $row['station_event_id'];
		$sql_seid = "select `line_id` from `sg_station_event` where station_event_id = '$station_event_id' order by line_id";
		$result_seid = mysqli_query($db,$sql_seid);
		$row_see = mysqli_fetch_array($result_seid);
		$line_id = $row_see['line_id'];

		if ($line_id != $l_id) {
			continue;
		}
		if(($line_id == 48) ){
			$reerfge = 1;
		}
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

//    $yesdate = date('Y-m-d H:i:s',strtotime("+2 days"));
//    $current_time = $yesdate;

		if (empty($total_time) || ($is_incomplete == 1)) {
			$datetime1 = strtotime($current_time);
			$datetime2 = strtotime($time);

			$end_hrs_insecs = $datetime1 - $datetime2;
			$end_hrs = $end_hrs_insecs/3600;
			$k = $end_hrs/24;
//        $end_hrs = ($current_time - $time) / 60;
			// $tt = sprintf('%02d:%02d', (int)$current_time, fmod($current_time, 1) * 60);
			if ($end_hrs < 24) {
				$tt = sprintf('%02d:%02d', (int)$end_hrs, fmod($end_hrs, 1) * 60);
				$end_time2 = $curdate . ' ' . $tt;
				if ($created_on < $curdate) {

					$s_arr_1 = explode(' ', $created_on);
					$s_arr = explode(':', $s_arr_1[1]);
					$st_time = $s_arr[0] + ($s_arr[1] / 60) + ($s_arr[2] / 3600);
					$start_time = round($st_time, 2);


					$tt_time_1 = 24 - $start_time;
					$tt_time_2 = $end_hrs - $tt_time_1;

					$end_time2 = $s_arr_1[0] . ' ' . '23:59:59';

					if ($z === 0){
						$z = 1;
					}
					$page = "INSERT INTO `sg_station_event_log_update`(`line_id`,`sg_station_event_old_id`,`day_seq`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`)                 
				values ('$line_id','$station_event_log_id','$z','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$created_on','$end_time2','$tt_time_1','$created_by')";
					$result1 = mysqli_query($db, $page);

					$sql_result = "Update sg_station_event_log SET is_incomplete = '1' where station_event_log_id = '$station_event_log_id'";
					$sql_result1 = mysqli_query($db,$sql_result);

//                 $z++;


//                $start_time2 = $curdate . ' ' . '00:00:00';
//                $page = "INSERT INTO `sg_station_event_log_update`(`sg_station_event_old_id`,`day_seq`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`)
//				values ('$station_event_log_id','$z','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$start_time2','$current_time','$tt_time_2','$created_by')";
//                $result1 = mysqli_query($db, $page);


				}
//            else{
//                if ($z === 0){
//                    $z = 1;
//                }
//                $page = "INSERT INTO `sg_station_event_log_update`(`sg_station_event_old_id`,`day_seq`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`)
//                values ('$station_event_log_id','$z','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$created_on','$end_time2','$total_time','$created_by')";
//                $result1 = mysqli_query($db, $page);
//            }

			}else{

				$co_sql = "SELECT COUNT(sg_station_event_update_id)  , SUM(total_time) FROM sg_station_event_log_update where station_event_id = '$station_event_id' and  sg_station_event_old_id = '$station_event_log_id';";
				$result_sql = mysqli_query($db, $co_sql);
				$count_sql = mysqli_fetch_array($result_sql);
				$j = $count_sql[0];
				$tt_ains = $count_sql[1];
				$end_hrs = $end_hrs - $tt_ains;
				$i++;

				$co_sql = "SELECT day_seq , end_time FROM sg_station_event_log_update where station_event_id = '$station_event_id' order by created_on desc Limit 1;";
				$result_sql = mysqli_query($db, $co_sql);
				$ds_sql = mysqli_fetch_array($result_sql);
				$z = $ds_sql[0];
				$et_time = $ds_sql[1];

				if (empty($z)){
					$z = 1;
				}


//
//			$co_sql = "SELECT sg_station_event_update_id, end_time FROM sg_station_event_log_new ORDER BY sg_station_event_update_id DESC LIMIT 1;";
//			$result_sql = mysqli_query($db, $co_sql);
//			$count_sql = mysqli_fetch_array($result_sql);
//			//  $j = $count_sql[0];
//			$j = $count_sql['sg_station_event_update_id'];
//			$en_time_new = $count_sql['end_time'];

				$s_arr_1 = explode(' ', $time);
				$s_arr = explode(':', $s_arr_1[1]);
				$st_time = $s_arr[0] + ($s_arr[1] / 60) + ($s_arr[2] / 3600);
				$start_time = round($st_time, 2);

				$c_arr_1 = explode(' ',$current_time);

				if($i > $j){
					$tt_time_1 = 24 - $start_time;
					$endtime_1 = $s_arr_1[0] . ' ' . '23:59:59';
					$c_arr = explode(':', $c_arr_1[1]);
					$cu_time = $c_arr[0] + ($c_arr[1] / 60) + ($c_arr[2] / 3600);
					$curr_time = round($cu_time, 2);

					$page = "INSERT INTO `sg_station_event_log_update`(`line_id`,`sg_station_event_old_id`,`day_seq`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`)
                values ('$line_id','$station_event_log_id','$z','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$created_on','$endtime_1','$tt_time_1','$created_by')";
					$result1 = mysqli_query($db, $page);
				}
				$i = $z;

				$start_date2 = $s_arr_1[0];
				$tt_time_2 = $end_hrs - $tt_time_1;

				//$i++;
				$end_date_se ='';
				$start_date21 ='';
				$start_time21='';


				$end_time_se_tt = explode(' ', $et_time);
				$et_tt = $end_time_se_tt[0];
				$n = $z;
				while($tt_time_2 > 0){
					if(($tt_time_1 == null) &&  ( $z>$k)){

						$sql_se = "select end_time from sg_station_event_log_update where day_seq = '$n' AND station_event_id = '$station_event_id' ";
						$result_se = mysqli_query($db,$sql_se);
						$row_se = mysqli_fetch_array($result_se);
						$end_time_se = $row_se['end_time'];

						$end_time_se = explode(' ', $end_time_se);
						$end_date_se = $end_time_se[0];
						$end_date_se_tm = $end_time_se[1];
						$en_arr = explode(':', $end_time_se[1]);
						$end_date_se_t = $en_arr[0] + ($en_arr[1] / 60) + ($en_arr[2] / 3600);
						$end_date_se_tm = round($end_date_se_t, 2);

						if((($end_date_se_tm < 24 ) && ($tt_time_2 > 24))) {

							$tt_time_2 = $tt_time_2 + $end_date_se_tm;
							$end_se = $end_date_se . ' ' . '23:59:59';
							$sql_up = "update sg_station_event_log_update set total_time = '24' , end_time = '$end_se' where day_seq = '$n' AND station_event_id = '$station_event_id'";
							$result_up = mysqli_query($db,$sql_up);
							$tt_updated = 1;
						}else if((($end_date_se_tm < 24 ) && ($tt_time_2 < 24))){
							$tt_time_3 = $tt_time_2 + $end_date_se_tm;
							if($tt_time_3 >= 24){
								$n++;
								if(!empty($end_date_se)){
									$start_date21 = date('Y-m-d', strtotime($end_date_se . " +1 days"));
									$start_time21 = $start_date21 . ' ' . '00:00:00';
									$e_time21 = $start_date21 . ' ' . '23:59:59';
								}
								$page = "INSERT INTO `sg_station_event_log_update`(`line_id`,`sg_station_event_old_id`,`day_seq`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`)                 
				values ('$line_id','$station_event_log_id','$n','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$start_time21','$e_time21','24','$created_by')";
								$result1 = mysqli_query($db, $page);
								$tt_time_2 = $tt_time_2 + $end_date_se_tm;
							}else{
								$end_se = $end_date_se . ' ' . $c_arr_1[1];
								$sql_up = "update sg_station_event_log_update set total_time = '$tt_time_2' , end_time = '$end_se' where day_seq = '$n' AND station_event_id = '$station_event_id'";
								$result_up = mysqli_query($db,$sql_up);
							}
						}else if((($end_date_se_tm >= 24 ) && ($tt_time_2 > 24))){
							$n++;
							$start_date21 = '';
							if(!empty($end_date_se)){
								$start_date21 = date('Y-m-d', strtotime($end_date_se . " +1 days"));
								$start_time21 = $start_date21 . ' ' . '00:00:00';
								$e_time21 = $start_date21 . ' ' . '23:59:59';
							}
							$page = "INSERT INTO `sg_station_event_log_update`(`line_id`,`sg_station_event_old_id`,`day_seq`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`)                 
				values ('$line_id','$station_event_log_id','$n','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$start_time21','$e_time21','24','$created_by')";
							$result1 = mysqli_query($db, $page);

						}else if((($end_date_se_tm >= 24 ) && ($tt_time_2 < 24)) ){
							$n++;
							$start_date21 = '';
							if(!empty($end_date_se)){
								$start_date21 = date('Y-m-d', strtotime($end_date_se . " +1 days"));
								$start_time21 = $start_date21 . ' ' . '00:00:00';
								$e_time21 = $start_date21 . ' ' . $c_arr_1[1];
							}
							$page = "INSERT INTO `sg_station_event_log_update`(`line_id`,`sg_station_event_old_id`,`day_seq`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`)                 
				values ('$line_id','$station_event_log_id','$n','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$start_time21','$e_time21','$tt_time_2','$created_by')";
							$result1 = mysqli_query($db, $page);
						}

					} else if($i == $j){

						$sql_se = "select end_time from sg_station_event_log_update where day_seq = '$j' AND station_event_id = '$station_event_id' ";
						$result_se = mysqli_query($db,$sql_se);
						$row_se = mysqli_fetch_array($result_se);
						$end_time_se = $row_se['end_time'];

						$end_time_se = explode(' ', $end_time_se);
						$end_date_se = $end_time_se[0];
						if($tt_time_2 > 24 ) {
							$end_date_se_tm = $end_time_se[1];


							$en_arr = explode(':', $end_time_se[1]);
							$end_date_se_t = $en_arr[0] + ($en_arr[1] / 60) + ($en_arr[2] / 3600);
							$end_date_se_tm = round($end_date_se_t, 2);
							$tt_time_2 = $tt_time_2 + $end_date_se_tm;
						}
						$end_se = $end_date_se . ' ' . '23:59:59';
						//$z++;
						$sql_up = "update sg_station_event_log_update set total_time = '24' , end_time = '$end_se' where day_seq = '$z' AND station_event_id = '$station_event_id'";
						$result_up = mysqli_query($db,$sql_up);
					} else if(($i == $j) && ( $z<$k)){
						$sql_se = "select end_time from sg_station_event_log_update where day_seq = '$j' AND station_event_id = '$station_event_id' ";
						$result_se = mysqli_query($db,$sql_se);
						$row_se = mysqli_fetch_array($result_se);
						$end_time_se = $row_se['end_time'];

						$end_time_se = explode(' ', $end_time_se);
						$end_date_se = $end_time_se[0];
						if($tt_time_2 > 24 ) {
							$end_date_se_tm = $end_time_se[1];
							$en_arr = explode(':', $end_time_se[1]);
							$end_date_se_t = $en_arr[0] + ($en_arr[1] / 60) + ($en_arr[2] / 3600);
							$end_date_se_tm = round($end_date_se_t, 2);
							$tt_time_2 = $tt_time_2 + $end_date_se_tm;
						}
						$end_se = $end_date_se . ' ' . '23:59:59';

						$sql_up = "update sg_station_event_log_update set total_time = '24' , end_time = '$end_se' where day_seq = '$z' AND station_event_id = '$station_event_id'";
						$result_up = mysqli_query($db,$sql_up);
					}else if(($i > $j) && ( $j !=0)) {
						if(empty($start_date21)){
							if(!empty($end_date_se)){
								$start_date21 = date('Y-m-d', strtotime($end_date_se . " +1 days"));
								$start_time21 = $start_date21 . ' ' . '00:00:00';
							}elseif (!empty($endtime_1)){
								$s_et = explode(' ', $endtime_1);
								$start_date21 = date('Y-m-d', strtotime($s_et[0] . " +1 days"));
								$start_time21 = $start_date21 . ' ' . '00:00:00';
							}elseif  (!empty($et_time)){
								$s_et = explode(' ', $et_time);
								$start_date21 = date('Y-m-d', strtotime($s_et[0] . " +1 days"));
								$start_time21 = $start_date21 . ' ' . '00:00:00';
							}
						}else{
							$start_date21 = date('Y-m-d', strtotime($start_date21 . " +1 days"));
							$start_time21 = $start_date21 . ' ' . '00:00:00';
						}
						$z++;
						if ($tt_time_2 < 24) {
							$tt = sprintf('%02d:%02d', (int)$tt_time_2, fmod($tt_time_2, 1) * 60);
							$end_time2 = $start_date21 . ' ' . $tt;
							$page = "INSERT INTO `sg_station_event_log_update`(`line_id`,`sg_station_event_old_id`,`day_seq`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`)                 
				values ('$line_id','$station_event_log_id','$z','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$start_time21','$end_time2','$tt_time_2','$created_by')";
							$result1 = mysqli_query($db, $page);
						} else {
							$end_time2 = $start_date21 . ' ' . '23:59:59';
							$page = "INSERT INTO `sg_station_event_log_update`(`line_id`,`sg_station_event_old_id`,`day_seq`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`)                 
				values ('$line_id','$station_event_log_id','$z','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$start_time21','$end_time2','24','$created_by')";
							$result1 = mysqli_query($db, $page);
						}
					}else if(empty($j)){
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
					}else{
						$z--;
					}
					$tt_time_2 = ($tt_time_2 - 24);
					$i++;
				}
				$sql_result1 = "Update sg_station_event_log SET is_incomplete = '1' where station_event_log_id = '$station_event_log_id'";
				$sql_result2 = mysqli_query($db,$sql_result1);
			}
		}else if(!empty($total_time)) {
			$sql_result1 = "Update sg_station_event_log SET is_incomplete = '0' where station_event_log_id = '$station_event_log_id'";
			$sql_result2 = mysqli_query($db,$sql_result1);
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
			}else{

				$tt_time_1 = 24 - $start_time;
				$endtime_1 = $s_arr_1[0] . ' ' . '23:59:59';
				$z = 1;
				$page = "INSERT INTO `sg_station_event_log_update`(`line_id`,`sg_station_event_old_id`,`day_seq`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`) 
                values ('$line_id','$station_event_log_id','$z','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$created_on','$endtime_1','$tt_time_1','$created_by')";
				$result1 = mysqli_query($db, $page);
				$start_date2 = $s_arr_1[0];
				$tt_time_2 = $total_time - $tt_time_1;
				$i++;

				while($tt_time_2 > 0){
					$start_date2 = date('Y-m-d', strtotime($start_date2 . " +1 days"));
					$start_time2 = $start_date2 . ' ' . '00:00:00';
					$z++;
					if($tt_time_2 < 24){
						$tt = sprintf('%02d:%02d', (int)$tt_time_2, fmod($tt_time_2, 1) * 60);
						$end_time2 = $start_date2 . ' ' . $tt;
						$page = "INSERT INTO `sg_station_event_log_update`(`line_id`,`sg_station_event_old_id`,`day_seq`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`)                 
				values ('$line_id','$station_event_log_id','$z','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$start_time2','$end_time2','$tt_time_2','$created_by')";
						$result1 = mysqli_query($db, $page);
					}else{
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