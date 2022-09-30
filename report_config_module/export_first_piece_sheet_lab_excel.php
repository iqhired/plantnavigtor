<?php
ob_start();
ini_set('display_errors', 'off');
session_start();
include '../config.php';
$chicagotime = date('m-d-Y', strtotime('-1 days'));
//$chicagotime1 = date('Y-m-d', strtotime('-1 days'));
$exportData = mysqli_query($db, "SELECT distinct `station`,`form_type`,count(form_name) as cd,created_at FROM `form_user_data` WHERE form_type in (4,5) and DATE_FORMAT(`created_at`,'%Y-%m-%d') >= '$chicagotime' and DATE_FORMAT(`created_at`,'%Y-%m-%d') <= '$chicagotime' ");
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
                $qur04 = mysqli_query($db, "SELECT * FROM `form_type` where `form_type_id` = '$un' ");
                while ($rowc04 = mysqli_fetch_array($qur04)) {
                    $pnn = $rowc04["form_type_name"];
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
file_put_contents("../daily_report/" . $chicagotime . "/Form_submit_Log_" . $chicagotime . ".xls", $header . "\n" . $result);
?>