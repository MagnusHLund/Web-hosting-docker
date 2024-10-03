<?php

namespace MagZilla\Api\Models;

use MagZilla\Api\Handlers\CookieHandler;
use MagZilla\Api\Managers\DatabaseManager;
use MagZilla\Api\Managers\SecurityManager;

class User
{
    public readonly int $id;

    public function __construct($userId)
    {
        $this->id = $userId;
    }

    public static function getUserFromJwt(CookieHandler $cookieHandler, SecurityManager $securityManager)
    {
        $jwt = $cookieHandler->readCookie("jwt");
        $decodedJwt = $securityManager->decodeJwt($jwt);

        $userId = $decodedJwt['sub'];

        return new User($userId);
    }

    public function isAdmin(DatabaseManager $database)
    {
        $queryLimit = 1;
        return (bool) $database->read(
            OrmModelMapper::UserRolesTable->getModel(),
            ["user_id" => $this->id],
            ["is_admin"],
            $queryLimit
        );
    }

    public function isEnabled(DatabaseManager $database)
    {
        $queryLimit = 1;
        return (bool) $database->read(
            OrmModelMapper::UserRolesTable->getModel(),
            ["user_id" => $this->id],
            ["is_active"],
            $queryLimit
        );
    }

    public function getName(DatabaseManager $database)
    {
        $queryLimit = 1;
        return $database->read(
            OrmModelMapper::UsersTable->getModel(),
            ["user_id" => $this->id],
            ["user_name"],
            $queryLimit
        );
    }
}
