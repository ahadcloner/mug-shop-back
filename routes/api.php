<?php

use App\Http\Controllers\PermisionController;
use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\RoleController;
    use App\Http\Controllers\BannerController;

    /*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider and all of them will
    | be assigned to the "api" middleware group. Make something great!
    |
    */
    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::post('/register', [UserController::class, 'register'])->name('user.register');
        Route::post('/login', [UserController::class, 'login'])->name('user.login');

    });

    Route::group(['prefix' => 'user', 'as' => 'user.', 'middleware' => 'auth:api'], function () {
        Route::post('/logout', [UserController::class, 'logout'])->name('user.logout');
        Route::get('index', [UserController::class, 'index'])->name('user.index');
        Route::post('/get-addresses',[UserController::class,'get_addresses'])->name('user.addresses');
        Route::post('/change-status',[UserController::class,'change_status'])->name('user.change-status');
        Route::get('/find/{id}' ,[UserController::class , 'find'])->name('user.find');
        Route::patch('/update/{id}' ,[UserController::class , 'update'])->name('user.update');
        Route::delete('/delete/{id}' ,[UserController::class , 'delete'])->name('user.delete');
        Route::get('/roles/{id}' ,[UserController::class , 'get_roles'])->name('user.get-roles');
        Route::post('/roles/assign' ,[UserController::class , 'assign_role'])->name('user.assign-role');
        Route::post('/roles/revoke' ,[UserController::class , 'revoke_role'])->name('user.revoke-role');
    });


    Route::group(['prefix' => 'role', 'as' => 'role.', 'middleware' => 'auth:api'], function () {
        Route::post('/create', [RoleController::class, 'create'])->name('role.create');
        Route::get('/index', [RoleController::class, 'index'])->name('role.index');
        Route::delete('/delete/{id}', [RoleController::class, 'delete'])->name('role.delete');
        Route::get('/permissions/{id}', [RoleController::class, 'get_permissions'])->name('role.permissions');
        Route::post('/grant-permission', [RoleController::class, 'grant_permission'])->name('role.grant-permission');
        Route::post('/revoke-permission', [RoleController::class, 'revoke_permission'])->name('role.revoke-permission');
        Route::get('/find/{id}', [RoleController::class, 'find'])->name('role.find');
        Route::patch('/update/{id}', [RoleController::class, 'update'])->name('role.update');
    });

    Route::group(['prefix' => 'permision', 'as' => 'permision.', 'middleware' => 'auth:api'], function () {
        Route::post('/create', [PermisionController::class, 'create'])->name('permision.create');
        Route::get('/index', [PermisionController::class, 'index'])->name('permision.index');
        Route::delete('/delete/{id}', [PermisionController::class, 'delete'])->name('permision.delete');
        Route::get('/find/{id}', [PermisionController::class, 'find'])->name('permision.find');
        Route::patch('/update/{id}', [PermisionController::class, 'update'])->name('permision.update');
    });

    Route::group(['prefix' => 'banner', 'as' => 'banner.', 'middleware' => 'auth:api'], function () {
        Route::get('/index', [BannerController::class, 'index'])->name('banner.index');
        Route::post('/create', [BannerController::class, 'create'])->name('banner.create');
    });

    Route::group(['prefix' => 'state', 'as' => 'state.', 'middleware' => 'auth:api'], function () {
        Route::get('/index', [\App\Http\Controllers\StateController::class, 'index'])->name('state.index');
        Route::get('/cities/{id}', [\App\Http\Controllers\StateController::class, 'cities'])->name('state.cities');
    });


    Route::get('/cleareverything', function () {

//        $clearcache = Artisan::call('migrate:fresh');
//        echo "Cache cleared<br>";
//
//        $clearcache = Artisan::call('passport:install');
//        echo "Cache cleared<br>";
//
//        $clearview = Artisan::call('view:clear');
//        echo "View cleared<br>";
//
//        $clearconfig = Artisan::call('config:cache');
//        echo "Config cleared<br>";

        $clearconfig = Artisan::call('migrate:fresh');
//        $clearconfig = Artisan::call('passport:install');
        $clearconfig = Artisan::call('db:seed');

//        $clearconfig = Artisan::call('permission:create-permission edit-articles');

        echo "ok<br>";

    });
