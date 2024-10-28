<?php

namespace MagZilla\Api\Middleware;

use MagZilla\Api\Managers\Logger;
use MagZilla\Api\Services\ResponseService;

abstract class BaseMiddleware
{
    private readonly ResponseService $responseService;
    private readonly Logger $logger;

    public function __construct()
    {
        $this->responseService = ResponseService::getInstance();
        $this->logger = Logger::getInstance();
    }

    protected function handleError($response, $httpStatusCode = 401)
    {
        $this->logger->writeSystemLog($response);
        $this->responseService->sendResponse($response, $httpStatusCode);
    }
}
