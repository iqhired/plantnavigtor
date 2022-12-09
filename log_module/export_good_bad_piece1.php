<?php include("../config.php");
$curdate = date('Y-m-d');
//$dateto = $curdate;
//$datefrom = $curdate;
$button = "";
$temp = "";
if (!isset($_SESSION['user'])) {
    header('location: logout.php');
}


//Set the session duration for 10800 seconds - 3 hours
$duration = $auto_logout_duration;
//Read the request time of the user
$time = $_SERVER['REQUEST_TIME'];
//Check the user's session exist or not
if (isset($_SESSION['LAST_ACTIVITY']) && ($time - $_SESSION['LAST_ACTIVITY']) > $duration) {
    //Unset the session variables
    session_unset();
    //Destroy the session
    session_destroy();
    header($redirect_logout_path);
//	header('location: ../logout.php');
    exit;
}
//Set the time of the user's last activity
$_SESSION['LAST_ACTIVITY'] = $time;
$button_event = "button3";
$curdate = date('Y-m-d');
$dateto = $curdate;
$datefrom = $curdate;
$button = "button3";
$temp = "";
// if (!isset($_SESSION['user'])) {
// 	header('location: logout.php');
// }
$station = $_SESSION['station'];
$datefrom = $_SESSION['date_from'];
$dateto = $_SESSION['date_to'];
$pf = $_SESSION['pf'];
$pn = $_SESSION['pn'];
$wc = '';
$print_data='';

if($station == 'all'){
    $print_data .= "Station :  All Station \n";
    $wc = $wc . " ";

}else {

    if (!empty($station)) {
        $qurtemp = mysqli_query($db, "SELECT line_name FROM  cam_line where line_id = '$station' ");
        while ($rowctemp = mysqli_fetch_array($qurtemp)) {
            $line_name = $rowctemp["line_name"];
            $date_f = date('F j, Y',strtotime($datefrom));
            $date_t = date('F j, Y',strtotime($dateto));
            $print_data .= $date_f . '-' . $date_t . "\n";
        }

        $wc = $wc . " and sg_station_event.line_id = '$station'";
    }

    if (!empty($pn)) {
        $qurtemp = mysqli_query($db, "SELECT part_number , part_name FROM `pm_part_number` where pm_part_number_id = '$pn' ");
        while ($rowctemp = mysqli_fetch_array($qurtemp)) {
            $part_number = $rowctemp["part_number"];
            $part_name = $rowctemp["part_name"];
            $print_data .= "Part Number  : " . $part_number . "\n";
            $print_data .= "Part Description / Name  : " . $part_name . "\n";
        }
        $wc = $wc . " and sg_station_event.part_number_id = '$pn'";
    }
    if (!empty($pf)) {
        $qurtemp = mysqli_query($db, "SELECT part_family_name FROM `pm_part_family` where pm_part_family_id = '$pf' ");
        while ($rowctemp = mysqli_fetch_array($qurtemp)) {
            $part_family_name = $rowctemp["part_family_name"];
            $print_data .= "Part Family  : " . $part_family_name . "\n";
        }
        $wc = $wc . " and sg_station_event.part_family_id = '$pf'";
    }
}
/* If Data Range is selected */
if ($button == "button3") {
    if (!empty($datefrom)) {
        $print_data .= "From Date : " . $datefrom . "\n";
        $wc = $wc . " and DATE_FORMAT(`created_at`,'%Y-%m-%d') >= '$datefrom' ";
    }
    if (!empty($dateto)) {
        $print_data .= "To Date : " . $dateto . "\n\n\n";
        $wc = $wc . " and DATE_FORMAT(`created_at`,'%Y-%m-%d') <= '$dateto' ";
    }
} else if ($button == "button2") {
    /* If Date Period is Selected */
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
    if (!empty($countdate)) {
        $wc = $wc . " AND DATE_FORMAT(`created_at`,'%Y-%m-%d') >= '$countdate' and DATE_FORMAT(created_at,'%Y-%m-%d') <= '$curdate' ";
    }
} else {
    $wc = $wc . " and DATE_FORMAT(`created_at`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`created_at`,'%Y-%m-%d') <= '$dateto' ";
}



$sql = "SELECT ( select cam_line.line_name from cam_line where cam_line.line_id = sg_station_event.line_id) as Station ,good_bad_pieces_details.good_pieces AS good_pieces  , ( select pm_part_family.part_family_name from pm_part_family where pm_part_family.pm_part_family_id = sg_station_event.part_family_id) as p_fam_name ,( select pm_part_number.part_number from pm_part_number where pm_part_number.pm_part_number_id = sg_station_event.part_number_id) as pm_p_num , ( select pm_part_number.part_name from pm_part_number where pm_part_number.pm_part_number_id = sg_station_event.part_number_id) as pm_part_name , good_bad_pieces_details.created_by , good_bad_pieces_details.created_at  FROM `good_bad_pieces_details`  INNER JOIN sg_station_event ON good_bad_pieces_details.station_event_id = sg_station_event.station_event_id where 1 and good_pieces > 0 " . $wc ."ORDER BY sg_station_event.line_id,good_bad_pieces_details.created_at";
$gp_result = mysqli_query($db,$sql);


$header1 = "Sr. No" . "\t" . "Station" . "\t" . "Good Pieces" . "\t" .  "Part Family" ."\t" . "Part Number" ."\t" . "Part Name" ."\t". "Personnel" . "\t" . "Time";
$result1 = '';
$i=1;

$fields = mysqli_num_fields($db, $gp_result);
for ($i = 0; $i < $fields; $i++) {
    $header1 .= mysqli_field_name($db, $gp_result, $i) . "\t";
}
$k =1;

while ($row1 = mysqli_fetch_row($gp_result)) {

    $date_n = $row1[6];
    $date_ne = explode(' ', $date_n);
    $date_next = $date_ne[0];

    $line = '';
    $j = 1;

    if (($datefrom == $date_next) && ($k == 1)) {
        $date_data = "\nDate : " . $date_next . "\n";
        $line .= "$date_data\n$header1\n";
        $k = 0;
    } else if ($datefrom < $date_next) {
        $line .= ".\n";
        $date_data = "Date : " . $date_next . "\n";
        $line .= "$date_data\n$header1\n";
        $datefrom = $date_next;
    }
    $skipped = array('0', '2', '6', '7');
    foreach ($row1 as $key => $value) {
        if (in_array($key, $skipped)) {
            continue;
        }

        foreach ($row1 as $value) {
            if ((empty($value)) || ($value == "")) {
                $value = "-" . "\t";
            } else {
                $value = str_replace('"', '""', $value);
                $value = '"' . $value . '"' . "\t";
            }
            $line .= $value;
            $j++;
        }
        $result1 .= $i . "\t" . trim($line) . "\n";
        $i++;
    }
}
$result1 = str_replace("\r", "", $result1);
if ($result1 == "") {
    $result1 = "\nNo Record(s) Found!\n";
}

$sql1 = "SELECT (select cam_line.line_name from cam_line where cam_line.line_id = sg_station_event.line_id) as station ,(good_bad_pieces_details.bad_pieces)   , (good_bad_pieces_details.rework) AS Rework , good_bad_pieces_details.defect_name  , ( select pm_part_family.part_family_name from pm_part_family where pm_part_family.pm_part_family_id = sg_station_event.part_family_id) as p_fam_name ,( select pm_part_number.part_number from pm_part_number where pm_part_number.pm_part_number_id = sg_station_event.part_number_id) as pm_p_num , ( select pm_part_number.part_name from pm_part_number where pm_part_number.pm_part_number_id = sg_station_event.part_number_id) as pm_part_name , good_bad_pieces_details.created_by as Personnel , good_bad_pieces_details.created_at Created_At FROM `good_bad_pieces_details` INNER JOIN sg_station_event ON good_bad_pieces_details.station_event_id = sg_station_event.station_event_id WHERE defect_name IS NOT NULL " . $wc . " ORDER BY sg_station_event.line_id,good_bad_pieces_details.created_at;";
$exportData = mysqli_query($db, $sql1);

$header = "Sr. No" . "\t" . "Station" . "\t" ."Bad Pieces" . "\t" . "Rework" . "\t" . "Defect Name" . "\t" . "Part Family" ."\t" . "Part Number" ."\t" . "Part Name" ."\t" . "Personnel" . "\t" . "Time";
$result = '';
$i=1;
while ($row = mysqli_fetch_row($exportData)) {
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
    $result .= $i."\t".trim($line) . "\n";
    $i++;
}
$result = str_replace("\r", "", $result);
if ($result == "") {
    $result = "\nNo Record(s) Found!\n";
}
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Good Bad Piece Log.xls");
header("Pragma: no-cache");
header("Expires: 0");
print "\n$print_data\n";
print "$header1\n$result1";
print "$header\n$result";
?>