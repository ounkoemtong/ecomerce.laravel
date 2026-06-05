<?php

namespace App\Http\Controllers;

use App\Models\AddressesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => 'required',
                'full_name' => 'required|string',
                'phone' => 'required|min:8',
                'province' => 'required|string',
                'city' => 'required|string',
                'district' => 'required|string',
                'address_line' => 'required|string',

            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'validate erorr',
                'error' => $validator->errors(),
            ], 401);
        }

        $address = AddressesModel::create([
            'user_id' => $request->user_id,
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'province' => $request->province,
            'city' => $request->city,
            'district' => $request->district,
            'address_line' => $request->address_line,
            'is_default' => false,

        ]);


        return response()->json([
            'success' => true,
            'message' => 'address created',
            'address' => $address,
        ], 200);
    }


    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'addresss found !',
            'address' => AddressesModel::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $findID = AddressesModel::find($id);

        if (!$findID) {
            return response()->json([
                'success' => false,
                'message' => 'address not found !',
            ]);
        }
        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => 'required',
                'full_name' => 'required|string',
                'phone' => 'required|min:8',
                'province' => 'required|string',
                'city' => 'required|string',
                'district' => 'required|string',
                'address_line' => 'required|string',

            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'validate erorr',
                'error' => $validator->errors(),
            ], 401);
        }

        $findID->update([
            'user_id' => $request->user_id,
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'province' => $request->province,
            'city' => $request->city,
            'district' => $request->district,
            'address_line' => $request->address_line,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'address updated successfully',
            'address' => $findID,
        ]);
    }

    public function destroy($id)
    {
        $find = AddressesModel::find($id);

        if (!$find) {
            return response()->json([
                'success' => false,
                'message' => 'address not found !',
            ]);
        }

        $find->delete();

        return response()->json([
            'success' => true,
            'message' => 'delete success',

        ]);
    }
}
