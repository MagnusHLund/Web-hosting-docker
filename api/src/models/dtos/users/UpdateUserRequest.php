<?php

namespace MagZilla\Api\Models\DTOs\Users;

use MagZilla\Api\Models\DTOs\RequestDTO;

class UpdateUserRequest extends RequestDTO
{
    public readonly int $userId;
    public readonly string $name;
    public readonly string $email;
    public readonly bool|null $isAdmin;
    public readonly bool|null $isActive;

    public function __construct(array $data)
    {
        parent::__construct();

        $this->userId   = $data['userId'];
        $this->name     = $data['name'];
        $this->email    = $data['email'];
        $this->isAdmin  = $data['isAdmin'];
        $this->isActive = $data['isActive'];

        $this->validate($this->toArray());
    }

    public function toArray()
    {
        return [
            "userId"   => $this->userId,
            "name"     => $this->name,
            "email"    => $this->email,
            "isAdmin"  => $this->isAdmin,
            "isActive" => $this->isActive,
        ];
    }
}
