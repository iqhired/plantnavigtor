<?php
ob_start();
ini_set('display_errors', 'off');
session_start();
include '../config.php';
$chicagotime = date('d-m-Y', strtotime('-1 days'));
$chicagotime1 = date('Y-m-d', strtotime('-1 days'));if (!file_exists("../daily_report/" . $chicagotime)) {
    mkdir("../daily_report/" . $chicagotime, 0777, true);
}
$qur05 = mysqli_query($db, "SELECT * FROM `tm_task_log_config` ");
while ($rowc05 = mysqli_fetch_array($qur05)) {
    $taskboard_id = $rowc05["taskboard"];
    $qur06 = mysqli_query($db, "SELECT * FROM `sg_taskboard` where sg_taskboard_id = '$taskboard_id' ");
    $rowc06 = mysqli_fetch_array($qur06);
    $taskboard_name = $rowc06["taskboard_name"];
    $exportData = mysqli_query($db, "SELECT `taskboard`,`assign_to`,`equipment`,`property`,`building`,`assigned_time`,`finished_time`,`duration`, SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(`finished_time` ,`assigned_time`))) as total_time  FROM `tm_task` WHERE DATE_FORMAT(`assigned_time`,'%Y-%m-%d') >= '$chicagotime1' and DATE_FORMAT(`assigned_time`,'%Y-%m-%d') <= '$chicagotime1' and taskboard = '$taskboard_id' ");
//$exportData = mysqli_query($db, "SELECT user_name,firstname,lastname,email,role,hiring_date,job_title_description,shift_location FROM users where users_id !='1' ");
    $header = "Taskboard" . "\t" . "Assign To" . "\t" . "Equipment" . "\t" . "Property" . "\t" . "Building" . "\t". "Task Assign Time" . "\t" . "Task Completion Time" . "\t"  . "Estimated Duration" . "\t" . "Total Duration" . "\t";
  /*  $result = '';
    $fields = mysqli_num_fields($db, $exportData);
    for ($i = 0; $i < $fields; $i++) {
        $header .= mysqli_field_name($db, $exportData, $i) . "\t";
    }*/
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
                    $qur04 = mysqli_query($db, "SELECT * FROM  sg_taskboard where sg_taskboard_id = '$un' ");
                    while ($rowc04 = mysqli_fetch_array($qur04)) {
                        $first = $rowc04["taskboard_name"];
                    }
                    $value = $first;
                }
                if ($j == 2) {
                    $un = $value;
                    $qur04 = mysqli_query($db, "SELECT * FROM  cam_users where users_id = '$un' ");
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
    header("Content-Disposition: attachment; filename= " . $chicagotime . ".xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    print $header . "\n" . $result;
    file_put_contents("../daily_report/" . $chicagotime . "/" . $taskboard_name . "_Task_Log_" . $chicagotime . ".xls", $header . "\n" . $result);
}
?>