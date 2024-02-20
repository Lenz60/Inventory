<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InputController extends Controller
{
    //
    public function index(Request $request){
        $user = Auth::user();

        // dd($user);
        $furniture = DB::table('furniture')
        ->get();
        // dd($furniture);



    return Inertia::render('Input/Input', [
        'furnitures' => $furniture,
    ]);

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
