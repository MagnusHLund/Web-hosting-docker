<?php

namespace MagZilla\Api\Models\ORM;

use illuminate\database\Eloquent\Model;

class SettingsTable extends Model
{
    protected $table = 'Settings';
    protected $primaryKey = 'settings_id';
    protected $fillable = [
        "user_id",
        "dark_mode",
        "language",
    ];
    protected $casts = [
        "user_id"   => "integer",
        "dark_mode" => "boolean",
        "language"  => "string",
    ];
    public $timestamps = false;
}
