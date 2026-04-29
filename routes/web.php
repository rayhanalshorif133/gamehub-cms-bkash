<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\PlayerLoginController;
use App\Http\Controllers\BkashController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\PrizeController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\LandingPageController;
use Illuminate\Support\Facades\Artisan;

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

Route::get('clear', function () {
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('optimize:clear');
    return 'Clear';
});

Route::get('/', [HomeController::class, 'home'])->name('home');

Auth::routes();

Route::get('/admin', [HomeController::class, 'admin'])->name('admin');


// Public routes

Route::match(['get', 'put'], '/account', [WebController::class, 'account'])->name('account')->middleware('role:player,admin');
Route::match(['get', 'put'], '/account-new', [WebController::class, 'accountNew'])->name('account-new')->middleware('role:player,admin');
Route::get('/category', [WebController::class, 'category'])->name('category');
Route::get('/not-allow', [WebController::class, 'notAllow'])->name('not-allow');
Route::get('/boost-buy/{type}', [WebController::class, 'boostBuy'])->name('boost-buy')->middleware('role:player,admin');




Route::middleware('role:player,admin')->group(function () {
    Route::get('/player/reward-point/{point}/{type}', [WebController::class, 'rewardPoint'])->name('player.reward-point');
    Route::get('/points', [WebController::class, 'points'])->name('player.points');
});


// Player Login routes
Route::prefix('player')->name('player.')->group(function () {
    Route::post('/login', [PlayerLoginController::class, 'login'])->name('login');
    Route::post('/register', [PlayerLoginController::class, 'register'])->name('register');
});






// Bkash routes


// bkash/auth/

Route::get('/dev-login/{msisdn}', [BkashController::class, 'devLogin']);

Route::prefix('bkash')->name('bkash.')->group(function () {
    Route::match(['get', 'post'], '/auth', [BkashController::class, 'auth'])->name('auth');
    Route::get('/login/{id_token}', [BkashController::class, 'login'])->name('login');
});


// bkash/login/{id_token}



// Home Page Public fetch
Route::get('campaign/{id}/fetch', [CampaignController::class, 'fetch'])->name('fetch');
Route::get('game/{id}/fetch', [GameController::class, 'fetch'])->name('fetch');
Route::get('gameover', [GameController::class, 'gameover'])->name('gameover');
Route::get('leaderboard/{id?}/fetch', [CampaignController::class, 'fetchLeaderboard'])->name('fetch-leaderboard');
Route::get('campaign/block/user', [CampaignController::class, 'blockUser']);

Route::middleware('role:player,admin')->get('game-play/{id}/{campaign_id}', [GameController::class, 'gamePlay'])->name('game-play');

Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // CampaignController
    //
    Route::prefix('/campaign')->name('campaign.')->group(function () {
        Route::get('/', [CampaignController::class, 'index'])->name('index');
        Route::post('/create', [CampaignController::class, 'create'])->name('create');
        Route::put('/update', [CampaignController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [CampaignController::class, 'delete'])->name('delete');
        
        // clone campaign
        Route::get('/{id}/clone', [CampaignController::class, 'cloneCampaign'])->name('clone-campaign');

    });  
    
    Route::prefix('/prize')->name('prize.')->group(function () {
        Route::get('/', [PrizeController::class, 'index'])->name('index');
        Route::get('/{id}/fetch', [PrizeController::class, 'fetch'])->name('fetch');
        Route::post('/store', [PrizeController::class, 'store'])->name('store');
    });

    Route::prefix('/game')->name('game.')->group(function () {
        Route::get('/', [GameController::class, 'index'])->name('index');
        Route::post('/create', [GameController::class, 'create'])->name('create');
        Route::put('/update', [GameController::class, 'update'])->name('update');
    });
    

    Route::prefix('/report')->name('report.')->group(function () {
        Route::get('/pay-logs', [ReportController::class, 'payLogs'])->name('pay-logs');
        Route::get('/daily-winner-list', [ReportController::class, 'dailyWinnerList'])->name('daily-winner-list');
        Route::get('/weekly-winner-list', [ReportController::class, 'weeklyWinnerList'])->name('weekly-winner-list');
        Route::get('/score-log', [ReportController::class, 'scoreLog'])->name('score-log');
        Route::get('/day-based-score-log', [ReportController::class, 'dayBasedScoreLog'])->name('day-based-score-log');
        Route::get('/summery-report', [ReportController::class, 'summeryReport'])->name('summery-report');
        Route::get('/play-logs', [ReportController::class, 'playLogs'])->name('play-logs');
    });

    
});


// landing page LandingPageController
Route::get('landing', [LandingPageController::class, 'index'])->name('landing.index');
Route::get('new-password/{msisdn}/{camp_id}', [LandingPageController::class, 'newPassword'])->name('landing.new-password');
