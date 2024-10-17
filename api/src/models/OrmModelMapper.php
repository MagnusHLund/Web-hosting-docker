<?php

namespace MagZilla\Api\Models;

use Illuminate\Database\Eloquent\Model;
use MagZilla\Api\Models\ORM\ServicesTable;
use MagZilla\Api\Models\ORM\ServiceTypesTable;
use MagZilla\Api\Models\ORM\SettingsTable;
use MagZilla\Api\Models\ORM\UserRolesTable;
use MagZilla\Api\Models\ORM\UserServiceMappingsTable;
use MagZilla\Api\Models\ORM\UsersTable;

enum OrmModelMapper: string
{
    case ServicesTable = ServicesTable::class;
    case ServiceTypesTable = ServiceTypesTable::class;
    case SettingsTable = SettingsTable::class;
    case UserRolesTable = UserRolesTable::class;
    case UserServiceMappingsTable = UserServiceMappingsTable::class;
    case UsersTable = UsersTable::class;

    public function getModel(): Model
    {
        return new $this->value;
    }
}
