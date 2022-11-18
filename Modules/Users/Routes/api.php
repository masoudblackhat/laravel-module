<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Users\Http\Controllers\AuthController;
use Modules\Users\Http\Controllers\UsersController;

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

//Route::middleware('auth:api')->get('/users', function (Request $request) {
//    return $request->user();
//});
Route::post('/login', [AuthController::class,'login'])->name('auth.login');
Route::post('/register', [AuthController::class,'register'])->name('auth.register');
Route::get('/users',[UsersController::class,'index'])->middleware('auth:sanctum');
