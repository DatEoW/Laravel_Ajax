<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UserRequest;
use DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user=User::orderBy('created_at','desc')->get();
        // dd($user);
        if($request->ajax()){
            return DataTables::of($user)
            ->addColumn('action',function(){
                return '<a href="" class=""btn btn-info><i class="fas fa-edit"></i></a>';
            })

            ->make(true);
        }



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
        // return $request->all();
        $input=[
            'name'=>$request->name,
            'password'=>$request->password,
            'email'=>$request->email,
            'is_active'=>1,
            'is_delete'=>1,
        ];
        $validator = $request->validate([
            'name' => 'required',
            'password' => 'required',
            'email' => 'required|unique:mst_users|email',

        ], [
            'required' => ':attribute Không được để trống',
            'unique' => ':attribute Không được trùng'
        ], [
            'name' => 'Tên',
            'password' => 'Mật khẩu',
            'email' => 'Email',

        ]);
        // $user=User::create($input);
        return response()->json([
            'success'=>'Thêm thành viên mới thành công !',
        ],201);

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
