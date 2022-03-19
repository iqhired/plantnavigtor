<?php
include("../config.php");
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
                    $query0003 = sprintf("SELECT * FROM  sg_user_group where user_id = '$delete_check[$i]' and group_id = '$group_id' ");
                    $qur0003 = mysqli_query($db, $query0003);
                    $rowc0003 = mysqli_fetch_array($qur0003);
                    $checkgroup = $rowc0003["group_id"];
                    if ($checkgroup != "") {
                        $_SESSION['message_stauts_class'] = 'alert-danger';
                        $_SESSION['import_status_message'] = 'User Group Relation Already Exist.';
                    } else {
                        $sql1 = "INSERT INTO `sg_user_group`(`user_id`,`group_id`) VALUES ('$delete_check[$i]','$group_id')";
                        if (!mysqli_query($db, $sql1)) {
                            $_SESSION['message_stauts_class'] = 'alert-danger';
                            $_SESSION['import_status_message'] = 'Please Try Again.';
                        } else {
                            $_SESSION['message_stauts_class'] = 'alert-success';
                            $_SESSION['import_status_message'] = 'User Added to Group Sucessfully.';
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
                    $query0003 = sprintf("SELECT * FROM  sg_user_group where user_id = '$delete_check[$i]' and group_id = '$group_id' ");
                    $qur0003 = mysqli_query($db, $query0003);
                    $rowc0003 = mysqli_fetch_array($qur0003);
                    $checkgroup = $rowc0003["group_id"];
                    if ($checkgroup == "") {
                        $_SESSION['message_stauts_class'] = 'alert-danger';
                        $_SESSION['import_status_message'] = 'User Group Relation Does not Exist.';
                    } else {
                        $sql1 = "DELETE FROM `sg_user_group` where user_id = '$delete_check[$i]' and group_id = '$group_id'";
                        if (!mysqli_query($db, $sql1)) {
                            $_SESSION['message_stauts_class'] = 'alert-danger';
                            $_SESSION['import_status_message'] = 'Please Try Again.';
                        } else {
                            $_SESSION['message_stauts_class'] = 'alert-success';
                            $_SESSION['import_status_message'] = 'User Deleted from Group Sucessfully.';
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
    if ($choose == "3") {
        if ($delete_check != "") {
            $cnt = count($delete_check);
            for ($i = 0; $i < $cnt;) {
                $sql1 = "UPDATE `cam_users` SET `pin_flag`= '1' where `users_id` = '$delete_check[$i]'";
                if (!mysqli_query($db, $sql1)) {
                    $_SESSION['message_stauts_class'] = 'alert-danger';
                    $_SESSION['import_status_message'] = 'Please Try Again.';
                } else {
                    $_SESSION['message_stauts_class'] = 'alert-success';
                    $_SESSION['import_status_message'] = 'User Added to Approvers Sucessfully.';
                }
                $i++;
            }
        } else {
            $_SESSION['message_stauts_class'] = 'alert-danger';
            $_SESSION['import_status_message'] = 'Please Select Users.';
        }
    }
	if ($choose == "4") {
		$_SESSION['training'] = '1';
    }
	if ($choose == "5") {
		if ($delete_check != "") {
            $cnt = count($delete_check);
            for ($i = 0; $i < $cnt;) {
                $sql1 = "UPDATE `cam_users` SET `pin_flag`= '0' where `users_id` = '$delete_check[$i]'";
                if (!mysqli_query($db, $sql1)) {
                    $_SESSION['message_stauts_class'] = 'alert-danger';
                    $_SESSION['import_status_message'] = 'Please Try Again.';
                } else {
                    $_SESSION['message_stauts_class'] = 'alert-success';
                    $_SESSION['import_status_message'] = 'User Removed from Approvers Sucessfully.';
                }
                $i++;
            }
        } else {
            $_SESSION['message_stauts_class'] = 'alert-danger';
            $_SESSION['import_status_message'] = 'Please Select Users.';
        }
    }
}
?>
