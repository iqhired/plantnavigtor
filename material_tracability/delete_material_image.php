<?php include("../config.php");
$material_id = $_POST['material_id'];
//$delete_check = $_POST['id'];
$sql = "DELETE FROM `material_images` where material_images_id ='$material_id'";
if (!mysqli_query($db, $sql)) {
	$_SESSION['message_stauts_class'] = 'alert-danger';
	$_SESSION['import_status_message'] = 'Please Retry.';
} else {
	$_SESSION['message_stauts_class'] = 'alert-success';
	$_SESSION['import_status_message'] = 'Material image Deleted Sucessfully.';
}

header("Location:edit_material.php?id=$form_id");
