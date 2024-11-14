<?php

namespace MagZilla\Api\Models;

class ServiceType
{
    public readonly int|null $id;
    public string $type;
    public string $startupPath;
    public string|null $port;
    public string|null $dotEnvPath;
    public string|null $dotEnvFile;

    public function __construct($serviceTypeId, $type, $startupPath, $port = null, $dotEnvPath = null, $dotEnvFile = null)
    {
        $this->id          = $serviceTypeId;
        $this->type        = $type;
        $this->startupPath = $startupPath;
        $this->port        = $port;
        $this->dotEnvPath  = $dotEnvPath;
        $this->$dotEnvFile = $dotEnvFile;
    }

    public function toArray()
    {
        return array(
            "id"            => $this->id ?? "",
            "type"          => $this->type,
            "port"          => $this->port,
            "startupPath"   => $this->startupPath,
            "dotEnvPath"    => $this->dotEnvPath ?? "",
            "dotEnvFile"    => $this->dotEnvFile ?? "",
        );
    }
}
