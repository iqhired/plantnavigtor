<?php include("../config.php");
$time_stamp = $_SESSION['good_timestamp_id'];
$g_id = $_POST['bad_image_id'];

//$delete_check = $_POST['id'];
$sql = "select * from `good_piece_images` where good_image_id = '$g_id'";
$sql1 = mysqli_query($db,$sql);
$row = mysqli_fetch_array($sql1);
$id = $row['good_image_id'];
$file_name = $row['good_image_name'];
unlink("../assets/images/bad_piece_image/".$time_stamp.'/'.$file_name);
if(!is_dir($time_stamp)){
    unlink("../assets/images/bad_piece_image/".$g_id.'/'.$file_name);
}
$sql = "DELETE FROM `good_piece_images` where good_image_id ='$g_id'";

if (!mysqli_query($db, $sql)) {
    $_SESSION['message_stauts_class'] = 'alert-danger';
    $_SESSION['import_status_message'] = 'Please Retry.';
} else {
    $_SESSION['message_stauts_class'] = 'alert-success';
    $_SESSION['import_status_message'] = 'Bad image Deleted Sucessfully.';
}
?>

