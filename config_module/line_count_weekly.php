<?php
include("../config.php");
$station = $_POST['station'];
$chicagotime = date("Y-m-d");
//select line down data
$sql2 = sprintf("SELECT round(sum(sg_station_event_log_update.total_time), 2) as t1 FROM `sg_station_event` INNER JOIN sg_station_event_log_update ON sg_station_event.`station_event_id` = sg_station_event_log_update.`station_event_id` WHERE sg_station_event.`line_id` = '$station' and sg_station_event_log_update.event_cat_id = 2 and sg_station_event.`created_on` > '$chicagotime' - interval 7 day and sg_station_event_log_update.`created_on` > '$chicagotime' - interval 7 day");
$result2 = mysqli_query($db,$sql2);
$row2 = $result2->fetch_assoc();
$t1 = $row2['t1'];
if(empty($t1)){
    $d1 = 0;
}else{
    $d1 = $t1;
}

$sql3 = sprintf("SELECT round(sum(sg_station_event_log_update.total_time), 2) as t2 FROM `sg_station_event` INNER JOIN sg_station_event_log_update ON sg_station_event.`station_event_id` = sg_station_event_log_update.`station_event_id` WHERE sg_station_event.`line_id` = '$station' and sg_station_event_log_update.event_cat_id = 3 and sg_station_event.`created_on` > '$chicagotime' - interval 7 day and sg_station_event_log_update.`created_on` > '$chicagotime' - interval 7 day");
$result3 = mysqli_query($db,$sql3);
$row3 = $result3->fetch_assoc();
$t2 = $row3['t2'];
if(empty($t2)){
    $d2 = 0;
}else{
    $d2 = $t2;
}

$sqlv = sprintf("SELECT round(sum(sg_station_event_log_update.total_time), 2) as t3 FROM `sg_station_event` INNER JOIN sg_station_event_log_update ON sg_station_event.`station_event_id` = sg_station_event_log_update.`station_event_id` WHERE sg_station_event.`line_id` = '$station' and sg_station_event_log_update.event_cat_id = 4 and sg_station_event.`created_on` > '$chicagotime' - interval 7 day and sg_station_event_log_update.`created_on` > '$chicagotime' - interval 7 day");
$response = array();
$posts = array();
$resultv = mysqli_query($db,$sqlv);
//$result = $mysqli->query($sql);
$data =array();

while ($rowv=$resultv->fetch_assoc()){
    $t = $rowv['t3'];
    if(empty($t)){
        $d3 = 0;
    }else{
        $d3 = $t;
    }
    $posts[] = array('line_up1'=> $d1,'line_down1'=> $d2,'eof1'=> $d3);
}
$response['posts'] = $posts;
echo json_encode($response);





