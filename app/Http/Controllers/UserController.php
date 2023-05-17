<?php

    namespace App\Http\Controllers;


    use App\Models\User;
    use Illuminate\Auth\Events\Registered;
    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Facades\Hash;
    use PHPUnit\Framework\Error;
    use Spatie\Permission\Models\Role;


    class UserController extends Controller
    {


        public function register(Request $request): \Illuminate\Http\JsonResponse
        {


            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ], [
                'email.required' => 'ایمیل خود را وارد کنید',
                'email.email' => 'ایمیل خود را با فرمت صحیح وارد کنید',
                'email.unique' => 'کاربر از قبل ثبت شده است',
                'password.required' => 'رمز خود را وارد کنید',

            ]);

            if ($validator->fails()) {
                return Response()->json(
                    ['errors' => $validator->messages()],
                    422
                );
            }
            try {
                $user = User::create(
                    [
                        'mobile' => $request->mobile,
                        'email' => $request->email,
                        'city_id' => $request->city_id,
                        'full_name' => $request->full_name,
                        'birth_date' => farsiToEngDate($request->birth_date),
                        'password' => Hash::make($request->password),
                        'status' => $request->status ? $request->status : false
                    ]
                );
                event(new Registered($user));
                return Response()->json(['message' => 'تبریک ، ثبت نام شما با موفقیت انجام شد'], 201);
            } catch (Error $e) {
                return Response()->json(['error' => 'فرمت ورودی ها را کنترل کنید'], 500);
            }


        }

        public function login(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => ['required']
            ], [
                'email.required' => 'ایمیل خود را وارد کنید',
                'email.email' => 'ایمیل خود را با فرمت صحیح وارد کنید',
                'password.required' => 'رمز خود را وارد کنید',

            ]);

            if ($validator->fails()) {
                return Response()->json(
                    ['errors' => $validator->messages()],
                    422
                );
            }
            $user = User::all()
                ->where('email', '=', $request->email)->first();

            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                    return Response()->json([
                            'message' => 'خوش آمدید',
                            'token' => $token]
                        , 200);
                } else {
                    return Response()->json([
                        'message' => 'رمز عبور صحیح نمی باشد'
                    ], 401);
                }
            } else {
                return Response()->json([
                    'message' => 'کاربری با اطلاعات دریافتی پیدا نشد'
                ], 404);
            }


        }

        public function logout(Request $request)
        {

            \auth()->user()->token()->revoke();
            return Response()->json([
                'message' => 'باموفقیت خارج شدید'
            ], 200);
        }


        public function index()
        {
            $data = User::with(['city.state'])->get();
            foreach ($data as $d) {
                if ($d->birth_date != null) {
                    $d->birth_date = verta($d->birth_date)->format('Y/m/d');
                }
                $d->created_at = str(verta($d->created_at)->format('Y/m/d'));

            }
            return Response()->json(['data' => $data], 200);
        }

        public function get_addresses(Request $request)
        {
            $user = User::find($request->user_id);
            if ($user) {
                return Response()->json([
                    'data' => $user->addresses
                ], 200);
            } else {
                return Response()->json([
                    'message' => 'کاربر مورد نظر شما پیدا نشد'
                ], 404);
            }
        }

        public function change_status(Request $request)
        {
            $user = User::find($request->user_id);

            if ($user) {
                $user->status = !(bool)$user->status;
                $user->save();
                return Response()->json([
                    'message' => 'تغییرات با موفقیت انجام شد'
                ], 200);
            } else {
                return Response()->json([
                    'message' => 'کاربر مورد نظر شما پیدا نشد'
                ], 404);
            }
        }

        public function find($id)
        {
            $user = User::with('city.state')->find($id);
            if ($user) {
                return Response()->json(['data' => $user], 200);
            }
            return Response()->json(['message' => 'کاربر مورد نظر پیدا نشد'], 400);
        }

        public function auth_find(Request $request)
        {
            $user = User::with('city.state')->find(auth()->id());
            if ($user->birth_date != null) {
                $user->birth_date = verta($user->birth_date)->format('Y/m/d');
            }
            return Response()->json(['data' => $user], 200);
        }

        public function update($id, Request $request)
        {

            $validator = Validator::make($request->all(), [
                'email' => 'required|email|',
            ], [
                'email.required' => 'ایمیل خود را وارد کنید',
                'email.email' => 'ایمیل خود را با فرمت صحیح وارد کنید',
            ]);

            if ($validator->fails()) {
                return Response()->json(
                    ['errors' => $validator->messages()],
                    422
                );
            }

            $user = User::find($id);
            if ($user) {
                $user->mobile = $request->mobile;
                $user->email = $request->email;
                $user->city_id = $request->city_id;
                $user->full_name = $request->full_name;
                $user->birth_date = farsiToEngDate($request->birth_date);
                if ($request->password) {
                    $user->password = Hash::make($request->password);
                }
                if ($request->status) {
                    $user->status = $request->status;
                } else {
                    $user->status = false;
                }
                $user->save();
                return Response()->json(['message' => 'تغییرات با موفقیت انجام شد'], 200);


            } else {
                return Response()->json(['message' => 'کاربر مورد نظر پیدا نشد'], 400);
            }

        }

        public function delete($id)
        {
            $user = User::find($id);
            if ($user) {
                $user->delete();
                return Response()->json(['message' => 'کابر با موفقیت حذف شد'], 200);
            }
            return Response()->json(['message' => 'کاربر مورد نظر پیدا نشد'], 400);
        }

        public function get_roles($id)
        {
            $user = User::find($id);
            if ($user) {
                return Response()->json(['data' => $user->roles()->get()], 200);
            }
            return Response()->json(['message' => 'کاربر مورد نظر پیدا نشد'], 400);
        }

        public function assign_role(Request $request)
        {
            $user = User::find($request->user_id);
            if ($user) {
                $role = Role::where('name', '=', $request->role)->first();
                if ($role) {
                    $user->assignRole($role);
                    return Response()->json(['message' => 'عملیات با موفقیت انجام شد'], 200);
                } else {
                    return Response()->json(['message' => 'نقش مورد نظر پیدا نشد'], 404);
                }
            } else {
                return Response()->json(['message' => 'کاربر مورد نظر پیدا نشد'], 404);
            }
        }

        public function revoke_role(Request $request)
        {
            $user = User::find($request->user_id);
            if ($user) {
                $role = Role::where('name', '=', $request->role)->first();
                if ($role) {
                    $user->removeRole($role);
                    return Response()->json(['message' => 'عملیات با موفقیت انجام شد'], 200);
                } else {
                    return Response()->json(['message' => 'نقش مورد نظر پیدا نشد'], 404);
                }
            } else {
                return Response()->json(['message' => 'کاربر مورد نظر پیدا نشد'], 404);
            }
        }
    }
