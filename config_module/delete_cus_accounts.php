<?php
include("../config.php");
//include("../database_config.php");
//include("../../sup_config.php");
$delete_check = $_POST['delete_check'];
if ($delete_check != "") {
    $cnt = count($delete_check);
    for ($i = 0; $i < $cnt;) {
        $sql1 = "DELETE FROM `cus_account` WHERE `c_id` = '$delete_check[$i]'";
        if (!mysqli_query($db, $sql1)) {
			$_SESSION['message_stauts_class'] = 'alert-danger';
			$_SESSION['import_status_message'] = 'Please Retry.';
		} else {
            $_SESSION['message_stauts_class'] = 'alert-success';
            $_SESSION['import_status_message'] = 'Customer Account Deleted Sucessfully.';
        }
        $i++;
    }
} else {
    $_SESSION['message_stauts_class'] = 'alert-danger';
    $_SESSION['import_status_message'] = 'Please Select Customer Account.';
}

header("Location:cus_accounts.php");
?>
