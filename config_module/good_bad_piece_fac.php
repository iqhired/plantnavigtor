<?php include("../config.php");
$station = $_POST['id'];
$def_ch = $_POST['def_ch'];
$sql1 = "SELECT * FROM `cam_line` WHERE gbd_id = '1' and line_id = '$station'";
$result1 = mysqli_query($db,$sql1);
while ($cam1 = mysqli_fetch_array($result1)){
	$station1 = $cam1['line_id'];
	$station2 = $cam1['line_name'];
}

$sqlmain = "SELECT * FROM `sg_station_event` where `line_id` = '$station1' and event_status = 1";
$resultmain = mysqli_query($db,$sqlmain);
if(!empty($resultmain)){
	$rowcmain = $resultmain->fetch_assoc();
	if(empty($rowcmain)){
		$part_family = $rowcmain['part_family_id'];
		$part_number = $rowcmain['part_number_id'];
		$station_id = $rowcmain['station_event_id'];
	}

	if(!empty($part_family)){
		$sqlfamily = "SELECT * FROM `pm_part_family` where `pm_part_family_id` = '$part_family'";
		$resultfamily = mysqli_query($db,$sqlfamily);
		$rowcfamily = $resultfamily->fetch_assoc();
		$pm_part_family_name = $rowcfamily['part_family_name'];

		$sqlaccount = "SELECT * FROM `part_family_account_relation` where `part_family_id` = '$part_family'";
		$resultaccount = mysqli_query($db,$sqlaccount);
		$rowcaccount = $resultaccount->fetch_assoc();
		$account_id = $rowcaccount['account_id'];

		if(!empty($account_id)){
			$sqlcus = "SELECT * FROM `cus_account` where `c_id` = '$account_id'";
			$resultcus = mysqli_query($db,$sqlcus);
			$rowccus = $resultcus->fetch_assoc();
			$cus_name = $rowccus['c_name'];
			$logo = $rowccus['logo'];
		}
	}

}
if(!empty($def_ch) && $def_ch == 1){
	$sql1 = "SELECT good_bad_pieces_details.defect_name,SUM(good_bad_pieces_details.bad_pieces) AS bad_pieces FROM `good_bad_pieces_details` INNER JOIN sg_station_event ON good_bad_pieces_details.station_event_id = sg_station_event.station_event_id  and sg_station_event.line_id = '$station1' and sg_station_event.event_status = 1 WHERE defect_name IS NOT NULL group by good_bad_pieces_details.defect_name order by bad_pieces desc";
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
}else{
	$sql = "SELECT SUM(good_pieces) AS good_pieces,SUM(bad_pieces)AS bad_pieces,SUM(rework) AS rework FROM `good_bad_pieces`  INNER JOIN sg_station_event ON good_bad_pieces.station_event_id = sg_station_event.station_event_id where sg_station_event.line_id = '$station1' and sg_station_event.event_status = 1" ;
	$response = array();
	$posts = array();
	$result = mysqli_query($db,$sql);
//$result = $mysqli->query($sql);
	$data =array();

	while ($row=$result->fetch_assoc()){
		$posts[] = array('good_pieces'=> $row['good_pieces'], 'bad_pieces'=> $row['bad_pieces'], 'rework'=> $row['rework']);

	}
	$response['posts'] = $posts;
	echo json_encode($response);
}


