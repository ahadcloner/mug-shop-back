<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Error;

class BannerController extends Controller
{
    public function create(Request $request)
    {
        try {
            if ($request->hasFile('banner')){
                $address = saveOnDisk($request ,'banner');
                $banner = new Banner();
                $banner->address = $address;
                if($request->order)
                {
                    $banner->order = $request->order;
                }
                else{
                    $banner->order = 0;
                }
                $banner->save();
                return Response()->json(['message'=>'بنر با موفقیت ذخیره شد'],201);
            }
        }
        catch (\Exception $reror)
        {
            return Response()->json(['message'=>'خطا در ذخیره بنر'],500);
        }
    }

    public function index(){
        $banners = DB::table('banners')
            ->orderBy('order', 'asc')
            ->get();
        return Response()->json(['data'=>$banners],200);
    }
}
