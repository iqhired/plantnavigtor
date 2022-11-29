<?php
define('SITE_ROOT', __DIR__);

include("config/database_config.php");
include("config/general_coding_config.php");
include("config/error_config.php");
require_once($_SERVER['DOCUMENT_ROOT']."/helper/PNUtilHelper.php");
$url = "../api/";

?>