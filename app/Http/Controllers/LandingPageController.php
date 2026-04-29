<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Campaign;
use App\Models\TrafficLog;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\api\ScoreController;
use Illuminate\Support\Facades\Http;


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


        $campaigns = Campaign::select()
            ->get()
            ->each(function ($campaign) {
                $campaign = $campaign->calculateTimeForCampaign($campaign);
                $campaign->game = Game::select()->where('id', $campaign->game_id)->first();
            })->filter(function ($campaign) {
                return $campaign->time_status !== 'Expired';
            })->values();
        $activeCampaign = $campaigns->firstWhere('time_status', '!=', 'Expired');
        $hasSubs = false;
        return view('landing.index', compact('activeCampaign', 'hasSubs'));
    }

    public function newPassword(Request $request, $msisdn, $camp_id)
    {
        $campaign = Campaign::select()->where('id', $camp_id)->first();
        return view('landing.new-password', compact('msisdn', 'campaign'));
    }
}
