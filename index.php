<?php

use App\Request;
use App\Router;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "vendor/autoload.php";

require_once "routes.php";

$request = new Request();

$response = Router::resolve($request);

echo $response->send();