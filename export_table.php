<?php
//SELECT `user_name`, DATEDIFF(now(),`hiring_date`) FROM users
ob_start();
ini_set('display_errors', 'off');
session_start();
include 'config.php';
$hed[] = "";
$line = $_POST['li'];
$line04 = mysqli_query($db, "select line_name from cam_line where line_id = '$line'");
while ($rowc_line = mysqli_fetch_array($line04)) {
    $line_name = $rowc_line["line_name"];
}
$lwn = $line;
$exportData = mysqli_query($db, " SELECT DISTINCT `user_id` FROM `cam_user_rating` WHERE `line_id` = '$line'");
$header = "First Name" . "\t" ."Last Name" . "\t" . "Hire Date" . "\t" . "Total Days" . "\t" . "Job Title" . "\t" . "Shift" . "\t" . "Status" . "\t" . "" . "\t" . "" . "\t" . "$line_name" . "\t";
$result = '';
$header1 = "\n" . "" . "\t" . "" . "\t" . "" . "\t" . "" . "\t" . "" . "\t" . "\t" . "" . "\t" ;
$header .= $header1;
$exportData11 = mysqli_query($db, " SELECT DISTINCT `position_id`FROM `cam_user_rating` WHERE `line_id` = '$line'");
while ($row11 = mysqli_fetch_row($exportData11)) {
    //$line = '';
    foreach ($row11 as $value11) {
        if ((!isset($value11) ) || ( $value11 == "" )) {
            $value11 = "\t";
        } else {
            $value11 = str_replace('"', '""', $value11);
            $hed[] = $value11;
            $qur04 = mysqli_query($db, "SELECT position_name FROM  cam_position where position_id = '$value11' ");
            while ($rowc04 = mysqli_fetch_array($qur04)) {
                $lnn = $rowc04["position_name"];
            }
            $value11 = $lnn;

            $value11 = '"' . $value11 . '"' . "\t";
        }
        $header .= $value11;
    }
}
//$fields = mysqli_num_fields($db, $exportData);
//for ($i = 0; $i < $fields; $i++) {
//    $header .= mysqli_field_name($db, $exportData, $i) . "\t";
//}
$pnhed = "0";
while ($row = mysqli_fetch_row($exportData)) {
    //$nnm = $row;
//	$nnm = str_replace( '"' , '""' , $row );
    $line = '';
    foreach ($row as $value) {
        if ((!isset($value) ) || ( $value == "" )) {
            $value = "\t";
        } else {
            $value = str_replace('"', '""', $value);
            $g = $value;
           // $value = '"' . $value . '"' . "\t";
        }
    //    $line .= $value;
    }
    $nnm = $g;
    $exportData1 = mysqli_query($db, " SELECT firstname,lastname,hiring_date,DATEDIFF(now(),`hiring_date`),job_title_description,shift_location FROM  cam_users where users_id = '$nnm'");
    $row1 = mysqli_fetch_row($exportData1);
    foreach ($row1 as $value1) {
        if ((!isset($value1) ) || ( $value1 == "" )) {
            $value1 = "\t";
        } else {
            $value1 = str_replace('"', '""', $value1);
            $value1 = '"' . $value1 . '"' . "\t";
        }
        $line .= $value1;
    }
    $line .= '"Active"';
//for loop starts
    $cccnt = count($hed);
//$line .= "\t";
    for ($ii = 0; $ii < $cccnt;) {
        $pn = $hed[$ii];
        $exportData2 = mysqli_query($db, " SELECT ratings FROM `cam_user_rating` WHERE `position_id` = '$pn' and `user_id` = '$nnm' AND `line_id` = '$lwn' ");
        $row2 = mysqli_fetch_row($exportData2);
        if ($row2 == "") {
            $line .= "\t";
        }
        foreach ($row2 as $value2) {
//$message = "Position :- ";
//echo "<script type='text/javascript'>alert('$message');</script>";
            if ((!isset($value2) ) || ( $value2 == "" )) {
                //  $value2 = "\t";
            } else {
                $value2 = str_replace('"', '""', $value2);
                $value2 = '"' . $value2 . '"' . "\t";
            }
            $line .= $value2;
        }
        $ii ++;
    }
// for loop over
    $result .= trim($line) . "\n";
}
$result = str_replace("\r", "", $result);
if ($result == "") {
    $result = "\nNo Record(s) Found!\n";
}
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Table List.xls");
header("Pragma: no-cache");
header("Expires: 0");
print "$header\n$result";
?>