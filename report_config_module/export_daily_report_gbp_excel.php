<?php
ob_start();
ini_set('display_errors', 'off');
session_start();
include '../config.php';
$chicagotime = date('m-d-Y', strtotime('-1 days'));
$chicagotime2 = date('m-d-Y', strtotime('-1 days'));
if (!file_exists("../daily_report/" . $chicagotime)) {
    mkdir("../daily_report/" . $chicagotime, 0777, true);
}
/*$exportData = mysqli_query($db,"SELECT distinct sg_station_event_log_update.`line_id` as line_id,good_bad_pieces_details.good_pieces as good_pieces,good_bad_pieces_details.bad_pieces,good_bad_pieces_details.rework as rework, sg_station_event_log_update.event_cat_id,good_bad_pieces_details.created_at as created_at FROM `sg_station_event_log_update`
    INNER JOIN good_bad_pieces_details ON good_bad_pieces_details.`station_event_id` = sg_station_event_log_update.`station_event_id` 
    where DATE_FORMAT(`created_at`,'%m-%d-%Y') >= '$chicagotime2' and DATE_FORMAT(`created_at`,'%m-%d-%Y') <= '$chicagotime2' ORDER BY line_id ASC");*/
$exportData = mysqli_query($db,"SELECT s.line_id as line_id,g.`good_pieces` as good_pieces,g.`bad_pieces`,g.`rework` as rework,s.event_cat_id,g.created_at as created_at,g.created_at FROM `good_bad_pieces_details` as g 
    INNER JOIN sg_station_event_log_update as s ON s.station_event_id = g.station_event_id WHERE DATE_FORMAT(`created_at`,'%m-%d-%Y') >= '$chicagotime2' and DATE_FORMAT(`created_at`,'%m-%d-%Y') <= '$chicagotime2' GROUP BY g.station_event_id ORDER BY s.line_id,g.station_event_id");
$header = "Station" . "\t" . "Good Piece" . "\t" . "Bad Piece" . "\t" . "Rework" . "\t" . "Category" . "\t" . "Efficiency" . "\t" . "Date&Time" . "\t";
$p = $chicagotime2 . "  " ."Daily_Efficiency_Report_Log";
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
                $qur04 = mysqli_query($db, "SELECT line_name FROM cam_line where line_id = '$un' ");
                while ($rowc04 = mysqli_fetch_array($qur04)) {
                    $lnn = $rowc04["line_name"];
                    $ln = $rowc04["line_id"];
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
            if ($j == 6) {
                $un = $value;
                $q1 = mysqli_query($db, "SELECT * FROM `good_bad_pieces_details` where `created_at` = '$un'");
                while ($row2 = mysqli_fetch_array($q1)) {
                    $station_event_id = $row2["station_event_id"];
                    $good_pieces = $row2["good_pieces"];
                    if(empty($good_pieces)){
                        $g = 0;
                    }else{
                        $g = $good_pieces;
                    }
                    $rework = $row2["rework"];
                    if(empty($rework)){
                        $r = 0;
                    }else{
                        $r = $rework;
                    }
                    $gpr = $g + $r;
                    $q3 = mysqli_query($db, "SELECT * FROM `sg_station_event_log_update` where `station_event_id` = '$station_event_id'");
                    $r3 = $q3->fetch_assoc();
                    $total_time = $r3["total_time"];
                    $q2 = mysqli_query($db, "SELECT * FROM `sg_station_event` where `station_event_id` = '$station_event_id'");
                    $r2 = $q2->fetch_assoc();
                    $part_number = $r2["part_number_id"];
                    $sqlpnum = "SELECT * FROM `pm_part_number` where `pm_part_number_id` = '$part_number'";
                    $resultpnum = mysqli_query($db, $sqlpnum);
                    $rowcpnum = $resultpnum->fetch_assoc();
                    $pm_npr = $rowcpnum['npr'];
                    if (empty($pm_npr)) {
                        $npr = 30;
                    } else {
                        $npr = $pm_npr;
                    }
                    $target_eff = round($npr * $total_time);
                    $actual_eff = $gpr;
                    if ($actual_eff === 0 || $target_eff === 0 || $target_eff === 0.0 || $actual_eff === 0.0) {
                        $eff = 0;
                    } else {
                        $eff = round(100 * ($actual_eff / $target_eff));
                    }
                }
                $value = $eff;
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
header("Content-Disposition: attachment; filename= " . "Daily_Efficiency_Report_Log_" . $chicagotime . ".xls");
header("Pragma: no-cache");
header("Expires: 0");
print "\n\n" . $p . "\n\n" . $header . "\n" . $result;
file_put_contents("../daily_report/" . $chicagotime . "/Daily_Efficiency_Report_Log_" . $chicagotime . ".xls", "\n\n" . $p . "\n\n" . $header . "\n" . $result);
?>
