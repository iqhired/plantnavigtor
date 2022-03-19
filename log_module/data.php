<?php include("../config.php");
header('Content-type: application/json');
$sql = "SELECT good_pieces,bad_pieces,rework FROM `good_bad_pieces`";
$response = array();
$posts = array();
$result = mysqli_query($db,$sql);
$result = $mysqli->query($sql);
$data =array();

while ($row=$result->fetch_assoc()){
   array('good_pieces'=> $row['good_pieces'], 'bad_pieces'=> $row['bad_pieces'], 'rework'=> $row['rework']);
}
$response['posts'] = $posts;
$fp = fopen('results.json', 'w');
fwrite($fp, json_encode($response));
fclose($fp);
?>

