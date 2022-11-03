<?php

include("../config.php");

$seq_id = $_POST['seq_id'];

$sql1 = "DELETE FROM `station_assests` WHERE asset_id = '$seq_id'";
mysqli_query($db, $sql1);


$page = "assets_config.php?id=$seq_id";
header('Location: '.$page, true, 303);
exit;
