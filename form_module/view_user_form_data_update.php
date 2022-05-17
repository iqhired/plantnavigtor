<?php
include("../config.php");

    $form_id = $_GET['id'];
$form_user_data_item = "";
$querymain = sprintf("SELECT * FROM `form_user_data` where form_user_data_id = '$form_id' ");
$qurmain = mysqli_query($db, $querymain);

while ($rowcmain = mysqli_fetch_array($qurmain)) {

    $get_form_type = $rowcmain['form_type'];
    $get_station = $rowcmain['station'];
    $get_part_family = $rowcmain['part_family'];
    $get_part_number = $rowcmain['part_number'];
    $formname = $rowcmain['form_name'];
    $form_item_array1 = $rowcmain["form_user_data_item"];
    $form_item_array2 = explode(',', $form_item_array1);

    $query1 = sprintf("SELECT form_create_id FROM  form_create where form_type = '$get_form_type' and station = '$get_station' and part_family = '$get_part_family' and part_number = '$get_part_number' and name = '$formname'");
    $qur1 = mysqli_query($db, $query1);
    $rowc1 = mysqli_fetch_array($qur1);
    $item_id = $rowc1['form_create_id'];

    $query = sprintf("SELECT * FROM  form_item where form_create_id = '$item_id'");
    $qur = mysqli_query($db, $query);
	$i = 0;
    while ($rowc = mysqli_fetch_array($qur)) {

        $item_id = $rowc['form_item_id'];
        $form_user_data_item .= $item_id . "~" . $form_item_array2[$i] . ",";
		$i++;

    }


}

    $sql0 = "UPDATE `form_user_data` SET `form_user_data_item`='$form_user_data_item' WHERE `form_user_data_id` = '$form_id'";
    $result0 = mysqli_query($db, $sql0);
    if ($result0) {
        $_SESSION['message_stauts_class'] = 'alert-success';
        $_SESSION['import_status_message'] = 'Form Updated Sucessfully.';
    } else {
        $_SESSION['message_stauts_class'] = 'alert-danger';
        $_SESSION['import_status_message'] = 'Please retry';
    }

//header("Location:form_edit.php?id=$hidden_id");
$page = "view_user_form_data.php?id=$form_id";
header('Location: '.$page, true, 303);
exit;

?>