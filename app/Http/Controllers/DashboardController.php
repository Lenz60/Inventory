<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    //
    public function index(){
        $orderCounts = DB::table('orders')
        ->where('invoice_status', "Generated")
        ->orWhere('invoice_status', "Pending")
        ->count();
        return Inertia::render('Dashboard', ['orderCounts' => $orderCounts]);
    }
}
