<?php

namespace MagZilla\Api\Models\DTOs;

class ServiceTypeDTO extends BaseDTO
{
    public readonly null|int $ServiceTypeId;
    public readonly string $ServiceType;
    public readonly string $startupPath;
    public readonly string $dotEnvPath;
    // TODO: should dotEnvFile be here too? Not entirely sure how the file transfers will work. 
    public readonly null|int $port;

    public function __construct(array $data)
    {
        $this->ServiceTypeId = $data['ServiceTypeId'];
        $this->ServiceType   = $data['ServiceType'];
        $this->startupPath   = $data['startupPath'];
        $this->dotEnvPath    = $data['dotEnvPath'];
        $this->port          = $data['port'];

        $this->validate($this->toArray());
    }

    public function toArray()
    {
        return [
            "ServiceTypeId" => $this->ServiceTypeId,
            "ServiceType"   => $this->ServiceType,
            "startupPath"   => $this->startupPath,
            "dotEnvPath"    => $this->dotEnvPath,
            "port"          => $this->port
        ];
    }
}
