<?php
include("../config.php");
$delete_check = $_POST['delete_check'];
if ($delete_check != "") {
	$cnt = count($delete_check);
	for ($i = 0; $i < $cnt;) {
		$sql1 = "DELETE FROM `cell_grp` WHERE `c_id` = '$delete_check[$i]'";
		if (!mysqli_query($db, $sql1)) {
			$_SESSION['message_stauts_class'] = 'alert-danger';
			$_SESSION['import_status_message'] = 'Please Retry.';
		} else {
			$_SESSION['message_stauts_class'] = 'alert-success';
			$_SESSION['import_status_message'] = 'Account Deleted Sucessfully.';
		}
		$i++;
	}
} else {
	$_SESSION['message_stauts_class'] = 'alert-danger';
	$_SESSION['import_status_message'] = 'Please Select Account.';
}

header("Location:accounts.php");
?>
