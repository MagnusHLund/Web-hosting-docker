<?php

namespace MagZilla\Api\Models\DTOs\Services;

use MagZilla\Api\Models\DTOs\RequestDTO;
use MagZilla\Api\Models\ServiceType;

class UpdateServiceTypeRequest extends RequestDTO
{
    public readonly ServiceType $serviceType;

    public function __construct(array $data)
    {
        parent::__construct();

        $this->serviceType = new ServiceType(
            $data["serviceTypeId"],
            $data["type"],
            $data["startupPath"],
            $data["port"],
            $data["dotEnvPath"],
            $data["dotEnvFile"]
        );

        $this->validate($this->toArray());
    }

    public function toArray()
    {
        return [
            "serviceTypeId" => $this->serviceType->id,
            "type"          => $this->serviceType->type,
            "startupPath"   => $this->serviceType->startupPath,
            "port"          => $this->serviceType->port,
            "dotEnvPath"    => $this->serviceType->dotEnvPath,
        ];
    }
}
