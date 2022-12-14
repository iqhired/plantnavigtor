<?php include("../config.php");
$chicagotime = date("Y-m-d");
$monthdate = date("Y-m-d", strtotime('-1 month'));
$fd_monthdate = date("Y-m-d", strtotime("first day of this month"));
$fdl_monthdate = date("Y-m-d", strtotime("first day of previous month"));
$ld_monthdate = date("Y-m-d", strtotime("last day of previous month"));
$ldd_monthdate = date("Y-m-d", strtotime($fdl_monthdate. ' -1 day'));
$diff = abs(strtotime($fd_monthdate) - strtotime($fdl_monthdate));
$m = ($diff/3600);
$station = $_POST['station'];

//select other data
$sql1 = sprintf("SELECT round(sum(total_time), 2) as t1 FROM sg_station_event_log_update  WHERE `line_id` = '$station' and event_cat_id not in ('2','3','4') and `created_on` < '$fd_monthdate' and `created_on` >  '$fdl_monthdate' ");
$result1 = mysqli_query($db,$sql1);
$row1 = $result1->fetch_assoc();
$t1 = $row1['t1'];
if(empty($t1)){
	$d0 = 0;
}else{
	$d0 = $t1;
}

//select line down data
$sql2 = sprintf("SELECT round(sum(total_time), 2) as t1 FROM sg_station_event_log_update  WHERE `line_id` = '$station' and event_cat_id = 2 and `created_on` < '$fd_monthdate' and `created_on` >  '$fdl_monthdate' ");
$result2 = mysqli_query($db,$sql2);
$row2 = $result2->fetch_assoc();
$t1 = $row2['t1'];
if(empty($t1)){
    $d1 = 0;
}else{
    $d1 = $t1;
}

$sql3 = sprintf("SELECT round(sum(total_time), 2) as t2 FROM sg_station_event_log_update  WHERE `line_id` = '$station' and event_cat_id = 3 and `created_on` < '$fd_monthdate' and `created_on` >  '$fdl_monthdate' ");
$result3 = mysqli_query($db,$sql3);
$row3 = $result3->fetch_assoc();
$t2 = $row3['t2'];
if(empty($t2)){
    $d2 = 0;
}else{
    $d2 = $t2;
}

$sqlv = sprintf("SELECT round(sum(total_time), 2) as t3 FROM sg_station_event_log_update  WHERE `line_id` = '$station' and event_cat_id = 4 and `created_on` < '$fd_monthdate' and `created_on` >  '$fdl_monthdate' ");
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
    $posts[] = array('others2'=> $d0,'line_up2'=> $d1,'line_down2'=> $d2,'eof2'=> $d3,'mf'=> onlydateReadFormat($fdl_monthdate),'mt'=> onlydateReadFormat($ld_monthdate),'mh'=> $m);
}
$response['posts'] = $posts;
echo json_encode($response);





