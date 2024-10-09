<?php

namespace MagZilla\Api\Models;

class Service
{
    public readonly int $id;
    public readonly string $serviceName;
    public readonly array $serviceTypes; // Array of MagZilla\Api\Models\ServiceType
    public readonly string $accessToService;
    public readonly string|null $gitCloneUrl;
    public readonly FileUpload|null $fileUpload;

    public function __construct($serviceId, $serviceName = null, $serviceTypes = null, $accessToService = null, $gitCloneUrl = null, $fileUpload = null, $isActive = null,)
    {
        $this->id = $serviceId;
        $this->serviceName = $serviceName;
        $this->serviceTypes = $serviceTypes;
        $this->accessToService = $accessToService;
        $this->gitCloneUrl = $gitCloneUrl;
        $this->fileUpload = $fileUpload;
    }
}
