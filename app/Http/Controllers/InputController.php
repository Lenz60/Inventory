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

    public function create(){

    }
}
