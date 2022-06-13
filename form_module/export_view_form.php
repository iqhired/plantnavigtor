<?php
include '../config.php';
$user = $_SESSION['user'];
$dateto = $_SESSION['date_to_1'];
$datefrom = $_SESSION['date_from_1'];
$station =  $_SESSION['station_1'];
$part_number = $_SESSION['part_number_1'];
$part_family = $_SESSION['part_family_1'];
$form_type = $_SESSION['form_type_1'];

if(!empty($part_number)){
    $q_str = "and part_number = '$part_number' ";
}
if(!empty($part_family)){
    $q_str .= "and part_family = '$part_family' ";
}
if(!empty($form_type)){
    $q_str .= "and form_type = '$form_type' ";
}

    if ($station != "" && $datefrom != "" && $dateto != "") {
        $result = "SELECT fd.form_name,pn.part_number,ft.form_type_name,fd.created_at  FROM form_user_data as fd inner join pm_part_number as pn on fd.part_number = pn.pm_part_number_id inner join form_type as ft on fd.form_type = ft.form_type_id  WHERE DATE_FORMAT(fd.created_at,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(fd.created_at,'%Y-%m-%d') <= '$dateto' and fd.station = '$station' ORDER BY fd.form_user_data_id DESC";
        $qur = mysqli_query($db,$result);
    }



$header = "Sr No"."\t"."Form Name" . "\t" . "Part Number" . "\t" . "Form Type" . "\t"  .  "Created At" . "\t";
$result1 = '';
$i=1;
while ($row = mysqli_fetch_row($qur)) {
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
header("Content-Disposition: attachment; filename=Form Details Log.xls");
header("Pragma: no-cache");
header("Expires: 0");
print "$header\n$result1";
?>