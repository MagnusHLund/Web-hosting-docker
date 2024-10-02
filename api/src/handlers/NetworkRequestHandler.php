<?php

namespace MagZilla\Api\Handlers;

class NetworkRequestHandler
{
    private static $instance = null;

    private function __construct() {}

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new NetworkRequestHandler();
        }
        return self::$instance;
    }

    public function sendGetRequest() {}
}
