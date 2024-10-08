<?php

namespace MagZilla\Api\Models;

use MagZilla\Api\Handlers\CookieHandler;
use MagZilla\Api\Managers\DatabaseManager;
use MagZilla\Api\Managers\SecurityManager;

class Service
{
    public readonly int $id;
    public array $serviceTypes; // Array of MagZilla\Api\Models\ServiceType
    public string $accessToService;

    public function __construct($serviceId, $, $serviceTypes = null, $accessToService = null)
    {
        $this->id = $serviceId;
        $this->serviceTypes = $serviceTypes;
        $this->accessToService = $accessToService;
    }
}
