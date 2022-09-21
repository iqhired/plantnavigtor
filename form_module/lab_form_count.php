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
//$_SESSION['station'] = "";
$_SESSION['date_from'] = "";
$_SESSION['date_to'] = "";
$_SESSION['button'] = "";
$_SESSION['timezone'] = "";
$_SESSION['button_event'] = "";
$_SESSION['event_type'] = "";
$_SESSION['event_category'] = "";

if (count($_POST) > 0) {
	//$_SESSION['station'] = $_POST['station'];
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
	//$station = $_POST['station'];
	$dateto = $_POST['date_to'];
	$datefrom = $_POST['date_from'];
	$button = $_POST['button'];
	$timezone = $_POST['timezone'];
}
if (count($_POST) > 0) {
    $cus_id = $_POST['cus_id'];
	$pf = $_POST['part_family'];
}else{
	$datefrom = $curdate;
	$dateto = $curdate;
}

$wc = '';
if(isset($pf)){
    $_SESSION['pf'] = $pf;
    $wc = $wc . " and form_user_data.part_family = '$pf'";
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

	$sql = "SELECT count(`form_type`) as cc,part_family FROM `form_user_data` where part_family = '$pf' and form_type = 4". $wc;
	$response = array();
	$posts = array();
	$result = mysqli_query($db,$sql);
//$result = $mysqli->query($sql);
	$data =array();
		while ($row=$result->fetch_assoc()){
            $cc = $row['cc'];
			$posts[] = array('d_count'=> $row['cc']);
		}
	$response['posts'] = $posts;
	echo json_encode($response);

      /*  $q1 = "SELECT * FROM `sg_station_event` WHERE `part_family_id` = '$pf'". $wc;
        $r1 = mysqli_query($db,$q1);
        $row1 = $r1->fetch_assoc();
        $station_event_id = $row1["station_event_id"];
        $q2 = "SELECT * FROM `sg_station_event` WHERE `station_event_id` = '$station_event_id'". $wc;
        $r2 = mysqli_query($db,$q2);
        $row2 = $r2->fetch_assoc();
        $event_cat_id = $row2["event_cat_id"];
        $created_on = $row2["created_on"];*/
