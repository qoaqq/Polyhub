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
                    'vnp_TmnCode' => 'CONGTY001', // Mã website tại VNPAY
                    'vnp_Amount' => 1000000 * 100, // số tiền từ request
                    'vnp_CurrCode' => 'VND',
                    'vnp_ReturnUrl' => 'http://localhost:4200/home', // URL trả về sau khi thanh toán
                    'vnp_CreateDate' => now()->format('YmdHis'),
                    'vnp_Bill_Mobile' => '0987654321', // Số điện thoại giả lập
                    'vnp_Bill_Email' => 'nguyenvana@example.com', // Email giả lập
                    'vnp_Bill_FirstName' => 'NGUYEN', // Tên giả lập
                    'vnp_Bill_LastName' => 'VAN A', // Họ giả lập
                    'vnp_Bill_Address' => '123 Street', // Địa chỉ giả lập
                    'vnp_Bill_City' => 'Hanoi', // Thành phố giả lập
                    'vnp_Bill_Country' => 'VN', // Quốc gia giả lập
                    'vnp_Bill_State' => 'Hanoi', // Tỉnh thành giả lập
                    'vnp_Inv_Phone' => '0987654321', // Số điện thoại hóa đơn giả lập
                    'vnp_Inv_Email' => 'nguyenvana@example.com', // Email hóa đơn giả lập
                    'vnp_Inv_Customer' => 'Nguyen Van A', // Khách hàng hóa đơn giả lập
                    'vnp_Inv_Address' => '123 Street', // Địa chỉ hóa đơn giả lập
                    'vnp_Inv_Company' => 'ABC Company', // Công ty hóa đơn giả lập
                    'vnp_Inv_Taxcode' => '1234567890', // Mã số thuế hóa đơn giả lập
                    'vnp_Inv_Type' => 'I' // Loại hóa đơn giả lập
                ];

                ksort($vnpayData);
                $query = http_build_query($vnpayData);
                $hashData = $query . '&' . 'vnp_SecureHashKey=' . $vnpaySecretKey;
                $vnpayData['vnp_SecureHash'] = strtoupper(hash_hmac('sha512', $hashData, $vnpaySecretKey));

                $vnpayUrl .= '?' . http_build_query($vnpayData);

                return response()->json(['redirect_url' => $vnpayUrl]);
            case 'momo':
                // Giả lập thanh toán MoMo
                $momoData = [
                    'partnerCode' => 'YOUR_PARTNER_CODE',
                    'accessKey' => 'YOUR_ACCESS_KEY',
                    'requestId' => time(),
                    'amount' => 1000000, // Số tiền từ request
                    'orderId' => time(),
                    'orderInfo' => 'Payment for order',
                    'returnUrl' => 'http://localhost:4200/home',
                    'notifyUrl' => 'http://localhost:8000/api/momo/notify',
                    'signature' => 'dummy_signature', // Signature giả lập
                ];

                // Giả lập URL thanh toán MoMo
                $momoPayUrl = 'http://localhost:4200/momo-payment';

                // Trả về URL giả lập
                return response()->json(['redirect_url' => $momoPayUrl]);
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
