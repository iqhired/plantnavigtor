<?php
include("../config.php");
$delete_val = $_POST['delete_check'];
if ($delete_val != "") {
	$val = explode("_",$delete_val[0]);
	$delete_check = $val[0];
	$seq = $val[1];
	$sql = "select (MAX(so)) as max_seq_num from event_type";
	$res = mysqli_query($db, $sql);
	if($res != ''){
		$max_seq = ($res ->fetch_assoc())['max_seq_num'];
		if( $seq < $max_seq ){
			$set = 'so = so - 1';
			$where = 'so > ' . $seq . ' and so <= ' . $max_seq;
		}
		if($set != '' && $where != ''){
			$sql = 'update event_type set ' .  $set . ' where ' . $where;
			$result1 = mysqli_query($db, $sql);
		}
	}
	$sql1 = "UPDATE `event_type` SET `is_deleted`='1' WHERE `event_type_id`='$delete_check'";
	if (!mysqli_query($db, $sql1)) {
		echo "Invalid Data";
	} else {
				$_SESSION['message_stauts_class'] = 'alert-success';
		$_SESSION['import_status_message'] = 'Event Type Deleted Sucessfully.';
	}
} else {
	$_SESSION['message_stauts_class'] = 'alert-danger';
	$_SESSION['import_status_message'] = 'Please Select Event Type.';
}
header("Location:event_type.php");
?>
