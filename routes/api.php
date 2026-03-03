<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\MainController;
use App\Http\Controllers\Api\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'v1'], function () {
    Route::get('cities', [MainController::class, 'cities']);
    Route::get('regions', [MainController::class, 'regions']);
    Route::get('categories', [MainController::class, 'categories']);
    Route::get('restaurants', [MainController::class, 'restaurants']);
    Route::get('restaurant', [MainController::class, 'restaurant']);
    Route::get('foods', [MainController::class, 'foods']);
    Route::get('comments', [MainController::class, 'comments']);
    Route::get('offers', [MainController::class, 'offers']);
    Route::post('contacts', [MainController::class, 'contacts']);

    // Consolidate Auth Routes (Shared Logic)
    Route::post('reset_password', [AuthController::class, 'resetPassword']);
    Route::post('password', [AuthController::class, 'password']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::group(['middleware' => ['auth:api_client', 'auto-check-user-type:client']], function () {
        Route::post('client/profile', [AuthController::class, 'profile']);
        Route::post('client/register_token', [AuthController::class, 'registerToken']);
        Route::post('client/remove-token', [AuthController::class, 'removeToken']);
        Route::get('client/notifications-list', [AuthController::class, 'notificationList']);

        // Orders
        Route::post('client/new-order', [OrderController::class, 'newOrder']);
        Route::get('client/my-orders', [OrderController::class, 'myOrders']);
        Route::get('client/show-order', [OrderController::class, 'showOrder']);
        Route::post('client/cancel-order', [OrderController::class, 'cancelOrder']);
    });

    Route::group(['middleware' => ['auth:api_restaurant', 'auto-check-user-type:restaurant']], function () {
        Route::post('restaurant/profile', [AuthController::class, 'profile']);
        Route::post('restaurant/register_token', [AuthController::class, 'registerToken']);
        Route::post('restaurant/remove-token', [AuthController::class, 'removeToken']);
        Route::get('restaurant/notifications-list', [AuthController::class, 'notificationList']);

        // Item
        Route::post('restaurant/add-product', [ItemController::class, 'addProduct']);
        Route::post('restaurant/edit-product', [ItemController::class, 'editProduct']);
        Route::get('restaurant/delete-product', [ItemController::class, 'deleteProduct']);
        Route::get('restaurant/my-products', [ItemController::class, 'myProducts']);

        Route::post('restaurant/add-offer', [ItemController::class, 'addOffer']);
        Route::post('restaurant/edit-offer', [ItemController::class, 'editOffer']);
        Route::get('restaurant/delete-offer', [ItemController::class, 'deleteOffer']);
        Route::get('restaurant/my-offers', [ItemController::class, 'myOffers']);

        Route::get('restaurant/financial-accounts', [ItemController::class, 'financialAccounts']);

        // Order
        Route::post('restaurant/accept-order', [OrderController::class, 'acceptOrder']);
        Route::post('restaurant/reject-order', [OrderController::class, 'rejectOrder']);
        Route::post('restaurant/delivery-order', [OrderController::class, 'deliveryOrder']);
    });
});
