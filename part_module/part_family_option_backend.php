<?php
include("../config.php");
$chicagotime = date("Y-m-d H:i:s");
$temp = "";
if (count($_POST) > 0) {
    $choose = $_POST['choose'];
    $accnt = $_POST['accnt'];
    $delete_check = $_POST['delete_check'];
    if ($choose == "1") {
        if ($accnt != "") {
            if ($delete_check != "") {
                $cnt = count($delete_check);
                for ($i = 0; $i < $cnt;) {
                    $query0003 = sprintf("SELECT * FROM  part_family_account_relation where part_family_id = '$delete_check[$i]'  ");
                    $qur0003 = mysqli_query($db, $query0003);
                    $rowc0003 = mysqli_fetch_array($qur0003);
                    $checkgroup = $rowc0003["account_id"];
                    if ($checkgroup != "") {
                        $_SESSION['message_stauts_class'] = 'alert-danger';
                        $_SESSION['import_status_message'] = 'Part Family Relation Already Exist.';
                    } else {
                        $sql1 = "INSERT INTO `part_family_account_relation`(`part_family_id`,`account_id`) VALUES ('$delete_check[$i]','$accnt')";
                        if (!mysqli_query($db, $sql1)) {
                            $_SESSION['message_stauts_class'] = 'alert-danger';
                            $_SESSION['import_status_message'] = 'Please Try Again.';
                        } else {
                            $_SESSION['message_stauts_class'] = 'alert-success';
                            $_SESSION['import_status_message'] = 'Part Family and Account relation Created Sucessfully.';
                        }
                    }
                    $i++;
                }
            } else {
                $_SESSION['message_stauts_class'] = 'alert-danger';
                $_SESSION['import_status_message'] = 'Please Select Part Family.';
            }
        } else {
            $_SESSION['message_stauts_class'] = 'alert-danger';
            $_SESSION['import_status_message'] = 'Please Select Account.';
        }
    }
	else {
            $_SESSION['message_stauts_class'] = 'alert-danger';
            $_SESSION['import_status_message'] = 'Please Select Option.';
        }
 }
?>
