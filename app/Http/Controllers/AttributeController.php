<?php

    namespace App\Http\Controllers;

    use http\Env\Response;
    use Illuminate\Http\Request;
    use App\Models\Attribute;
    use Illuminate\Support\Facades\Validator;

    class AttributeController extends Controller
    {
        public function index()
        {
            return Response() -> json(['data' => Attribute::all()], 200);
        }

        public function create(Request $request)
        {

            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:attributes',
            ], [
                'name.required' => 'نام ویژگی را وارد کنید',
                'name.unique' => 'نام ویژگی تکراری است',
            ]);

            if ($validator->fails()) {
                return Response()->json(
                    ['errors' => $validator->messages()],
                    422
                );
            }

            $pg = new Attribute();
            $pg->name = $request->name;
            $pg->save();
            return Response()->json(['message' => 'ویژگی جدید با موفقیت ایجاد شد'], 201);
        }

        public function update($id, Request $request)
        {

            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:attributes',
            ], [
                'name.required' => 'نام ویژگی را وارد کنید',
                'name.unique' => 'نام ویژگی تکراری است',
            ]);

            if ($validator->fails()) {
                return Response()->json(
                    ['errors' => $validator->messages()],
                    422
                );
            }

            $pg = Attribute::find($id);
            $pg->name = $request->name;
            $pg->save();
            return Response()->json(['message','عملیات با موفقیت انجام شد'],200);
        }

        public function delete($id): \Illuminate\Http\JsonResponse
        {
            $pg = Attribute::find($id);
            if($pg)
            {
                $pg->delete();
                return Response()->json(['message','عملیات با موفقیت انجام شد'],200);
            }
            return Response()->json(['message','ویژگی مورد نظر یافت نشد'],404);
        }
        public function find($id): \Illuminate\Http\JsonResponse
        {
            $item = Attribute::find($id);
            if ($item) {
                return Response()->json(['data' => $item], 200);
            }
            return Response()->json(['message' => 'ویژگی مورد نظر یافت نشد'], 404);
        }
    }
