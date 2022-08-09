    <?php
include("config.php");
$delete_check = $_POST['delete_check'];
if ($delete_check != "") {
    $cnt = count($delete_check);
    for ($i = 0; $i < $cnt;) {

		$qur04 = mysqli_query($db, "SELECT * FROM  sg_taskboard where `group_id`='$delete_check[$i]' ");
        $rowc04 = mysqli_fetch_array($qur04);
            $taskboard_id = $rowc04["sg_taskboard_id"];
		
		$qur04 = mysqli_query($db, "SELECT * FROM  tm_task where `taskboard` = '$taskboard_id' and status = '1' ");
        $rowc04 = mysqli_fetch_array($qur04);
            $task_id = $rowc04["tm_task_id"];
		
		if ($task_id == "") {
        
			$sql1 = "UPDATE `sg_group` SET `is_deleted`='1' WHERE `group_id`='$delete_check[$i]'";
			if (!mysqli_query($db, $sql1)) {
				echo "Invalid Data";
			} else {
				$_SESSION['message_stauts_class'] = 'alert-success';
				$_SESSION['import_status_message'] = 'Group Deleted Sucessfully.';
			}
		}else {
            $_SESSION['message_stauts_class'] = 'alert-danger';
            $_SESSION['import_status_message'] = 'Task has been assign to Group User. Please finish task to remove Group.';
        }
		$task_id = "";
		
        $i++;
    }
} else {
    $_SESSION['message_stauts_class'] = 'alert-danger';
    $_SESSION['import_status_message'] = 'Please Select Group.';
}
header("Location:group.php");
?>
