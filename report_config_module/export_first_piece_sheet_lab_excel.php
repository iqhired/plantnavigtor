<?php
ob_start();
include '../config.php';
$chicagotime = date('m-d-Y', strtotime('-1 days'));
$chicagotime2 = date('m-d-Y', strtotime('-1 days'));
if (!file_exists("../daily_report/" . $chicagotime)) {
    mkdir("../daily_report/" . $chicagotime, 0777, true);
}
//$sql2 = sprintf("SELECT distinct `station`,`form_type`,created_at,count(form_name) as ce FROM `form_user_data` WHERE `form_type` = '4' and DATE_FORMAT(`created_at`,'%%Y-%%m-%%d') >= '%d' and DATE_FORMAT(`created_at`,'%%Y-%%m-%%d') <= '%d'" , $chicagotime1, $chicagotime1);
//$exportData = mysqli_query($db, "SELECT `station`,`form_type`,created_at,count(form_name) as ce FROM `form_user_data` WHERE DATE_FORMAT(`created_at`,'%m-%d-%Y') >= '$chicagotime2' and DATE_FORMAT(`created_at`,'%m-%d-%Y') <= '$chicagotime2' and form_type = 4 group by station");
$exportData = mysqli_query($db, "SELECT line_name,line_id FROM `cam_line` where enabled = 1 and is_deleted != 1 order by line_id asc");
$header = "Station" . "\t" . "First Piece Sheet Lab Count" . "\t" . "First Piece Sheet Op Count" . "\t";
$p = $chicagotime2 . "  " ."First_Piece_Sheet_Submit_Log";
while ($row = mysqli_fetch_row($exportData)) {
    $line = '';
    $j = 1;
    foreach ($row as $value) {
        if ((!isset($value) ) || ( $value == "" )) {
            $value = "\t";
        } else {
            $value = str_replace('"', '""', $value);
            if ($j == 2) {
                $un = $value;
                $qur01 = mysqli_query($db, "select * from cam_line where line_id = '$un'");
                while ($rowc01 = mysqli_fetch_array($qur01)) {
                    $line_id = $rowc01['line_id'];
                    $q3 = mysqli_query($db, "SELECT `station`,`form_type`,created_at as cr,count(form_name) as ce FROM `form_user_data` where `station` = '$line_id' and form_type = 4 and DATE_FORMAT(`created_at`,'%m-%d-%Y') >= '$chicagotime2' and DATE_FORMAT(`created_at`,'%m-%d-%Y') <= '$chicagotime2'");
                    $r3 = $q3->fetch_assoc();
                    $form_type = $r3["form_type"];
                    $cr = $r3["cr"];
                    $ce = $r3["ce"];
                    $q31 = mysqli_query($db, "SELECT `station`,`form_type`,created_at as ct,count(form_name) as cnt FROM `form_user_data` where `station` = '$line_id' and form_type = 5 and DATE_FORMAT(`created_at`,'%m-%d-%Y') >= '$chicagotime2' and DATE_FORMAT(`created_at`,'%m-%d-%Y') <= '$chicagotime2'");
                    $r31 = $q31->fetch_assoc();
                    $form_type1 = $r31["form_type"];
                    $cnt = $r31["cnt"];
                }
                $value = $ce;
            }
            $value = '"' . $value . '"' . "\t";
        }
        $line .= $value;

        $j++;
    }
    $result .= trim($line) . "\t" . trim($cnt) ."\n";
}
$result = str_replace("\r", "", $result ."\n\n\n");
if ($result == "") {
    $result = "\nNo Record(s) Found!\n";
}
/*$exportData1 = mysqli_query($db, "SELECT line_name,line_id FROM `cam_line` where enabled = 1 and is_deleted != 1 order by line_id asc");
$header1 = "Station" . "\t" . "Form Type Name" . "\t" . "Created Date" . "\t" . "Count" . "\t";
while ($row1 = mysqli_fetch_row($exportData1)) {
    $line1 = '';
    $j1= 1;
    foreach ($row1 as $value1) {
        if ((!isset($value1) ) || ( $value1 == "" )) {
            $value1 = "\t";
        } else {
            $value1 = str_replace('"', '""', $value1);
            if ($j1 == 2) {
                $un1 = $value1;
                $qur011 = mysqli_query($db, "select * from cam_line where line_id = '$un1'");
                while ($rowc011 = mysqli_fetch_array($qur011)) {
                    $line_id1 = $rowc011['line_id'];
                    $q31 = mysqli_query($db, "SELECT `station`,`form_type`,created_at as cr,count(form_name) as ce FROM `form_user_data` where `station` = '$line_id1' and form_type = 5 and DATE_FORMAT(`created_at`,'%m-%d-%Y') >= '$chicagotime2' and DATE_FORMAT(`created_at`,'%m-%d-%Y') <= '$chicagotime2'");
                    $r31 = $q31->fetch_assoc();
                    $form_type1 = $r31["form_type"];
                    $cr1 = $r31["cr"];
                    $ce1 = $r31["ce"];
                    $qur0511 = mysqli_query($db, "SELECT * FROM `form_type` where `form_type_id` = '$form_type1'");
                    $rowc0511 = $qur0511->fetch_assoc();
                    $pnn1 = $rowc0511["form_type_name"];
                }
                $value1 = $pnn1;
            }
            $value1 = '"' . $value1 . '"' . "\t";
        }
        $line1 .= $value1;

        $j1++;
    }
    $result1 .= trim($line1) . "\t" . trim($cr1) . "\t" . trim($ce1) ."\n";
}
$result1 = str_replace("\r", "", $result1);
if ($result1 == "") {
    $result1 = "\nNo Record(s) Found!\n";
}*/
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename= " . "First_Piece_Sheet_Submit_Log_" . $chicagotime . ".xls");
header("Pragma: no-cache");
header("Expires: 0");
//print "\n\n" . $p . "\n\n" . $header . "\n" . $result ."\n\n" . $p . "\n\n" . $header1 ."\n" . $result1;
//file_put_contents("../daily_report/" . $chicagotime . "/First_Piece_Sheet_Submit_Log_" . $chicagotime . ".xls",  "\n\n" . $p . "\n\n" . $header . "\n" . $result . "\n\n" . $p . "\n\n" . $header1 . "\n" . $result1);
print "\n\n" . $p . "\n\n" . $header . "\n" . $result;
file_put_contents("../daily_report/" . $chicagotime . "/First_Piece_Sheet_Submit_Log_" . $chicagotime . ".xls",  "\n\n" . $p . "\n\n" . $header . "\n" . $result);
?>
