<?php

namespace MagZilla\Api\Models\ORM;

use illuminate\database\Eloquent\Model;

class ServicesTable extends Model
{
    protected $table = 'Services';
    protected $primaryKey = 'service_id';
    protected $fillable = [
        "service_owner_user_id",
        "service_name",
        "git_clone_url",
        "is_active"
    ];
    protected $casts = [
        "service_owner_user_id" => "integer",
        "service_name"          => "string",
        "git_clone_url"         => "string",
        "is_active"             => "boolean",
    ];
    public $timestamps = false;
}
