<?php

namespace MagZilla\Api\Models\DTOs\Services;

use InvalidArgumentException;
use MagZilla\Api\Models\DTOs\RequestDTO;
use MagZilla\Api\Models\ServiceType;
use ReflectionClass;

class AddServiceRequest extends RequestDTO
{
    public readonly string $serviceName;
    public readonly string $projectFiles; // Handles both GitUrl & ZipFile
    public readonly array $serviceTypes;

    public function __construct(array $data)
    {
        parent::__construct();

        $serviceTypeReflectionClass = new ReflectionClass(ServiceType::class);

        $this->serviceName  = $data['serviceName'];
        $this->projectFiles = $data['projectFiles'];

        $this->serviceTypes = array_map(function ($serviceTypeData) use ($serviceTypeReflectionClass) {

            $serviceType = new ServiceType(
                null,
                $serviceTypeData['type'],
                $serviceTypeData['startupPath'],
                $serviceTypeData['port'],
                $serviceTypeData['dotEnvPath'],
                $serviceTypeData['dotEnvFile'],
            );

            $this->validate($serviceType->toArray(), $serviceTypeReflectionClass);

            return $serviceType;
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
