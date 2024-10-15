<?php

namespace MagZilla\Api\Models\DTOs\Users;

use MagZilla\Api\Models\DTOs\RequestDTO;

class UpdateSettingRequest extends RequestDTO
{
    public readonly string $settingName;
    public readonly string|int $settingValue;

    public function __construct(array $data)
    {
        parent::__construct();

        $this->settingName  = $data['settingName'];
        $this->settingValue = $data['settingValue'];

        $this->validate($this->toArray());
    }

    public function toArray()
    {
        return [
            "settingName"  => $this->settingName,
            "settingValue" => $this->settingValue,
        ];
    }
}
