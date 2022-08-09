<?php
include("../config.php");
$delete_check = $_POST['delete_check'];
if ($delete_check != "") {
    $cnt = count($delete_check);
    for ($i = 0; $i < $cnt;) {
        $sql1 = "UPDATE `cam_role` SET `is_deleted` = '1' WHERE `role_id`='$delete_check[$i]'";
        if (!mysqli_query($db, $sql1)) {
            echo "Invalid Data";
        } else {
            $_SESSION['message_stauts_class'] = 'alert-success';
            $_SESSION['import_status_message'] = 'Role Deleted Sucessfully.';
        }
        $i++;
    }
} else {
    $_SESSION['message_stauts_class'] = 'alert-danger';
    $_SESSION['import_status_message'] = 'Please Select Role.';
}
header("Location:role_list.php");
?>
