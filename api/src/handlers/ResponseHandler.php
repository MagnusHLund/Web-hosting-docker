<?php

namespace MagZilla\Api\Handlers;

class ResponseHandler
{
    private static $instance = null;

    private function __construct() {}

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new ResponseHandler();
        }
        return self::$instance;
    }

    public function sendResponse($response, $statusCode)
    {
        $success = $statusCode < 400;

        http_response_code($statusCode);

        if ((isset($response))) {
            echo json_encode([
                "success" => $success,
                "result"  => $response->toArray()
            ]);
        } else {
            echo json_encode(["success" => $success]);
        }

        exit;
    }
}
