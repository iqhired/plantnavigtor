<?php
//$_SESSION['mobile'] = $_GET['student_id'];
include("../config.php");
//require('db_config.php');
$sql = "SELECT * FROM `form_measurement_unit` order by name";
$result = $mysqli->query($sql);
//$json = [];
while ($row = $result->fetch_assoc()) {
    $form_measurement_unit_id  = $row['form_measurement_unit_id'];
    $unit_of_measurement  = $row['unit_of_measurement'] . "    (" . $row['description'] . ")";
    
	$json[] = array(
        'name' => $unit_of_measurement,
        'id' => $form_measurement_unit_id
    );
}
echo json_encode($json);
?>