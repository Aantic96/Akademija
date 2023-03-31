<?php

use App\Request;

require_once "vendor/autoload.php";

require_once "routes.php";

$request = new Request();

$response = $router->resolve($request);

echo $response->send();

