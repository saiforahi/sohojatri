<?php

use App\Models\car_brand;
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


Route::prefix('brands')->group(function () {
    Route::get('all', function (Request $request) {
        return response()->json(['success'=>true,'message'=>'Brand list','data'=>car_brand::all()],200);
    });
});



