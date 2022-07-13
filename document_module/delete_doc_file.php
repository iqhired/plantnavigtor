<?php include("../config.php");
$time_stamp = $_SESSION['timestamp_id'];
$doc_id = $_POST['doc_id'];

//$delete_check = $_POST['id'];
$sql = "select * from `document_files` where doc_file_id = '$doc_id'";
$sql1 = mysqli_query($db,$sql);
$row = mysqli_fetch_array($sql1);
$id = $row['doc_file_id'];
$file_name = $row['file_name'];
unlink("../document_files/".$time_stamp.'/'.$file_name);
if(!is_dir($time_stamp)){
    unlink("../document_files/".$doc_id.'/'.$file_name);
}
      $sql = "DELETE FROM `document_files` where doc_file_id ='$doc_id'";

if (!mysqli_query($db, $sql)) {
	$_SESSION['message_stauts_class'] = 'alert-danger';
	$_SESSION['import_status_message'] = 'Please Retry.';
} else {
	$_SESSION['message_stauts_class'] = 'alert-success';
	$_SESSION['import_status_message'] = 'Document file Deleted Sucessfully.';
}

