<?php
include("../config.php");
$line_id = $_POST['print'];

$gbd_is_checked = $_POST['isChecked'];

     $print_label = "select * from cam_line where line_id = '$line_id'";
         $qur = mysqli_query($db, $print_label);
          while ($rowc = mysqli_fetch_array($qur)) {
              $print = $rowc['print_label'];
          }
          if($print == '1'){
              $sql0 = "UPDATE `cam_line` SET `print_label`='0' WHERE `line_id` = '$line_id'";
              $result0 = mysqli_query($db, $sql0);
              if ($result0) {
                  $_SESSION['message_stauts_class'] = 'alert-success';
                  $_SESSION['import_status_message'] = 'Form Updated Sucessfully.';
              } else {
                  $_SESSION['message_stauts_class'] = 'alert-danger';
                  $_SESSION['import_status_message'] = 'Please retry';
              }
          }else{
              $sql0 = "UPDATE `cam_line` SET `print_label`='1' WHERE `line_id` = '$line_id'";
              $result0 = mysqli_query($db, $sql0);
              if ($result0) {
                  $_SESSION['message_stauts_class'] = 'alert-success';
                  $_SESSION['import_status_message'] = 'Form Updated Sucessfully.';
              } else {
                  $_SESSION['message_stauts_class'] = 'alert-danger';
                  $_SESSION['import_status_message'] = 'Please retry';
              }
          }



//header("Location:form_edit.php?id=$hidden_id");
$page = "line.php";
header('Location: '.$page, true, 303);
exit;

?>