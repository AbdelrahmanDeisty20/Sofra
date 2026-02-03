<?php

namespace App\Services;

use App\Enums\UserType;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthService
{
    protected $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function register(array $data, UserType $type)
    {
        $data['type'] = $type->value;
        $data['api_token'] = Str::random(40);
        return $this->userRepo->create($data);
    }

    public function login(string $email, string $password)
    {
        $user = $this->userRepo->findByEmail($email);
        if ($user && Hash::check($password, $user->password)) {
            return $user;
        }
        return null;
    }
}
