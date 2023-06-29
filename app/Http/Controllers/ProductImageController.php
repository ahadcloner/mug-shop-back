<?php
    namespace App\Http\Controllers;
    use App\Models\ProductImage;
    use Illuminate\Http\Request;
    use Illuminate\Support\Str;

    class ProductImageController extends Controller
    {
        public function create(Request $request)
        {
            try {
                if ($request->has('images')) {
                    foreach ($request->images as $image) {
                        $name = (string)Str::uuid();

                        $path = $image
                            ->move(public_path('myimages'),
                                $name . $image->getClientOriginalName());
                        $path = 'myimages/' . $name . $image->getClientOriginalName();
                        $banner = new ProductImage();
                        $banner->image = $path;
                        $banner->product_id = $request->product_id;
                        $banner->save();

                    }
                    return Response()->json(['message' => 'تصویر محصول با موفقیت ذخیره شد'], 201);
                } else {
                    return Response()->json(['message' => 'else part'], 201);
                }
            } catch (\Exception $reror) {
                return Response()->json(['message' => 'خطا در ذخیره تصویر محصول'], 500);
            }

        }
    }
