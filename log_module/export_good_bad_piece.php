<?php  include("../config.php");
$button_event = "button3";
$curdate = date('Y-m-d');
$dateto = $curdate;
$datefrom = $curdate;
$button = "";
$temp = "";
// if (!isset($_SESSION['user'])) {
// 	header('location: logout.php');
// }
$_SESSION['station'] = "";
$_SESSION['date_from'] = "";
$_SESSION['date_to'] = "";
$_SESSION['button'] = "";
$_SESSION['timezone'] = "";
$_SESSION['button_event'] = "";
$_SESSION['event_type'] = "";
$_SESSION['event_category'] = "";

if (count($_POST) > 0) {
	$_SESSION['station'] = $_POST['station'];
	$_SESSION['date_from'] = $_POST['date_from'];
	$_SESSION['date_to'] = $_POST['date_to'];
	$_SESSION['button'] = $_POST['button'];
	$_SESSION['timezone'] = $_POST['timezone'];
	$_SESSION['button_event'] = $_POST['button_event'];
	$_SESSION['event_type'] = $_POST['event_type'];
	$_SESSION['event_category'] = $_POST['event_category'];
	$button_event = $_POST['button_event'];
	$event_type = $_POST['event_type'];
	$event_category = $_POST['event_category'];
	$station = $_POST['station'];
	$dateto = $_POST['date_to'];
	$datefrom = $_POST['date_from'];
	$button = $_POST['button'];
	$timezone = $_POST['timezone'];
}
if (count($_POST) > 0) {
	$station1 = $_POST['station'];
	$sta = $_POST['station'];
	$pf = $_POST['part_family'];
	$pn = $_POST['part_number'];
	$qurtemp = mysqli_query($db, "SELECT * FROM  cam_line where line_id = '$station1' ");
	while ($rowctemp = mysqli_fetch_array($qurtemp)) {
		$station1 = $rowctemp["line_name"];
	}
}else{
	$curdate = date('Y-m-d');
	$dateto = $curdate;
	$yesdate = date('Y-m-d',strtotime("-1 days"));
	$datefrom = $yesdate;
//	$datefrom = $curdate;
//	$dateto = $curdate;
}
$wc = '';

if(isset($station)){
	$wc = $wc . " and sg_station_event.line_id = '$station'";
}
if(isset($pf)){
	$wc = $wc . " and sg_station_event.part_family_id = '$pf'";
}
if(isset($pn)){
	$wc = $wc . " and sg_station_event.part_number_id = '$pn'";
}

/* If Data Range is selected */
if ($button == "button1") {
	if(isset($datefrom)){
		$wc = $wc . " and DATE_FORMAT(`created_at`,'%Y-%m-%d') >= '$datefrom' ";
	}
	if(isset($dateto)){
		$wc = $wc . " and DATE_FORMAT(`created_at`,'%Y-%m-%d') <= '$dateto' ";
	}
} else if ($button == "button2"){
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
	if(isset($countdate)){
		$wc = $wc . " AND DATE_FORMAT(`created_at`,'%Y-%m-%d') >= '$countdate' and DATE_FORMAT(created_at,'%Y-%m-%d') <= '$curdate' ";
	}
} else{
	$wc = $wc . " and DATE_FORMAT(`created_at`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`created_at`,'%Y-%m-%d') <= '$dateto' ";
}

$sql1 = "SELECT (good_bad_pieces_details.bad_pieces) AS bad_pieces  , (good_bad_pieces_details.rework) AS rework , good_bad_pieces_details.defect_name , good_bad_pieces_details.created_by as Personnel , good_bad_pieces_details.created_at Created_At FROM `good_bad_pieces_details` INNER JOIN sg_station_event ON good_bad_pieces_details.station_event_id = sg_station_event.station_event_id WHERE defect_name IS NOT NULL " . $wc . " Order By created_at DESC";
$exportData = mysqli_query($db,$sql1);

$header = "Sr. No" ."\t" . "Bad Pieces" . "\t" . "Rework" . "\t" . "Defect Name" ."\t" . "Personnel" . "\t" . "Time" ;
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