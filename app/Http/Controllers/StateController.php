<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\State;
use http\Env\Response;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index(){
        return Response()->json(['data'=>State::all()],200);
    }
    public function cities($id){
        $state = State::find($id);
        if($state)
        {
            return Response()->json(['data'=>$state->cities],200);
        }
        return Response()->json(['message'=>'شهر مورد نظر شما پیدا نشد'],404);
    }

}
