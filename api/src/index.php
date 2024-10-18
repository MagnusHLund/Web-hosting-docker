<?php

namespace MagZilla\Api;

use Dotenv;
use MagZilla\Api\Managers\ApiRouter;
use MagZilla\Api\Middleware\AuthenticationMiddleware;
use MagZilla\Api\Middleware\CorsMiddleware;
use MagZilla\Api\Utils\DependencyInjection;

require_once __DIR__ . "/conf.php";
require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

class Main
{
    private $container;

    public function __construct()
    {
        $di = new DependencyInjection();
        $this->container = $di->registerDependencies();
    }

    public function handleRequest()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = $_SERVER['REQUEST_URI'];
        $requestBody = json_decode(file_get_contents('php://input'), true);

        $this->handleMiddleware($path);

        $router = new ApiRouter($this->container);
        $router->handleRequest($method, $path, $requestBody);
    }

    private function handleMiddleware($path)
    {
        CorsMiddleware::getInstance()->handleCors();
        AuthenticationMiddleware::getInstance()->validateAuthentication($path);
    }
}

(new main())->handleRequest();
