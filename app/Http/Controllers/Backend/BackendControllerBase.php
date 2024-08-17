<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BackendControllerBase extends Controller
{
    //
    public function index() {
        return view('Backend.index');
    }

    public function getProductsData()
    {
        $data = DB::table('orders')
        ->select(DB::raw('DATE(order_date) as date'), DB::raw('COUNT(product_id) as sold_products'))
        ->where('order_date', '>=', now()->subDays(7))
            ->groupBy(DB::raw('DATE(order_date)'))
            ->orderBy('date')
            ->get();

        return response()->json($data);
    }
}
