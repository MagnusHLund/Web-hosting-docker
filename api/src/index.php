<?php

namespace MagZilla\Api;

use Dotenv;
use MagZilla\Api\Managers\ApiRouter;

require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

class Main
{
    public static function handleRequest()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = $_SERVER['REQUEST_URI'];
        $requestBody = json_decode(file_get_contents('php://input'), true);

        self::handleMiddleware();
        (new ApiRouter)->handleRequest($method, $path, $requestBody);
    }

    private static function handleMiddleware() {}
}
Main::handleRequest();
