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
        // dd($data);
        // $ip=$request->ip();
        // dd($ip);
    //     $validator = Validator::make($input, [
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ],
    //     [
    //         'required' => ':attribute Không được để trống.',
    //         'password' => ':attribute Phải là số dương',

    //     ], [
    //         'email' => 'Email',
    //         'password' => 'Mật Khẩu',
    //     ]



    // );
        // dd($input);
        // if($validator->fails()){
        //     // dd($validator->errors());
        //     return back()->with('error',$validator->errors());
        // }

        if(Auth::attempt($input)){
            $user=User::where('email',$request->email)->first();
            $now=Carbon::now();
            $user->last_login_at=$now;
            $user->last_login_ip=$request->ip();


            if(isset($data['remember'])&& !empty($data['remember'])){

                $user->remember_token=$request->_token;


                setcookie('email',$data['email'],time()+3600);
                setcookie('password',$data['password'],time()+3600);
            }
            else{
                setcookie('email','');
                setcookie('password','');
            }
            $user->save();
            return redirect('')->with('success','Đăng nhập thành công');
        }

        return back()->with('error','Email hoặc Password sai');





    }

}
