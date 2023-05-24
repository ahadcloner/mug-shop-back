<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\Option;
    use Illuminate\Support\Facades\Validator;


    class OptionController extends Controller
    {
        public function index()
        {
            return Response()->json(['data' => Option::all()], 200);
        }

        public function create(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'description' => 'required',
                'price' => 'required'
            ], [
                'name.required' => 'نام آپشن را وارد کنید',
                'description.required' => 'توضیحات آپشن را وارد کنید',
                'price.required' => 'هزینه آپشن را وارد کنید',
            ]);
            if ($validator->fails()) {
                return Response()->json(
                    ['errors' => $validator->messages()],
                    422
                );
            }

            $pg = new Option();
            $pg->name = $request->name;
            $pg->description = $request->description;
            $pg->price = $request->price;
            $pg->save();
            return Response()->json(['message' => 'آپشن جدید با موفقیت ایجاد شد'], 201);
        }

        public function update($id, Request $request)
        {

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'description' => 'required',
                'price' => 'required'
            ], [
                'name.required' => 'نام آپشن را وارد کنید',
                'description.required' => 'توضیحات آپشن را وارد کنید',
                'price.required' => 'هزینه آپشن را وارد کنید',
            ]);
            if ($validator->fails()) {
                return Response()->json(
                    ['errors' => $validator->messages()],
                    422
                );
            }

            $pg = Option::find($id);
            $pg->name = $request->name;
            $pg->description = $request->description;
            $pg->price = $request->price;
            $pg->save();
            return Response()->json(['message', 'عملیات با موفقیت انجام شد'], 200);
        }

        public function delete($id): \Illuminate\Http\JsonResponse
        {
            $pg = Option::find($id);
            if ($pg) {
                $pg->delete();
                return Response()->json(['message', 'عملیات با موفقیت انجام شد'], 200);
            }
            return Response()->json(['message', 'آپشن مورد نظر یافت نشد'], 404);
        }

        public function find($id): \Illuminate\Http\JsonResponse
        {
            $item = Option::find($id);
            if ($item) {
                return Response()->json(['data' => $item], 200);
            }
            return Response()->json(['message' => 'آپشن مورد نظر یافت نشد'], 404);
        }
    }
