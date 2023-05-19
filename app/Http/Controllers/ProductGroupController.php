<?php

    namespace App\Http\Controllers;

    use http\Env\Response;
    use Illuminate\Http\Request;
    use App\Models\ProductGroup;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Validator;
    use phpseclib3\File\ASN1\Maps\GeneralName;
    use phpseclib3\System\SSH\Agent\Identity;

    class ProductGroupController extends Controller
    {
        public function index()
        {
            $pg = DB ::table('product_groups')
                -> orderBy('order', 'asc')
                -> get();
            return Response() -> json(['data' => $pg], 200);
        }

        public function create(Request $request)
        {

            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ], [
                'name.required' => 'نام گروه را وارد کنید',
            ]);

            if ($validator->fails()) {
                return Response()->json(
                    ['errors' => $validator->messages()],
                    422
                );
            }

            $pg = new ProductGroup();
            $pg->name = $request->name;
            if ($request->orderd) {
                $pg->order = $request->order;
            } else {
                $pg->order = 0;
            }
            $pg->save();
            return Response()->json(['message' => 'گروه محصول جدید با موفقیت ایجاد شد'], 201);
        }

        public function inc($id)
        {
            $pg = ProductGroup::find($id);
            $pg->order = $pg->order + 1;
            $pg->save();
            return Response()->json(['message' => 'عملیات با موفقیت انجام شد'], 200);
        }

        public function desc($id)
        {
            $pg = ProductGroup::find($id);
            if($pg->order >0)
            {
                $pg->order = $pg->order - 1;
                $pg->save();
            }
            return Response()->json(['message' => 'عملیات با موفقیت انجام شد'], 200);
        }

        public function update($id, Request $request)
        {

            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ], [
                'name.required' => 'نام گروه را وارد کنید',
            ]);

            if ($validator->fails()) {
                return Response()->json(
                    ['errors' => $validator->messages()],
                    422
                );
            }
            $pg = ProductGroup::find($id);
            $pg->name = $request->name;
            $pg->save();
            return Response()->json(['message','عملیات با موفقیت انجام شد'],200);
        }

        public function delete($id): \Illuminate\Http\JsonResponse
        {
            $pg = ProductGroup::find($id);
            if($pg)
            {
                $pg->delete();
                return Response()->json(['message','عملیات با موفقیت انجام شد'],200);
            }
            return Response()->json(['message','گروه محصول مورد نظر یافت نشد'],404);
        }

        public function find($id)
        {
            $item = ProductGroup::find($id);
            if($item)
            {
                return Response()->json(['data'=>$item],200);
            }
            return Response()->json(['message'=>'گروه محصول مورد نظر یافت نشد'],404);
        }
    }
