<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function findById(int $id): ?User
    {
        return User::find($id);
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function update(User $user, array $data): User
    {
        $user->fill($data);
        $user->save();
        return $user;
    }

    public function create(array $data): User
    {
        return User::create($data);
    }
}
