<?php

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::controller(UserController::class)->group(function (){
    Route::get('/user', 'index');
    Route::get('/create', 'create');
    Route::post('/user', 'store');
    Route::get('/user/{user}/edit', 'edit');
    Route::put('/user/{user}', 'update');
    Route::get('user/export','export');
    Route::post('/user/import','import');
    Route::get('/user/stats','stats');
    Route::get('user/col','collection');

});


Route::get('/table',function (){
   $users = User::all();
   return view('table')->with(compact('users'));
});


