<?php

namespace MagZilla\Api\Models\DTOs\Users;

use MagZilla\Api\Models\DTOs\RequestDTO;

class DeleteUserRequest extends RequestDTO
{
    public readonly int $userId;

    public function __construct(array $data)
    {
        parent::__construct();

        $this->userId = $data['userId'];

        $this->validate($this->toArray());
    }

    public function toArray()
    {
        return [
            "userId" => $this->userId,
        ];
    }
}
