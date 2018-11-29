<?php

namespace App\Api\V1\Controllers;

use App\address_Ip;
use App\User;
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
                $insert = new address_Ip();
                $insert->name = $req["name"];
                $insert->ip = $req["ip"];
                $insert->port = $req["port"];
                $insert->user_id = $req["user_id"];
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

    public function getAllIp()
    {
        DB::beginTransaction();
        try{
            $data = address_Ip::all();

            DB::commit();
            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        } catch (\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function getUser($id){

        DB::beginTransaction();
        try{

            $data = address_Ip::where('user_id', $id)->get();

            DB::commit();
            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        } catch (\Exception $e){
            DB::rollback();
            throw $e;
        }

    }
}
