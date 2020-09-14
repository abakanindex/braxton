<?php
ini_set('display_errors', 1);
error_reporting(0);
//ini_set('memory_limit', '-1');
// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
defined('DOCUMENT__ROOT') or define('DOCUMENT__ROOT', $_SERVER['DOCUMENT_ROOT']);

If(count(list($subDomain) = explode('.', $_SERVER['SERVER_NAME'])) >= 2) {
    defined('SUBDOMAIN_NAME') or define('SUBDOMAIN_NAME', $subDomain);
} else {
    defined('SUBDOMAIN_NAME') or define('SUBDOMAIN_NAME', null);
}


require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');

(new yii\web\Application($config))->run();
