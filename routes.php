<?php

//Instantiate class Router
$router = new \App\Router();

//Uses method get (defined in Router)
$router->get("/", function () {
    echo "Hi\n";
});

//Uses method post (defined in Router)
$router->get("/test", function () {
    echo "Bye\n";
});