<?php
ob_start();
ini_set('display_errors', 'off');
session_start();
include '../config.php';
$chicagotime = date('m-d-Y', strtotime('-1 days'));
//$chicagotime1 = date('Y-m-d', strtotime('-1 days'));
$exportData = mysqli_query($db, "SELECT distinct `station`,`form_type`,count(form_name) as cd,created_at FROM `form_user_data` WHERE form_type = 4 and DATE_FORMAT(`created_at`,'%Y-%m-%d') >= '$chicagotime' and DATE_FORMAT(`created_at`,'%Y-%m-%d') <= '$chicagotime' ");
//$exportData = mysqli_query($db, "SELECT user_name,firstname,lastname,email,role,hiring_date,job_title_description,shift_location FROM users where users_id !='1' ");
$header = "Station" . "\t" . "Form Type Name" . "\t" . "Created Date" . "\t" . "Count" . "\t";
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
                $qur04 = mysqli_query($db, "SELECT line_name FROM  cam_line where line_id = '$un' ");
                while ($rowc04 = mysqli_fetch_array($qur04)) {
                    $lnn = $rowc04["line_name"];
                }
                $value = $lnn;
            }
            if ($j == 2) {
                $un = $value;
                $qur05 = mysqli_query($db, "SELECT * FROM `form_type` where `form_type_id` = '$un' ");
                while ($rowc05 = mysqli_fetch_array($qur05)) {
                    $pnn = $rowc05["form_type_name"];
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
$exportData1 = mysqli_query($db, "SELECT distinct `station`,`form_type`,count(form_name) as ce,created_at FROM `form_user_data` WHERE form_type = 5 and DATE_FORMAT(`created_at`,'%Y-%m-%d') >= '$chicagotime' and DATE_FORMAT(`created_at`,'%Y-%m-%d') <= '$chicagotime' ");
$result1 = '';
$fields1 = mysqli_num_fields($db, $exportData1);
for ($i1 = 0; $i1 < $fields1; $i1++) {
    $header .= mysqli_field_name($db, $exportData1, $i1) . "\t";
}
while ($row1 = mysqli_fetch_row($exportData1)) {
    $line1 = '';
    $j1 = 1;
    foreach ($row1 as $value1) {
        if ((!isset($value1) ) || ( $value1 == "" )) {
            $value1 = "\t";
        } else {
            $value1 = str_replace('"', '""', $value1);
            if ($j1 == 1) {
                $un1 = $value1;
                $qur041 = mysqli_query($db, "SELECT line_name FROM  cam_line where line_id = '$un1' ");
                while ($rowc041 = mysqli_fetch_array($qur041)) {
                    $lnn1 = $rowc041["line_name"];
                }
                $value1 = $lnn1;
            }
            if ($j1 == 2) {
                $un1 = $value1;
                $qur051 = mysqli_query($db, "SELECT * FROM `form_type` where `form_type_id` = '$un1' ");
                while ($rowc051 = mysqli_fetch_array($qur051)) {
                    $pnn1 = $rowc051["form_type_name"];
                }
                $value1 = $pnn1;
            }
            $value1 = '"' . $value1 . '"' . "\t";
        }
        $line1 .= $value1;
        $j1++;
    }
    $result1 .= trim($line1) . "\n";
}
$result1 = str_replace("\r", "", $result1);
if ($result1 == "") {
    $result1 = "\nNo Record(s) Found!\n";
}
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename= " . $chicagotime . ".xls");
header("Pragma: no-cache");
header("Expires: 0");
print $header . "\n" . $result . "\n" . $result1;
file_put_contents("../daily_report/" . $chicagotime . "/Form_submit_Log_" . $chicagotime . ".xls", $header . "\n" . $result);
?>