<?php

namespace App;

class Router
{
    //Stores all routes
    protected array $routes = [];

    public function get(string $uri, callable $callback): void
    {
        $this->routes[] = [
            'uri' => $uri,
            'function' => $callback,
            'method' => "GET"
        ];
    }

    public function post(string $uri, callable $callback): void
    {
        $this->routes[] = [
            'uri' => $uri,
            'function' => $callback,
            'method' => "POST"
        ];
    }

    //Resolves route with the matching uri
    //TODO: Add matching by method
    public function resolve(string $uri)
    {
        foreach($this->routes as $route)
        {
            if($uri === $route["uri"]) {
                $function = $route['function'];
                $function();
            }
        }

        //IF not abort
    }
}