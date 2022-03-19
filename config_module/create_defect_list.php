<?php
//include("../database_config.php");
include("../config.php");
$chicagotime = date("Y-m-d H:i:s");

    $name = $_POST['name'];
	$array_part_numbers = null;
	$part_numbers = $_POST['part_number'];
	foreach ($part_numbers as $part_number) {
		$array_part_numbers .= $part_number . ",";
	}

    if ($name != "") {
        $name = $_POST['name'];
        $sqlquery = "INSERT INTO `defect_list`(`defect_list_name`,`part_number_id`,`created_at`,`updated_at`) VALUES ('$name','$array_part_numbers','$chicagotime','$chicagotime')";
        if (!mysqli_query($db, $sqlquery)) {
			$_SESSION['message_stauts_class'] = 'alert-danger';
			$_SESSION['import_status_message'] = 'Error: Defect List with this Name Already Exists';
        } else {
            $_SESSION['message_stauts_class'] = 'alert-success';
            $_SESSION['import_status_message'] = 'Defect List Created Sucessfully.';
        }
    }
header("Location:defect_list.php");
?>
