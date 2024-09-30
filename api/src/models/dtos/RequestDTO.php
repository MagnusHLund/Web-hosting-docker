<?php

namespace MagZilla\Api\Models\DTOs;

use ReflectionClass;
use InvalidArgumentException;
use MagZilla\Api\Interfaces\DTOs\IDTO;

abstract class RequestDTO implements IDTO
{
    protected readonly ReflectionClass $reflection;

    public function __construct()
    {
        $this->reflection = new \ReflectionClass($this);
    }

    abstract public function toArray();

    protected function validate(array $data)
    {
        foreach ($this->reflection->getProperties() as $property) {
            $propertyName = $property->getName();
            $propertyType = $property->getType();

            if (!isset($data[$propertyName])) {
                throw new InvalidArgumentException("Missing property: $propertyName");
            }

            if ($propertyType && !$this->isValidType($data[$propertyName], $propertyType)) {
                throw new InvalidArgumentException("Invalid type for property: $propertyName");
            }
        }
    }

    protected function isValidType($value, \ReflectionNamedType $propertyType): bool
    {
        $allowsNull = $propertyType->allowsNull();

        if ($allowsNull) {
            return true;
        }

        switch ($propertyType) {
            case 'int':
                return is_int($value);
            case 'string':
                return is_string($value);
            case 'bool':
                return is_bool($value);
            case 'array':
                return is_array($value);
            default:
                return $value instanceof $propertyType;
        }
    }
}
