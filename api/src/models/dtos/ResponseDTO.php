<?php

namespace MagZilla\Api\Models\DTOs;

use MagZilla\Api\Interfaces\DTOs\IDTO;

abstract class ResponseDTO implements IDTO
{
    abstract public function toArray();
}
