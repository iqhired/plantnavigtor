<?php include("../config.php");
$id = $_POST['id'];
$name = $_POST['name_val'];
$n = $_POST['npr_val'];
$npr = (($n == "No") || ($n ==0))?0:1;


$sql = "update events_category set events_cat_name='$name',npr='$npr'  where events_cat_id ='$id'";
$result1 = mysqli_query($db, $sql);
if ($result1) {
    $message_stauts_class = 'alert-success';
    $import_status_message = 'Event Category  Updated successfully.';
} else {
    $message_stauts_class = 'alert-danger';
    $import_status_message = 'Error: Please Insert valid data';
}
$page = "event_category.php";
header('Location: '.$page, true, 303);
exit;

