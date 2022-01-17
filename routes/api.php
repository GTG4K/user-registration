<?php

use GuzzleHttp\Middleware;
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

// register
Route::post('/signup',[AuthenticationController::class,'createAccount']);

// login
Route::post('/signin',[AuthenticationController::class,'signin']);

Route::group(['middleware' => ['auth:sanctum']], function(){

    Route::get('/profile', function(Request $request){
        return auth()->user();
    });

    //logout
    Route::post('/sign-out',[AuthenticationController::class,'logout']);
});


