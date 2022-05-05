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
    $quantity = $_POST['quantity'];
    $reason_desc = $_POST['reason_desc'];
    $notes = $_POST['material_notes'];
    $created_by = date("Y-m-d H:i:s");


      $sql0 = "INSERT INTO `material_tracability`(`station_event_id`,`customer_account_id`,`line_number`,`part_number`,`part_family`,`part_name`,`material_type`,`serial_number`,`material_status`,`fail_reason`,`reason_desc`,`quantity`,`notes`,`created_at`) VALUES 
	        	('$station_event_id','$customer_account_id','$line_number' , ' $part_number' ,'$part_family',' $part_name','$material_type','$serial_number','$material_status' , '$fail_reason','$reason_desc','$quantity','$notes','$created_by')";
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
        $totalfiles = count($_FILES['image']['name']);
            if($totalfiles > 0 && $_FILES['image']['name'][0] !='' && $_FILES['image']['name'][0] != null){
                for($i=0;$i<$totalfiles;$i++) {
                    $errors = array();
                    $file_name = $_FILES['image']['name'][$i];
                    $file_rename = "material_id_".$material_id."_".$file_name;
                    $file_size = $_FILES['image']['size'][$i];
                    $file_tmp = $_FILES['image']['tmp_name'][$i];
                    $file_type = $_FILES['image']['type'][$i];
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
                        move_uploaded_file($file_tmp, "../material_images/" . "material_id_".$material_id."_".$file_name);

                        $sql = "INSERT INTO `material_images`(`image_name`,`material_id`,`created_at`) VALUES ('$file_rename' , '$material_id' , '$created_by' )";

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
    }


$page = "material_search.php";
header('Location: '.$page, true, 303);
exit;
