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
    $location = "../assets/images/part_images/";
    $uploadOk = 1;
    $imageFileType = pathinfo($filename,PATHINFO_EXTENSION);
    $part_timestamp = time();
    $temp_pid = $_SESSION['temp_part_id'];
    $_SESSION['temp_part_id'] = $temp_pid . ',' .$part_timestamp;

    // Check image format
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        $uploadOk = 0;
    }

    if($uploadOk == 0){
        echo 0;
    }else{
        /* Upload file */
		$destination = $location .$part_timestamp.'_'. $fname;
		$f_name = $part_timestamp.'_'. $fname;
//        if(move_uploaded_file($_FILES['file']['name'],$location)){
        if( move_uploaded_file($file_tmp, $destination)){
            $sql = "INSERT INTO `material_images`(`material_id`,`image_name`,`created_at`) VALUES ('$part_timestamp','$f_name' , '$created_by' )";
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
        $sql = "DELETE FROM `material_images` where image_name ='$file1'";
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