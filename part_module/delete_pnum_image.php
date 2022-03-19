<?php include("../config.php");
$images = $_POST['images'];
$id = $_POST['id'];


$sql1 = "update  `pm_part_number` set part_images = '$images' WHERE `pm_part_number_id` = '$id' ";
$result1 = mysqli_query($db, $sql1);

?>
