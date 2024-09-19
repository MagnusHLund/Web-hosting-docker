<?php

namespace MagZilla\Api\Models\ORM;

use illuminate\database\Eloquent\Model;

class UserServiceMappingsTable extends Model
{
    protected $table = 'UserServiceMappings';
    protected $primaryKey = 'user_services_id';
    protected $fillable = [
        "user_id",
        "service_id",
    ];
    protected $casts = [
        "user_id"    => "integer",
        "service_id" => "integer",
    ];
    public $timestamps = false;
}
