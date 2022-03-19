<?php
session_start();
$line = $_SESSION['tab_station'] ;
$cell_id = $_SESSION['cell_id'];
if($_SESSION['is_cell_login']){
	$is_cell_login = null;
	$redirect = 'Location: tab_login.php?c_id='.$cell_id;
	session_destroy();
	header($redirect);
}else{
	$redirect = 'Location: tab_login.php?s_id='.$line.'&d_user=tab';
	session_destroy();
	header($redirect);
}

?>