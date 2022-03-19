<?php
@ob_start();
session_start();
ini_set('display_errors', false);

$servername = "localhost";
$username = "ashams001";
$password = "iqHired@123";
$dbname = "sg_crewAssignmentMgmt";

// to check whether pin is updated or not

$db = mysqli_connect('localhost','ashams001','iqHired@123','sg_crewAssignmentMgmt');
$mysqli = new mysqli('localhost', 'ashams001', 'iqHired@123', 'sg_crewAssignmentMgmt');


//echo $mysqli;
//$db = mysqli_connect('localhost','sg_crew_assign_mgr','sg_crew_assign_mgr@2020','sg_crew_assign_mgmt');
//$mysqli = new mysqli('localhost', 'sg_crew_assign_mgr', 'sg_crew_assign_mgr@2020', 'sg_crew_assign_mgmt');

date_default_timezone_set("America/chicago");

$sitename = "SaarGummi";

$scriptName = "http://crewassignmentmgmt:8888/";
$siteURL = "http://crewassignmentmgmt:8888/";

?>


