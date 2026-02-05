<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

date_default_timezone_set('Asia/Jakarta');
setlocale(LC_TIME, 'INDONESIA');

/**
 * Adjust the path below if you move the yii directory.
 * This app expects: egor_app_full/yii/framework/yii.php
 */
$yii = dirname(__FILE__) . '/yii/framework/yii.php';
$config = dirname(__FILE__) . '/protected/config/main.php';

if (!file_exists($yii)) {
    die("Yii framework not found. Expected at: $yii");
}

require_once($yii);
Yii::createWebApplication($config)->run();
