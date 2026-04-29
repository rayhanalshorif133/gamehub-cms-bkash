<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PlayerLoginController extends Controller
{

    public function login(Request $request)
    {
        // Validate input data
        $request->validate([
            'phone' => 'required|string|min:11|max:13',
            'password' => 'required|string|min:4',
        ]);

        // Attempt authentication
        $credentials = $request->only('phone', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            Session::flash('success', 'Login successful!');
        } else {
            Session::flash('error', 'Invalid credentials. Please try again.');
        }
        return redirect()->route('home');
    }

    public function register(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'name' => 'string|min:2|max:15',
            'phone' => 'required|string|min:11|max:13', // Ensure phone is unique
            'password' => 'required|string|min:4', // Confirm password field
        ]);

        if ($validator->fails()) {
            // Return validation errors as JSON if the request expects JSON
            if ($request->reg_type == 'new_player') {
                Session::flash('error', $validator->errors()->first());
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid data. Please try again.',
                    'errors' => $validator->errors()
                ], 201);
            }
        }

        // Create a new user

        // find user
        $existingUser = User::where('phone', $request->phone)->first();
        if ($existingUser) {
            $existingUser->password = Hash::make($request->password);
            $existingUser->save();
        }else{
            $existingUser = User::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'password' => Hash::make($request->password)
            ]);
        }


        $existingUser->assignRole('player');
        // Attempt authentication

        $credentials = $request->only('phone', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if ($request->reg_type == 'new_player') {
                Session::flash('success', 'Login successful!');
                return redirect()->route('home');
            } else {
                return response()->json([
                    'status' => 'success',
                    'message' => 'login successful!',
                ], 200);
            }
        } else {
            if ($request->reg_type == 'new_player') {
                Session::flash('error', 'Invalid credentials. Please try again.');
                return redirect()->route('home');
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid credentials. Please try again.',
                ], 201);
            }
        }
    }
}
