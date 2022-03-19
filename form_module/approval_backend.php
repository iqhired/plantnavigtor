<?php

include("../config.php");
$array = json_decode($_POST['info']);
$drag_drop_res = (array) json_decode($array);
//echo "<pre>";print_r($drag_drop_res);

echo "<pre>";
print_r($_POST);
echo "</pre>";

if(count($_POST)>0) {

   $formid = $_POST['formid'];
   $approvalid = $_POST['approvalid'];
    $updated_at = date("Y-m-d H:i:s");

   $pin = $_POST['pin'];
	$sid = $_SESSION['id'];
	$qur04 = mysqli_query($db, "SELECT * FROM  form_user_data where form_user_data_id = '$formid' ");
$rowc04 = mysqli_fetch_array($qur04);
$approval_initials = $rowc04["approval_initials"];
$passcode = $rowc04['passcode'];
	
	
	
    
        $sql0 = "UPDATE `form_approval` SET  `approval_initials` ='$sid', `passcode`= '$pin', approval_status = '0' , updated_at = '$updated_at' where form_approval_id = '$approvalid'";
        $result0 = mysqli_query($db, $sql0);
        if ($result0) {
                           $_SESSION['message_stauts_class'] = 'alert-success';
                $_SESSION['import_status_message'] = 'Form Approved Sucessfully.';
 
        } else {
                $_SESSION['message_stauts_class'] = 'alert-danger';
                $_SESSION['import_status_message'] = 'Please retry';
         }

}  

  header("Location:pending_approval_list.php");

?>