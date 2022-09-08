<?php
include("../config.php");
$array = json_decode($_POST['info']);
$drag_drop_res = (array)json_decode($array);
$date = date("Y-m-d H:i:s");
if (isset($_POST['submit'])) {
    $statusMsg = '';
    $created_by = $_SESSION['id'];
    $comment = $_POST['comment'];
    $pw = $_POST['pin2'];
    $targetDir = "../form_images/";
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    $form_user_data_id = $_POST['form_user_data_id'];
    $sql = "select * from cam_users where users_id = '$created_by'";
    $qurmain = mysqli_query($db, $sql);
    while ($rowcmain = mysqli_fetch_array($qurmain)) {
        $sqlt = "INSERT INTO `form_comments`(`form_user_data_id`,`comments`,`comment_date`) VALUES ('$form_user_data_id','$comment','$date')";
        $resultt = mysqli_query($db, $sqlt);
            echo 'updated successfully';
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf');
            if (in_array($fileType, $allowTypes)) {
                // Upload file to server
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                    // Insert image file name into database
                    $insert = $db->query("UPDATE `form_rejection_data` SET `filename`='$fileName' where form_user_data_id = '$form_user_data_id'");
                    if ($insert) {
                        $statusMsg = "uploaded successfully.";
                    }
                }
            } else {
                echo "please enter correct password";
            }
        }
}
if (isset($_POST['save'])) {
    $sql2 = "UPDATE `form_rejection_data` SET `r_flag`='0' where form_user_data_id = '$form_user_data_id'";
    $result2 = mysqli_query($db, $sql2);
}
?>