<?php
include("../config.php");
$chicagotime = date("Y-m-d H:i:s");
$oneHourAgo= date('Y-m-d H:i:s', strtotime('-1 hour'));
echo 'One hour ago, the date = ' . $oneHourAgo;
$time = date("H");
$page = $_SERVER['PHP_SELF'];
$sec = "36000";
$sql = "SELECT * FROM `sg_station_event` where event_status = '1'";
$res = mysqli_query($db, $sql);
$firstrow = mysqli_fetch_array($res);
$station_event_id = $firstrow['station_event_id'];
/*$q1 = "SELECT * FROM `sg_station_event` where `station_event_id` = '$station_event_id'";
$r1 = mysqli_query($db, $q1);*/
if (mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $station_event_id = $row['station_event_id'];
        $event_status = $row['event_status'];
        $sql = "select SUM(good_pieces) as good_pieces,SUM(bad_pieces) AS bad_pieces,SUM(rework) as rework from good_bad_pieces_details where station_event_id ='$station_event_id' and created_at > '$oneHourAgo'";
        $result1 = mysqli_query($db, $sql);
        $rowc = mysqli_fetch_array($result1);
        $gp = $rowc['good_pieces'];
        $bp = $rowc['bad_pieces'];
        $rwp = $rowc['rework'];
        $gr = $gp + $rwp;
        $npr_data = $time . ":" . $gr . ":" . $bp;
        if ($event_status == 1) {
            $sqlt = "INSERT INTO `npr_data`(`station_event_id`,`npr_data`,`npr_h`, `npr_gr`, `npr_b`,`event_status`,`update_date`) VALUES ('$station_event_id','$npr_data','$time','$gr','$bp','$event_status','$chicagotime')";
            $resultt = mysqli_query($db, $sqlt);
        } else {

        }
    }
}
?>