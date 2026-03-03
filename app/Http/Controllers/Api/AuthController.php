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
use App\Http\Resources\ClientResource;
use App\Http\Resources\RestaurantResource;
use App\Services\AuthService;
use Illuminate\Http\Request;

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

        $resource = $type === UserType::CLIENT ? new ClientResource($user->load('regions')) : new RestaurantResource($user->load('region', 'category'));

        return jsonResponse(1, 'تم التسجيل بنجاح', [
            'api_token' => $user->api_token,
            'user' => $resource
        ]);
    }

    public function login(LoginRequest $request)
    {
        $user = $this->authService->login($request->email, $request->password);

        if ($user && $user->type->value === $request->type) {
            $resource = $user->type === UserType::CLIENT ? new ClientResource($user->load('regions')) : new RestaurantResource($user->load('region', 'category'));
            return jsonResponse(1, 'تم تسجيل الدخول بنجاح', [
                'api_token' => $user->api_token,
                'user' => $resource
            ]);
        }

        return jsonResponse(0, 'بيانات الدخول غير صحيحة');
    }

    public function profile(ProfileRequest $request)
    {
        $user = $this->authService->updateProfile($request->user(), $request->validated());
        $resource = $user->type === UserType::CLIENT ? new ClientResource($user->load('regions')) : new RestaurantResource($user->load('region', 'category'));

        return jsonResponse(1, 'تم تحديث الملف الشخصي بنجاح', $resource);
    }

    public function registerToken(RegisterTokenRequest $request)
    {
        $this->authService->registerToken($request->user(), $request->validated());
        return jsonResponse(1, 'تم حفض التوكن بنجاح');
    }

    public function removeToken(TokenRequest $request)
    {
        $this->authService->removeToken($request->token);
        return jsonResponse(1, 'تم حذف التوكن بنجاح');
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $result = $this->authService->resetPassword($request->phone);
        if ($result['status'] == 1) {
            return jsonResponse(1, 'تم ارسال كود التحقق', ['pin_code_for_test' => $result['code']]);
        }
        return jsonResponse(0, 'الهاتف غير متاح');
    }

    public function password(NewPasswordRequest $request)
    {
        $updated = $this->authService->changePassword($request->phone, $request->pin_code, $request->password);
        if ($updated) {
            return jsonResponse(1, 'تم تغيير كلمة المرور بنجاح');
        }
        return jsonResponse(0, 'الكود غير صحيح');
    }

    public function notificationList(Request $request)
    {
        $notifications = $this->authService->getNotifications($request->user());
        return jsonResponse(1, 'success', $notifications);
    }
}
