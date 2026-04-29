<?php

namespace App\Http\Controllers;

use App\Models\BkashAuth;
use App\Models\BkashAuthLog;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


class BkashController extends Controller
{


    // ::TODO:: Remove - :: Dev Login system
    public function devLogin(Request $request, $msisdn)
    {

        if (!str_starts_with($msisdn, '88')) {
            $msisdn = '88' . $msisdn;
        }

        $request->merge([
            'username'      => 'bkgamers',
            'password'      => 'b2mbdgbkash',
            'mobile_number' => $msisdn,
        ]);

        $data = $this->auth($request);

        $token = $data->original['id_token'];



        return $this->login($request, $token);
    }

    public function auth(Request $request)
    {
        try {



            if ($request->username != 'bkgamers' || $request->password != 'b2mbdgbkash' || $request->mobile_number == null) {
                return response()->json([
                    'message' => 'Invalid User Data',
                ]);
            }


            // find by mobile number
            $bkashAuth = BkashAuth::where('mobile_number', $request->mobile_number)->first();

            if ($bkashAuth) {
                $bkashAuth->status = 'active';
            } else {
                $bkashAuth = BkashAuth::create([
                    'username' => $request->username,
                    'password' => $request->password,
                    'mobile_number' => $request->mobile_number,
                    'status' => 'active',
                ]);
            }

            $bkashAuth->id_token = $bkashAuth->generateToken(40);
            $bkashAuth->save();

            $dateTime = Carbon::parse($bkashAuth->updated_at)->format('Y-m-d H:i:s');

            $response = [
                'id_token' => $bkashAuth->id_token,
                'update_time' => $dateTime,
            ];

            $bkashAuth->response = $response;
            $bkashAuth->save();



            if ($bkashAuth) {
                BkashAuthLog::create([
                    'mobile_number' => $request->mobile_number,
                    'id_token' => $bkashAuth->id_token,
                    'created_date' => now()->format('Y-m-d'),
                    'created_time' => now()->format('H:i:s'),
                    'exp_time' => date('H:i:s', strtotime('+1 hour')),
                ]);
                return response()->json($response);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ]);
        }
    }


    public function login(Request $request, $id_token)
    {
        try {
            $bkashAuth = BkashAuth::where('id_token', $id_token)->first();

            if ($bkashAuth) {

                $bkashAuthLog = BkashAuthLog::where('id_token',  $id_token)->first();

                if ($bkashAuthLog && Carbon::parse($bkashAuthLog->exp_time)->isPast()) {
                    return response()->json([
                        'message' => 'Token Expired',
                    ]);
                }

                if (Auth::check()) {
                    Auth::logout();
                }

                $user = User::where('phone', $bkashAuth->mobile_number)->first();
                Auth::logoutOtherDevices($bkashAuth->mobile_number);
                if ($user) {
                    Auth::login($user);
                } else {
                    $pass = $bkashAuth->generateToken(8);
                    $player = User::create([
                        'phone' => $bkashAuth->mobile_number,
                        'password' => Hash::make($pass),
                    ]);
                    $player->assignRole('player');
                    Auth::login($player);
                }
                $request->session()->regenerate();
                // Session::flash('success', 'Login successful!');
                setcookie("user_id", $user->id, time() + 86400, "/", "", false, true);
                return redirect()->route('home');
            } else {
                Session::flash('error', 'Invalid credentials. Please try again.');
                return redirect()->route('home');
            }
        } catch (\Throwable $th) {
            return redirect()->route('home');
        }
    }
}
