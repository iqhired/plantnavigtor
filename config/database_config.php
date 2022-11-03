<?php
@ob_start();
session_start();
ini_set('display_errors', FALSE);

$servername = "localhost";
$username = "u0txir940ctq3";
$password = "8xtufivsxpu8";
$dbname = "dbhnjuseplnng8";

// to check whether pin is updated or not

$db = mysqli_connect('localhost','u0txir940ctq3','8xtufivsxpu8','dbhnjuseplnng8');
$mysqli = new mysqli('localhost', 'u0txir940ctq3', '8xtufivsxpu8', 'dbhnjuseplnng8');

//$db = mysqli_connect('localhost','sg_crew_assign_mgr','sg_crew_assign_mgr@2020','sg_crew_assign_mgmt');
//$mysqli = new mysqli('localhost', 'sg_crew_assign_mgr', 'sg_crew_assign_mgr@2020', 'sg_crew_assign_mgmt');

date_default_timezone_set("America/chicago");

$sitename = "SaarGummi";

$scriptName = "https://plantnavigator.com/";
$siteURL = "https://plantnavigator.com/";

?>