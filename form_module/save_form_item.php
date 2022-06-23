<?php

include("../config.php");

$seq_id = $_POST['seq_id'];
$i_id = $_POST['i_id'];
$c_id = $_POST['c_id'];
$val = $_POST['val'];
$desc = $_POST['desc'];
$unit = $_POST['unit'];
$nominal = $_POST['nominal'];
$lower = $_POST['lower'];
$upper = $_POST['upper'];
$notes = $_POST['notes'];
$des = $_POST['des'];
$sql1 = "UPDATE `form_item` SET `item_desc`='$desc',`item_val`='$val',`unit_of_measurement`='$unit',`numeric_normal`='$nominal',`part_family`='$lower',`part_number`='$upper',`po_number`='$notes',`da_number`='$des' WHERE form_item_id = '$i_id'";

mysqli_query($db, $sql1);


$page = "form_edit.php?id=$c_id";
header('Location: '.$page, true, 303);

