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
//$exportData = mysqli_query($db, "SELECT line_name,line_id FROM `cam_line` where enabled = 1 and is_deleted != 1 order by line_id asc");
$exportData = mysqli_query($db,"SELECT s.line_id as line_id,s.total_time,g.`good_pieces` as good_pieces,g.`bad_pieces`,g.`rework` as rework,g.created_at as created_at,g.created_at,ss.part_number_id,ss.part_family_id,ss.part_number_id FROM `good_bad_pieces_details` as g
    INNER JOIN sg_station_event_log_update as s ON s.station_event_id = g.station_event_id 
    INNER JOIN sg_station_event as ss ON ss.station_event_id = s.station_event_id 
    WHERE DATE_FORMAT(`created_at`,'%m-%d-%Y') >= '$chicagotime2' and DATE_FORMAT(`created_at`,'%m-%d-%Y') <= '$chicagotime2' GROUP BY g.station_event_id ORDER BY s.line_id,g.station_event_id");
$header = "Station" . "\t" . "TotalUp-time" . "\t"  . "Good Piece" . "\t" . "Bad Piece" . "\t" . "Rework" . "\t" . "Efficiency" . "\t" . "Actual NPR" . "\t" . "Estimated NPR" . "\t" . "Part Family" . "\t" . "Part Number&Name" . "\t";
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
            if ($j == 7) {
                $un = $value;
                $q21 = mysqli_query($db, "SELECT * FROM `good_bad_pieces_details` where `created_at` = '$un'");
                while ($row21 = mysqli_fetch_array($q21)) {
                    $station_event_id1 = $row21["station_event_id"];
                    $good_pieces1 = $row21["good_pieces"];
                    if(empty($good_pieces1)){
                        $g1 = 0;
                    }else{
                        $g1 = $good_pieces1;
                    }
                    $rework1 = $row21["rework"];
                    if(empty($rework1)){
                        $r1 = 0;
                    }else{
                        $r1 = $rework1;
                    }
                    $gpr1 = $g1 + $r1;
                    $q31 = mysqli_query($db, "SELECT * FROM `sg_station_event_log_update` where `station_event_id` = '$station_event_id1'");
                    $r31 = $q31->fetch_assoc();
                    $total_time1 = $r31["total_time"];
                    if ($total_time1 === '0'|| $total_time1 === '0.0' ||$gpr1 === 0 || $gpr1 === 0.0) {
                        $a_npr = 0;
                    } else {
                        $a_npr = round($gpr1/$total_time1 , 2);
                    }
                }
                $value = $a_npr;
            }
            if ($j == 8) {
                $un = $value;
                $qur077 = mysqli_query($db, "SELECT part_number,part_name FROM pm_part_number where pm_part_number_id = '$un' ");

                while ($rowc077 = mysqli_fetch_array($qur077)) {
                    $npr77 = $rowc077["npr"];
                    if(empty($npr77)){
                        $npr771 = 30;
                    }else{
                        $npr771 = $npr77;
                    }
                }
                $value = $npr771;
            }
            if ($j == 9) {
                $un = $value;
                $qur061 = mysqli_query($db, "SELECT part_family_name FROM  pm_part_family where pm_part_family_id = '$un' ");

                while ($rowc061 = mysqli_fetch_array($qur061)) {
                    $lnn6 = $rowc061["part_family_name"];
                }
                $value = $lnn6;
            }
            if ($j == 10) {
                $un = $value;
                $qur071 = mysqli_query($db, "SELECT part_number,part_name FROM pm_part_number where pm_part_number_id = '$un' ");

                while ($rowc071 = mysqli_fetch_array($qur071)) {
                    $lnn7 = $rowc071["part_number"].' - '.$rowc071["part_name"] ;
                }
                $value = $lnn7;
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
