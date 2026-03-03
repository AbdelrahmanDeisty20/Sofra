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

    public function registerToken($user, array $data)
    {
        \App\Models\Token::where('token', $data['token'])->delete();
        return $user->tokens()->create($data);
    }

    public function removeToken(string $token)
    {
        return \App\Models\Token::where('token', $token)->delete();
    }

    public function resetPassword(string $phone)
    {
        $user = \App\Models\User::where('phone', $phone)->first();
        if ($user) {
            $code = rand(1111, 9999);
            $user->update(['pin_code' => $code]);
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\ResetPassword($code));
            return ['status' => 1, 'code' => $code];
        }
        return ['status' => 0];
    }

    public function changePassword(string $phone, string $pinCode, string $newPassword)
    {
        $user = \App\Models\User::where('phone', $phone)->where('pin_code', $pinCode)->first();
        if ($user) {
            $user->update([
                'password' => \Illuminate\Support\Facades\Hash::make($newPassword),
                'pin_code' => null
            ]);
            return true;
        }
        return false;
    }

    public function getNotifications($user)
    {
        return $user->notifications()->latest()->paginate(10);
    }

    public function updateProfile($user, array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($data['password']);
        }
        $user->update($data);
        return $user->fresh();
    }
}
