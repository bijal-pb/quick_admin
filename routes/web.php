<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\PageController; 
use Illuminate\Support\Facades\Auth;     

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/token/{id}', [HomeController::class, 'accessToken'])->name('authtoken');

Route::get('/login', function () {
    return redirect("/admin");
});
Route::get('/', function () {
    return view('front.welcome');
});


Auth::routes();


Route::get('/home', function () {
    return redirect("/admin");
});

Route::get('/forgot/password', [UserController::class, 'forgot_password'])->name('admin.forgot');
Route::post('/forgot/password/mail', [UserController::class, 'password_mail'])->name('admin.forgot.mail');
Route::post('admin/login', [UserController::class, 'admin_login'])->name('admin.login');

Route::name('admin.')->namespace('Admin')->group(function () {
    Route::group(['prefix' => 'admin', 'middleware' => ['admin.check']], function () {
        Route::get('/', [AdminController::class, 'index'])->name('home');
       
        // users  route
        Route::get('/profile', [UserController::class, 'profile'])->name('profile');
        Route::get('/password', [UserController::class, 'password'])->name('password');
        Route::post('/password/change', [UserController::class, 'change_password'])->name('password.update');
        Route::post('/profile/update', [UserController::class, 'update_profile'])->name('profile.update');
        Route::get('/users', [UserController::class, 'index'])->name('user');
        Route::get('/users/list', [UserController::class, 'users'])->name('users.list');
        Route::get('/get/user', [UserController::class, 'getUser'])->name('user.get');
        Route::get('/user/status/change', [UserController::class, 'changeStatus'])->name('user.status.change');
        Route::post('/user/store', [UserController::class, 'store'])->name('user.store');

        // app setting
        Route::get('setting', [UserController::class, 'app_setting'])->name('setting');
        Route::post('setting/update', [UserController::class, 'setting_update'])->name('setting.update');

        // app version
        Route::get('version',[UserController::class,'app_version'])->name('version');
        Route::post('version/update', [UserController::class, 'version_update'])->name('version.update');

        //pages
        Route::get('/pages', [PageController::class, 'index'])->name('pages');
        Route::get('/page/list', [PageController::class, 'page'])->name('page.list');
        Route::get('/pages/edit/{page_id}', [PageController::class, 'edit'])->name('page.edit');
        Route::post('/pages/{page_id}', [PageController::class, 'save'])->name('page.save');

    });
});

Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/{slug}', [PageController::class, 'show'])->name('page.show');