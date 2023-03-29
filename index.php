<?php

require_once "vendor/autoload.php";

require_once "routes.php";

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$router->resolve($uri);

