<?php
ob_start();
ini_set('display_errors', 'off');
session_start();
include '../config.php';
$chicagotime = date('d-m-Y', strtotime('-1 days'));
$chicagotime1 = date('Y-m-d', strtotime('-1 days'));
mkdir("../daily_report/" . $chicagotime);
?>