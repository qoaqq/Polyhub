<?php

namespace Modules\Bill\Http\Controllers\API;

use Milon\Barcode\DNS1D;
use Illuminate\Http\Request;
use App\Mail\BookingConfirmed;
use Modules\Bill\Entities\Bill;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Modules\Checkin\Entities\Checkin;
use Modules\TicketSeat\Entities\TicketSeat;
use Illuminate\Contracts\Support\Renderable;
use Modules\TicketFoodCombo\Entities\TicketFoodCombo;
use Modules\SeatShowtimeStatus\Entities\SeatShowtimeStatus;

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
        // dd($request->user['user']['email']);
        $paymentMethod = $request->bill['paymentMethod'];
        
        switch ($paymentMethod) {
            case 'vnpay':
                $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
                $vnp_Returnurl = "http://localhost:4200/confirmation";
                $vnp_TmnCode = "AQX9I3H0";
                $vnp_HashSecret = "UVWWYVHECNHDWLRSOKBNLPMZENAARDLS";

                $vnp_TxnRef = uniqid();
                $vnp_OrderInfo = "Payment success";
                $vnp_OrderType = "PolyHub";
                $vnp_Amount = $request->bill['grandTotal'] * 100;
                $vnp_Locale = "US";
                $vnp_BankCode = "NCB";
                $vnp_IpAddr = $request->ip();

                $vnp_CreateDate = date('YmdHis');

                $inputData = array(
                    "vnp_Version" => "2.1.0",
                    "vnp_TmnCode" => $vnp_TmnCode,
                    "vnp_Amount" => $vnp_Amount,
                    "vnp_Command" => "pay",
                    "vnp_CreateDate" => $vnp_CreateDate,
                    "vnp_CurrCode" => "USD",
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

                $barcode = (new DNS1D())->getBarcodePNG($vnp_TxnRef, 'C39');

                $checkin = Checkin::create([
                    'name' => 'Check-in for bill ' . $vnp_TxnRef,
                    'checkin_code' => $barcode,
                    'type' => 'bill',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $bill = Bill::create([
                    'user_id' => $request->bill['user_id'],
                    'grand_total' => $request->bill['grandTotal'],
                    'checkin_id' => $checkin->id
                ]);
                
                foreach ($request->ticket_seat['selectedSeats'] as $seat) {
                    $seatDetails = $seat['seat'];
                    $showingRelease = $request->ticket_seat['showingrelease'];
                    $seatType = $seatDetails['seat_type'];

                    TicketSeat::create([
                        'seat_showtime_status_id' => $seat['id'], 
                        'bill_id' => $bill->id, 
                        'movie_id' => $showingRelease['movie_id'],
                        'room_id' => $showingRelease['room_id'], 
                        'cinema_id' => $showingRelease['room']['cinema']['id'],
                        'showing_release_id' => $showingRelease['id'], 
                        'time_start' => $showingRelease['time_release'], 
                        'price' => $seatType['price'] 
                    ]);
                }

                foreach ($request->ticket_seat['selectedFoodCombos'] as $selectedFoodCombos) {
                    TicketFoodCombo::create([
                        'food_combo_id' => $selectedFoodCombos['id'],
                        'bill_id' => $bill->id,
                        'price' => $selectedFoodCombos['price'],
                        'quantity' => $selectedFoodCombos['quantity']
                    ]);
                };

                Mail::to($request->user['user']['email'])->send(new BookingConfirmed($bill, $checkin, $barcode));
                
                return response()->json([
                    'redirect_url' => $vnp_Url,
                    'data' => [
                        'bill' => $bill,
                        'checkin' => $checkin,
                        'barcode' => $barcode
                    ]
                ], 200);
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
