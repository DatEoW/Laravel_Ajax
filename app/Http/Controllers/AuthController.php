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
    public function to_login(){
        return view('login');
    }

    public function login(LoginRequest $request){
        //check mail
        $user=User::where('email',$request->email)->first();
        $now=Carbon::now();
        if(empty($user)){
            return back()->with('error_email','Email không chính xác');
        }
        $remember_me = $request->has('remember_me') ? true : false;
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password],$remember_me)){
            $user->last_login_at=$now;
            $user->last_login_ip=$request->ip();
            $user->save();
            //tăng cường bảo mật
            $request->session()->regenerate();
            return redirect('')->with('user',Auth::user());
        }

        return back()->with('error_password','Mật khẩu không chính xác');
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

}
