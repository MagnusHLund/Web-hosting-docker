<?php

namespace MagZilla\Api\Middleware;

use MagZilla\Api\Services\CookieService;
use MagZilla\Api\Managers\DatabaseManager;
use MagZilla\Api\Managers\SecurityManager;
use MagZilla\Api\Models\User;

class AuthenticationMiddleware
{
    private static $instance = null;

    private CookieService $cookieService;
    private SecurityManager $securityManager;
    private DatabaseManager $database;

    private function __construct()
    {
        // TODO: Dependency injection

        $this->cookieService = CookieService::getInstance();
        $this->securityManager = SecurityManager::getInstance();
        $this->database = DatabaseManager::getInstance();
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function validateAuthentication($path)
    {
        try {
            if ($path != "/api/auth/login") {
                $cookieName = CookieService::AUTHENTICATION_COOKIE_NAME;
                $this->verifyValidAuthCookie($cookieName);

                $jwt = $this->securityManager->decodeJwt($this->cookieService->readCookie($cookieName));
                $this->verifyRealUser($jwt);

                $user = User::getUserFromJwt($this->cookieService, $this->securityManager);
                $this->verifyUserActivated($user);
            }
        } catch (\Exception $e) {
            // TODO
            exit;
        }
    }

    private function verifyValidAuthCookie($cookieName)
    {
        if (!isset($_COOKIE[$cookieName]) || $this->cookieService->isCookieExpired($cookieName)) {
            throw new \Exception("User is not logged in!");
        }
    }

    private function verifyRealUser($jwt)
    {
        if ($jwt === null) {
            throw new \Exception("User is not real");
        }
    }

    private function verifyUserActivated($user)
    {
        if (!$user->getIsActive($this->database)) {
            throw new \Exception("User is not active");
        }
    }
}
