<?php
$form_id = $_POST['form_id'];

$sql = "select * from form_user_data where form_create_id = '$form_id'";
$response = array();
$posts = array();
$result = mysqli_query($db,$sql);
//$result = $mysqli->query($sql);
$data =array();

while ($row=$result->fetch_assoc()){
$cd = $row['cd'];
$posts[] = array('cd'=> $cd);

}
$response['posts'] = $posts;
echo json_encode($response);
?>