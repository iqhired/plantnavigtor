<?php
include("../config.php");
$array = json_decode($_POST['info']);
$drag_drop_res = (array) json_decode($array);

if(count($_POST)>0) {
    $doc_name = $_POST['doc_name'];
    $doc_type = $_POST['doc_type'];
    $station = $_POST['station'];
    $category = $_POST['category'];
    $part_number = $_POST['part_number'];
    $status = $_POST['status'];
    $exp_date = $_POST['exp_date'];
    $created_by = date("Y-m-d H:i:s");


    $sql0 = "INSERT INTO `document_data`(`doc_name`,`station`,`doc_type`,`doc_category`,`part_number`,`status`,`expiry_date`,`created_at`) VALUES 
	        	('$doc_name','$station','$doc_type' ,'$category',' $part_number' ,'$status',' $exp_date','$created_by')";
    $result0 = mysqli_query($db, $sql0);
    if ($result0) {
        $_SESSION['message_stauts_class'] = 'alert-success';
        $_SESSION['import_status_message'] = 'Document Created Sucessfully.';
    } else {
        $_SESSION['message_stauts_class'] = 'alert-danger';
        $_SESSION['import_status_message'] = 'Please retry';

    }
}


$qur04 = mysqli_query($db, "SELECT * FROM  document_data where doc_name = '$doc_name' ORDER BY `doc_id` DESC ");
$rowc04 = mysqli_fetch_array($qur04);
$material_id = $rowc04["doc_id"];


//multiple image
if (isset($_FILES['file'])) {

    foreach($_FILES['file']['name'] as $key=>$val ){
        $errors = array();
        $file_name = $_FILES['file']['name'][$key];
        $file_size = $_FILES['file']['size'][$key];
        $file_tmp = $_FILES['file']['tmp_name'][$key];
        $file_type = $_FILES['file']['type'][$key];
        $file_ext = strtolower(end(explode('.', $file_name)));
        $extensions = array("doc", "docx", "xls","xlsx","pdf");
        if (in_array($file_ext, $extensions) === false) {
            $errors[] = "extension not allowed, please choose a doc,excel or pdf file.";
            $message_stauts_class = 'alert-danger';
            $import_status_message = 'Error: Extension not allowed, please choose a doc,excel or pdf file.';
        }
        if ($file_size > 2097152) {
            $errors[] = 'File size must be excately 2 MB';
            $message_stauts_class = 'alert-danger';
            $import_status_message = 'Error: File size must be excately 2 MB';
        }
        if (empty($errors) == true) {
            move_uploaded_file($file_tmp, "../document_files/" . $file_name);

            $sql = "INSERT INTO `document_images`(`file_name`,`doc_id`,`created_at`) VALUES ('$file_name' , '$material_id' , '$created_by' )";

            $result1 = mysqli_query($db, $sql);
            if ($result1) {
                $message_stauts_class = 'alert-success';
                $import_status_message = 'Files Added Successfully.';
            } else {
                $message_stauts_class = 'alert-danger';
                $import_status_message = 'Error: Please Try Again.';
            }
        }

    }
}

$page = "document_form.php";
header('Location: '.$page, true, 303);
exit;
