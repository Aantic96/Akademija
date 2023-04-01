<?php

use App\Interfaces\RequestInterface;
use App\JsonResponse;
use App\Response;

//Instantiate class Router
$router = new \App\Router();

//Uses method get (defined in Router)
$router->get("/", function (RequestInterface $request) {
    return new Response(implode(", ", $request->getParams()));
});

$router->get("/jason", function (RequestInterface $request) {
    return new JsonResponse($request->getParams());
});

//Uses method post (defined in Router)
$router->post("/test", function (RequestInterface $request) {
    return new Response(implode(", ", $request->getBody()));
});