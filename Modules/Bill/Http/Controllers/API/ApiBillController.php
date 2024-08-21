<?php

namespace Modules\Bill\Http\Controllers\API;

use App\Models\User;
use Barryvdh\DomPDF\PDF;
use Milon\Barcode\DNS1D;
use Illuminate\Http\Request;
use App\Mail\BookingConfirmed;
use Modules\Bill\Entities\Bill;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Modules\Checkin\Entities\Checkin;
use Modules\TicketSeat\Entities\TicketSeat;
use Illuminate\Contracts\Support\Renderable;
use Modules\RankMember\Entities\RankMember;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
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
            'status' => true,
            'message' => 'Lấy danh sách thành công',
            'data' => $bills,
        ], 200);
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

                $barcodeUrl = 'https://barcode.tec-it.com/barcode.ashx?data=' . $vnp_TxnRef . '&code=Code128&dpi=96';
                $barcodeImage = file_get_contents($barcodeUrl);
                $barcodeBase64 = base64_encode($barcodeImage);

                $checkin = Checkin::create([
                    'name' => 'Check-in for bill ' . $vnp_TxnRef,
                    'checkin_code' => $barcodeBase64,
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

                if (isset($request->user['user']['id'])) {
                    $user_id = $request->user['user']['id'];
                    $user = User::find($user_id);
                    $user->points += 100;
                    $user->save();
                    $newRankMember = RankMember::where('min_points', '<=',  $user->points)
                        ->orderBy('min_points', 'desc')
                        ->first();
                    if ($newRankMember) {
                        $user->rank_member_id = $newRankMember->id;
                    }
                    $user->save();
                }

                Mail::to($request->user['user']['email'])
                    ->later(now()->addSeconds(10), new BookingConfirmed($bill, $checkin, $barcodeBase64));

                return response()->json([
                    'redirect_url' => $vnp_Url,
                    'data' => [
                        'bill' => $bill,
                        'checkin' => $checkin,
                        'barcode' => $barcodeBase64
                    ]
                ], 200);
            case 'momo':
                // MoMo
                $endpoint = "https://test-payment.momo.vn/gw_payment/transactionProcessor";

                $partnerCode = 'MOMOBKUN20180529';
                $accessKey = 'klm05TvNBzhg7h7j';
                $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

                $orderInfo = "Thanh toán qua MoMo";
                $amount = (string) $request->bill['grandTotal'];
                $orderId = time() . "";
                $returnUrl = "http://localhost:4200/confirmation";
                $notifyurl = "http://localhost:4200/confirmation";
                // Lưu ý: link notifyUrl không phải là dạng localhost
                $bankCode = "SML";

                $requestId = time() . "";
                $requestType = "payWithMoMoATM";
                $extraData = "";
                //before sign HMAC SHA256 signature
                $rawHashArr =  array(
                    'partnerCode' => $partnerCode,
                    'accessKey' => $accessKey,
                    'requestId' => $requestId,
                    'amount' => $amount,
                    'orderId' => $orderId,
                    'orderInfo' => $orderInfo,
                    'bankCode' => $bankCode,
                    'returnUrl' => $returnUrl,
                    'notifyUrl' => $notifyurl,
                    'extraData' => $extraData,
                    'requestType' => $requestType
                );
                // echo $serectkey;die;
                $rawHash = "partnerCode=" . $partnerCode . "&accessKey=" . $accessKey . "&requestId=" . $requestId . "&bankCode=" . $bankCode . "&amount=" . $amount . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&returnUrl=" . $returnUrl . "&notifyUrl=" . $notifyurl . "&extraData=" . $extraData . "&requestType=" . $requestType;
                $signature = hash_hmac("sha256", $rawHash, $secretKey);

                $data =  array(
                    'partnerCode' => $partnerCode,
                    'accessKey' => $accessKey,
                    'requestId' => $requestId,
                    'amount' => $amount,
                    'orderId' => $orderId,
                    'orderInfo' => $orderInfo,
                    'returnUrl' => $returnUrl,
                    'bankCode' => $bankCode,
                    'notifyUrl' => $notifyurl,
                    'extraData' => $extraData,
                    'requestType' => $requestType,
                    'signature' => $signature
                );
                $result = $this->execPostRequest($endpoint, json_encode($data));
                $jsonResult = json_decode($result, true);  // decode json

                $barcodeUrl = 'https://barcode.tec-it.com/barcode.ashx?data=' . $request->user['user']['email'] . '&code=Code128&dpi=96';
                $barcodeImage = file_get_contents($barcodeUrl);
                $barcodeBase64 = base64_encode($barcodeImage);

                $checkin = Checkin::create([
                    'name' => 'Check-in for bill ' . $request->user['user']['email'],
                    'checkin_code' => $barcodeBase64,
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

                if (isset($request->user['user']['id'])) {
                    $user_id = $request->user['user']['id'];
                    $user = User::find($user_id);
                    $user->points += 100;
                    $user->save();
                    $newRankMember = RankMember::where('min_points', '<=',  $user->points)
                        ->orderBy('min_points', 'desc')
                        ->first();
                    if ($newRankMember) {
                        $user->rank_member_id = $newRankMember->id;
                    }
                    $user->save();
                }

                Mail::to($request->user['user']['email'])
                    ->later(now()->addSeconds(10), new BookingConfirmed($bill, $checkin, $barcodeBase64));

                if (isset($jsonResult['payUrl'])) {
                    return response()->json([
                        'redirect_url' => $jsonResult['payUrl'],
                        'data' => [
                            'bill' => $bill,
                            'checkin' => $checkin,
                            'barcode' => $barcodeBase64
                        ]
                    ], 200);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'MoMo response missing payUrl'], 400);
                }
            case 'paypal':
                $provider = new PayPalClient;
                $provider->setApiCredentials(config('paypal'));
                $paypalToken = $provider->getAccessToken();

                $response = $provider->createOrder([
                    "intent" => "CAPTURE",
                    "application_context" => [
                        "return_url" => "http://localhost:4200/confirmation",
                        "cancel_url" => "http://localhost:4200/confirmation"
                    ],
                    "purchase_units" => [
                        [
                            "amount" => [
                                "currency_code" => "USD",
                                "value" => $request->bill['grandTotal']
                            ]
                        ]
                    ]
                ]);

                $barcodeUrl = 'https://barcode.tec-it.com/barcode.ashx?data=' . $request->user['user']['email'] . '&code=Code128&dpi=96';
                $barcodeImage = file_get_contents($barcodeUrl);
                $barcodeBase64 = base64_encode($barcodeImage);

                $checkin = Checkin::create([
                    'name' => 'Check-in for bill ' . $request->user['user']['email'],
                    'checkin_code' => $barcodeBase64,
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

                if (isset($request->user['user']['id'])) {
                    $user_id = $request->user['user']['id'];
                    $user = User::find($user_id);
                    $user->points += 100;
                    $user->save();
                    $newRankMember = RankMember::where('min_points', '<=',  $user->points)
                        ->orderBy('min_points', 'desc')
                        ->first();
                    if ($newRankMember) {
                        $user->rank_member_id = $newRankMember->id;
                    }
                    $user->save();
                }

                Mail::to($request->user['user']['email'])
                    ->later(now()->addSeconds(10), new BookingConfirmed($bill, $checkin, $barcodeBase64));

                if (isset($response['id']) && $response['id'] != null) {
                    foreach ($response['links'] as $link) {
                        if ($link['rel'] === 'approve') {
                            return response()->json([
                                'redirect_url' => $link['href'],
                                'data' => [
                                    'bill' => $bill,
                                    'checkin' => $checkin,
                                    'barcode' => $barcodeBase64
                                ]
                            ], 200);
                        }
                    }
                }
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
                'message' => 'Success',
                'data' => []
            ];
            return response()->json($arr, 200);
        }
        $arr = [
            'status' => true,
            'message' => 'Not Found',
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

    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }
}
