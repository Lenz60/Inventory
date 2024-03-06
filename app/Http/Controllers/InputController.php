<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\InputUpdateRequest;
use Symfony\Component\HttpFoundation\RedirectResponse;

class InputController extends Controller
{
    //
    public function index(Request $request){
        // $user = Auth::user();

        // dd($user);
        $furniture = DB::table('furniture')
        ->get();
        // dd($furniture);



    return Inertia::render('Input/Input', [
        'furnitures' => $furniture,
    ]);

    }

    public function create(Request $request){

        $this->validateInput($request,'input');
        return redirect()->back()->with('message', 'input:200');
    }

    public function update(Request $request){

        $this->validateInput($request,'update');
        return redirect()->back()->with('message', 'update:200');
        // return Redirect::route('input.index', ['message' => 'update:200']);
    }

    public function validateInput($input, $context){
        $validationInteger = "required|numeric|min:0|not_in:0";
        $validationString = "required|string";

        if ($context == 'input'){
            return $input -> validate([
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
        }else{
            return $input -> validate([
                    'sImage' => "required|file",
                    'sDescription' => $validationString,
                    'sCategory' => $validationString,
                    'sWoodtype' => $validationString,
                    'sWidth' => $validationInteger,
                    'sHeight' => $validationInteger,
                    'sDepth' => $validationInteger,
                    'sStock' => $validationInteger,
                    'sPrice' => $validationInteger,
            ]);
        }
    }
}
