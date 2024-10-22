<?php

namespace MagZilla\Api\Models\Exceptions;

use Exception;

class ControllerException extends Exception
{
    private readonly int $httpErrorCode;
    private readonly Exception|null $exception;

    public function __construct($message, int $httpErrorCode, Exception $originalException = null)
    {
        $this->message = $message;
        $this->httpErrorCode = $httpErrorCode;
        $this->exception = $originalException;
    }

    public function getHttpErrorCode()
    {
        return $this->httpErrorCode;
    }

    public function getOriginalException()
    {
        return $this->exception;
    }
}
