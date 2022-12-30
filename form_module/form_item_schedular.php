<?php
include("../s_config.php");
include("../config.php");
$chicagotime2 = date('Y-m-d', strtotime('-365 days'));
$chicagotime = date('Y-m-d', strtotime('-1 days'));
$querymain = sprintf("SELECT * FROM `form_user_data` WHERE created_at >= '$chicagotime2' and created_at <= '$chicagotime' ORDER BY form_user_data_id ASC");
$qurmain = mysqli_query($db, $querymain);
while ($rowcmain = mysqli_fetch_array($qurmain)) {
    $formname = $rowcmain['form_name'];
    $form_create_id = $rowcmain['form_create_id'];
    $form_user_data_id = $rowcmain['form_user_data_id'];
    $station_event_id = $rowcmain['station_event_id'];
    $form_type = $rowcmain['form_type'];
    $form_status = $rowcmain['form_status'];
    $created_at = $rowcmain['created_at'];
    $form_item_array1 = $rowcmain['form_user_data_item'];

    $form_item_array = explode(',' ,$form_item_array1);
    foreach ($form_item_array as $word) {
        $form_item_array2 = explode("~",$word);
        $f_itm = $form_item_array2[0];
        $f_val = $form_item_array2[1];
        $q1 = sprintf("SELECT * FROM `form_item` WHERE form_item_id = '$f_itm'");
        $q2 = mysqli_query($db, $q1);
        $row1 = mysqli_fetch_array($q2);
        $item_val = $row1['item_val'];
        if(empty($station_event_id)){
            $station_event_id = 0;
        }
        if(($item_val == 'numeric') || ( $item_val == 'binary')){
            $sql = "INSERT INTO `spc_schedular_data`(`form_user_data_id`, `form_create_id`, `form_type`, `station_event_id`, `data_item_id`, `data_item_value`,`data_item_desc`,`form_status`, `created_at`) 
               VALUES ('$form_user_data_id','$form_create_id','$form_type','$station_event_id','$f_itm','$f_val','$item_val','$form_status','$created_at')";

            $result1 = mysqli_query($s_db, $sql);
        }

    }
}
?>



