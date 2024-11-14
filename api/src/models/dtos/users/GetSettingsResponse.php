<?php

namespace MagZilla\Api\Models\DTOs\Users;

use MagZilla\Api\Models\DTOs\ResponseDTO;

class GetSettingsResponse extends ResponseDTO
{
    public readonly bool $darkMode;
    public readonly string $language;

    public function __construct($darkMode, $language)
    {
        $this->darkMode  = $darkMode;
        $this->language  = $language;
    }

    public function toArray()
    {
        return [
            "darkMode" => $this->darkMode,
            "language" => $this->language,
        ];
    }
}
