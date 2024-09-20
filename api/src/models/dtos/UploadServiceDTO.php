<?php

namespace MagZilla\Api\Models\DTOs;

class UploadServiceDTO extends BaseDTO
{
    // TODO: Not entirely sure how file uploading will work yet. Might need an additional property.
    public readonly int $serviceId;
    public readonly null|string $gitUrl;

    public function __construct(array $data)
    {
        $this->serviceId = $data['serviceId'];
        $this->gitUrl    = $data['gitUrl'];

        $this->validate($this->toArray());
    }

    public function toArray()
    {
        return [
            "serviceId" => $this->serviceId,
            "gitUrl"    => $this->gitUrl
        ];
    }
}
