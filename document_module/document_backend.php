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
    if (empty($part_number)){
        $part_number = 0;
    }
    $status = $_POST['status'];
    $exp_date = $_POST['exp_date'];
    $created_by = date("Y-m-d H:i:s");


    $sql0 = "INSERT INTO `document_data`(`doc_name`,`station`,`doc_type`,`doc_category`,`part_number`,`status`,`expiry_date`,`created_at`) VALUES 
	        	('$doc_name','$station','$doc_type' ,'$category',' $part_number' ,'$status',' $exp_date','$created_by')";
    $result0 = mysqli_query($db, $sql0);
    $qur04 = mysqli_query($db, "SELECT * FROM  document_data where station= '$station' ORDER BY `doc_id` DESC LIMIT 1");
    $rowc04 = mysqli_fetch_array($qur04);
    $doc_trace_id = $rowc04["doc_id"];
    $ts = $_SESSION['timestamp_id'];
    $folderPath =  "../document_files/".$ts;
    $newfolder = "../document_files/".$doc_trace_id;
    $update_sql ="UPDATE `document_files` SET `part_number`='$part_number',`station`='$station' WHERE `doc_id` = '$doc_trace_id'";
    $result_up = mysqli_query($db, $update_sql);
    rename("$folderPath","$newfolder");
    if ($result0) {
        $_SESSION['message_stauts_class'] = 'alert-success';
        $_SESSION['import_status_message'] = 'Document Created Sucessfully.';

    } else {
        $_SESSION['message_stauts_class'] = 'alert-danger';
        $_SESSION['import_status_message'] = 'Please retry';

    }
    $sql = "update `document_files` SET doc_id = '$doc_trace_id', station = '$station',part_number = '$part_number' where doc_id = '$ts'";
    $result1 = mysqli_query($db, $sql);
    if($result1){
        $_SESSION['temp_doc_id'] = '';
    }

}


//$qur04 = mysqli_query($db, "SELECT * FROM  document_data where doc_name = '$doc_name' ORDER BY `doc_id` DESC ");
//$rowc04 = mysqli_fetch_array($qur04);
//$doc_id = $rowc04["doc_id"];
//$station = $rowc04["station"];
//$part_number = $rowc04["part_number"];
//
//
//if($doc_trace_id > 0){
//	$temp_docid = $_SESSION['temp_doc_id'];
//	$doc_arr = explode ( ',' , $temp_docid);
//	$doc_str = '';
//	$i = 0 ;
//	foreach ($doc_arr as $docid){
//		if(($i == 0) && ($docid != "")){
//            $doc_str = '\'' . $docid . '\'';
//			$i++;
//		}else if($docid != ""){
//            $doc_str .= ',' . '\'' . $docid . '\'';
//		}
//	}
//
//}

//multiple image
//if (isset($_FILES['file'])) {
//
//    foreach($_FILES['file']['name'] as $key=>$val ){
//        $errors = array();
//        $file_name = $_FILES['file']['name'][$key];
//        $file_size = $_FILES['file']['size'][$key];
//        $file_tmp = $_FILES['file']['tmp_name'][$key];
//        $file_type = $_FILES['file']['type'][$key];
//        $file_ext = strtolower(end(explode('.', $file_name)));
//        $extensions = array("png", "jpg", "jpeg","pdf");
//        if (in_array($file_ext, $extensions) === false) {
//            $errors[] = "extension not allowed, please choose a .png,.jpg,.jpeg or pdf file.";
//            $message_stauts_class = 'alert-danger';
//            $import_status_message = 'Error: Extension not allowed, please choose a jpg,png or pdf file.';
//        }
//        if ($file_size > 2097152) {
//            $errors[] = 'File size must be excately 2 MB';
//            $message_stauts_class = 'alert-danger';
//            $import_status_message = 'Error: File size must be excately 2 MB';
//        }
//        if (empty($errors) == true) {
//            move_uploaded_file($file_tmp, "../document_files/" . $file_name);
//
//            $sql = "INSERT INTO `document_files`(`file_name`,`doc_id`,`part_number`,`station`,`created_at`) VALUES ('$file_name','$doc_id' ,'$part_number','$station','$created_by' )";
//
//            $result1 = mysqli_query($db, $sql);
//            if ($result1) {
//                $message_stauts_class = 'alert-success';
//                $import_status_message = 'Files Added Successfully.';
//            } else {
//                $message_stauts_class = 'alert-danger';
//                $import_status_message = 'Error: Please Try Again.';
//            }
//        }
//
//    }
//}

$page = "document_form.php";
header('Location: '.$page, true, 303);

exit;
