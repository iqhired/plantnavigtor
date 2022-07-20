<?php
include("../config.php");
$delete_check = $_POST['delete_check'];
if ($delete_check != "") {
    $cnt = count($delete_check);
    for ($i = 0; $i < $cnt;) {
        $qur04 = mysqli_query($db, "SELECT * FROM  cam_users where `users_id`='$delete_check[$i]' ");
        while ($rowc04 = mysqli_fetch_array($qur04)) {
            $assigned = $rowc04["assigned"];
            $assigned2 = $rowc04["assigned2"];
        }
		
		$qur05 = mysqli_query($db, "SELECT * FROM  tm_task where `assign_to`='$delete_check[$i]' and status = '1' ");
        $rowc05 = mysqli_fetch_array($qur05);
            $tm_task_id = $rowc05["tm_task_id"];
        
		if($tm_task_id == "")
		{	
		
        if ($assigned == "0" && $assigned2 == "0") {
            $sql1 = "UPDATE `cam_users` SET `is_deleted` = '1' WHERE `users_id`='$delete_check[$i]'";
            if (!mysqli_query($db, $sql1)) {
                $_SESSION['message_stauts_class'] = 'alert-danger';
                $_SESSION['import_status_message'] = 'Please retry';
            } else {
                $_SESSION['message_stauts_class'] = 'alert-success';
                $_SESSION['import_status_message'] = 'Users Deleted Sucessfully.';
            }
        } else {
            $_SESSION['message_stauts_class'] = 'alert-danger';
            $_SESSION['import_status_message'] = 'User is assigned to a station. Please Un-Assign User to delete';
        }
		}else {
            $_SESSION['message_stauts_class'] = 'alert-danger';
            $_SESSION['import_status_message'] = 'User is assigned to a task. Please finish task to Remove User';
        }
		
        $i++;
    }
} else {
    $_SESSION['message_stauts_class'] = 'alert-danger';
    $_SESSION['import_status_message'] = 'Please Select Users.';
}


//header("Location:users_list.php");
?>
