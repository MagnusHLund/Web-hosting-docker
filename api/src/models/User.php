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

    public function isAdmin() {}

    public function isEnabled() {}

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
