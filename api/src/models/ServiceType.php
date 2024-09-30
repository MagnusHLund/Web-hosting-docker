<?php

namespace MagZilla\Api\Models;

class ServiceType
{
    public readonly int|null $id;
    public string $type;
    public string $startupPath;
    public string|null $dotEnvPath;
    public string|null $dotEnvFile;
    public int|null $port;

    public function __construct($serviceTypeId, $type, $startupPath, $dotEnvPath = null, $dotEnvFile = null, $port = null)
    {
        $this->id          = $serviceTypeId;
        $this->type        = $type;
        $this->startupPath = $startupPath;
        $this->dotEnvPath  = $dotEnvPath;
        $this->$dotEnvFile = $dotEnvFile;
        $this->port        = $port;
    }

    public function toArray()
    {
        return array(
            "serviceTypeId" => $this->id,
            "type"          => $this->type,
            "startupPath"   => $this->startupPath,
            "dotEnvPath"    => $this->dotEnvPath,
            "dotEnvFile"    => $this->dotEnvFile,
            "port"          => $this->port,
        );
    }
}
