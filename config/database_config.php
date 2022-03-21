<?php
@ob_start();
session_start();
ini_set('display_errors', FALSE);

$servername = "localhost";
$username = "u0rraniwebfga";
$password = "j1e85aazb5tf";
$dbname = "dbdn8ggvr3ljbd";

// to check whether pin is updated or not

$db = mysqli_connect('localhost','u0rraniwebfga','j1e85aazb5tf','dbdn8ggvr3ljbd');
$mysqli = new mysqli('localhost', 'u0rraniwebfga', 'j1e85aazb5tf', 'dbdn8ggvr3ljbd');

//$db = mysqli_connect('localhost','sg_crew_assign_mgr','sg_crew_assign_mgr@2020','sg_crew_assign_mgmt');
//$mysqli = new mysqli('localhost', 'sg_crew_assign_mgr', 'sg_crew_assign_mgr@2020', 'sg_crew_assign_mgmt');

date_default_timezone_set("America/chicago");

$sitename = "SaarGummi";

$scriptName = "https://plantworkx.com/";
$siteURL = "https://plantworkx.com/";

?>