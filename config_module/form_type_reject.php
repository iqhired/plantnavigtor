<?php
include("../config.php");
$form_type_check = $_POST['form_reject'];
$form_is_checked = $_POST['isChecked'];
if ($form_type_check != "") {

    if($form_is_checked =='true') {
        $sql1 = "UPDATE  `form_type` set  form_type_reject = 1  WHERE `form_type_id`='$form_type_check'";
    }else{
        $sql1 = "UPDATE  `form_type` set  form_type_reject = 1  WHERE `form_type_id`='$form_type_check'";
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
