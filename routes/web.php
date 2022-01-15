<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminApiController;


Route::prefix('admin')->group(function () {
    
    /* ADMIN LOGIN */
    Route::get('/login', [AdminApiController::class, 'login_page']);
    Route::post('/login', [AdminApiController::class, 'login']);
    /* */
    /* */
    Route::get('/', fn() =>  redirect('admin/dashboard'));
    /* */
    /* */
    Route::middleware(['FixarAdminAuth'])->group(function () {
        Route::get('/dashboard', [AdminApiController::class, 'dashboard']);
        Route::get('/logout', [AdminApiController::class, 'logout']);
        /* */
        /* */
        /* */
        // -----USER APIS-----
        Route::prefix('users')->group(function () {

            // ADD
            Route::get('add', [AdminApiController::class, 'create_user_page']);
            Route::post('add', [AdminApiController::class, 'create_user']);

            // UPDATE
            Route::get('update/{username}', [AdminApiController::class, 'update_user_page']);
            Route::post('update', [AdminApiController::class, 'update_user']);
            
            // TABLE
            Route::get('table', [AdminApiController::class, 'users_table']);
            Route::get('data', [AdminApiController::class, 'users_data']);
            
            // AJAX 
            Route::post('suspend', [AdminApiController::class, 'suspend_user']);
            Route::post('recover', [AdminApiController::class, 'recover_user']);

            // SUSPENDED
            Route::prefix('suspended')->group(function () {
                Route::get('table', [AdminApiController::class, 'users_suspended_table']);
                Route::get('data', [AdminApiController::class, 'users_suspended_data']);
            });
            
        });
        // -----USER API ENDS-----
        /* */
        /* */
        /* */
        /* */
        /* */
        // -----SERVICES APIS-----
        Route::prefix('services')->group(function () {

            // ADD
            Route::get('add', [AdminApiController::class, 'create_service_page']);
            Route::post('add', [AdminApiController::class, 'create_service']);

            // UPDATE
            Route::get('update/{slug}', [AdminApiController::class, 'update_service_page']);
            Route::post('update', [AdminApiController::class, 'update_service']);
            
            // TABLE
            Route::get('table', [AdminApiController::class, 'services_table']);
            Route::get('data', [AdminApiController::class, 'services_data']);
            
            // AJAX 
            Route::post('suspend', [AdminApiController::class, 'suspend_service']);
            Route::post('recover', [AdminApiController::class, 'recover_service']);

            // SUSPENDED
            Route::prefix('suspended')->group(function () {
                Route::get('table', [AdminApiController::class, 'services_suspended_table']);
                Route::get('data', [AdminApiController::class, 'services_suspended_data']);
            });
            
        });
        // -----SERVICES API ENDS-----

    });
});