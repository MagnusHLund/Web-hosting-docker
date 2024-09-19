<?php

namespace MagZilla\Api\Models\ORM;

use illuminate\database\Eloquent\Model;

class UsersTable extends Model
{
    protected $table = 'Users';
    protected $primaryKey = 'user_id';
    protected $fillable = [
        "user_name",
        "email",
        "password",
        "salt"
    ];
    protected $casts = [
        "user_name" => "string",
        "email"     => "string",
        "password"  => "string",
        "salt"      => "string"
    ];
    public $timestamps = false;
}
