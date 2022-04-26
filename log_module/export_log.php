<?php
ini_set('display_errors', 'off');
include '../config.php';
$name = $_SESSION['usr'];
$station = $_SESSION['station'];
$date = $_SESSION['assign_date'];
$curdate = date('Y-m-d');
$dateto = $_SESSION['date_to'];
$datefrom = $_SESSION['date_from'];
$button = $_SESSION['button'];
$timezone = $_SESSION['timezone'];
$q = "SELECT `user_id`,`station_id`,`position_id`,`assign_time`,`unassign_time`,`total_time`  as t_time FROM `cam_assign_crew_log` WHERE 1 ";

if ($name != "" ) {
	$q = $q . "and `user_id` = '$name' ";
//	$exportData = mysqli_query($db, "SELECT `user_id`,`station_id`,`position_id`,`assign_time`,`unassign_time`,`total_time`  as time FROM `cam_assign_crew_log` WHERE DATE_FORMAT(`assign_time`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`assign_time`,'%Y-%m-%d') <= '$dateto' and `user_id` = '$name' and `station_id` = '$station'");
}
if ($station != "" ) {
	$q = $q . "and `station_id` = '$station'";
//		$exportData = mysqli_query($db, "SELECT `user_id`,`station_id`,`position_id`,`assign_time`,`unassign_time`,`total_time`  as time FROM `cam_assign_crew_log` WHERE DATE_FORMAT(`assign_time`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`assign_time`,'%Y-%m-%d') <= '$dateto' and `user_id` = '$name' and `station_id` = '$station'");
}

if($datefrom != "" && $dateto != ""){
	$q = $q . " AND DATE_FORMAT(assign_time,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(assign_time,'%Y-%m-%d') <= '$dateto' ";
}else if($datefrom != "" && $dateto == ""){
	$q = $q . " AND DATE_FORMAT(assign_time,'%Y-%m-%d') >= '$datefrom' ";
}else if($datefrom == "" && $dateto != ""){
	$q = $q . " AND DATE_FORMAT(assign_time,'%Y-%m-%d') <= '$dateto' ";
}


$q = $q . " Order by t_time DESC";
$exportData = mysqli_query($db, $q);
//$exportData = mysqli_query($db, "SELECT user_name,firstname,lastname,email,role,hiring_date,job_title_description,shift_location FROM users where users_id !='1' ");
$header = "User Name" . "\t" . "Station" . "\t" . "Position" . "\t" . "Assign Time" . "\t" . "Unassign Time" . "\t" . "Total Assign Time" . "\t";
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
                $qur04 = mysqli_query($db, "SELECT * FROM  cam_users where users_id = '$un' ");
                while ($rowc04 = mysqli_fetch_array($qur04)) {
                    $first = $rowc04["firstname"];
                    $last = $rowc04["lastname"];
                }
                $value = $first . " " . $last;
            }
            if ($j == 2) {
                $un = $value;
                $qur04 = mysqli_query($db, "SELECT line_name FROM  cam_line where line_id = '$un' ");
                while ($rowc04 = mysqli_fetch_array($qur04)) {
                    $lnn = $rowc04["line_name"];
                }
                $value = $lnn;
            }
            if ($j == 3) {
                $un = $value;
                $qur04 = mysqli_query($db, "SELECT position_name FROM  cam_position where position_id = '$un' ");
                while ($rowc04 = mysqli_fetch_array($qur04)) {
                    $pnn = $rowc04["position_name"];
                }
                $value = $pnn;
            }
            if ($j == 4) {
                $ass = $value;
            }
            if ($j == 5) {
                $un = $value;
                $timee = $ass;
                if ($un == $timee) {
                    $value = "Still Assigned";
                }
            }
            if ($j == 6) {
                $un = $value;
                $timee = "00:00:00";
                if ($un == $timee) {
                    $value = "Still Assigned";
                }
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
header("Content-Disposition: attachment; filename=Assign Log.xls");
header("Pragma: no-cache");
header("Expires: 0");
print "$header\n$result";
?>