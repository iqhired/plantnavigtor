<?php
ob_start();
ini_set('display_errors', 'off');
session_start();
include '../config.php';
$chicagotime = date('d-m-Y', strtotime('-1 days'));
$chicagotime1 = date('Y-m-d', strtotime('-1 days'));
if (!file_exists("../daily_report/" . $chicagotime)) {
    mkdir("../daily_report/" . $chicagotime, 0777, true);
}

$exportData = mysqli_query($db, "SELECT user_id,subject,message,signature,mail_sent_time FROM sg_sent_mail where DATE_FORMAT(`mail_sent_time`,'%Y-%m-%d') = '$chicagotime1' ");
$header = "User Name" . "\t" . "Subject" . "\t" . "Message" . "\t" . "Signature" . "\t" . "Mail Sent Time" . "\t";
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
                $qur04 = mysqli_query($db, "SELECT * FROM  cam_users where users_id = '$un' ");
                while ($rowc04 = mysqli_fetch_array($qur04)) {
                    $first = $rowc04["firstname"];
                    $last = $rowc04["lastname"];
                }
                $value = $first . " " . $last;
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
file_put_contents("../daily_report/" . $chicagotime . "/Communicator_Log_" . $chicagotime . ".xls", $header . "\n" . $result);
?>