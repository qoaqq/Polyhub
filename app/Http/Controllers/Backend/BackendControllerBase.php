<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BackendControllerBase extends Controller
{
    //
    public function index() {
        return view('Backend.index');
    }
}
