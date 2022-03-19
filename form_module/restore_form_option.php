<?php
include("../config.php");
//include("../database_config.php");
//include("../../sup_config.php");
$restore_check = $_POST['restore_check'];
if ($restore_check != "") {
	$cnt = count($restore_check);
	for ($i = 0; $i < $cnt;) {
		//$sql1 = "DELETE FROM `form_create` WHERE `form_create_id` = '$delete_check[$i]'";
		$sql1 = "update form_create set delete_flag='0',updated_by='$chicagotime' where form_create_id ='$restore_check[$i]'";
		if (!mysqli_query($db, $sql1)) {
			$_SESSION['message_stauts_class'] = 'alert-danger';
			$_SESSION['import_status_message'] = 'Please Retry.';
		} else {
			$_SESSION['message_stauts_class'] = 'alert-success';
			$_SESSION['import_status_message'] = 'Form Restored Sucessfully.';
		}
		$i++;
	}
} else {
	$_SESSION['message_stauts_class'] = 'alert-danger';
	$_SESSION['import_status_message'] = 'Please Select Form.';
}

header("Location:forms_recycle_bin.php");
?>
