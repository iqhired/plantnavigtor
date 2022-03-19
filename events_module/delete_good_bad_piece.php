<?php
//include("../database_config.php");
include("../config.php");
$station_event_id = $_POST['station_event_id'];
$delete_check = $_POST['delete_check'];
if ($delete_check != "") {
    $cnt = count($delete_check);
    for ($i = 0; $i < $cnt;) {

        $sql = "select * from good_bad_pieces_details where bad_pieces_id ='$delete_check[$i]'";
//		$sql = "select * from good_bad_pieces where station_event_id ='$station_event_id' and event_status = '1' and defect_name = '$add_defect_name'";
        $result1 = mysqli_query($db, $sql);
        $rowc = mysqli_fetch_array($result1);
        $gp = (($rowc['good_pieces'] == null) || ($rowc['good_pieces'] == "" ) )?0:$rowc['good_pieces'] ;;
        $bp = (($rowc['bad_pieces'] == null) || ($rowc['bad_pieces'] == "" ) )?0:$rowc['bad_pieces'] ;;
        $rw = (($rowc['rework'] == null) || ($rowc['rework'] == "" ) )?0:$rowc['rework'] ;;
        $station_event_id = $rowc['station_event_id'];
        $sql1 = "DELETE FROM `good_bad_pieces_details` WHERE `bad_pieces_id`='$delete_check[$i]'";
        if (!mysqli_query($db, $sql1)) {
            echo "Invalid Data";
        } else {
            $_SESSION['message_stauts_class'] = 'alert-success';
            $_SESSION['import_status_message'] = 'Data Deleted Sucessfully.';
            $sql1 = "update good_bad_pieces set good_pieces = (good_pieces - '$gp') ,bad_pieces = (bad_pieces - '$bp'),rework = (rework - '$rw') , modified_at = '$chicagotime' where station_event_id ='$station_event_id' and event_status = '1'";
            $result11 = mysqli_query($db, $sql1);
        }
        $i++;
    }
} else {
    $_SESSION['message_stauts_class'] = 'alert-danger';
    $_SESSION['import_status_message'] = 'Please Select Atleast one row.';
}
header("Location:good_bad_piece.php?station_event_id=$station_event_id");

?>
