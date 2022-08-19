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

$sql0 = "SELECT distinct(station_event_id) FROM sg_station_event_log where station_event_id BETWEEN '$page_from' AND '$page_to'";
$result0 = mysqli_query($db, $sql0);
while ($row = mysqli_fetch_array($result0)) {

    $station_event_id = $row['station_event_id'];

    $line_sql = "SELECT line_id,event_type_id FROM sg_station_event where station_event_id = '$station_event_id'";
    $result_sql = mysqli_query($db, $line_sql);


    while ($row = mysqli_fetch_array($result_sql)) {
        $line_id = $row['line_id'];
        $event_type_id = $row['event_type_id'];

        $sql1 = "update sg_station_event_log_latest set ended_on =(SELECT created_on FROM sg_station_event_log s1 WHERE s1.station_event_log_id > sg_station_event_log_latest.station_event_log_id and s1.station_event_id = '$station_event_id' ORDER BY s1.station_event_log_id ASC LIMIT 1)  WHERE sg_station_event_log_latest.station_event_id = '$station_event_id'";
        $result1 = mysqli_query($db, $sql1);

        $sql2 = "update sg_station_event_log_latest set ended_on =(SELECT created_on FROM sg_station_event s1 WHERE s1.station_event_id > sg_station_event_log_latest.station_event_id and S1.line_id = '$line_id' ORDER BY s1.station_event_id ASC LIMIT 1) WHERE sg_station_event_log_latest.station_event_id = '$station_event_id' AND sg_station_event_log_latest.event_type_id= '$event_type_id'";
        $result2 = mysqli_query($db, $sql2);

        $sql3 = "UPDATE sg_station_event_log_latest set tt = (TIMEDIFF(ended_on,created_on)) where station_event_id = '$station_event_id'";
        $result3 = mysqli_query($db, $sql3);
    }



}
$url = "sg_station_line_log.php";
header('Location: ' . $url, true, 303);

