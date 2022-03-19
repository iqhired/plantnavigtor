<?php
include("../config.php");
if (!isset($_SESSION['user'])) {
	header('location: logout.php');
}
$user = $_SESSION['user'];
$chicagotime = date("Y-m-d H:i:s");
    $good_name = $_POST['good_name'];
$good_bad_piece_name = $_POST['good_bad_piece_name'];
$edit_id = $_POST['edit_id'];
$edit_gbid = $_POST['edit_gbid'];
$edit_seid = $_POST['edit_seid'];

if ($good_name != "") {
	$station_event_id = $_POST['station_event_id'];
//        $sql = "select * from good_bad_pieces  where station_event_id ='$station_event_id' and event_status = '1' and defect_name is NULL";
	$sql = "select * from good_bad_pieces  where station_event_id ='$station_event_id' and event_status = '1'";
	$result1 = mysqli_query($db, $sql);
	$rowc = mysqli_fetch_array($result1);
	$g =(($rowc['good_pieces'] == null) || ($rowc['good_pieces'] == "" ) )?0:$rowc['good_pieces'] ;
	$good_bad_pieces_id =$rowc['good_bad_pieces_id'];
	if($good_bad_pieces_id == null || $good_bad_pieces_id == ""){
		$sql1 = "INSERT INTO `good_bad_pieces_details`(`station_event_id`, `good_pieces`,  `created_at`, `created_by`) VALUES ('$station_event_id','$good_name','$chicagotime','$user')";
		$result11 = mysqli_query($db, $sql1);
		$sqlquery = "INSERT INTO `good_bad_pieces`(`station_event_id`,`good_pieces`,`created_at`,`modified_at`) VALUES ('$station_event_id','$good_name','$chicagotime','$chicagotime')";
		if (!mysqli_query($db, $sqlquery)) {
			$_SESSION['message_stauts_class'] = 'alert-danger';
			$_SESSION['import_status_message'] = 'Error: Good Pieces Couldnt Added';
		} else {
			$_SESSION['message_stauts_class'] = 'alert-success';
			$_SESSION['import_status_message'] = 'Good Pieces Added Sucessfully.';
		}
	}else{
		$good_pieces = $g + $good_name;
		$sql1 = "INSERT INTO `good_bad_pieces_details`(`station_event_id`, `good_pieces`,  `created_at`, `created_by`) VALUES ('$station_event_id','$good_name','$chicagotime','$user')";
		$result11 = mysqli_query($db, $sql1);
		$sql1 = "update good_bad_pieces set good_pieces ='$good_pieces' , modified_at = '$chicagotime' where station_event_id ='$station_event_id' and event_status = '1'";
		$result11 = mysqli_query($db, $sql1);
		if ($result11) {
			$_SESSION['message_stauts_class'] = 'alert-success';
			$_SESSION['import_status_message'] = 'Good Pieces Added Sucessfully.';
		} else {
			$_SESSION['message_stauts_class'] = 'alert-danger';
			$_SESSION['import_status_message'] = 'Error: Please Retry';
		}
	}
//	if ( $g != "") {
//		$good_pieces = $rowc['good_pieces'] + $good_name;
//		$sql1 = "INSERT INTO `good_bad_pieces_details`(`station_event_id`, `good_pieces`,  `created_at`, `created_by`) VALUES ('$station_event_id','$good_name','$chicagotime','$user')";
//		$result11 = mysqli_query($db, $sql1);
//		$sql1 = "update good_bad_pieces set good_pieces ='$good_pieces' , modified_at = '$chicagotime' where station_event_id ='$station_event_id' and event_status = '1'";
//		$result11 = mysqli_query($db, $sql1);
//		if ($result11) {
//			$_SESSION['message_stauts_class'] = 'alert-success';
//			$_SESSION['import_status_message'] = 'Good Pieces Added Sucessfully.';
//		} else {
//			$_SESSION['message_stauts_class'] = 'alert-danger';
//			$_SESSION['import_status_message'] = 'Error: Please Retry';
//		}
//	} else {
//		$sql1 = "INSERT INTO `good_bad_pieces_details`(`station_event_id`, `good_pieces`,  `created_at`, `created_by`) VALUES ('$station_event_id','$good_name','$chicagotime','$user')";
//		$result11 = mysqli_query($db, $sql1);
//		$sqlquery = "INSERT INTO `good_bad_pieces`(`station_event_id`,`good_pieces`,`created_at`,`modified_at`) VALUES ('$station_event_id','$good_name','$chicagotime','$chicagotime')";
//		if (!mysqli_query($db, $sqlquery)) {
//			$_SESSION['message_stauts_class'] = 'alert-danger';
//			$_SESSION['import_status_message'] = 'Error: Good Pieces Couldnt Added';
//		} else {
//			$_SESSION['message_stauts_class'] = 'alert-success';
//			$_SESSION['import_status_message'] = 'Good Pieces Added Sucessfully.';
//		}
//	}
}
else if($good_bad_piece_name != "")
{
	$station_event_id = $_POST['station_event_id'];
	$add_defect_name = $_POST['add_defect_name'];
//        $cnt = count($defect_arr);
	$bad_type = $_POST['bad_type'];
	$good_bad_piece_name = $_POST['good_bad_piece_name'];

	$sql = "select * from good_bad_pieces where station_event_id ='$station_event_id' and event_status = '1'";
//		$sql = "select * from good_bad_pieces where station_event_id ='$station_event_id' and event_status = '1' and defect_name = '$add_defect_name'";
		$result1 = mysqli_query($db, $sql);
		$rowc = mysqli_fetch_array($result1);
		$bad =$rowc['bad_pieces'];
		$good_bad_pieces_id =$rowc['good_bad_pieces_id'];

	if($bad_type == "bad_piece")
	{
		if($good_bad_pieces_id != "")
		{
			$bp = $rowc['bad_pieces'];
			$bad_pieces = $bp + $good_bad_piece_name;
			$sql1 = "INSERT INTO `good_bad_pieces_details`(`station_event_id`, `defect_name`, `bad_pieces`,  `created_at`,`created_by`, `modified_at`) VALUES ('$station_event_id','$add_defect_name','$good_bad_piece_name','$chicagotime','$user','$chicagotime')";
			$result11 = mysqli_query($db, $sql1);
//				$sql1 = "update good_bad_pieces set bad_pieces ='$bad_pieces' where station_event_id ='$station_event_id' and event_status = '1' and defect_name = '$add_defect_name'";
			$sql1 = "update good_bad_pieces set bad_pieces ='$bad_pieces' , modified_at = '$chicagotime' where station_event_id ='$station_event_id' and event_status = '1'";
			$result11 = mysqli_query($db, $sql1);
			if ($result11) {
				$_SESSION['message_stauts_class'] = 'alert-success';
				$_SESSION['import_status_message'] = 'Bad Pieces Added Sucessfully.';
			} else {
				$_SESSION['message_stauts_class'] = 'alert-danger';
				$_SESSION['import_status_message'] = 'Error: Please Retry';
			}
		}
		else
		{
			$sql1 = "INSERT INTO `good_bad_pieces_details`(`station_event_id`, `defect_name`, `bad_pieces`, `rework`, `created_at`,`created_by`, `modified_at`) VALUES ('$station_event_id','$add_defect_name','$good_bad_piece_name','','$chicagotime','$user','$chicagotime')";
			$result11 = mysqli_query($db, $sql1);
			$sqlquery = "INSERT INTO `good_bad_pieces`(`station_event_id`,`bad_pieces`,`created_at`,`modified_at`) VALUES ('$station_event_id','$good_bad_piece_name','$chicagotime','$chicagotime')";
			if (!mysqli_query($db, $sqlquery)) {
				$_SESSION['message_stauts_class'] = 'alert-danger';
				$_SESSION['import_status_message'] = 'Error: Bad Pieces Couldnt Added';
			} else {
				$_SESSION['message_stauts_class'] = 'alert-success';
				$_SESSION['import_status_message'] = 'Bad Pieces Added Sucessfully.';
			}
		}
	}
	else
	{
		if($good_bad_pieces_id != "")
		{
			$rw = $rowc['rework'];
			$rework_pieces = $rw + $good_bad_piece_name;
			$sql1 = "INSERT INTO `good_bad_pieces_details`(`station_event_id`, `defect_name`, `rework`, `created_at`,`created_by`, `modified_at`) VALUES ('$station_event_id','$add_defect_name','$good_bad_piece_name','$chicagotime','$user','$chicagotime')";
			$result11 = mysqli_query($db, $sql1);
//				$sql1 = "update good_bad_pieces set rework ='$rework_pieces' where station_event_id ='$station_event_id' and event_status = '1' and defect_name = '$add_defect_name'";
			$sql1 = "update good_bad_pieces set rework ='$rework_pieces' , modified_at = '$chicagotime'  where station_event_id ='$station_event_id' and event_status = '1' ";
			$result11 = mysqli_query($db, $sql1);
			if ($result11) {
				$_SESSION['message_stauts_class'] = 'alert-success';
				$_SESSION['import_status_message'] = 'Rework Pieces Added Sucessfully.';
			} else {
				$_SESSION['message_stauts_class'] = 'alert-danger';
				$_SESSION['import_status_message'] = 'Error: Please Retry';
			}
		}
		else
		{
			$sql1 = "INSERT INTO `good_bad_pieces_details`(`station_event_id`, `defect_name`,  `rework`, `created_at`,`created_by`, `modified_at`) VALUES ('$station_event_id','$add_defect_name','$good_bad_piece_name','$chicagotime','$user','$chicagotime')";
			$result11 = mysqli_query($db, $sql1);
			$sqlquery = "INSERT INTO `good_bad_pieces`(`station_event_id`,`rework`,`created_at`,`modified_at`) VALUES ('$station_event_id','$good_bad_piece_name','$chicagotime','$chicagotime')";
			if (!mysqli_query($db, $sqlquery)) {
				$_SESSION['message_stauts_class'] = 'alert-danger';
				$_SESSION['import_status_message'] = 'Error: Rework Pieces Couldnt Added';
			} else {
				$_SESSION['message_stauts_class'] = 'alert-success';
				$_SESSION['import_status_message'] = 'Rework Pieces Added Sucessfully.';
			}

		}

	}
}
else if($edit_id != "")
{
	$editgood_name = $_POST['editgood_name'];
	$editdefect_name = $_POST['editdefect_name'];
	$editbad_name = $_POST['editbad_name'];
	$editre_work = $_POST['editre_work'];
	if($editgood_name != "")
	{

		$query = sprintf("SELECT ('$editgood_name' - good_pieces) as total from good_bad_pieces_details where `station_event_id` = '$edit_seid' and bad_pieces_id = '$edit_gbid'");
		$qur = mysqli_query($db, $query);
		while ($rowc = mysqli_fetch_array($qur)) {
			$gps =  $rowc['total'];

			$sql1 = "update good_bad_pieces_details set good_pieces ='$editgood_name' ,modified_by='$user', modified_at = '$chicagotime'  where bad_pieces_id ='$edit_gbid'";
			$result11 = mysqli_query($db, $sql1);
			$sql1 = "update good_bad_pieces set good_pieces =(good_pieces + '$gps') , modified_at = '$chicagotime'  where good_bad_pieces_id ='$edit_id'";
			$result11 = mysqli_query($db, $sql1);
			if ($result11) {
				$_SESSION['message_stauts_class'] = 'alert-success';
				$_SESSION['import_status_message'] = 'Good Pieces Updated Sucessfully.';
			} else {
				$_SESSION['message_stauts_class'] = 'alert-danger';
				$_SESSION['import_status_message'] = 'Error: Please Retry';
			}
		}

	}
	else
	{
		$query = sprintf("SELECT ('$editbad_name' - bad_pieces) as b_total , ('$editre_work' - rework) as r_total from good_bad_pieces_details where `station_event_id` = '$edit_seid' and bad_pieces_id = '$edit_gbid'");
		$qur = mysqli_query($db, $query);
		while ($rowc = mysqli_fetch_array($qur)) {
			$bps =  $rowc['b_total'];
			$rwps =  $rowc['r_total'];
			$sql1 = "update good_bad_pieces_details set bad_pieces ='$editbad_name' , rework = '$editre_work' ,modified_by='$user', modified_at = '$chicagotime'  where bad_pieces_id ='$edit_gbid'";
			$result11 = mysqli_query($db, $sql1);
			$sql1 = "update good_bad_pieces set bad_pieces =( bad_pieces + '$bps'),rework =( rework + '$rwps') , modified_at = '$chicagotime' where good_bad_pieces_id ='$edit_id'";
			$result11 = mysqli_query($db, $sql1);
			if ($result11) {
				$_SESSION['message_stauts_class'] = 'alert-success';
				$_SESSION['import_status_message'] = 'Bad / Re-work Pieces Updated Sucessfully.';
			} else {
				$_SESSION['message_stauts_class'] = 'alert-danger';
				$_SESSION['import_status_message'] = 'Error: Please Retry';
			}
		}

	}
}

header("Location:good_bad_piece.php");
?>
