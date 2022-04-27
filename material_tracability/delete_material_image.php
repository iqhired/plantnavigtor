<?php include("../config.php");
$form_id = $_POST['material_id'];
$delete_check = $_POST['delete_image'];
if ($delete_check != "") {
    $cnt = count($delete_check);
    for ($i = 0; $i < $cnt;) {

        $sql = "DELETE FROM `material_images` where material_images_id ='$delete_check[$i]'";
        if (!mysqli_query($db, $sql)) {
            $_SESSION['message_stauts_class'] = 'alert-danger';
            $_SESSION['import_status_message'] = 'Please Retry.';
        } else {
            $_SESSION['message_stauts_class'] = 'alert-success';
            $_SESSION['import_status_message'] = 'Material image Deleted Sucessfully.';
        }
        $i++;
    }
} else {
    $_SESSION['message_stauts_class'] = 'alert-danger';
    $_SESSION['import_status_message'] = 'Please retry.';
}

header("Location:edit_material.php?id=$form_id");
