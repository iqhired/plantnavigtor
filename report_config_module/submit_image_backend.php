<?php include("../config.php");
$chicagotime = date("Y-m-d H:i:s");
$temp = "";
if (!isset($_SESSION['user'])) {
	if ($_SESSION['is_tab_user'] || $_SESSION['is_cell_login']) {
		header($redirect_tab_logout_path);
	} else {
		header($redirect_logout_path);
	}
}
//Set the session duration for 10800 seconds - 3 hours
$duration = $auto_logout_duration;
//Read the request time of the user
$time = $_SERVER['REQUEST_TIME'];
//Check the user's session exist or not
if (isset($_SESSION['LAST_ACTIVITY']) && ($time - $_SESSION['LAST_ACTIVITY']) > $duration) {
	//Unset the session variables
	session_unset();
	//Destroy the session
	session_destroy();
	if ($_SESSION['is_tab_user'] || $_SESSION['is_cell_login']) {
		header($redirect_tab_logout_path);
	} else {
		header($redirect_logout_path);
	}

//	header('location: ../logout.php');
	exit;
}
//Set the time of the user's last activity
$_SESSION['LAST_ACTIVITY'] = $time;
$i = $_SESSION["role_id"];
if ($i != "super" && $i != "admin" && $i != "pn_user" && $_SESSION['is_tab_user'] != 1 && $_SESSION['is_cell_login'] != 1) {
	header('location: ../dashboard.php');
}

    $created_by = $_SESSION['id'];
    $assets_id = $_POST['asset_id'];
    $station = $_POST['station'];
    $asset_name = $_POST['asset_name'];
    $notes = $_POST['notes'];
    $created_by_user = $_SESSION['id'];

    $sql2 = "INSERT INTO `submit_assets`(`asset_id`, `line_id`, `asset_name`,`notes`, `created_date`,`created_by`,`is_deleted`) VALUES ('$assets_id','$station','$asset_name','$notes','$chicagotime','$created_by_user','1')";
    $result2 = mysqli_query($db, $sql2);

    $sql1 = "SELECT submit_id as a_id FROM  submit_assets where line_id = '$station' ORDER BY `submit_id` DESC LIMIT 1";
    $result1 = mysqli_query($db, $sql1);
    $rowc04 = mysqli_fetch_array($result1);
    $a_trace_id = $rowc04["a_id"];
    $ts = $_SESSION['assets_timestamp_id'];
    $folderPath =  "../assets/images/assets_images/".$ts;
    $newfolder = "../assets/images/assets_images/".$a_trace_id;
    if ($result1) {
        rename( $folderPath, $newfolder) ;
        $sql = "update `station_assets_images` SET station_asset_id = '$a_trace_id' where station_asset_id = '$ts'";
        $result1 = mysqli_query($db, $sql);
        $_SESSION['timestamp_id'] = "";
        $_SESSION['message_stauts_class'] = 'alert-success';
        $_SESSION['import_status_message'] = 'Assets Created Sucessfully.';
    } else {
        $_SESSION['message_stauts_class'] = 'alert-danger';
        $_SESSION['import_status_message'] = 'Please retry';

    }

$page = "view_assets_config.php?id=$a_trace_id";
header('Location: ' . $page, true, 303);


?>