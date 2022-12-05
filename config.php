<?php
define('SITE_ROOT', __DIR__);

include("config/database_config.php");
include("config/general_coding_config.php");
include("config/error_config.php");
$url = "../api/";
require_once "helper/PNUtilHelper.php";
require_once "helper/PN_Constants.php";
?>