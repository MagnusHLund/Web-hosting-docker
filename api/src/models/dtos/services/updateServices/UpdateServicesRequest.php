<?php

namespace MagZilla\Api\Models\DTOs\Services;

use MagZilla\Api\Models\DTOs\RequestDTO;

class UpdateServicesRequest extends RequestDTO
{
    public readonly string $x;

    public function __construct(array $data)
    {
        parent::__construct();

        $this->x = $data['x'];

        $this->validate($this->toArray());
    }

    public function toArray()
    {
        return [
            "x" => $this->x,
        ];
    }
}
