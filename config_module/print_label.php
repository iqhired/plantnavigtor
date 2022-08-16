<?php
include("../config.php");
$label_check = $_POST['p_label'];
$label_is_checked = $_POST['isChecked'];
if ($label_check != "") {

        if($label_is_checked =='true') {
            $sql1 = "UPDATE  `cam_line` set  indivisual_label = 1  WHERE `line_id`='$label_check'";
        }else{
            $sql1 = "UPDATE  `cam_line` set  indivisual_label = 0  WHERE `line_id`='$label_check'";
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
