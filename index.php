<?php
declare(strict_types=1);

use App\Core\{Router, Request, Response};

require __DIR__ . '/vendor/autoload.php';

session_start();

$config = require __DIR__ . '/config/config.php';

define('BASE_URL', $config['app']['base_url']);


error_reporting($config['app']['debug'] ? E_ALL : 0);
ini_set('display_errors', $config['app']['debug'] ? '1' : '0');

require __DIR__ . '/app/Route/route.php';