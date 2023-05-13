<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;


class PermisionController extends Controller
{
    public function index(){
        return Response()->json(['data'=>Permission::all()],200);
    }
    public function create(Request $request){
        $validator = Validator ::make($request -> all(), [
            'name' => 'required|unique:permissions',
        ], [
            'name.required' => 'نام دسترسی را وارد کنید',
            'name.unique' => 'این دسترسی از قبل ثبت شده است',
        ]);

        if ($validator -> fails()) {
            return Response() -> json(
                ['errors' => $validator -> messages()],
                422
            );
        }

        $name = $request ->name;
        $role = new Permission();
        $role -> name = $name;
        $role -> guard_name = 'web';
        $role -> save();

        return Response() -> json(['message' => 'دسترسی با موفقیت ثبت شد'], 201);

    }
    public function delete($id)
    {
        $role = Permission ::find($id);
        if ($role) {
            $role -> delete();
            return Response() -> json(['message' => 'اطلاعات دسترسی با موفقیت حذف شد'], 200);
        } else {
            return Response() -> json(['message' => 'دسترسی مورد نظر پیدا نشد'], 200);
        }
    }

    public function find($id)
    {
        $role = Permission::find($id);
        if ($role)
        {
            return Response()->json(['data'=>$role]);
        }
        else
        {
            return Response()->json(['message'=>'دسترسی مورد نظر یافت نشد']);
        }

    }

    public function update($id , Request $request)
    {
        $validator = Validator ::make($request -> all(), [
            'name' => 'required|unique:permissions',
        ], [
            'name.required' => 'نام دسترسی را وارد کنید',
            'name.unique' => 'این دسترسی از قبل ثبت شده است',
        ]);

        if ($validator -> fails()) {
            return Response() -> json(
                ['errors' => $validator -> messages()],
                422
            );
        }

        $role = Permission::find($id);
        $role->name = $request->name;
        $role->save();
        return Response()->json(['message'=>'ویرایش با موفقیت انجام شد'],200);
    }
}
