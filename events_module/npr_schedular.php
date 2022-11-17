<?php include("../config.php");
$chicagotime = date("Y-m-d H:i:s");
$chicagotime_to_date = date("Y-m-d");
$chicagotime_from_date = date("Y-m-d", strtotime('-1 hour'));
$oneHourAgo= date('H', strtotime('-1 hour'));
$oneHourLater= date('H', strtotime('+1 hour'));
echo 'One hour ago, the date = ' . $oneHourAgo;
echo 'One hour Later, the date = ' . $oneHourLater;
$time = date("H");
$page = $_SERVER['PHP_SELF'];
$sec = "36000";

$sql_st_202 = "SELECT line_id FROM cam_line  where enabled = 1 and is_deleted = 0 ORDER BY `cam_line`.`line_id` ASC;";
$result_st_202 = mysqli_query($db, $sql_st_202);

while ($row_st_202 = mysqli_fetch_array($result_st_202)) {
	$ll_id = $row_st_202['line_id'];
	$sql = "SELECT SUM(good_pieces) as good_pieces,SUM(bad_pieces) AS bad_pieces,SUM(rework) as rework , good_bad_pieces_details.station_event_id as sei FROM `good_bad_pieces_details`  INNER JOIN sg_station_event ON good_bad_pieces_details.station_event_id = sg_station_event.station_event_id where 1  and sg_station_event.line_id = '$ll_id' and date(`created_at`) >= '$chicagotime_from_date' and date(`created_at`) <= '$chicagotime_to_date' and hour(good_bad_pieces_details.created_at) >= '$time'  and hour(good_bad_pieces_details.created_at) < '$oneHourLater'";
	$result1 = mysqli_query($db, $sql);
	$rowc = mysqli_fetch_array($result1);
	$gp = $rowc['good_pieces'];
	$bp = $rowc['bad_pieces'];
	$rwp = $rowc['rework'];
	$station_event_id = $rowc['sei'];
	$gr = $gp + $rwp;
	$npr_data = $time . ":" . $gr . ":" . $bp;

	$sql_st_2021 = "SELECT count(*) as r_count FROM npr_station_data  where line_id = '$ll_id' and npr_h = '$time' and date(created_on) = '$chicagotime_to_date'";
	$result_st_2021 = mysqli_query($db, $sql_st_2021);
	$rowc_2021 = mysqli_fetch_array($result_st_2021);
	$r_count  = $rowc_2021['r_count'];
	if(($r_count == 0) && ((!empty($gr) && ($gr > 0) ) || (!empty($bp) && ($bp >0)))){
		$sqlt = "INSERT INTO `npr_station_data`(`line_id`,`npr_data`,`npr_h`, `npr_gr`,`npr_g`, `npr_b`,`npr_rework`,`created_on`) VALUES ('$ll_id','$npr_data','$time','$gr','$gp','$bp','$rwp','$chicagotime')";
		$resultt = mysqli_query($db, $sqlt);
	}else{
		$sqlt = "update `npr_station_data` set npr_data = '$npr_data' , `npr_gr` = '$gr',`npr_g` = '$gp', `npr_b` = '$bp' ,`npr_rework` = '$rwp' ,`created_on` = '$chicagotime'  where line_id = '$ll_id' and npr_h = '$time' and date(created_on) = '$chicagotime_to_date' ";
		$resultt = mysqli_query($db, $sqlt);
	}

}
?>