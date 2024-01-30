<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
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


    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index(Request $request)
    {
        $perPage = $request->perPage ?? 10;
        $name = $request->name;
        $email = $request->email;
        $is_active = $request->is_active;
        $group_role = $request->group_role;
        $user = User::orderBy('id', 'desc')->where('is_delete', User::NOTDELETE);
        $user->active($is_active);
        $user->byName($name);
        $user->byEmail($email);
        $user->byGroupRole($group_role);
        $paginate = $user->paginate($perPage);
        return response()->json($paginate, 200);
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


        $input = [
            'name' => $request->name,
            'password' => $request->password,
            'email' => $request->email,
            'is_active' => 1,
            'is_delete' => User::NOTDELETE,
            'group_role' => $request->group_role,
        ];

        $user = User::create($input);
        return response()->json([
            'success' => 'Thêm thành viên mới thành công !',
        ], 201);
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

        $user = User::find($id);
        return response()->json($user, 200);
    }

    /**
     * Chỉnh sửa thông tin user
     * @param  $id
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function update(UserRequest $request)
    {
        $id = $request->id;
        $user = User::find($id);

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


        $user = User::find($request->id);
        $phuongThuc = $request->phuongThuc;
        if ($phuongThuc === 'delete') {
            $user->is_delete = User::DELETED;
            $user->save();
        }
        if ($phuongThuc === 'lock') {
            $user->is_active = User::NOTACTIVE;
            $user->save();
        }
        if ($phuongThuc === 'unlock') {
            $user->is_active = User::ACTIVE;
            $user->save();
        }
        return response()->json(['phuongThuc' => $phuongThuc], 201);
    }
}
