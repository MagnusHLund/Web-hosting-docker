<?php

namespace MagZilla\Api\Controllers;

use MagZilla\Api\Models\User;
use MagZilla\Api\Models\Settings;
use MagZilla\Api\Models\OrmModelMapper;
use MagZilla\Api\Models\DTOs\Users\AddUserRequest;
use MagZilla\Api\Models\DTOs\Users\AddUserResponse;
use MagZilla\Api\Models\DTOs\Users\GetUsersResponse;
use MagZilla\Api\Models\DTOs\Users\UpdateUserRequest;
use MagZilla\Api\Models\DTOs\Users\DeleteUserRequest;
use MagZilla\Api\Models\DTOs\users\UpdateUserResponse;
use MagZilla\Api\Models\DTOs\Users\GetSettingsResponse;
use MagZilla\Api\Models\Exceptions\ControllerException;
use MagZilla\Api\Models\DTOs\Users\UpdateSettingRequest;
use MagZilla\Api\Models\DTOs\Users\UpdateSettingResponse;

class UserController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function addUser($request)
    {
        try {
            $addUserRequest = new AddUserRequest($request);

            $userAddingNewUser = User::getUserFromJwt($this->cookieService, $this->securityManager);

            if (!$userAddingNewUser->getIsAdmin($this->database)) {
                throw new ControllerException("Insufficient permissions to create a new user!", 403);
            }

            $passwordData = $this->securityManager->generateHashedPassword($addUserRequest->password);

            $databaseResponse = $this->database->create(
                OrmModelMapper::UsersTable,
                [
                    "user_name" => $addUserRequest->userName,
                    "email" => $addUserRequest->email,
                    "password" => $passwordData["password"],
                    "salt" => $passwordData["salt"]
                ],
                ["user_id"]
            );

            $this->database->create(
                OrmModelMapper::UserRolesTable,
                [
                    "user_id" => $databaseResponse->user_id,
                    "is_admin" => $addUserRequest->isAdmin,
                    "is_active" => $addUserRequest->isActive
                ]
            );

            $settings = new Settings(false, "en_US");

            $this->database->create(
                OrmModelMapper::SettingsTable,
                [
                    "user_id" => $databaseResponse->user_id,
                    "dark_mode" => $settings->darkMode,
                    "language" => $settings->language
                ]
            );

            $addUserResponse = new AddUserResponse(
                $databaseResponse->user_id,
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

    // TODO Bug: returns success if the user did not exist
    public function deleteUser($request)
    {
        try {
            $deleteUserRequest = new DeleteUserRequest($request);

            $userDeletingUser = User::getUserFromJwt($this->cookieService, $this->securityManager);

            if (!$userDeletingUser->getIsAdmin($this->database)) {
                throw new ControllerException("Insufficient permissions to delete a user!", 403);
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
            $user = User::getUserFromJwt($this->cookieService, $this->securityManager);

            $settings = $this->database->read(
                OrmModelMapper::SettingsTable,
                ["user_id" => $user->id],
                ["dark_mode", "language"]
            )[0];

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
            $requestingUser = User::getUserFromJwt($this->cookieService, $this->securityManager);

            if (!$requestingUser->getIsAdmin($this->database)) {
                $userData = $requestingUser->getAllUserInfo($this->database);
            } else {
                $userData = $this->database->readMultipleTables(
                    [OrmModelMapper::UsersTable, OrmModelMapper::UserRolesTable],
                    ["user_name", "email", "is_admin", "is_active"]
                );
            }

            $getUsersResponse = new GetUsersResponse($userData);
            $this->handleSuccess($getUsersResponse);
        } catch (ControllerException $e) {
            $this->handleError($e, $e->getMessage(), $e->getHttpErrorCode());
        }
    }

    public function updateSetting($request)
    {
        try {
            $updateSettingRequest = new UpdateSettingRequest($request);

            $user = User::getUserFromJwt($this->cookieService, $this->securityManager);

            $updatedSettings = $this->database->update(
                OrmModelMapper::SettingsTable,
                ["user_id" => $user->id],
                [$updateSettingRequest->settingName => $updateSettingRequest->settingValue],
                ["dark_mode", "language"]
            );

            $userSettings = new Settings($updatedSettings->dark_mode, $updatedSettings->language);
            $updateSettingResponse = new UpdateSettingResponse($userSettings);
            $this->handleSuccess($updateSettingResponse);
        } catch (ControllerException $e) {
            $this->handleError($e, $e->getMessage(), $e->getHttpErrorCode());
        }
    }

    public function updateUser($request)
    {
        try {
            $updateUserRequest = new UpdateUserRequest($request);

            if (isset($updateUserRequest->isActive, $updateUserRequest->isAdmin)) {
                $userDoingRequest = User::getUserFromJwt($this->cookieService, $this->securityManager);
                if (!$userDoingRequest->getIsAdmin($this->database)) {
                    throw new ControllerException("Insufficient permissions to update a user's role!", 403);
                }
            }

            $this->database->update(
                OrmModelMapper::UsersTable,
                ["user_id" => $updateUserRequest->userId],
                [
                    "user_name" => $updateUserRequest->name,
                    "email"     => $updateUserRequest->email
                ]
            );

            $this->database->update(
                OrmModelMapper::UserRolesTable,
                ["user_id" => $updateUserRequest->userId],
                [
                    "is_admin" => $updateUserRequest->isAdmin,
                    "is_active" => $updateUserRequest->isActive
                ]
            );

            $updatedUser = new User(
                $updateUserRequest->userId,
                $updateUserRequest->name,
                $updateUserRequest->email,
                $updateUserRequest->isAdmin,
                $updateUserRequest->isActive
            );

            $updateUserResponse = new UpdateUserResponse($updatedUser);
            $this->handleSuccess($updateUserResponse);
        } catch (ControllerException $e) {
            $this->handleError($e, $e->getMessage(), $e->getHttpErrorCode());
        }
    }
}
