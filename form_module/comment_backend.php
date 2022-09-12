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
}
?>
