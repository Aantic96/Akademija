<?php

namespace App;

use App\Interfaces\RequestInterface;
use App\Interfaces\ResponseInterface;

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

    public function resolve(RequestInterface $request): ?ResponseInterface
    {
        foreach ($this->routes as $route) {
            if ($request->getUri() === $route["uri"] && $request->getMethod() === $route['method']) {
                $function = $route['function'];
                return call_user_func($function, $request);
            }
        }
        echo "Page not found";
        return null;
    }
}