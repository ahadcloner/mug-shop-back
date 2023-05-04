<?php

namespace App\Http\Controllers;

use App\Models\Permision;
use Illuminate\Http\Request;

class PermisionController extends Controller
{
    public function index(){
        return Response()->json(['data'=>Permision::all()],200);
    }
    public function create(Request $request){

    }
}
