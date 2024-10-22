<?php

namespace MagZilla\Api\Models\DTOs\Services;

use InvalidArgumentException;
use MagZilla\Api\Models\DTOs\RequestDTO;
use MagZilla\Api\Models\ServiceType;

class AddServiceRequest extends RequestDTO
{
    public readonly string $serviceName;
    public readonly string $projectFiles; // Handles both GitUrl & ZipFile
    public readonly array $serviceTypes;

    public function __construct(array $data)
    {
        parent::__construct();

        $this->serviceName  = $data['serviceName'];
        $this->projectFiles = $data['zipFile'];

        $this->serviceTypes = array_map(function ($serviceTypeData) {
            return
                new ServiceType(
                    null,
                    $serviceTypeData['type'],
                    $serviceTypeData['port'],
                    $serviceTypeData['startupPath'],
                    $serviceTypeData['dotEnvPath'],
                    $serviceTypeData['dotEnvFile'],
                    $serviceTypeData['file'],
                );
        }, $data['serviceTypes']);

        $this->validate($this->toArray());
        $this->validate($this->serviceTypes);
    }

    public function toArray()
    {
        return [
            "serviceName"  => $this->serviceName,
            "zip"          => $this->projectFiles,
            "serviceTypes" => $this->serviceTypes
        ];
    }

    protected function validate(array $data)
    {
        foreach ($this->reflection->getProperties() as $property) {
            $propertyName = $property->getName();
            $propertyType = $property->getType();

            if (isset($this->gitUrl) && isset($this->projectFiles)) {
                throw new InvalidArgumentException("Can not upload using zip and git at the same time!");
            }

            if (empty($this->gitUrl) && empty($this->projectFiles)) {
                throw new InvalidArgumentException("Must upload either git or zip file!");
            }

            if (!isset($data[$propertyName])) {
                throw new InvalidArgumentException("Missing property: $propertyName");
            }

            if ($propertyType && !$this->isValidType($data[$propertyName], $propertyType)) {
                throw new InvalidArgumentException("Invalid type for property: $propertyName");
            }
        }
    }
}
