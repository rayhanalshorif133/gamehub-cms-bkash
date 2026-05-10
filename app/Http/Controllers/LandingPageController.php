<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Campaign;
use App\Models\TrafficLog;
use Illuminate\Http\Request;
use Carbon\Carbon;


class LandingPageController extends Controller
{
    public function index(Request $request)
    {
        $trafficLog = new TrafficLog();
        $trafficLog->tracking_id = $request->t_id ? $request->t_id : null;
        $trafficLog->ip_address = $request->ip();
        $trafficLog->user_agent = $request->header('User-Agent');
        $trafficLog->url = $request->fullUrl();
        $trafficLog->save();


        $today = Carbon::today()->format('Y-m-d');
        $campaigns = Campaign::where('status', 1)
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->inRandomOrder()
            ->get()
            ->each(function ($campaign) {
                $campaign->game = Game::select()->where('id', $campaign->game_id)->first();
            });

        return view('landing.index', compact('campaigns'));
    }

    public function newPassword(Request $request, $msisdn, $camp_id)
    {
        $campaign = Campaign::select()->where('id', $camp_id)->first();
        return view('landing.new-password', compact('msisdn', 'campaign'));
    }
}
