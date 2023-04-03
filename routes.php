<?php

use App\Controllers\IndexController;
use App\Interfaces\RequestInterface;
use App\Response;

//Instantiate class Router
$router = new \App\Router();

//Uses method get (defined in Router)
$router->get("/", function (RequestInterface $request) {
    return new Response(implode(", ", $request->getParams()));
});

//Uses method post (defined in Router)
$router->post("/post", function (RequestInterface $request) {
    return new Response(implode(", ", $request->getBody()));
});

$router->get("/index", [IndexController::class, "indexAction"]);

$router->get("/index-json", [IndexController::class, "indexJsonAction"]);

//Case for placeholder param
$router->get('/test/{test_id}', function (RequestInterface $request) {
    return new Response(implode(", ", $request->getAttributes()));
});

$router->get('/test/{bla}', [IndexController::class, "indexJsonAction"]);