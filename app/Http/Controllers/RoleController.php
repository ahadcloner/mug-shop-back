<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Exception;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use function PHPUnit\Framework\assertStringEqualsStringIgnoringLineEndings;


class RoleController extends Controller
{
    public function index()
    {
        return Response() -> json(['data' => Role ::all()], 200);
    }

    public function create(Request $request)
    {

        $validator = Validator ::make($request -> all(), [
            'name' => 'required|unique:roles',
        ], [
            'name.required' => 'نام نقش را وارد کنید',
            'name.unique' => 'این نقش از قبل ثبت شده است',
        ]);

        if ($validator -> fails()) {
            return Response() -> json(
                ['errors' => $validator -> messages()],
                422
            );
        }

        $name = $request -> name;
        $role = new Role();
        $role -> name = $name;
        $role -> guard_name = 'web';
        $role -> save();

        return Response() -> json(['message' => 'نقش کاربری با موفقیت ثبت شد'], 201);

    }

    public function delete($id)
    {
        $role = Role ::find($id);
        if ($role) {
            $role -> delete();
            return Response() -> json(['message' => 'اطلاعات نقش با موفقیت حذف شد'], 200);
        } else {
            return Response() -> json(['message' => 'نقش مورد نظر پیدا نشد'], 200);
        }
    }

    public function get_permissions($id)
    {
        $role = Role ::find($id);
        if ($role) {

            return Response() -> json(['data' => $role -> permissions], 200);
        } else {
            return Response() -> json(['message' => 'نقش مورد نظر پیدا نشد'], 200);
        }
    }

    public function grant_permission(Request $request)
    {
        $role =Role::find( $request -> role_id);
        $permission = Permission::find($request->permission_id);
        if ($role) {
            if ($permission) {
                $role->givePermissionTo($permission);
                return Response()->json(['message'=>'عملیات با موفقیت انجام شد'],200);
            } else {
                return Response()->json(['message'=>'دسترسی مورد نظر یافت نشد'],404);
            }
        } else {
            return Response()->json(['message'=>'نقش مورد نظر یافت نشد'],404);
        }

    }

    public function revoke_permission(Request $request)
    {
        $role =Role::find( $request -> role_id);
        $permission = Permission::find($request->permission_id);
        if ($role) {
            if ($permission) {
                $role->revokePermissionTo($permission);
                return Response()->json(['message'=>'عملیات با موفقیت انجام شد'],200);
            } else {
                return Response()->json(['message'=>'دسترسی مورد نظر یافت نشد'],404);
            }
        } else {
            return Response()->json(['message'=>'نقش مورد نظر یافت نشد'],404);
        }

    }

    public function find($id)
    {
        $role = Role::find($id);
        if ($role)
        {
            return Response()->json(['data'=>$role]);
        }
        else
        {
            return Response()->json(['message'=>'نقش مورد نظر یافت نشد']);
        }

    }

    public function update($id , Request $request)
    {
        $validator = Validator ::make($request -> all(), [
            'name' => 'required|unique:roles',
        ], [
            'name.required' => 'نام نقش را وارد کنید',
            'name.unique' => 'این نقش از قبل ثبت شده است',
        ]);

        if ($validator -> fails()) {
            return Response() -> json(
                ['errors' => $validator -> messages()],
                422
            );
        }

        $role = Role::find($id);
        $role->name = $request->name;
        $role->save();
        return Response()->json(['message'=>'ویرایش با موفقیت انجام شد'],200);
    }
}
