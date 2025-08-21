<?php

namespace App\Core;

class Router
{
    private array $routes = ['GET' => [], 'POST' => []];

    public function __construct(private array $config)
    {
    }

    public function get(string $path, callable|array $action)
    {
        $this->routes['GET'][$path] = $action;
    }

    public function post(string $path, callable|array $action)
    {
        $this->routes['POST'][$path] = $action;
    }

    public function dispatch(Request $req, Response $res)
    {
        $method = $req->method();
        $path = $req->path();
        $action = $this->routes[$method][$path] ?? null;
        if (!$action) return $res->status(404)->send('Not Found!');

        if (is_array($action)) {
            [$class, $methodName] = $action;
            $controller = new $class($this->config, $req, $res);
            return $controller->$methodName();
        }
        return $action($req, $res);
    }
}