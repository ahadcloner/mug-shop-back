<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Access\Response;

class UserController extends Controller
{
    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        return Response()->json(['message'=>'ok you are registered successfully in site'],200);
    }
}
