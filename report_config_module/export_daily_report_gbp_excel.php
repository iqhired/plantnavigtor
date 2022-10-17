<?php
include '../config.php';
$chicagotime = date('m-d-Y', strtotime('-6 days'));
$chicagotime1 = date('m-d-Y', strtotime('-6 days'));
if (!file_exists("../daily_report/" . $chicagotime)) {
    mkdir("../daily_report/" . $chicagotime, 0777, true);
}
/*$query0003 = mysqli_query($db,"SELECT sg_station_event.`line_id` as line_id,good_bad_pieces_details.good_pieces as good_pieces,good_bad_pieces_details.bad_pieces,good_bad_pieces_details.rework as rework,sg_station_event_log.event_cat_id,good_bad_pieces_details.created_at as created_at FROM `sg_station_event` INNER JOIN good_bad_pieces_details ON good_bad_pieces_details.`station_event_id` = sg_station_event.`station_event_id` INNER JOIN sg_station_event_log ON sg_station_event_log.`station_event_id` = sg_station_event.`station_event_id` where DATE_FORMAT(`created_at`,'%m-%d-%Y') >= '$chicagotime1' and DATE_FORMAT(`created_at`,'%m-%d-%Y') <= '$chicagotime1'");
while($rowc0003 = $query0003->fetch_assoc()){
$g = $rowc0003["good_pieces"];
$r = $rowc0003["rework"];
$npr = 30;
$h = 1;
$gpr = $g + $r;
$target_eff = round($npr * $h);
$actual_eff = $gpr;
$eff = round(100 * ($actual_eff/$target_eff));}*/
//$exportData = mysqli_query($db, "SELECT `station_event_id`,`good_pieces`,`defect_name`,`bad_pieces`,`rework`,`created_at`  as time FROM `good_bad_pieces_details` WHERE DATE_FORMAT(`created_at`,'%Y-%m-%d') >= '$chicagotime1' and DATE_FORMAT(`created_at`,'%Y-%m-%d') <= '$chicagotime1' ");
$exportData = mysqli_query($db,"SELECT sg_station_event.`line_id` as line_id,good_bad_pieces_details.good_pieces as good_pieces,good_bad_pieces_details.bad_pieces,good_bad_pieces_details.rework as rework,sg_station_event_log.event_cat_id,good_bad_pieces_details.created_at as created_at FROM `sg_station_event` INNER JOIN good_bad_pieces_details ON good_bad_pieces_details.`station_event_id` = sg_station_event.`station_event_id` INNER JOIN sg_station_event_log ON sg_station_event_log.`station_event_id` = sg_station_event.`station_event_id` where DATE_FORMAT(`created_at`,'%m-%d-%Y') >= '$chicagotime1' and DATE_FORMAT(`created_at`,'%m-%d-%Y') <= '$chicagotime1'");
$header = "Station" . "\t"  . "Good Pieces" . "\t" . "Bad Pieces" . "\t" . "Rework" . "\t". "Category" . "\t". "Efficiency" . "\t";
$result = '';
//$fields = mysqli_num_fields($db, $exportData);
//for ($i = 0; $i < $fields; $i++) {
//    $header .= mysqli_field_name($db, $exportData, $i) . "\t";
//}
while ($row = mysqli_fetch_row($exportData)) {

   //
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
            if ($j == 5) {
                $un = $value;
                $qur041 = mysqli_query($db, "SELECT events_cat_name FROM  events_category where events_cat_id = '$un' ");

                while ($rowc041 = mysqli_fetch_array($qur041)) {
                    $lnn1 = $rowc041["events_cat_name"];
                }
                $value = $lnn1;
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
file_put_contents("../daily_report/" . $chicagotime . "/Daily_Efficiency_Report_Log_" . $chicagotime . ".xls", $header . "\n" . $result);


?>