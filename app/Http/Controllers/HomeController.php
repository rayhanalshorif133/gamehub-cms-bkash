<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\ChargeLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Subscription;
use App\Models\PointLog;
use App\Models\Game;
use Carbon\Carbon;
use App\Models\CampaignLevel;
use App\Models\UserHasBoost;
use App\Models\UserBlockList;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{

    public function home(Request $request)
    {



        $hasLoginAchievement = false;

        if (Auth::check()) {
            $hasClimbedToday = PointLog::where('user_id', Auth::user()->id)
                ->whereDate('date', date('Y-m-d'))
                ->where('type', 'login')
                ->exists();
            if (!$hasClimbedToday) {
                $newPoint = new PointLog();
                $newPoint->user_id = Auth::user()->id;
                $newPoint->campaign_id = null;
                $newPoint->phone = Auth::user()->phone;
                $newPoint->point = 1;
                $newPoint->type = "login";
                $newPoint->status = "success";
                $newPoint->message = "Login Achievement";
                $newPoint->date = Carbon::now()->toDateString();
                $newPoint->time = Carbon::now()->toTimeString();
                $newPoint->save();
                Auth::user()->increment('point', $newPoint->point);
            }

            setcookie("user_id", Auth::user()->id, time() + 86400, "/", "", false, true);
        }

        $today = Carbon::today()->format('Y-m-d');

        $targetKeyword = 'bubble-shooter';

        $campaigns = Campaign::where('status', 1)
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->orderByRaw("
        CASE
            WHEN game_keyword LIKE ? THEN 1
            ELSE 2
        END ASC", ["%{$targetKeyword}%"])
            ->orderBy('game_keyword', 'asc') // Secondary sort to keep things organized
            ->get();


        $games = Game::select()->where('status', 1)->inRandomOrder()->get()->take(4);
        $userId = null;
        $user = null;
        if (isset($_COOKIE["user_id"]) && $campaigns->count() > 0) {
            $userId = $_COOKIE["user_id"];
            $user = User::find($userId);
            foreach ($campaigns as $campaign) {
                $hasChargeLog = ChargeLog::where('msisdn', $user->phone)
                    ->where('campaign_id', $campaign->id)
                    ->exists();

                $campaign->msisdn = $user->phone;
                $campaign->count_player = ChargeLog::where('campaign_id', $campaign->id)
                    ->count();


                $today = Carbon::today()->toDateString();

                $campaign->hasLevel = false;
                $levelCount = CampaignLevel::where('campaign_id', $campaign->id)->count();
                $campaign->hasLevel = $levelCount > 1? true : false;
                $campaignLevel = CampaignLevel::where('campaign_id', $campaign->id)
                    ->where('start_date', '<=', $today)
                    ->where('end_date', '>=', $today)
                    ->orderBy('level_number', 'asc')
                    ->first();

                if ($campaignLevel && $campaignLevel->game_id) {
                    $getGame = Game::where('id', $campaignLevel->game_id)->first();

                    if ($getGame) {
                        $campaign->bg_color = $getGame->bg_color;
                        $campaign->banner = $getGame->icon;
                    }
                }


                $campaign->block = UserBlockList::where('msisdn', $user->phone)
                    ->where('campaign_id', $campaign->id)
                    ->where('is_read', 0)
                    ->first();
                if ($hasChargeLog) {
                    $campaign->has_charge_log = true;
                } else {
                    $campaign->has_charge_log = false;
                }
            }
        }

        return view('home', compact('campaigns', 'hasLoginAchievement', 'games'));
    }




    public function admin()
    {
        if (Auth::check()) {
            if (Auth::user()->roles[0]->name == "admin") {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('login');
        }
    }
}
