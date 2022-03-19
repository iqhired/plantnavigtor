<?php
ob_start();
ini_set('display_errors', 'off');
session_start();
include 'config.php';
$exportData = mysqli_query($db, "SELECT user_name,firstname,lastname,email,role,hiring_date,job_title_description,shift_location FROM users where users_id !='1' ");
$header = "User Name" . "\t" . "First Name" . "\t" . "Last Name" . "\t" . "Email" . "\t" . "Role" . "\t" . "Hiring Date" . "\t" . "Job Title" . "\t" . "Shift Location" . "\t";
$result = '';
$fields = mysqli_num_fields($db, $exportData);
for ($i = 0; $i < $fields; $i++) {
    $header .= mysqli_field_name($db, $exportData, $i) . "\t";
}
while ($row = mysqli_fetch_row($exportData)) {
    $line = '';
    foreach ($row as $value) {
        if ((!isset($value) ) || ( $value == "" )) {
            $value = "\t";
        } else {
            $value = str_replace('"', '""', $value);
            $value = '"' . $value . '"' . "\t";
        }
        $line .= $value;
    }
    $result .= trim($line) . "\n";
}
$result = str_replace("\r", "", $result);
if ($result == "") {
    $result = "\nNo Record(s) Found!\n";
}
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Users List.xls");
header("Pragma: no-cache");
header("Expires: 0");
print "$header\n$result";
?>