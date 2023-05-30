<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use League\OAuth2\Server\RequestRefreshTokenEvent;
use PHPUnit\Framework\Error;


class ProductController extends Controller
{
    public function index()
    {
        return Response()->json(['data'=>Product::all()],200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:products',
            'price' => 'required|min:0|numeric',
            'category_id'=>'required',
            'brand_id'=>'required',
            'tags'=>'required|array',
            'quantity'=>'required|min:0|numeric',
            'discount'=>'required|min:0|numeric',
            'group_id'=>'required'
        ], [
            'name.required'=>'نام را وارد کنید',
            'name.unique:products'=>'این نام از قبل ثبت شده است',
            'price.required'=>'قیمت محصول را وارد کنید',
            'price.min:0'=>'قیمت نمی تواند از 0 کمتر باشد',
            'price.numeric'=>'قیمت باید عددی باشد',
            'category_id.required'=>'دسته بندی محصول را مشخص کنید',
            'brand_id.required'=>'برند محصول را مشخص کنید',
            'tags.required'=>'تگ های محصول را مشخص کنید',
            'quantity.required'=>'تعداد محصول را وارد کنید',
            'quantity.min:0'=>'حداقل تعداد محصول 0 می باشد',
            'quantity.numeric'=>'تعداد باید عددی باشد',
            'discount.required'=>'درصد تخفیف را وارد کنید',
            'discount.min:0'=>'حد اقل تخفیف 0 می باشد',
            'discount.numeric'=>'تخفیف باید عددی باشد',
            'group_id.required'=>'گروه محصول را وارد کنید'
        ]);

        if ($validator->fails()) {
            return Response()->json(
                ['errors' => $validator->messages()],
                422
            );
        }
        try {

            $item = new Product();
            $item->name = $request->name;
            $item->price = $request->price;
            $item->discount = $request->discount;
            $item->quantity = $request->quantity;
            $item->product_category_id = $request->category_id;
            $item->product_brand_id = $request->brand_id;
            $item->product_group_id = $request->group_id;
            $item->save();
            return Response()->json(['message','عملیات با موفقیت انجام شد'],201);


        }
        catch (\Exception $e)
        {
            return Response()->json(['message'=>'خطا در ایجاد محصول'],500);
        }
    }
}
