<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
       /**
     * Hiển thị dữ liệu(search,sort,phân trang,...)
     * @param  $request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {

        $this->authorize('viewAny', User::class);
        $perPage = $request->perPage ?? 10;
        $name = $request->name;
        $email = $request->email;
        $is_active = $request->is_active;
        $group_role=$request->group_role;
        $user = User::orderBy('id', 'desc')->where('is_delete', 0);
        $user->active($is_active);
        $user->byName($name);
        $user->byEmail($email);
        $user->byGroupRole($group_role);
        $paginate = $user->paginate($perPage);
        $paginate->getCollection()->transform(function ($user) {
            $user->getActiveTextAttribute();
            $user->getGroupTextAttribute();
            return $user;
        });

        if ($request->ajax()) {
            return response()->json([$paginate], 201);
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
     * Thêm user
     * @param  $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function store(UserRequest $request)
    {
        try{
            $this->authorize('create', User::class);
            if ($request->ajax()) {
                $input = [
                    'name' => $request->name,
                    'password' => $request->password,
                    'email' => $request->email,
                    'is_active' => 1,
                    'is_delete' => 0,
                    'group_role' => $request->group_role,
                ];

                $user = User::create($input);
                return response()->json([
                    'success' => 'Thêm thành viên mới thành công !',
                ], 201);
            }

        }catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 403);
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
     * Truy cập vào form chỉnh sửa user
     * @param  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(string $id)
    {
        try {
            $this->authorize('update', User::class);
        $user = User::find($id);
        return response()->json($user);
        }catch(\Illuminate\Auth\Access\AuthorizationException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 403);
        }
    }

     /**
     * Chỉnh sửa thông tin user
     * @param  $id
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function update(UserRequest $request)
    {

        try {
            $this->authorize('update', User::class);


            $id = $request->id;
            $user = User::find($id);

            if ($request->ajax()) {
                $name = $request->name ?? $user->name;
                $email = $request->email ?? $user->email;
                $password = $request->password ?? $user->password;
                $is_active = $request->is_active ?? 1;

                $group_role = $request->group_role;

                $user->name = $name;
                $user->email = $email;
                $user->password = $password;
                $user->is_active = $is_active;

                if (isset($request->group_role)) {
                    $user->group_role = $group_role;
                }
                $user->save();
                return response()->json([
                    'success' => 'Cập nhật thành viên thành công !',
                ], 201);
            }
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 403);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
     /**
     * Điều chỉnh trạng thái user(khóa,mở khóa,xóa)
     * @param  $id
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function changeUser(Request $request)
    {
        try {
            $this->authorize('update', User::class);
            $user = User::find($request->id);
            $phuongThuc = $request->phuongThuc;
            if ($phuongThuc === 'delete') {
                $user->is_delete = 1;
                $user->save();
            }
            if ($phuongThuc === 'lock') {
                $user->is_active = 0;
                $user->save();
            }
            if ($phuongThuc === 'unlock') {
                $user->is_active = 1;
                $user->save();
            }
            return response()->json(['phuongThuc' => $phuongThuc], 201);
        }catch(\Illuminate\Auth\Access\AuthorizationException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 403);
        }

    }
}
