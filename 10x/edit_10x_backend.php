<?php
include("../config.php");
use PHPMailer\PHPMailer\PHPMailer;

require '../vendor/autoload.php';
$array = json_decode($_POST['info']);
$drag_drop_res = (array) json_decode($array);
$x_timestamp = time();
//echo "<pre>";print_r($drag_drop_res);

//echo "<pre>";
//print_r($_POST);
//echo "</pre>";

if(count($_POST)>0 || count($_GET)>0) {
    $x_id = $_GET['10x_id'];
    if(empty($x_id)){
		$x_id = $_POST['10x_id'];
	}
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
        $_SESSION['import_status_message'] = '10x Form Updated Sucessfully.';
    } else {
        $_SESSION['message_stauts_class'] = 'alert-danger';
        $_SESSION['import_status_message'] = 'Please retry';
    }
//    $qur04 = mysqli_query($db, "SELECT * FROM  material_tracability where material_id= '$material_id' ");
//    $rowc04 = mysqli_fetch_array($qur04);
//    $material_id = $rowc04["material_id"];

//multiple image
    if($edit_file != "") {
        if (isset($_FILES['edit_image'])) {
            $totalfiles = count($_FILES['edit_image']['name']);
            if($totalfiles > 0 && $_FILES['edit_image']['name'][0] !='' && $_FILES['edit_image']['name'][0] != null){
                for($i=0;$i<$totalfiles;$i++){
                    $errors = array();
                    $file_name = $_FILES['edit_image']['name'][$i];
                    $file_rename = $x_timestamp.'_'.$file_name;
                    $file_size = $_FILES['edit_image']['size'][$i];
                    $file_tmp = $_FILES['edit_image']['tmp_name'][$i];
                    $file_type = $_FILES['edit_image']['type'][$i];
                    $file_ext = strtolower(end(explode('.', $file_name)));
                    $extensions = array("jpeg", "jpg", "png", "pdf");
//                    if (in_array($file_ext, $extensions) === false) {
//                        $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
//                        $message_stauts_class = 'alert-danger';
//                        $import_status_message = 'Error: Extension not allowed, please choose a JPEG or PNG file.';
//                    }
//                    if ($file_size > 2097152) {
//                        $errors[] = 'File size must be excately 2 MB';
//                        $message_stauts_class = 'alert-danger';
//                        $import_status_message = 'Error: File size must be less than 2 MB';
//                    }
                    if (empty($errors) == true) {
                        move_uploaded_file($file_tmp, "../assets/images/10x/" .$x_id. '/'.$file_rename);

                        $sql = "INSERT INTO `10x_images`(`10x_id`,`image_name`,`created_at`) VALUES ( '$x_id' ,'$file_rename', '$created_by' )";
                        $result1 = mysqli_query($db, $sql);
                        if ($result1) {
                            $message_stauts_class = 'alert-success';
                            $import_status_message = 'Image Added Successfully.';
							$_SESSION['timestamp_id'] = '';
                        } else {
                            $message_stauts_class = 'alert-danger';
                            $import_status_message = 'Error: Please Try Again.';
                        }


                    }

                }
            }

        }
    }



}
//header("Location:form_edit.php?id=$hidden_id");
$page = "edit_10x.php?id=$x_id";
header('Location: '.$page, true, 303);
exit;

?>