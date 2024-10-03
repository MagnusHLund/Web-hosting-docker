<?php

namespace MagZilla\Api\Controllers;

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
                $this->cookieHandler,
                $this->securityManager
            );

            $passwordData = $this->securityManager->generateHashedPassword($updatePasswordRequest->newPassword);

            $this->database->update(
                OrmModelMapper::UsersTable->getModel(),
                ["user_id" => $user->id],
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
                OrmModelMapper::UsersTable->getModel(),
                ["email" => $loginRequest->email],
                ["user_id", "password", "salt"],
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
        } catch (ControllerException $e) {
            $this->handleError($e, $e->getMessage(), $e->getHttpErrorCode());
        }
    }

    public function logout()
    {
        try {
            // TODO: Add deny list for removed JWTs? Needs new database table

            $this->cookieHandler->removeCookie("jwt");
        } catch (ControllerException $e) {
            $this->handleError($e, $e->getMessage(), $e->getHttpErrorCode());
        }
    }
}
