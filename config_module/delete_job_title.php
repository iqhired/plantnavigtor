<?php
include("../config.php");
$delete_check = $_POST['delete_check'];
if ($delete_check != "") {
    $cnt = count($delete_check);
    for ($i = 0; $i < $cnt;) {
        $sql1 = "UPDATE `cam_job_title` SET `is_deleted`='1' WHERE `job_title_id`='$delete_check[$i]'";
        if (!mysqli_query($db, $sql1)) {
            echo "Invalid Data";
        } else {
            $_SESSION['message_stauts_class'] = 'alert-success';
            $_SESSION['import_status_message'] = 'Job-Title Deleted Sucessfully.';
        }
        $i++;
    }
} else {
    $_SESSION['message_stauts_class'] = 'alert-danger';
    $_SESSION['import_status_message'] = 'Please Select Job-Title.';
}
header("Location:job_title.php");
?>
