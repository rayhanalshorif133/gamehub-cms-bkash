<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignLevel;
use App\Models\Game;
use App\Models\Subscription;
use App\Models\ChargeLog;
use App\Models\Score;
use App\Models\UserBlockList;
use App\Models\Prize;
use App\Models\PrizeDistribution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        if (request()->ajax()) {

            $query = Campaign::orderBy('id', 'desc');

            if ($request->date) {
                $formattedDate = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
                $query->whereDate('start_date', $formattedDate);
            }

            if ($request->game_id) {
                if ($request->game_id == 'active-next-camp') {
                    $query->where('end_date', '>=', Carbon::now()->toDateString());
                } else {
                    $query->where('game_id', $request->game_id);
                }
            }

            $campaigns = $query->get()->map(function ($campaign) {
                $campaign->type = $this->isActiveCampaign($campaign->id);
                $campaign->pay_count = ChargeLog::where('campaign_id', $campaign->id)->count();
                return $campaign;
            });


            return DataTables::of($campaigns)
                ->addIndexColumn()
                ->toJson();
        }

        $games = Game::select()->where('status', 1)->get();
        $prizes = Prize::all();
        $campaignDates = Campaign::selectRaw("DATE_FORMAT(start_date, '%d-%m-%Y') as formatted_date")
            ->distinct()
            ->orderBy('start_date', 'desc')
            ->pluck('formatted_date');
        return view('campaign.index', compact('games', 'prizes', 'campaignDates'));
    }

    public function fetch(Request $request, $id)
    {
        $campaign = Campaign::where('id', $id)
            ->first();

        $campaign->levels = CampaignLevel::where('campaign_id', $id)
            ->orderBy('level_number', 'asc')
            ->get();


        if (!$campaign->levels->count() > 0) {
            $campaign = $campaign->calculateTimeForCampaign($campaign);
            $campaign->type = $this->isActiveCampaign($id);
        } else {
            foreach ($campaign->levels as $level) {
                $game = Game::select()->where('status', 1)->where('id', $level->game_id)->first();
                $level->game_title = $game->title;
                $level->prize = Prize::where('id', $level->prize_id)->with('distributions')->first();
            }
        }

        $game = Game::select()->where('status', 1)->where('id', $campaign->game_id)->first();

        if (!$game) {
            $game = Game::select()->where('status', 1)->where('keyword', $campaign->game_keyword)->first();
        }

        $campaign->game = $game;
        $campaign->user = Auth::user();

        $campaign->hasSubs = false;
        if ($request->msisdn) {
            $campaign->hasSubs = Subscription::select()
                ->where('msisdn', $request->msisdn)
                ->where('campaign_id', $id)
                ->where('status', 1)
                ->first();
        }
        $campaign->prizes = Prize::where('id', $campaign->prize_id)->with('distributions')->first();


        return $this->respondWithSuccess('Successfully fetched campaign', $campaign);
    }

    public function fetchLeaderboard(Request $request, $id = null)
    {



        $campaign = Campaign::where('id', $id)
            ->first();


        $aggregate = $campaign->score_count_type . '(score) as total_score';
        $scores = Score::selectRaw("msisdn, $aggregate")
            ->where('game_keyword', $campaign->game_keyword)
            ->where('status', '1')
            ->where('campaign_id', $id)
            ->groupBy('msisdn')
            ->orderBy('total_score', 'desc')
            ->limit(30)
            ->get()->map(function ($item, $key) use ($campaign) {
                return [
                    'rank' => $key + 1,
                    'msisdn' => $item->msisdn,
                    'prize' => $this->getPrize($key + 1, $campaign->prize_id),
                    'total_score' => $item->total_score
                ];
            });



        $data = [
            'daily' => $scores,
            'user' => Auth::user()
        ];
        return $this->respondWithSuccess('Successfully fetched leaderboard', $data);
    }


    public function getPrize($rank, $prize_id)
    {

        $prize = PrizeDistribution::where('prize_id', $prize_id)
            ->where('rank_min', '<=', $rank)
            ->where('rank_max', '>=', $rank)
            ->first();
        return $prize ? (int)$prize->amount . ' ৳' : '---';
    }

    public function blockUser(Request $request)
    {
        if (Auth::user()) {
            $msisdn = Auth::user()->phone;
            $camp_id = $request->camp_id;

            $find_user = UserBlockList::where('msisdn', $msisdn)
                ->where('campaign_id', $camp_id)
                ->first();
            $find_user->is_read = 1;
            $find_user->save();
            return $this->respondWithSuccess('Successfully fetched campaign', $camp_id);
        } else {
            return $this->respondWithError('Unknown User');
        }
    }


    public function create(Request $request)
    {
        try {


            // Indirect modification of overloaded property Illuminate\Http\Request::$levels has no effect
            if ($request->has('levels') && !empty($request->levels)) {
                // 1. Assign to a variable to avoid the "overloaded property" error
                $levels = $request->levels;

                $campaign = Campaign::create([
                    'name'   => $request->name,
                    'amount' => $request->amount,
                    'status' => $request->status,
                ]);

                foreach ($levels as $index => $levelData) {
                    $campaign->levels()->create([
                        'level_number' => $index + 1,
                        'game_id'    => $levelData['game_id'],
                        'prize_id'   => $levelData['prize_id'],
                        'start_date' => $levelData['start_date'],
                        'end_date'   => $levelData['end_date'],
                    ]);
                }

                // 2. Use the variable here
                $campaign->start_date = $levels[0]['start_date'];
                $campaign->end_date = end($levels)['end_date'];
                $campaign->save();

                Session::flash('success', 'Campaign created successfully');
                return redirect()->back();
            }





            $startDateTime = $request->start_date_time;
            $endDateTime = $request->end_date_time;
            $campaign = new Campaign();
            $findPrize = Prize::find($request->prize_id);
            $campaign->prize_id = $request->prize_id;
            $campaign->start_date = date('Y-m-d', strtotime($startDateTime));
            $campaign->start_time = date('H:i:s', strtotime($startDateTime));
            $campaign->end_date = date('Y-m-d', strtotime($endDateTime));
            $campaign->end_time = date('H:i:s', strtotime($endDateTime));
            $campaign->name = $request->name;
            $campaign->amount = $request->amount;
            $campaign->gift_amount = $findPrize->total_amount;
            $campaign->game_id = $request->game_id;
            $findGame = Game::find($request->game_id);
            if ($findGame) {
                $campaign->banner = $findGame->icon;
                $campaign->game_keyword = $findGame->keyword;
            }
            $campaign->save();

            Session::flash('success', 'Campaign created successfully');
            return redirect()->back();
        } catch (\Throwable $th) {
            Session::flash('error', 'Something went wrong');
            Session::flash('error', $th->getMessage());
            return redirect()->back();
        }
    }


    public function update(Request $request)
    {
        try {


            $campaign_id = $request->campaign_id;

            if (!$campaign_id) {
                Session::flash('error', 'Campaign Not Found, Please try Again!');
                return redirect()->back();
            }


            $startDateTime = $request->start_date_time;
            $endDateTime = $request->end_date_time;
            $campaign = Campaign::find($campaign_id);
            if (!$campaign) {
                Session::flash('error', 'Campaign Not Found, Please try Again!');
                return redirect()->back();
            }
            $campaign->start_date = date('Y-m-d', strtotime($startDateTime));
            $campaign->start_time = date('H:i:s', strtotime($startDateTime));
            $campaign->end_date = date('Y-m-d', strtotime($endDateTime));
            $campaign->end_time = date('H:i:s', strtotime($endDateTime));
            $campaign->name = $request->name;
            $campaign->status = $request->status;
            $campaign->amount = $request->amount;
            if ($request->banner) {
                $image = $request->file('banner');
                $image_name = time() . '_' . $image->getClientOriginalName();

                $image->move(public_path('/images/campaign'), $image_name);
                $campaign->banner = '/images/campaign/' . $image_name;
            }

            $findGame = Game::find($request->game_id);
            $campaign->game_id = $request->game_id;
            if ($findGame) {
                $campaign->game_keyword = $findGame->keyword;
            }
            $campaign->save();

            Session::flash('success', 'Campaign updated successfully');
            return redirect()->back();
        } catch (\Throwable $th) {
            Session::flash('error', 'Something went wrong' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function delete($id)
    {
        try {


            $campaign = Campaign::find($id);
            if (!$campaign) {
                Session::flash('error', 'Campaign Not Found, Please try Again!');
                return redirect()->back();
            }


            $campaign->delete();
            Session::flash('success', 'Campaign deleted successful...!');
            return redirect()->back();
        } catch (\Throwable $th) {
            Session::flash('error', 'Something went wrong' . $th->getMessage());
            return redirect()->back();
        }
    }


    public function cloneCampaign($id)
    {

        try {
            $campaign = Campaign::findOrFail($id)->replicate();
            $campaign->start_date = Carbon::parse($campaign->end_date)->addDay()->format('Y-m-d');
            $campaign->end_date   = Carbon::parse($campaign->end_date)->addDays(3)->format('Y-m-d');
            $campaign->save();
            Session::flash('success', 'Campaign created successfully');
            return redirect()->back();
        } catch (\Throwable $th) {
            Session::flash('error', 'Something went wrong');
            return redirect()->back();
        }
    }
}
