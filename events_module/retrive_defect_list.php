<?php
//$_SESSION['mobile'] = $_GET['student_id'];
include("../config.php");
//require('db_config.php');
$sql = "SELECT * FROM `defect_list` ORDER BY `defect_list_name` ASC";
$result = $mysqli->query($sql);
//$json = [];
while ($row = $result->fetch_assoc()) {
    $defect_list_id = $row['defect_list_id'];
    $defect_list_name = $row['defect_list_name'];

    $json[] = array(
        'name' => $defect_list_name,
        'id' => $defect_list_id
    );
}
echo json_encode($json);
?>