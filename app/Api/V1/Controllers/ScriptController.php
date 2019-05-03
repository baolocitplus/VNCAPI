<?php

namespace App\Api\V1\Controllers;

use App\address_Ip;
use App\Computer;
use App\Content;
use App\Script;
use App\User;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use DB;

class ScriptController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt.auth', [])->except('postConttent','deleteConttent', 'deleteScript', 'getComputer');
    }

    public function getScrip()
    {
        DB::beginTransaction();
        try {
            $user_id = auth()->user();
            $data = Script::where('user_id', $user_id->id)->get();
            foreach ($data as $item) {
                $item->IpAddress;
                $item->contents;
                $script = $data;
            }

            DB::commit();
            return response()->json([
                'status' => 'success',
                'data' => $script
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function createScript(Request $request)
    {

        try {
            $user_id = auth()->user();

            $script = new  Script;
            $script->name = $request->name;
            $script->security = $request->security;
            $script->attack = $request->attack;
            $script->user_id = $user_id->id;
            $script->save();
            return response()->json([
                'error_code' => 0,
                'error_message' => 'success',
                'data' => $script
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
    public function deleteScript($id){
        DB::beginTransaction();
        try{
            $script = Script::find($id);
            $script->delete();
            $ip = address_Ip::where('script_id', $id)->delete();
            DB::commit();
            return response()->json([
                'status' => true,
                'error_message' => 'success',
                'data' => $script
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


    public function addNameComputer(){
        DB::beginTransaction();
        try{
            $req = Input::all();
            $insert = new Computer;
            $insert->name = $req["name"];
            $insert->ip = $req["ip"];
            $insert->description = $req["description"];
            $insert->system = $req["system"];
            $insert->memory = $req["memory"];
            $insert->cpu = $req["cpu"];
            $insert->save();
            DB::commit();
            return response()->json([
                'status' => true,
                'error_message' => 'success',
                'data' => $insert
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function getComputer(){
        DB::beginTransaction();
        try{
            $data = Computer::all();
            DB::commit();
            return response()->json([
                'status' => true,
                'error_message' => 'success',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function deleteComputer($id){
        DB::beginTransaction();
        try{
            $data = Computer::find($id);
            $data->delete();
            DB::commit();
            return response()->json([
                'status' => true,
                'error_message' => 'success',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    // content
    public function postConttent($id){
        DB::beginTransaction();
        try{
            $req = Input::all();
            $insert = new Content();
            $insert->name = $req['name'];
            $insert->content = $req['content'];
            $insert->script_id = $id;
            $insert->save();

            DB::commit();

            return response()->json([
                'status' => true,
                'error_message' => 'success',
                'data' => $insert
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
    public function deleteConttent($id){
        DB::beginTransaction();
        try{
            $content = Content::find($id);
            $content->delete();
            DB::commit();
            return response()->json([
                'status' => true,
                'error_message' => 'success',
                'data' => $content
            ]);
        }catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
