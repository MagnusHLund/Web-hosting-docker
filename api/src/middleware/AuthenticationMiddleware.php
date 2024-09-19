<?php

namespace MagZilla\Api\Middleware;

use MagZilla\Api\Managers\SecurityManager;

class AuthenticationMiddleware
{
    public static function validateAuthentication($path)
    {
        try {
            if ($path != "/Api/auth/login") {
                if (!isset($_COOKIE['jwt'])) {
                    throw new \Exception("User is not logged in!");
                }

                if (!(bool) securityManager::getInstance()->decodeJwt($_COOKIE['jwt'])) {
                    throw new \Exception("User is not real");
                }
            }
        } catch (\Exception $e) {
            // TODO
            exit;
        }
    }
}
