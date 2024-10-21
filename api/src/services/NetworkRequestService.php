<?php

namespace MagZilla\Api\Services;

use GuzzleHttp\Client;

class NetworkRequestService
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
