<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\UnlockingController;
use App\Http\Controllers\UserController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {

// });

Route::post('/auth/login', [AuthController::class, 'login'])->name('/auth/login');
Route::post('/auth/register', [AuthController::class, 'registration'])->name('/auth/register');

Route::post('/validateemail', [UserController::class, 'validateEmail']);
Route::post('/validateusername', [UserController::class, 'validateUsername']);
Route::post('/validateusernameonupdate', [UserController::class, 'validateUsernameOnUpdate']);
Route::post('/validateemailonupdate', [UserController::class, 'validateEmailOnUpdate']);
Route::post('/plans', [PlansController::class, 'plans']);
Route::group(['middleware' => 'auth:sanctum'], function () {

    //User functions
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    //users function
    Route::get('/users', [UserController::class, 'users'])->name('/users');
    Route::get('/user/users/{id}', [UserController::class, 'usersById'])->name('/user/users/{id}');
    Route::post('/user/adduser', [UserController::class, 'addUser'])->name('/user/adduser');
    Route::post('/user/updateavatar/{id}', [UserController::class, 'updateAvatar'])->name('/user/updateavatar/{id}');
    Route::post('/user/removeavatar/{id}', [UserController::class, 'removeAvatar'])->name('/user/removeavatar/{id}');
    Route::post('/user/updateaccount/{id}', [UserController::class, 'updateUserAccount'])->name('/user/updateaccount/{id}');
    Route::post('/user/updateinformation/{id}', [UserController::class, 'updateUserInformation'])->name('/user/updateinformation/{id}');
    Route::post('/user/deleteuser/{id}', [UserController::class, 'deleteUser'])->name('/user/deleteuser/{id}');
    // Unlocking functions
    Route::post('/autosuggestcoins', [UnlockingController::class, 'coinsForAutoSuggest']);
    Route::post('/load-single-coin', [UnlockingController::class, 'loadSingleCoin']);
    Route::post('/load-single-coin-with-top-five', [UnlockingController::class, 'loadSingleCoinWithTopFive']);
    Route::post('/update-coindata', [UnlockingController::class, 'updateCoinData']);
    Route::post('/upload-pdf', [UnlockingController::class, 'uploadPDF']);
    Route::post('/parse-pdf', 'App\Http\Controllers\UnlockingController@parsePDF');

    //MoonSniper functions
    Route::post('/get_coins', 'App\Http\Controllers\Coingecko@get_coin_prices');
    Route::post('/get_fag', 'App\Http\Controllers\Coingecko@get_fear_greed');
    Route::post('/get_trading_volume_history', 'App\Http\Controllers\Coingecko@get_trading_volume_history');
    Route::post('/create_preset_filter', 'App\Http\Controllers\PresetFilterController@create_preset_filter');
    Route::post('/get_preset_filters', 'App\Http\Controllers\PresetFilterController@get_preset_filters');
    Route::post('/delete_preset_filter', 'App\Http\Controllers\PresetFilterController@delete_preset_filter');
    Route::post('/user/profile', [UserController::class, 'updateUserProfile'])->name('/user/profile');
    Route::post('/user/updatepassword', [UserController::class, 'updateUserPassword'])->name('/user/updatepassword');
    Route::post('/user/updateprofileinformation', [UserController::class, 'updateUserProfileInfo'])->name('/user/updateprofileinformation');
    Route::post('/user/updatenotofications', [UserController::class, 'updateUserNotifications'])->name('/user/updatenotofications');
    //Profit Calc
    Route::post('/gettopfive', 'App\Http\Controllers\Coingecko@topFiveAverage');

});

//ChromeApp functions:
//public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'generateForgotPasswordToken']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::post('/verify-mail', [AuthController::class, 'verifyEmail']);
