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
$exportData = mysqli_query($db,"SELECT sg_station_event.`line_id` as line_id,good_bad_pieces_details.good_pieces as good_pieces,good_bad_pieces_details.bad_pieces,good_bad_pieces_details.rework as rework,sg_station_event_log.event_cat_id,good_bad_pieces_details.created_at as created_at FROM `sg_station_event` INNER JOIN good_bad_pieces_details ON good_bad_pieces_details.`station_event_id` = sg_station_event.`station_event_id` INNER JOIN sg_station_event_log ON sg_station_event_log.`station_event_id` = sg_station_event.`station_event_id` where DATE_FORMAT(`created_at`,'%m-%d-%Y') >= '$chicagotime2' and DATE_FORMAT(`created_at`,'%m-%d-%Y') <= '$chicagotime2'");
$header = "Station" . "\t" . "Good Piece" . "\t" . "Bad Piece" . "\t" . "Rework" . "\t" . "Category" . "\t" . "Efficiency" . "\t";
$result = '';
while ($row = mysqli_fetch_row($exportData)) {
    $line = '';
    $j = 1;
    $h = 1;
    /*$g = $row['good_pieces'];
    $r = $row['rework'];
    $p = $g + $r;
    $line_id = $row['line_id'];*/
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
          /*  if ($j == 6) {
                $un = $value;
                $q2 = mysqli_query($db, "SELECT * FROM `sg_station_event` where `line_id` = '$un'");
                while ($r2 = mysqli_fetch_array($q2)) {
                    $part_number = $r2["part_number_id"];
                    $sqlpnum= "SELECT * FROM `pm_part_number` where `pm_part_number_id` = '$part_number'";
                    $resultpnum = mysqli_query($db,$sqlpnum);
                    $rowcpnum = $resultpnum->fetch_assoc();
                    $pm_npr= $rowcpnum['npr'];
                    if(empty($pm_npr))
                    {
                        $npr = 0;
                    }else{
                        $npr = $pm_npr;
                    }
                    $target_eff = round($npr * $h);
                    $actual_eff = 30;
                    $eff = round(100 * ($actual_eff/$target_eff));
                }
                $value = $eff;
            }*/
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
file_put_contents("../daily_report/" . $chicagotime . "/Daily_Efficiency_Report_Log_" . $chicagotime . ".xls", $header . "\n" . $result . $result1);
?>
