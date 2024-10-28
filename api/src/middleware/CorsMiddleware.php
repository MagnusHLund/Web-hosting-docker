<?php

namespace MagZilla\Api\Middleware;

use MagZilla\Api\Utils\Constants;

class CorsMiddleware extends BaseMiddleware
{
    private const ALLOWED_NETWORK_METHODS = "POST, GET, PUT, DELETE, OPTIONS";

    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function handleCors()
    {
        $this->validateOrigin();
        $this->handlePreflightRequest();
    }

    private function validateOrigin()
    {
        $origin = $_SERVER['HTTP_ORIGIN'] ?? 'undefined';

        $allowedOrigins = Constants::getAllowedCorsOrigins();

        if (in_array($origin, $allowedOrigins)) {
            header("Access-Control-Allow-Origin: {$origin}");
            header("Access-Control-Allow-Credentials: true");
            header("Access-Control-Max-Age: 86400");
            header("Access-Control-Allow-Methods: " . self::ALLOWED_NETWORK_METHODS);
            header("Access-Control-Allow-Headers: Content-Type, Authorization");
        } else {
            $this->handleError("Invalid origin", 403);
        }
    }

    private function handlePreflightRequest()
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'] ?? '';

        if ($requestMethod == 'OPTIONS') {
            $requestHeaders = $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'] ?? '';

            header("Access-Control-Allow-Methods: " . self::ALLOWED_NETWORK_METHODS);

            if (!empty($requestHeaders)) {
                header("Access-Control-Allow-Headers: {$requestHeaders}");
            }

            http_response_code(200);
            exit;
        }
    }
}
