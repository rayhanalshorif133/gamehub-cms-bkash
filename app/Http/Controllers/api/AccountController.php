<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AccountController extends Controller
{
    public function attendGame(Request $request){
        try {
            $user = User::select()->where('id', $request->user_id)->first();
            $user->attend_game_id = $request->game_id;
            $user->attend_camp_id = $request->camp_id;
            $user->save();
            return $this->respondWithSuccess('success', $user);
        } catch (\Throwable $th) {
            return $this->respondWithError('error', 'Something went wrong');
        }
    }
}
