<?php

namespace App\Http\Controllers;


use App\Models\Attribute;
use App\Models\ProductAttributeValue;
use App\Models\ProductBrand;
use App\Models\ProductImage;
use App\Models\ProductTag;
use App\Models\Tag;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use League\OAuth2\Server\RequestRefreshTokenEvent;
use App\Models\AttributeValue;
use PHPUnit\Framework\Error;
use function Sodium\add;


class ProductController extends Controller
{
    public function index()
    {
        $data = Product::with(['tags.tag','images','brand.brand','attributes.attribute_value.attribute','category'])->get();
        return Response() -> json(['data' => $data], 200);
    }

    public function create(Request $request)
    {

        $validator = Validator ::make($request -> all(), [
            'name' => 'required|unique:products',
            'price' => 'required|min:0|numeric',
            'category_id' => 'required',
            'brand_id' => 'required',
            'tags' => 'required|array',
            'quantity' => 'required|min:0|numeric',
            'discount' => 'required|min:0|numeric',
        ], [
            'name.required' => 'نام را وارد کنید',
            'name.unique:products' => 'این نام از قبل ثبت شده است',
            'price.required' => 'قیمت محصول را وارد کنید',
            'price.min:0' => 'قیمت نمی تواند از 0 کمتر باشد',
            'price.numeric' => 'قیمت باید عددی باشد',
            'category_id.required' => 'دسته بندی محصول را مشخص کنید',
            'brand_id.required' => 'برند محصول را مشخص کنید',
            'tags.required' => 'تگ های محصول را مشخص کنید',
            'quantity.required' => 'تعداد محصول را وارد کنید',
            'quantity.min:0' => 'حداقل تعداد محصول 0 می باشد',
            'quantity.numeric' => 'تعداد باید عددی باشد',
            'discount.required' => 'درصد تخفیف را وارد کنید',
            'discount.min:0' => 'حد اقل تخفیف 0 می باشد',
            'discount.numeric' => 'تخفیف باید عددی باشد',
        ]);

        if ($validator -> fails()) {
            return Response() -> json(
                ['errors' => $validator -> messages()],
                422
            );
        }
        try {

            $item = new Product();
            $item -> name = $request -> name;
            $item -> price = $request -> price;
            $item -> discount = $request -> discount;
            $item -> total = $request -> quantity;
            $item -> product_category_id = $request -> category_id;
            $item -> product_type_id = 1;
            $item -> save();


            $product_brand = new ProductBrand();
            $product_brand -> product_id = $item -> id;
            $product_brand -> brand_id = $request -> brand_id;
            $product_brand -> save();

            if ($request -> dynamics) {
                foreach ($request -> dynamics as $key => $value) {
                    $id = Attribute ::where('name', '=', $key) -> first() -> id;
                    $attr_val = new AttributeValue();
                    $attr_val -> attribute_id = $id;
                    $attr_val -> value = $value;
                    $attr_val -> save();

                    $pro_attr_val = new ProductAttributeValue();
                    $pro_attr_val -> product_id = $item -> id;
                    $pro_attr_val -> attribute_value_id = $attr_val -> id;
                    $pro_attr_val -> save();

                }
            }
            if ($request -> tags) {

                foreach ($request -> tags as $key => $value) {
                    $product_tag = new ProductTag();
                    $product_tag->product_id = $item->id;
                    $product_tag->tag_id =$value['value'];
                    $product_tag->save();
                }
            }

            return Response() -> json(['message', 'عملیات با موفقیت انجام شد' , 'data'=>$item->id], 201);


        } catch (\Exception $e) {
            return Response() -> json(['message' => $e], 500);
        }
    }
    public function save_product_images(Request $request)
    {
        try {
            $count = count($request->banners);
            for($i=0;$i<$count;$i++)
            {
                $address = saveOnDisk($request , 'banner'+str($count));
                $product_image = new ProductImage();
                $product_image->product_id = $request->product_id;
                $product_image->image =$address;
                $product_image->save();
            }
            return Response()->json(['message'=>'عملیات با موفقیت انجام شد'],201);
        }
        catch (\Exception $e)
        {
            return Response()->json(['message'=>'خطا در ذخیره سازی تصویر محصول'],500);
        }

    }



}
