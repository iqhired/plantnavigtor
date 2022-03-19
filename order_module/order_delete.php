<?php
//include("../database_config.php");
include("../config.php");
include("../sup_config.php");
$id = $_POST['id'];
 $sql1="DELETE FROM `sup_order` WHERE `order_id`='".$_POST['id']."'";
if(!mysqli_query($sup_db,$sql1))
{
// die('Unable to Connect');
                $_SESSION['message_stauts_class'] = 'alert-danger';
                $_SESSION['import_status_message'] = 'Please retry';
  }
  else
  {
                $_SESSION['message_stauts_class'] = 'alert-success';
                $_SESSION['import_status_message'] = 'Order Deleted Sucessfully.';
  }

?>
