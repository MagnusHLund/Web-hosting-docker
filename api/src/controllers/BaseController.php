<?php

namespace MagZilla\Api\Controllers;

use MagZilla\Api\Handlers\ResponseHandler;
use MagZilla\Api\Managers\DatabaseManager;
use MagZilla\Api\Managers\SecurityManager;
use MagZilla\Api\Models\DTOs\ResponseDTO;

abstract class BaseController
{
    protected readonly DatabaseManager $database;
    protected readonly SecurityManager $securityManager;

    private readonly ResponseHandler $responseHandler;

    public function __construct()
    {
        $this->database = DatabaseManager::getInstance();
        $this->securityManager = SecurityManager::getInstance();
        $this->responseHandler = ResponseHandler::getInstance();
    }

    protected function handleSuccess(ResponseDTO $response = null, $statusCode = 200)
    {
        $this->responseHandler->sendResponse($response, $statusCode);
    }

    protected function handleError(\Exception $e, $response, $statusCode = 500)
    {
        // TODO: Add a log, related to the exception

        $this->responseHandler->sendResponse($response, $statusCode);
    }
}
