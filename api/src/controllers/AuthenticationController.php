<?php

namespace MagZilla\Api\Controllers;

use MagZilla\Api\Handlers\CookieHandler;
use MagZilla\Api\Models\DTOs\Auth\LoginRequest;
use MagZilla\Api\Models\OrmModelMapper;
use MagZilla\Api\Models\DTOs\Auth\UpdatePasswordRequest;
use MagZilla\Api\Models\User;

class AuthenticationController extends BaseController
{
    private readonly CookieHandler $cookieHandler;

    public function __construct()
    {
        parent::__construct();

        $this->cookieHandler = CookieHandler::getInstance();
    }

    public function updatePassword($request)
    {
        try {
            $updatePasswordRequest = new UpdatePasswordRequest($request);

            $user = new User;
            $userId = $user->getUserIdFromJwt(
                $this->cookieHandler,
                $this->securityManager
            );

            $salt = $this->securityManager->generateSalt();
            $hashedPassword = $this->securityManager->hashPassword(
                $updatePasswordRequest->newPassword,
                $salt
            );

            $this->database->update(
                OrmModelMapper::UsersTable->getModel(),
                ["user_id" => $userId],
                [
                    "password" => $hashedPassword,
                    "salt" => $salt
                ]
            );

            $this->handleSuccess(null, 204);
        } catch (\Exception $e) {
            // TODO
        }
    }

    public function login($request)
    {
        $loginRequest = new LoginRequest($request);

        $queryLimit = 1;
        $userAuthData = $this->database->read(
            OrmModelMapper::UsersTable->getModel(),
            ["email" => $loginRequest->email],
            ["user_id", "password", "salt"],
            $queryLimit
        );

        $validPassword = $this->securityManager->verifyHashedPassword(
            $loginRequest->password,
            $userAuthData['password'],
            $userAuthData['salt']
        );

        if ($validPassword) {
            $jwt = $this->securityManager->encodeJwt($userAuthData['user_id']);
            $this->cookieHandler->setCookie("jwt", $jwt);

            $this->handleSuccess(null, 204);
        }
    }

    public function logout()
    {
        // TODO: Add deny list for removed JWTs?

        $this->cookieHandler->removeCookie("jwt");
    }
}
