<?php
ini_set('display_errors', 'off');
include '../config.php';
$taskboard = $_SESSION['taskboard'];
$user = $_SESSION['user'];
$date = $_SESSION['assign_date'];
$curdate = date('Y-m-d');
$dateto = $_SESSION['date_to'];
$datefrom = $_SESSION['date_from'];
$button = $_SESSION['button'];
$timezone = $_SESSION['timezone'];
if ($button == "button1") {
    if ($taskboard != "" && $user != "" && $datefrom != "" && $dateto != "") {
        $exportData = mysqli_query($db, "SELECT `taskboard`,`assign_to`,`equipment`,`property`,`building`,`duration`,`assigned_time`,`finished_time`,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(`finished_time` ,`assigned_time`))) as total_time FROM `tm_task` WHERE DATE_FORMAT(`assigned_time`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`assigned_time`,'%Y-%m-%d') <= '$dateto' and `taskboard` = '$taskboard' and `assign_to` = '$user'");
    } else if ($taskboard != "" && $user != "" && $datefrom == "" && $dateto == "") {
        $exportData = mysqli_query($db, "SELECT `taskboard`,`assign_to`,`equipment`,`property`,`building`,`duration`,`assigned_time`,`finished_time`,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(`finished_time` ,`assigned_time`))) as total_time FROM `tm_task` WHERE  `taskboard` = '$taskboard' and `assign_to` = '$user'");
    } else if ($taskboard != "" && $user == "" && $datefrom != "" && $dateto != "") {
        $exportData = mysqli_query($db, "SELECT `taskboard`,`assign_to`,`equipment`,`property`,`building`,`duration`,`assigned_time`,`finished_time`,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(`finished_time` ,`assigned_time`))) as total_time FROM `tm_task` WHERE DATE_FORMAT(`assigned_time`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`assigned_time`,'%Y-%m-%d') <= '$dateto' and `taskboard` = '$taskboard' ");
    } else if ($taskboard != "" && $user == "" && $datefrom == "" && $dateto == "") {
        $exportData = mysqli_query($db, "SELECT `taskboard`,`assign_to`,`equipment`,`property`,`building`,`duration`,`assigned_time`,`finished_time`,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(`finished_time` ,`assigned_time`))) as total_time FROM `tm_task` WHERE `taskboard` = '$taskboard'");
    } else if ($taskboard == "" && $user != "" && $datefrom != "" && $dateto != "") {
        $exportData = mysqli_query($db, "SELECT `taskboard`,`assign_to`,`equipment`,`property`,`building`,`duration`,`assigned_time`,`finished_time`,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(`finished_time` ,`assigned_time`))) as total_time FROM `tm_task` WHERE DATE_FORMAT(`assigned_time`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`assigned_time`,'%Y-%m-%d') <= '$dateto' and `assign_to` = '$user'");
    } else if ($taskboard == "" && $user != "" && $datefrom == "" && $dateto == "") {
        $exportData = mysqli_query($db, "SELECT `taskboard`,`assign_to`,`equipment`,`property`,`building`,`duration`,`assigned_time`,`finished_time`,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(`finished_time` ,`assigned_time`))) as total_time FROM `tm_task` WHERE  `assign_to` = '$user'");
    } else if ($taskboard == "" && $user == "" && $datefrom != "" && $dateto != "") {
        $exportData = mysqli_query($db, "SELECT `taskboard`,`assign_to`,`equipment`,`property`,`building`,`duration`,`assigned_time`,`finished_time`,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(`finished_time` ,`assigned_time`))) as total_time FROM `tm_task` WHERE DATE_FORMAT(`assigned_time`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`assigned_time`,'%Y-%m-%d') <= '$dateto' ");
    }else {
        $exportData = mysqli_query($db, "SELECT `taskboard`,`assign_to`,`equipment`,`property`,`building`,`duration`,`assigned_time`,`finished_time`,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(`finished_time` ,`assigned_time`))) as total_time FROM `tm_task`");
    }
} else {
    $curdate = date('Y-m-d');
    if ($timezone == "7") {
        $countdate = date('Y-m-d', strtotime('-7 days'));
    } else if ($timezone == "1") {
        $countdate = date('Y-m-d', strtotime('-1 days'));
    } else if ($timezone == "30") {
        $countdate = date('Y-m-d', strtotime('-30 days'));
    } else if ($timezone == "90") {
        $countdate = date('Y-m-d', strtotime('-90 days'));
    } else if ($timezone == "180") {
        $countdate = date('Y-m-d', strtotime('-180 days'));
    } else if ($timezone == "365") {
        $countdate = date('Y-m-d', strtotime('-365 days'));
    }
    if ($taskboard != "" && $user != "" && $timezone != "") {
        $exportData = mysqli_query($db, "SELECT `taskboard`,`assign_to`,`equipment`,`property`,`building`,`duration`,`assigned_time`,`finished_time`,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(`finished_time` ,`assigned_time`))) as total_time FROM `tm_task` WHERE DATE_FORMAT(`assigned_time`,'%Y-%m-%d') >= '$countdate' and DATE_FORMAT(`assigned_time`,'%Y-%m-%d') <= '$curdate' and `taskboard` = '$taskboard' and `assign_to` = '$user'");
    } else if ($taskboard != "" && $user != "" && $timezone == "") {
        $exportData = mysqli_query($db, "SELECT `taskboard`,`assign_to`,`equipment`,`property`,`building`,`duration`,`assigned_time`,`finished_time`,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(`finished_time` ,`assigned_time`))) as total_time FROM `tm_task` WHERE  `taskboard` = '$taskboard' and `assign_to` = '$user'");
    } else if ($taskboard == "" && $user != "" && $timezone != "") {
        $exportData = mysqli_query($db, "SELECT `taskboard`,`assign_to`,`equipment`,`property`,`building`,`duration`,`assigned_time`,`finished_time`,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(`finished_time` ,`assigned_time`))) as total_time FROM `tm_task` WHERE DATE_FORMAT(`assigned_time`,'%Y-%m-%d') >= '$countdate' and DATE_FORMAT(`assigned_time`,'%Y-%m-%d') <= '$curdate' and `assign_to` = '$user'");
    } else if ($taskboard == "" && $user != "" && $timezone == "") {
        $exportData = mysqli_query($db, "SELECT `taskboard`,`assign_to`,`equipment`,`property`,`building`,`duration`,`assigned_time`,`finished_time`,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(`finished_time` ,`assigned_time`))) as total_time FROM `tm_task` WHERE  `assign_to` = '$user'");
    } else if ($taskboard != "" && $user == "" && $timezone != "") {
        $exportData = mysqli_query($db, "SELECT `taskboard`,`assign_to`,`equipment`,`property`,`building`,`duration`,`assigned_time`,`finished_time`,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(`finished_time` ,`assigned_time`))) as total_time FROM `tm_task` WHERE DATE_FORMAT(`assigned_time`,'%Y-%m-%d') >= '$countdate' and DATE_FORMAT(`assigned_time`,'%Y-%m-%d') <= '$curdate' and `taskboard` = '$taskboard' ");
    } else if ($taskboard != "" && $user == "" && $timezone == "") {
        $exportData = mysqli_query($db, "SELECT `taskboard`,`assign_to`,`equipment`,`property`,`building`,`duration`,`assigned_time`,`finished_time`,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(`finished_time` ,`assigned_time`))) as total_time FROM `tm_task` WHERE `taskboard` = '$taskboard' ");
    } else if ($taskboard == "" && $user == "" && $timezone != "") {
        $exportData = mysqli_query($db, "SELECT `taskboard`,`assign_to`,`equipment`,`property`,`building`,`duration`,`assigned_time`,`finished_time`,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(`finished_time` ,`assigned_time`))) as total_time FROM `tm_task` WHERE DATE_FORMAT(`assigned_time`,'%Y-%m-%d') >= '$countdate' and DATE_FORMAT(`assigned_time`,'%Y-%m-%d') <= '$curdate' ");
    } else {
        $exportData = mysqli_query($db, "SELECT `taskboard`,`assign_to`,`equipment`,`property`,`building`,`duration`,`assigned_time`,`finished_time`,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(`finished_time` ,`assigned_time`))) as total_time FROM `tm_task`");
    }
}
//$exportData = mysqli_query($db, "SELECT user_name,firstname,lastname,email,role,hiring_date,job_title_description,shift_location FROM users where users_id !='1' ");
$header = "Taskboard" . "\t" . "Assign To" . "\t" . "Equipment" . "\t" . "Property" . "\t" . "Building" . "\t" . "Estimated Duration" . "\t" . "Assign Time" . "\t" . "Finished Time" . "\t" . "Total Duration" . "\t";
$result = '';
$fields = mysqli_num_fields($db, $exportData);
for ($i = 0; $i < $fields; $i++) {
    $header .= mysqli_field_name($db, $exportData, $i) . "\t";
}
while ($row = mysqli_fetch_row($exportData)) {
    $line = '';
    $j = 1;
    foreach ($row as $value) {
        if ((!isset($value) ) || ( $value == "" )) {
            $value = "\t";
        } else {
            $value = str_replace('"', '""', $value);
            if ($j == 1) {
				$un = $value;
                $qur04 = mysqli_query($db, "SELECT taskboard_name FROM  sg_taskboard where sg_taskboard_id = '$un' ");
                while ($rowc04 = mysqli_fetch_array($qur04)) {
                    $lnn = $rowc04["taskboard_name"];
                }
                $value = $lnn;
				
            }
            if ($j == 2) {
                $un = $value;
                $qur04 = mysqli_query($db, "SELECT firstname,lastname FROM  cam_users where users_id = '$un' ");
                while ($rowc04 = mysqli_fetch_array($qur04)) {
                    $first = $rowc04["firstname"];
                    $last = $rowc04["lastname"];
                }
                $value = $first . " " . $last;
            }
            if ($j == 3) {
                $un = $value;
                $qur04 = mysqli_query($db, "SELECT tm_equipment_name FROM  tm_equipment where tm_equipment_id = '$un' ");
                while ($rowc04 = mysqli_fetch_array($qur04)) {
                    $pnn = $rowc04["tm_equipment_name"];
                }
                $value = $pnn;
            }
			if ($j == 4) {
                $un = $value;
                $qur04 = mysqli_query($db, "SELECT tm_property_name FROM  tm_property where tm_property_id = '$un' ");
                while ($rowc04 = mysqli_fetch_array($qur04)) {
                    $pnn = $rowc04["tm_property_name"];
                }
                $value = $pnn;
            }
			if ($j == 5) {
                $un = $value;
                $qur04 = mysqli_query($db, "SELECT tm_building_name FROM  tm_building where tm_building_id = '$un' ");
                while ($rowc04 = mysqli_fetch_array($qur04)) {
                    $pnn = $rowc04["tm_building_name"];
                }
                $value = $pnn;
            }
            $value = '"' . $value . '"' . "\t";
        }
        $line .= $value;
        $j++;
    }
    $result .= trim($line) . "\n";
}
$result = str_replace("\r", "", $result);
if ($result == "") {
    $result = "\nNo Record(s) Found!\n";
}
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Task Log.xls");
header("Pragma: no-cache");
header("Expires: 0");
print "$header\n$result";
?>