<?php
include("../config.php");
use PHPMailer\PHPMailer\PHPMailer;

require '../vendor/autoload.php';
$array = json_decode($_POST['info']);
$drag_drop_res = (array) json_decode($array);
//echo "<pre>";print_r($drag_drop_res);

//echo "<pre>";
//print_r($_POST);
//echo "</pre>";

if(count($_POST)>0) {
    $x_id = $_POST['10x_id'];
    $station_event_id = $_POST['station_event_id'];
    $customer_account_id = $_POST['customer_account_id'];
    $line_number = $_POST['line_number'];
    $part_number = $_POST['part_number'];
    $part_family = $_POST['part_family'];
    $part_name = $_POST['part_name'];
    $notes = $_POST['10x_notes'];
    $created_by = date("Y-m-d H:i:s");
    $edit_file = $_FILES['edit_image']['name'];
	$updated_by_user = $_SESSION['id'];
    $edit_10x_id =  $_SESSION['edit_10x_id'];
    $x_timestamp = time();

    //$sql0 = "UPDATE `material_tracability` SET `line_number`='$line_number',`part_number`='$part_number',`part_family`='$part_family',`part_name`='$part_name',`material_type`='$material_type',`serial_number`='$serial_number',`material_status`='$material_status',`fail_reason`='$fail_reason',`reason_desc`='$reason_desc',`quantity`='$quantity',`notes`='$notes',`created_at`='$created_by' WHERE `material_id` = '$form_id'";
	$sql0 = "UPDATE `10x` SET `created_by`='$updated_by_user',`line_no`='$line_number',`part_no`='$part_number',`part_family_id`='$part_family',`part_name`='$part_name',`notes`='$notes',`created_at`='$created_by' WHERE `10x_id` = '$x_id'";
    $result0 = mysqli_query($db, $sql0);
    if ($result0) {
        $_SESSION['message_stauts_class'] = 'alert-success';
        $_SESSION['import_status_message'] = '10x Updated Sucessfully.';
    } else {
        $_SESSION['message_stauts_class'] = 'alert-danger';
        $_SESSION['import_status_message'] = 'Please retry';
    }
//    $qur04 = mysqli_query($db, "SELECT * FROM  10x where 10x_id= '$x_id' ");
//    $rowc04 = mysqli_fetch_array($qur04);
//    $x1_id = $rowc04["10x_id"];

//multiple image
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
    if(empty($_SESSION['timestamp_id'])){
        $_SESSION['timestamp_id'] = $x_timestamp;
    }

    $timestamp = $_SESSION['timestamp_id'];
    $file = $folderPath.'/'.$edit_10x_id.'/'.$timestamp.'_'. $fileName;
    $file_name = $timestamp.'_'. $fileName;
  //  mkdir($folderPath.'/'.$timestamp, 0777, true);
    file_put_contents($file, $image_base64);
    if(file_put_contents($file, $image_base64)){

        $sql = "INSERT INTO `10x_images`(`10x_id`,`image_name`,`created_at`) VALUES ('$edit_10x_id','$file_name' , '$created_by' )";
        $result1 = mysqli_query($db, $sql);
        if ($result1) {
            echo $file;

        }

    }

}
//header("Location:form_edit.php?id=$hidden_id");
$page = "edit_10x.php?id=$x_id";
header('Location: '.$page, true, 303);
exit;

?>