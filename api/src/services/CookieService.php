<?php

namespace MagZilla\Api\Services;

class CookieService
{
    public const AUTHENTICATION_COOKIE_NAME = "authentication";

    private static $instance = null;

    private function __construct() {}

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
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

        setcookie($cookieName, "", $expirationTime, "/", "", false, true);
    }

    public function readCookie($cookieName)
    {
        if (isset($_COOKIE[$cookieName])) {
            return $_COOKIE[$cookieName];
        }

        // Throw some exception
    }

    public function isCookieExpired($cookieName)
    {
        $remainingCookieLifetimeInSeconds = $this->secondsToCookieExpire($cookieName);

        return $remainingCookieLifetimeInSeconds < 0;
    }

    public function secondsToCookieExpire($cookieName)
    {
        $cookie = json_decode($this->readCookie($cookieName));
        $expiration = $cookie['expires'];

        return time() - $expiration;
    }
}
