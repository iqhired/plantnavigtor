<?php
@ob_start();
session_start();
ini_set('display_errors', FALSE);

$servername = "localhost";
$username = "ashams001";
$password = "iqHired@123";
$dbname = "sg_supplier";

// to check whether pin is updated or not

$sup_db = mysqli_connect('localhost', 'ashams001', 'iqHired@123', 'sg_supplier');
//$mysqli = new mysqli('localhost', 'ashams001', 'iqHired@123', 'sg_supplier');
$sup_mysqli = new mysqli('localhost', 'ashams001', 'iqHired@123', 'sg_supplier');

date_default_timezone_set("America/chicago");

$sitename = "SaarGummi";

$scriptName = "http://crewassignmentmgmt:8888/";

?>