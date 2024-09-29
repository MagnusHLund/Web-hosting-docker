<?php

namespace MagZilla\Api\Controllers;

use MagZilla\Api\Handlers\LogHandler;
use MagZilla\Api\Handlers\ResponseHandler;
use MagZilla\Api\Managers\DatabaseManager;
use MagZilla\Api\Managers\SecurityManager;
use MagZilla\Api\Models\DTOs\ResponseDTO;

abstract class BaseController
{
    protected readonly LogHandler $logHandler;
    protected readonly DatabaseManager $database;
    protected readonly SecurityManager $securityManager;

    private readonly ResponseHandler $responseHandler;

    public function __construct()
    {
        $this->logHandler = LogHandler::getInstance();
        $this->database = DatabaseManager::getInstance();
        $this->securityManager = SecurityManager::getInstance();
        $this->responseHandler = ResponseHandler::getInstance();
    }

    protected function handleSuccess(ResponseDTO $response = null, $statusCode = 200)
    {
        $this->responseHandler->sendResponse($response, $statusCode);
    }

    protected function handleError(\Exception $exception, $response, $statusCode = 500)
    {
        $this->logHandler->writeLog($exception);
        $this->responseHandler->sendResponse($response, $statusCode);
    }
}
