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
        // $perPage=$request->perPage;

        $perPage=$request->perPage ?? 10;
        $name=$request->name ?? 0;
        $email=$request->email ?? 0;
        $is_active=$request->is_active;
        $search_active=$request->is_active ?? 2;
        $user=User::orderBy('id','desc')->where('is_delete',1);
        if($search_active!=2){
            $user=$user->where('is_active',$is_active);
        }
        if(!empty($name)){
            $user=$user->where('name','like' ,"%$name%");
        }
        if(!empty($email)){
            $user=$user->where('email','like',"%$email%");
        }

        if(isset($request->group_role)&&($request->group_role!=3)){
                $user=$user->where('group_role',$request->group_role);
        }
        $paginate = $user->paginate($perPage);
        $paginate->getCollection()->transform(function($user){
            $user->active_text = $user->is_active ? 'Hoạt động' : 'Tạm khóa';
            if($user->group_role==0){
                $user->group_text='Admin';
            }else if($user->group_role==1){
                $user->group_text='Editor';
            }else if($user->group_role==2){
                $user->group_text='Reviewer';
            }
                return $user;
        });
        if($request->ajax()){
            return response()->json([$paginate],201);
        }
        return view('user_um');

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
        if($request->ajax()){
            $input=[
                'name'=>$request->name,
                'password'=>$request->password,
                'email'=>$request->email,
                'is_active'=>1,
                'is_delete'=>1,
                'group_role'=>$request->group_role,
            ];
            $validator = $request->validate([
                'name' => 'required',
                'password' => 'required',
                'email' => 'required|unique:mst_users|email',
                'group_role'=>'required',


            ], [
                'required' => ':attribute Không được để trống',
                'unique' => ':attribute Không được trùng',
                'email'=> ':attribute Phải là định dạng email'
            ], [
                'name' => 'Tên',
                'password' => 'Mật khẩu',
                'email' => 'Email',
                'group_role'=>'Nhóm'

            ]);
            $user=User::create($input);
            return response()->json([
                'success'=>'Thêm thành viên mới thành công !',
            ],201);
        }


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
        $user=User::find($id);
        // dd($user);
        if(!$user){
            abort(404);
        }
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id=$request->id;
        $user=User::find($id);
        // dd($user);
      if($request->ajax()){
        $name=$request->name ?? $user->name;
        $email=$request->email ?? $user->email;
        $password=$request->password ?? $user->password;
        $is_active=$request->is_active ?? 1;

        $group_role=$request->group_role;
        $validator = $request->validate([
            'name' => 'required',
            'password' => 'required',
            'email' => 'required|email',
        ], [
            'required' => ':attribute Không được để trống',
            'unique' => ':attribute Không được trùng',
            'email'=> ':attribute Phải là định dạng email'
        ], [
            'name' => 'Tên',
            'password' => 'Mật khẩu',
            'email' => 'Email',

        ]);
        $user->name=$name;
        $user->email=$email;
        $user->password=$password;
        $user->is_active=$is_active;

        if(isset($request->group_role)){
            $user->group_role=$group_role;
        }
        $user->save();
        return response()->json([
            'success'=>'Cập nhật thành viên thành công !',
        ],201);
      }

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function deleteUser(Request $request){

        $user=User::find($request->id);
        $phuongThuc=$request->phuongThuc;
        if($phuongThuc==='delete'){
            $user->is_delete=0;
            $user->save();
        }
        if($phuongThuc==='lock'){
            $user->is_active=0;
            $user->save();
        }
        if($phuongThuc==='unlock'){
            $user->is_active=1;
            $user->save();
        }
        // dd($user->is_active);

        return response()->json(['phuongThuc'=>$phuongThuc],201);
    }
}
