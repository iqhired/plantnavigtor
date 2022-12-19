<?php include("../config.php");
$chicagotime = date("Y-m-d H:i:s");
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
	if(isset($station1) && $station1 != 'all'){
		$qurtemp = mysqli_query($db, "SELECT * FROM  cam_line where line_id = '$station1' ");
		while ($rowctemp = mysqli_fetch_array($qurtemp)) {
			$station1 = $rowctemp["line_name"];
		}
	}
}else{
	$datefrom = $curdate;
	$dateto = $curdate;
}
$wc = '';

if(isset($station) && $station != 'all'){
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
}else if($_POST['fa_op'] == 2) {
    if(!empty($pn)) {
        $sqlpnum = "SELECT * FROM `pm_part_number` where pm_part_number_id = '$pn'";
        $resultpnum = mysqli_query($db, $sqlpnum);
        $rowcpnum = $resultpnum->fetch_assoc();
        $pm_bsr = $rowcpnum['budget_scrape_rate'];
        $pm_avg_bsr = $pm_bsr - 2;
        $sqlvv = "SELECT SUM(good_pieces) AS good_pieces,SUM(bad_pieces)AS bad_pieces,SUM(rework) AS rework FROM `good_bad_pieces`  INNER JOIN sg_station_event ON good_bad_pieces.station_event_id = sg_station_event.station_event_id where 1 " . $wc;
        $response = array();
        $posts = array();
        $resultvv = mysqli_query($db, $sqlvv);
        $data = array();
        if (null != $resultvv) {
            $total = 0;
            while ($row = $resultvv->fetch_assoc()) {
                $total = $row['good_pieces'] + $row['bad_pieces'] + $row['rework'];
                $actual_bsr = round(100 * ($row['bad_pieces'] / $total), 2);
                $posts[] = array('bsr' => $pm_bsr, 'avg_bsr' => $pm_avg_bsr, 'actual_bsr' => $actual_bsr,);
            }
        }
        $response['posts'] = $posts;
        echo json_encode($response);
    }

}else if($_POST['fa_op'] == 3) {
    if(!empty($pn)){
    $sqlpnum1 = "SELECT * FROM `pm_part_number` where `pm_part_number_id` = '$pn'";
    $resultpnum1 = mysqli_query($db, $sqlpnum1);
    $rowcpnum1 = $resultpnum1->fetch_assoc();
    $pm_npr= $rowcpnum1['npr'];
    if(empty($pm_npr))
    {
        $npr = 0;
    }else{
        $npr = $pm_npr;
    }
    $sql11 = "SELECT SUM(good_pieces) AS good_pieces,SUM(bad_pieces)AS bad_pieces,SUM(rework) AS rework FROM `good_bad_pieces`  INNER JOIN sg_station_event ON good_bad_pieces.station_event_id = sg_station_event.station_event_id where 1 " . $wc;
    $response = array();
    $posts = array();
    $result11 = mysqli_query($db, $sql11);
    $row2=$result11->fetch_assoc();
    $total_gp =  $row2['good_pieces'] + $row2['rework'];
    $data = array();
    $sql3 = "SELECT * FROM `sg_station_event_log` where 1 and station_event_id = '$station_event_id' and event_cat_id in (SELECT events_cat_id FROM `events_category` where npr = 1)" ;
    $result3 = mysqli_query($db,$sql3);
    $ttot = null;
    $tt = null;
    if (null != $result3) {
        $total_time = 0;
        while ($row3 = $result3->fetch_assoc()) {
            $ct = $row3['created_on'];
            $tot = $row3['total_time'];
            if(!empty($row3['total_time'])){
                $ttot = explode(':' , $row3['total_time']);
                $i = 0;
                foreach($ttot as $t_time) {
                    if($i == 0){
                        $total_time += ( $t_time * 60 * 60 );
                    }else if( $i == 1){
                        $total_time += ( $t_time * 60 );
                    }else{
                        $total_time += $t_time;
                    }
                    $i++;
                }
            }else{
                $total_time +=  strtotime($chicagotime) - strtotime($ct);
            }
        }
        $total_time = (($total_time/60)/60);

        $target_npr = $pm_npr;
        $actual_npr = round($total_gp/$total_time , 2);
        // $pm_avg_npr = (($target_npr + 2) > 0)? ($target_npr + 2) : $target_npr;
        $posts[] = array( 'npr'=> $target_npr,  'actual_npr'=> $actual_npr,);
    }
    $response['posts'] = $posts;
    echo json_encode($response);
    }
}else if($_POST['fa_op'] == 4) {
    if(!empty($pn)) {
        $sqlpnum1 = "SELECT * FROM `pm_part_number` where `pm_part_number_id` = '$pn'";
        $resultpnum1 = mysqli_query($db, $sqlpnum1);
        $rowcpnum1 = $resultpnum1->fetch_assoc();
        $pm_npr = $rowcpnum1['npr'];
        if (empty($pm_npr)) {
            $npr = 0;
        } else {
            $npr = $pm_npr;
        }
        $sql11 = "SELECT SUM(good_pieces) AS good_pieces,SUM(bad_pieces)AS bad_pieces,SUM(rework) AS rework FROM `good_bad_pieces`  INNER JOIN sg_station_event ON good_bad_pieces.station_event_id = sg_station_event.station_event_id where 1 " . $wc;
        $response = array();
        $posts = array();
        $result11 = mysqli_query($db, $sql11);
        $row2 = $result11->fetch_assoc();
        $total_gp = $row2['good_pieces'] + $row2['rework'];
        $data = array();
        $sql3 = "SELECT * FROM `sg_station_event_log` where 1 and station_event_id = '$station_event_id' and event_cat_id in (SELECT events_cat_id FROM `events_category` where npr = 1)";
        $result3 = mysqli_query($db, $sql3);
        $ttot = null;
        $tt = null;
        if (null != $result3) {
            $total_time = 0;
            while ($row3 = $result3->fetch_assoc()) {
                $ct = $row3['created_on'];
                $tot = $row3['total_time'];
                if (!empty($row3['total_time'])) {
                    $ttot = explode(':', $row3['total_time']);
                    $i = 0;
                    foreach ($ttot as $t_time) {
                        if ($i == 0) {
                            $total_time += ($t_time * 60 * 60);
                        } else if ($i == 1) {
                            $total_time += ($t_time * 60);
                        } else {
                            $total_time += $t_time;
                        }
                        $i++;
                    }
                } else {
                    $total_time += strtotime($chicagotime) - strtotime($ct);
                }
            }
            $total_time = (($total_time / 60) / 60);
            $b = round($total_time);
            $target_eff = round($npr * $b);
            $actual_eff = $total_gp;
            $eff = round(100 * ($actual_eff / $target_eff));
            // $pm_avg_npr = (($target_npr + 2) > 0)? ($target_npr + 2) : $target_npr;
            $posts[] = array('target_eff' => $target_eff, 'actual_eff' => $actual_eff, 'eff' => $eff,);
        }

        $response['posts'] = $posts;
        echo json_encode($response);
    }
}else if($_POST['fa_op'] == 5) {
    if($pn != "" && $pf != ""){
        $sql11 = "SELECT SUM(good_pieces) as good_pieces,SUM(bad_pieces) as bad_pieces,SUM(rework) as rework FROM `good_bad_pieces` INNER JOIN sg_station_event ON good_bad_pieces.station_event_id = sg_station_event.station_event_id WHERE sg_station_event.line_id = '$sta' and sg_station_event.part_family_id = '$pf' and sg_station_event.part_number_id = '$pn' AND hour(good_bad_pieces.created_at) >= 00 and hour(good_bad_pieces.created_at) < 08 and DATE_FORMAT(good_bad_pieces.`created_at`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(good_bad_pieces.`created_at`,'%Y-%m-%d') <= '$dateto'";
        $result11 = mysqli_query($db,$sql11);
        while ($row11=$result11->fetch_assoc()){
            $good_pieces = $row11['good_pieces'];
            $bad_pieces = $row11['bad_pieces'];
            $rework = $row11['rework'];
        }
        $sql21 = "SELECT SUM(good_pieces) as good_pieces1,SUM(bad_pieces) as bad_pieces1,SUM(rework) as rework1 FROM `good_bad_pieces` INNER JOIN sg_station_event ON good_bad_pieces.station_event_id = sg_station_event.station_event_id WHERE sg_station_event.line_id = '$sta' and sg_station_event.part_family_id = '$pf' and sg_station_event.part_number_id = '$pn' AND hour(good_bad_pieces.created_at) >= 08 and hour(good_bad_pieces.created_at) < 16 and DATE_FORMAT(good_bad_pieces.`created_at`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(good_bad_pieces.`created_at`,'%Y-%m-%d') <= '$dateto'";
        $result21 = mysqli_query($db,$sql21);
        while ($row21=$result21->fetch_assoc()){
            $good_pieces1 = $row21['good_pieces1'];
            $bad_pieces1 = $row21['bad_pieces1'];
            $rework1 = $row21['rework1'];
        }

        $sql31 = "SELECT SUM(good_pieces) as good_pieces2,SUM(bad_pieces) as bad_pieces2,SUM(rework) as rework2 FROM `good_bad_pieces` INNER JOIN sg_station_event ON good_bad_pieces.station_event_id = sg_station_event.station_event_id WHERE sg_station_event.line_id = '$sta' and sg_station_event.part_family_id = '$pf' and sg_station_event.part_number_id = '$pn' AND hour(good_bad_pieces.created_at) >= 16 and hour(good_bad_pieces.created_at) <= 23 and DATE_FORMAT(good_bad_pieces.`created_at`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(good_bad_pieces.`created_at`,'%Y-%m-%d') <= '$dateto'";
        $response = array();
        $posts = array();
        $result31 = mysqli_query($db,$sql31);
//$result = $mysqli->query($sql);
        $data =array();
        if( null != $result31){
            while ($row31=$result31->fetch_assoc()){
                $good_pieces2 = $row31['good_pieces2'];
                $bad_pieces2 = $row31['bad_pieces2'];
                $rework2 = $row31['rework2'];
                $posts[] = array('good_pieces'=> $good_pieces, 'bad_pieces'=> $bad_pieces, 'rework'=> $rework,
                    'good_pieces1'=> $good_pieces1, 'bad_pieces1'=> $bad_pieces1, 'rework1'=> $rework1,
                    'good_pieces2'=> $good_pieces2, 'bad_pieces2'=> $bad_pieces2, 'rework2'=> $rework2);
            }
        }

        $response['posts'] = $posts;
        echo json_encode($response);
    }
    else{
        $sql11 = "SELECT SUM(good_pieces) as good_pieces,SUM(bad_pieces) as bad_pieces,SUM(rework) as rework FROM `good_bad_pieces` INNER JOIN sg_station_event ON good_bad_pieces.station_event_id = sg_station_event.station_event_id WHERE sg_station_event.line_id = '$sta' AND hour(good_bad_pieces.created_at) >= 00 and hour(good_bad_pieces.created_at) < 08 and DATE_FORMAT(good_bad_pieces.`created_at`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(good_bad_pieces.`created_at`,'%Y-%m-%d') <= '$dateto'";
    $result11 = mysqli_query($db,$sql11);
    while ($row11=$result11->fetch_assoc()){
        $good_pieces = $row11['good_pieces'];
        $bad_pieces = $row11['bad_pieces'];
        $rework = $row11['rework'];
    }
    $sql21 = "SELECT SUM(good_pieces) as good_pieces1,SUM(bad_pieces) as bad_pieces1,SUM(rework) as rework1 FROM `good_bad_pieces` INNER JOIN sg_station_event ON good_bad_pieces.station_event_id = sg_station_event.station_event_id WHERE sg_station_event.line_id = '$sta' AND hour(good_bad_pieces.created_at) >= 08 and hour(good_bad_pieces.created_at) < 16 and DATE_FORMAT(good_bad_pieces.`created_at`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(good_bad_pieces.`created_at`,'%Y-%m-%d') <= '$dateto'";
    $result21 = mysqli_query($db,$sql21);
    while ($row21=$result21->fetch_assoc()){
        $good_pieces1 = $row21['good_pieces1'];
        $bad_pieces1 = $row21['bad_pieces1'];
        $rework1 = $row21['rework1'];
    }

    $sql31 = "SELECT SUM(good_pieces) as good_pieces2,SUM(bad_pieces) as bad_pieces2,SUM(rework) as rework2 FROM `good_bad_pieces` INNER JOIN sg_station_event ON good_bad_pieces.station_event_id = sg_station_event.station_event_id WHERE sg_station_event.line_id = '$sta' AND hour(good_bad_pieces.created_at) >= 16 and hour(good_bad_pieces.created_at) <= 23 and DATE_FORMAT(good_bad_pieces.`created_at`,'%Y-%m-%d') >= '$datefrom' and DATE_FORMAT(good_bad_pieces.`created_at`,'%Y-%m-%d') <= '$dateto'";
    $response = array();
    $posts = array();
    $result31 = mysqli_query($db,$sql31);
//$result = $mysqli->query($sql);
    $data =array();
    if( null != $result31){
        while ($row31=$result31->fetch_assoc()){
            $good_pieces2 = $row31['good_pieces2'];
            $bad_pieces2 = $row31['bad_pieces2'];
            $rework2 = $row31['rework2'];
            $posts[] = array('good_pieces'=> $good_pieces, 'bad_pieces'=> $bad_pieces, 'rework'=> $rework,
                'good_pieces1'=> $good_pieces1, 'bad_pieces1'=> $bad_pieces1, 'rework1'=> $rework1,
                'good_pieces2'=> $good_pieces2, 'bad_pieces2'=> $bad_pieces2, 'rework2'=> $rework2);
        }
    }

    $response['posts'] = $posts;
    echo json_encode($response);
    }
}

