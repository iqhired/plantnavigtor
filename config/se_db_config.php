<?php
@ob_start();
session_start();
ini_set('display_errors', FALSE);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "form_item_schedular";

// to check whether pin is updated or not

$s_db = mysqli_connect('localhost', 'root', '', 'form_item_schedular');
//$mysqli = new mysqli('localhost', 'ashams001', 'iqHired@123', 'sg_supplier');
$s_mysqli = new mysqli('localhost', 'root', '', 'form_item_schedular');

date_default_timezone_set("America/chicago");

$sitename = "plantnavigtor";

$scriptName = "http://localhost/plantnavigtor/";
//$siteURL = "http://localhost/plantnavigtor/";
$link = "http://localhost/plantnavigtor/";
?>