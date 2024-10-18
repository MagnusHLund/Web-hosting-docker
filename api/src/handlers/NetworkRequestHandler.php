<?php

namespace MagZilla\Api\Handlers;

use GuzzleHttp\Client;

class NetworkRequestHandler
{
    private static $instance = null;

    private $client;

    private function __construct()
    {
        $this->client = new Client();
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function sendGetRequest($url)
    {
        return $this->client->request("GET", $url);
    }
}
