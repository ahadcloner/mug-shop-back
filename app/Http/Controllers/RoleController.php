<?php

    namespace App\Http\Controllers;

    use http\Env\Response;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;
    use PHPUnit\Exception;
    use Spatie\Permission\Models\Role;


    class RoleController extends Controller
    {
        public function index()
        {
            return Response()->json(['data' => Role::all()], 200);
        }

        public function create(Request $request)
        {

            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:roles',
            ], [
                'name.required' => 'نام نقش را وارد کنید',
                'name.unique' => 'این نقش از قبل ثبت شده است',
            ]);

            if ($validator->fails()) {
                return Response()->json(
                    ['errors' => $validator->messages()],
                    422
                );
            }

            $name = $request->name;
            $role = new Role();
            $role->name = $name;
            $role->guard_name = 'web';
            $role->save();

            return Response()->json(['message'=>'نقش کاربری با موفقیت ثبت شد'],201);

        }
    }
