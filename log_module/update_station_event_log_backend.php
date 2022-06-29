<?php
include("../config.php");
$curdate = date('Y-m-d');

$button = "";
$temp = "";
if (!isset($_SESSION['user'])) {
    header('location: logout.php');
}
if (count($_POST) > 0) {

    $page_from = $_POST['id_from'];
    $page_to = $_POST['id_to'];
}
$sql0 = "select * from sg_station_event_log WHERE station_event_log_id BETWEEN '$page_from' AND '$page_to'";

$result0 = mysqli_query($db, $sql0);
while($row = mysqli_fetch_array($result0)){
    $station_event_log_id = $row['station_event_log_id'];
    $event_seq = $row['event_seq'];
    $station_event_id = $row['station_event_id'];
    $station_cat_id = $row['station_cat_id'];
    $station_type_id = $row['station_type_id'];
    $event_status = $row['event_status'];
    $reason = $row['reason'];
    $created_on = $row['created_on'];
    $total_time = $row['total_time'];
    $created_by = $row['created_by'];

    $time = cast($created_on);
    if(!empty($time)){
        $s_arr = explode(':',$time);
        $st_time = $s_arr[0] + ($s_arr[1] / 60) + ($s_arr[2] /3600);
        $start_time = round($st_time, 3);
    }
    if(!empty($total_time)){
        $t_arr = explode(':',$total_time);
        $tot_time = $t_arr[0] + ($t_arr[1] / 60) + ($t_arr[2] /3600);
        $total_time = round($tot_time, 3);
    }
    $diff = $total_time - $start_time;
    if($diff > '24'){
        $page = "INSERT INTO `sg_station_log_update`(`sg_station_event_old_id`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`) 
                
values ('$station_event_log_id','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$created_on','$diff','$total_time','$created_by');" ;

    }else {
        $page = "INSERT INTO `sg_station_log_update`(`sg_station_event_old_id`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`) 
                
values ('$station_event_log_id','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$created_on','$diff','$total_time','$created_by');";

        $result1 = mysqli_query($db, $page);
    }
}




if ($result0) {
    $_SESSION['message_stauts_class'] = 'alert-success';
    $_SESSION['import_status_message'] = 'Form Created Sucessfully.';
} else {
    $_SESSION['message_stauts_class'] = 'alert-danger';
    $_SESSION['import_status_message'] = 'Please retry';
}

$url = "update_station_event_log.php";
header('Location: '.$url, true, 303);

?>
