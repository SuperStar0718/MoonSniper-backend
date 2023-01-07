<?php

use App\Http\Controllers\AlertController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Coingecko;
use App\Http\Controllers\ExchangesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\UnlockingController;
use App\Http\Controllers\RolesAndPermissionsController;

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
    Route::get('/user', [AuthController::class, 'user'])->name('/user');
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
    Route::post('/update-visible-fields', 'App\Http\Controllers\Coingecko@updateVisibleFields')->name('update-visible-fields');
    Route::post('/load-visible-fileds', 'App\Http\Controllers\Coingecko@loadVisibleFileds')->name('load-visible-fileds');

    //Profit Calc
    Route::post('/gettopfive', 'App\Http\Controllers\Coingecko@topFiveAverage');

      //Roles And Permissions 
      Route::post('/roles-and-permissions', [RolesAndPermissionsController::class, 'getRolesAndPermissions'])->name('/roles-and-permissions');
      Route::post('/update-role-permissions', [RolesAndPermissionsController::class, 'updateRolePermissions'])->name('/update-role-permissions');
      Route::post('/update-role-permissions-for-clients', [RolesAndPermissionsController::class, 'updateRolePermissionsForClient'])->name('/update-role-permissions-for-clients');
      Route::post('/abilities', [RolesAndPermissionsController::class, 'loadAbilities'])->name('/abilities');
    //Notify Unlcoking Table
    Route::post('/check-coin-notified', [UnlockingController::class, 'checkCoinNotified'])->name('/check-coin-notified');
    Route::post('/notify-unlock-token', [UnlockingController::class, 'notifyTokenUnlock'])->name('/notify-unlock-token');
    Route::post('/manage-favorites', [Coingecko::class, 'manageFavorites'])->name('/manage-favorites');

    //Exchanges

    Route::post('/exchanges-by-token', [ExchangesController::class, 'exchangesByToken'])->name('/exchanges-by-token');
    Route::post('/load-exchange-coins', [ExchangesController::class, 'ExchangeCoins'])->name('/load-exchange-coins');
    // ETh Price
   
    Route::get('/load-ethgas-values', [Coingecko::class, 'ethGasPrice'])->name('/load-ethgas-values');
    Route::get('/load-marketcap-values', [Coingecko::class, 'marketcapValues'])->name('/load-marketcap-values');
   //Coin alerts 

   Route::post('/add-coinalert',[AlertController::class, 'addAlert'])->name('/add-coinalert');
    Route::get('/load-user-alerts', [AlertController::class, 'getUserAlerts'])->name('/load-user-alerts');
    Route::post('/delete-alert', [AlertController::class, 'deleteAlert'])->name('/delete-alert');
    Route::post('/update-alert', [AlertController::class, 'updateAlert'])->name('/update-alert');
    Route::post('/load-alert-coin-data', [AlertController::class, 'loadAlertCoinData'])->name('/load-alert-coin-data');
    //Chrome Extension APIS


    Route::get('/load-user-alert-list', [AlertController::class, 'getUserAlertList'])->name('/load-user-alert-list');

});
Route::post('/extension-coin-data-coingecko', [ExchangesController::class, 'CoinDetailsForCoinGecko'])->name('/extension-coin-data-coingecko');
Route::post('/get_trading_volume_history-extension', 'App\Http\Controllers\Coingecko@get_trading_volume_history');

Route::post('/exchanges-by-token-extension', [ExchangesController::class, 'exchangesByToken'])->name('/exchanges-by-token-extension');
Route::post('/load-price-chart-by-coin', [Coingecko::class, 'loadPriceChartByCoin'])->name('/load-price-chart-by-coin');
Route::post('/load-mc-chart-by-coin', [Coingecko::class, 'loadMcChartByCoin'])->name('/load-mc-chart-by-coin');

//ChromeApp functions:
//public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'generateForgotPasswordToken']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::post('/verify-mail', [AuthController::class, 'verifyEmail']);
