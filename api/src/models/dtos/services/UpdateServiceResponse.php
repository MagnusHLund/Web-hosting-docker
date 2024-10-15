<?php

namespace MagZilla\Api\Models\DTOs\Services;

use MagZilla\Api\Models\DTOs\ResponseDTO;

class UpdateServiceResponse extends ResponseDTO
{
    public readonly int $x;

    public function __construct($x)
    {
        $this->x  = $x;
    }

    public function toArray()
    {
        return [
            "x" => $this->x,
        ];
    }
}
