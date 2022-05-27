<?php
include("../config.php");
$request = $_POST['request'];
$created_by = date("Y-m-d H:i:s");
// Upload file
if($request == 1){

    $filename = $_FILES['file']['name'];
    /* Location */
    $location = "../assets/images/mt/timestamp/".$filename;
    $uploadOk = 1;
    $imageFileType = pathinfo($location,PATHINFO_EXTENSION);

    // Check image format
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        $uploadOk = 0;
    }

    if($uploadOk == 0){
        echo 0;
    }else{
        /* Upload file */

        if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
            $sql = "INSERT INTO `material_images`(`image_name`,`created_at`) VALUES ('$filename' , '$created_by' )";
            $result1 = mysqli_query($db, $sql);
            if ($result1) {
                echo $location;
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

    $return_text = 0;

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