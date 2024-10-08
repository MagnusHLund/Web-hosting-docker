<?php

namespace MagZilla\Api\Models\DTOs\Users;

use MagZilla\Api\Models\DTOs\ResponseDTO;
use MagZilla\Api\Models\Service;

class GetServiceDetailsResponse extends ResponseDTO
{
    public readonly Service $service;

    public function __construct(service $service)
    {
        $this->service  = $service;
    }

    public function toArray()
    {
        return [];
    }
}
