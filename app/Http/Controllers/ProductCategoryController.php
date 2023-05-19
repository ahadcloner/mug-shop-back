<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Validator;

class ProductCategoryController extends Controller
{
    public function index()
    {
        return Response() -> json(['data' => ProductCategory::all()], 200);
    }

    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], [
            'name.required' => 'نام دسته بندی را وارد کنید',
        ]);

        if ($validator->fails()) {
            return Response()->json(
                ['errors' => $validator->messages()],
                422
            );
        }

        $pg = new ProductCategory();
        $pg->name = $request->name;
        $pg->save();
        return Response()->json(['message' => 'دسته بندی جدید با موفقیت ایجاد شد'], 201);
    }

    public function update($id, Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], [
            'name.required' => 'نام دسته بندی را وارد کنید',
        ]);

        if ($validator->fails()) {
            return Response()->json(
                ['errors' => $validator->messages()],
                422
            );
        }
        $pg = ProductCategory::find($id);
        $pg->name = $request->name;
        $pg->save();
        return Response()->json(['message','عملیات با موفقیت انجام شد'],200);
    }

    public function delete($id): \Illuminate\Http\JsonResponse
    {
        $pg = ProductCategory::find($id);
        if($pg)
        {
            $pg->delete();
            return Response()->json(['message','عملیات با موفقیت انجام شد'],200);
        }
        return Response()->json(['message','دسته بندی مورد نظر یافت نشد'],404);
    }

    public function find($id)
    {
        $item = ProductCategory::find($id);
        if($item)
        {
            return Response()->json(['data'=>$item],200);
        }
        return Response()->json(['message'=>'دسته بندی مورد نظر یافت نشد'],404);
    }
}
