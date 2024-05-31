<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Api\Auth\LoginRequest;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Authenticate user and generate access token",
     *     tags={"auth"},
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="User's email",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="User's password",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Login successful"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
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


    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Logs out the authenticated user by revoking the access token.",
     *     tags={"auth"},
     *     @OA\Response(response="200", description="logout successful"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function logout(Request $request)
    {
        $user = $request->user();
        $user->token()->revoke();
        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}
