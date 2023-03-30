<?php



require_once "vendor/autoload.php";

require_once "routes.php";

use App\Request;

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$request = new Request([]);

$router->resolve($uri, $request);

