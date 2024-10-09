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
use MagZilla\Api\Models\DTOs\Users\SearchUsersRequest;
use MagZilla\Api\Models\DTOs\Users\SearchUsersResponse;
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

            $userAddingNewUser = User::getUserFromJwt($this->cookieHandler, $this->securityManager);

            if (!$userAddingNewUser->getIsAdmin($this->database)) {
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

            if (!$userDeletingUser->getIsAdmin($this->database)) {
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
            $requestingUser = User::getUserFromJwt($this->cookieHandler, $this->securityManager);

            if (!$requestingUser->getIsAdmin($this->database)) {
                $userData = $requestingUser->getAllUserInfo($this->database);
            } else {
                $usersTableData = $this->database->read(
                    OrmModelMapper::UsersTable->getModel(),
                    [],
                    ["user_id", "user_name", "email"]
                );
                $userRolesTableData = $this->database->read(
                    OrmModelMapper::UserRolesTable->getModel(),
                    [],
                    ["user_id", "is_admin", "is_active"]
                );

                $userData = [];

                foreach ($usersTableData as $user) {
                    $userData[$user['user_id']] = [
                        'user_name' => $user['user_name'],
                        'email' => $user['email']
                    ];
                }

                foreach ($userRolesTableData as $role) {
                    if (isset($userData[$role['user_id']])) {
                        $userData[$role['user_id']]['is_admin'] = $role['is_admin'];
                        $userData[$role['user_id']]['is_active'] = $role['is_active'];
                    }
                }
            }

            // TODO: This might fail. Maybe fix?
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

            $user = User::getUserFromJwt($this->cookieHandler, $this->securityManager);

            $updatedSettings = $this->database->update(
                OrmModelMapper::SettingsTable->getModel(),
                ["user_id" => $user->id],
                [$updateSettingRequest->settingName => $updateSettingRequest->settingValue],
                ["dark_mode", "language"]
            );

            $userSettings = new Settings($updatedSettings["darkMode"], $updatedSettings["language"]);
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
                $userDoingRequest = User::getUserFromJwt($this->cookieHandler, $this->securityManager);
                if (!$userDoingRequest->getIsAdmin($this->database)) {
                    throw new ControllerException("Insufficient permissions to update a user's role!", 403);
                }
            }

            $this->database->update(
                OrmModelMapper::UsersTable->getModel(),
                ["user_id" => $updateUserRequest->userId],
                [
                    "user_name" => $updateUserRequest->name,
                    "email"     => $updateUserRequest->email
                ]
            );

            $this->database->update(
                OrmModelMapper::UserRolesTable->getModel(),
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
