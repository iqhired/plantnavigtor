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

 $page = "INSERT INTO `sg_station_log_update`(`sg_station_event_old_id`,`event_seq`,`station_event_id`,`event_cat_id`,`event_type_id`,`event_status`,`reason`,`created_on` ,`end_time`,`total_time`,`created_by`) SELECT station_event_log_id, event_seq, station_event_id, event_cat_id, event_type_id, event_status,reason,created_on,cast(created_on as time),total_time,created_by FROM sg_station_event_log WHERE station_event_log_id BETWEEN '$page_from' AND '$page_to';" ;

$result0 = mysqli_query($db, $page);


if ($result0) {
    $_SESSION['message_stauts_class'] = 'alert-success';
    $_SESSION['import_status_message'] = 'Form Created Sucessfully.';
} else {
    $_SESSION['message_stauts_class'] = 'alert-danger';
    $_SESSION['import_status_message'] = 'Please retry';
}

$url = "update_station_log.php";
header('Location: '.$url, true, 303);

?>
