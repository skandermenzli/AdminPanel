<?php

use App\Http\Controllers\Api\v1\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//public routes
Route::prefix('v1')->controller(UserController::class)->group(function(){
    Route::get('/test', 'test');
    Route::post('/login','login');


});

//protected routes
Route::prefix('v1')->middleware('auth:sanctum')->controller(UserController::class)->group(function(){
    Route::get('/logout','logout');
    Route::post('/store','store');
    Route::put('/update/{user}', 'update');
    Route::get('/list','list');
    Route::delete('/delete/{user}','delete');
    Route::get('/show/{user}','show');

});

