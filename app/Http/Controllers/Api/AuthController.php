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
    public function login(LoginRequest $request): Response
    {
        $user = User::where('email', $request->email)->first();
        $now = Carbon::now();
        $remember_me = $request->remember_me;
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember_me)) {

            $userAuth = Auth::user();
            // add thông tin user
            $user->last_login_at = $now;
            $user->last_login_ip = $request->ip();
            $user->save();
            //
            $token =  $userAuth->createToken('MyApp')->plainTextToken;

            $cookie = cookie('auth_token', $token, 60 * 24 * 7);
            $data = [
                'status' => true,
                'token' => $token,
                'user' => $userAuth,
                'test' => $remember_me,
            ];
            return response()->json($data, 200)->withCookie($cookie);
        }
        return Response(['message' => 'Email hoặc Mật khẩu không đúng', 'status' => false], 401);
    }

    /**
     * Display the specified resource.
     */
    public function logout(Request $request): response
    {
        auth()->user()->tokens()->delete();
        // $request->user()->currentAccessToken()->delete();
        Auth::guard('web')->logout();
        return response()->json(['data' => 'Đăng xuất thành công'], 200);
    }
}
