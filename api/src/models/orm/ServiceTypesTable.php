<?php

namespace MagZilla\Api\Models\ORM;

use illuminate\database\Eloquent\Model;

class ServiceTypesTable extends Model
{
    protected $table = 'ServiceTypes';
    protected $primaryKey = 'service_type_id';
    protected $fillable = [
        "service_id",
        "type",
        "startup_location",
        "env_location",
        "port"
    ];
    protected $casts = [
        "service_id"       => "integer",
        "type"             => "string",
        "startup_location" => "string",
        "env_location"     => "string",
        "port"             => "integer"
    ];
    public $timestamps = false;
}
