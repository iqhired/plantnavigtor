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
    $location = "../document_files/";
    $uploadOk = 1;
    $imageFileType = pathinfo($filename,PATHINFO_EXTENSION);
    $doc_timestamp = time();
   // $temp_docid = $_SESSION['temp_doc_id'];
    $_SESSION['temp_doc_id'] = $doc_timestamp;
	if(empty($_SESSION['timestamp_id'])){
		$_SESSION['timestamp_id'] = $doc_timestamp;
	}
	$doc_timestamp = $_SESSION['timestamp_id'] ;
    $rename_file = $_POST['rename'];

	// Check image format
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" && $imageFileType != "pdf" && $imageFileType != "JPG" && $imageFileType != "JPEG" && $imageFileType != "PDF") {
        $uploadOk = 0;
    }


    if($uploadOk == 0){
        echo 0;
    }else{
        /* Upload file */
		mkdir($location.'/'.$doc_timestamp, 0777, true);
		$f_name =  $doc_timestamp.'_'.$fname;
		$destination = $location.$doc_timestamp.'/'.$f_name;
//        if(move_uploaded_file($_FILES['file']['name'],$location)){
        if( move_uploaded_file($file_tmp, $destination)){
            $sql = "INSERT INTO `document_files`(`file_name`,`doc_id`,`part_number`,`station`,`created_at`) VALUES ('$f_name','$doc_timestamp','$part_number' ,'$station','$created_by' )";
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
        $sql = "DELETE FROM `document_files` where file_name ='$file1'";
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