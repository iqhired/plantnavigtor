<?php
ini_set('display_errors', 'off');
include '../config.php';
$taskboard = $_SESSION['taskboard'];
$user = $_SESSION['user'];
$date = $_SESSION['assign_date'];
$curdate = date('Y-m-d');
$dateto = $_SESSION['date_to'];
$datefrom = $_SESSION['date_from'];
$button = $_SESSION['button_event'];
$timezone = $_SESSION['timezone'];
$event_type = $_SESSION['event_type'];
$event_category = $_SESSION['event_category'];
$line_id = $_SESSION['station'];
$print_data='';

	$q = "SELECT sg_events.line_id,et.event_type_name as e_type, ( select events_cat_name from events_category where events_cat_id = et.event_cat_id) as cat_name ,
pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,e_log.created_on as start_time , 
e_log.end_time as end_time ,e_log.total_time as total_time  
from sg_station_event_log_update as e_log left join sg_station_event as sg_events on e_log.station_event_id = sg_events.station_event_id
INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id 
inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id 
inner join event_type as et on e_log.event_type_id = et.event_type_id 
where 1 ";

/* If Line is selected. */
if ($line_id != null) {
	$q = $q . " and sg_events.line_id = '$line_id' ";
	$qurtemp = mysqli_query($db, "SELECT line_name FROM  cam_line where line_id = '$line_id' ");
	while ($rowctemp = mysqli_fetch_array($qurtemp)) {
		$line_name = $rowctemp["line_name"];
		$print_data .= "Station : " . $line_name . "\n";
	}
}

	if ($event_type != "") {
		$q = $q . " and e_log.event_type_id = '$event_type'";
		$qurtemp = mysqli_query($db, "SELECT event_type_name FROM  event_type where event_type_id = '$event_type' ");
		while ($rowctemp = mysqli_fetch_array($qurtemp)) {
			$event_type_name = $rowctemp["event_type_name"];
			$print_data .= "Event Type : " . $event_type_name . "\n";
		}
	}

	if ($event_category != "") {
		$q = $q . " AND  e_log.event_cat_id ='$event_category'";
		$qurtemp = mysqli_query($db, "SELECT events_cat_name FROM  events_category where events_cat_id = '$event_category' ");
		while ($rowctemp = mysqli_fetch_array($qurtemp)) {
			$events_cat_name = $rowctemp["events_cat_name"];
			$print_data .= "Event Category : " . $events_cat_name . "\n";
		}
	}
	if($datefrom != "" && $dateto != ""){
		$print_data .= "From Date : " . $datefrom . "\n";
		$print_data .= "To Date : " . $dateto . "\n\n\n";
		$q = $q . " AND DATE_FORMAT(e_log.created_on,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(e_log.created_on,'%Y-%m-%d') <= '$dateto' ";
	}else if($datefrom != "" && $dateto == ""){
		$print_data .= "From Date : " . $datefrom . "\n\n\n";
		$q = $q . " AND DATE_FORMAT(e_log.created_on,'%Y-%m-%d') >= '$datefrom' ";
	}else if($datefrom == "" && $dateto != ""){
		$print_data .= "To Date : " . $dateto . "\n\n\n";
		$q = $q . " AND DATE_FORMAT(e_log.created_on,'%Y-%m-%d') <= '$dateto' ";
	}




$q = $q . " ORDER BY e_log.sg_station_event_update_id  DESC";

$exportData = mysqli_query($db, $q);
$header = "Sr. No" . "\t" . "Line" . "\t" . "Event Type" . "\t" . "Event Category" . "\t" . "Part Number" . "\t" . "Part Name" . "\t" . "Part Family" .  "\t" . "Start Time" .  "\t" . "End Time" . "\t".  "Total Time" . "\t";
$result = '';
$fields = mysqli_num_fields($db, $exportData);
for ($i = 0; $i < $fields; $i++) {
	$header .= mysqli_field_name($db, $exportData, $i) . "\t";
}
$i=1;
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
	//$result .= trim($line) . "\n";
	$result .= $i."\t".trim($line) . "\n";
	$i++;
}
$result = str_replace("\r", "", $result);
if ($result == "") {
	$result = "\nNo Record(s) Found!\n";
}
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Station Events Log.xls");
header("Pragma: no-cache");
header("Expires: 0");
print "\n\n$print_data\n\n\n$header\n$result";

?>