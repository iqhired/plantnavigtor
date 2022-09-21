<?php
include("../config.php");
$chicagotime = date("Y-m-d H:i:s");
if (count($_POST) > 0) {
       $id = $_POST['userid'];
       $user_id = $_POST['username'];
       $pin_old = $_POST['pin'];

       $sql = "select pin from cam_users where users_id = '$user_id'";
       $query_user = mysqli_query($db,$sql);
       $result = mysqli_fetch_array($query_user);
       $pin_new = $result['pin'];

       if ($pin_old == $pin_new){

               $sql1 = "UPDATE `form_rejection_data` SET `r_flag`='0',`closed_by` = '$user_id' where form_user_data_id = '$id'";
               mysqli_query($db, $sql1);
               $_SESSION['message_stauts_class'] = 'alert-success';
               $_SESSION['import_status_message'] = 'Form Closed';
           } else {
               $_SESSION['message_stauts_class'] = 'alert-danger';
               $_SESSION['import_status_message'] = 'Incorrect Pin';
           }

       }



?>
