<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthClientController extends Controller
{
    public function signup(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);
        try {
            // Create new user
            $user = new User();
            $user->fill($request->except(['_token', 'password', 're-password', 'avatar']));
            $user->user_type = 'client';
            $user->password = Hash::make($request->password);
            $user->save();
            // Optionally, you can generate a token here if you're implementing JWT or Passport

            // Return response
            return response()->json(['message' => 'User registered successfully'], 201);
        } catch (\Exception $e) {
            // Xử lý ngoại lệ khi email đã tồn tại
            throw ValidationException::withMessages(['email' => 'Email already exists']);
        }
    }

    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     if (Auth::attempt($request->only('email', 'password'))) {
    //         $user = Auth::user();
    //         $token = $user->createToken('auth_token')->plainTextToken;

    //         return response()->json([
    //             'access_token' => $token,
    //             'token_type' => 'Bearer',
    //         ]);
    //     }

    //     return response()->json(['message' => 'Unauthorized'], 401);
    // }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}
