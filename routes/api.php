<?php

    use App\Http\Controllers\BrandController;
    use App\Http\Controllers\PermisionController;
    use App\Http\Controllers\ProductCategoryController;
    use App\Http\Controllers\ProductGroupController;
    use App\Models\ProductCategory;
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
        Route::post('/get-addresses', [UserController::class, 'get_addresses'])->name('user.addresses');
        Route::post('/change-status', [UserController::class, 'change_status'])->name('user.change-status');
        Route::get('/find/{id}', [UserController::class, 'find'])->name('user.find');
        Route::patch('/update/{id}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
        Route::get('/roles/{id}', [UserController::class, 'get_roles'])->name('user.get-roles');
        Route::post('/roles/assign', [UserController::class, 'assign_role'])->name('user.assign-role');
        Route::post('/roles/revoke', [UserController::class, 'revoke_role'])->name('user.revoke-role');
        Route::get('/auth/find', [UserController::class, 'auth_find'])->name('user.auth-find');
        Route::post('/auth/verify-mail', [UserController::class, 'verify'])->name('user.verify-mail');
        Route::post('/auth/activate-account/{code}', [UserController::class, 'activate'])->name('user.activate-account');
        Route::get('/auth/status', [UserController::class, 'get_account_status'])->name('user.status');

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
        Route::post('/create', [BannerController::class, 'create'])->name('banner.create');
        Route::post('/inc-order/{id}', [BannerController::class, 'inc_order'])->name('banner.inc-order');
        Route::post('/desc-order/{id}', [BannerController::class, 'desc_order'])->name('banner.desc-order');
        Route::delete('/delete/{id}', [BannerController::class, 'delete'])->name('banner.delete');
    });

    Route::group(['prefix' => 'banner', 'as' => 'banner.'], function () {
        Route::get('/index', [BannerController::class, 'index'])->name('banner.index');
    });

    Route::group(['prefix' => 'state', 'as' => 'state.', 'middleware' => 'auth:api'], function () {
        Route::get('/index', [\App\Http\Controllers\StateController::class, 'index'])->name('state.index');
        Route::get('/cities/{id}', [\App\Http\Controllers\StateController::class, 'cities'])->name('state.cities');
    });

    Route::group(['prefix' => 'product-group', 'as' => 'product-group.', 'middleware' => 'auth:api'], function () {
        Route::post('/create', [ProductGroupController::class, 'create'])->name('product-group.create');
        Route::get('/index', [ProductGroupController::class, 'index'])->name('product-group.index');
        Route::delete('/delete/{id}', [ProductGroupController::class, 'delete'])->name('product-group.delete');
        Route::patch('/update/{id}', [ProductGroupController::class, 'update'])->name('product-group.update');
        Route::post('/inc/{id}', [ProductGroupController::class, 'inc'])->name('product-group.inc');
        Route::post('/desc/{id}', [ProductGroupController::class, 'desc'])->name('product-group.desc');
        Route::get('/find/{id}', [ProductGroupController::class, 'find'])->name('product-group.find');

    });

    Route::group(['prefix' => 'product-category', 'as' => 'product-category.', 'middleware' => 'auth:api'], function () {
        Route::post('/create', [ProductCategoryController::class, 'create'])->name('product-category.create');
        Route::get('/index', [ProductCategoryController::class, 'index'])->name('product-category.index');
        Route::delete('/delete/{id}', [ProductCategoryController::class, 'delete'])->name('product-category.delete');
        Route::patch('/update/{id}', [ProductCategoryController::class, 'update'])->name('product-category.update');
        Route::get('/find/{id}', [ProductCategoryController::class, 'find'])->name('product-category.find');
    });

    Route::group(['prefix' => 'brand', 'as' => 'brand.', 'middleware' => 'auth:api'], function () {
        Route::post('/create', [BrandController::class, 'create'])->name('brand.create');
        Route::get('/index', [BrandController::class, 'index'])->name('brand.index');
        Route::delete('/delete/{id}', [BrandController::class, 'delete'])->name('brand.delete');
        Route::patch('/update/{id}', [BrandController::class, 'update'])->name('brand.update');
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

        $clearconfig = Artisan::call('config:cache');
        echo "Config cleared<br>";

//    $clearconfig = Artisan ::call('migrate:fresh');
//        $clearconfig = Artisan::call('passport:install');
//    $clearconfig = Artisan ::call('db:seed');

//        $clearconfig = Artisan::call('permission:create-permission edit-articles');

        echo "ok<br>";

    });
