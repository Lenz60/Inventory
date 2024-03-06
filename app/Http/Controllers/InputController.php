<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Furniture;
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



        $check = $this->validateInput($request,'input');
        // dd($request->all());
        // dd($request->image->getClientOriginalName());
        // dd(fake()->uuid());
        if($check){
            Furniture::create ([
                'uuid' => fake()->uuid(),
                'image' => $request->image->getClientOriginalName(),
                'code' => $request->code,
                'description' => $request->description,
                'category' => $request->category,
                'wood_type' => $request->woodtype,
                'width' => $request->width,
                'depth' => $request->depth,
                'height' => $request->height,
                'stock' => $request->stock,
                'price' => $request->price,
            ]);
        }
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
    public function delete(Request $request){
        $deletedFurniture = Furniture::find($request->uuid);
        $deletedFurniture->delete();

        //create failsafe here if uuid is not valid or not exists
        //if uuid is not exists then send message that the uuid is invalid
        return redirect()->back()->with('message', 'delete:200');
    }
}
