<?php

use App\Http\Controllers\api\RideController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\frontend\RequestController;
use App\Http\Controllers\frontend\VerificationController;
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
require __DIR__.'/brands.php';

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json(['success'=>true,'message'=>'User details','data'=>$request->user()],200);
});

Route::post('/register',[App\Http\Controllers\api\auth\AuthController::class,'register']);
Route::post('/verify-otp',[App\Http\Controllers\api\auth\AuthController::class,'verifyOTP']);
Route::post('/resend-otp',[App\Http\Controllers\api\auth\AuthController::class,'resendOTP']);
Route::post('/login',[App\Http\Controllers\api\auth\AuthController::class,'login']);
Route::get('/logout',[App\Http\Controllers\api\auth\AuthController::class,'logout']);

Route::middleware(['auth:sanctum'])->prefix('ride')->group(function () {
    Route::post('request', [RequestController::class, 'RequestPostAPI']);
    Route::get('all', [RequestController::class, 'RequestPostAPI']);
    Route::post('post', [RideController::class, 'post_ride']);
    Route::prefix('post')->group(function () {
        Route::post('step1', [RideController::class, 'post_ride_step1']);
        Route::post('step2', [RideController::class, 'post_ride_step2']);
        Route::post('step3', [RideController::class, 'post_ride_step3']);
    });
});
Route::middleware(['auth:sanctum'])->prefix('user')->group(function () {
    Route::put('/details/update',[UserController::class,'user_details_update']);
    Route::post('/reset-password',[App\Http\Controllers\api\auth\AuthController::class,'resetPassword']);
    Route::post('/verification',[VerificationController::class,'SpVerificationPost_API']);
    Route::get('details', function (Request $request) {
        return response()->json(['success'=>true,'message'=>'User details','data'=>$request->user()],200);
    });
    Route::prefix('cars')->group(function () {
        Route::post('add', [UserController::class, 'add_car']);
        Route::get('all', [UserController::class, 'my_cars']);
        Route::delete('remove/{car}', [UserController::class, 'remove_car']);
        Route::post('mark_active', [UserController::class, 'mark_car_active']);
    });
});


