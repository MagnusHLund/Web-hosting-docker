<?php

namespace MagZilla\Api\Models;

use MagZilla\Api\Handlers\CookieHandler;
use MagZilla\Api\Managers\SecurityManager;

class User
{
    public function __construct() {}

    public function getUserIdFromJwt(CookieHandler $cookieHandler, SecurityManager $securityManager)
    {
        $jwt = $cookieHandler->readCookie("jwt");
        $decodedJwt = $securityManager->decodeJwt($jwt);

        return $decodedJwt['sub'];
    }
}
