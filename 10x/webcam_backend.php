<?php
include("../config.php");
$created_by = date("Y-m-d H:i:s");
$img = $_POST['image'];
$folderPath =  "../assets/images/10x/";

$image_parts = explode(";base64,", $img);
$image_type_aux = explode("image/", $image_parts[0]);
$image_type = $image_type_aux[1];

$image_base64 = base64_decode($image_parts[1]);
$fileName = uniqid() . '.png';

$x_timestamp = time();
$temp_xid = $_SESSION['temp_10x_id'];
$_SESSION['temp_10x_id'] = $temp_xid . ',' .$x_timestamp;
$x_id = $_GET['10x_id'];
if(empty($x_id)){
    $x_id = $_POST['10x_id'];
}
if(empty($x_id) && empty($_SESSION['timestamp_id'])){
    $_SESSION['timestamp_id'] = $x_timestamp;
}
if(!empty($x_id)) {
    $_SESSION['timestamp_id'] = $_GET['10x_id'];
    $timestamp = $_SESSION['timestamp_id'];
    $file = $folderPath . '/' . $x_id . '/' . $x_timestamp . '_' . $fileName;
    $file_name = $x_timestamp . '_' . $fileName;
    file_put_contents($file, $image_base64);
    if (file_put_contents($file, $image_base64)) {

        $sql = "INSERT INTO `10x_images`(`10x_id`,`image_name`,`created_at`) VALUES ('$x_id','$file_name' , '$created_by' )";
        $result1 = mysqli_query($db, $sql);
        if ($result1) {
            echo $file;
        }
    }
}else{
    $timestamp = $_SESSION['timestamp_id'];
    $file = $folderPath.'/'.$timestamp.'/'.$x_timestamp.'_'. $fileName;
    $file_name = $x_timestamp.'_'. $fileName;
    mkdir($folderPath.'/'.$timestamp, 0777, true);
    file_put_contents($file, $image_base64);
    if(file_put_contents($file, $image_base64)){

        $sql = "INSERT INTO `10x_images`(`10x_id`,`image_name`,`created_at`) VALUES ('$timestamp','$file_name' , '$created_by' )";
        $result1 = mysqli_query($db, $sql);
        if ($result1) {
            echo $file;
        }
    }
}



//print_r($fileName);

?>
