<?php

namespace MagZilla\Api\Models\DTOs\Users;

use MagZilla\Api\Models\DTOs\RequestDTO;
use MagZilla\Api\Utils\TextCasingUtils;

class UpdateSettingRequest extends RequestDTO
{
    public readonly string $settingName;
    public readonly string $settingValue;

    public function __construct(array $data)
    {
        parent::__construct();

        $this->settingName  = TextCasingUtils::camelToSnake($data['setting']);
        $this->settingValue = $data['value'];

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
