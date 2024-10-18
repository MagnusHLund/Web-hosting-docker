<?php

namespace MagZilla\Api\Managers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use MagZilla\Api\Models\Exceptions\ControllerException;
use MagZilla\Api\Utils\Constants;

class SecurityManager
{
    const JWT_HASHING_ALGORITHM = 'HS256';
    const PASSWORD_HASHING_ALGORITHM = PASSWORD_ARGON2ID;

    private static $instance = null;

    private function __construct() {}

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function hashPassword($passwordToHash, $salt)
    {
        try {
            $options = ['memory_cost' => 1024, 'time_cost' => 2, 'threads' => 2];
            return password_hash($passwordToHash . $salt, self::PASSWORD_HASHING_ALGORITHM, $options);
        } catch (\Exception $e) {
            // TODO
        }
    }

    public function verifyHashedPassword($loginPassword, $storedPassword, $salt): bool
    {
        try {
            return password_verify($loginPassword . $salt, $storedPassword);
        } catch (\Exception $e) {
            // TODO
        }
    }

    private function verifyNewPassword($password): bool
    {
        $minimumLength = 6;
        $minimumNumbers = 2;
        $requiredMixedCase = true;

        // Check if the length is above the minimum length.
        if (strlen($password) < $minimumLength) {
            return false;
        }

        // Check if password has the minimally required numbers.
        if (!preg_match('/(.*\d.*){' . $minimumNumbers . ',}/', $password)) {
            return false;
        }

        // Check for mixed case letters
        if ($requiredMixedCase && !preg_match('/(?=.*[a-z])(?=.*[A-Z])/', $password)) {
            return false;
        }

        return true;
    }

    private function generateSalt()
    {
        $randomBytes = random_bytes(32);
        return bin2hex($randomBytes);
    }

    public function generateHashedPassword($password)
    {
        if (!$this->verifyNewPassword($password)) {
            throw new ControllerException("Password does not meet requirements", 400);
        }

        $salt = $this->generateSalt();
        $hashedPassword = $this->hashPassword($password, $salt);

        return [
            "salt" => $salt,
            "password" => $hashedPassword
        ];
    }

    public function encodeJwt($userId)
    {
        try {
            $payload = [
                'iss' => 'MagZilla',
                'sub' => $userId,
                'iat' => time(),
                'exp' => time() + 86400 // 1 day
            ];

            return JWT::encode(
                $payload,
                Constants::getJwtSecretKey(),
                self::JWT_HASHING_ALGORITHM,
                Constants::getKid()
            );
        } catch (\Exception $e) {
            // TODO
        }
    }

    public static function decodeJwt($jwt)
    {
        try {
            $keyArray = new Key(Constants::getJwtSecretKey(), self::JWT_HASHING_ALGORITHM);
            return JWT::decode($jwt, $keyArray);
        } catch (\Exception $e) {
            // TODO
        }
    }
}
