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

    $sql1 = "update sg_station_event_log_latest set ended_on =(SELECT created_on FROM sg_station_event_log s1 WHERE s1.station_event_log_id > sg_station_event_log_latest.station_event_log_id and s1.station_event_id = '$station_event_id' ORDER BY s1.station_event_log_id ASC LIMIT 1)  WHERE sg_station_event_log_latest.station_event_id = '$station_event_id'";
    $result1 = mysqli_query($db, $sql1);

    $sql2 = "UPDATE sg_station_event_log_latest set tt = (TIMEDIFF(ended_on,created_on)) where station_event_id = '$station_event_id'";
    $result2 = mysqli_query($db, $sql2);

}

$url = "update_station_event_log.php";
header('Location: ' . $url, true, 303);

