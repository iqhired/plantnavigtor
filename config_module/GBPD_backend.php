<?php
include("../config.php");
$gbd_check = $_POST['gbpd'];
$gbd_is_checked = $_POST['isChecked'];
if ($gbd_check != "") {

        if($gbd_is_checked =='true') {
            $sql1 = "UPDATE  `cam_line` set  gbd_id = 1  WHERE `line_id`='$gbd_check'";
        }else{
            $sql1 = "UPDATE  `cam_line` set  gbd_id = 0  WHERE `line_id`='$gbd_check'";
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
