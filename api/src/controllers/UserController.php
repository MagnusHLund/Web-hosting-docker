<?php

namespace MagZilla\Api\Controllers;

use MagZilla\Api\Models\User;
use MagZilla\Api\Models\OrmModelMapper;
use MagZilla\Api\Models\DTOs\Users\AddUserResponse;
use MagZilla\Api\Models\DTOs\Users\AddUserRequest;
use MagZilla\Api\Models\DTOs\Users\DeleteUserRequest;
use MagZilla\Api\Models\DTOs\Users\GetSettingsResponse;
use MagZilla\Api\Models\Exceptions\ControllerException;

class UserController extends BaseController
{
    public function addUser($request)
    {
        try {
            $addUserRequest = new AddUserRequest($request);

            $userAddingNewUser = User::getUserFromJwt($this->cookieHandler, $this->securityManager);

            if (!$userAddingNewUser->isAdmin($this->database)) {
                throw new ControllerException("Insufficient permissions to create a new user!", 403);
            }

            $passwordData = $this->securityManager->generateHashedPassword($addUserRequest->password);

            $userId = $this->database->create(
                OrmModelMapper::UsersTable->getModel(),
                [
                    "user_name" => $addUserRequest->userName,
                    "email" => $addUserRequest->email,
                    "password" => $passwordData["password"],
                    "salt" => $passwordData["salt"]
                ],
                ["user_id"]
            );

            $this->database->create(
                OrmModelMapper::UserRolesTable->getModel(),
                [
                    "user_id" => $userId,
                    "is_admin" => $addUserRequest->isAdmin,
                    "is_active" => $addUserRequest->isActive
                ]
            );

            $addUserResponse = new AddUserResponse(
                $userId,
                $addUserRequest->userName,
                $addUserRequest->email,
                $addUserRequest->isAdmin,
                $addUserRequest->isActive
            );
            $this->handleSuccess($addUserResponse);
        } catch (ControllerException $e) {
            $this->handleError($e, $e->getMessage(), $e->getHttpErrorCode());
        }
    }

    public function deleteUser($request)
    {
        try {
            $deleteUserRequest = new DeleteUserRequest($request);

            $userDeletingUser = User::getUserFromJwt($this->cookieHandler, $this->securityManager);

            if (!$userDeletingUser->isAdmin($this->database)) {
                throw new ControllerException("Insufficient permissions to delete a new user!", 403);
            }

            $this->database->delete(
                OrmModelMapper::UsersTable->getModel(),
                ["user_id" => $deleteUserRequest->userId]
            );

            $this->handleSuccess();
        } catch (ControllerException $e) {
            $this->handleError($e, $e->getMessage(), $e->getHttpErrorCode());
        }
    }

    public function getSettings()
    {
        try {
            $user = User::getUserFromJwt($this->cookieHandler, $this->securityManager);

            $settings = $this->database->read(OrmModelMapper::SettingsTable->getModel(), ["user_id" => $user->id], ["dark_mode", "language"]);

            $getSettingsResponse = new GetSettingsResponse(
                $settings["dark_mode"],
                $settings["language"]
            );
            $this->handleSuccess($getSettingsResponse);
        } catch (ControllerException $e) {
            $this->handleError($e, $e->getMessage(), $e->getHttpErrorCode());
        }
    }

    public function getUsers()
    {
        try {
        } catch (ControllerException $e) {
            $this->handleError($e, $e->getMessage(), $e->getHttpErrorCode());
        }
    }

    public function updateSetting($request)
    {
        try {
        } catch (ControllerException $e) {
            $this->handleError($e, $e->getMessage(), $e->getHttpErrorCode());
        }
    }

    public function updateUser($request)
    {
        try {
        } catch (ControllerException $e) {
            $this->handleError($e, $e->getMessage(), $e->getHttpErrorCode());
        }
    }
}
