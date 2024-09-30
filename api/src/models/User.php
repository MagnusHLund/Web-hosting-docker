<?php

namespace MagZilla\Api\Models;

use MagZilla\Api\Handlers\CookieHandler;
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
}
