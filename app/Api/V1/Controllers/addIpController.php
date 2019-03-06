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
        $user_id = auth()->user();
        if(isset($req)){

            DB::beginTransaction();
            try {
                $insert = new address_Ip();
                $insert->name = $req["name"];
                $insert->ip = $req["ip"];
                $insert->port = $req["port"];
                $insert->protocol = $req["protocol"];
                $insert->script_id = $req["script_id"];
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

//    public function getUser(){
//
//        DB::beginTransaction();
//        try{
//
//
//            $data = address_Ip::where('user_id', $id)->get();
//
//            DB::commit();
//            return response()->json([
//                'status' => 'success',
//                'data' => $data
//            ]);
//        } catch (\Exception $e){
//            DB::rollback();
//            throw $e;
//        }
//
//    }

    public function deleteIp($id){
        DB::beginTransaction();
        try{

            $data = address_Ip::find($id);
            $data->delete();
            DB::commit();
            return response()->json([
                'status' => 'success',
                'data' => $data->id
            ]);
        } catch (\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

}
