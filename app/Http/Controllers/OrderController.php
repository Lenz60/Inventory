<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //
    public function index(){

        // $cart = DB::table('cart')
        // ->join('furniture', 'cart.furniture_id', '=', 'furniture.uuid')
        // ->join('users', 'cart.user_id', '=', 'users.uuid')
        // ->select('cart.id', 'cart.user_id', 'cart.furniture_id','cart.preorder','furniture.image','furniture.description', 'cart.qty','cart.total_price' )
        // ->orderBy('cart.created_at', 'desc')
        // ->get();
        // $orders = DB::table('orders')
        // ->join('order_items', 'orders.id', '=', 'order_items.order_id')
        // ->join('furniture', 'order_items.furniture_id', '=', 'furniture.uuid')
        // ->join('users', 'order_items.user_id', '=', 'users.uuid')
        // ->select('orders.id','users.name','orders.track_code',)
        // ->orderBy('orders.created_at', 'desc')
        // ->groupBy('orders.id')
        // ->get();


        $orders = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('furniture', 'order_items.furniture_id', '=', 'furniture.uuid')
            ->join('users', 'order_items.user_id', '=', 'users.uuid')
            ->select('orders.id','users.name','orders.track_code',)
            ->orderBy('orders.created_at', 'desc')
            ->groupBy('orders.id', 'users.name')
            ->get();

        // $order_items = DB::table('orders')
        // ->join('order_items', 'orders.id', '=', 'order_items.order_id')
        // ->join('furniture', 'order_items.furniture_id', '=', 'furniture.uuid')
        // ->join('users', 'order_items.user_id', '=', 'users.uuid')
        // ->select('orders.id', 'order_items.user_id', 'order_items.furniture_id', 'furniture.image', 'furniture.description', 'order_items.preorder','order_items.qty','order_items.total_price')
        // ->groupBy('orders.id','order_items.user_id')
        // ->get();

        $order_items = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('order_items_production', 'order_items_id', '=', 'order_items.id')
            ->join('furniture', 'order_items.furniture_id', '=', 'furniture.uuid')
            ->join('users', 'order_items.user_id', '=', 'users.uuid')
            ->select('order_items.id as id','orders.id as order_id', 'order_items.user_id','users.name', 'order_items.furniture_id', 'furniture.description','furniture.color', 'furniture.image', 'order_items.preorder as preorder', 'order_items.qty', 'order_items.total_price','order_items_production.production_status as status')
            ->orderBy('order_items.created_at','desc')
            // ->groupBy('orders.id', 'order_items.user_id')
            ->get();

        // dd($order_items[0]->furniture_id);
        // dd($order_items);
        return Inertia::render('Order/Order', [
        'orders' => $orders,
        'order_items' => $order_items,
    ]);
    }

    public function update(Request $request){
        // $order_items = DB::table('orders')
        //     ->join('order_items', 'orders.id', '=', 'order_items.order_id')
        //     ->join('order_items_production', 'order_items_id', '=', 'order_items.id')
        //     ->join('furniture', 'order_items.furniture_id', '=', 'furniture.uuid')
        //     ->join('users', 'order_items.user_id', '=', 'users.uuid')
        //     ->select('order_items.id as id','orders.id as order_id', 'order_items.user_id','users.name', 'order_items.furniture_id', 'furniture.description','furniture.color', 'furniture.image', 'order_items.preorder as preorder', 'order_items.qty', 'order_items.total_price',  'order_items_production.production_status as status')
        //     ->orderBy('order_items.created_at','desc')
        //     ->get();
            //Update the status off the order
            // dd($order_items);
            //Update the status based on request given by the $request->status
            $order_items_production = DB::table('order_items_production')
            ->where('order_items_id', $request->id)
            ->update([
                'production_status' => $request->status
            ]);
            return redirect()->back()->with('message', 'update:200');

        // dd($request->all());
        // return inertia()
    }
}
