<?php include("../config.php");
$delete_check = $_POST['delete_check'];
if ($delete_check != "") {
	$cnt = count($delete_check);
	for ($i = 0; $i < $cnt;) {

		$sql = "DELETE FROM `material_config` where material_id ='$delete_check[$i]'";
		if (!mysqli_query($db, $sql)) {
			$_SESSION['message_stauts_class'] = 'alert-danger';
			$_SESSION['import_status_message'] = 'Please Retry.';
		} else {
			$_SESSION['message_stauts_class'] = 'alert-success';
			$_SESSION['import_status_message'] = 'Material Type Deleted Sucessfully.';
		}
		$i++;
	}
} else {
	$_SESSION['message_stauts_class'] = 'alert-danger';
	$_SESSION['import_status_message'] = 'Please Select Material Type.';
}

header("Location:material_config.php");
?>