<?php

namespace MagZilla\Api\Models\DTOs;

class SettingsDTO extends BaseDTO
{
    public readonly string $setting;
    public readonly string $value;

    public function __construct(array $data)
    {
        parent::__construct();

        $this->setting = $data['setting'];
        $this->value   = $data['value'];

        $this->validate($this->toArray());
    }

    public function toArray()
    {
        return [
            "setting" => $this->setting,
            "value"   => $this->value
        ];
    }
}
