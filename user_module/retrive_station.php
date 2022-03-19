<?php
//$_SESSION['mobile'] = $_GET['student_id'];
include("../config.php");
//require('db_config.php');
$sql = "SELECT DISTINCT `line_id` FROM `cam_station_pos_rel`";
$result = $mysqli->query($sql);
//$json = [];
while ($row = $result->fetch_assoc()) {
    $station1 = $row['line_id'];
    $qurtemp = mysqli_query($db, "SELECT * FROM  cam_line where line_id = '$station1' ");
    $rowctemp = mysqli_fetch_array($qurtemp);
    $station = $rowctemp["line_name"];
    //      $json[$row['line_id']] = $row['line_id'];
    $json[] = array(
        'name' => $station,
        'id' => $row['line_id']
    );
}
echo json_encode($json);
?>