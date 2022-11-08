<?php include("../config.php");
$request = $_POST['request'];
$created_by = date("Y-m-d H:i:s");

if ($request == 1) {
    $id = $_GET['asset_id'];
    $filename = $_FILES['file']['name'];
    $fname = str_replace(" ", "", $filename);
    $file_size = $_FILES['file']['size'];
    $file_tmp = $_FILES["file"]["tmp_name"];

    $file_type = $_FILES['file']['type'];
    $location = "../assets/images/assets_images/";
    $uploadOk = 1;
    $imageFileType = pathinfo($filename, PATHINFO_EXTENSION);
    $asset_timestamp = time();
    $temp_aid = $_SESSION['temp_assets_id'];
    $_SESSION['temp_assets_id'] = $temp_aid . ',' .$asset_timestamp;
    if(empty($_SESSION['assets_timestamp_id'])){
        $_SESSION['assets_timestamp_id'] = $asset_timestamp;
    }
    $asset_timestamp = $_SESSION['assets_timestamp_id'] ;
    $data1 = file_get_contents($_FILES['file']['tmp_name']);
    $data1 = base64_encode($data1);
    if ($uploadOk == 0) {
        echo 0;
    } else {
        /* Upload file */
        mkdir($location.'/'.$asset_timestamp, 0777, true);
        $f_name =  $asset_timestamp.'_'.$fname;
        $destination = $location.$asset_timestamp.'/'.$f_name;
        /*$img = file_get_contents();
        $hex_string = ;*/
        if (move_uploaded_file($file_tmp, $destination)) {


            $sql = "INSERT INTO `update_asset_images`(`image_name`,`asset_create_id`,`created_at`) VALUES ('$data1','$a_id' ,'$created_by' )";
            $result1 = mysqli_query($db, $sql);
            if ($result1) {
                echo $destination;
            }
        } else {
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
        $sql = "DELETE FROM `update_asset_images` where image_name ='$file1'";
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



