<?php
include("../config.php");
$chicagotime = date("Y-m-d H:i:s");
$temp = "";
if (count($_POST) > 0) {
    $message = $_POST['enter-message'];
    $sender = $_POST['sender'];
    $receiver = $_SESSION['session_user'];
    $flag = $_SESSION['session_user'];

if($message != null){
  $sql1 = "INSERT INTO `sg_chatbox`(`sender`,`receiver`,`message`,`createdat`,`flag`) VALUES ('$sender','$receiver','$message','$chicagotime','$flag')";
                        if (!mysqli_query($db, $sql1)) {
                        } else {
                        }
}
}
?>
