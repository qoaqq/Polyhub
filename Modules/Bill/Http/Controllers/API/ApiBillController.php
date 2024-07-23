<?php

namespace Modules\Bill\Http\Controllers\API;

use Illuminate\Http\Request;
use Modules\Bill\Entities\Bill;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Support\Renderable;

class ApiBillController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $bills = Bill::all();
        return response()->json([
            'status'=>true,
            'message'=>'Lấy danh sách thành công',
            'data' => $bills,
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('bill::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
        Log::info('Payment Method: ' . $request->input('paymentMethod'));

        $paymentMethod = $request->input('paymentMethod');

        switch ($paymentMethod) {
            case 'vnpay':
                // VNPAY
                $vnpayUrl = 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html';
                $vnpaySecretKey = '4t7v6K7Nq2e4k3t1b4Vf5Aq8R9k6F9F2';

                $vnpayData = [
                    'vnp_TmnCode' => 'CONGTY001',
                    'vnp_Amount' => 1000000 * 100,
                    'vnp_CurrCode' => 'VND',
                    'vnp_OrderInfo' => 'Thanh toán đơn hàng',
                    'vnp_ReturnUrl' => 'http://localhost:4200/home',
                    'vnp_TxnRef' => uniqid(),
                    'vnp_IpAddr' => $request->ip(),
                    'vnp_CreateDate' => date('YmdHis'),
                ];

                ksort($vnpayData);
                $query = http_build_query($vnpayData);
                $hashData = $query . '&' . 'vnp_SecureHashKey=' . $vnpaySecretKey;
                $vnpayData['vnp_SecureHash'] = strtoupper(hash('sha256', $hashData));

                $vnpayUrl .= '?' . http_build_query($vnpayData);

                return response()->json(['redirect_url' => $vnpayUrl]);
            case 'momo':
                // Momo
                return response()->json(['status' => 'success', 'message' => 'Momo payment processed']);
            default:
                return response()->json(['status' => 'error', 'message' => 'Unknown payment method'], 400);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $bill = Bill::find($id);
        if (!$bill) {
            $arr = [
                'status' => false,
                'message' => 'Không tìm thấy bài viết này',
                'data' => []
            ];
            return response()->json($arr, 200);
        }
        $arr = [
            'status' => true,
            'message' => 'Thông tin chi tiết bài viết',
            'data' => $bill
        ];
        return response()->json($arr, 200);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('bill::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
        $bill = Bill::findOrFail($id);
        $bill->update($request->all());
        return response()->json($bill);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
        Bill::destroy($id);
        return response()->json(null, 204);
    }
}
