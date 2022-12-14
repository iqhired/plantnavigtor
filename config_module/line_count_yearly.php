<?php
include("../config.php");
$chicagotime = date("Y-m-d");
$chicagotime1 = date("Y-m-d" , strtotime('-1 days'));
$yeardate = date("Y-m-d", strtotime('-12 month'));
$yes_yeardate = date("Y-m-d", strtotime($chicagotime1. ' -12 months'));
$diff = abs(strtotime($yeardate) - strtotime($chicagotime));
$y = ($diff/3600);
$station = $_POST['station'];

//select other data
$sql1 = sprintf("SELECT round(sum(total_time), 2) as t1 FROM sg_station_event_log_update  WHERE `line_id` = '$station' and event_cat_id not in ('2','3','4') and `created_on` < '$chicagotime' and `created_on` > ('$chicagotime' - interval 12 month)");
$result1 = mysqli_query($db,$sql1);
$row1 = $result1->fetch_assoc();
$t1 = $row1['t1'];
if(empty($t1)){
	$d0 = 0;
}else{
	$d0 = $t1;
}

//select line down data
$sql2 = sprintf("SELECT round(sum(total_time), 2) as t1 FROM sg_station_event_log_update  WHERE `line_id` = '$station' and event_cat_id = 2 and `created_on` < '$chicagotime' and `created_on` > ('$chicagotime' - interval 12 month)");
$result2 = mysqli_query($db,$sql2);
$row2 = $result2->fetch_assoc();
$t1 = $row2['t1'];
if(empty($t1)){
    $d1 = 0;
}else{
    $d1 = $t1;
}

$sql3 = sprintf("SELECT round(sum(total_time), 2) as t2 FROM sg_station_event_log_update  WHERE `line_id` = '$station' and event_cat_id = 3 and `created_on` < '$chicagotime' and  `created_on` > ('$chicagotime' - interval 12 month)");
$result3 = mysqli_query($db,$sql3);
$row3 = $result3->fetch_assoc();
$t2 = $row3['t2'];
if(empty($t2)){
    $d2 = 0;
}else{
    $d2 = $t2;
}

$sqlv = sprintf("SELECT round(sum(total_time), 2) as t3 FROM sg_station_event_log_update  WHERE `line_id` = '$station' and event_cat_id = 4 and `created_on` < '$chicagotime' and `created_on` > ('$chicagotime' - interval 12 month)");
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
    $d0 = $y - $d1 - $d2 - $d3;
    $posts[] = array('others3'=>$d0,'line_up3'=> $d1,'line_down3'=> $d2,'eof3'=> $d3,'yf'=> onlydateReadFormat($yes_yeardate),'yt'=> onlydateReadFormat($chicagotime1),'yh'=> $y);
}
$response['posts'] = $posts;
echo json_encode($response);





