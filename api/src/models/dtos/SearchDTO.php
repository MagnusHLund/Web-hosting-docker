<?php

namespace MagZilla\Api\Models\DTOs;

class SearchDTO extends BaseDTO
{
    public readonly string $search;

    public function __construct(array $data)
    {
        $this->search = $data['search'];

        $this->validate($this->toArray());
    }

    public function toArray()
    {
        return [
            "search" => $this->search
        ];
    }
}
