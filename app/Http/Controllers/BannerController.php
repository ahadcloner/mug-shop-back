<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Error;
use function Symfony\Component\VarDumper\Dumper\esc;

class BannerController extends Controller
{
    public function create(Request $request)
    {
        try {
            if ($request -> hasFile('banner')) {
                $address = saveOnDisk($request, 'banner');
                $banner = new Banner();
                $banner -> address = $address;
                if ($request -> order) {
                    $banner -> order = $request -> order;
                } else {
                    $banner -> order = 0;
                }
                $banner -> save();
                return Response() -> json(['message' => 'بنر با موفقیت ذخیره شد'], 201);
            }
            else
            {
                return Response() -> json(['message' => 'else part'], 201);
            }
        } catch (\Exception $reror) {
            return Response() -> json(['message' => 'خطا در ذخیره بنر'], 500);
        }
    }

    public function index()
    {
        $banners = DB ::table('banners')
            -> orderBy('order', 'asc')
            -> get();
        return Response() -> json(['data' => $banners], 200);
    }


    public
    function desc_order($id)
    {
        $banner = Banner ::find($id);
        if ($banner) {
            if ($banner -> order > 0) {
                $banner -> order = $banner -> order - 1;
                $banner -> save();
                return Response() -> json(['message' => 'عملیات با موفقیت انجام شد'], 200);
            }
        }
        else
        {
            return Response() -> json(['message' => 'بنر مورد نظر پیدا نشد'], 404);
        }

    }

    public function inc_order($id)
    {
        $banner = Banner ::find($id);
        if ($banner) {

                $banner -> order = $banner -> order + 1;
                $banner -> save();
                return Response() -> json(['message' => 'عملیات با موفقیت انجام شد'], 200);

        } else {
            return Response() -> json(['message' => 'بنر مورد نظر پیدا نشد'], 404);
        }
    }

    public function delete($id)
    {
        $banner = Banner ::find($id);
        if ($banner) {

            $banner -> delete();
            return Response() -> json(['message' => 'عملیات با موفقیت انجام شد'], 200);

        } else {
            return Response() -> json(['message' => 'بنر مورد نظر پیدا نشد'], 404);
        }
    }


}
