<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\PointLog;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\api\ScoreController;
use Carbon\Carbon;
use App\Models\Boost;
use App\Models\Score;
use App\Models\UserHasBoost;
use Illuminate\Support\Str;


class GameController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Game::orderBy('created_at', 'desc')
                ->get();
            return DataTables::of($query)
                ->addIndexColumn()
                ->toJson();
        }
        return view('game.index');
    }

    public function fetch(Request $request, $idOrKeyword)
    {

        if ($request->type == 'attend') {
            $game = Game::select()->where('id', $idOrKeyword)->first();
            $game->incrementAttempt();
            return $this->respondWithSuccess('Successfully fetched game', $game);
        }

        if ($request->type == 'check-keyword') {
            $game = Game::select()->where('keyword', $idOrKeyword)->first();
            if ($game) {
                return $this->respondWithSuccess('Already exists');
            } else {
                return $this->respondWithError('Game\'s keyword does not exist');
            }
        }

        if ($request->type == 'check-keyword-update') {
            $game = Game::select()->where('id', '!=', $idOrKeyword)->where('keyword', $request->keyword)->first();
            if ($game) {
                return $this->respondWithSuccess('Already exists');
            } else {
                return $this->respondWithError('Game\'s keyword does not exist');
            }
        }

        $game = Game::select()->where('id', $idOrKeyword)->first();
        return $this->respondWithSuccess('Successfully fetched game', $game);
    }

    // create
    public function create(Request $request)
    {
        try {

            $hasAlready = Game::select()->where('keyword', $request->keyword)->first();
            if ($hasAlready) {
                Session::flash('error', 'Game\'s keyword already exist');
                return redirect()->back();
            }

            $game = new Game();
            $game->title = $request->title;
            $game->keyword = $request->keyword;
            $game->status = $request->status;
            $game->url = $request->url;

            if ($request->banner) {
                $image = $request->file('banner');
                $image_name = time() . '_' . $image->getClientOriginalName();

                $image->move(public_path('/images/game'), $image_name);
                $game->banner = '/images/game/' . $image_name;
            }

            $game->description = $request->description;
            $game->save();

            Session::flash('success', 'Game created successfully');
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

            $hasAlready = Game::select()->where('id', '!=', $request->id)->where('keyword', $request->keyword)->first();

            if ($hasAlready) {
                Session::flash('error', 'Game\'s keyword already exist');
                return redirect()->back();
            }

            $game = Game::select()->where('id', $request->id)->first();
            $game->title = $request->title;
            $game->keyword = $request->keyword;
            $game->status = $request->status;
            $game->url = $request->url;

            if ($request->banner) {
                // Check if there's an existing banner to delete
                if ($game->banner) {
                    $existingImagePath = public_path($game->banner);
                    if (file_exists($existingImagePath)) {
                        unlink($existingImagePath); // Delete the old banner image
                    }
                }

                $image = $request->file('banner');
                $image_name = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('/images/game'), $image_name);

                // Update the banner field in the game record
                $game->banner = '/images/game/' . $image_name;
            }


            $game->description = $request->description;
            $game->save();

            Session::flash('success', 'Game updated successfully');
            return redirect()->back();
        } catch (\Throwable $th) {
            Session::flash('error', 'Something went wrong');
            Session::flash('error', $th->getMessage());
            return redirect()->back();
        }
    }


    public function gamePlay($game_id, $campaign_id)
    {

        if (Auth::check()) {
            $auth_user = Auth::user();
            $game = Game::find($game_id);
            $random_mac = Str::random(12);
            $auth_user->attend_camp_id = $campaign_id;
            $auth_user->attend_game_id = $game_id;
            $auth_user->mac = $random_mac;
            $auth_user->save();

            // Set Reward
            $hasClimbedToday = PointLog::where('user_id', Auth::user()->id)
                ->whereDate('date', date('Y-m-d'))
                ->where('type', 'trail')
                ->exists();
            if (!$hasClimbedToday) {
                $newPoint = new PointLog();
                $newPoint->user_id = Auth::user()->id;
                $newPoint->campaign_id = null;
                $newPoint->phone = Auth::user()->phone;
                $newPoint->point = 1;
                $newPoint->type = "trail";
                $newPoint->status = "success";
                $newPoint->message = "Trail Game Play Achievement";
                $newPoint->date = date('Y-m-d');
                $newPoint->time = date('H:i:s');
                $newPoint->save();
                Auth::user()->increment('point', $newPoint->point);
            }

            // $auth_user

            $url = $game->url . "?mac=" . $random_mac;

            return redirect(url($url));
        } else {
            return redirect()->route('home');
        }
    }


    public function gameOver(Request $request)
    {


        $score =  $request->score;
        $keyword =  $request->keyword;
        $camp_id =  $request->camp_id ? $request->camp_id : 'free';




        if ($request->puntaje) {
            $scoreController = new ScoreController();
            $response = $scoreController->score($request);
            if (isset($response->original['score'])) {
                $score =  $response->original['score']->score;
                $keyword =  $response->original['score']->game_keyword;
                $camp_id =  $response->original['score']->campaign_id;
                $score = (int)$score;
            } else {
                $camp_id = 'free';
            }
        }

        $camp_id == '' ?? $camp_id = 'free';

        $game = Game::select()->where('keyword', $keyword)->first();
        $gameURL = "/game-play/" . $game->id . "/" . $camp_id;

        $leaderboardEnabled = false;
        $boost = null;
        $playTimes = 0;

        if ($camp_id != 'free') {
            $campaign = Campaign::select()->where('id', $camp_id)->first();

            if ($campaign) {
                $leaderboardEnabled = true;
            }
            if (Auth::check()) {
                $msisdn = Auth::user()->phone;
                if ($campaign) {
                    $playTimes = Score::where('msisdn', $msisdn) // Ekhane msisdn filter kora hoyeche
                        ->where('game_keyword', $campaign->game_keyword)
                        ->where('status', '1')
                        ->where('campaign_id', $camp_id)
                        ->count();
                }
                $userBoost = UserHasBoost::where('msisdn', $msisdn)
                    ->where('keyword', $keyword)
                    ->where('camp_id', $camp_id)
                    ->latest()
                    ->first();
                $boostIsActive = $userBoost && Carbon::parse($userBoost->expire_time)->isFuture();

                if ($boostIsActive) {
                    $boost = Boost::find($userBoost->boost_id);
                    $expiry = Carbon::parse($userBoost->expire_time);
                    $now = Carbon::now();
                    $boost->remaining_time = $now->diffForHumans($expiry, true);
                }
            }
        }

        return view('web.gameover', compact('score', 'game', 'gameURL', 'camp_id', 'leaderboardEnabled', 'boost', 'playTimes'));
    }
}
