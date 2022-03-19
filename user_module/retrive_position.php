<?php
//$_SESSION['mobile'] = $_GET['student_id'];
include("../config.php");
//require('db_config.php');
$i = $_GET['campus'];
$sql = "SELECT * FROM `cam_station_pos_rel` WHERE line_id = '$i' ORDER by `priority_order` ASC";
$result = $mysqli->query($sql);
$json = array();
while ($row = $result->fetch_assoc()) {
    //$json1[$row['position_id']] = $row['position_id'];
    //$json1[$row['position_name']] = $row['position_name'];
    $position1 = $row['position_id'];
    $qurtemp1 = mysqli_query($db, "SELECT * FROM  cam_position where position_id = '$position1' ");
    $rowctemp1 = mysqli_fetch_array($qurtemp1);
    $position = $rowctemp1["position_name"];
    $json[] = array(
        'name' => $position,
        'id' => $row['position_id']
    );
}
echo json_encode($json);
?>