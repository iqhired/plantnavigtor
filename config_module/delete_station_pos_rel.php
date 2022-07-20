<?php
include("../config.php");
$delete_check = $_POST['delete_check'];
if ($delete_check != "") {
    $cnt = count($delete_check);
    for ($i = 0; $i < $cnt;) {
		//to find station id and position id
		$station = "";
		$position = "";
        $qur04 = mysqli_query($db, "SELECT * FROM  cam_station_pos_rel where `station_pos_rel_id`='$delete_check[$i]' ");
        $rowc04 = mysqli_fetch_array($qur04);
        $station = $rowc04["line_id"];
		$position = $rowc04["position_id"];
        // check user is assigned to station and position
		$stationpos = "";
        $qur04 = mysqli_query($db, "SELECT * FROM  cam_assign_crew where `position_id`='$position' and line_id = '$station' ");
        $rowc04 = mysqli_fetch_array($qur04);
        $stationpos = $rowc04["assign_crew_id"];
        if ($stationpos == "") {
        
			$sql1 = "UPDATE `cam_station_pos_rel` SET `is_deleted`='1' WHERE `station_pos_rel_id`='$delete_check[$i]'";
			if (!mysqli_query($db, $sql1)) {
				$_SESSION['message_stauts_class'] = 'alert-danger';
				$_SESSION['import_status_message'] = 'Please Try Again.';
			} else {
				$_SESSION['message_stauts_class'] = 'alert-success';
				$_SESSION['import_status_message'] = 'Station Position Deleted Sucessfully.';
			}
		} else {
            $_SESSION['message_stauts_class'] = 'alert-danger';
            $_SESSION['import_status_message'] = 'Crew Members needs to Unassigned before deleting the Station Position Config.';
        }
		$i++;
    }
} else {
    $_SESSION['message_stauts_class'] = 'alert-danger';
    $_SESSION['import_status_message'] = 'Please Select Station Position.';
}
header("Location:station_pos_rel.php");
?>
