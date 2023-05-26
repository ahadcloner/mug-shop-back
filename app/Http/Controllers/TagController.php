<?php

    namespace App\Http\Controllers;

    use http\Env\Response;
    use Illuminate\Http\Request;
    use App\Models\Tag;
    use Illuminate\Support\Facades\Validator;

    class TagController extends Controller
    {
        public function index()
        {
            return Response() -> json(['data' => Tag::all()], 200);
        }

        public function create(Request $request)
        {

            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:tags',
            ], [
                'name.required' => 'نام تگ را وارد کنید',
                'name.unique' => 'نام تگ تکراری است',
            ]);

            if ($validator->fails()) {
                return Response()->json(
                    ['errors' => $validator->messages()],
                    422
                );
            }

            $pg = new Tag();
            $pg->name = $request->name;
            $pg->save();
            return Response()->json(['message' => 'تگ جدید با موفقیت ایجاد شد'], 201);
        }

        public function update($id, Request $request)
        {

            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:tags',
            ], [
                'name.required' => 'نام تگ را وارد کنید',
                'name.unique' => 'نام تگ تکراری است',
            ]);

            if ($validator->fails()) {
                return Response()->json(
                    ['errors' => $validator->messages()],
                    422
                );
            }

            $pg = Tag::find($id);
            $pg->name = $request->name;
            $pg->save();
            return Response()->json(['message','عملیات با موفقیت انجام شد'],200);
        }

        public function delete($id): \Illuminate\Http\JsonResponse
        {
            $pg = Tag::find($id);
            if($pg)
            {
                $pg->delete();
                return Response()->json(['message','عملیات با موفقیت انجام شد'],200);
            }
            return Response()->json(['message','تگ مورد نظر یافت نشد'],404);
        }
        public function find($id): \Illuminate\Http\JsonResponse
        {
            $item = Tag::find($id);
            if ($item) {
                return Response()->json(['data' => $item], 200);
            }
            return Response()->json(['message' => 'تگ مورد نظر یافت نشد'], 404);
        }
    }
