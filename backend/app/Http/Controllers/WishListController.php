<?php

namespace App\Http\Controllers;

use App\Models\WishListModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WishListController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'user_id' => 'required|integer|exists:users,id',
            'product_id' => 'required|integer|exists:products,id',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'validator error !',
                'error' => $validator->errors()
            ]);
        }

        $Wishlist = WishListModel::create([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'create wishlist successfully  !',
            'WishList' => $Wishlist,
        ]);
    }

    public function index()
    {
        return response()->json([
            'message' => 'Wishlist found  !',
            'Wishlish' => WishListModel::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $find = WishListModel::find($id);
        $validator = Validator::make($request->all(), [

            'user_id' => 'required|integer|exists:users,id',
            'product_id' => 'required|integer|exists:products,id',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'validator error !',
                'error' => $validator->errors()
            ]);
        }

        $find->update([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'create wishlist successfully  !',
            'WishList' => $find,
        ]);
    }

    public function show($id){
        $find = WishListModel::find($id);

        if (!$find){
            return response()->json([
                'success'=>false,
                'message'=>'wishlist not found !',


            ]);
        }

        return response()->json([
            'success'=>true,
            'message'=>'wishlist found  !',
            'wishlist'=>$find,

        ]);
    }
    public function destroy($id){
        $find = WishListModel::find($id);

        if (!$find){
            return response()->json([
                'success'=>false,
                'message'=>'wishlist not found  !',

            ]);
        }

        $find->delete();
        

        return response()->json([
            'success'=>false,
            'message'=>' delete success',
            'delete '=>$find,

        ]);

    }


}
