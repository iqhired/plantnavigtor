<?php include("../config.php");
$doc_id = $_POST['doc_id'];
$edit_doc_id = $_SESSION['edit_id'];
//$delete_check = $_POST['id'];
$sql = "select * from `document_files` where doc_file_id = '$doc_id'";
$sql1 = mysqli_query($db,$sql);
$row = mysqli_fetch_array($sql1);
$id = $row['doc_file_id'];
$file_name = $row['file_name'];
unlink("../document_files/".$edit_doc_id."/".$file_name);

$sql = "DELETE FROM `document_files` where doc_file_id ='$doc_id'";

if (!mysqli_query($db, $sql)) {
	$_SESSION['message_stauts_class'] = 'alert-danger';
	$_SESSION['import_status_message'] = 'Please Retry.';
} else {
	$_SESSION['message_stauts_class'] = 'alert-success';
	$_SESSION['import_status_message'] = 'Document file Deleted Sucessfully.';
}

