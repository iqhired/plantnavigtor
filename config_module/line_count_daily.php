<?php include("../config.php");
$chicagotime = date("Y-m-d" , strtotime('-4 days'));
$dh = date("H");
$station = $_POST['station'];
//select line down data
//$sql2 = sprintf("SELECT round(IFNULL(SEC_TO_TIME( SUM( TIME_TO_SEC( sg_station_event_log.`total_time` ) ) ),'00:00:00')) as t1 FROM `sg_station_event` INNER JOIN sg_station_event_log on sg_station_event.station_event_id = sg_station_event_log.station_event_id WHERE date(sg_station_event.`created_on`) = '$chicagotime' and sg_station_event.line_id = '$station' and sg_station_event_log.event_cat_id = 3");
$sql2 = sprintf("SELECT ( SUM( sg_station_event_log_update.`total_time` )) as t1 FROM sg_station_event_log_update WHERE date(`created_on`) = '$chicagotime' and line_id = '$station' and event_cat_id = 3");
$result2 = mysqli_query($db,$sql2);
$row2 = $result2->fetch_assoc();
$t1 = $row2['t1'];

$sql3 = sprintf("SELECT ( SUM( sg_station_event_log_update.`total_time` )) as t2 FROM sg_station_event_log_update WHERE date(`created_on`) = '$chicagotime' and line_id = '$station' and event_cat_id = 4");
$result3 = mysqli_query($db,$sql3);
$row3 = $result3->fetch_assoc();
$t2 = $row3['t2'];


$sqlv = sprintf("SELECT ( SUM( sg_station_event_log_update.`total_time` )) as t3 FROM sg_station_event_log_update WHERE date(`created_on`) = '$chicagotime' and line_id = '$station' and event_cat_id = 2");
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
	$dh = $t1 + $t2 + $t;
	$posts[] = array('line_up'=> $t,'line_down'=> $t1,'eof'=> $t2,'d'=> $chicagotime,'dh'=> $dh);
}
$response['posts'] = $posts;
echo json_encode($response);