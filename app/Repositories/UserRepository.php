<?php

namespace App\Repositories;

use App\Enums\UserType;
use App\Models\User;

class UserRepository
{
    public function create(array $data)
    {
        return User::create($data);
    }

    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    public function findByPhone(string $phone)
    {
        return User::where('phone', $phone)->first();
    }

    public function findById(int $id)
    {
        return User::find($id);
    }

    public function getByType(UserType $type, array $columns = ['*'])
    {
        return User::where('type', $type->value)->select($columns);
    }

    public function update(int $id, array $data)
    {
        $user = $this->findById($id);
        if ($user) {
            $user->update($data);
        }
        return $user;
    }
}
