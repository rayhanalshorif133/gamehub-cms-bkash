<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Score;
use App\Models\Game;
use App\Models\Campaign;
use App\Models\User;
use App\Models\Subscription;
use App\Models\UserHasBoost;
use App\Models\Boost;
use App\Models\GamePlayLog;
use Carbon\Carbon;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\DB;

class ScoreController extends Controller
{
    // score
    function getCurrentUrl()
    {
        // Check if HTTPS is used
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443)
            ? "https://"
            : "http://";

        // Construct the full URL
        $currentUrl = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        return $currentUrl;
    }


    public function score(Request $request)
    {


        try {



            $userId = null;

            if (isset($_COOKIE["user_id"])) {
                $userId = $_COOKIE["user_id"];
            }

            $puntaje = $request->puntaje;

            if ($puntaje == null || $userId == null) {
                return response()->json('Invalid Request, required puntaje and user_id');
            }


            $user = User::find($userId);
            $game = Game::find($user->attend_game_id);
            $encrypted_score = null;

            if ($request->type == 'unity') {
                $encrypted_score = $puntaje;
                $puntaje = str_replace(' ', '+', $puntaje);
                $puntaje = $this->decryptUnityData($puntaje, '1234567890123456');
            } else {

                $puntaje = json_decode($puntaje, true);
                $encrypted_score = $puntaje['ciphertext'];
                $puntaje = $this->decryptData($puntaje['key'], $puntaje['salt'], $puntaje['iv'], $puntaje['ciphertext']);
            }



            $msisdn = $user->phone;
            if (substr($msisdn, 0, 2) !== '88') {
                $msisdn = '88' . $msisdn;
            }
            $keyword = $game->keyword;
            $campaign_id =  $user->attend_camp_id;
            $get_score = $puntaje;



            // FIND SUBSCRIPTION
            $boostIsActive = false;
            $boost = null;
            $subscription_id = null;
            $message = 'No Subscription Found';
            if ($campaign_id != 'Free') {
                $subscription = Subscription::where('msisdn', '=',  $msisdn)
                    ->where('campaign_id', '=', $campaign_id)
                    ->where('status', '=', 1)
                    ->first();
                if ($subscription) {
                    $subscription_id = $subscription->id;
                    $message = 'Score achieved with subscription';
                }
            }


            $score = new Score();
            $score->status = 1;
            $score->message = $message;
            $score->subscription_id = $subscription_id;

            // GET SCORE FROM 10AM TO 11::59 PM OTHERWISE FREE SCORE
            // $current_time = date('H:i');
            // $campaign_id = ($current_time >= '10:00' && $current_time <= '23:59') ? $campaign_id : 'free';

            if ($campaign_id == 'free') {
                $campaign_id = null;
                $score->status = 0;
                $score->message = 'Free Score';
            }

            if ($score->subscription_id == null) {
                $score->status = 0;
                $score->message = 'Has Campaign But Not Subscriber yet';
            }



            $score->campaign_id = $campaign_id;
            $score->msisdn = $msisdn;

            if ($campaign_id != 'Free') {
                $userBoost = UserHasBoost::where('msisdn', $msisdn)
                    ->where('keyword', $keyword)
                    ->where('camp_id', $campaign_id)
                    ->latest()
                    ->first();
                $boostIsActive = $userBoost && Carbon::parse($userBoost->expire_time)->isFuture();

                if ($boostIsActive) {
                    $boost = Boost::find($userBoost->boost_id);
                    $get_score = (int)$get_score * (int)$boost->score_up;
                    $score->message = 'Score achieved with Boost!';
                }
            }

            $score->score = $get_score;
            $score->encrypted_score = $encrypted_score;
            $score->game_keyword = $keyword;
            $score->device_type = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
            $score->user_mac = null;
            $score->mac = $request->mac ? $request->mac : "Unknown";
            $score->date_time = date('Y-m-d H:i:s');
            $score->hit_url = $this->getCurrentUrl();
            $score->save();

            return response()->json([
                'type' => 'success',
                'score' => $score,
            ]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }







    function decryptUnityData($cipherText, $key)
    {
        $key = substr($key, 0, 16);
        $combined = base64_decode($cipherText);
        $iv = substr($combined, 0, 16);
        $encrypted = substr($combined, 16);
        $plainText = openssl_decrypt($encrypted, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
        return $plainText;
    }



    function decryptData($key, $salt, $iv, $ciphertext)
    {

        $key = str_replace(" ", "+", $key);
        $salt = str_replace(" ", "+", $salt);
        $iv = str_replace(" ", "+", $iv);
        $ciphertext = str_replace(" ", "+", $ciphertext);

        $method = "AES-256-CBC"; // Ensure this matches the encryption method used
        $key = base64_decode($key);
        $iv = base64_decode($iv);
        $ciphertext = base64_decode($ciphertext);

        // Decrypt
        $decrypted = openssl_decrypt($ciphertext, $method, $key, OPENSSL_RAW_DATA, $iv);

        return $decrypted;
    }


    public function checkScore(Request $request)
    {


        $userId = null;
        if (isset($_COOKIE["user_id"])) {
            $userId = $_COOKIE["user_id"];
        }
        $user = User::find($userId);
        $game = Game::find($user->attend_game_id);


        $msisdn = $user->phone;
        $keyword = $game->keyword;
        $activeCampaign = $this->activeCampaign();

        if (!$msisdn || !$keyword) {
            return response()->json([
                'status' => 'error',
                'message' => 'MSISDN and Keyword are required'
            ], 400);
        }



        $totalScore = Score::where('msisdn', $msisdn)
            ->where('game_keyword', $keyword)
            ->where('status', 1)
            ->where('campaign_id', $activeCampaign ? $activeCampaign->id : null)
            ->sum('score');

        // 1. Player-er Rank Calculation
        $currentRank = Score::where('game_keyword', $keyword)
            ->where('status', 1)
            ->where('campaign_id', $activeCampaign ? $activeCampaign->id : null)
            ->groupBy('msisdn')
            ->selectRaw('msisdn, SUM(score) as total')
            ->orderByDesc('total')
            ->get()
            ->pluck('msisdn')
            ->search($msisdn) + 1;

        $boostActive = false;

        // Condition: Rank jodi 7 er beshi hoy (mane top 7 er baire)
        if ($currentRank > 7) {
            $isLastDays = false;
            if ($activeCampaign) {
                $remainingDays = Carbon::now()->diffInDays($activeCampaign->end_date, false);
                if ($remainingDays <= 2 && $remainingDays >= 0) {
                    $isLastDays = true;
                }
            }

            // Recent Performance Check (Last 24 hours)
            $recentScore = Score::where('msisdn', $msisdn)
                ->where('game_keyword', $keyword)
                ->where('status', 1)
                ->where('created_at', '>=', now()->subDay())
                ->sum('score');

            // Average Performance
            $firstPlayDate = Score::where('msisdn', $msisdn)->min('created_at');
            $daysPlayed = max(1, Carbon::parse($firstPlayDate)->diffInDays(now()));
            $avgDailyScore = $totalScore / $daysPlayed;

            // Trigger Boost
            if ($isLastDays && $recentScore > ($avgDailyScore * 1.5)) {
                $boostActive = true;
            }
        }

        // UserHasBoost check for active boost
        $userBoost = UserHasBoost::where('msisdn', $msisdn)
            ->where('keyword', $keyword)
            ->where('camp_id', $activeCampaign ? $activeCampaign->id : null)
            ->latest()
            ->first();

        $isActive = $userBoost && Carbon::parse($userBoost->expire_time)->isFuture();

        if ($isActive == true) {
            $boostActive = false;
        }

        return response()->json([
            'status' => 'success',
            'msisdn' => $msisdn,
            'game' => $keyword,
            'rank' => $currentRank,
            'total_score' => $totalScore ? (int)$totalScore : 0,
            'boost_active' => $boostActive
        ]);
    }


    public function gamePlayLog(Request $request)
    {
        $userId = null;
        if (isset($_COOKIE["user_id"])) {
            $userId = $_COOKIE["user_id"];
        }
        $user = User::find($userId);
        $game = Game::find($user->attend_game_id);


        $msisdn = $user->phone;
        $keyword = $game->keyword;



        $log = GamePlayLog::where('msisdn', $msisdn)
            ->where('keyword', $keyword)
            ->whereNull('end_time')
            ->latest()
            ->first();


        if ($log) {
            $score = score::where('msisdn', $msisdn)
                ->where('game_keyword', $keyword)
                ->latest()
                ->first();
            $log->end_time = Carbon::now()->format('Y-m-d H:i:s');
            $log->status = 'completed';
            $log->score = $score ? $score->score : 0;
            $log->save();
            $getLog = GamePlayLog::find($log->id);
            $score->durations = $getLog->durations;
            $score->save();
            return response()->json([
                'status' => 'success',
                'log' => $getLog
            ]);
        }


        $log = GamePlayLog::create([
            'date'       => Carbon::now()->format('Y-m-d'),
            'msisdn'     => $msisdn,
            'keyword'    => $keyword,
            'start_time' => Carbon::now()->format('Y-m-d H:i:s'),
            'end_time'   => null,
            'status'     => 'initial',
        ]);

        return response()->json([
            'status' => 'success',
            'log' => $log
        ]);
    }
}
