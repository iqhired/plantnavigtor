<?php
include("../config.php");
$ts = $_SESSION['timestamp_id'];
$rename_file = $_POST['rename'];

$sql_rename = "select * from document_files where doc_id = '$ts' ";
$row = mysqli_query($db,$sql_rename);
$row_ren = mysqli_fetch_array($row);
$file_name = $row_ren['file_name'];
$file_ex = explode('.', $file_name);
$sql_up = "UPDATE `document_files` SET `file_name`='$rename_file' where doc_id = '$ts' ";
$row_up = mysqli_query($db,$sql_up);
$result_ren = mysqli_fetch_array($row_up);
$file_new = $result_ren['file_name'];

$oldfile =  "../document_files/".$ts.'/'.$file_name;
$newfile = "../document_files/".$ts.'/'.$file_new;

if($result_ren){
    rename( $oldfile, $newfile);
    $_SESSION['message_stauts_class'] = 'alert-success';
    $_SESSION['import_status_message'] = 'Rename Sucessfully.';
} else {
    $_SESSION['message_stauts_class'] = 'alert-danger';
    $_SESSION['import_status_message'] = 'Please retry';

}
