<?php

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('login/google', [UserController::class, 'handleGoogle'])->middleware('apilogs');
Route::post('login/facebook', [UserController::class, 'handleFacebook']);
Route::post('login/apple', [UserController::class, 'handleApple']);
Route::middleware('apilogs')->post('register', [UserController::class, 'register']);
Route::middleware('apilogs')->post('login', [UserController::class, 'login']);
Route::post('username/check', [UserController::class, 'check_username']);
Route::post('forgot/password', [UserController::class,'forgot_password']);
Route::middleware('apilogs')->get('countries', [UserController::class, 'get_countries']);
Route::group(['middleware' => ['auth:api']], function () {
    // profile
    Route::get('profile', [UserController::class, 'me']);
    Route::post('profile/edit', [UserController::class, 'edit_profile']);
    Route::post('change/password', [UserController::class, 'change_password']);
   
    //logout
    Route::get('logout', [UserController::class, 'logout']);
});
