<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    // jwt
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(LoginRequest $request)
    {
        $now = Carbon::now();
        $remember_me = $request->remember_me;
        $credentials = $request->only('email', 'password');
        // tạo token
        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }
        // Lưu thông tin user vào database
        $user = User::where('email', $request->email)->first();
        $user->last_login_at = $now;
        $user->last_login_ip = $request->ip();
        $user->save();
        // thòi gian cookies tồn tại, 1 ngày hoặc vĩnh viễn
        $expries = $remember_me ? null : 60 * 24 * 7;
        $cookie = cookie('auth_token', $token, $expries, '/', 'localhost', true, true, false, 'None');
        return response()->json([
            'user' => $user,
        ])->withCookie($cookie);
    }
    public function me(Request $request)
    {
        return response()->json(['user' => $request->user()]);
    }
    public function logout()
    {
        Auth::logout();
        $cookie = cookie()->forget('auth_token');
        return response()->json([
            'message' => 'Successfully logged out',
        ])->withCookie($cookie);
    }

    public function refresh()
    {
        return response()->json([
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
