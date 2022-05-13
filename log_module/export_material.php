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
$wc = $wc . " and DATE_FORMAT(`created_at`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`created_at`,'%Y-%m-%d') <= '$dateto' ";

$sql = "SELECT line_no, part_family_id,part_no,part_name,material_type, created_at from material_tracability DATE_FORMAT(`created_at`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`created_at`,'%Y-%m-%d') <= '$dateto' where line_no = '$station'";
$gp_result = mysqli_query($db,$sql);

$header1 = "Sr. No" . "\t" . "Station" . "\t" .  "Part Family" ."\t" . "Part Number" ."\t" . "Part Name" ."\t". "Material Type" . "\t" . "Time";
$result1 = '';
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
    $result1 .= $i."\t".trim($line) . "\n";
    $i++;
}
$result1 = str_replace("\r", "", $result1);
if ($result1 == "") {
    $result1 = "\nNo Record(s) Found!\n";
}

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Material tracability Log.xls");
header("Pragma: no-cache");
header("Expires: 0");
print "\n\n$print_data\n$header1\n$result1\n\n\n\n";
print "$header\n$result";
?>





