<?php
include("../config.php");
$cus_id = $_POST['cus_id'];
$pf = $_POST['part_family'];
//weekly data
$sql2 = "SELECT distinct `form_type`,`station`,count(created_at) as cd,`part_family` FROM `form_user_data` WHERE part_family = '$pf' and form_type = '5' and YEARWEEK(`created_at`) = YEARWEEK(CURDATE()) GROUP BY form_type";
$result2 = mysqli_query($db,$sql2);
$row2 = $result2->fetch_assoc();
$cd = $row2['cd'];
//monthly data
$sql3 = "SELECT distinct `form_type`,`station`,count(created_at) as ce,`part_family` FROM `form_user_data` WHERE part_family = '$pf' and form_type = '5' and Month(`created_at`) = Month(CURDATE()) GROUP BY form_type";
$result3 = mysqli_query($db,$sql3);
$row3 = $result3->fetch_assoc();
$ce = $row3['ce'];

$sql4 = "SELECT distinct `form_type`,`station`,count(created_at) as cf,`part_family` FROM `form_user_data` WHERE part_family = '$pf' and form_type = '5' and date(`created_at`) = CURDATE() GROUP BY form_type";
$result4 = mysqli_query($db,$sql4);
$row4 = $result4->fetch_assoc();
$cf = $row4['cf'];

$sql = "SELECT distinct `form_type`,`station`,count(created_at) as cc,`part_family` FROM `form_user_data` WHERE part_family = '$pf' and form_type = '5' and Year(`created_at`) = Year(CURDATE()) GROUP BY form_type" ;
$response = array();
$posts = array();
$result = mysqli_query($db,$sql);
//$result = $mysqli->query($sql);
$data =array();

while ($row=$result->fetch_assoc()){
    $cc = $row['cc'];
    $posts[] = array('d_count'=> $cf, 'w_count'=> $cd, 'm_count'=> $ce, 'y_count'=> $cc);
}
$response['posts'] = $posts;
echo json_encode($response);





