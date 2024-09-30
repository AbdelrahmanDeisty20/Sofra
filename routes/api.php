<?php

use App\Http\Controllers\Api\Client\AuthController;
use App\Http\Controllers\Api\Client\MainController as ClientMainController;
use App\Http\Controllers\Api\MainController;
use App\Http\Controllers\Api\Restaurant\AuthController as RestaurantAuthController;
use App\Http\Controllers\Api\Restaurant\MainController as RestaurantMainController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'v1'], function () {
    Route::get('cities', [MainController::class, 'cities']);
    Route::get('regions', [MainController::class, 'regions']);
    Route::get('categories', [MainController::class, 'categories']);
    Route::get('restaurants',[MainController::class,'restaurants']);
    Route::get('restaurant',[MainController::class,'restaurant']);
    Route::get('foods',[MainController::class,'foods']);
    Route::get('comments',[MainController::class,'comments']);
    Route::get('offers',[MainController::class,'offers']);
    Route::post('contacts',[MainController::class,'contacts']);



    Route::group(['prefix' => 'client'], function () {
        // login
        Route::post('reset_password',action: [AuthController::class,'resetPassword']);
        Route::post('password', [AuthController::class, 'password']);
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::group(['middleware' => 'auth:api_client'], function () {
            // create order
            Route::post('profile',[AuthController::class,'profile']);
            Route::post('comment_create',[ClientMainController::class,'comment_create']);
            Route::post('register_token',[AuthController::class,'registerToken' ]);
            Route::post('remove-token',[AuthController::class ,'removeToken']);
            Route::post('new-order',[ClientMainController::class,'newOrder']);
            Route::get('notifications-list',[AuthController::class,'notificationList']);
            Route::get('my-orders',[ClientMainController::class,'myOrders']);
            Route::get('show-order',[ClientMainController::class,'showOrder']);
            Route::post('cancle-order',[ClientMainController::class,'cancleOrder']);
            Route::get('offers',[ClientMainController::class,'activeOffer']);
        });
    });

    Route::group(['prefix' => 'restaurant'], function () {
        // login
        Route::post('reset_password',action: [RestaurantAuthController::class,'resetPassword']);
        Route::post('password', [RestaurantAuthController::class, 'password']);
        Route::post('register', [RestaurantAuthController::class, 'register']);
        Route::post('login', [RestaurantAuthController::class, 'login']);
        Route::group(['middleware' => 'auth:api_resturant'], function () {
            // add product
            Route::post('add_product',[RestaurantMainController::class,'add_product']);
            Route::post('profile',[RestaurantAuthController::class,'profile']);
            Route::post('add_offer',[RestaurantMainController::class,'add_offer']);
            Route::post('register_token',[RestaurantAuthController::class,'registerToken' ]);
            Route::post('remove-token',[RestaurantAuthController::class ,'removeToken']);
            Route::get('notifications-list',[AuthController::class,'notificationList']);
            Route::post('accept-order',[RestaurantMainController::class,'acceptOrder']);
            Route::post('reject-order',[RestaurantMainController::class,'rejectOrder']);
            Route::post('delivery-order',[RestaurantMainController::class,'deliveyOrder']);
            Route::get('my-offers',[RestaurantMainController::class,'myOffers']);
            Route::post('edit-offer',[RestaurantMainController::class,'editOffer']);
            Route::get('delete-offer',[RestaurantMainController::class,'deleteOffer']);
            Route::get('delete-product',[RestaurantMainController::class,'deleteProduct']);
            Route::post('edit-product',[RestaurantMainController::class,'editProduct']);
            Route::get('financial-accounts',[RestaurantMainController::class,'financialAccounts']);
            Route::get('my-products',[RestaurantMainController::class,'myProducts']);
        });
    });
});
