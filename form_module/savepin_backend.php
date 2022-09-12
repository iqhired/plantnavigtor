<?php
include("../config.php");
$chicagotime = date("Y-m-d H:i:s");
if (count($_POST) > 0) {
       $id = $_POST['userid'];
        $sql1 = "UPDATE `form_rejection_data` SET `r_flag`='0' where form_user_data_id = '$id'";
        if (!mysqli_query($db, $sql1)) {
            echo 'success';
        } else {
            echo 'fail';
        }

    }

?>
