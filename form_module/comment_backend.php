<?php
include("../config.php");
$chicagotime = date("Y-m-d H:i:s");
if (count($_POST) > 0) {
    $message = $_POST['enter-message'];
    $userid = $_POST['sender'];
    $file = $_FILES['com_file'];

    if ($message != null) {
        $sql1 = "INSERT INTO `comments`(`userid`, `message`,`comment_date`) VALUES ('$userid','$message','$chicagotime')";
        if (!mysqli_query($db, $sql1)) {
            //header("Location:edit_rejection.php");
        } else {

        }

    }
    $qur04 = mysqli_query($db, "SELECT * FROM  comments where message= '$message'");
    $rowc04 = mysqli_fetch_array($qur04);
    $comment_id = $rowc04["slno"];


 //   multiple image
       if (isset($_FILES['com_file'])) {

			foreach($_FILES['com_file']['name'] as $key=>$val ){
                $errors = array();
                $file_name = $_FILES['com_file']['name'][$key];
                $file_size = $_FILES['com_file']['size'][$key];
                $file_tmp = $_FILES['com_file']['tmp_name'][$key];
                $file_type = $_FILES['com_file']['type'][$key];
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
                    move_uploaded_file($file_tmp, "../comment_files/" . $file_name);

					$sql = "INSERT INTO `comment_files`(`file_name`,`comment_id`,`created_at`) VALUES ('$file_name' , '$comment_id' , '$chicagotime' )";

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
?>
