<?php

namespace MagZilla\Api\Models\DTOs;

class LoginDTO extends BaseDTO
{
    public readonly string|null $email;
    public readonly string $password;

    public function __construct(array $data)
    {
        parent::__construct();

        $this->email    = $data['email'];
        $this->password = $data['password'];

        $this->validate($this->toArray());
    }

    public function toArray()
    {
        return [
            "email"    => $this->email,
            "password" => $this->password
        ];
    }
}
