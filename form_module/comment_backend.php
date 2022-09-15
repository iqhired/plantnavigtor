<?php
include("../config.php");
$chicagotime = date("Y-m-d H:i:s");
if (count($_POST) > 0) {
    $message = $_POST['enter-message'];
    $userid = $_POST['sender'];


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


    if($comment_id > 0){


        $sql = "update `comment_files` SET comment_id = '$comment_id' where comment_id = '0'";
        $result1 = mysqli_query($db, $sql);
        if($result1){
        }
    }

}

?>
