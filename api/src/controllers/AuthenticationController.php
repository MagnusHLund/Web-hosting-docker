<?php

namespace MagZilla\Api\Controllers;

use MagZilla\Api\Services\CookieService;
use MagZilla\Api\Models\User;
use MagZilla\Api\Models\OrmModelMapper;
use MagZilla\Api\Models\DTOs\Auth\LoginRequest;
use MagZilla\Api\Models\Exceptions\ControllerException;
use MagZilla\Api\Models\DTOs\Auth\UpdatePasswordRequest;

class AuthenticationController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function updatePassword($request)
    {
        try {
            $updatePasswordRequest = new UpdatePasswordRequest($request);

            $user = User::getUserFromJwt(
                $this->cookieService,
                $this->securityManager
            );

            if (isset($updatePasswordRequest->userId) && !$user->getIsAdmin($this->database) && $user->id !== $updatePasswordRequest->userId) { // TODO: Test this
                throw new ControllerException("Can not change password of other users!", 401);
            }

            $userToUpdate = $updatePasswordRequest->userId ?? $user->id;

            $passwordData = $this->securityManager->generateHashedPassword($updatePasswordRequest->newPassword);

            $this->database->update(
                OrmModelMapper::UsersTable,
                ["user_id" => $userToUpdate],
                [
                    "password" => $passwordData["password"],
                    "salt" => $passwordData["salt"]
                ]
            );

            $this->handleSuccess();
        } catch (ControllerException $e) {
            $this->handleError($e, $e->getMessage(), $e->getHttpErrorCode());
        }
    }

    public function login($request)
    {
        try {
            $loginRequest = new LoginRequest($request);

            $userAuthData = $this->database->read(
                OrmModelMapper::UsersTable,
                ["email" => $loginRequest->email],
                ["user_id", "password", "salt"],
            )[0];

            $validPassword = $this->securityManager->verifyHashedPassword(
                $loginRequest->password,
                $userAuthData['password'],
                $userAuthData['salt']
            );

            if (!$validPassword) {
                throw new ControllerException("Invalid credentials", 401);
            }

            $jwt = $this->securityManager->encodeJwt($userAuthData['user_id']);
            $this->cookieService->setCookie(CookieService::AUTHENTICATION_COOKIE_NAME, $jwt);

            $this->handleSuccess();
        } catch (ControllerException $e) {
            $this->handleError($e, $e->getMessage(), $e->getHttpErrorCode());
        }
    }

    public function logout()
    {
        try {
            // TODO: Add deny list for removed JWTs? Needs new database table

            $this->cookieService->removeCookie(CookieService::AUTHENTICATION_COOKIE_NAME);
            $this->handleSuccess();
        } catch (ControllerException $e) {
            $this->handleError($e, $e->getMessage(), $e->getHttpErrorCode());
        }
    }
}
