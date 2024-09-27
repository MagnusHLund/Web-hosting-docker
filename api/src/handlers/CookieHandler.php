<?php

namespace MagZilla\Api\Handlers;

class CookieHandler
{
    private static $instance = null;

    private function __construct() {}

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new CookieHandler();
        }
        return self::$instance;
    }

    public function setCookie($name, $value, $expirationTime = 86400, $httpOnly = true)
    {
        $expirationDate = time() + $expirationTime;

        setcookie($name, $value, $expirationDate, "/", "", false, $httpOnly);
    }

    /**
     * Expires a cookie, by setting $expirationTime to the start of UNIX time (1970)
     */
    public function removeCookie($cookieName)
    {
        $expirationTime = 0;

        setcookie($cookieName, "", $expirationTime);
    }

    public function readCookie($cookieName)
    {
        return $_COOKIE[$cookieName];
    }
}
