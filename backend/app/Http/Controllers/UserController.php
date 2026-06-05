<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => "required|string",
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4',
            'phone' => 'required|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'validate error',
                'error' => $validator->errors(),
            ]);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role_id' => 1,
            'status' => 'active',
        ]);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'can not create user',

            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'create user success',
            'user' => $user,
        ]);
    }
    public function index()
    {
        return response()->json([
            'messsage' => 'user found ',
            'User' => User::all(),
        ]);
    }
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'user not found ',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'user found',
            'user' => $user
        ]);
    }
    public function update(Request $request, $id)
    {
        $findById = User::find($id);

        if (!$findById) {
            return response()->json([
                'sucess' => false,
                'message' => 'user not found ',


            ]);
        }
        $validator = Validator::make($request->all(), [
            'name' => "required|string",
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'required|min:4',
            'phone' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'error with validate',
                'erorr' => $validator->errors(),
            ]);
        }

        $findById->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,

        ]);



        return response()->json([
            'success' => true,
            'message' => 'update user success',
            'user' => $findById->fresh(),
        ]);
    }

    public function destroy($id)
    {
        $FindId = User::find($id);


        if (!$FindId) {
            return response()->json([
                'success' => false,
                'message' => 'user not found ',

            ]);
        }
        $FindId->delete();

        return response()->json([
            'succcess' => true,
            'message' => 'delete success',
            'user' => $FindId,
        ]);
    }
}
