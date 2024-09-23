<?php

namespace MagZilla\Api\Models\ORM;

use illuminate\database\Eloquent\Model;

class UserRolesTable extends Model
{
    protected $table = 'UserRoles';
    protected $primaryKey = 'user_roles_id';
    protected $fillable = [
        "user_id",
        "is_admin",
        "is_active",
    ];
    protected $casts = [
        "user_id"   => "integer",
        "is_admin"  => "boolean",
        "is_active" => "boolean",
    ];
    public $timestamps = false;
}
