<?php
include("../config.php");
$form_rejection = $_POST['rejection_loop'];
$form_is_checked = $_POST['isChecked'];
if ($form_rejection != "") {

    if($form_is_checked =='true') {
        $sql1 = "UPDATE  `form_type` set  form_rejection_loop = 1  WHERE `form_type_id`='$form_rejection'";
    }else{
        $sql1 = "UPDATE  `form_type` set  form_rejection_loop = 0  WHERE `form_type_id`='$form_rejection'";
    }
    if (mysqli_query($db, $sql1)) {
        $_SESSION['message_stauts_class'] = 'alert-success';
        $_SESSION['import_status_message'] = 'Required Sucessfully';
    } else {
        $_SESSION['message_stauts_class'] = 'alert-danger';
        $_SESSION['import_status_message'] = 'please retry.';
    }
}

header("Location:form_type.php");
?>
