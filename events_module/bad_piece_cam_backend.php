<?php
include("../config.php");
$img = $_POST['image'];
$folderPath = "../assets/images/bad_piece_image/";
$created_by = date("Y-m-d H:i:s");

$image_parts = explode(";base64,", $img);
$image_type_aux = explode("image/", $image_parts[0]);
$image_type = $image_type_aux[1];

$image_base64 = base64_decode($image_parts[1]);
$fileName = uniqid() . '.png';
$gp_timestamp = time();

$temp_gid = $_SESSION['temp_gp_id'];
$_SESSION['temp_gp_id'] = $temp_gid . ',' .$gp_timestamp;
$g_id = $_GET['bad_pieces_id'];

if(empty($g_id)){
    $g_id = $_POST['bad_pieces_id'];
}

if(empty($g_id) && empty($_SESSION['good_timestamp_id'])){
    $_SESSION['good_timestamp_id'] = $gp_timestamp;
}
if(!empty($g_id)) {
    $_SESSION['good_timestamp_id'] = $_GET['bad_pieces_id'];
    $timestamp = $_SESSION['good_timestamp_id'];
    $file = $folderPath . '/' . $g_id . '/' . $gp_timestamp . '_' . $fileName;
    $file_name = $gp_timestamp . '_' . $fileName;
    file_put_contents($file, $image_base64);
    if (file_put_contents($file, $image_base64)) {
        $sql = "INSERT INTO `good_piece_images`(`bad_piece_id`,`good_image_name`,`created_at`) VALUES ('$g_id','$img' , '$created_by')";
        $result1 = mysqli_query($db, $sql);
        if ($result1) {
            echo $file;
        }
    }
}else{

    $timestamp = $_SESSION['good_timestamp_id'];
    $file = $folderPath.'/'.$timestamp.'/'.$gp_timestamp.'_'. $fileName;
    $file_name = $gp_timestamp.'_'. $fileName;
    mkdir($folderPath.'/'.$timestamp, 0777, true);
    file_put_contents($file, $image_base64);
    if(file_put_contents($file, $image_base64)){
        $sql = "INSERT INTO `good_piece_images`(`bad_piece_id`,`good_image_name`,`created_at`) VALUES ('$timestamp','$img' ,'$created_by')";
        $result1 = mysqli_query($db, $sql);
        if ($result1) {
            echo $file;
        }
    }
}
