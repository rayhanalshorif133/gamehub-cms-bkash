<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\User;
use App\Models\Score;
use App\Models\ChargeLog;
use App\Models\Subscription;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Game;
use App\Models\UserHasBoost;
use App\Models\Boost;
use App\Models\PointLog;
use Carbon\Carbon;

class WebController extends Controller
{
    

   

    public function account(Request $request)
    {


        $user_id = null;
        if (Auth::check()) {
            $profile_image = Auth::user()->image;
            if ($profile_image == null) {
                $profile_image = "/images/user/1741247755_bg-removebg-preview.png";
                $user = User::find(Auth::user()->id);
                $user->image = $profile_image;
                $user->save();
            }
            $user_id = Auth::user()->id;
            setcookie("user_id", $user_id, time() + 86400, "/", "", false, true);
        } else {
            return redirect()->route('home');
        }


        if ($request->method() == 'GET') {

             $today = Carbon::today()->format('Y-m-d');


            $payLogs = ChargeLog::where('msisdn', Auth::user()->phone)
                ->orderBy('id', 'desc')
                ->get()
                ->filter(function ($item) {
                    $item->campaign = Campaign::where('id', $item->campaign_id)->first();
                    $item->position = $this->getPosition($item->campaign_id);
                    return true;
                })
                ->values();

            $campaigns = Campaign::where('status', 1)
                ->whereDate('start_date', '<=', $today)
                ->whereDate('end_date', '>=', $today)
                ->inRandomOrder()
                ->get()
                ->map(function ($campaign) {
                    $campaign->position = $this->getPosition($campaign->id);
                    return $campaign;
                });

            return view('web.account-new', compact('payLogs', 'profile_image', 'campaigns'));
        }


        if (!$user_id) {
            return redirect()->route('login');
        }

        $user = User::find($user_id);

        if ($request->image) {
            if ($user->image && file_exists(public_path($user->image))) {
                unlink(public_path($user->image)); // Delete the old image
            }

            $image = $request->file('image');
            $image_name = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('/images/user'), $image_name);
            $user->image = '/images/user/' . $image_name;
        }

        $user->name = $request->name;
        $user->save();

        Session::flash('success', 'Profile updated successfully');
        return redirect()->route('account');
    }

    public function category()
    {

        if (Auth::check()) {
            $user_id = Auth::user()->id;
            setcookie("user_id", $user_id, time() + 86400, "/", "", false, true);
        }
        $campaigns = Campaign::select()->get();
        $games = Game::where('status', 1)
            ->inRandomOrder()
            ->get();
        return view('web.category', compact('campaigns', 'games'));
    }

    public function notAllow()
    {

        return view('errors.403');
    }

    public function rewardPoint($coin, $type)
    {



        if (Auth::check()) {
            if ($type == 'login-reward') {
                $today = Carbon::today()->toDateString();
                $hasClimbedToday = CoinLog::where('user_id', Auth::user()->id)
                    ->whereDate('date', $today)
                    ->exists();
                if (!$hasClimbedToday) {
                    $newCoin = new CoinLog();
                    $newCoin->user_id = Auth::user()->id;
                    $newCoin->campaign_id = null;
                    $newCoin->phone = Auth::user()->phone;
                    $newCoin->coin = $coin;
                    $newCoin->type = "login";
                    $newCoin->status = "success";
                    $newCoin->message = "Login Achievement";
                    $newCoin->date = Carbon::now()->toDateString();
                    $newCoin->time = Carbon::now()->toTimeString();
                    $newCoin->save();

                    Auth::user()->increment('coin', $newCoin->coin);
                }
            }
            return 'success';
        } else {
            return false;
        }
    }


    public function points(Request $request)
    {
        if (Auth::check()) {
            $points = PointLog::where('user_id', Auth::user()->id)
                ->orderBy('id', 'desc')
                ->get();
            return view('web.points', compact('points'));
        } else {
            return redirect()->route('home');
        }
    }

    public function boostBuy($type)
    {
        $activeCampaign = $this->activeCampaign();
        $game = Game::select()->where('id', $activeCampaign->game_id)->first();
        $boosts = Boost::where('status', 1)->get();



        if (Auth::check()) {
            $msisdn = Auth::user()->phone;
            $camp_id = $activeCampaign ? $activeCampaign->id : null;
            // UserHasBoost check for active boost
            $userBoost = UserHasBoost::where('msisdn', $msisdn)
                ->where('keyword', $game->keyword)
                ->where('camp_id', $activeCampaign ? $activeCampaign->id : null)
                ->latest()
                ->first();

            $boostIsActive = $userBoost && Carbon::parse($userBoost->expire_time)->isFuture();



            $gameURL = "/game-play/" . $game->id . "/" . $camp_id;
            return view('web.boost-buy', compact('type', 'game', 'camp_id', 'gameURL', 'boosts', 'boostIsActive'));
        } else {
            return redirect()->route('home');
        }
    }
}
