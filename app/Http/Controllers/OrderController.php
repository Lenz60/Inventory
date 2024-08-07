<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //
    public function index(){

        $orders = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('orders_payment', 'orders_payment.order_id', '=', 'orders.id')
            ->join('furniture', 'order_items.furniture_id', '=', 'furniture.uuid')
            ->join('users', 'order_items.user_id', '=', 'users.uuid')
            ->select('orders.id','users.name','orders.track_code','orders_payment.payment_status')
            ->orderBy('orders.created_at', 'desc')
            ->groupBy('orders.id', 'users.name')
            ->get();

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
        // dd($request->update);
            $update = $request->update;
            if($update  == 'payment'){
                $update = DB::table('orders_payment');
                $update ->where('order_id', $request->id)
                ->update([
                    'payment_status' => $request->status
                ]);
                return redirect()->back()->with('message', 'updatePayment:200');
            }elseif($update == 'production'){
                $update = DB::table('order_items_production');
                $update ->where('order_items_id', $request->id)
                ->update([
                    'production_status' => $request->status
                ]);
                return redirect()->back()->with('message', 'updateOrder:200');
            }else{
                dd("invalid");
            }
            //Update the status based on request given by the $request->status
            // if()
            // return true;
    }


}
