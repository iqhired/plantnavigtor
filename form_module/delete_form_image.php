<?php include("../config.php");
$form_id = $_POST['form_create_id'];

//$delete_check = $_POST['id'];
$sql = "select * from `form_images` where form_images_id = '$form_id'";
$sql1 = mysqli_query($db,$sql);
$row = mysqli_fetch_array($sql1);
$id = $row['form_images_id'];
$file_name = $row['image_name'];
unlink("../form_images/".$file_name);

$sql = "DELETE FROM `form_images` where form_images_id ='$form_id'";

if (!mysqli_query($db, $sql)) {
    $_SESSION['message_stauts_class'] = 'alert-danger';
    $_SESSION['import_status_message'] = 'Please Retry.';
} else {
    $_SESSION['message_stauts_class'] = 'alert-success';
    $_SESSION['import_status_message'] = 'Form image Deleted Sucessfully.';
}
?>
