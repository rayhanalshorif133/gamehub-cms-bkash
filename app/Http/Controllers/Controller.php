<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Campaign;
use App\Models\Score;
use Illuminate\Support\Facades\Auth;


class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    function getPosition($camp_id)
    {

        $msisdn = Auth::user()->phone;
        $campaign = Campaign::where('id', $camp_id)->first();
        if (!$campaign) return "No Campaign";

        $aggregate = $campaign->score_count_type . '(score) as total_score';

        $scores = Score::selectRaw("msisdn, $aggregate")
            ->where('game_keyword', $campaign->game_keyword)
            ->where('status', '1')
            ->where('campaign_id', $camp_id)
            ->groupBy('msisdn')
            ->orderBy('total_score', 'desc')
            ->get();

        foreach ($scores as $key => $item) {
            if ($item->msisdn == $msisdn) {
                $rank = $key + 1;

                if (!in_array(($rank % 100), [11, 12, 13])) {
                    switch ($rank % 10) {
                        case 1:
                            return $rank . 'st';
                        case 2:
                            return $rank . 'nd';
                        case 3:
                            return $rank . 'rd';
                    }
                }
                return $rank . 'th';
            }
        }

        return "N/A";
    }

    protected function respondWithSuccess($message = '', $data = [], $code = 200)
    {
        return response()->json([
            'status'   => true,
            'errors'  => false,
            'message'  => $message,
            'data'     => $data
        ], $code);
    }
    protected function respondWithError($message, $data = [], $code = 203)
    {
        return response()->json([
            'status'   => false,
            'errors'  => true,
            'message'  => $message,
            'data'     => $data
        ], $code);
    }



    public function getCurrentCampaign($id = null)
    {
        $date = date('Y-m-d');
        $campaign = Campaign::where('status', 1)
            ->where('start_date', '<=', $date)
            ->where('end_date', '>=', $date)
            ->first();
        return $campaign;

        if ($id) {
            $campaign = Campaign::where('status', 1)
                ->where('id', $id)
                ->where('start_date', '<=', $date)
                ->where('end_date', '>=', $date)
                ->first();
        }
    }

    public function isActiveCampaign($id = null)
    {
        $date = date('Y-m-d');
        if ($id) {
            $campaign = Campaign::where('status', 1)
                ->where('id', $id)
                ->where('start_date', '<=', $date)
                ->where('end_date', '>=', $date)
                ->first();

            if ($campaign) {
                return 'active';
            } else {
                return 'inactive';
            }
        }
    }

    public function activeCampaign()
    {
        return Campaign::all()
            ->each(function ($campaign) {
                $campaign->calculateTimeForCampaign($campaign);
            })
            ->first(function ($campaign) {
                return $campaign->time_status !== 'Expired';
            });
    }
}
