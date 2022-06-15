<?php
ini_set('display_errors', 'off');
include '../config.php';
$user = $_SESSION['user'];
$dateto = $_SESSION['date_to'];
$datefrom = $_SESSION['date_from'];
$timezone = $_SESSION['timezone'];
$station =  $_SESSION['station'];
$part_number = $_SESSION['part_number'];
$part_family = $_SESSION['part_family'];
$part_name = $_SESSION['part_name'];
$material_type = $_SESSION['material_type'];

$wc = '';
$print_data='';

if (!empty($station)) {
    $qurtemp = mysqli_query($db, "SELECT line_name FROM  cam_line where line_id = '$station' ");
    while ($rowctemp = mysqli_fetch_array($qurtemp)) {
        $line_name = $rowctemp["line_name"];
        $print_data .= "Station : " . $line_name . "\n";
    }

    $wc = $wc . " and sg_station_event.line_id = '$station'";
}
if (!empty($part_number)) {
    $qurtemp = mysqli_query($db, "SELECT part_number , part_name FROM `pm_part_number` where pm_part_number_id = '$part_number' ");
    while ($rowctemp = mysqli_fetch_array($qurtemp)) {
        $part_number = $rowctemp["part_number"];
        $part_name = $rowctemp["part_name"];
        $print_data .= "Part Number  : " . $part_number . "\n";
        $print_data .= "Part Description / Name  : " . $part_name . "\n";
    }
    $wc = $wc . " and sg_station_event.part_number_id = '$part_number'";
}
if (!empty($part_family)) {
    $qurtemp = mysqli_query($db, "SELECT part_family_name FROM `pm_part_family` where pm_part_family_id = '$part_family' ");
    while ($rowctemp = mysqli_fetch_array($qurtemp)) {
        $part_family_name = $rowctemp["part_family_name"];
        $print_data .= "Part Family  : " . $part_family_name . "\n";
    }
    $wc = $wc . " and sg_station_event.part_family_id = '$part_family'";
}
if (!empty($datefrom)) {
    $print_data .= "From Date : " . $datefrom . "\n";
    $wc = $wc . " and DATE_FORMAT(`created_at`,'%Y-%m-%d') >= '$datefrom' ";
}
if (!empty($dateto)) {
    $print_data .= "To Date : " . $dateto . "\n\n\n";
    $wc = $wc . " and DATE_FORMAT(`created_at`,'%Y-%m-%d') <= '$dateto' ";
}

$sql = ("SELECT cl.line_name ,pf.part_family_name,pn.part_number,pn.part_name ,mc.material_type,mt.created_at FROM material_tracability as mt inner join cam_line as cl on mt.line_no = cl.line_id inner join pm_part_family as pf on mt.part_family_id= pf.pm_part_family_id inner join pm_part_number as pn on mt.part_no=pn.pm_part_number_id inner join material_config as mc on mt.material_type=mc.material_id where DATE_FORMAT(mt.created_at,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(mt.created_at,'%Y-%m-%d') <= '$dateto' and cl.line_id='$station' and mt.material_status = '1'");
$gp_result = mysqli_query($db,$sql);

$header = "Sr. No" . "\t" . "Station" . "\t" .  "Part Family" ."\t" . "Part Number" ."\t" . "Part Name" ."\t". "Material Type" . "\t" . "Time";
$result = '';
$i=1;
while ($row = mysqli_fetch_row($gp_result)) {
    $line = '';
    $j = 1;
    foreach ($row as $value) {
        if ((empty($value)) || ($value == "")) {
            $value = "-"."\t";
        } else {
            $value = str_replace('"', '""', $value);
            $value = '"' . $value . '"' . "\t";
        }
        $line .= $value;
        $j++;
    }
    $result .= $i."\t".trim($line) . "\n";
    $i++;
}
$result = str_replace("\r", "", $result);
if ($result == "") {
    $result = "\nNo Record(s) Found!\n";
}

$sql_pass = ("SELECT cl.line_name ,pf.part_family_name,pn.part_number,pn.part_name ,mc.material_type,mt.fail_reason,mt.created_at FROM material_tracability as mt inner join cam_line as cl on mt.line_no = cl.line_id inner join pm_part_family as pf on mt.part_family_id= pf.pm_part_family_id inner join pm_part_number as pn on mt.part_no=pn.pm_part_number_id inner join material_config as mc on mt.material_type=mc.material_id where DATE_FORMAT(mt.created_at,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(mt.created_at,'%Y-%m-%d') <= '$dateto' and cl.line_id='$station' and mt.material_status = '0'");
$pass_result = mysqli_query($db,$sql_pass);

$header_pass = "Sr. No" . "\t" . "Station" . "\t" .  "Part Family" ."\t" . "Part Number" ."\t" . "Part Name" ."\t". "Material Type" . "\t" . "Fail Reason". "\t" . "Time";
$result_pass = '';
$i=1;
while ($row_pass = mysqli_fetch_row($pass_result)) {
    $line_pass = '';
    $j = 1;
    foreach ($row_pass as $value_pass) {
        if ((empty($value_pass)) || ($value_pass == "")) {
            $value_pass = "-"."\t";
        } else {
            $value_pass = str_replace('"', '""', $value_pass);
            $value_pass = '"' . $value_pass . '"' . "\t";
        }
        $line_pass .= $value_pass;
        $j++;
    }
    $result_pass .= $i."\t".trim($line_pass) . "\n";
    $i++;
}
$result_pass = str_replace("\r", "", $result_pass);
if ($result_pass == "") {
    $result_pass = "\nNo Record(s) Found!\n";
}

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Material tracability Log.xls");
header("Pragma: no-cache");
header("Expires: 0");
print "\n\n$print_data\n$header\n$result\n\n\n\n";
print "$header_pass\n$result_pass";

?>





