<?php
include("../config.php");
$npd_check = $_POST['npd'];
$npd_is_checked = $_POST['isChecked'];
if ($npd_check != "") {
    if($npd_is_checked =='true') {
        $sql1 = "UPDATE  `cam_line` set  npr_id = 1  WHERE `line_id`='$npd_check'";
    }else{
        $sql1 = "UPDATE  `cam_line` set  npr_id = 0  WHERE `line_id`='$npd_check'";
    }
    if (mysqli_query($db, $sql1)) {
        $_SESSION['message_stauts_class'] = 'alert-success';
        $_SESSION['import_status_message'] = 'Required Sucessfully';
    } else {
        $_SESSION['message_stauts_class'] = 'alert-danger';
        $_SESSION['import_status_message'] = 'please retry.';
    }
}

header("Location:line.php");
?>
