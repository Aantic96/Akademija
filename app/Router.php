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

    public function resolve(string $uri, Request $request): string
    {
        foreach($this->routes as $route)
        {
            if($uri === $route["uri"])
            {
                $method = $request->getMethod();
                if($method === $route['method'])
                {
                    $function = $route['function'];
                    return call_user_func($function);
                }
            }
        }
        echo "Page not found";
    }
}