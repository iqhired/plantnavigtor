<?php
include("../config.php");
$station = $_POST['station'];
//select line down data
$sql2 = sprintf("SELECT distinct sg_station_event.`line_id`,sg_station_event.`created_on`,sg_station_event.`station_event_id`,round(IFNULL(SEC_TO_TIME( SUM( TIME_TO_SEC( sg_station_event_log_update.`total_time` ) ) ),'00:00:00')) as t1,sg_station_event_log_update.`event_cat_id` FROM `sg_station_event` INNER JOIN sg_station_event_log_update on sg_station_event.station_event_id = sg_station_event_log_update.station_event_id WHERE Month(sg_station_event.`created_on`) = Month(CURDATE()) and  sg_station_event.line_id = '$station' and sg_station_event_log_update.event_cat_id = 3");
$result2 = mysqli_query($db,$sql2);
$row2 = $result2->fetch_assoc();
$t1 = $row2['t1'];

$sql3 = sprintf("SELECT distinct sg_station_event.`line_id`,sg_station_event.`created_on`,sg_station_event.`station_event_id`,round(IFNULL(SEC_TO_TIME( SUM( TIME_TO_SEC( sg_station_event_log_update.`total_time` ) ) ),'00:00:00')) as t2,sg_station_event_log_update.`event_cat_id` FROM `sg_station_event` INNER JOIN sg_station_event_log_update on sg_station_event.station_event_id = sg_station_event_log_update.station_event_id WHERE Month(sg_station_event.`created_on`) = Month(CURDATE()) and  sg_station_event.line_id = '$station' and sg_station_event_log_update.event_cat_id = 4");
$result3 = mysqli_query($db,$sql3);
$row3 = $result3->fetch_assoc();
$t2 = $row3['t2'];


$sqlv = sprintf("SELECT distinct sg_station_event.`line_id`,sg_station_event.`created_on`,sg_station_event.`station_event_id`,round(IFNULL(SEC_TO_TIME( SUM( TIME_TO_SEC( sg_station_event_log_update.`total_time` ) ) ),'00:00:00')) as t3,sg_station_event_log_update.`event_cat_id` FROM `sg_station_event` INNER JOIN sg_station_event_log_update on sg_station_event.station_event_id = sg_station_event_log_update.station_event_id WHERE Month(sg_station_event.`created_on`) = Month(CURDATE()) and  sg_station_event.line_id = '$station' and sg_station_event_log_update.event_cat_id = 2");
$response = array();
$posts = array();
$resultv = mysqli_query($db,$sqlv);
//$result = $mysqli->query($sql);
$data =array();

while ($rowv=$resultv->fetch_assoc()){
    $time = $rowv['t3'];
    if($time === 0){
        $t = 0;
    }else{
        $t = $time;
    }
    $posts[] = array('line_up2'=> $t,'line_down2'=> $t1,'eof2'=> $t2);
}
$response['posts'] = $posts;
echo json_encode($response);





