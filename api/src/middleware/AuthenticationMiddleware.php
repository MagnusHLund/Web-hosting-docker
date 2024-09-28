<?php

namespace MagZilla\Api\Middleware;

use MagZilla\Api\Handlers\CookieHandler;
use MagZilla\Api\Managers\SecurityManager;

class AuthenticationMiddleware
{
    public static function validateAuthentication($path)
    {
        try {
            if ($path != "/api/auth/login") {
                if (!isset($_COOKIE['jwt'])) {
                    throw new \Exception("User is not logged in!");
                }

                if (SecurityManager::getInstance()->decodeJwt(CookieHandler::getInstance()->readCookie("jwt")) !== null) {
                    throw new \Exception("User is not real");
                }
            }
        } catch (\Exception $e) {
            // TODO
            exit;
        }
    }
}
