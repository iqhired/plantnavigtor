<?php include("../config.php");
$x_id = $_POST['10x_id'];

//$delete_check = $_POST['id'];
$sql = "select * from `10x_images` where 10x_images_id = '$x_id'";
$sql1 = mysqli_query($db,$sql);
$row = mysqli_fetch_array($sql1);
$id = $row['10x_images_id'];
$file_name = $row['image_name'];
unlink("../assets/images/10x".$file_name);

    $sql = "DELETE FROM `10x_images` where 10x_images_id ='$x_id'";

if (!mysqli_query($db, $sql)) {
	$_SESSION['message_stauts_class'] = 'alert-danger';
	$_SESSION['import_status_message'] = 'Please Retry.';
} else {
	$_SESSION['message_stauts_class'] = 'alert-success';
	$_SESSION['import_status_message'] = '10x image Deleted Sucessfully.';
}

