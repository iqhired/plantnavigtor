<?php
include("../config.php");
$info = $_POST['info'];
$name = $_POST['name'];
//echo($name);
//print_r($name);
//die();

if($name == "equipment")
{
$sql1 = "UPDATE `tm_equipment` SET `is_deleted` = '1' WHERE `tm_equipment_id` = '$info' ";
}
else if($name == "description")
{
$sql1 = "UPDATE `tm_description` SET `is_deleted` = '1' WHERE `tm_description_id`='$info' ";
}
else if($name == "property")
{
$sql1 = "UPDATE `tm_property` SET `is_deleted` = '1' WHERE `tm_property_id`='$info' ";
}
else if($name == "building")
{
$sql1 = "UPDATE `tm_building` SET `is_deleted` = '1' WHERE `tm_building_id`='$info' ";
}

if (mysqli_query($db, $sql1)) {
//    echo "deleted";
} 
else
{
	//echo "there is some issue";
}
?>
