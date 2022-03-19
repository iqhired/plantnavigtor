<?php
include("config.php");
$chicagotime = date("Y-m-d H:i:s");
$temp = "";
if (count($_POST) > 0) {
	$choose = $_POST['choose'];
	$group_id = $_POST['group_id'];
	$delete_check = $_POST['delete_check'];
	if ($choose == "1") {
		if ($group_id != "") {
			if ($delete_check != "") {
				$cnt = count($delete_check);
				for ($i = 0; $i < $cnt;) {
					$query0003 = sprintf("SELECT * FROM  sg_def_defgroup where defect_list_id = '$delete_check[$i]' and d_group_id = '$group_id' ");
					$qur0003 = mysqli_query($db, $query0003);
					$rowc0003 = mysqli_fetch_array($qur0003);
					$checkgroup = $rowc0003["group_id"];
					if ($checkgroup != "") {
						$_SESSION['message_stauts_class'] = 'alert-danger';
						$_SESSION['import_status_message'] = 'Defect and Defect Group is Already linked.';
					} else {
						$sql1 = "INSERT INTO `sg_def_defgroup`(`defect_list_id`,`d_group_id`) VALUES ('$delete_check[$i]','$group_id')";
						if (!mysqli_query($db, $sql1)) {
							$_SESSION['message_stauts_class'] = 'alert-danger';
							$_SESSION['import_status_message'] = 'Defect and Defect Group is Already linked.';
						} else {
							$_SESSION['message_stauts_class'] = 'alert-success';
							$_SESSION['import_status_message'] = 'Defect Added to Group Sucessfully.';
						}
					}
					$i++;
				}
			} else {
				$_SESSION['message_stauts_class'] = 'alert-danger';
				$_SESSION['import_status_message'] = 'Please Select Users.';
			}
		} else {
			$_SESSION['message_stauts_class'] = 'alert-danger';
			$_SESSION['import_status_message'] = 'Please Select Group.';
		}
	}
	if ($choose == "2") {
		if ($group_id != "") {
			if ($delete_check != "") {
				$cnt = count($delete_check);
				for ($i = 0; $i < $cnt;) {
					$query0003 = sprintf("SELECT * FROM  sg_def_defgroup where defect_list_id = '$delete_check[$i]' and d_group_id = '$group_id' ");
					$qur0003 = mysqli_query($db, $query0003);
					$rowc0003 = mysqli_fetch_array($qur0003);
					$checkgroup = $rowc0003["group_id"];
					if ($checkgroup == "") {
						$_SESSION['message_stauts_class'] = 'alert-danger';
						$_SESSION['import_status_message'] = 'Defect and Defect Group Relation Does not Exist.';
					} else {
						$sql1 = "DELETE FROM `sg_def_defgroup` where defect_list_id = '$delete_check[$i]' and d_group_id = '$group_id'";
						if (!mysqli_query($db, $sql1)) {
							$_SESSION['message_stauts_class'] = 'alert-danger';
							$_SESSION['import_status_message'] = 'Please Try Again.';
						} else {
							$_SESSION['message_stauts_class'] = 'alert-success';
							$_SESSION['import_status_message'] = 'Defect Deleted from Group Sucessfully.';
						}
					}
					$i++;
				}
			} else {
				$_SESSION['message_stauts_class'] = 'alert-danger';
				$_SESSION['import_status_message'] = 'Please Select Defects.';
			}
		} else {
			$_SESSION['message_stauts_class'] = 'alert-danger';
			$_SESSION['import_status_message'] = 'Please Select Group.';
		}
	}
}
?>
