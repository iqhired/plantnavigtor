<?php
include("../config.php");
$delete_check = $_POST['delete_check'];
if ($delete_check != "") {
    $cnt = count($delete_check);
    for ($i = 0; $i < $cnt;) {
        $linename = "";
        $qur04 = mysqli_query($db, "SELECT * FROM  cam_assign_crew where `line_id`='$delete_check[$i]' ");
        $rowc04 = mysqli_fetch_array($qur04);
        $linename = $rowc04["assign_crew_id"];
        if ($linename == "") {
            $sql1 = "UPDATE `cam_line` SET `is_deleted`='1' WHERE `line_id`='$delete_check[$i]'";
            if (!mysqli_query($db, $sql1)) {
                $_SESSION['message_stauts_class'] = 'alert-danger';
                $_SESSION['import_status_message'] = 'Please retry';
            } else {
                $_SESSION['message_stauts_class'] = 'alert-success';
                $_SESSION['import_status_message'] = 'Station Deleted Sucessfully.';
            }
        } else {
            $_SESSION['message_stauts_class'] = 'alert-danger';
            $_SESSION['import_status_message'] = 'Crew Members needs to Unassigned before deleting the Line.';
        }
        $i++;
    }
} else {
    $_SESSION['message_stauts_class'] = 'alert-danger';
    $_SESSION['import_status_message'] = 'Please Select Station.';
}
header("Location:line.php");
?>
