<?php include("../config.php");
$material_id = $_POST['material_id'];

//$delete_check = $_POST['id'];
$sql = "select * from `material_images` where material_images_id = '$material_id'";
$sql1 = mysqli_query($db,$sql);
$row = mysqli_fetch_array($sql1);
$id = $row['material_image_id'];
$file_name = $row['image_name'];
unlink("../material_images/".$file_name);

$sql = "DELETE FROM `material_images` where material_images_id ='$material_id'";

if (!mysqli_query($db, $sql)) {
	$_SESSION['message_stauts_class'] = 'alert-danger';
	$_SESSION['import_status_message'] = 'Please Retry.';
} else {
	$_SESSION['message_stauts_class'] = 'alert-success';
	$_SESSION['import_status_message'] = 'Material image Deleted Sucessfully.';
}

