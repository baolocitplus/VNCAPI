<?php

namespace App\Api\V1\Controllers;

use App\address_ip;
use Config;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use DB;

class addIpController extends Controller
{
    public function addIp()
    {
        $req = Input::all();

        if(isset($req)){

            DB::beginTransaction();
            try {
                $insert = new address_ip;
                $insert->name = $req["name"];
                $insert->ip = $req["ip"];
                $insert->port = $req["port"];
                $insert->protocol = $req["protocol"];
                $insert->save();
                DB::commit();
                return response()->json([
                    'status' => 'success',
                    'data' => $insert
                ]);

            } catch (\Exception $e){
                DB::rollback();
                throw $e;
            }

        }
    }
}
