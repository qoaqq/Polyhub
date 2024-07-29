<?php

namespace Modules\PaymentMethod\Http\Controllers\API;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\PaymentMethod\Entities\PaymentMethod;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $payments = PaymentMethod::all();
        return response()->json([
            'status' => true,
            'message' => 'Lấy danh sách thành công',
            'data' => $payments,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('paymentmethod::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
         // Log::info('Payment Method: ' . $request->input('paymentMethod'));
        //  Log::info('Sub Total: ' . $request->input('totalCost'));
         $paymentMethod = $request->paymentMethod;
         
         switch ($paymentMethod) {
             case 'vnpay':
                 $grandTotal = $request->total;
                 $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
                 $vnp_Returnurl = "http://localhost:4200/confirmation";
                 $vnp_TmnCode = "AQX9I3H0";
                 $vnp_HashSecret = "UVWWYVHECNHDWLRSOKBNLPMZENAARDLS";
                 $vnp_TxnRef = uniqid();
                 $vnp_OrderInfo = "Payment success";
                 $vnp_OrderType = "PolyHub";
                 $vnp_Amount = $grandTotal * 100;
                 $vnp_Locale = "VN";
                 $vnp_BankCode = "NCB";
                 $vnp_IpAddr = $request->ip();
 
                 $vnp_CreateDate = date('YmdHis');
 
                 $inputData = array(
                     "vnp_Version" => "2.1.0",
                     "vnp_TmnCode" => $vnp_TmnCode,
                     "vnp_Amount" => $vnp_Amount,
                     "vnp_Command" => "pay",
                     "vnp_CreateDate" => $vnp_CreateDate,
                     "vnp_CurrCode" => "VND",
                     "vnp_IpAddr" => $vnp_IpAddr,
                     "vnp_Locale" => $vnp_Locale,
                     "vnp_OrderInfo" => $vnp_OrderInfo,
                     "vnp_OrderType" => $vnp_OrderType,
                     "vnp_ReturnUrl" => $vnp_Returnurl,
                     "vnp_TxnRef" => $vnp_TxnRef,
                 );
 
                 ksort($inputData);
                 $query = "";
                 $i = 0;
                 $hashdata = "";
                 foreach ($inputData as $key => $value) {
                     if ($i == 1) {
                         $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                     } else {
                         $hashdata .= urlencode($key) . "=" . urlencode($value);
                         $i = 1;
                     }
                     $query .= urlencode($key) . "=" . urlencode($value) . '&';
                 }
 
                 $vnp_Url = $vnp_Url . "?" . $query;
                 if (isset($vnp_HashSecret)) {
                     $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
                     $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
                 }
                 return response()->json(['redirect_url' => $vnp_Url], 200);
             case 'momo':
                 // Giả lập thanh toán MoMo
                 $momoData = [
                     'partnerCode' => 'YOUR_PARTNER_CODE',
                     'accessKey' => 'YOUR_ACCESS_KEY',
                     'requestId' => time(),
                     'amount' => 1000000,
                     'orderId' => time(),
                     'orderInfo' => 'Payment for order',
                     'returnUrl' => 'http://localhost:4200/home',
                     'notifyUrl' => 'http://localhost:8000/api/momo/notify',
                     'signature' => 'dummy_signature',
                 ];
 
                 $momoPayUrl = 'http://localhost:4200/momo-payment';
 
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
        return view('paymentmethod::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('paymentmethod::edit');
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
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
