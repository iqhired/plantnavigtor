<?php
include("../config.php");
$chicagotime = date("Y-m-d H:i:s");
if (count($_POST) > 0) {
    $message = $mysqli->real_escape_string($_POST['s_message']);
    $data =  $_POST['data'];
    $data_arr = (explode("&",$data));
   // $message = null;
    $userid = null;
    foreach ($data_arr as $data) {
       $d_arr =  (explode("=",$data));
       if($d_arr[0] === 'sender'){
           $userid = $d_arr[1];
       }else if($d_arr[0] === 'rej_loop_form_id'){
           $rej_loop_form_id = $d_arr[1];
       }
    }



    $comment_id = null;
    $sql1 = "INSERT INTO `comments`(`userid`,`rej_loop_form_id`, `message`,`comment_date`) VALUES ('$userid','$rej_loop_form_id','$message','$chicagotime')";
    if ($mysqli->query($sql1) === TRUE) {
        $comment_id = $mysqli->insert_id;
    }

    if(!empty($_FILES)){
        $filename = $_FILES['file']['name'];
        $file_size = $_FILES['file']['size'];
        $file_tmp = $_FILES['file']['tmp_name'];
        $file_type = $_FILES['file']['type'];
        $location = "../assets/comment_files/";
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"  && $imageFileType != "pdf" && $imageFileType != "xls" && $imageFileType != "docx" && $imageFileType != "doc") {
            $uploadOk = 0;
        }
        if ($uploadOk == 0) {
            echo 0;
        } else {
            /* Upload file */
            $filename = pathinfo($_FILES["file"]["name"])['filename']. '_' . time(). '.' .  pathinfo($_FILES["file"]["name"])['extension'];
            $destination = $location .  $filename;
            if (move_uploaded_file($file_tmp, $destination)) {
                $sql = "INSERT INTO `comment_files`(`file_name`,`comment_id`,`created_at`) VALUES ('$filename','$comment_id' ,'$chicagotime' )";
                $result1 = mysqli_query($db, $sql);
            }
        }
    }
}

?>
