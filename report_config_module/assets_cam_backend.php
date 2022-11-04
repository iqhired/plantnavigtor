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
$x_timestamp = time();

$x_id = $_GET['asset_id'];
if(empty($x_id)){
    $x_id = $_POST['asset_id'];
}
if(empty($x_id) && empty($_SESSION['timestamp_id'])){
    $_SESSION['timestamp_id'] = $x_timestamp;
}

$file = $folderPath . '/' . $x_timestamp . '_' . $fileName;
$file_name = $x_timestamp . '_' . $fileName;
file_put_contents($file, $image_base64);
if(file_put_contents($file, $image_base64)){
    $sql = "INSERT INTO `assets_images`(`id`,`image_name`,`created_at`) VALUES ('$x_id','$file_name' , '$created_by' )";
    $result1 = mysqli_query($db, $sql);
    if ($result1) {
        echo $file;
    }
}

print_r($fileName);

?>