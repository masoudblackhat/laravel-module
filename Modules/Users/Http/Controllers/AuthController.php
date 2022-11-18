<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Modules\Users\Entities\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'c_password' => 'required|same:password',
        ]);
        if ($validate->failed()) {
            return response()->json($validate->messages(), 422);
        }

        $user = User::query()->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $token = $user->createToken('myApp')->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string'
        ]);
        if ($validate->failed()) {
            return response()->json($validate->messages(), 422);
        }

        $user = User::query()->where('email', $request->email)->first();
        if (!$user) {
            return response()->json('user not found', 401);
        }

        if (!Hash::check($request->get('password'), $user->password)) {
            return response()->json('password is incorrect', 401);
        }

        $token = $user->createToken('myApp')->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token
        ], 200);
    }
}
