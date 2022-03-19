<?php include("../config.php");
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
	$datefrom = $curdate;
	$dateto = $curdate;
}
$wc = '';

//if(isset($station)){
	$wc = $wc . " and sg_station_event.line_id = '$station'";
//}
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
if($_POST['fa_op'] == 1){
	$sql = "SELECT SUM(good_pieces) AS good_pieces,SUM(bad_pieces)AS bad_pieces,SUM(rework) AS rework FROM `good_bad_pieces`  INNER JOIN sg_station_event ON good_bad_pieces.station_event_id = sg_station_event.station_event_id where 1 " . $wc;
	$response = array();
	$posts = array();
	$result = mysqli_query($db,$sql);
//$result = $mysqli->query($sql);
	$data =array();
	if( null != $result){
		while ($row=$result->fetch_assoc()){
			$posts[] = array('good_pieces'=> $row['good_pieces'], 'bad_pieces'=> $row['bad_pieces'], 'rework'=> $row['rework']);
		}
	}

	$response['posts'] = $posts;
	echo json_encode($response);
}else if($_POST['fa_op'] == 0){
	$sql1 = "SELECT good_bad_pieces_details.defect_name,SUM(good_bad_pieces_details.bad_pieces) AS bad_pieces FROM `good_bad_pieces_details` INNER JOIN sg_station_event ON good_bad_pieces_details.station_event_id = sg_station_event.station_event_id WHERE defect_name IS NOT NULL " . $wc . " group by good_bad_pieces_details.defect_name order by bad_pieces desc";
	$response1 = array();
	$posts1 = array();
	$result1 = mysqli_query($db,$sql1);
//$result = $mysqli->query(
	$data =array();
	if( null != $result1){
		while ($row=$result1->fetch_assoc()){
//	$posts1[] = array( 'bad_pieces'=> $row['bad_pieces'], 'rework'=> $row['rework'],'defect_name'=> $row['defect_name']);
			$posts1[] = array(  $row['defect_name'] , $row['bad_pieces']);
//			array_push($data,$posts1);
		}
	}
	$response1['posts1'] = $posts1;
	echo json_encode($response1);
}

