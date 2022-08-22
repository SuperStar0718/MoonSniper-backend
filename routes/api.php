<?php

use App\Http\Controllers\UserController;
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

Route::get('/users',[UserController::class,'users'])->name('/users');
Route::get('/user/users/{id}',[UserController::class,'usersById'])->name('/user/users/{id}');
Route::post('/user/adduser',[UserController::class,'addUser'])->name('/user/adduser');
Route::post('/user/updateavatar/{id}',[UserController::class,'updateAvatar'])->name('/user/updateavatar/{id}');
Route::post('/user/removeavatar/{id}',[UserController::class,'removeAvatar'])->name('/user/removeavatar/{id}');
Route::post('/user/updateaccount/{id}',[UserController::class,'updateUserAccount'])->name('/user/updateaccount/{id}');
Route::post('/user/updateinformation/{id}',[UserController::class,'updateUserInformation'])->name('/user/updateinformation/{id}');
Route::post('/user/deleteuser/{id}',[UserController::class,'deleteUser'])->name('/user/deleteuser/{id}');

