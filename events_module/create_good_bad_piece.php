<?php
include("../config.php");
$user = $_SESSION['user'];
$user_fullname = str_replace("&nbsp;" , " " , $_SESSION['fullname']);
$chicagotime = date("Y-m-d H:i:s");
$good_name = $_POST['good_name'];
$ipe = $_POST['ipe'];
$chk = 1;
$p_line_name = $_POST['line_name'];
$good_bad_piece_name = $_POST['good_bad_piece_name'];
$edit_id = $_POST['edit_id'];
$edit_gbid = $_POST['edit_gbid'];
$edit_seid = $_POST['edit_seid'];
$station_event_id = $_POST['station_event_id'];
$f_postfix = $_POST['time'];
$label_quantity = 0;
$g_timestamp = time();
$query1 = sprintf("SELECT line_id , part_number_id FROM sg_station_event where  station_event_id = '$station_event_id'");
$qur1 = mysqli_query($db, $query1);
while ($rowc = mysqli_fetch_array($qur1)) {
    $line_id = $rowc['line_id'];
    $part_number = $rowc['part_number_id'];
}
if ($good_name != "") {
    //check the station individual enabled or not
    if ($ipe == $chk){
        $label_quantity = $chk;
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
                $_SESSION['import_status_message'] = 'Error: Error Adding Good Pieces';
            } else {
                $station_event_id = $_POST['station_event_id'];
                $add_defect_name = $_POST['add_defect_name'];

                $good_bad_piece_name = $_POST['good_bad_piece_name'];

                $query = sprintf("SELECT gbp.good_bad_pieces_id as good_bad_pieces_id ,gbpd.bad_pieces_id as bad_pieces_id , gbpd.good_pieces as good_pieces, gbpd.defect_name as defect_name, gbpd.bad_pieces as bad_pieces ,gbpd.rework as rework FROM good_bad_pieces as gbp INNER JOIN good_bad_pieces_details as gbpd on gbp.station_event_id = gbpd.station_event_id where gbp.event_status = '1' and gbp.station_event_id = '$station_event_id' order by gbpd.bad_pieces_id DESC");
                $qur = mysqli_query($db, $query);
                while ($rowc = mysqli_fetch_array($qur)) {

                    $good_bad_pieces_id = $rowc['good_bad_pieces_id'];
                    $station_event_id = $rowc['station_event_id'];
                }

                if($good_bad_pieces_id){


                    $sqlnumber = "SELECT * FROM `pm_part_number` where `pm_part_number_id` = '$part_number'";
                    $resultnumber = $mysqli->query($sqlnumber);
                    $rowcnumber = $resultnumber->fetch_assoc();
                    $pm_part_number = $rowcnumber['part_number'];
                    $pm_part_name = $rowcnumber['part_name'];
                    $dir_path = "../assets/label_files/" . $line_id;
                    $format_file =  file($dir_path . '/f1');
                    $file =  file($dir_path . '/g_' . $f_postfix);
                    $patterns = array();
                    $patterns[0] = '/PartNo/';
                    $patterns[1] = '/PartName/';
                    $patterns[2] = '/Date/';
                    $patterns[3] = '/UserName/';
                    $patterns[4] = '/StationName/';
                    $patterns[5] = '/Qty/';
                    $patterns[6] = '/PQ1/';
                    $replacements = array();
                    $replacements[0] = $pm_part_number;
                    $replacements[1] = $pm_part_name;
                    $replacements[2] = $chicagotime;
                    $replacements[3] = $user_fullname;
                    $replacements[4] = $p_line_name;
                    $replacements[5] = $label_quantity;
                    $replacements[6] = "PQ".$good_name;
                    file_put_contents('../assets/label_files/'. $line_id .'/g_'.$f_postfix, '');
                    $output = preg_replace($patterns, $replacements, $format_file);
                    file_put_contents('../assets/label_files/'. $line_id .'/g_'.$f_postfix, $output);
                }
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
                $station_event_id = $_POST['station_event_id'];
                $add_defect_name = $_POST['add_defect_name'];

                $good_bad_piece_name = $_POST['good_bad_piece_name'];

                $query = sprintf("SELECT gbp.good_bad_pieces_id as good_bad_pieces_id ,gbpd.bad_pieces_id as bad_pieces_id , gbpd.good_pieces as good_pieces, gbpd.defect_name as defect_name, gbpd.bad_pieces as bad_pieces ,gbpd.rework as rework FROM good_bad_pieces as gbp INNER JOIN good_bad_pieces_details as gbpd on gbp.station_event_id = gbpd.station_event_id where gbp.event_status = '1' and gbp.station_event_id = '$station_event_id' order by gbpd.bad_pieces_id DESC");
                $qur = mysqli_query($db, $query);
//			while ($rowc = mysqli_fetch_array($qur)) {
//
//				$good_bad_pieces_id = $rowc['good_bad_pieces_id'];
//				$station_event_id = $rowc['station_event_id'];
//			}
                $query1 = sprintf("SELECT line_id , part_number_id FROM sg_station_event where  station_event_id = '$station_event_id'");
                $qur1 = mysqli_query($db, $query1);
                while ($rowc = mysqli_fetch_array($qur1)) {
                    $line_id = $rowc['line_id'];
                    $part_number = $rowc['part_number_id'];
                }
                if($good_bad_pieces_id){


                    $sqlnumber = "SELECT * FROM `pm_part_number` where `pm_part_number_id` = '$part_number'";
                    $resultnumber = $mysqli->query($sqlnumber);
                    $rowcnumber = $resultnumber->fetch_assoc();
                    $pm_part_number = $rowcnumber['part_number'];
                    $pm_part_name = $rowcnumber['part_name'];
                    $dir_path = "../assets/label_files/" . $line_id;
                    $format_file =  file($dir_path . '/f1');
                    $file =  file($dir_path . '/g_'. $f_postfix);
                    $patterns = array();
                    $patterns[0] = '/PartNo/';
                    $patterns[1] = '/PartName/';
                    $patterns[2] = '/Date/';
                    $patterns[3] = '/UserName/';
                    $patterns[4] = '/StationName/';
                    $patterns[5] = '/Qty/';
                    $patterns[6] = '/PQ1/';
                    $replacements = array();
                    $replacements[0] = $pm_part_number;
                    $replacements[1] = $pm_part_name;
                    $replacements[2] = $chicagotime;
                    $replacements[3] = $user_fullname;
                    $replacements[4] = $p_line_name;
                    $replacements[5] = $label_quantity;
                    $replacements[6] = "PQ".$good_name;
                    file_put_contents('../assets/label_files/'. $line_id .'/g_'.$f_postfix, '');
                    $output = preg_replace($patterns, $replacements, $format_file);
                    file_put_contents('../assets/label_files/'. $line_id .'/g_'.$f_postfix, $output);
                }
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
    } else{
        $label_quantity = $good_name;
//        $sql = "select * from good_bad_pieces  where station_event_id ='$station_event_id' and event_status = '1' and defect_name is NULL";
        $sql = "select * from good_bad_pieces  where station_event_id ='$station_event_id' and event_status = '1'";
        $result1 = mysqli_query($db, $sql);
        $rowc = mysqli_fetch_array($result1);
        $g = (($rowc['good_pieces'] == null) || ($rowc['good_pieces'] == "")) ? 0 : $rowc['good_pieces'];
        $good_bad_pieces_id = $rowc['good_bad_pieces_id'];
        if ($good_bad_pieces_id == null || $good_bad_pieces_id == "") {
            $sql1 = "INSERT INTO `good_bad_pieces_details`(`station_event_id`, `good_pieces`,  `created_at`, `created_by`) VALUES ('$station_event_id','$good_name','$chicagotime','$user')";
            $result11 = mysqli_query($db, $sql1);
            $sqlquery = "INSERT INTO `good_bad_pieces`(`station_event_id`,`good_pieces`,`created_at`,`modified_at`) VALUES ('$station_event_id','$good_name','$chicagotime','$chicagotime')";
            if (!mysqli_query($db, $sqlquery)) {
                $_SESSION['message_stauts_class'] = 'alert-danger';
                $_SESSION['import_status_message'] = 'Error: Error Adding Good Pieces';
            } else {
                $station_event_id = $_POST['station_event_id'];
                $add_defect_name = $_POST['add_defect_name'];

                $good_bad_piece_name = $_POST['good_bad_piece_name'];

                $query = sprintf("SELECT gbp.good_bad_pieces_id as good_bad_pieces_id ,gbp.station_event_id as station_event_id,gbpd.bad_pieces_id as bad_pieces_id , gbpd.good_pieces as good_pieces, gbpd.defect_name as defect_name, gbpd.bad_pieces as bad_pieces ,gbpd.rework as rework FROM good_bad_pieces as gbp INNER JOIN good_bad_pieces_details as gbpd on gbp.station_event_id = gbpd.station_event_id where gbp.event_status = '1' and gbp.station_event_id = '$station_event_id' order by gbpd.bad_pieces_id DESC");
                $qur = mysqli_query($db, $query);
                while ($rowc = mysqli_fetch_array($qur)) {

                    $good_bad_pieces_id = $rowc['good_bad_pieces_id'];
                    $station_event_id = $rowc['station_event_id'];
                }

                if ($good_bad_pieces_id) {
                    $sqlnumber = "SELECT * FROM `pm_part_number` where `pm_part_number_id` = '$part_number'";
                    $resultnumber = $mysqli->query($sqlnumber);
                    $rowcnumber = $resultnumber->fetch_assoc();
                    $pm_part_number = $rowcnumber['part_number'];
                    $pm_part_name = $rowcnumber['part_name'];
                    $dir_path = "../assets/label_files/" . $line_id;
                    $format_file = file($dir_path . '/f1');
                    $file = file($dir_path . '/g_' . $f_postfix);
                    $patterns = array();
                    $patterns[0] = '/PartNo/';
                    $patterns[1] = '/PartName/';
                    $patterns[2] = '/Date/';
                    $patterns[3] = '/UserName/';
                    $patterns[4] = '/StationName/';
                    $patterns[5] = '/Qty/';
                    $replacements = array();
                    $replacements[0] = $pm_part_number;
                    $replacements[1] = $pm_part_name;
                    $replacements[2] = $chicagotime;
                    $replacements[3] = $user_fullname;
                    $replacements[4] = $p_line_name;
                    $replacements[5] = $label_quantity;
                    file_put_contents('../assets/label_files/' . $line_id . '/g_' . $f_postfix, '');
                    $output = preg_replace($patterns, $replacements, $format_file);
                    file_put_contents('../assets/label_files/' . $line_id . '/g_' . $f_postfix, $output);
                }
                $_SESSION['message_stauts_class'] = 'alert-success';
                $_SESSION['import_status_message'] = 'Good Pieces Added Sucessfully.';

            }
        } else {
            $good_pieces = $g + $good_name;
            $sql1 = "INSERT INTO `good_bad_pieces_details`(`station_event_id`, `good_pieces`,  `created_at`, `created_by`) VALUES ('$station_event_id','$good_name','$chicagotime','$user')";
            $result11 = mysqli_query($db, $sql1);
            $sql1 = "update good_bad_pieces set good_pieces ='$good_pieces' , modified_at = '$chicagotime' where station_event_id ='$station_event_id' and event_status = '1'";
            $result11 = mysqli_query($db, $sql1);
            if ($result11) {
                $station_event_id = $_POST['station_event_id'];
                $add_defect_name = $_POST['add_defect_name'];

                $good_bad_piece_name = $_POST['good_bad_piece_name'];

                $query = sprintf("SELECT gbp.good_bad_pieces_id as good_bad_pieces_id ,gbpd.bad_pieces_id as bad_pieces_id , gbpd.good_pieces as good_pieces, gbpd.defect_name as defect_name, gbpd.bad_pieces as bad_pieces ,gbpd.rework as rework FROM good_bad_pieces as gbp INNER JOIN good_bad_pieces_details as gbpd on gbp.station_event_id = gbpd.station_event_id where gbp.event_status = '1' and gbp.station_event_id = '$station_event_id' order by gbpd.bad_pieces_id DESC");
                $qur = mysqli_query($db, $query);
//			while ($rowc = mysqli_fetch_array($qur)) {
//
//				$good_bad_pieces_id = $rowc['good_bad_pieces_id'];
//				$station_event_id = $rowc['station_event_id'];
//			}
                $query1 = sprintf("SELECT line_id , part_number_id FROM sg_station_event where  station_event_id = '$station_event_id'");
                $qur1 = mysqli_query($db, $query1);
                while ($rowc = mysqli_fetch_array($qur1)) {
                    $line_id = $rowc['line_id'];
                    $part_number = $rowc['part_number_id'];
                }
                if ($good_bad_pieces_id) {


                    $sqlnumber = "SELECT * FROM `pm_part_number` where `pm_part_number_id` = '$part_number'";
                    $resultnumber = $mysqli->query($sqlnumber);
                    $rowcnumber = $resultnumber->fetch_assoc();
                    $pm_part_number = $rowcnumber['part_number'];
                    $pm_part_name = $rowcnumber['part_name'];
                    $dir_path = "../assets/label_files/" . $line_id;
                    $format_file = file($dir_path . '/f1');
                    $file = file($dir_path . '/g_' . $f_postfix);
                    $patterns = array();
                    $patterns[0] = '/PartNo/';
                    $patterns[1] = '/PartName/';
                    $patterns[2] = '/Date/';
                    $patterns[3] = '/UserName/';
                    $patterns[4] = '/StationName/';
                    $patterns[5] = '/Qty/';
                    $replacements = array();
                    $replacements[0] = $pm_part_number;
                    $replacements[1] = $pm_part_name;
                    $replacements[2] = $chicagotime;
                    $replacements[3] = $user_fullname;
                    $replacements[4] = $p_line_name;
                    $replacements[5] = $label_quantity;
                    file_put_contents('../assets/label_files/' . $line_id . '/g_' . $f_postfix, '');
                    $output = preg_replace($patterns, $replacements, $format_file);
                    file_put_contents('../assets/label_files/' . $line_id . '/g_' . $f_postfix, $output);
                }
                $_SESSION['message_stauts_class'] = 'alert-success';
                $_SESSION['import_status_message'] = 'Good Pieces Added Sucessfully.';
                $page = "good_bad_piece.php?station_event_id=$station_event_id";
                header('Location: ' . $page, true, 303);
            } else {
                $_SESSION['message_stauts_class'] = 'alert-danger';
                $_SESSION['import_status_message'] = 'Error: Please Retry';
                $page = "good_bad_piece.php?station_event_id=$station_event_id";
                header('Location: ' . $page, true, 303);
            }

        }
    }
}
// this is original code i just add else if incase above not its should work
/*if ($good_name != "") {
	$label_quantity = $good_name;
//        $sql = "select * from good_bad_pieces  where station_event_id ='$station_event_id' and event_status = '1' and defect_name is NULL";
	$sql = "select * from good_bad_pieces  where station_event_id ='$station_event_id' and event_status = '1'";
	$result1 = mysqli_query($db, $sql);
	$rowc = mysqli_fetch_array($result1);
	$g = (($rowc['good_pieces'] == null) || ($rowc['good_pieces'] == "")) ? 0 : $rowc['good_pieces'];
	$good_bad_pieces_id = $rowc['good_bad_pieces_id'];
	if ($good_bad_pieces_id == null || $good_bad_pieces_id == "") {
		$sql1 = "INSERT INTO `good_bad_pieces_details`(`station_event_id`, `good_pieces`,  `created_at`, `created_by`) VALUES ('$station_event_id','$good_name','$chicagotime','$user')";
		$result11 = mysqli_query($db, $sql1);
		$sqlquery = "INSERT INTO `good_bad_pieces`(`station_event_id`,`good_pieces`,`created_at`,`modified_at`) VALUES ('$station_event_id','$good_name','$chicagotime','$chicagotime')";
		if (!mysqli_query($db, $sqlquery)) {
			$_SESSION['message_stauts_class'] = 'alert-danger';
			$_SESSION['import_status_message'] = 'Error: Error Adding Good Pieces';
		} else {
			$station_event_id = $_POST['station_event_id'];
			$add_defect_name = $_POST['add_defect_name'];

			$good_bad_piece_name = $_POST['good_bad_piece_name'];

			$query = sprintf("SELECT gbp.good_bad_pieces_id as good_bad_pieces_id ,gbpd.bad_pieces_id as bad_pieces_id , gbpd.good_pieces as good_pieces, gbpd.defect_name as defect_name, gbpd.bad_pieces as bad_pieces ,gbpd.rework as rework FROM good_bad_pieces as gbp INNER JOIN good_bad_pieces_details as gbpd on gbp.station_event_id = gbpd.station_event_id where gbp.event_status = '1' and gbp.station_event_id = '$station_event_id' order by gbpd.bad_pieces_id DESC");
			$qur = mysqli_query($db, $query);
			while ($rowc = mysqli_fetch_array($qur)) {

				$good_bad_pieces_id = $rowc['good_bad_pieces_id'];
				$station_event_id = $rowc['station_event_id'];
			}

			if ($good_bad_pieces_id) {


				$sqlnumber = "SELECT * FROM `pm_part_number` where `pm_part_number_id` = '$part_number'";
				$resultnumber = $mysqli->query($sqlnumber);
				$rowcnumber = $resultnumber->fetch_assoc();
				$pm_part_number = $rowcnumber['part_number'];
				$pm_part_name = $rowcnumber['part_name'];
				$dir_path = "../assets/label_files/" . $line_id;
				$format_file = file($dir_path . '/f1');
				$file = file($dir_path . '/g_' . $f_postfix);
				$patterns = array();
				$patterns[0] = '/PartNo/';
				$patterns[1] = '/PartName/';
				$patterns[2] = '/Date/';
				$patterns[3] = '/UserName/';
				$patterns[4] = '/StationName/';
				$patterns[5] = '/Qty/';
				$replacements = array();
				$replacements[0] = $pm_part_number;
				$replacements[1] = $pm_part_name;
				$replacements[2] = $chicagotime;
				$replacements[3] = $user_fullname;
				$replacements[4] = $p_line_name;
				$replacements[5] = $label_quantity;
				file_put_contents('../assets/label_files/' . $line_id . '/g_' . $f_postfix, '');
				$output = preg_replace($patterns, $replacements, $format_file);
				file_put_contents('../assets/label_files/' . $line_id . '/g_' . $f_postfix, $output);
			}
			$_SESSION['message_stauts_class'] = 'alert-success';
			$_SESSION['import_status_message'] = 'Good Pieces Added Sucessfully.';
		}
	} else {
		$good_pieces = $g + $good_name;
		$sql1 = "INSERT INTO `good_bad_pieces_details`(`station_event_id`, `good_pieces`,  `created_at`, `created_by`) VALUES ('$station_event_id','$good_name','$chicagotime','$user')";
		$result11 = mysqli_query($db, $sql1);
		$sql1 = "update good_bad_pieces set good_pieces ='$good_pieces' , modified_at = '$chicagotime' where station_event_id ='$station_event_id' and event_status = '1'";
		$result11 = mysqli_query($db, $sql1);
		if ($result11) {
			$station_event_id = $_POST['station_event_id'];
			$add_defect_name = $_POST['add_defect_name'];

			$good_bad_piece_name = $_POST['good_bad_piece_name'];

			$query = sprintf("SELECT gbp.good_bad_pieces_id as good_bad_pieces_id ,gbpd.bad_pieces_id as bad_pieces_id , gbpd.good_pieces as good_pieces, gbpd.defect_name as defect_name, gbpd.bad_pieces as bad_pieces ,gbpd.rework as rework FROM good_bad_pieces as gbp INNER JOIN good_bad_pieces_details as gbpd on gbp.station_event_id = gbpd.station_event_id where gbp.event_status = '1' and gbp.station_event_id = '$station_event_id' order by gbpd.bad_pieces_id DESC");
			$qur = mysqli_query($db, $query);
//			while ($rowc = mysqli_fetch_array($qur)) {
//
//				$good_bad_pieces_id = $rowc['good_bad_pieces_id'];
//				$station_event_id = $rowc['station_event_id'];
//			}
			$query1 = sprintf("SELECT line_id , part_number_id FROM sg_station_event where  station_event_id = '$station_event_id'");
			$qur1 = mysqli_query($db, $query1);
			while ($rowc = mysqli_fetch_array($qur1)) {
				$line_id = $rowc['line_id'];
				$part_number = $rowc['part_number_id'];
			}
			if ($good_bad_pieces_id) {


				$sqlnumber = "SELECT * FROM `pm_part_number` where `pm_part_number_id` = '$part_number'";
				$resultnumber = $mysqli->query($sqlnumber);
				$rowcnumber = $resultnumber->fetch_assoc();
				$pm_part_number = $rowcnumber['part_number'];
				$pm_part_name = $rowcnumber['part_name'];
				$dir_path = "../assets/label_files/" . $line_id;
				$format_file = file($dir_path . '/f1');
				$file = file($dir_path . '/g_' . $f_postfix);
				$patterns = array();
				$patterns[0] = '/PartNo/';
				$patterns[1] = '/PartName/';
				$patterns[2] = '/Date/';
				$patterns[3] = '/UserName/';
				$patterns[4] = '/StationName/';
				$patterns[5] = '/Qty/';
				$replacements = array();
				$replacements[0] = $pm_part_number;
				$replacements[1] = $pm_part_name;
				$replacements[2] = $chicagotime;
				$replacements[3] = $user_fullname;
				$replacements[4] = $p_line_name;
				$replacements[5] = $label_quantity;
				file_put_contents('../assets/label_files/' . $line_id . '/g_' . $f_postfix, '');
				$output = preg_replace($patterns, $replacements, $format_file);
				file_put_contents('../assets/label_files/' . $line_id . '/g_' . $f_postfix, $output);
			}
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
}*/


else if($good_bad_piece_name != "")
{

    $add_defect_name = $_POST['add_defect_name'];
//        $cnt = count($defect_arr);
    $bad_type = $_POST['bad_type'];
    $good_bad_piece_name = $_POST['good_bad_piece_name'];
    $label_quantity = $good_bad_piece_name;
    $sql = "select * from good_bad_pieces where station_event_id ='$station_event_id' and event_status = '1'";
//		$sql = "select * from good_bad_pieces where station_event_id ='$station_event_id' and event_status = '1' and defect_name = '$add_defect_name'";
    $result1 = mysqli_query($db, $sql);
    $rowc = mysqli_fetch_array($result1);
    $bad =$rowc['bad_pieces'];
    $good_bad_pieces_id =$rowc['good_bad_pieces_id'];

    if($bad_type == "bad_piece")
    {
//		$sqlnumber = "SELECT * FROM `pm_part_number` where `pm_part_number_id` = '$part_number'";
//		$resultnumber = $mysqli->query($sqlnumber);
//		$rowcnumber = $resultnumber->fetch_assoc();
//		$pm_part_number = $rowcnumber['part_number'];
//		$pm_part_name = $rowcnumber['part_name'];
//		$dir_path = "../assets/label_files/" . $line_id;
//		$format_file =  file($dir_path . '/f2');
//		$file =  file($dir_path . '/b_'.$f_postfix);
//		$patterns = array();
//		$patterns[0] = '/PartNo/';
//		$patterns[1] = '/PartName/';
//		$patterns[2] = '/Date/';
//		$patterns[3] = '/UserName/';
//		$patterns[4] = '/StationName/';
//		$patterns[5] = '/Qty/';
//		$replacements = array();
//		$replacements[0] = $pm_part_number;
//		$replacements[1] = $pm_part_name;
//		$replacements[2] = $chicagotime;
//		$replacements[3] = $user_fullname;
//		$replacements[4] = $p_line_name;
//		$replacements[5] = $label_quantity;
//		file_put_contents('../assets/label_files/'. $line_id .'/b_'.$f_postfix, '');
//		$output = preg_replace($patterns, $replacements, $format_file);
//		file_put_contents('../assets/label_files/'. $line_id .'/b_'.$f_postfix, $output);

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

            $qur04 = mysqli_query($db, "SELECT gbpd.bad_pieces_id as bad_pieces_id , gbpd.good_pieces as good_pieces, gbpd.defect_name as defect_name, gbpd.bad_pieces as bad_pieces ,gbpd.rework as rework FROM good_bad_pieces_details as gbpd where gbpd.station_event_id  = '$station_event_id' order by gbpd.bad_pieces_id DESC LIMIT 1");
            $rowc04 = mysqli_fetch_array($qur04);
            $bad_trace_id = $rowc04["bad_pieces_id"];


            $gs = $_SESSION['good_timestamp_id'];
            $folderPath =  "../assets/images/bad_piece_image/".$gs;
            $newfolder = "../assets/images/bad_piece_image/".$bad_trace_id;

            if ($bad_trace_id > 0) {
                $temp_gid = $_SESSION['temp_gp_id'];
                $gid_arr = explode(',', $temp_gid);
                $g_str = '';
                $i = 0;
                foreach ($gid_arr as $gid) {
                    if (($i == 0) && ($gid != "")) {
                        $g_str = '\'' . $gid . '\'';
                        $i++;
                    } else if ($gid != "") {
                        $g_str .= ',' . '\'' . $gid . '\'';
                    }
                }
                rename( $folderPath, $newfolder) ;
                $sql = "update `good_piece_images` SET bad_piece_id = '$bad_trace_id' where bad_piece_id in ($g_str)";
                $result1 = mysqli_query($db, $sql);
                if ($result1) {
                    $_SESSION['temp_gp_id'] = '';
                }
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

            $qur04 = mysqli_query($db, "SELECT gbpd.bad_pieces_id as bad_pieces_id , gbpd.good_pieces as good_pieces, gbpd.defect_name as defect_name, gbpd.bad_pieces as bad_pieces ,gbpd.rework as rework FROM good_bad_pieces_details as gbpd where gbpd.station_event_id  = '$station_event_id' order by gbpd.bad_pieces_id DESC LIMIT 1");
            $rowc04 = mysqli_fetch_array($qur04);
            $bad_trace_id = $rowc04["bad_pieces_id"];


            $gs = $_SESSION['good_timestamp_id'];
            $folderPath =  "../assets/images/bad_piece_image/".$gs;
            $newfolder = "../assets/images/bad_piece_image/".$bad_trace_id;

            if ($bad_trace_id > 0) {
                $temp_gid = $_SESSION['temp_gp_id'];
                $gid_arr = explode(',', $temp_gid);
                $g_str = '';
                $i = 0;
                foreach ($gid_arr as $gid) {
                    if (($i == 0) && ($gid != "")) {
                        $g_str = '\'' . $gid . '\'';
                        $i++;
                    } else if ($gid != "") {
                        $g_str .= ',' . '\'' . $gid . '\'';
                    }
                }
                rename( $folderPath, $newfolder) ;
                $sql = "update `good_piece_images` SET bad_piece_id = '$bad_trace_id' where bad_piece_id in ($g_str)";
                $result1 = mysqli_query($db, $sql);
                if ($result1) {
                    $_SESSION['temp_gp_id'] = '';
                }
            }
        }
    }
    else
    {
        $sqlnumber = "SELECT * FROM `pm_part_number` where `pm_part_number_id` = '$part_number'";
        $resultnumber = $mysqli->query($sqlnumber);
        $rowcnumber = $resultnumber->fetch_assoc();
        $pm_part_number = $rowcnumber['part_number'];
        $pm_part_name = $rowcnumber['part_name'];
        $dir_path = "../assets/label_files/" . $line_id;
        $format_file =  file($dir_path . '/f1');
        $file =  file($dir_path . '/b_'.$f_postfix);
        $patterns = array();
        $patterns[0] = '/PartNo/';
        $patterns[1] = '/PartName/';
        $patterns[2] = '/Date/';
        $patterns[3] = '/UserName/';
        $patterns[4] = '/StationName/';
        $patterns[5] = '/Qty/';
        $replacements = array();
        $replacements[0] = $pm_part_number;
        $replacements[1] = $pm_part_name;
        $replacements[2] = $chicagotime;
        $replacements[3] = $user_fullname;
        $replacements[4] = $p_line_name;
        $replacements[5] = $label_quantity;
        file_put_contents('../assets/label_files/'. $line_id .'/b_'.$f_postfix, '');
        $output = preg_replace($patterns, $replacements, $format_file);
        file_put_contents('../assets/label_files/'. $line_id .'/b_'.$f_postfix, $output);
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
$editgood_name = $_POST['editgood_name'];
$editdefect_name = $_POST['editdefect_name'];
$editbad_name = $_POST['editbad_name'];
$editre_work = $_POST['editre_work'];
$edit_file = $_FILES['edit_image']['name'];

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
    $bad_pieces_id = $_POST['bad_pieces_id'];
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
        if($edit_file != "") {

            if (isset($_FILES['edit_image'])) {
                $totalfiles = count($_FILES['edit_image']['name']);
                if($totalfiles > 0 && $_FILES['edit_image']['name'][0] !='' && $_FILES['edit_image']['name'][0] != null){
                    for($i=0;$i<$totalfiles;$i++){
                        $errors = array();
                        $file_name = $_FILES['edit_image']['name'][$i];
                        $file_rename = $g_timestamp.'_'.$file_name;
                        $file_size = $_FILES['edit_image']['size'][$i];
                        $file_tmp = $_FILES['edit_image']['tmp_name'][$i];
                        $file_type = $_FILES['edit_image']['type'][$i];
                        $file_ext = strtolower(end(explode('.', $file_name)));
                        $extensions = array("jpeg", "jpg", "png", "pdf");
                        $data1 = file_get_contents($_FILES['edit_image']['tmp_name'][$i]);
                        $data1 = base64_encode($data1);
                        if (empty($errors) == true) {
                            move_uploaded_file($file_tmp, "../assets/images/bad_piece_image/" .$bad_pieces_id. '/'.$file_rename);

                            $sql = "INSERT INTO `good_piece_images`(`bad_piece_id`,`good_image_name`,`created_at`) VALUES ( '$bad_pieces_id' ,'$data1', '$chicagotime' )";
                            $result1 = mysqli_query($db, $sql);
                            if ($result1) {
                                $message_stauts_class = 'alert-success';
                                $import_status_message = 'Image Added Successfully.';
                                $_SESSION['good_timestamp_id'] = '';
                            } else {
                                $message_stauts_class = 'alert-danger';
                                $import_status_message = 'Error: Please Try Again.';
                            }

                        }
                    }
                }
            }
        }
    }
}
$page = $siteURL."events_module/good_bad_piece.php?station_event_id=$station_event_id";
header('Location: ' . $page, true, 303);
?>