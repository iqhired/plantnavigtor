<?php include("../config.php");
$time_stamp = $_SESSION['assets_timestamp_id'];
$a_id = $_POST['asset_id'];

//$delete_check = $_POST['id'];
$sql = "select * from `assets_images` where asset_images_id = '$a_id'";
$sql1 = mysqli_query($db,$sql);
$row = mysqli_fetch_array($sql1);
$id = $row['asset_images_id'];
$file_name = $row['image_name'];
unlink("../assets/images/assets_images/".$time_stamp.'/'.$file_name);
if(!is_dir($time_stamp)){
    unlink("../assets/images/assets_images/".$a_id.'/'.$file_name);
}
$sql = "DELETE FROM `assets_images` where asset_images_id ='$a_id'";

if (!mysqli_query($db, $sql)) {
    $_SESSION['message_stauts_class'] = 'alert-danger';
    $_SESSION['import_status_message'] = 'Please Retry.';
} else {
    $_SESSION['message_stauts_class'] = 'alert-success';
    $_SESSION['import_status_message'] = 'Assets image Deleted Sucessfully.';
}
?>
