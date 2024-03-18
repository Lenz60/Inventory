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

        $user = Auth::user();
        // dd($user->role);
        if($user->role == '1'){
            // $admins = new Admin;
            $admins = DB::table('admin')
            ->select('uuid', 'email', 'name')
            ->where('role','2')
            ->get();
            // dd($admins);
            return Inertia::render('Manage/Manage', ['admins' => $admins]);
        }else{
            return redirect('dashboard');
        }
    }

    public function manageCreate(Request $request){

        // dd($request->all());
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'email' =>['required', 'string','email'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);
        if($validated){
            Admin::create([
                'uuid' => fake()->uuid(),
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'role' => '2'
            ]);
        }
        return redirect()->back()->with('message', 'admin:200');
    }

}
