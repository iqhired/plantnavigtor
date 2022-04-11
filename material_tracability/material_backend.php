<?php
include("../config.php");
$array = json_decode($_POST['info']);
$drag_drop_res = (array) json_decode($array);

if(count($_POST)>0) {
    $station_event_id = $_POST['station_event_id'];
    $customer_account_id = $_POST['customer_account_id'];
    $line_number = $_POST['line_number'];
    $part_number = $_POST['part_number'];
    $part_family = $_POST['part_family'];
    $part_name = $_POST['part_name'];
    $serial_number = $_POST['serial_number'];
    $material_type = $_POST['material_type'];
    $material_status = $_POST['material_status'];
    $fail_reason = $_POST['reason'];
    $notes = $_POST['material_notes'];
    $created_by = date("Y-m-d H:i:s");


      $sql0 = "INSERT INTO `material_tracability`(`station_event_id`,`customer_account_id`,`line_number`,`part_number`,`part_family`,`part_name`,`material_type`,`serial_number`,`material_status`,`fail_reason`,`notes`,`created_at`) VALUES 
	        	('$station_event_id','$customer_account_id','$line_number' , ' $part_number' ,'$part_family',' $part_name','$material_type','$serial_number','$material_status' , '$fail_reason','$notes','$created_by')";
                $result0 = mysqli_query($db, $sql0);
                if ($result0) {
                    $_SESSION['message_stauts_class'] = 'alert-success';
                    $_SESSION['import_status_message'] = 'Material tracability Created Sucessfully.';
                } else {
                    $_SESSION['message_stauts_class'] = 'alert-danger';
                    $_SESSION['import_status_message'] = 'Please retry';

         }
    }


    $qur04 = mysqli_query($db, "SELECT * FROM  material_tracability where line_number= '$line_number' ORDER BY `material_id` DESC ");
    $rowc04 = mysqli_fetch_array($qur04);
    $material_id = $rowc04["material_id"];


//multiple image
        if (isset($_FILES['image'])) {

        foreach($_FILES['image']['name'] as $key=>$val ){
            $errors = array();
            $file_name = $_FILES['image']['name'][$key];
            $file_size = $_FILES['image']['size'][$key];
            $file_tmp = $_FILES['image']['tmp_name'][$key];
            $file_type = $_FILES['image']['type'][$key];
            $file_ext = strtolower(end(explode('.', $file_name)));
            $extensions = array("jpeg", "jpg", "png", "pdf");
            if (in_array($file_ext, $extensions) === false) {
                $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
                $message_stauts_class = 'alert-danger';
                $import_status_message = 'Error: Extension not allowed, please choose a JPEG or PNG file.';
            }
            if ($file_size > 2097152) {
                $errors[] = 'File size must be excately 2 MB';
                $message_stauts_class = 'alert-danger';
                $import_status_message = 'Error: File size must be excately 2 MB';
            }
            if (empty($errors) == true) {
                move_uploaded_file($file_tmp, "../material_images/" . $file_name);

                $sql = "INSERT INTO `material_images`(`image_name`,`material_id`,`created_at`) VALUES ('$file_name' , '$material_id' , '$created_by' )";

                $result1 = mysqli_query($db, $sql);
                if ($result1) {
                    $message_stauts_class = 'alert-success';
                    $import_status_message = 'Image Added Successfully.';
                } else {
                    $message_stauts_class = 'alert-danger';
                    $import_status_message = 'Error: Please Try Again.';
                }
            }

        }
    }

$finalstation=urlencode( base64_encode($station_event_id));
$page = "material_tracability.php?station=$line_number;&station_event_id=$finalstation;";
header('Location: '.$page, true, 303);
exit;
