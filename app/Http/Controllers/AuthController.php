<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    /**
     * Di chuyển tới trang đăng nhập
     * @return \Illuminate\View\View
     */
    public function to_login()
    {
        return view('login');
    }
    /**
     * Xử lý đăng nhập
     * @param  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(LoginRequest $request)
    {
        //check mail

        $user = User::where('email', $request->email)->first();
        $now = Carbon::now();

        $remember_me = $request->has('remember_me') ? true : false;

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember_me)) {
            $user->last_login_at = $now;
            $user->last_login_ip = $request->ip();
            $user->save();
            //tăng cường bảo mật
            $request->session()->regenerate();
            return redirect()->route('product.index')->with('user', Auth::user());
        }
        return back()->with('error_password', 'Thông tin không chính xác')->withInput($request->input());
    }

    /**
     * Xử lý đăng xuất
     * @param  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
