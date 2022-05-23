<?php

include("../config.php");

$seq_id = $_POST['seq_id'];
$i_id = $_POST['i_id'];
$c_id = $_POST['c_id'];
$sql1 = "DELETE FROM `form_item` WHERE form_item_id = '$i_id'";
mysqli_query($db, $sql1);


$page = "form_edit.php?id=$c_id";
header('Location: '.$page, true, 303);
exit;
