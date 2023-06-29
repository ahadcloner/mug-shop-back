<?php

use Illuminate\Http\Request;
use Illuminate\Support\Str;

function saveOnDisk(Request $request, $file_name)
{
    $name = (string)Str::uuid();
    $path = $request->file($file_name)
        ->move(public_path('myimages'),
            $name . $request->file($file_name)->getClientOriginalName());
    $path = 'myimages/' . $name . $request->file($file_name)->getClientOriginalName();
    return $path;
}

