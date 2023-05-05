<?php

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\RoleController;

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
    });


    Route::group(['prefix' => 'role', 'as' => 'role.', 'middleware' => 'auth:api'], function () {
        Route::post('/create', [RoleController::class, 'create'])->name('role.create');
        Route::get('/index', [RoleController::class, 'index'])->name('role.index');
    });

    Route::group(['prefix' => 'permision', 'as' => 'permision.', 'middleware' => 'auth:api'], function () {
        Route::post('/create', [\App\Http\Controllers\PermisionController::class, 'create'])->name('permision.create');
        Route::get('/index', [\App\Http\Controllers\PermisionController::class, 'index'])->name('permision.index');
    });


    Route::get('/cleareverything', function () {

        $clearcache = Artisan::call('migrate:fresh');
        echo "Cache cleared<br>";

        $clearcache = Artisan::call('passport:install');
        echo "Cache cleared<br>";

        $clearview = Artisan::call('view:clear');
        echo "View cleared<br>";

        $clearconfig = Artisan::call('config:cache');
        echo "Config cleared<br>";

    });
