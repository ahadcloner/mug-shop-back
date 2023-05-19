<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function index()
    {
        return Response() -> json(['data' => Brand::all()], 200);
    }

    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], [
            'name.required' => 'نام برند را وارد کنید',
        ]);

        if ($validator->fails()) {
            return Response()->json(
                ['errors' => $validator->messages()],
                422
            );
        }

        $pg = new Brand();
        $pg->name = $request->name;
        if($request->name2)
        {
            $pg->name2 = $request->name2;
        }
        $pg->save();
        return Response()->json(['message' => 'برند جدید با موفقیت ایجاد شد'], 201);
    }

    public function update($id, Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], [
            'name.required' => 'نام برند را وارد کنید',
        ]);

        if ($validator->fails()) {
            return Response()->json(
                ['errors' => $validator->messages()],
                422
            );
        }
        $pg = Brand::find($id);
        $pg->name = $request->name;
        if($request->name2)
        {
            $pg->name2 = $request->name2;
        }
        $pg->save();
        return Response()->json(['message','عملیات با موفقیت انجام شد'],200);
    }

    public function delete($id): \Illuminate\Http\JsonResponse
    {
        $pg = Brand::find($id);
        if($pg)
        {
            $pg->delete();
            return Response()->json(['message','عملیات با موفقیت انجام شد'],200);
        }
        return Response()->json(['message','برند مورد نظر یافت نشد'],404);
    }
}
