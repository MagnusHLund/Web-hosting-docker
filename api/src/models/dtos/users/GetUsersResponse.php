<?php

namespace MagZilla\Api\Models\DTOs\Users;

use MagZilla\Api\Models\DTOs\ResponseDTO;

class GetUsersResponse extends ResponseDTO
{
    public readonly array $users;

    public function __construct($users)
    {
        // $this->users = $users;

        $this->users = array_map(function ($user) {
            return [
                "userId"   => $user->user_id,
                "name"     => $user->user_name,
                "email"    => $user->email,
                "isAdmin"  => $user->is_admin,
                "isActive" => $user->is_active
            ];
        }, $users);
    }

    public function toArray()
    {
        return [
            "users" => $this->users,
        ];
    }
}
