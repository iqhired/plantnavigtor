<?php
include("../config.php");
//include("../database_config.php");
//include("../../sup_config.php");
$delete_check = $_POST['delete_check'];
if ($delete_check != "") {
    $cnt = count($delete_check);
    for ($i = 0; $i < $cnt;) {
        //$sql1 = "DELETE FROM `form_create` WHERE `form_create_id` = '$delete_check[$i]'";
        $sql1 = "update form_create set delete_flag='1',updated_by='$chicagotime' where form_create_id ='$delete_check[$i]'";
        if (!mysqli_query($db, $sql1)) {
			$_SESSION['message_stauts_class'] = 'alert-danger';
			$_SESSION['import_status_message'] = 'Please Retry.';
		} else {
            $_SESSION['message_stauts_class'] = 'alert-success';
            $_SESSION['import_status_message'] = 'Form Deleted Sucessfully.';
        }
        $i++;
    }
} else {
    $_SESSION['message_stauts_class'] = 'alert-danger';
    $_SESSION['import_status_message'] = 'Please Select Form.';
}

header("Location:edit_form_options.php");
?>
