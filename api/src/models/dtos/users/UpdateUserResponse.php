<?php

namespace MagZilla\Api\Models\DTOs\users;

use MagZilla\Api\Models\DTOs\ResponseDTO;
use MagZilla\Api\Models\Settings;
use MagZilla\Api\Models\User;

class UpdateUserResponse extends ResponseDTO
{
    public readonly User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function toArray()
    {
        return [
            "userId" => $this->user->id,
            "name" => $this->user->name,
            "email" => $this->user->email,
            "isAdmin" => $this->user->isAdmin,
            "isActive" => $this->user->isActive
        ];
    }
}
