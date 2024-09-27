<?php

namespace MagZilla\Api\Models\DTOs;

abstract class ResponseDTO
{
    abstract protected function toArray();
}
