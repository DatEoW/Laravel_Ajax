<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

            $user=User::orderBy('updated_at','desc')->paginate($perPage = 5, $columns = ['*'], $pageName = 'users');
            return view('list_user',compact('user'));


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input=[
            'name'=>$request->name,
            'password'=>$request->password,
            'email'=>$request->email,
            'is_active'=>1,
            'is_delete'=>1,
        ];
        $validator = $request->validate([
            'name' => 'required',
            'password' => 'required|between:6,10',
            'email' => 'required|unique:mst_users|email',

        ], [
            'required' => ':attribute Không được để trống',

            'between' => ':attribute Phải là số dương ',
            'unique' => ':attribute Không được trùng'
        ], [
            'name' => 'Tên',
            'password' => 'Mật khẩu',
            'email' => 'Email',

        ]);





        $user=User::create($input);
        return back()->with('error_code ',5);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
