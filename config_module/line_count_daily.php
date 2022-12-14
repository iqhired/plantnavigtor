<?php include("../config.php");
$chicagotime = date("Y-m-d");
$chicagotime1 = date("Y-m-d H:i:s");
//$dh = date("H");
$s_arr_1 = explode(' ', $chicagotime1);
$s_arr = explode(':', $s_arr_1[1]);
$create_date = $s_arr_1[0];
$st_time = $s_arr[0] + ($s_arr[1] / 60) + ($s_arr[2] / 3600);
$dh = round($st_time, 2);
$station = $_POST['station'];

//select other data
$sql1 = sprintf("SELECT round(sum(total_time), 2) as t1 FROM sg_station_event_log_update  WHERE `line_id` = '$station' and event_cat_id not in ('2','3','4') and date(`created_on`) = '$chicagotime' ");
$result1 = mysqli_query($db,$sql1);
$row1 = $result1->fetch_assoc();
$t1 = $row1['t1'];
if(empty($t1)){
	$d0 = 0;
}else{
	$d0 = $t1;
}

//select line down data
//$sql2 = sprintf("SELECT round(IFNULL(SEC_TO_TIME( SUM( TIME_TO_SEC( sg_station_event_log.`total_time` ) ) ),'00:00:00')) as t1 FROM `sg_station_event` INNER JOIN sg_station_event_log on sg_station_event.station_event_id = sg_station_event_log.station_event_id WHERE date(sg_station_event.`created_on`) = '$chicagotime' and sg_station_event.line_id = '$station' and sg_station_event_log.event_cat_id = 3");
$sql2 = sprintf("SELECT ( SUM( `total_time` )) as t1 FROM sg_station_event_log_update WHERE date(`created_on`) = '$chicagotime' and line_id = '$station' and event_cat_id = 3");
$result2 = mysqli_query($db,$sql2);
$row2 = $result2->fetch_assoc();
$t1 = $row2['t1'];

$sql3 = sprintf("SELECT ( SUM( `total_time` )) as t2 FROM sg_station_event_log_update WHERE date(`created_on`) = '$chicagotime' and line_id = '$station' and event_cat_id = 4");
$result3 = mysqli_query($db,$sql3);
$row3 = $result3->fetch_assoc();
$t2 = $row3['t2'];


$sqlv = sprintf("SELECT ( SUM( `total_time` )) as t3 FROM sg_station_event_log_update WHERE date(`created_on`) = '$chicagotime' and line_id = '$station' and event_cat_id = 2");
$response = array();
$posts = array();
$resultv = mysqli_query($db,$sqlv);

while ($rowv=$resultv->fetch_assoc()){
	$time = $rowv['t3'];
	if($time === 0){
		$t = 0;
	}else{
		$t = $time;
	}
//	$dh = $t1 + $t2 + $t + $d0;
//	$dh = round($dh, 2);
	$posts[] = array('others'=>$d0,'line_up'=> $t,'line_down'=> $t1,'eof'=> $t2,'d'=> onlydateReadFormat($chicagotime),'dh'=> $dh);
}
$response['posts'] = $posts;
echo json_encode($response);