<?php

namespace MagZilla\Api\Models\DTOs;

class AddServiceDTO extends BaseDTO
{
    // TODO: Not entirely sure how file uploading will work yet. Might need to change this one.
    public readonly string $serviceName;
    public readonly string $projectFiles;
    public readonly string $serviceTypes;

    public function __construct(array $data)
    {
        parent::__construct();

        $this->serviceName    = $data['serviceName'];
        $this->projectFiles = $data['projectFiles'];

        $this->serviceTypes = array_map(function ($serviceTypeData) {
            return new ServiceTypeDTO($serviceTypeData);
        }, $data['serviceTypes']);

        $this->validate($this->toArray());
    }

    public function toArray()
    {
        return [
            "serviceName"  => $this->serviceName,
            "projectFiles" => $this->projectFiles,
            "serviceTypes" => $this->serviceTypes
        ];
    }
}
