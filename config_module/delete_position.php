<?php
include("../config.php");
$delete_check = $_POST['delete_check'];
if ($delete_check != "") {
    $cnt = count($delete_check);
    for ($i = 0; $i < $cnt;) {
        $posname = "";
        $qur04 = mysqli_query($db, "SELECT * FROM  cam_assign_crew where `position_id`='$delete_check[$i]' ");
        $rowc04 = mysqli_fetch_array($qur04);
        $posname = $rowc04["assign_crew_id"];
        if ($posname == "") {
            $sql1 = "UPDATE `cam_position` SET `is_deleted`='1' WHERE `position_id`='$delete_check[$i]'";
            if (!mysqli_query($db, $sql1)) {
                $_SESSION['message_stauts_class'] = 'alert-danger';
                $_SESSION['import_status_message'] = 'Please Try Again.';
            } else {
                $_SESSION['message_stauts_class'] = 'alert-success';
                $_SESSION['import_status_message'] = 'Position Deleted Sucessfully.';
            }
        } else {
            $_SESSION['message_stauts_class'] = 'alert-danger';
            $_SESSION['import_status_message'] = 'Crew Members needs to Unassigned before deleting the Position.';
        }
        $i++;
    }
} else {
    $_SESSION['message_stauts_class'] = 'alert-danger';
    $_SESSION['import_status_message'] = 'Please Select Position.';
}
header("Location:position.php");
?>
