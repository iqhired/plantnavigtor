<?php include("../config.php");
$button_event = "button3";
$curdate = date('Y-m-d');
$dateto = $curdate;
$datefrom = $curdate;
$button = "";
$temp = "";

$_SESSION['station'] = "";
$_SESSION['date_from'] = "";
$_SESSION['date_to'] = "";
$_SESSION['button'] = "";
$_SESSION['timezone'] = "";
$_SESSION['button_event'] = "";
$_SESSION['event_type'] = "";
$_SESSION['event_category'] = "";

if (count($_POST) > 0) {
    $_SESSION['station'] = $_POST['station'];
    $_SESSION['date_from'] = $_POST['date_from'];
    $_SESSION['date_to'] = $_POST['date_to'];
    $_SESSION['button'] = $_POST['button'];
    $_SESSION['timezone'] = $_POST['timezone'];
    $_SESSION['button_event'] = $_POST['button_event'];
    $_SESSION['event_type'] = $_POST['event_type'];
    $_SESSION['event_category'] = $_POST['event_category'];
    $button_event = $_POST['button_event'];
    $event_type = $_POST['event_type'];
    $event_category = $_POST['event_category'];
    $station = $_POST['station'];
    $dateto = $_POST['date_to'];
    $datefrom = $_POST['date_from'];
    $button = $_POST['button'];
    $timezone = $_POST['timezone'];
    $diff = abs(strtotime($datefrom) - strtotime($dateto));
    $t = ($diff/3600);
}
if (count($_POST) > 0) {
    $st = $_POST['station'];
}else{
    $datefrom = $curdate;
    $dateto = $curdate;
}
//select other data
$sql11 = "SELECT round(sum(total_time), 2) as t0 FROM sg_station_event_log_update  WHERE `line_id` = '$st' and event_cat_id not in ('2','3','4')"." and DATE_FORMAT(`created_on`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`created_on`,'%Y-%m-%d') <= '$dateto' ";
$result11 = mysqli_query($db,$sql11);
$row11 = $result11->fetch_assoc();
$t0 = $row11['t0'];
if(empty($t0)){
    $d0 = 0;
}else{
    $d0 = $t0;
}

$sql1 = "SELECT round(sum(total_time),2) as t1 FROM `sg_station_event_log_update` WHERE `line_id` = '$st' and event_cat_id = 2"." and DATE_FORMAT(`created_on`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`created_on`,'%Y-%m-%d') <= '$dateto' ";
$result1 = mysqli_query($db,$sql1);
$row1 = $result1->fetch_assoc();
$t1 = $row1['t1'];
if(empty($t1)){
    $d1 = 0;
}else{
    $d1 = $t1;
}

$sql2 = "SELECT round(sum(total_time),2) as t2 FROM `sg_station_event_log_update` WHERE `line_id` = '$st' and event_cat_id = 3"." and DATE_FORMAT(`created_on`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`created_on`,'%Y-%m-%d') <= '$dateto' ";
$result2 = mysqli_query($db,$sql2);
$row2 = $result2->fetch_assoc();
$t2 = $row2['t2'];
if(empty($t2)){
    $d2 = 0;
}else{
    $d2 = $t2;
}

$sql3 = "SELECT round(sum(total_time),2) as t3 FROM `sg_station_event_log_update` WHERE `line_id` = '$st' and event_cat_id = 4"." and DATE_FORMAT(`created_on`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`created_on`,'%Y-%m-%d') <= '$dateto' ";
$response = array();
$posts = array();
$result3 = mysqli_query($db,$sql3);
//$result = $mysqli->query($sql);
$data =array();
while ($row3=$result3->fetch_assoc()){
    $t3 = $row3['t3'];
    if(empty($t3)){
        $d3 = 0;
    }else{
        $d3 = $t3;
    }
    if($st != ""){
        $posts[] = array('others0'=> $d0,'line_up'=> $d1,'line_down'=> $d2,'eop'=> $d3,'df'=> onlydateReadFormat($datefrom),'dt'=> onlydateReadFormat($dateto),'h'=> $t);
    }
}
$response['posts'] = $posts;
echo json_encode($response);


