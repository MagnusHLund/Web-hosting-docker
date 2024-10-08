<?php

namespace MagZilla\Api\Models;

use MagZilla\Api\Handlers\CookieHandler;
use MagZilla\Api\Managers\DatabaseManager;
use MagZilla\Api\Managers\SecurityManager;

class User
{
    public readonly int $id;
    public string|null $name;
    public string|null $email;
    public bool|null $isAdmin;
    public bool|null $isActive;

    public function __construct($userId, $userName = null, $email = null, $isAdmin = null, $isActive = null)
    {
        $this->id = $userId;
        $this->name = $userName;
        $this->email = $email;
        $this->isAdmin = $isAdmin;
        $this->isActive = $isActive;
    }

    public static function getUserFromJwt(CookieHandler $cookieHandler, SecurityManager $securityManager)
    {
        $jwt = $cookieHandler->readCookie("jwt");
        $decodedJwt = $securityManager->decodeJwt($jwt);

        $userId = $decodedJwt['sub'];

        return new User($userId);
    }

    public function getIsAdmin(DatabaseManager $database)
    {
        if (!isset($this->isAdmin)) {
            $this->isAdmin = (bool) $database->read( // TODO: Is the casting required here?
                OrmModelMapper::UserRolesTable->getModel(),
                ["user_id" => $this->id],
                ["is_admin"],
            );
        }

        return $this->isAdmin;
    }

    public function getIsActive(DatabaseManager $database)
    {
        if (!isset($this->isActive)) {
            $this->isActive = (bool) $database->read( // TODO: Is the casting required here?
                OrmModelMapper::UserRolesTable->getModel(),
                ["user_id" => $this->id],
                ["is_active"],
            );
        }

        return $this->isActive;
    }

    public function getName(DatabaseManager $database)
    {
        return $database->read(
            OrmModelMapper::UsersTable->getModel(),
            ["user_id" => $this->id],
            ["user_name"],
        );
    }

    public function getAllUserInfo(DatabaseManager $database = null)
    {
        if (!isset($this->name, $this->email)) {
            $usersTableData = $database->read(
                OrmModelMapper::UsersTable->getModel(),
                ["user_id" => $this->id],
                ["user_name", "email"]
            );

            $this->name  = (string) $usersTableData["user_name"];
            $this->email = (string) $usersTableData["email"];
        }

        if (!isset($this->isAdmin, $this->isActive)) {
            $userRolesTableData = $database->read(
                OrmModelMapper::UserRolesTable->getModel(),
                ["user_id" => $this->id],
                ["is_admin", "is_active"]
            );

            $this->isAdmin  = (bool) $userRolesTableData["is_admin"];
            $this->isActive = (bool) $userRolesTableData["is_active"];
        }

        return [
            "id"       => $this->id,
            "name"     => $this->name,
            "email"    => $this->email,
            "isAdmin"  => $this->isAdmin,
            "isActive" => $this->isActive
        ];
    }
}
