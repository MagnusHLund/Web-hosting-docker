<?php

namespace MagZilla\Handlers;

class CookieManager
{
    private static $instance = null;

    private function __construct() {}

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new CookieManager();
        }
        return self::$instance;
    }

    public function setJwtCookie($jwt)
    {
        $cookieName = "jwt";

        $oneDay = 86400;
        $expirationDate = time() + $oneDay;

        setcookie($cookieName, $jwt, $expirationDate, "/", "", false, true);
    }

    public function unsetCookie($cookieName)
    {
        $oneHour = 3600;
        $expirationTime = time() - $oneHour;

        setcookie($cookieName, "", $expirationTime);
    }

    public function readCookie($cookieName)
    {
        return $_COOKIE[$cookieName];
    }
}
