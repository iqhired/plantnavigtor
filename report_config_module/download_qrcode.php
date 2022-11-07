<?php include '../config.php';
$user = $_SESSION['user'];
$print_data='';

$q = "SELECT cl.line_name as station, ( select event_type_name from event_type where event_type_id = e_log.event_type_id) as e_type,
pn.part_number as p_num, pn.part_name as p_name , pf.part_family_name as pf_name,
cast(e_log.created_on AS date),cast(e_log.created_on AS Time), 
cast(e_log.end_time AS Time),e_log.total_time as total_time from sg_station_event_log_update as e_log 
inner join sg_station_event as sg_events on e_log.station_event_id = sg_events.station_event_id 
INNER JOIN pm_part_family as pf on sg_events.part_family_id = pf.pm_part_family_id 
inner join pm_part_number as pn on sg_events.part_number_id = pn.pm_part_number_id 
inner join cam_line as cl on e_log.line_id = cl.line_id where 1  ";

$exportData = mysqli_query($db, $q);
$header = "Station" . "\t" ."Event Type" . "\t" . "Part Number" . "\t" . "Part Name" . "\t" . "Part Family" .  "\t"  . "Date" .  "\t". "Start Time" . "\t" ."End Time" . "\t" ."Total Time" . "\t" ;
$result = '';

while ($row = mysqli_fetch_row($exportData)) {
    $line = '';
    $j = 1;
    foreach ($row as $value) {

        if ((!isset($value)) || ($value == "")) {
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
header("Content-Disposition: attachment; filename=Station Events Log.xls");
header("Pragma: no-cache");
header("Expires: 0");
print "\n\n$print_data\n\n";
print "$header\n$result";
?>