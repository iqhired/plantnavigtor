<?php
//SELECT `user_name`, DATEDIFF(now(),`hiring_date`) FROM users
ob_start();
ini_set('display_errors', 'off');
session_start();
include 'config.php';
$hed[] = "";
$line = $_POST['li'];
$lwn = $line;
$exportData = mysqli_query($db, " SELECT DISTINCT `line_name` FROM `user_rating` ORDER BY `line_name`");
$header = "Emp Name" . "\t" . "Hire Date" . "\t" . "Total Days" . "\t" . "Job Title" . "\t" . "Shift" . "\t" . "Status" . "\t";
$header1 = "\n" . "" . "\t" . "" . "\t" . "" . "\t" . "" . "\t" . "" . "\t" . "Status" . "\t";
while ($row = mysqli_fetch_array($exportData)) {
    $value11 = $row['line_name'];
    $exportData11 = mysqli_query($db, " SELECT DISTINCT `position_name`FROM `user_rating` WHERE `line_name` = '$value11'");
    $p = 0;
    $g = 0;
    while ($row1 = mysqli_fetch_array($exportData11)) {
        $value12 = $row1['position_name'];
        $value12 .= "style=font-weight:bold;background-color:#999;text-transform: uppercase;";
        $value2 = '"' . $value12 . '"' . "\t";
        $header1 .= $value2;
        $p ++;
    }
    $pi = $p;
    if ($pi == 5) {
        $p--;
    }
    if ($pi == 1) {
        $p--;
    }
    $g = $p / 2;
    for ($i = 0; $i < $g; $i++) {
        $header .= "\t";
    }
    //$value11 = str_replace( '"' , '""' , $value11 );
    $value = '"' . $value11 . '"' . "\t";
    $header .= $value;
    if ($pi != 5) {
        $g--;
    }
    for ($i = 0; $i < $g; $i++) {
        $header .= "\t";
    }
}
$header .= $header1;
//line code starts
$exportData3 = mysqli_query($db, " SELECT DISTINCT `user_name` FROM `user_rating` ");
while ($row3 = mysqli_fetch_row($exportData3)) {
    $line = '';
    foreach ($row3 as $value3) {
        if ((!isset($value3) ) || ( $value3 == "" )) {
            $value3 = "\t";
        } else {
            $value3 = str_replace('"', '""', $value3);
            $g = $value3;
            $value3 = '"' . $value3 . '"' . "\t";
        }
        $line .= $value3;
    }
    $nnm = $g;
    $exportData4 = mysqli_query($db, " SELECT hiring_date,DATEDIFF(now(),`hiring_date`),job_title_description,shift_location FROM  users where user_name = '$nnm'");
    $row4 = mysqli_fetch_row($exportData4);
    foreach ($row4 as $value4) {
        if ((!isset($value4) ) || ( $value4 == "" )) {
            $value4 = "\t";
        } else {
            $value4 = str_replace('"', '""', $value4);
            $value4 = '"' . $value4 . '"' . "\t";
        }
        $line .= $value4;
    }
    $line .= '"Active"';
    while ($row = mysqli_fetch_array($exportData)) {
        $value15 = $row['line_name'];
        $exportData11 = mysqli_query($db, " SELECT DISTINCT `position_name` FROM `user_rating` WHERE `line_name` = '$value15'");
        $line2 = "";
        while ($row1 = mysqli_fetch_array($exportData11)) {
            $positioname = $row1['position_name'];
//aaya thi code karvano baki che
            if ($nnm == $username) {
                $line2 .= '"' . $ratings . '"' . "\t";
            } else {
                $line2 .= "\t";
            }
        }
        $line .= $line2;
    }
    $result .= trim($line) . "\n";
}
//line code ends
$result = str_replace("\r", "", $result);
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Table All Data.xls");
header("Pragma: no-cache");
header("Expires: 0");
print "$header\n$result";
?>