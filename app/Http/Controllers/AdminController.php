<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    public function manageIndex(){

        // $user = Auth::user();
        // dd($user);

        // $admins = new Admin;
        $admins = DB::table('admin')
        ->select('uuid', 'username', 'name')
        ->where('role','2')
        ->get();

        // dd($admins);
        return Inertia::render('Manage/Manage', ['admins' => $admins]);
    }

    public function manageCreate(Request $request){

        // dd($request->all());
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'username' =>['required', 'string'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);
        return redirect()->back()->with('message', 'admin:200');
    }

}
