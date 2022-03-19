<?php
include("../config.php");
$chicagotime = date("Y-m-d H:i:s");
$user_id  = $_POST['user_id'];
$_SESSION['session_user'] = $user_id;
$loginid = $_SESSION["id"];

$query10 = sprintf("SELECT `flag`,`sg_chatbox_id` FROM sg_chatbox where sender = '$user_id' and receiver = '$loginid' and flag != '0' ;  ");
$qur10 = mysqli_query($db, $query10);
while ($rowc10 = mysqli_fetch_array($qur10)) {
$chatid = $rowc10["sg_chatbox_id"];
$flag = $rowc10["flag"];

$query11 = "UPDATE `sg_chatbox` SET `flag`='0' where  `sg_chatbox_id` = '$chatid' ";
$qur11 = mysqli_query($db, $query11);

}
?>
						