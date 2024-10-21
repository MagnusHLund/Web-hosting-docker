<?php

namespace MagZilla\Api\Utils;

class Constants
{
    public static function getDatabaseInfo()
    {
        return array(
            "DB_HOST" => $_ENV['DB_HOST'],
            "DB_NAME" => $_ENV['DB_NAME'],
            "DB_USER" => $_ENV['DB_USER'],
            "DB_PASS" => $_ENV['DB_PASS'],
        );
    }

    public static function getKid()
    {
        return $_ENV['KID'];
    }

    public static function getAllowedCorsOrigins()
    {
        return explode(', ', $_ENV['ALLOWED_CORS_ORIGINS']);
    }

    public static function getEncryptionKey()
    {
        return $_ENV['ENCRYPTION_KEY'];
    }

    public static function getJwtSecretKey()
    {
        return $_ENV['JWT_SECRET_KEY'];
    }

    public static function getBaseServiceDirectory()
    {
        return $_ENV['BASE_SERVICE_DIRECTORY'];
    }

    public static function getBaseConfigDirectory()
    {
        return $_ENV['BASE_CONFIG_DIRECTORY'];
    }
}
