<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\ChargeLog;
use App\Models\Game;
use App\Models\GrantToken;
use App\Models\PaymentCreate;
use App\Models\PaymentExecute;
use App\Models\Subscription;
use App\Models\SubUnsubsLog;
use App\Models\Score;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class ReportController extends Controller
{



    public function payLogs(Request $request)
    {
        if ($request->ajax()) {

            $query = ChargeLog::query();

            if ($request->filled('msisdn')) {
                $query->where('msisdn', 'LIKE', '%' . $request->msisdn . '%');
            }

            $fromDate = $request->input('from_date');
            $toDate = $request->input('to_date', $fromDate);

            if ($fromDate) {
                $query->whereDate('charge_date', '>=', $fromDate);
            }

            if ($toDate) {
                $query->whereDate('charge_date', '<=', $toDate);
            }

            $query->orderBy('charge_date', 'desc');

            return DataTables::of($query)
                ->addIndexColumn()
                ->toJson();
        }

        return view('report.pay-log');
    }


    public function dailyWinnerList(Request $request)
    {
        if ($request->ajax()) {
            $activeCampaign = $this->activeCampaign();
            $query = Score::selectRaw('msisdn, SUM(score) as total_score, DATE(date_time) as date')
                ->where('game_keyword', $activeCampaign->game_keyword)
                ->where('status', '1')
                ->groupBy('msisdn', 'date');

            if ($request->date) {
                $query = $query->whereDate('date_time', $request->date);
            }

            $query = $query->orderBy('total_score', 'desc');

            $scores = $query->get();


            return DataTables::of($scores)
                ->addIndexColumn()
                ->toJson();
        }

        return view('report.daily-winner-list');
    }


    public function weeklyWinnerList(Request $request)
    {
        if ($request->ajax()) {

            $keyword = $request->get('campaign_by_keyword');
            $campaign = Campaign::find($request->camp_id);

            $aggregate = $campaign->score_count_type . '(score) as total_score';
            $query = Score::selectRaw("msisdn, $aggregate, COUNT(*) as total_played")
                ->where('status', 1)
                ->where('game_keyword', $keyword);


            // 3. Apply Date Filters conditionally
            if ($request->filled(['date_from', 'date_to'])) {
                $query->whereBetween('date_time', [
                    $request->date_from . ' 00:00:00',
                    $request->date_to . ' 23:59:59'
                ]);
            }

            // 4. Execute and Format for DataTables
            $scores = $query->groupBy('msisdn')
                ->orderByDesc('total_score')
                ->get();

            return DataTables::of($scores)
                ->addIndexColumn()
                ->addColumn('campaign_name', fn() => $keyword)
                ->addColumn('duration', function () use ($request) {
                    return $request->filled(['date_from', 'date_to'])
                        ? "{$request->date_from} to {$request->date_to}"
                        : 'All Time';
                })
                ->toJson();
        }

        $games = Game::all();
        $campaigns = Campaign::select()
            ->get()
            ->each(function ($campaign) {
                $campaign = $campaign->calculateTimeForCampaign($campaign);
            });


        $activeCampaign = $campaigns->firstWhere('time_status', '!=', 'Expired');
        return view('report.weekly-winner-list', compact('games','campaigns', 'activeCampaign'));
    }

    // score log

    public function scoreLog(Request $request)
    {
        if ($request->ajax()) {
            $query = Score::query();

            if ($request->has('game_keyword') && $request->game_keyword != '') {
                $query->where('game_keyword', $request->game_keyword);
            }

            if ($request->has('msisdn') && $request->msisdn != '') {
                $query->where('msisdn', 'like', '%' . $request->msisdn . '%');
            }

            if ($request->filled('start_date') && $request->filled('end_date')) {
                $query->whereBetween('date_time', [$request->start_date, $request->end_date]);
            }
            elseif ($request->filled('start_date')) {
                $query->whereDate('date_time', '>=', $request->start_date);
            }
            elseif ($request->filled('end_date')) {
                $query->whereDate('date_time', '<=', $request->end_date);
            }

            $query->orderBy('date_time', 'desc');

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('date', function ($row) {
                    return Carbon::parse($row->date_time)->format('Y-m-d');
                })
                ->addColumn('time', function ($row) {
                    return Carbon::parse($row->date_time)->format('H:i:s');
                })
                ->toJson();
        }

        $games = Game::all();
        $game_id = null;

        if($request->has('camp_id') && $request->camp_id != ''){
            $campaign = Campaign::find($request->camp_id);
            $game_id = $campaign->game_id;
        }

        return view('report.score-log', compact('games', 'game_id'));
    }

    public function dayBasedScoreLog(Request $request)
    {
        if ($request->ajax()) {
            $campaignKeyword = $request->campaign_by_keyword;
            $msisdn = $request->msisdn;

            $startDate = $request->start_date;
            $endDate = $request->end_date;

            $query = Score::selectRaw('msisdn, SUM(score) as total_score, DATE(date_time) as date')
                ->where('status', '1');

            if ($campaignKeyword) {
                $query->where('game_keyword', $campaignKeyword);
            }
            if ($startDate && $endDate) {
                $start = Carbon::parse($startDate)->startOfDay();
                $end = Carbon::parse($endDate)->endOfDay();

                $query->whereBetween('date_time', [$start, $end]);
            }



            if ($msisdn) {
                $query->where('msisdn', 'LIKE', "%{$msisdn}%");
            }

            // Grouping by Date and MSISDN
            $scores = $query->groupBy('date', 'msisdn')
                ->orderBy('date', 'asc')
                ->orderBy('total_score', 'desc')
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $scores
            ]);
        }

        $campaigns = Campaign::all();
        return view('report.day-based-score-log', compact('campaigns'));
    }

    public function playLogs(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table('game_play_logs')
                ->select('msisdn', 'keyword', 'start_time', 'end_time', 'durations', 'score', 'status', 'date');

            if ($request->has('game_keyword') && $request->game_keyword != '') {
                $query->where('game_keyword', $request->game_keyword);
            }

            if ($request->has('msisdn') && $request->msisdn != '') {
                $query->where('msisdn', 'like', '%' . $request->msisdn . '%');
            }

            if ($request->has('date') && $request->date != '') {
                $query->whereDate('date', $request->date);
            }

            $query->orderBy('date', 'desc');

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('date', function ($row) {
                    return Carbon::parse($row->date)->format('Y-m-d');
                })
                ->addColumn('start_time', function ($row) {
                    return Carbon::parse($row->start_time)->format('H:i:s');
                })
                ->addColumn('end_time', function ($row) {
                    return Carbon::parse($row->end_time)->format('H:i:s');
                })
                ->addColumn('durations', function ($row) {
                    return Carbon::parse($row->durations)->format('H:i:s');
                })
                ->toJson();
        }

        $games = Game::all();
        return view('report.play-log', compact('games'));
    }
}
