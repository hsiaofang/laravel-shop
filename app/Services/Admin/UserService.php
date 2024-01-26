<?php

namespace App\Services\Admin;

use App\Models\User;

class UserService
{
    public function getAllUsers()
    {
        return User::all();
    }
}
