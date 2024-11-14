<?php

namespace MagZilla\Api\Models\DTOs\Services;

use MagZilla\Api\Models\DTOs\RequestDTO;

class GetServiceDetailsRequest extends RequestDTO
{
    public readonly string $serviceId;

    public function __construct(array $data)
    {
        parent::__construct();

        $this->serviceId = $data['serviceId'];

        $this->validate($this->toArray());
    }

    public function toArray()
    {
        return [
            "serviceId" => $this->serviceId,
        ];
    }
}
