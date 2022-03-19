<?php
//$_SESSION['mobile'] = $_GET['student_id'];
include("../config.php");
//require('db_config.php');
$i = $_GET['campus'];
$json = array();
$sql1 = "SELECT * FROM `sg_taskboard` WHERE sg_taskboard_id = '$i' ";
$result1 = $mysqli->query($sql1);
$row1 = $result1->fetch_assoc();
$group_id = $row1['group_id'];
$sql2 = "SELECT * FROM `sg_user_group` WHERE group_id = '$group_id' ";
$result2 = $mysqli->query($sql2);
while ($row2 = $result2->fetch_assoc()) {
    $user_id = $row2['user_id'];
    $sql = "SELECT * FROM `cam_users` WHERE users_id = '$user_id' and available = '1' ";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    $first = $row['firstname'];
    $last = $row['lastname'];
    $full = $first . " " . $last;
    if ($first != "") {
        $json[] = array(
            'name' => $full,
            'id' => $user_id
        );
    }
    $first = "";
}
echo json_encode($json);
?>