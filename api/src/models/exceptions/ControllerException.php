<?php

namespace MagZilla\Api\Models\Exceptions;

use Exception;

class ControllerException extends Exception
{
    private readonly int $httpErrorCode;

    public function __construct($message, $httpErrorCode)
    {
        $this->message = $message;
        $this->httpErrorCode = $httpErrorCode;
    }

    public function getHttpErrorCode()
    {
        return $this->httpErrorCode;
    }
}
