<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DeviceController extends Controller
{
    //

    public function index(){
        $conn = DB::connection('mysql_baileys');
        $creds = $conn->table('session')->select('data')->where('id', 'creds')->first();
        if($creds === null){
            $deviceName = null;
            $deviceId = null;
            // dd($deviceName, $deviceId);

            return Inertia::render('Device', [
                'deviceName' => $deviceName,
                'deviceId' => $deviceId,
            ]);

        }else{
            $jsonCreds = json_decode($creds->data, true);
            $deviceName = $jsonCreds['me']['name'];
            $deviceId = $jsonCreds['me']['id'];
            // dd($deviceName, $deviceId);

            return Inertia::render('Device', [
                'deviceName' => $deviceName,
                'deviceId' => $deviceId,
            ]);
        }
    }
}
