<?php
include("../config.php");
$delete_check = $_POST['delete_check'];
if ($delete_check != "") {
    $cnt = count($delete_check);
    for ($i = 0; $i < $cnt;) {
//            $sql1 = "DELETE FROM `pm_part_family` WHERE `pm_part_family_id`='$delete_check[$i]'";
        $sql1 = "update `pm_part_family` set is_deleted = '1' WHERE `pm_part_family_id`='$delete_check[$i]'";

        if (!mysqli_query($db, $sql1)) {
                $_SESSION['message_stauts_class'] = 'alert-danger';
                $_SESSION['import_status_message'] = 'Please Try Again.';
            } else {
                $_SESSION['message_stauts_class'] = 'alert-success';
                $_SESSION['import_status_message'] = 'Part Family Deleted Sucessfully.';
            }
        $i++;
    }
} else {
    $_SESSION['message_stauts_class'] = 'alert-danger';
    $_SESSION['import_status_message'] = 'Please Select Part Family.';
}
header("Location:part_family.php");
?>
