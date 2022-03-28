<?php
ini_set('display_errors', 'off');
include '../config.php';

$user_id = $_SESSION["id"];
$chicagotime = date("Y-m-d H:i:s");
//$line = "<b>-</b>";
$curdate = date('Y-m-d');
$line = "";
$station_event_id = $_SESSION['station'];
$sqlmain = "SELECT * FROM `sg_station_event` where `station_event_id` = '$station_event_id'";
$resultmain = $mysqli->query($sqlmain);
$rowcmain = $resultmain->fetch_assoc();
$part_family = $rowcmain['part_family_id'];
$part_number = $rowcmain['part_number_id'];

$sqlnumber = "SELECT * FROM `pm_part_number` where `pm_part_number_id` = '$part_number'";
$resultnumber = $mysqli->query($sqlnumber);
$rowcnumber = $resultnumber->fetch_assoc();
$pm_part_number = $rowcnumber['part_number'];
$pm_part_name = $rowcnumber['part_name'];

$sqlfamily = "SELECT * FROM `pm_part_family` where `pm_part_family_id` = '$part_family'";
$resultfamily = $mysqli->query($sqlfamily);
$rowcfamily = $resultfamily->fetch_assoc();
$pm_part_family_name = $rowcfamily['part_family_name'];

$sqlaccount = "SELECT * FROM `part_family_account_relation` where `part_family_id` = '$part_family'";
$resultaccount = $mysqli->query($sqlaccount);
$rowcaccount = $resultaccount->fetch_assoc();
$account_id = $rowcaccount['account_id'];

$sqlcus = "SELECT * FROM `cus_account` where `c_id` = '$account_id'";
$resultcus = $mysqli->query($sqlcus);
$rowccus = $resultcus->fetch_assoc();
$cus_name = $rowccus['c_name'];
$logo = $rowccus['logo'];
$dateto = $_SESSION['date_to'];
$datefrom = $_SESSION['date_from'];
$button = $_SESSION['button'];
if ($button == "button1") {
    if ($station_event_id != "" && $user_id != "" && $datefrom != "" && $dateto != "") {
        $exportData = mysqli_query($db, "SELECT `bad_pieces_id`,`good_pieces`,`bad_pieces`,`rework`,`defect_name`,`created_at` FROM `good_bad_pieces_details` WHERE DATE_FORMAT(`assigned_time`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`assigned_time`,'%Y-%m-%d') <= '$dateto' and `station_event_id` = '$station_event_id'");
    }  else if ($station_event_id != "" && $user_id != "" && $datefrom == "" && $dateto == "") {
        $exportDatbutton1 = mysqli_query($db, "SELECT  `bad_pieces_id`,`good_pieces`,`bad_pieces`,`rework`,`defect_name`,`created_at` FROM `good_bad_pieces_details` WHERE  `station_event_id` = '$station_event_id'");
    } else if ($station_event_id != "" && $user_id == "" && $datefrom != "" && $dateto != "") {
        $exportData = mysqli_query($db, "SELECT `bad_pieces_id`,`good_pieces`,`bad_pieces`,`rework`,`defect_name`,`created_at` FROM `good_bad_pieces_details` WHERE DATE_FORMAT(`assigned_time`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`assigned_time`,'%Y-%m-%d') <= '$dateto' and `station_event_id` = '$station_event_id' ");
    } else if ($station_event_id != "" && $user_id == "" && $datefrom == "" && $dateto == "") {
        $exportData = mysqli_query($db, "SELECT `bad_pieces_id`,`good_pieces`,`bad_pieces`,`rework`,`defect_name`,`created_at` FROM `good_bad_pieces_details` WHERE `station_event_id` = '$station_event_id'");
    } else if ($station_event_id == "" && $user_id != "" && $datefrom != "" && $dateto != "") {
        $exportData = mysqli_query($db, "SELECT `bad_pieces_id`,`good_pieces`,`bad_pieces`,`rework`,`defect_name`,`created_at` FROM `good_bad_pieces_details` WHERE DATE_FORMAT(`assigned_time`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`assigned_time`,'%Y-%m-%d') <= '$dateto' and `station_event_id` = '$station_event_id'");
    } else if ($station_event_id == "" && $user_id != "" && $datefrom == "" && $dateto == "") {
        $exportData = mysqli_query($db, "SELECT `bad_pieces_id`,`good_pieces`,`bad_pieces`,`rework`,`defect_name`,`created_at` FROM `good_bad_pieces_details`");
    } else if ($station_event_id == "" && $user_id == "" && $datefrom != "" && $dateto != "") {
        $exportData = mysqli_query($db, "SELECT `bad_pieces_id`,`good_pieces`,`bad_pieces`,`rework`,`defect_name`,`created_at` FROM `good_bad_pieces_details` WHERE DATE_FORMAT(`assigned_time`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`assigned_time`,'%Y-%m-%d') <= '$dateto' ");
    }else {
        $exportData = mysqli_query($db, "SELECT `bad_pieces_id`,`good_pieces`,`bad_pieces`,`rework`,`defect_name`,`created_at` FROM `good_bad_pieces_details`");
    }

    }else {
    $curdate = date('Y-m-d');
    if ($timezone == "7") {
        $countdate = date('Y-m-d', strtotime('-7 days'));
    } else if ($timezone == "1") {
        $countdate = date('Y-m-d', strtotime('-1 days'));
    } else if ($timezone == "30") {
        $countdate = date('Y-m-d', strtotime('-30 days'));
    } else if ($timezone == "90") {
        $countdate = date('Y-m-d', strtotime('-90 days'));
    } else if ($timezone == "180") {
        $countdate = date('Y-m-d', strtotime('-180 days'));
    } else if ($timezone == "365") {
        $countdate = date('Y-m-d', strtotime('-365 days'));
    }
    if ($station_event_id != "" && $user_id != "" && $timezone != "") {
        $Data = mysqli_query($db, "SELECT `bad_pieces_id`,`good_pieces`,`bad_pieces`,`rework`,`defect_name`,`created_at` FROM `good_bad_pieces_details` WHERE  `station_event_id` = '$station_event_id'");
    } else if ($station_event_id != "" && $user_id != "" && $timezone == "") {
        $exportData = mysqli_query($db, "SELECT `bad_pieces_id`,`good_pieces`,`bad_pieces`,`rework`,`defect_name`,`created_at` FROM `good_bad_pieces_details` WHERE  `station_event_id` = '$station_event_id'");
    } else if ($station_event_id == "" && $user_id != "" && $timezone != "") {
        $exportData = mysqli_query($db, "SELECT `bad_pieces_id`,`good_pieces`,`bad_pieces`,`rework`,`defect_name`,`created_at` FROM `good_bad_pieces_details`");
    } else if ($station_event_id == "" && $user_id != "" && $timezone == "") {
        $exportData = mysqli_query($db, "SELECT `bad_pieces_id`,`good_pieces`,`bad_pieces`,`rework`,`defect_name`,`created_at` FROM `good_bad_pieces_details` WHERE  `assign_to` = '$station_event_id'");
    } else if ($station_event_id != "" && $user_id == "" && $timezone != "") {
        $exportData = mysqli_query($db, "SELECT `bad_pieces_id`,`good_pieces`,`bad_pieces`,`rework`,`defect_name`,`created_at` FROM `good_bad_pieces_details` WHERE `station_event_id` = '$station_event_id' ");
    } else if ($station_event_id != "" && $user_id == "" && $timezone == "") {
        $exportData = mysqli_query($db, "SELECT `bad_pieces_id`,`good_pieces`,`bad_pieces`,`rework`,`defect_name`,`created_at` FROM `good_bad_pieces_details` WHERE `station_event_id` = '$station_event_id' ");
    } else if ($station_event_id == "" &&$user_id == "" && $timezone != "") {
        $exportData = mysqli_query($db, "SELECT `bad_pieces_id`,`good_pieces`,`bad_pieces`,`rework`,`defect_name`,`created_at` FROM `good_bad_pieces_details` WHERE DATE_FORMAT(`assigned_time`,'%Y-%m-%d') >= '$countdate'");
    } else {
        $exportData = mysqli_query($db, "SELECT `bad_pieces_id`,`good_pieces`,`bad_pieces`,`rework`,`defect_name`,`created_at` FROM `good_bad_pieces_details`");
    }
}
$header = "Sr. No" . "\t" . "Good Piece" . "\t" . "Bad Pieces" . "\t" . "Rework" . "\t" . "Defect Name" . "\t" . "Time" ;
$result = '';
$fields = mysqli_num_fields($db, $exportData);
for ($i = 0; $i < $fields; $i++) {
    $header .= mysqli_field_name($db, $exportData, $i) . "\t";
}
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
                $qur04 = mysqli_query($db, "SELECT taskboard_name FROM  sg_taskboard where sg_taskboard_id = '$un' ");
                while ($rowc04 = mysqli_fetch_array($qur04)) {
                    $lnn = $rowc04["taskboard_name"];
                }
                $value = $lnn;

            }
            if ($j == 2) {
                $un = $value;
                $qur04 = mysqli_query($db, "SELECT firstname,lastname FROM  cam_users where users_id = '$un' ");
                while ($rowc04 = mysqli_fetch_array($qur04)) {
                    $first = $rowc04["firstname"];
                    $last = $rowc04["lastname"];
                }
                $value = $first . " " . $last;
            }
            if ($j == 3) {
                $un = $value;
                $qur04 = mysqli_query($db, "SELECT tm_equipment_name FROM  tm_equipment where tm_equipment_id = '$un' ");
                while ($rowc04 = mysqli_fetch_array($qur04)) {
                    $pnn = $rowc04["tm_equipment_name"];
                }
                $value = $pnn;
            }
            if ($j == 4) {
                $un = $value;
                $qur04 = mysqli_query($db, "SELECT tm_property_name FROM  tm_property where tm_property_id = '$un' ");
                while ($rowc04 = mysqli_fetch_array($qur04)) {
                    $pnn = $rowc04["tm_property_name"];
                }
                $value = $pnn;
            }
            if ($j == 5) {
                $un = $value;
                $qur04 = mysqli_query($db, "SELECT tm_building_name FROM  tm_building where tm_building_id = '$un' ");
                while ($rowc04 = mysqli_fetch_array($qur04)) {
                    $pnn = $rowc04["tm_building_name"];
                }
                $value = $pnn;
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
header("Content-Disposition: attachment; filename=Good Bad Piece Log.xls");
header("Pragma: no-cache");
header("Expires: 0");
print "$header\n$result";
        ?>