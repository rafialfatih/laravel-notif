<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;

class UserService
{
    public function getAllUserData(): Collection
    {
        return User::latest()->get();
    }

    public function storeUserData($data): User
    {
        return User::create($data);
    }
}
