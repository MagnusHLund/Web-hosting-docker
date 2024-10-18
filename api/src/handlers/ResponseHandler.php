<?php

namespace MagZilla\Api\Handlers;

class ResponseHandler
{
    private static $instance = null;

    private function __construct() {}

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function sendResponse($response, $statusCode)
    {
        $success = $statusCode < 400;

        $this->addHeaders();

        http_response_code($statusCode);

        if (!empty($response)) {
            echo json_encode([
                "success" => $success,
                "result"  => $response
            ]);
        } else {
            echo json_encode(["success" => $success]);
        }

        exit;
    }

    private function addHeaders()
    {
        header('Content-Type: application/json');
    }
}
