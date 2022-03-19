<?php
include("../config.php");
$db = mysqli_connect('localhost','root','','saargummi');

$delete_check = $_POST['delete_check'];
if ($delete_check != "") {
    $cnt = count($delete_check);
    for ($i = 0; $i < $cnt;) {
        
		$taskboard_id = $delete_check[$i];
		$qur04 = mysqli_query($db, "SELECT * FROM  tm_task where `taskboard` = '$taskboard_id' and status = '1' ");
        $rowc04 = mysqli_fetch_array($qur04);
        $task_id = $rowc04["tm_task_id"];
		if ($task_id != "") {
            $_SESSION['message_stauts_class'] = 'alert-danger';
            $_SESSION['import_status_message'] = 'Task has been assign to Taskboard User. Please finish task to remove Taskboard.';
		}else {
			$sql1 = "DELETE FROM `sg_taskboard` WHERE `sg_taskboard_id`='$delete_check[$i]'";
			if(mysqli_query($db, $sql1)) {
				$_SESSION['message_stauts_class'] = 'alert-success';
				$_SESSION['import_status_message'] = 'Taskboard Deleted Sucessfully.';
			} 
        }
		$task_id = "";
		$i++;
    }
} else {
    $_SESSION['message_stauts_class'] = 'alert-danger';
    $_SESSION['import_status_message'] = 'Please Select Taskboard.';
}
header("Location:create_taskboard.php");
?>
