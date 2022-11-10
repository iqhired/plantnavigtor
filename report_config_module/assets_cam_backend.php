<?php
include("../config.php");
$created_by = date("Y-m-d H:i:s");
$img = $_POST['image'];
$folderPath = "../assets/images/assets_images/";

$image_parts = explode(";base64,", $img);
$image_type_aux = explode("image/", $image_parts[0]);
$image_type = $image_type_aux[1];

$image_base64 = base64_decode($image_parts[1]);
$fileName = uniqid() . '.png';
$a_timestamp = time();

$temp_aid = $_SESSION['temp_assets_id'];
$_SESSION['temp_assets_id'] = $temp_aid . ',' .$a_timestamp;
$a_id = $_GET['assets_id'];

if(empty($a_id)){
    $a_id = $_POST['asset_id'];
}
if(empty($a_id) && empty($_SESSION['assets_timestamp_id'])){
    $_SESSION['assets_timestamp_id'] = $a_timestamp;
}
if(!empty($a_id)) {
    $_SESSION['assets_timestamp_id'] = $_GET['assets_id'];
    $timestamp = $_SESSION['assets_timestamp_id'];
    $file = $folderPath . '/' . $a_id . '/' . $a_timestamp . '_' . $fileName;
    $file_name = $a_timestamp . '_' . $fileName;
    file_put_contents($file, $image_base64);
    if(file_put_contents($file, $image_base64)){
        $sql = "INSERT INTO `station_assets_images`(`station_asset_id`,`station_asset_image`,`created_at`,`image_type`) VALUES ('$a_id','$img' , '$created_by','S')";
        $result1 = mysqli_query($db, $sql);
        if ($result1) {
            echo $file;
        }
}

}else{

    $timestamp = $_SESSION['assets_timestamp_id'];
    $file = $folderPath.'/'.$timestamp.'/'.$a_timestamp.'_'. $fileName;
    $file_name = $a_timestamp.'_'. $fileName;
    mkdir($folderPath.'/'.$timestamp, 0777, true);
    file_put_contents($file, $image_base64);
    if(file_put_contents($file, $image_base64)){
        $sql = "INSERT INTO `station_assets_images`(`station_asset_id`,`station_asset_image`,`created_at`,`image_type`) VALUES ('$timestamp','$img' ,'$created_by','S')";
        $result1 = mysqli_query($db, $sql);
        if ($result1) {
            echo $file;
        }
    }
}

//print_r($fileName);

?>