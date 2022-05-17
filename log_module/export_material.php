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

$sql = ("SELECT cl.line_name ,pf.part_family_name,pn.part_number,pn.part_name ,mc.material_type,mt.created_at FROM material_tracability as mt inner join cam_line as cl on mt.line_no = cl.line_id inner join pm_part_family as pf on mt.part_family_id= pf.pm_part_family_id inner join pm_part_number as pn on mt.part_no=pn.pm_part_number_id inner join material_config as mc on mt.material_type=mc.material_id where DATE_FORMAT(mt.created_at,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(mt.created_at,'%Y-%m-%d') <= '$dateto' and cl.line_id='$station'");
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





