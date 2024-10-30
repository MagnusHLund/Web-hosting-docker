<?php

namespace MagZilla\Api\Managers;

use Psr\Container\ContainerInterface;
use MagZilla\Api\Services\ResponseService;
use MagZilla\Api\Controllers\UserController;
use MagZilla\Api\Controllers\ServiceController;
use MagZilla\Api\Controllers\AuthenticationController;

class ApiRouter
{
    private $routes = [];

    public function __construct(ContainerInterface $container)
    {
        $authenticationController = $container->get(AuthenticationController::class);
        $serviceController = $container->get(ServiceController::class);
        $userController = $container->get(UserController::class);

        $this->routes = [
            ["PUT",   "/api/auth/updatePassword",           $authenticationController, "updatePassword"],
            ["POST",   "/api/auth/login",                   $authenticationController, "login"],
            ["POST",   "/api/auth/logout",                  $authenticationController, "logout"],

            ["POST",   "/api/services/addService",          $serviceController,        "addService"],
            ["GET",    "/api/services/getServiceDetails",   $serviceController,        "getServiceDetails"],
            ["GET",    "/api/services/getServices",         $serviceController,        "getServices"],
            ["PUT",    "/api/services/updateService",       $serviceController,        "updateService"],
            ["PUT",    "/api/services/updateServiceSource", $serviceController,        "updateServiceSource"],
            ["DELETE", "/api/services/deleteService",       $serviceController,        "deleteService"],

            ["POST",   "/api/users/addUser",                $userController,           "addUser"],
            ["GET",    "/api/users/getSettings",            $userController,           "getSettings"],
            ["GET",    "/api/users/getUsers",               $userController,           "getUsers"],
            ["PUT",    "/api/users/updateSetting",          $userController,           "updateSetting"],
            ["PUT",    "/api/users/updateUser",             $userController,           "updateUser"],
            ["DELETE", "/api/users/deleteUser",             $userController,           "deleteUser"],
        ];
    }

    public function handleRequest($method, $path, $requestBody)
    {
        foreach ($this->routes as $route) {
            [$routeMethod, $routePath, $controller, $action] = $route;
            if ($method === $routeMethod && $path === $routePath) {
                call_user_func([$controller, $action], $requestBody);
                return;
            }
        }

        ResponseService::getInstance()->sendResponse("This route does not exist!", 404);
    }
}
