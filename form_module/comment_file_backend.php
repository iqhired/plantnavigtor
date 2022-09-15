<?php
include("../config.php");
$request = $_POST['request'];
$created_by = date("Y-m-d H:i:s");

if ($request == 1) {
    $filename = $_FILES['file']['name'];
    $file_size = $_FILES['file']['size'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_type = $_FILES['file']['type'];
    $location = "../comment_files/";
    $uploadOk = 1;
    $imageFileType = pathinfo($filename, PATHINFO_EXTENSION);

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"  && $imageFileType != "pdf") {
        $uploadOk = 0;
    }
    if ($uploadOk == 0) {
        echo 0;
    } else {
        /* Upload file */
        $destination = $location .  $filename;
        if (move_uploaded_file($file_tmp, $destination)) {
            $sql = "INSERT INTO `comment_files`(`file_name`,`comment_id`,`created_at`) VALUES ('$filename','0' ,'$created_by' )";
            $result1 = mysqli_query($db, $sql);
            if ($result1) {
                echo $destination;
            }
        } else {
            echo 0;
        }
    }
    exit;
}




