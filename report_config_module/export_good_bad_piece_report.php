<?php
include '../config.php';
$chicagotime = date('d-m-Y', strtotime('-1 days'));
$chicagotime1 = date('Y-m-d', strtotime('-1 days'));
if (!file_exists("../daily_report/" . $chicagotime)) {
    mkdir("../daily_report/" . $chicagotime, 0777, true);
}
//$exportData = mysqli_query($db, "SELECT `station_event_id`,`good_pieces`,`defect_name`,`bad_pieces`,`rework`,`created_at`  as time FROM `good_bad_pieces_details` WHERE DATE_FORMAT(`created_at`,'%Y-%m-%d') >= '$chicagotime1' and DATE_FORMAT(`created_at`,'%Y-%m-%d') <= '$chicagotime1' ");
$exportData = mysqli_query($db,"SELECT (select sg_station_event.line_id from sg_station_event where good_bad_pieces_details.station_event_id = sg_station_event.station_event_id) as Station ,  ( select pm_part_family.part_family_name from pm_part_family where pm_part_family.pm_part_family_id = sg_station_event.part_family_id) as p_fam_name ,( select pm_part_number.part_number from pm_part_number where pm_part_number.pm_part_number_id = sg_station_event.part_number_id) as pm_p_num , ( select pm_part_number.part_name from pm_part_number where pm_part_number.pm_part_number_id = sg_station_event.part_number_id) as pm_part_name , good_bad_pieces_details.good_pieces AS good_pieces, good_bad_pieces_details.bad_pieces AS bad_pieces,good_bad_pieces_details.rework AS rework,good_bad_pieces_details.created_by , good_bad_pieces_details.created_at  FROM `good_bad_pieces_details`  INNER JOIN sg_station_event ON good_bad_pieces_details.station_event_id = sg_station_event.station_event_id where DATE_FORMAT(`created_at`,'%Y-%m-%d') >= '$chicagotime1' and DATE_FORMAT(`created_at`,'%Y-%m-%d') <= '$chicagotime1'");

$header = "Station" . "\t"  . "Part Family Name" . "\t" . "Part Number" . "\t" . "Part Name" . "\t". "Good Pieces" . "\t". "Bad Pieces" . "\t". "Rework" . "\t". "User" . "\t". "Time" . "\t";
$result = '';
//$fields = mysqli_num_fields($db, $exportData);
//for ($i = 0; $i < $fields; $i++) {
//    $header .= mysqli_field_name($db, $exportData, $i) . "\t";
//}

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
file_put_contents("../daily_report/" . $chicagotime . "/Good_bad_Log_" . $chicagotime . ".xls", $header . "\n" . $result);


?>