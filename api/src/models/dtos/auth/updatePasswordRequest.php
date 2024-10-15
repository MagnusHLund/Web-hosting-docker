<?php

namespace MagZilla\Api\Models\DTOs\Auth;

use MagZilla\Api\Models\DTOs\RequestDTO;

class UpdatePasswordRequest extends RequestDTO
{
    public readonly string $newPassword;

    public function __construct(array $data)
    {
        parent::__construct();
        $this->newPassword = $data['password'];

        $this->validate($this->toArray());
    }

    public function toArray()
    {
        return [
            "newPassword" => $this->newPassword
        ];
    }
}
