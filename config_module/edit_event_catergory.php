<?php include("../config.php");
$id = $_POST['id'];
$name = $_POST['name'];
$npr = $_POST['npr'];


$sql = "update events_category set events_cat_name='$name',npr='$npr'  where events_cat_id ='$id'";
$result1 = mysqli_query($db, $sql);
if ($result1) {
    $message_stauts_class = 'alert-success';
    $import_status_message = 'Event Category  Updated successfully.';
} else {
    $message_stauts_class = 'alert-danger';
    $import_status_message = 'Error: Please Insert valid data';
}
