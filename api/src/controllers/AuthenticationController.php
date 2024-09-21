<?php

namespace MagZilla\Api\Controllers;

use MagZilla\Api\Models\DTOs\LoginDTO;

class AuthenticationController extends BaseController
{
    public function changePassword() {}

    public function login($request)
    {
        new LoginDTO($request);
    }

    public function logout() {}
}
