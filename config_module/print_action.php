<?php
include("../config.php");
    $line_id = $_POST['print_status'];

    $sql0 = "UPDATE `cam_line` SET `print_label`='0' WHERE `line_id` = '$line_id'";
    $result0 = mysqli_query($db, $sql0);
    if ($result0) {
        $_SESSION['message_stauts_class'] = 'alert-success';
        $_SESSION['import_status_message'] = 'Form Updated Sucessfully.';
    } else {
        $_SESSION['message_stauts_class'] = 'alert-danger';
        $_SESSION['import_status_message'] = 'Please retry';
    }

//header("Location:form_edit.php?id=$hidden_id");
$page = "config_module/line.php";
header('Location: '.$page, true, 303);
exit;

?>