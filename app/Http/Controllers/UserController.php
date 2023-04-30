<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{


    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email'=>'required' ,
            'email'=>'email',
            'email'=>'unique:users,email',
            'password'=>'required'
        ] ,[
            'email.required'=>'ایمیل خود را وارد کنید',
            'email.email'=>'ایمیل خود را با فرمت صحیح وارد کنید',
            'email.unique'=>'کاربر از قبل ثبت شده است',
            'password.required'=>'رمز خود را وارد کنید',

        ]);

        if ($validator->fails()) {
            return Response()->json(
                ['errors'=>$validator->messages()],
                422
            );
        }

        User::create(
            [
                'email'=>$request->email,
                'password'=>$request->password
            ]
        );
        return Response()->json(['message'=>'تبریک ، ثبت نام شما با موفقیت انجام شد'],201);



    }
}
