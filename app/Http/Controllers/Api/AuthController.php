<?php

namespace App\Http\Controllers\Api;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\NewPasswordRequest;
use App\Http\Requests\Api\Auth\ProfileRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Requests\Api\Auth\RegisterTokenRequest;
use App\Http\Requests\Api\Auth\ResetPasswordRequest;
use App\Http\Requests\Api\Auth\TokenRequest;
use App\Mail\ResetPassword;
use App\Models\Token;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $type = $request->type === 'client' ? UserType::CLIENT : UserType::RESTAURANT;
        $user = $this->authService->register($request->validated(), $type);

        return resposeJison(1, 'تم التسجيل بنجاح', [
            'api_token' => $user->api_token,
            'user' => $user->load('region')
        ]);
    }

    public function login(LoginRequest $request)
    {
        $user = $this->authService->login($request->email, $request->password);

        if ($user && $user->type->value === $request->type) {
            return resposeJison(1, 'تم تسجيل الدخول بنجاح', [
                'api_token' => $user->api_token,
                'user' => $user->load('region')
            ]);
        }

        return resposeJison(0, 'بيانات الدخول غير صحيحة');
    }

    public function profile(ProfileRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();
        if ($request->has('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return resposeJison(1, 'تم تحديث الملف الشخصي بنجاح', $user->fresh()->load('region'));
    }

    public function registerToken(RegisterTokenRequest $request)
    {
        Token::where('token', $request->token)->delete();
        $request->user()->tokens()->create($request->validated());
        return resposeJison(1, 'تم حفض التوكن بنجاح');
    }

    public function removeToken(TokenRequest $request)
    {
        Token::where('token', $request->token)->delete();
        return resposeJison(1, 'تم حذف التوكن بنجاح');
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = User::where('phone', $request->phone)->first();
        if ($user) {
            $code = rand(1111, 9999);
            $user->update(['pin_code' => $code]);

            Mail::to($user->email)->send(new ResetPassword($code));

            return resposeJison(1, 'تم ارسال كود التحقق', ['pin_code_for_test' => $code]);
        }

        return resposeJison(0, 'الهاتف غير متاح');
    }

    public function password(NewPasswordRequest $request)
    {
        $user = User::where('phone', $request->phone)->where('pin_code', $request->pin_code)->first();
        if ($user) {
            $user->update([
                'password' => Hash::make($request->password),
                'pin_code' => null
            ]);
            return resposeJison(1, 'تم تغيير كلمة المرور بنجاح');
        }

        return resposeJison(0, 'الكود غير صحيح');
    }

    public function notificationList(Request $request)
    {
        $notifications = $request->user()->notifications()->latest()->paginate(10);
        return resposeJison(1, 'success', $notifications);
    }
}
