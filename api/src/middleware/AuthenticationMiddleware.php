<?php

namespace MagZilla\Api\Middleware;

use MagZilla\Api\Models\User;
use MagZilla\Api\Services\CookieService;
use MagZilla\Api\Managers\DatabaseManager;
use MagZilla\Api\Managers\SecurityManager;
use MagZilla\Api\Middleware\BaseMiddleware;

class AuthenticationMiddleware extends BaseMiddleware
{
    private static $instance = null;

    private readonly DatabaseManager $database;
    private readonly CookieService $cookieService;
    private readonly SecurityManager $securityManager;

    private function __construct()
    {
        parent::__construct();

        // TODO: Dependency injection

        $this->database = DatabaseManager::getInstance();
        $this->cookieService = CookieService::getInstance();
        $this->securityManager = SecurityManager::getInstance();
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
        if ($path != "/api/auth/login") {
            $cookieName = CookieService::AUTHENTICATION_COOKIE_NAME;
            $this->verifyValidAuthCookie($cookieName);

            $jwt = $this->securityManager->decodeJwt($this->cookieService->readCookie($cookieName));
            $this->verifyRealUser($jwt);

            $this->verifyUserActivated();
        }
    }

    private function verifyValidAuthCookie($cookieName)
    {
        if (!isset($_COOKIE[$cookieName]) || $this->cookieService->isCookieExpired($cookieName)) {
            $this->handleError("User is not logged in");
        }
    }

    private function verifyRealUser($jwt)
    {
        if ($jwt === null) {
            // TODO: Ban ip temporarily?
            $this->handleError("User is not real");
        }
    }

    private function verifyUserActivated()
    {
        $user = User::getUserFromJwt($this->cookieService, $this->securityManager);

        if (!$user->getIsActive($this->database)) {
            $this->handleError("User is not active");
        }
    }
}
