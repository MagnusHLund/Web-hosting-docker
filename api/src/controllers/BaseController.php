<?php

namespace MagZilla\Api\Controllers;

use MagZilla\Api\Managers\DatabaseManager;
use MagZilla\Api\Utils\PayloadValidator;

abstract class BaseController
{
    protected readonly DatabaseManager $database;

    public function __construct()
    {
        $this->database = DatabaseManager::getInstance();
    }

    protected function sendResponse($response, $statusCode = 200)
    {
        $success = true;

        if ($statusCode > 400) {
            $success = false;
        }

        http_response_code($statusCode);
        echo json_encode(["success" => $success, "result" => $response]);
    }

    protected function handleError(\Exception $e)
    {
        // TODO
    }
}
