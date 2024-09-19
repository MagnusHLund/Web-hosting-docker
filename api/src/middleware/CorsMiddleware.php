<?php

namespace MagZilla\Api\Middleware;

use MagZilla\Api\Utils\Constants;

class CorsMiddleware
{
    private const ALLOWED_NETWORK_METHODS = "POST, GET, PUT, DELETE, OPTIONS";

    public static function handleCors()
    {
        self::validateOrigin();
        self::handlePreflightRequest();
    }

    private static function validateOrigin()
    {
        // Gets the origin from the request header.
        $origin = $_SERVER['HTTP_ORIGIN'] ?? 'undefined';

        // Assigns an array which has the list of allowed origins.
        $allowedOrigins = Constants::getAllowedCorsOrigins();

        // sets CORS headers, if the origin is in the $allowedOrigins array, else an error is returned to the caller.
        if (in_array($origin, $allowedOrigins)) {
            header("Access-Control-Allow-Origin: {$origin}");
            header("Access-Control-Allow-Credentials: true");
            header("Access-Control-Max-Age: 86400");
            header("Access-Control-Allow-Methods: " . self::ALLOWED_NETWORK_METHODS);
            header("Access-Control-Allow-Headers: Content-Type, Authorization");
        } else {
            // TODO
            exit;
        }
    }

    private static function handlePreflightRequest()
    {
        // Get the request method type, from the network request
        $requestMethod = $_SERVER['REQUEST_METHOD'] ?? '';

        // Checks if the header is 'OPTIONS'.
        if ($requestMethod == 'OPTIONS') {
            $requestHeaders = $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'] ?? '';

            // Allow API calls with the GET, POST, and OPTIONS methods.
            header("Access-Control-Allow-Methods: " . self::ALLOWED_NETWORK_METHODS);

            // If $requestHeaders is not empty, then set Access control headers
            if (!empty($requestHeaders)) {
                header("Access-Control-Allow-Headers: {$requestHeaders}");
            }

            http_response_code(200);
            exit;
        }
    }
}
