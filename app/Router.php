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
            $placeholderParams = $this->resolvePlaceholders($request, $route);
            //Matching request uri to routes
            if ($request->getMethod() === $route['method'] &&
                $this->matchRoute($route['uri'], $request->getUri(), $placeholderParams)) {
                $request->addParams($placeholderParams);

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

    protected function resolvePlaceholders($request, $route): array
    {
        $requestParts = explode("/", $request->getUri());
        $routeParts = explode("/", $route['uri']);
        $placeholderParams = [];

        if(count($requestParts) != count($routeParts)) {
            return $placeholderParams;
        }

        for ($i = 0; $i < count($routeParts); $i++) {
            if (preg_match('/\{(.+?)}/', $routeParts[$i])) {
                $routePart = str_replace(['{', '}'], "", $routeParts[$i]);
                $placeholderParams[$routePart] = $requestParts[$i];
            }
        }
        return $placeholderParams;
    }

    protected function matchRoute(string $route, string $uri, array $placeholderParams): bool
    {
        foreach ($placeholderParams as $placeholder => $value) {
            $route = str_replace('{' . $placeholder . '}', $value, $route);
        }
        return $uri === $route;
    }
}