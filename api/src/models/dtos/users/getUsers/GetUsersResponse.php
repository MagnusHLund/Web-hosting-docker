<?php

namespace MagZilla\Api\Models\DTOs\Users;

use MagZilla\Api\Models\DTOs\ResponseDTO;

class GetUsersResponse extends ResponseDTO
{
    public readonly array $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function toArray()
    {
        return [
            "users" => $this->users,
        ];
    }
}
