<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Order;
use App\Models\Session;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //
    public function index(){

        $orders = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('orders_payment', 'orders_payment.order_id', '=', 'orders.id')
            ->join('furniture', 'order_items.furniture_id', '=', 'furniture.uuid')
            ->join('users', 'orders.user_id', '=', 'users.uuid')
            ->join('orders_info','orders_info.order_id', '=', 'orders.id')
            ->select('orders.id','users.name','orders_info.country','orders_info.region','orders.track_code','orders_payment.payment_status','orders.invoice_status','orders.created_at')
            ->orderBy('orders.created_at', 'desc')
            ->groupBy('orders.id', 'users.name')
            ->get();

        $order_items = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('order_items_production', 'order_items_id', '=', 'order_items.id')
            ->join('furniture', 'order_items.furniture_id', '=', 'furniture.uuid')
            ->join('users', 'orders.user_id', '=', 'users.uuid')
            ->select('order_items.id as id','orders.id as order_id', 'users.uuid as user_id','users.name',
                        'order_items.furniture_id', 'furniture.description','furniture.color', 'furniture.image',
                            'order_items.preorder as preorder', 'order_items.qty', 'order_items.total_price','order_items_production.production_status as status')
            ->orderBy('order_items.created_at','desc')
            // ->groupBy('orders.id', 'order_items.user_id')
            ->get();

        $order_info = DB::table('orders')
            ->join('orders_payment', 'orders_payment.order_id', '=', 'orders.id')
            ->join('orders_info','orders_info.order_id', '=', 'orders.id')
            ->join('users', 'orders.user_id', '=', 'users.uuid')
            ->select('orders_info.id as id','orders.id as order_id','orders_info.name','orders_info.company','orders_info.email','orders_info.phone_number',
                        'orders_info.address','orders_info.country','orders_info.region','orders_info.zip'
                            ,'orders.track_code','orders_payment.payment_status')
            ->orderBy('orders.created_at', 'desc')
            ->groupBy('orders.id', 'users.name')
            ->get();

        // dd($order_items[0]->furniture_id);
        // dd($order_items);
        // dd($order_info);
        // dd($orders);
        $files = glob(public_path('pdf/*')); // get all file names
        foreach ($files as $file) { // iterate files
            if (is_file($file)) {
                unlink($file); // delete file
            }
        }
        return Inertia::render('Order/Order', [
        'orders' => $orders,
        'order_items' => $order_items,
        'order_info' => $order_info
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
                return redirect()->back()->with('message', 'update:500');
            }
            //Update the status based on request given by the $request->status
            // if()
            // return true;
    }

    public function invoice(Request $request){
        // dd($request->all());
        $orderId = $request->id;
        $context = $request->context;
        $invoice = generateInvoice($orderId);
        $path = $invoice->getFile()->getPath();
        $invoiceName = $invoice->getFile()->getFilename();
        $url = asset('pdf/'. $invoiceName);
        $publicUrl = public_path('pdf/'. $invoiceName);
        $invoiceNameWeb = str_replace(' ', '%20', $invoice->getFile()->getFilename());
        $redirectUrl = asset('pdf/'. $invoiceNameWeb);
        $apiUrl = env('API_URL');
        $apiKey = env('API_KEY');

        $user_info = DB::table('orders')
            ->join('orders_info', 'orders.id', '=', 'orders_info.order_id')
            ->where('orders.id', '=', $orderId)
            ->first();
        dd($user_info->phone_number);

        // dd($invoice);
        //! Check here before return

        if($context == 'download'){
            return Inertia::location($redirectUrl);

        }else{
            $client = new \GuzzleHttp\Client();
            //? Check client connection
            try{
                $response = $client->request('GET',$apiUrl . '/sessions/', ['headers' => ['x-api-key' => $apiKey]]);
            }catch(Exception $e){
                return redirect()->back()->with('message', 'noWhatsapp:500');
            }
            $checkWhatsapp = DB::connection('mysql_baileys')->table('session')
            ->where('id', 'creds')->count();

            if($checkWhatsapp <= 0 ){
                return redirect()->back()->with('message', 'noWhatsapp:404');
            }
            $whatsapp = Session::first();
            if($whatsapp){
                $sessionId = $whatsapp->sessionId;
            }else{
                $sessionId = null;
            }
            if($sessionId == null){
                return redirect()->back()->with('message', 'noWhatsapp:404');
            }
            // dd($checkWhatsapp);
            try{
                $response = $client->request('POST', $apiUrl . '/' . $sessionId . '/messages/send', [
                    'headers' => ['x-api-key' => $apiKey],
                    'json' => [
                        'jid' => $user_info->phone_number.'@s.whatsapp.net',
                        'type' => 'number',
                        'message' => [
                            'document' => ['url' => $url],
                            'mimetype' => 'application/pdf',
                            'caption' => "Here is your invoice of your order at Teratai Furniture",
                            'fileName' => $invoiceName
                        ],
                    ],
                ]);
            }catch(GuzzleException $e){
                return redirect()->back()->with('message', 'invoiceSent:500');
            }
            // dd($response.status);
            if($response->getStatusCode() == 200){
                $updateOrder = Order::find($orderId);
                $updateOrder->invoice_status = 'Sent';
                $updateOrder->save();
                return redirect()->back()->with('message', 'invoiceSent:200');
            }
        }
    }
}
