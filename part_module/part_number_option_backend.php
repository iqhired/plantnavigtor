<?php
include("../config.php");
$chicagotime = date("Y-m-d H:i:s");
$temp = "";
if (count($_POST) > 0) {
    $choose = $_POST['choose'];
    $station = $_POST['station'];
    $delete_check = $_POST['delete_check'];
    if ($choose == "1") {
        if ($station != "") {
            if ($delete_check != "") {
                $cnt = count($delete_check);
                for ($i = 0; $i < $cnt;) {
                    $query0003 = sprintf("SELECT * FROM  pm_part_station_relation where part_number = '$delete_check[$i]' and station = '$station' ");
                    $qur0003 = mysqli_query($db, $query0003);
                    $rowc0003 = mysqli_fetch_array($qur0003);
                    $checkgroup = $rowc0003["station"];
                    if ($checkgroup != "") {
                        $_SESSION['message_stauts_class'] = 'alert-danger';
                        $_SESSION['import_status_message'] = 'Part Number Relation Already Exist.';
                    } else {
                        $sql1 = "INSERT INTO `pm_part_station_relation`(`part_number`,`station`) VALUES ('$delete_check[$i]','$station')";
                        if (!mysqli_query($db, $sql1)) {
                            $_SESSION['message_stauts_class'] = 'alert-danger';
                            $_SESSION['import_status_message'] = 'Please Try Again.';
                        } else {
                            $_SESSION['message_stauts_class'] = 'alert-success';
                            $_SESSION['import_status_message'] = 'Part Number and Station relation Created Sucessfully.';
                        }
                    }
                    $i++;
                }
            } else {
                $_SESSION['message_stauts_class'] = 'alert-danger';
                $_SESSION['import_status_message'] = 'Please Select Part number.';
            }
        } else {
            $_SESSION['message_stauts_class'] = 'alert-danger';
            $_SESSION['import_status_message'] = 'Please Select Station.';
        }
    }
	else {
            $_SESSION['message_stauts_class'] = 'alert-danger';
            $_SESSION['import_status_message'] = 'Please Select Option.';
        }
 }
?>
