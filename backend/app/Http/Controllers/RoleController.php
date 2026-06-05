<?php

namespace App\Http\Controllers;

use App\Models\RoleModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required|string',
        ]);


        if ($validator->fails()){
            return response()->json([
                'success'=>true,
                'message'=>$validator->errors(),
            ]);

        }
        
        $role = RoleModel::create([

        'name'=>$request->name

        ]);

        return response ()->json([
            'success'=>true,
            'message'=>'insert success',
            "role"=>$role
        ]);


    }
    public function index (){
        return response()->json([
            'message'=>'success',
            'roles'=>RoleModel::all(),

        ]);
    }
    public function show ($id){
        $role = RoleModel::find($id);

        if (!$role){
            return response ()->json([
                'success'=>false,
                'message'=>'can not find this role ',


            ]);
        }

        return response()->json([
                'success'=>true,
                'message'=>'find success',
                'role'=>$role,

        ]);

    }

    public function update(Request $request,$id){
        $role = RoleModel::find($id);

        if (!$role){
            return response()->json([
                'success'=>false,
                'message'=>'can not find role ',
            ]);
        }

        $validator = Validator::make($request->all(),[
            'name'=>'required|string',

        ]);

        if ($validator->fails()){
            return response ()->json([
                'success'=>false,
                'message'=>' can not wrong name ',
                

            ]);
        }

       $role->update([
            'name'=>$request->name
        ]);

        return response()->json([
            'success'=>true,
            'message'=>'update successfully ',
            'role'=>$role
        ]);
    }
    public function destroy($id){
        $role = RoleModel::find($id);

        if (!$role){
            return response()->json([
                'success'=>false,
                'message'=>"can not find role",
            ]);
        }
        
        $role->delete();

        return response()->json([
            'success'=>true,
            'message'=>'delete success',
            
        ]);
    }

}
