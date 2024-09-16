<?php

namespace MagZilla\Managers;

class ApiRouter
{
    private $routes = array();

    public function handleRequest($method, $path, $requestBody)
    {
        foreach ($this->routes as $route) {
            $routeMethod = $route[0];
            $routePath = $route[1];
            $handler = $route[2];
            $params = $route[3] ?? [];

            if ($method === $routeMethod && $path === $routePath) {
                call_user_func_array([$handler[0], $handler[1]], [[$requestBody], $params]);
                return;
            }
        }

        http_response_code(404);
        echo json_encode(["error" => "This route does not exist!"]);
        exit;
    }

    public function registerRoute($type, $route, $callback)
    {
        $this->routes = array_push($this->routes, array(
            "type" => $type,
            "route" => $route,
            "callback" => array()
        ));
    }
}
