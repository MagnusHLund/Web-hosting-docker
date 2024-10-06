<?php

namespace MagZilla\Api\Models\DTOs\Users;

use MagZilla\Api\Models\DTOs\RequestDTO;

class SearchUsersRequest extends RequestDTO
{
    public readonly string $searchInput;

    public function __construct(array $data)
    {
        parent::__construct();

        $this->searchInput = $data['search'];

        $this->validate($this->toArray());
    }

    public function toArray()
    {
        return [
            "searchInput" => $this->searchInput,
        ];
    }
}
