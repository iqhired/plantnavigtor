<?php

include("../config.php");
$app_id = $_POST['app_id'];
$pin = $_POST['pin'];
$index = $_POST['index'];
$app_dept = $_POST['app_dept'];
$form_data_id = $_POST['form_user_data_id'];
$approval_dept_cnt = $_POST['approval_dept_cnt'];

if(count($_POST)>0) {   

   
    $updated_at = date("Y-m-d H:i:s");
        
	 $qur04 = mysqli_query($db, "SELECT pin FROM  cam_users where users_id = '$app_id'");
	 $rowc04 = mysqli_fetch_array($qur04);

       $u_pin = $rowc04['pin'];
       if(empty($u_pin)){
		   echo json_encode(array("error_type" => 'user_error' , "err_row" => $index ));
	   }else if($u_pin != $pin){
		   echo json_encode(array("error_type" => 'pin_error' , "err_row" => $index ));
	   }else{
		   $sql0 = "INSERT INTO `form_approval`(`form_user_data_id`,`approval_dept`,`approval_initials`,`approval_status`,`passcode`, `created_at`) VALUES 
          ('$form_data_id','$app_dept','$app_id' ,'1', '$pin' ,'$updated_at')";
		   $result0 = mysqli_query($db, $sql0);
		   if ($result0) {
			   $_SESSION['message_stauts_class'] = 'alert-success';
			   $_SESSION['import_status_message'] = 'Form Approved Sucessfully.';
			   $qur04 = mysqli_query($db, "SELECT count(*) as r_count FROM  form_approval where form_user_data_id = '$form_data_id'");
			   $rowc04 = mysqli_fetch_array($qur04);
			   $r_count = $rowc04['r_count'];
			   if(!empty($r_count) && ($r_count == $approval_dept_cnt)){
				   echo json_encode(array("all_dept_approved" => 1));
			   }else{
				   echo json_encode(array("all_dept_approved" => 0));
			   }

		   } else {
			   $_SESSION['message_stauts_class'] = 'alert-danger';
			   $_SESSION['import_status_message'] = 'Please retry';
		   }
	   }
}  

 // header("Location:pending_approval_list.php");

?>