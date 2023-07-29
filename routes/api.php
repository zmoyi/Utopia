<?php

use App\Http\Controllers\Api\CardCode\CardCodeController;
use App\Http\Controllers\Api\OTPController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function (){
    Route::post('get-token',[OTPController::class,'getToken']);
    Route::middleware('otp')->group(function (){
        Route::post('verify-card-code',[CardCodeController::class, 'verifyCode']);
        Route::post('heartbeat',[CardCodeController::class,'heartbeat']);
        Route::post('sign',[CardCodeController::class,'signature']);
    });
});


