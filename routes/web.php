
<?php

use App\Http\Controllers\categoriesController;
use App\Http\Controllers\changePassword;
use App\Http\Controllers\changePasswordController;
use App\Http\Controllers\citiesController;
use App\Http\Controllers\clientsController;
use App\Http\Controllers\commentsController;
use App\Http\Controllers\contactsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\offersController;
use App\Http\Controllers\ordersController;
use App\Http\Controllers\paymentsController;
use App\Http\Controllers\productsController;
use App\Http\Controllers\regionsController;
use App\Http\Controllers\restaurantsController;
use App\Http\Controllers\rolesController;
use App\Http\Controllers\settingsController;
use App\Http\Controllers\usersController;
use App\Http\Middleware\AutoCheckPermission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware'=>['auth',AutoCheckPermission::class],'prefix'=>'admin'],function(){
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::resource('categories',categoriesController::class);
    Route::resource('regions',regionsController::class);
    Route::resource('cities',citiesController::class);
    Route::resource('contacts',contactsController::class);
    Route::resource('settings',settingsController::class);
    Route::resource('clients',clientsController::class);
    Route::resource('comments',commentsController::class);
    Route::resource('restaurants',restaurantsController::class);
    Route::get('change-password', [changePasswordController::class,'index'])->name('change-password');
    Route::post('change-password',[changePasswordController::class,'update'])->name('change-password.update');
    Route::resource('products',productsController::class);
    Route::resource('orders', controller: ordersController::class);
    Route::resource('offers', controller: offersController::class);
    Route::resource('payments', controller: paymentsController::class);
    Route::resource('users', controller: usersController::class);
    Route::resource('roles',rolesController::class);
});
