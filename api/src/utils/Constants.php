<?php

namespace MagZilla\Api\Utils;

class Constants
{
    public static function getDatabaseInfo()
    {
        return array(
            "DB_HOST" => $_ENV['DB_HOST'],
            "DB_USER" => $_ENV['DB_USER'],
            "DB_PASSWORD" => $_ENV['DB_PASSWORD'],
            "DB_DATABASE" => $_ENV['DB_DATABASE'],
        );
    }

    public static function getKid()
    {
        return $_ENV['KID'];
    }

    public static function getAllowedOrigins()
    {
        return explode(', ', $_ENV['ALLOWED_HOSTS']);
    }

    public static function getEncryptionKey()
    {
        return $_ENV['ENCRYPTION_KEY'];
    }

    public static function getPepper()
    {
        return $_ENV['PEPPER'];
    }

    public static function getJwtSecretKey()
    {
        return $_ENV['JWT_SECRET_KEY'];
    }

    public static function getAllowedCorsOrigins()
    {
        return $_ENV['ALLOWED_CORS_ORIGINS'];
    }
}
