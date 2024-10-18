<?php

namespace MagZilla\Api\Models\DTOs\Users;

use MagZilla\Api\Models\DTOs\ResponseDTO;

class AddUserResponse extends ResponseDTO
{
    public readonly int $userId;
    public readonly string $userName;
    public readonly string $email;
    public readonly bool $isAdmin;
    public readonly bool $isActive;

    public function __construct($userId, $userName, $email, $isAdmin, $isActive)
    {
        $this->userId    = $userId;
        $this->userName  = $userName;
        $this->email     = $email;
        $this->isAdmin  = $isAdmin;
        $this->isActive = $isActive;
    }

    public function toArray()
    {
        return [
            "userId"   => $this->userId,
            "name"     => $this->userName,
            "email"    => $this->email,
            "isAdmin"  => $this->isAdmin,
            "isActive" => $this->isActive
        ];
    }
}
