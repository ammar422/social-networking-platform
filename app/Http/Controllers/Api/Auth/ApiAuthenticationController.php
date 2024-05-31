<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use Illuminate\Http\Request;

class ApiAuthenticationController extends Controller
{
    public function login(LoginRequest $request)
    {
        // if (!Auth::attempt($request->validated())) {
        //     return response()->json(['message' => 'Invalid credentials'], 401);
        // }
        // $user = Auth::user();

        $user = User::where('email', $request->validated('email'))->first();
        if (!$user || !Hash::check($request->validated('password'), $user->password)) {
            return response()->json(['message' => 'invalied user\'s credentials  '], 401);
        }
        $token = $user->createToken('Personal Access Token')->accessToken;
        return response()->json(['access_token' => $token, 'user' => $user]);
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('Personal Access Token')->accessToken;

        return response()->json(['token' => $token], 201);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->token()->revoke();
        return response()->json(['message' => 'Successfully logged out'], 200);
    }

    // public function profile()
    // {
    //     $user = Auth::guard('api')->user();
    //     return response()->json(['user' => $user]);
    // }
}
