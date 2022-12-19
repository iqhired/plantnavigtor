<?php include("../s_config.php");
include("../config.php");
$form_create_id = $_POST['form_create'];
$form_item_id = $_POST['form_item_id'];
$date_from = $_POST['date_from'];
$date_to = $_POST['date_to'];
    //$sql = "SELECT data_item_value FROM `spc_schedular_data` WHERE `data_item_id` = '$form_item_id' and created_at >= '$date_from' and created_at <= '$date_to'";
$sql = "SELECT data_item_value as data_item_value FROM `spc_schedular_data` WHERE `data_item_id` = '$form_item_id'";
    $response = array();
    $posts = array();
    $result = mysqli_query($s_db,$sql);
    $data =array();
    while ($row = mysqli_fetch_array($result)){
        foreach ($row as $value){
            $a = $value;
        }
        $posts[] = array('item_value'=> $a);
    }
    $response['posts'] = $posts;
    echo json_encode($response);



