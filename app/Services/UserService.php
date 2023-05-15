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

    public function getUserData(int $id): User
    {
        return User::findOrfail($id);
    }

    public function storeUserData($data): User
    {
        return User::create($data);
    }

    public function updateUserData(int $id, array $data)
    {
        $user = User::find($id);

        return $user->update($data);
    }

    public function deleteUserData(int $id)
    {
        $user = User::findOrFail($id);
        
        return $user->delete($id);
    }
}
