<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Lấy toàn bộ user có user_type là 'client'
        $users = User::where('user_type', 'client')->get();

        // Trả về danh sách user dưới dạng JSON
        return response()->json($users);
    }
}
