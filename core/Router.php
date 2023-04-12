<?php

namespace Core;

use Core\Interfaces\RequestInterface;
use Core\Interfaces\ResponseInterface;

class Router
{
    //Stores all routes
    private static array $routes = [];
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';

    public static function get(string $uri, array|callable $action): void
    {
        self::$routes[]  = [
            'uri' => $uri,
            'action' => $action,
            'method' => self::METHOD_GET
        ];
    }

    public static function post(string $uri, array|callable $action): void
    {
        self::$routes[]  = [
            'uri' => $uri,
            'action' => $action,
            'method' => self::METHOD_POST
        ];
    }

    //Resolves route with the matching uri
    public static function resolve(RequestInterface $request): ?ResponseInterface
    {
        foreach (self::$routes as $route) {
            $placeholderParams = self::resolvePlaceholders($request, $route);
            //Matching request uri to routes
            if ($request->getMethod() === $route['method'] &&
                self::matchRoute($route['uri'], $request->getUri(), $placeholderParams)) {
                $request->setAttributes($placeholderParams);

                $action = $route['action'];
                if (is_callable($action)) {
                    return call_user_func($action, $request);
                }

                $controller = new $action[0]($request);
                return call_user_func([$controller, $action[1]]);
            }
        }
        echo "Page not found";
        return null;
    }

    protected static function resolvePlaceholders($request, $route): array
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

    protected static function matchRoute(string $route, string $uri, array $placeholderParams): bool
    {
        foreach ($placeholderParams as $placeholder => $value) {
            $route = str_replace('{' . $placeholder . '}', $value, $route);
        }
        return $uri === $route;
    }
}