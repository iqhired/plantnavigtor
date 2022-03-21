<?php
@ob_start();
session_start();
ini_set('display_errors', false);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "server";

// to check whether pin is updated or not

$db = mysqli_connect('localhost','root','','server');
$mysqli = new mysqli('localhost', 'root', '', 'server');


//echo $mysqli;
//$db = mysqli_connect('localhost','sg_crew_assign_mgr','sg_crew_assign_mgr@2020','sg_crew_assign_mgmt');
//$mysqli = new mysqli('localhost', 'sg_crew_assign_mgr', 'sg_crew_assign_mgr@2020', 'sg_crew_assign_mgmt');

date_default_timezone_set("America/chicago");

$sitename = "plantnavigator";

$scriptName = "http://localhost/plantnavigator/";
$siteURL = "http://localhost/plantnavigator/";

?>


