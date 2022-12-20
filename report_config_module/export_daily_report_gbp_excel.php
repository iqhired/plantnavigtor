<?php
ob_start();
ini_set('display_errors', 'off');
session_start();
include '../config.php';
$date = date('d-M-Y', strtotime('-1 days'));
$chicagotime = date('m-d-Y', strtotime('-1 days'));
$chicagotime2 = date('m-d-Y', strtotime('-1 days'));
if (!file_exists("../daily_report/" . $chicagotime)) {
    mkdir("../daily_report/" . $chicagotime, 0777, true);
}
//$exportData = mysqli_query($db, "SELECT line_name,line_id FROM `cam_line` where enabled = 1 and is_deleted != 1 order by line_id asc");
$exportData = mysqli_query($db,"SELECT cl.line_name as station,/*e_log.station_event_id,*/sum(e_log.total_time) as total_time, 
e_log.station_event_id,e_log.station_event_id,e_log.station_event_id,e_log.station_event_id,e_log.station_event_id,pn.part_number as p_num, pf.part_family_name as pf_name,pn.part_number as p_num, pn.part_name as p_name from sg_station_event_log_update as e_log  
inner join sg_station_event as sg_events on e_log.station_event_id = sg_events.station_event_id 
INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id 
inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id 
inner join cam_line as cl on e_log.line_id = cl.line_id
where DATE_FORMAT(e_log.created_on,'%m-%d-%Y') >= '$chicagotime2' and DATE_FORMAT(e_log.created_on,'%m-%d-%Y') <= '$chicagotime2' GROUP BY e_log.station_event_id order by cl.line_id,e_log.station_event_id asc");
$header = "Station" . "\t" /*. "station_event_id" . "\t" */. "Total Up-Time" . "\t" . "Good Piece" . "\t" . "Bad Piece" . "\t" . "Rework" . "\t" . "Efficiency" . "\t" . "Actual NPR/hr" . "\t" . "Estimated NPR/hr" . "\t" . "Part Family" . "\t" . "Part Number" . "\t" . "Part Name" . "\t";
$p = onlydateReadFormat($date) . "\n" ."Daily Efficiency Report Log Data";
while ($row = mysqli_fetch_row($exportData)) {
    $line = '';
    $j = 1;
    foreach ($row as $value) {
        if ((!isset($value) ) || ( $value == "" )) {
            $value = "\t";
        } else {
            $value = str_replace('"', '""', $value);
            /* if ($j == 1) {
                 $un = $value;
                 $qur04 = mysqli_query($db, "SELECT line_name FROM cam_line where line_id = '$un' ");
                 while ($rowc04 = mysqli_fetch_array($qur04)) {
                     $lnn = $rowc04["line_name"];
                     $ln = $rowc04["line_id"];
                 }
                 $value = $lnn;
             }*/
            if ($j == 3) {
                $un = $value;
                $qur05 = mysqli_query($db, "SELECT sum(good_pieces) as good_pieces FROM good_bad_pieces_details where station_event_id = '$un' and DATE_FORMAT(created_at,'%m-%d-%Y') = '$chicagotime2'");
                while ($rowc05 = mysqli_fetch_array($qur05)) {
                    $good_pieces = $rowc05["good_pieces"];
                    if(empty($good_pieces)){
                        $g = 0;
                    }else{
                        $g = $good_pieces;
                    }
                }
                $value = $g;
            }
            if ($j == 4) {
                $un = $value;
                $qur06 = mysqli_query($db, "SELECT sum(bad_pieces) as bad_pieces FROM good_bad_pieces_details where station_event_id = '$un' and DATE_FORMAT(created_at,'%m-%d-%Y') = '$chicagotime2'");
                while ($rowc06 = mysqli_fetch_array($qur06)) {
                    $bad_pieces = $rowc06["bad_pieces"];
                    if(empty($bad_pieces)){
                        $b = 0;
                    }else{
                        $b = $bad_pieces;
                    }
                }
                $value = $b;
            }
            if ($j == 5) {
                $un = $value;
                $qur07 = mysqli_query($db, "SELECT sum(rework) as rework FROM good_bad_pieces_details where station_event_id = '$un' and DATE_FORMAT(created_at,'%m-%d-%Y') = '$chicagotime2'");
                while ($rowc07 = mysqli_fetch_array($qur07)) {
                    $rework = $rowc07["rework"];
                    if(empty($rework)){
                        $r = 0;
                    }else{
                        $r = $rework;
                    }
                }
                $value = $r;
            }
            if ($j == 6) {
                $un = $value;
                $q211 = mysqli_query($db, "SELECT sum(total_time) as total_time,station_event_id FROM sg_station_event_log_update where station_event_id = '$un' and DATE_FORMAT(created_on,'%m-%d-%Y') = '$chicagotime2'");
                while ($row211 = mysqli_fetch_array($q211)) {
                    $total_time1 = $row211["total_time"];
                    $station_event_idd1 = $row211["station_event_id"];
                    $q2 = mysqli_query($db, "SELECT * FROM `sg_station_event` where `station_event_id` = '$station_event_idd1'");
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
                    $q31 = mysqli_query($db, "SELECT sum(good_pieces) as good_pieces,sum(rework) as rework FROM `good_bad_pieces_details` where `station_event_id` = '$station_event_idd1' and DATE_FORMAT(created_at,'%m-%d-%Y') = '$chicagotime2'");
                    $r31 = $q31->fetch_assoc();
                    $good_pieces31 = $r31["good_pieces"];
                    if(empty($good_pieces31)){
                        $g11 = 0;
                    }else{
                        $g11 = $good_pieces31;
                    }
                    $rework31 = $r31["rework"];
                    if(empty($rework31)){
                        $r11 = 0;
                    }else{
                        $r11 = $rework31;
                    }
                    $gpr11 = $g11 + $r11;
                    $target_eff = $npr * $total_time1;
                    $actual_eff = $gpr11;
                    if ($actual_eff === 0 || $target_eff === 0 || $target_eff === 0.0 || $actual_eff === 0.0) {
                        $eff = 0;
                    } else {
                        $eff = round(100 * ($actual_eff / $target_eff));
                    }
                }
                $value = $eff . '%';
            }
            if ($j == 7) {
                $un = $value;
                $q21 = mysqli_query($db, "SELECT sum(total_time) as total_time,station_event_id FROM sg_station_event_log_update where station_event_id = '$un' and DATE_FORMAT(created_on,'%m-%d-%Y') = '$chicagotime2'");
                while ($row21 = mysqli_fetch_array($q21)) {
                    $total_time = $row21["total_time"];
                    $station_event_idd = $row21["station_event_id"];
                    $q3 = mysqli_query($db, "SELECT sum(good_pieces) as good_pieces,sum(rework) as rework FROM `good_bad_pieces_details` where `station_event_id` = '$station_event_idd'and DATE_FORMAT(created_at,'%m-%d-%Y') = '$chicagotime2'");
                    $r3 = $q3->fetch_assoc();
                    $good_pieces3 = $r3["good_pieces"];
                    if(empty($good_pieces3)){
                        $g1 = 0;
                    }else{
                        $g1 = $good_pieces3;
                    }
                    $rework3 = $r3["rework"];
                    if(empty($rework3)){
                        $r1 = 0;
                    }else{
                        $r1 = $rework3;
                    }
                    $gpr1 = $g1 + $r1;
                    if ($total_time === '0' || $total_time === '0.0' || $gpr1 === 0 || $gpr1 === 0.0) {
                        $a_npr = 0;
                    } else {
                        $a_npr = round($gpr1 / $total_time, 2);
                    }
                }
                $value = $a_npr;
            }
            if ($j == 8) {
                $un = $value;
                $qur077 = mysqli_query($db, "SELECT npr as npr FROM pm_part_number where part_number = '$un'");
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
