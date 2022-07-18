<?php
include("../config.php");
$array = json_decode($_POST['info']);
$drag_drop_res = (array) json_decode($array);

if(count($_POST)>0) {
    $doc_id = $_POST['doc_id'];
    $doc_name = $_POST['doc_name'];
    $doc_type = $_POST['doc_type'];
    $station = $_POST['station'];
    $category = $_POST['category'];
    $part_number = $_POST['part_number'];
    $status = $_POST['status'];
    $exp_date = $_POST['exp_date'];
    $created_by = date("Y-m-d H:i:s");

    $sql0 = "UPDATE `document_data` SET `doc_name`='$doc_name',`station`='$station',`doc_type`='$doc_type',`doc_category`='$category',`part_number`='$part_number',`status`='$status',`expiry_date`='$exp_date',`created_at`='$created_by' WHERE `doc_id` = '$doc_id'";
    $result0 = mysqli_query($db, $sql0);
    if ($result0) {
        $_SESSION['message_stauts_class'] = 'alert-success';
        $_SESSION['import_status_message'] = 'Document Updated Sucessfully.';
    } else {
        $_SESSION['message_stauts_class'] = 'alert-danger';
        $_SESSION['import_status_message'] = 'Please retry';

    }

//    $qur04 = mysqli_query($db, "SELECT * FROM  document_data where doc_name = '$doc_name' ORDER BY `doc_id` DESC ");
//    $rowc04 = mysqli_fetch_array($qur04);
//    $doc_id = $rowc04["doc_id"];
//    $station = $rowc04["station"];
//    $part_number = $rowc04["part_number"];
//    $time_stamp = $_SESSION['timestamp_id'];
    //multiple image
//    if (isset($_FILES['file'])) {
//
//        foreach($_FILES['file']['name'] as $key=>$val ){
//            $errors = array();
//            $file_name = $_FILES['file']['name'][$key];
//            $file_size = $_FILES['file']['size'][$key];
//            $file_tmp = $_FILES['file']['tmp_name'][$key];
//            $file_type = $_FILES['file']['type'][$key];
//            $file_ext = strtolower(end(explode('.', $file_name)));
//            $extensions = array("png", "jpg", "jpeg","pdf");
//            if (in_array($file_ext, $extensions) === false) {
//                $errors[] = "extension not allowed, please choose a .png,.jpg,.jpeg or pdf file.";
//                $message_stauts_class = 'alert-danger';
//                $import_status_message = 'Error: Extension not allowed, please choose a jpg,png or pdf file.';
//            }
//            if ($file_size > 2097152) {
//                $errors[] = 'File size must be excately 2 MB';
//                $message_stauts_class = 'alert-danger';
//                $import_status_message = 'Error: File size must be excately 2 MB';
//            }
//            if (empty($errors) == true) {
//                $file_new_name = $time_stamp.'_'.$file_name;
//                move_uploaded_file($file_tmp, "../document_files/" .$doc_id.'/'. $file_new_name);
//
//                $sql = "INSERT INTO `document_files`(`file_name`,`doc_id`,`part_number`,`station`,`created_at`) VALUES ('$file_new_name','$doc_id' ,'$part_number','$station','$created_by' )";
//                $result1 = mysqli_query($db, $sql);
//                if ($result1) {
//                    $message_stauts_class = 'alert-success';
//                    $import_status_message = 'Files Added Successfully.';
//                } else {
//                    $message_stauts_class = 'alert-danger';
//                    $import_status_message = 'Error: Please Try Again.';
//                }
//            }
//
//        }
//    }


}
$page = "edit_document.php?id=$doc_id";
header('Location: '.$page, true, 303);
exit;

