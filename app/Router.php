<?php

namespace App;

use App\Interfaces\RequestInterface;
use App\Interfaces\ResponseInterface;

class Router
{
    //Stores all routes
    protected array $routes = [];

    public function get(string $uri, array|callable $action): void
    {
        $this->routes[] = [
            'uri' => $uri,
            'action' => $action,
            'method' => "GET"
        ];
    }

    public function post(string $uri, array|callable $action): void
    {
        $this->routes[] = [
            'uri' => $uri,
            'action' => $action,
            'method' => "POST"
        ];
    }

    //Resolves route with the matching uri
    public function resolve(RequestInterface $request): ?ResponseInterface
    {
        foreach ($this->routes as $route) {
            //Matching request uri to routes
            if ($request->getUri() === $route["uri"] && $request->getMethod() === $route['method']) {
                $action = $route['action'];
                if (is_callable($action)) {
                    return call_user_func($action, $request);
                }
                $controller = new $action[0]($request);
                return $controller->{$action[1]}();
            }
        }
        echo "Page not found";
        return null;
    }
}