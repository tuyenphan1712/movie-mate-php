<?php

namespace App\Repositories\Impl;

use App\Enums\UserStatus;
use App\Models\User;
use App\Repositories\UserRepository;

class UserRepositoryImpl implements UserRepository
{
    public function getAllUsers()
    {
        return User::all();
    }

    public function getUserById($id)
    {
        return User::findOrFail($id);
    }

    public function createUser(array $data)
    {
        return User::create($data);
    }

    public function updateUser($id, array $data)
    {
        $user = User::findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->user_status = UserStatus::DELETED;// Cập nhật trạng thái thay vì xóa
        $user->save();
        return $user;
    }
}
