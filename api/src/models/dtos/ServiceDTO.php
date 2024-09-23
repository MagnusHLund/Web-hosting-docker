<?php

namespace MagZilla\Api\Models\DTOs;

class ServiceDTO extends BaseDTO
{
    public readonly null|int $serviceId;
    public readonly array $serviceTypes; // Array of ServiceTypeDTO's

    public function __construct(array $data)
    {
        parent::__construct();

        $this->serviceId    = $data['serviceId'];
        $this->serviceTypes = array_map(function ($serviceTypeData) {
            return new ServiceTypeDTO($serviceTypeData);
        }, $data['serviceTypes']);

        $this->validate($this->toArray());
    }

    public function toArray()
    {
        return [
            "serviceId"    => $this->serviceId,
            "serviceTypes" => $this->serviceTypes
        ];
    }
}
