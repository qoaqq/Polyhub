<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Storage;

class AuthClientController extends Controller
{
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'repassword' => 'required|same:password',
            'phonenumber' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
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
        }else if($user->activated != true){
            Auth::logout();
            return response()->json(['errors' => ['auth' => 'Account has not been activated']], 403);
        }
        

        return response()->json(['message' => 'User signed in successfully', 'token' => $token]);
    }


    public function signout()
    {
        Auth::logout();
        return response()->json(['message' => 'User logged out successfully']);
    }

    public function getUser(Request $request)
    {
        return response()->json(Auth::user());
    }

    public function updateUser(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phonenumber' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|in:male,female,other',
            'address' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();
        $user->fill($request->only(['name', 'email', 'address', 'phonenumber', 'date_of_birth', 'gender']));

        // Xử lý avatar
        if ($request->hasFile('avatar')) {
            // Xóa ảnh cũ nếu có
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
        
            $fileName = time() . '_' . $request->file('avatar')->getClientOriginalName();
            $path = $request->file('avatar')->storeAs('/public/user', $fileName);
            $user->avatar = $path; // Lưu đường dẫn avatar vào DB
        }

        $user->save();
        return response()->json(['message' => 'Successfully updated', 'user' => $user]);
    }
}
