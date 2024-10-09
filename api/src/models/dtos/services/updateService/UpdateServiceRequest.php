<?php

namespace MagZilla\Api\Models\DTOs\Services;

use MagZilla\Api\Models\DTOs\RequestDTO;
use MagZilla\Api\Models\Service;

class UpdateServiceRequest extends RequestDTO
{
    public readonly Service $service;

    public function __construct(array $data)
    {
        parent::__construct();

        $this->service = new Service($data['serviceId'], null, null, null, null, $data['isActive']);

        $this->validate($this->toArray());
    }

    public function toArray()
    {
        return [
            "x" => $this->x,
        ];
    }
}
