<?php

use Core\Request;
use Core\Router;

require_once "../vendor/autoload.php";
require_once "../routes.php";

$request = new Request();

$response = Router::resolve($request);

echo $response->send();