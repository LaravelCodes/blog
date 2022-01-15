<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

// Route::post('/fixar/hash', function(){
//     return sha1('FixarWorldOnlineInternational');
// });

// Internation Middleware access
Route::middleware(['FixarAuth'])->group(function () {

    // -----USER APIS-----
    Route::post('/user/create', [ApiController::class, 'create_user']);
    Route::post('/user/read', [ApiController::class, 'read_user']);
    Route::post('/user/update/', [ApiController::class, 'update_user']);
    Route::post('/user/action', [ApiController::class, 'action_user']);
    Route::post('/user/login', [ApiController::class, 'login_user']);
    Route::post('/user/forgot/step1', [ApiController::class, 'forgot_step1']);
    Route::post('/user/forgot/step2', [ApiController::class, 'forgot_step2']);
    Route::post('/user/forgot/step3', [ApiController::class, 'forgot_step3']);
    Route::post('/user/email_verification/{id}', [ApiController::class, 'email_verification']);
    Route::post('/user/services', [ApiController::class, 'provider_services']);
    Route::post('/user/services/update', [ApiController::class, 'provider_services_update']);
    Route::post('/user/empty', [ApiController::class, 'empty_user']);
    Route::post('/user/provider/empty', [ApiController::class, 'empty_provider']);
    // -----USER API ENDS-----
    /* */
    /* */
    /* */
    /* */
    /* */
    // -----VERIFICATIONS API-----
    Route::post('/verifications/read', [ApiController::class, 'read_verification']);
    Route::post('/verifications/empty', [ApiController::class, 'empty_verification']);
    // -----VERIFICATIONS API ENDS-----
    /* */
    /* */
    /* */
    /* */
    /* */
    // -----TOKEN API-----
    Route::post('/tokens/read', [ApiController::class, 'read_token']);
    Route::post('/tokens/empty', [ApiController::class, 'empty_token']);
    // -----TOKEN API ENDS-----
    /* */
    /* */
    /* */
    /* */
    /* */
});