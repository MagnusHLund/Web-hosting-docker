<?php

namespace MagZilla\Api\Managers;

use MagZilla\Api\Controllers\AuthenticationController;
use MagZilla\Api\Controllers\ServiceController;
use MagZilla\Api\Controllers\UserController;
use Psr\Container\ContainerInterface;

class ApiRouter
{
    private $routes = array();

    public function __construct(ContainerInterface $container)
    {
        $authenticationController = $container->get(AuthenticationController::class);
        $serviceController = $container->get(ServiceController::class);
        $userController = $container->get(UserController::class);

        $this->routes = [
            ["POST",   "/api/auth/changePassword",          [$authenticationController, "changePassword"]],
            ["POST",   "/api/auth/login",                   [$authenticationController, "login"]],
            ["POST",   "/api/auth/logout",                  [$authenticationController, "logout"]],

            ["POST",   "/api/services/addService",          [$serviceController, "addService"]],
            ["GET",    "/api/services/getServiceDetails",   [$serviceController, "getServiceDetails"]],
            ["GET",    "/api/services/getServices",         [$serviceController, "getServices"]],
            ["PUT",    "/api/services/updateService",       [$serviceController, "updateService"]],
            ["PUT",    "/api/services/updateServiceSource", [$serviceController, "updateServiceSource"]],
            ["DELETE", "/api/services/deleteService",       [$serviceController, "deleteService"]],

            ["POST",   "/api/users/addUser",                [$userController, "addUser"]],
            ["GET",    "/api/users/getSettings",            [$userController, "getSettings"]],
            ["GET",    "/api/users/getUsers",               [$userController, "getUsers"]],
            ["PUT",    "/api/users/updateSettings",         [$userController, "updateSettings"]],
            ["PUT",    "/api/users/updateUser",             [$userController, "updateUser"]],
            ["DELETE", "/api/users/deleteUser",             [$userController, "addUser"]],
        ];
    }

    public function handleRequest($method, $path, $requestBody)
    {
        foreach ($this->routes as $route) {
            $routeMethod = $route[0];
            $routePath = $route[1];
            $handler = $route[2];
            $params = $route[3] ?? [];

            if ($method === $routeMethod && $path === $routePath) {
                call_user_func_array([$handler[0], $handler[1]], [$requestBody, $params]); // TODO: Can this be improved?
                return;
            }
        }

        http_response_code(404);
        echo json_encode(["error" => "This route does not exist!"]);
        exit;
    }
}
