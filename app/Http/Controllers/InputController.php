<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class InputController extends Controller
{
    //
    public function index(Request $request){

    return Inertia::render('Input/Input');

    }

    public function create(Request $request){
        $validationInteger = "required|integer";
        $validationString = "required|string";
        $request -> validate([
            'image' => "required|file",
            'description' => $validationString,
            'category' => $validationString,
            'woodtype' => $validationString,
            'width' => $validationInteger,
            'height' => $validationInteger,
            'depth' => $validationInteger,
            'stock' => $validationInteger,
            'price' => $validationInteger,
        ]);
        dd($request);
    }
}
