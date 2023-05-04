<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    public function index(){
        return Response()->json(['data'=>Role::all()],200);
    }
    public function create(Request $request){

    }
}
