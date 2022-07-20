<?php
include("../config.php");
$delete_check = $_POST['delete_check'];
if ($delete_check != "") {
    $cnt = count($delete_check);
    for ($i = 0; $i < $cnt;) {
        $sql1 = "UPDATE `sg_cust_dashboard` SET `is_deleted`='1' WHERE `sg_cust_group_id` = '$delete_check[$i]'";
        if (!mysqli_query($db, $sql1)) {
            $_SESSION['message_stauts_class'] = 'alert-danger';
            $_SESSION['import_status_message'] = 'Please Retry.';
        } else {
            $_SESSION['message_stauts_class'] = 'alert-success';
            $_SESSION['import_status_message'] = 'Dashboard Deleted Sucessfully.';
        }
        $i++;
    }
} else {
    $_SESSION['message_stauts_class'] = 'alert-danger';
    $_SESSION['import_status_message'] = 'Please Select Dashboard.';
}

header("Location:create_cust_dashboard.php");

?>
