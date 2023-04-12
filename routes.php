<?php

use App\Controllers\IndexController;
use Core\Interfaces\RequestInterface;
use Core\Responses\Response;
use Core\Router;

//Uses method get (defined in Router)
Router::get("/", function (RequestInterface $request) {
    return new Response(implode(", ", $request->getParams()));
});

//Uses method post (defined in Router)
Router::post("/post", function (RequestInterface $request) {
    return new Response(implode(", ", $request->getBody()));
});

Router::get("/index", [IndexController::class, "indexAction"]);

Router::get("/index-twig", [IndexController::class, "twigAction"]);

Router::get("/index-json", [IndexController::class, "indexJsonAction"]);

//Case for placeholder param
Router::get('/test/{test_id}', function (RequestInterface $request) {
    return new Response(implode(", ", $request->getAttributes()));
});

Router::get('/users', [IndexController::class, "getUsers"]);

Router::get('/users/{user_id}', [IndexController::class, "getUser"]);