<?php
include("../config.php");
$array = json_decode($_POST['info']);
$drag_drop_res = (array)json_decode($array);

if (count($_POST) > 0) {
	$created_by = $_SESSION['id'];
	$name = $_POST['name'];
	$form_type = $_POST['form_type'];
	$station = $_POST['station'];
	$part_family = $_POST['part_family'];
	$part_number = $_POST['part_number'];
	$form_item_array1 = $_POST['form_item_array'];
	$form_user_data_item = "";
	$formcreateid = $_POST['formcreateid'];
	$form_user_data_id = $_POST['form_user_data_id'];

	foreach ($form_item_array1 as $form_item_array) {
		$form_user_data_item .= $form_item_array."-".$_POST[$form_item_array] . ",";
	}

	$created_at = date("Y-m-d H:i:s");
	$updated_at = date("Y-m-d H:i:s");

	$approval_dept1 = $_POST['approval_dept'];
	foreach ($approval_dept1 as $approval_dept) {
		$arry_approval_dept .= $approval_dept . ",";
	}
	$approval_initials1 = $_POST['approval_initials'];
	foreach ($approval_initials1 as $approval_initials) {
		$array_approval_initials .= $approval_initials . ",";
	}
	$pin1 = $_POST['pin'];
	if (null != $pin1 && isset($pin1)) {
		foreach ($pin1 as $pin) {
			$array_pin .= $pin . ",";
		}
	}


	$sql0 = "UPDATE `form_user_data` SET `form_create_id`='$formcreateid',`form_comp_status` = '1',`form_user_data_item_op`='$form_user_data_item' where form_user_data_id = '$form_user_data_id'";
	$result0 = mysqli_query($db, $sql0);

	if ($result0) {
		$_SESSION['message_stauts_class'] = 'alert-success';
		$_SESSION['import_status_message'] = 'Form Updated Sucessfully.';
		$j_arr = array("form_user_data_id" => $form_user_data_id);
		echo json_encode($j_arr);
	} else {
		$_SESSION['message_stauts_class'] = 'alert-danger';
		$_SESSION['import_status_message'] = 'Please retry';
	}


}


//  header("Location:user_form.php?id=$formcreateid&station=$station&form_type=$form_type&part_family=$part_family&part_number=$part_number&form_name=$name");

?>