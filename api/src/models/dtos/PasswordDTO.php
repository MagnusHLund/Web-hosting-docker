<?php

namespace MagZilla\Api\Models\DTOs;

class PasswordDTO extends BaseDTO
{
    public readonly int $userId;
    public readonly string $password;

    public function __construct(array $data)
    {
        parent::__construct();

        $this->userId   = $data['userId'];
        $this->password = $data['password'];

        $this->validate($this->toArray());
    }

    public function toArray()
    {
        return [
            "userId"   => $this->userId,
            "password" => $this->password
        ];
    }
}
