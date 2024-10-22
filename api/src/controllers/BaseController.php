<?php

namespace MagZilla\Api\Controllers;

use MagZilla\Api\Managers\Logger;
use MagZilla\Api\Services\CookieService;
use MagZilla\Api\Models\DTOs\ResponseDTO;
use MagZilla\Api\Handlers\ResponseHandler;
use MagZilla\Api\Managers\DatabaseManager;
use MagZilla\Api\Managers\SecurityManager;

abstract class BaseController
{
    protected readonly Logger $logger;
    protected readonly DatabaseManager $database;
    protected readonly CookieService $cookieService;
    protected readonly SecurityManager $securityManager;

    private readonly ResponseHandler $responseHandler;

    public function __construct()
    {
        $this->logger          = Logger::getInstance();
        $this->database        = DatabaseManager::getInstance();
        $this->cookieService   = CookieService::getInstance();
        $this->securityManager = SecurityManager::getInstance();
        $this->responseHandler = ResponseHandler::getInstance();
    }

    protected function handleSuccess(ResponseDTO $response = null, $statusCode = 200)
    {
        $this->responseHandler->sendResponse($response, $statusCode);
    }

    protected function handleError(\Exception $exception, $response, $statusCode = 500)
    {
        $this->logger->writeLog($exception);
        $this->responseHandler->sendResponse($response, $statusCode);
    }
}
