<?php

namespace MagZilla\Api\Models\DTOs\Users;

use MagZilla\Api\Models\DTOs\ResponseDTO;
use MagZilla\Api\Models\Settings;

class UpdateSettingResponse extends ResponseDTO
{
    public readonly Settings $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function toArray()
    {
        return [
            "darkMode" => $this->settings->darkMode,
            "language" => $this->settings->language,
        ];
    }
}
