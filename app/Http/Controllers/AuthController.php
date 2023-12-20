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
        $input=[
            'email'=>$request->email,
            'password'=>$request->password
        ];
        $data=$request->all();


        $remember_me = $request->has('remember_me') ? true : false;

        if (Auth::viaRemember()) {
            return redirect('')->with('success','Đăng nhập thành công');
        }

        if((Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember_me))||Auth::viaRemember()){
            $user=User::where('email',$request->email)->first();
            $now=Carbon::now();
            $user->last_login_at=$now;
            $user->last_login_ip=$request->ip();
            // $user->remember_token=$request->_token;
            // if(isset($data['remember'])&& !empty($data['remember'])){

            // }
            $user->save();

            return redirect('')->with('success','Đăng nhập thành công');
        }
        else{

        }
        return back()->with('error','Email hoặc Password sai');
    }
    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }

}
