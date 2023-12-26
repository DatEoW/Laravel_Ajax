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
        $is_active=$request->is_active ?? 1;

        $user=User::orderBy('created_at','desc')->where('is_delete',1);
        // dd($request->group_role);
        if(!empty($name)){
            $user=$user->where('name','like' ,"%$name%");
        }
        if(!empty($email)){
            $user=$user->where('email','like',"%$email%");
        }

        $user=$user->where('is_active',$is_active);

        if(isset($request->group_role)){

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
        return response()->json([$paginate],201);
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
        // dd($request->all());
        if($request->ajax()){
            $input=[
                'name'=>$request->name,
                'password'=>$request->password,
                'email'=>$request->email,
                'is_active'=>1,
                'is_delete'=>1,
                'group'=>1,
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
    public function update(Request $request, string $id)
    {
        $user=User::find($id);
      if($request->ajax()){
        $input=[
            'name'=>$request->name,
            'password'=>$request->password,
            'email'=>$request->email,
            'is_active'=>1,
            'is_delete'=>1,
            'group'=>1,
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
        $user->name=$input['name'];
        $user->email=$input['email'];
        $user->password=$input['password'];
        $user->is_active=$user->is_active+0;
        $user->is_delete=$user->is_delete+0;
        $user->group=$user->group+0;
        $user->save();
        return response()->json([
            'success'=>'Cập nhật thành viên thành công !',
        ],201);
      }

    }
    public function updateUser(Request $request, $id){
        $user=User::find($id);
      if($request->ajax()){
        $input=[
            'name'=>$request->name,
            'password'=>$request->password,
            'email'=>$request->email,
            'is_active'=>1,
            'is_delete'=>1,
            'group'=>1,
        ];
        $validator = $request->validate([
            'name' => 'required',
            'password' => 'required',
            'email' => 'required',

        ], [
            'required' => ':attribute Không được để trống',

        ], [
            'name' => 'Tên',
            'password' => 'Mật khẩu',
            'email' => 'Email',

        ]);
        $user->name=$input['name'];
        $user->email=$input['email'];
        $user->password=$input['password'];
        $user->is_active=$user->is_active+0;
        $user->is_delete=$user->is_delete+0;
        $user->group=$user->group+0;
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
    public function search_user (Request $request){
        if($request->ajax()){
            $input=$request->all();
            // dd($input);
            $query=\DB::table('mst_users');

            if(!empty($input['name'])&&isset($input['name'])){

                $query=$query->where('name',$input['name']);
            }
            $query=$query->orderBy('created_at','desc')->paginate(50)->getCollection()->transform(function($user){
                $user->active_text = $user->is_active ? 'Đang hoạt động' : 'Tạm khóa';
                if($user->group==0){
                    $user->group_text='Admin';
                }else if($user->group==1){
                    $user->group_text='Editor';
                }else if($user->group==2){
                    $user->group_text='Reviewer';
                }else{
                    $user->group_text='None';
                }
                    return $user;
            });
            return DataTables::of($query)
            ->addColumn('action',function($row){
                return '<a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-info editButton" data-bs-toggle="modal"
                data-bs-target="#updateModal" ><i class="fas fa-edit"></i></a>
                <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-danger" data-bs-toggle="modal"
                data-id="'.$row->id.'"><i class="fas fa-cancel"></i></a>'
                ;
            })

            ->make(true);

        }

    }
}
