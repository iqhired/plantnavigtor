<?php

include("../config.php");

$id = $_GET['id'];

$sql1 = "DELETE FROM `station_assests` WHERE asset_id = '$id'";
mysqli_query($db, $sql1);


$page = "assets_config.php?id=$id";
header('Location: '.$page, true, 303);
exit;
