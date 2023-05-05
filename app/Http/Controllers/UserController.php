<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Error;


class UserController extends Controller
{


    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator ::make($request -> all(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ], [
            'email.required' => 'ایمیل خود را وارد کنید',
            'email.email' => 'ایمیل خود را با فرمت صحیح وارد کنید',
            'email.unique' => 'کاربر از قبل ثبت شده است',
            'password.required' => 'رمز خود را وارد کنید',

        ]);

        if ($validator -> fails()) {
            return Response() -> json(
                ['errors' => $validator -> messages()],
                422
            );
        }

        $user = User ::create(
            [
                'email' => $request -> email,
                'password' => Hash ::make($request -> password)
            ]
        );
        return Response() -> json(['message' => 'تبریک ، ثبت نام شما با موفقیت انجام شد'], 201);

    }

    public function login(Request $request)
    {
        $validator = Validator ::make($request -> all(), [
            'email' => 'required|email',
            'password' => ['required']
        ], [
            'email.required' => 'ایمیل خود را وارد کنید',
            'email.email' => 'ایمیل خود را با فرمت صحیح وارد کنید',
            'password.required' => 'رمز خود را وارد کنید',

        ]);

        if ($validator -> fails()) {
            return Response() -> json(
                ['errors' => $validator -> messages()],
                422
            );
        }
        $user = User ::all()
            -> where('email', '=', $request -> email) -> first();

        if ($user) {
            if (Hash ::check($request -> password, $user -> password)) {
                $token = $user -> createToken('Laravel Password Grant Client') -> accessToken;
                return Response() -> json([
                        'message' => 'خوش آمدید',
                        'token' => $token]
                    , 200);
            } else {
                return Response() -> json([
                    'message' => 'رمز عبور صحیح نمی باشد'
                ], 401);
            }
        } else {
            return Response() -> json([
                'message' => 'کاربری با اطلاعات دریافتی پیدا نشد'
            ], 404);
        }


    }

    public function logout(Request $request)
    {

            \auth() -> user() -> token() -> revoke();
            return Response() -> json([
                'message' => 'باموفقیت خارج شدید'
            ], 200);
    }


    public function index()
    {
        $data = User::with(['city.state'])->get();
        foreach ($data as $d){
            if($d->birth_date!=null)
            {
                $d->birth_date = verta($d->birth_date)->format('Y/m/d');
            }
            $d->created_at = str(verta($d->created_at)->format('Y/m/d'));

        }
        return Response()->json(['data'=>$data],200);
    }

}
