<?php
include("../config.php");
$curdate = date('Y-m-d H:i:s');

$button = "";
$temp = "";
if (!isset($_SESSION['user'])) {
    header('location: logout.php');
}
//if (count($_POST) > 0) {
//
//	$page_from = $_POST['id_from'];
//	$page_to = $_POST['id_to'];
//}
//$sql0 = "select * from sg_station_event_log WHERE station_event_log_id BETWEEN '$page_from' AND '$page_to'";
//
//$sql_st = "select sg_station_event_old_id from sg_station_event_log_update ORDER BY sg_station_event_update_id DESC LIMIT 1";
//$result_st = mysqli_query($db,$sql_st);
//$row_st =  mysqli_fetch_array($result_st);
//$station_event_old_id = $row_st['sg_station_event_old_id'];

$sql0 = "SELECT * FROM sg_station_event_log WHERE event_status = '1' AND total_time IS NULL OR total_time = ''";
$result0 = mysqli_query($db, $sql0);
while ($row = mysqli_fetch_array($result0)) {
    $station_event_log_id = $row['station_event_log_id'];
    $event_seq = $row['event_seq'];
    $station_event_id = $row['station_event_id'];
    $station_cat_id = $row['event_cat_id'];
    $station_type_id = $row['event_type_id'];
    $event_status = $row['event_status'];
    $reason = $row['reason'];
    $created_on = $row['created_on'];
    $total_time = $row['total_time'];
    $created_by = $row['created_by'];
    $current_time = date('Y-m-d H:i:s');

//    $yesdate = date('Y-m-d H:i:s',strtotime("+2 days"));
//    $current_time = $yesdate;

    $time = ($created_on);


    if (empty($total_time)) {
        $datetime1 = strtotime($current_time);
        $datetime2 = strtotime($time);

        $end_hrs_insecs = $datetime1 - $datetime2;
        $end_hrs = round($end_hrs_insecs/3600 ,2);
//        $end_hrs = ($current_time - $time) / 60;
       // $tt = sprintf('%02d:%02d', (int)$current_time, fmod($current_time, 1) * 60);
        if ($end_hrs < 24) {
            $tt = sprintf('%02d:%02d', (int)$end_hrs, fmod($end_hrs, 1) * 60);
            $end_time2 = $s_arr_1[0] . ' ' . $tt;
            $page = "INSERT INTO `sg_station_event_log_new`(`sg_station_event_old_id`,`day_seq`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`) 
                values ('$station_event_log_id','1','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$created_on','$end_time2','$total_time','$created_by')";
            $result1 = mysqli_query($db, $page);
        }else{

        //    $co_sql = "SELECT COUNT(sg_station_event_update_id) FROM sg_station_event_log_new";
            $co_sql = "SELECT sg_station_event_update_id, end_time FROM sg_station_event_log_new ORDER BY sg_station_event_update_id DESC LIMIT 1;";
            $result_sql = mysqli_query($db, $co_sql);
            $count_sql = mysqli_fetch_array($result_sql);
          //  $j = $count_sql[0];
            $j = $count_sql['sg_station_event_update_id'];


            $s_arr_1 = explode(' ', $time);
            $s_arr = explode(':', $s_arr_1[1]);
            $st_time = $s_arr[0] + ($s_arr[1] / 60) + ($s_arr[2] / 3600);
            $start_time = round($st_time, 2);

            $c_arr_1 = explode(' ',$current_time);
            $c_arr = explode(':', $c_arr_1[1]);
            $cu_time = $c_arr[0] + ($c_arr[1] / 60) + ($c_arr[2] / 3600);
            $curr_time = round($cu_time, 2);


            $tt_time_1 = 24 - $start_time;
            $endtime_1 = $s_arr_1[0] . ' ' . '23:59:59';

            $start_date2 = $s_arr_1[0];
            $tt_time_2 = $end_hrs - $tt_time_1;

            $i = 1;

            if($i > $j){

                $page = "INSERT INTO `sg_station_event_log_new`(`sg_station_event_old_id`,`day_seq`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`)
                values ('$station_event_log_id','$i','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$created_on','$endtime_1','$tt_time_1','$created_by')";
                $result1 = mysqli_query($db, $page);

            }


            $i = 2;

            while($tt_time_2 > 0){

                if($i > $j){
                    $start_date2 = date('Y-m-d', strtotime($start_date2 . " +1 days"));
                    $start_time2 = $start_date2 . ' ' . '00:00:00';
                    if($tt_time_2 < 24){
                        $tt = sprintf('%02d:%02d', (int)$tt_time_2, fmod($tt_time_2, 1) * 60);
                        $end_time2 = $start_date2 . ' ' . $tt;
                        $page = "INSERT INTO `sg_station_event_log_new`(`sg_station_event_old_id`,`day_seq`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`)                 
				values ('$station_event_log_id','$i','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$start_time2','$end_time2','$tt_time_2','$created_by')";
                        $result1 = mysqli_query($db, $page);
                    }else{
                        $end_time2 = $start_date2 . ' ' . '23:59:59';
                        $page = "INSERT INTO `sg_station_event_log_new`(`sg_station_event_old_id`,`day_seq`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`)                 
				values ('$station_event_log_id','$i','$event_seq','$station_event_id','$station_cat_id','$station_type_id','$event_status','$reason','$start_time2','$end_time2','24','$created_by')";
                        $result1 = mysqli_query($db, $page);
                    }
                    $tt_time_2 = ($tt_time_2 - 24);

                }
                $i++;
            }
        }
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
header('Location: ' . $url, true, 303);

?>
