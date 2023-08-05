<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/vendor/autoload.php';

use coffeforme\Kernel\Bootstrap;

ob_start();
$app = new Bootstrap();
$app->run();
ob_end_flush();