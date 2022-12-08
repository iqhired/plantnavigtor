<?php
include("../config.php");
$chicagotime = date("Y-m-d H:i:s");

$button = "";
$temp = "";
if (!isset($_SESSION['user'])) {
    header('location: logout.php');
}

if (count($_POST) > 0) {

    $page_from = $_POST['id_from'];
    $page_to = $_POST['id_to'];
}

$sql0 = "select * from good_bad_pieces_details WHERE bad_pieces_id BETWEEN '$page_from' AND '$page_to'";
$result0 = mysqli_query($db, $sql0);
while ($row = mysqli_fetch_array($result0)) {
    $bad_pieces_id = $row['bad_pieces_id'];
    $station_event_id = $row['station_event_id'];
    $good_pieces = $row['good_pieces'];
    $defect_name = $row['defect_name'];
    $bad_pieces = $row['bad_pieces'];
    $rework = $row['rework'];
    $created_by = $row['created_by'];
    $created_at = $row['created_at'];
    $time = $chicagotime;

    $s_arr_1 = explode(' ', $created_at);
    $s_arr = explode(':', $s_arr_1[1]);
    $st_time = $s_arr[0] + ($s_arr[1] / 60) + ($s_arr[2] / 3600);
    $start_time = round($st_time, 2);

    $datetime1 = strtotime($created_at);
    $datetime2 = strtotime($time);
    $totalSecondsDiff = $datetime2 - $datetime1;
    $end_time = $totalSecondsDiff / 3600;
    $end_time = round($end_time,2);

    $total_time = $end_time - $start_time;
    $tt = sprintf('%02d:%02d', (int)$start_time, fmod($start_time, 1) * 60);
    if ($total_time < 24) {
        $tt = sprintf('%02d:%02d', (int)$total_time, fmod($total_time, 1) * 60);
        $end_time2 = $s_arr_1[0] . ' ' . $tt;
        $page = "INSERT INTO `good_bad_pieces_details_new`(`bad_pieces_old_id`,`day_seq`,`station_event_id`,`good_pieces`,`defect_name`,`bad_pieces`,`rework`,`created_by`,`created_at` ,`current_time`,`total_time`) 
                values ('$bad_pieces_id','1','$station_event_id','$good_pieces','$defect_name','$bad_pieces','$rework','$created_by','$created_at','$chicagotime','$total_time')";
        $result1 = mysqli_query($db, $page);
    } else {
        $tt_time_1 = 24 - $start_time;
        $endtime_1 = $s_arr_1[0] . ' ' . '23:59:59';
        $page = "INSERT INTO `good_bad_pieces_details_new`(`bad_pieces_old_id`,`day_seq`,`station_event_id`,`good_pieces`,`defect_name`,`bad_pieces`,`rework`,`created_by`,`created_at` ,`current_time`,`total_time`) 
                values ('$bad_pieces_id','1','$station_event_id','$good_pieces','$defect_name','$bad_pieces','$rework','$created_by','$created_at','$endtime_1','$tt_time_1')";
        $result1 = mysqli_query($db, $page);
        $start_date2 = $s_arr_1[0];
        $tt_time_2 = $total_time - $tt_time_1;
        $i = 2;
        while ($tt_time_2 > 0) {
            $start_date2 = date('Y-m-d', strtotime($start_date2 . " +1 days"));
            $start_time2 = $start_date2 . ' ' . '00:00:00';
            if ($tt_time_2 < 24) {
                $tt = sprintf('%02d:%02d', (int)$tt_time_2, fmod($tt_time_2, 1) * 60);
                $end_time2 = $start_date2 . ' ' . $tt;
                $page = "INSERT INTO `good_bad_pieces_details_new`(`bad_pieces_old_id`,`day_seq`,`station_event_id`,`good_pieces`,`defect_name`,`bad_pieces`,`rework`,`created_by`,`created_at` ,`current_time`,`total_time`) 
                values ('$bad_pieces_id','1','$station_event_id','$good_pieces','$defect_name','$bad_pieces','$rework','$created_by','$start_time2','$end_time2','$tt_time_2')";
                $result1 = mysqli_query($db, $page);
            } else {
                $end_time2 = $start_date2 . ' ' . '23:59:59';
                $page = "INSERT INTO `good_bad_pieces_details_new`(`bad_pieces_old_id`,`day_seq`,`station_event_id`,`good_pieces`,`defect_name`,`bad_pieces`,`rework`,`created_by`,`created_at` ,`current_time`,`total_time`) 
                values ('$bad_pieces_id','1','$station_event_id','$good_pieces','$defect_name','$bad_pieces','$rework','$created_by','$start_time2','$end_time2','24')";
                $result1 = mysqli_query($db, $page);
            }
            $tt_time_2 = ($tt_time_2 - 24);
            $i++;
        }
    }


}



