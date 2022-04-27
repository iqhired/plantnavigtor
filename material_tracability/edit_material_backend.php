<?php

include("../config.php");
$array = json_decode($_POST['info']);
$drag_drop_res = (array) json_decode($array);
//echo "<pre>";print_r($drag_drop_res);

//echo "<pre>";
//print_r($_POST);
//echo "</pre>";

if(count($_POST)>0) {
    $form_id = $_POST['material_id'];
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
    $edit_file = $_FILES['edit_image']['name'];


    $sql0 = "UPDATE `material_tracability` SET `line_number`='$line_number',`part_number`='$part_number',`part_family`='$part_family',`part_name`='$part_name',`material_type`='$material_type',`serial_number`='$serial_number',`material_status`='$material_status',`fail_reason`='$fail_reason',`notes`='$notes',`created_at`='$created_by' WHERE `material_id` = '$form_id'";
    $result0 = mysqli_query($db, $sql0);
    if ($result0) {
        $_SESSION['message_stauts_class'] = 'alert-success';
        $_SESSION['import_status_message'] = 'Form Updated Sucessfully.';
    } else {
        $_SESSION['message_stauts_class'] = 'alert-danger';
        $_SESSION['import_status_message'] = 'Please retry';
    }


    $qur04 = mysqli_query($db, "SELECT * FROM  material_tracability where material_id= '$form_id' ");
    $rowc04 = mysqli_fetch_array($qur04);
    $material_id = $rowc04["material_id"];


//multiple image
    if($edit_file != "") {
        if (isset($_FILES['edit_image'])) {

            $totalfiles = count($_FILES['edit_image']['name']);

            if($totalfiles > 0 && $_FILES['edit_image']['name'][0] !='' && $_FILES['edit_image']['name'][0] != null){
                for($i=0;$i<$totalfiles;$i++){

                    $errors = array();
                    $file_name = $_FILES['edit_image']['name'][$i];
                    $file_size = $_FILES['edit_image']['size'][$i];
                    $file_tmp = $_FILES['edit_image']['tmp_name'][$i];
                    $file_type = $_FILES['edit_image']['type'][$i];
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
                        $import_status_message = 'Error: File size must be less than 2 MB';
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

        }
    }


}
//header("Location:form_edit.php?id=$hidden_id");
$page = "edit_material.php?id=$form_id";
header('Location: '.$page, true, 303);
exit;

?>