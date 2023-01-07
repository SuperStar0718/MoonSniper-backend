<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\UnlockingController;
use App\Http\Controllers\ApplicationController;

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
Route::get('/auth/google/callback',[AuthController::class,'googleCallback'])->name('/auth/google/callback');
Route::get('/auth/facebook/callback',[AuthController::class,'facebookCallback'])->name('/auth/facebook/callback');
Route::get('/auth/google/redirect',[AuthController::class,'googleRedirect'])->name('/auth/google/redirect');
Route::get('/auth/facebook/redirect',[AuthController::class,'facebookRedirect'])->name('/auth/facebook/redirect');
Route::get('/auth/logincompleted',[AuthController::class,'facebookRedirect'])->name('/auth/logincompleted');
Route::get('/createroles',[AuthController::class,'CreateRoles'])->name('/createroles');
Route::get('/loadfile/{coin}',[UnlockingController::class,'dataFromUrl']);
Route::get('/{any}', [ApplicationController::class, 'index'])->where('any', '.*');
