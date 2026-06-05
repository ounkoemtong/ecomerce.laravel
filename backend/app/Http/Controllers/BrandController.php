<?php

namespace App\Http\Controllers;

use App\Models\BrandModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function index (){
        return response()->json([
            'succcess'=>true,
            'message'=>'get all data ',
            'Brand '=> BrandModel::all(),
        ]);

    }

    public function store(Request $request ){
        $validator = Validator::make($request->all(),[
            'name'=>'required|string',
            'slug'=>'nullable|string',
            'logo'=>'nullable|string',
        ]);

        if ($validator->fails()){
           return  response()->json([
                'message'=>'error with validate !',
                'error'=>$validator->errors(),
            ]);
        }

        $brand = BrandModel::create([
            'name'=>$request->name,
            'slug'=>$request->slug,
            'logo'=>$request->logo,
            'status'=>'active',

        ]);

        return response()->json([
            'success'=>true,
            'message'=>'brand create successfully',
            'brand'=>$brand
        ]);
    }

    public function update(Request $request,$id){
        $find = BrandModel::find($id);

        if (!$find){
            return response()->json([
                'message'=>'brand not found !',
            ]);
        }

       $validator = Validator::make($request->all(),[
            'name'=>'required|string',
            'slug'=>'nullable|string',
            'logo'=>'nullable|string',
        ]);

        if ($validator->fails()){
           return  response()->json([
                'message'=>'error with validate !',
                'error'=>$validator->errors(),
            ]);
        }

        $find->update([
            'name'=>$request->name,
            'slug'=>$request->slug,
            'logo'=>$request->logo,
            'status'=>'active',

        ]);
    }

    public function destroy ($id){
        $find = BrandModel::find($id);

        if (!$find){
            return response()->json([
                'message'=>'brand not found !',

            ]);
        }

        $find->delete();
        return response()->json([
            'success'=>true,
            'message'=>"delete success !",
            'delete'=>$find
        ]);


    }
}
