<?php
include("../config.php");
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
	$location = "../assets/images/10x/";
	$uploadOk = 1;
	$imageFileType = pathinfo($filename,PATHINFO_EXTENSION);
	$x_timestamp = time();
	$temp_xid = $_SESSION['temp_10x_id'];
	$_SESSION['temp_10x_id'] = $temp_xid . ',' .$x_timestamp;
	if(empty($_SESSION['timestamp_id'])){
		$_SESSION['timestamp_id'] = $x_timestamp;
	}
	$x_timestamp = $_SESSION['timestamp_id'] ;

	// Check image format
	// if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	//     && $imageFileType != "gif" ) {
	//     $uploadOk = 0;
	//     compressImage($file_tmp,$location,60);
	// }

	// Compress image
	// function compressImage($source, $destination, $quality) {
	//     $info = getimagesize($source);
	//     if ($info['mime'] == 'image/jpeg')
	//         $image = imagecreatefromjpeg($source);
	//     elseif ($info['mime'] == 'image/gif')
	//         $image = imagecreatefromgif($source);
	//     elseif ($info['mime'] == 'image/png')
	//         $image = imagecreatefrompng($source);
	//     imagejpeg($image, $destination, $quality);
	// }

	if($uploadOk == 0){
		echo 0;
	}else{
		/* Upload file */
		mkdir($location.'/'.$x_timestamp, 0777, true);
		$f_name =  $x_timestamp.'_'.$fname;
		$destination = $location.$x_timestamp.'/'.$f_name;

//        if(move_uploaded_file($_FILES['file']['name'],$location)){

		if( move_uploaded_file($file_tmp, $destination)){
			$sql = "INSERT INTO `10x_images`(`10x_id`,`image_name`,`created_at`) VALUES ('$x_timestamp','$f_name' , '$created_by' )";
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
	$path = str_replace($siteURL,"../",$path);
	$return_text = 0;
//    $temp_mid = $_SESSION['temp_mt_id'];
//	$mid_arr = explode ( ',' , $temp_mid);
	// Check file exist or not
	if( file_exists($path) ){
		$sql = "DELETE FROM `10x_images` where image_name ='$file1'";
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