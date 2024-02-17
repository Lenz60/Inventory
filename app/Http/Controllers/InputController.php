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
        dd($request);
        $request -> validate([
            'image' => "required|file",
            'description' => "required|string",
            'category' => "required|string",
            'woodtype' => "required|string",
            'width' => "required|string",
            'height' => "required|string",
            'depth' => "required|string",
            'stock' => "required|integer",
            'price' => "required|integer",
        ]);
    }
}
