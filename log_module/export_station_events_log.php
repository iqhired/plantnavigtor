<?php
ini_set('display_errors', 'off');
include '../config.php';
$taskboard = $_SESSION['taskboard'];
$user = $_SESSION['user'];
$date = $_SESSION['assign_date'];
$curdate = date('Y-m-d');
$dateto = $_SESSION['date_to'];
$datefrom = $_SESSION['date_from'];
$button = $_SESSION['button'];
$timezone = $_SESSION['timezone'];
$event_type = $_SESSION['event_type'];
$event_category = $_SESSION['event_category'];


							if($event_type != "")
							{
							if ($button == "button1") {
								if ($station != "" && $datefrom != "" && $dateto != "") {
									$exportData = mysqli_query($db, "SELECT line_id,pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,sg_events.created_on as start_time , sg_events.modified_on as end_time ,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(sg_events.modified_on ,sg_events.created_on))) as total_time from sg_station_event as sg_events INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id where event_status = 0 AND DATE_FORMAT(`created_on`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`created_on`,'%Y-%m-%d') <= '$dateto' and `line_id` = '$station' and `event_type_id` = '$event_type' ");
								} else if ($station != "" && $datefrom == "" && $dateto == "") {
									$exportData = mysqli_query($db, "SELECT line_id,pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,sg_events.created_on as start_time , sg_events.modified_on as end_time ,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(sg_events.modified_on ,sg_events.created_on))) as total_time from sg_station_event as sg_events INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id where event_status = 0 AND  `sg_events.line_id` = '$station' and `sg_events.event_type_id` = '$event_type'");
								} 
								else if ($station == "" && $datefrom != "" && $dateto != "") {
                                    $Data = "SELECT sg_events.line_id,pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,sg_events.created_on as start_time , sg_events.modified_on as end_time ,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(sg_events.modified_on ,sg_events.created_on))) as total_time from sg_station_event as sg_events INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id where sg_events.event_status = 0 AND DATE_FORMAT(`created_on`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`created_on`,'%Y-%m-%d') <= '$dateto' and sg_events.event_type_id = '$event_type'";
                                    $exportData = mysqli_query($db,$Data);

                                }
								else {
									$exportData = mysqli_query($db, "SELECT line_id,pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,sg_events.created_on as start_time , sg_events.modified_on as end_time ,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(sg_events.modified_on ,sg_events.created_on))) as total_time from sg_station_event as sg_events INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id ");
								}
								
							} else {
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
								if ($station != "" && $timezone != "") {
									$exportData = mysqli_query($db, "SELECT line_id,pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,sg_events.created_on as start_time , sg_events.modified_on as end_time ,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(sg_events.modified_on ,sg_events.created_on))) as total_time from sg_station_event as sg_events INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id where event_status = 0 AND DATE_FORMAT(`created_on`,'%Y-%m-%d') >= '$countdate' and DATE_FORMAT(`created_on`,'%Y-%m-%d') <= '$curdate' and `line_id` = '$station' and `event_type_id` = '$event_type'");
								} else if ($station != "" && $timezone == "") {
									$exportData = mysqli_query($db, "SELECT line_id,pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,sg_events.created_on as start_time , sg_events.modified_on as end_time ,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(sg_events.modified_on ,sg_events.created_on))) as total_time from sg_station_event as sg_events INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id where event_status = 0 AND  `line_id` = '$station' and `event_type_id` = '$event_type'");
								} else if ($taskboard == ""  && $timezone != "") {
									$exportData = mysqli_query($db, "SELECT line_id,pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,sg_events.created_on as start_time , sg_events.modified_on as end_time ,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(sg_events.modified_on ,sg_events.created_on))) as total_time from sg_station_event as sg_events INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id where event_status = 0 AND DATE_FORMAT(`created_on`,'%Y-%m-%d') >= '$countdate' and DATE_FORMAT(`created_on`,'%Y-%m-%d') <= '$curdate' and `event_type_id` = '$event_type'");
								}
								else {
									$exportData = mysqli_query($db, "SELECT line_id,pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,sg_events.created_on as start_time , sg_events.modified_on as end_time ,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(sg_events.modified_on ,sg_events.created_on))) as total_time from sg_station_event as sg_events INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id ");
								}
							}
							
							}
		//event category					
						
							else if($event_category != "")
							{
							if ($button == "button1") {
								if ($station != "" && $datefrom != "" && $dateto != "") {
									$exportData = mysqli_query($db, "SELECT pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,sg_events.created_on as start_time , sg_events.modified_on as end_time ,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(sg_events.modified_on ,sg_events.created_on))) as total_time from sg_station_event as sg_events INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id where event_status = 0 AND DATE_FORMAT(`created_on`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`created_on`,'%Y-%m-%d') <= '$dateto' and `line_id` = '$station' and `event_category_id` = '$event_category' ");
								} else if ($station != "" && $datefrom == "" && $dateto == "") {
									$exportData = mysqli_query($db, "SELECT line_id,pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,sg_events.created_on as start_time , sg_events.modified_on as end_time ,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(sg_events.modified_on ,sg_events.created_on))) as total_time from sg_station_event as sg_events INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id where event_status = 0 AND  `line_id` = '$station' and `event_category_id` = '$event_category'");
								} 
								else if ($station == "" && $datefrom != "" && $dateto != "") {
									$Data =  "SELECT line_id,pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,sg_events.created_on as start_time , sg_events.modified_on as end_time ,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(sg_events.modified_on ,sg_events.created_on))) as total_time from sg_station_event as sg_events INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id where event_status = 0 AND DATE_FORMAT(`created_on`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(`created_on`,'%Y-%m-%d') <= '$dateto' and `event_category_id` = '$event_category'";
                                    $exportData = mysqli_query($db,$Data);
								}
								else {
									$exportData = mysqli_query($db, "SELECT line_id,pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,sg_events.created_on as start_time , sg_events.modified_on as end_time ,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(sg_events.modified_on ,sg_events.created_on))) as total_time from sg_station_event as sg_events INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id ");
								}
								
							} else {
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
								if ($station != "" && $timezone != "") {
									$exportData = mysqli_query($db, "SELECT line_id,pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,sg_events.created_on as start_time , sg_events.modified_on as end_time ,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(sg_events.modified_on ,sg_events.created_on))) as total_time from sg_station_event as sg_events INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id where event_status = 0 AND DATE_FORMAT(`created_on`,'%Y-%m-%d') >= '$countdate' and DATE_FORMAT(`created_on`,'%Y-%m-%d') <= '$curdate' and `line_id` = '$station' and `event_category_id` = '$event_category'");
								} else if ($station != "" && $timezone == "") {
									$exportData = mysqli_query($db, "SELECT line_id,pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,sg_events.created_on as start_time , sg_events.modified_on as end_time ,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(sg_events.modified_on ,sg_events.created_on))) as total_time from sg_station_event as sg_events INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id where event_status = 0 AND  `line_id` = '$station' and `event_category_id` = '$event_category'");
								} else if ($station == ""  && $timezone != "") {
									$exportData = mysqli_query($db, "SELECT line_id,pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,sg_events.created_on as start_time , sg_events.modified_on as end_time ,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(sg_events.modified_on ,sg_events.created_on))) as total_time from sg_station_event as sg_events INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id where event_status = 0 AND DATE_FORMAT(`created_on`,'%Y-%m-%d') >= '$countdate' and DATE_FORMAT(`created_on`,'%Y-%m-%d') <= '$curdate' and `event_category_id` = '$event_category'");
								}
								else {
									$exportData = mysqli_query($db, "SELECT line_id,pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,sg_events.created_on as start_time , sg_events.modified_on as end_time ,SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(sg_events.modified_on ,sg_events.created_on))) as total_time from sg_station_event as sg_events INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id ");
								}
							}
							
							}
							


//$exportData = mysqli_query($db, "SELECT user_name,firstname,lastname,email,role,hiring_date,job_title_description,shift_location FROM users where users_id !='1' ");
$header = "Line" . "\t" . "Part Number" . "\t" . "Part Name" . "\t" . "Part Family" . "\t" . "Start Time" . "\t" . "End Time" . "\t" . "Total Time" . "\t";
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
    $result .= trim($line) . "\n";
}
$result = str_replace("\r", "", $result);
if ($result == "") {
    $result = "\nNo Record(s) Found!\n";
}
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Station Events Log.xls");
header("Pragma: no-cache");
header("Expires: 0");
print "$header\n$result";
?>