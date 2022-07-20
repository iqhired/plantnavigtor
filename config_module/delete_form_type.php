<?php
include("../config.php");
$delete_check = $_POST['delete_check'];
if ($delete_check != "") {
    $cnt = count($delete_check);
    for ($i = 0; $i < $cnt;) {
        $sql1 = "UPDATE `form_type` SET `is_deleted`='1' WHERE `form_type_id`='$delete_check[$i]'";
        if (!mysqli_query($db, $sql1)) {
            echo "Invalid Data";
        } else {
            $_SESSION['message_stauts_class'] = 'alert-success';
            $_SESSION['import_status_message'] = 'Form Type Deleted Sucessfully.';
        }
        $i++;
    }
} else {
    $_SESSION['message_stauts_class'] = 'alert-danger';
    $_SESSION['import_status_message'] = 'Please Select Form Type.';
}
header("Location:form_type.php");
?>
