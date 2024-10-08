<?php

namespace MagZilla\Api\Models\DTOs\Users;

use MagZilla\Api\Models\DTOs\ResponseDTO;

class AddServiceResponse extends ResponseDTO
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
