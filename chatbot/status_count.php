<?php
include("../config.php");
if($_POST != ''){
    $iid = $_SESSION['id'];
    //print_r($_POST);
    $query = "SELECT DISTINCT `message`FROM sg_chatbox WHERE `sender` !=$iid AND `flag`=$iid";
    $count = $mysqli->query($query);
    while ($c = $count->fetch_assoc()) {
        $not_count[] = $c['message'];
         
    }
    $c =count($not_count);
   
    echo json_encode($c);
   
}

?>