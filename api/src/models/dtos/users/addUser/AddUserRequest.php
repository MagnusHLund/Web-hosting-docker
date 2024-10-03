<?php

namespace MagZilla\Api\Models\DTOs\Users;

use MagZilla\Api\Models\DTOs\RequestDTO;

class AddUserRequest extends RequestDTO
{
    public readonly string $userName;
    public readonly string $email;
    public readonly string $password;
    public readonly int $isAdmin;
    public readonly int $isActive;

    public function __construct(array $data)
    {
        parent::__construct();

        $this->userName = $data['name'];
        $this->email    = $data['email'];
        $this->password = $data['password'];
        $this->isAdmin  = $data['isAdmin'] ?? 0;
        $this->isActive = $data['isActive'] ?? 0;

        $this->validate($this->toArray());
    }

    public function toArray()
    {
        return [
            "userName" => $this->userName,
            "email"    => $this->email,
            "password" => $this->password,
            "isAdmin"  => $this->isAdmin,
            "isActive" => $this->isActive
        ];
    }
}
