<?php

include("../config.php");
$array = json_decode($_POST['info']);
$drag_drop_res = (array) json_decode($array);

if(count($_POST)>0) {
    $line_number = $_POST['line_number'];
    $material_type = $_POST['material_type'];
    $material_status = $_POST['material_status'];
    $out_of_tolerance_mail_list1 = $_POST['out_of_tolerance_mail_list'];
    $out_of_control_list1 = $_POST['out_of_control_list'];
    $notes = $_POST['material_notes'];
    $time_stamp = $_POST['time_stamp'];
    $created_by = date("Y-m-d H:i:s");
    foreach ($out_of_tolerance_mail_list1 as $out_of_tolerance_mail_list) {
        $array_out_of_tolerance_mail_list .= $out_of_tolerance_mail_list . ",";
    }
    foreach ($out_of_control_list1 as $out_of_control_list) {
        $array_out_of_control_list .= $out_of_control_list . ",";
    }

    $sql0 = "INSERT INTO `material_tracability`(`line_number`,`material_type`,`material_status`,`tolerance_mail_list`,`control_list`,`notes`,`timestamp`,`created_at`) VALUES 
		('$line_number' , '$material_type' ,'$material_status' , '$array_out_of_tolerance_mail_list' , '$array_out_of_control_list' , '$notes','$time_stamp','$created_by')";
    $result0 = mysqli_query($db, $sql0);
    if ($result0) {
        $_SESSION['message_stauts_class'] = 'alert-success';
        $_SESSION['import_status_message'] = 'Material tracability Created Sucessfully.';
    } else {
        $_SESSION['message_stauts_class'] = 'alert-danger';
        $_SESSION['import_status_message'] = 'Please retry';
    }
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
                move_uploaded_file($file_tmp, "../form_images/" . $file_name);

                $sql = "INSERT INTO `form_images`(`image_name`,`form_create_id`,`created_at`) VALUES ('$file_name' , '$form_create_id' , '$created_by' )";

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