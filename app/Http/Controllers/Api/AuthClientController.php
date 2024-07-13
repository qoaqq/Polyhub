<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthClientController extends Controller
{
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'repassword' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        // Create new user
        $user = new User();
        $user->fill($request->except(['_token', 'password', 'repassword', 'avatar']));
        $user->user_type = 'client';
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    }

    public function signin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['errors' => ['auth' => 'Invalid credentials']], 422);
        }

        $user = Auth::user();

        if ($user->user_type !== 'client') {
            Auth::logout();
            return response()->json(['errors' => ['auth' => 'Unauthorized user type']], 403);
        }

        return response()->json(['message' => 'User signed in successfully', 'token' => $token]);
    }


    public function signout()
    {
        Auth::logout();
        return response()->json(['message' => 'User logged out successfully']);
    }

    public function user()
    {
        return response()->json(Auth::user());
    }
}
