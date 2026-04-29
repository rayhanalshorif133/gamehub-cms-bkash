<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\ScoreController;
use App\Http\Controllers\api\AccountController;
use App\Http\Controllers\api\PaymentController;
use App\Http\Middleware\CorsMiddleware;

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






//{{baseurl}}/api/score?msisdn=8801711111111&score=100&keyword=mergeDice
// Route::middleware([CorsMiddleware::class])->match(['get', 'post'], '/score', [ScoreController::class, 'score']);

Route::match(['get', 'post'], '/score', [ScoreController::class, 'score']);


Route::match(['get', 'post'], '/redirect', [ScoreController::class, 'redirect']);

Route::match(['get', 'post'], '/set-attend', [AccountController::class, 'attendGame']);


Route::match(['get', 'post'], '/payment-query/{payment_id}', [PaymentController::class, 'paymentQuery']);
Route::match(['get', 'post'], '/payment-search/{trx_id}', [PaymentController::class, 'paymentSearch']);

// Callback URL for Payment
Route::match(['get', 'post'], '/callback-payment/msisdn/{msisdn}/campaign_id/{campaign_id}/amount/{amount}/', [PaymentController::class, 'appPaymentCallback']);

Route::match(['get', 'post'], '/callback-payment-web/msisdn/{msisdn}/campaign_id/{campaign_id}/amount/{amount}/', [PaymentController::class, 'webPaymentCallback']);


Route::match(['get', 'post'], '/app-callback-payment-boost/msisdn/{msisdn}/campaign_id/{campaign_id}/amount/{amount}/boost/{boost_id}', [PaymentController::class, 'appPaymentBoostCallback']);


// https://bdg.b2mwap.com/api/check-score?msisdn=8801923988380&keyword=stick-monkey
Route::get('/check-score', [ScoreController::class, 'checkScore']);
Route::get('/game-play-log', [ScoreController::class, 'gamePlayLog']);


