<?php include("../config.php");
$request = $_POST['request'];
$created_by = date("Y-m-d H:i:s");
// Upload file
if($request == 1){

	$filename = $_FILES['file']['name'];
	$fname = str_replace(" ","",$filename);
	$file_size = $_FILES['file']['size'];
	$file_tmp = $_FILES['file']['tmp_name'];
	$file_type = $_FILES['file']['type'];
	/* Location */
	$location = "../assets/images/bad_piece_image/";
	$uploadOk = 1;
	$imageFileType = pathinfo($filename,PATHINFO_EXTENSION);
	$gp_timestamp = time();
	$temp_gpid = $_SESSION['temp_gp_id'];
	$_SESSION['temp_gp_id'] = $temp_gpid . ',' .$gp_timestamp;
	// if(empty($_SESSION['good_timestamp_id'])){
	$_SESSION['good_timestamp_id'] = $gp_timestamp;
	// }
	$gp_timestamp = $_SESSION['good_timestamp_id'] ;

	$data1 = file_get_contents($_FILES['file']['tmp_name']);
	$data1 = base64_encode($data1);
    $data11 = 'data:image/gif;base64,'.$data1;
	// Check image format

	//$uploadOk = 0;


	if($uploadOk == 0){
		echo 0;
	}else{
		/* Upload file */
		mkdir($location.'/'.$gp_timestamp, 0777, true);
		$f_name = $gp_timestamp.'_'. $fname;
		$destination = $location.$gp_timestamp .'_'. $fname;


//        if(move_uploaded_file($_FILES['file']['name'],$location)){
		if( move_uploaded_file($file_tmp, $destination)){
			$sql = "INSERT INTO `good_piece_images`(`bad_piece_id`,`good_image_name`,`created_at`) VALUES ('$gp_timestamp','$data11' , '$created_by' )";
			$result1 = mysqli_query($db, $sql);
			if ($result1) {
				echo $destination;
			}
		}else{
			echo 0;
		}
	}
	exit;
}

// Remove file
if($request == 2){
	$path = $_POST['path'];
	$file1 = basename($path);
	$img = file_get_contents($path);
	$data = base64_encode($img);
	$path = str_replace($siteURL,"../",$path);
	$return_text = 0;
//    $temp_mid = $_SESSION['temp_mt_id'];
//	$mid_arr = explode ( ',' , $temp_mid);
	// Check file exist or not
	if( file_exists($path) ){
		$sql = "DELETE FROM `good_piece_images` where good_image_name ='$data'";
		$result1 = mysqli_query($db, $sql);
		// Remove file
		unlink($path);

		// Set status
		if ($result1) {
			$return_text = 1;
		}
	}else{

		// Set status
		$return_text = 0;
	}

	// Return status
	echo $return_text;
	exit;
}