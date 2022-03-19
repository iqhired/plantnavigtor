<?php
//include("../database_config.php");
include("../config.php");
$chicagotime = date("Y-m-d H:i:s");

	$edit_name = $_POST['edit_name'];
	$part_numbers = $_POST['def_edit_part_number'];
	foreach ($part_numbers as $part_number) {
		$array_part_numbers .= $part_number . ",";
	}
    if ($edit_name != "") {
        $id = $_POST['def_edit_id'];
        $sql = "update defect_list set defect_list_name='$_POST[edit_name]',part_number_id='$array_part_numbers',updated_at='$chicagotime' where defect_list_id ='$id'";
        $result1 = mysqli_query($db, $sql);
        if ($result1) {
            $_SESSION['message_stauts_class'] = 'alert-success';
            $_SESSION['import_status_message'] = 'Defect List Updated Sucessfully.';
        } else {
			$_SESSION['message_stauts_class'] = 'alert-danger';
			$_SESSION['import_status_message'] = 'Error: Please Retry';
        }
    }

header("Location:defect_list.php");
?>
