<?php

namespace Modules\Voucher\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Voucher\Entities\Voucher;

class VoucherAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        //
        $voucher = Voucher::all();
        return response()->json([
            'status' => true,
            'message' => 'Get data',
            'data' => $voucher
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
        $voucher =  Voucher::find($id);
        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công!',
            'data' => $voucher
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
    public function getAmountById($id){
        $voucher = Voucher::select('id', 'amount')->find($id);

        // Kiểm tra nếu voucher tồn tại
        if ($voucher) {
            // Trả về dữ liệu dưới dạng JSON
            return response()->json([
                'status' => true,
                'message' => 'Voucher found',
                'data' => $voucher
            ]);
        } else {
            // Nếu không tìm thấy voucher
            return response()->json([
                'status' => false,
                'message' => 'Voucher not found'
            ], 404);
        }
    }
    public function getVoucherById($id){
        $voucher = Voucher::select('id', 'code', 'type', 'amount')->find($id);

        // Kiểm tra nếu voucher tồn tại
        if ($voucher) {
            // Trả về dữ liệu dưới dạng JSON
            return response()->json([
                'status' => true,
                'message' => 'Voucher found',
                'data' => $voucher
            ]);
        } else {
            // Nếu không tìm thấy voucher
            return response()->json([
                'status' => false,
                'message' => 'Voucher not found'
            ], 404);
        }
    }
    public function applyVoucher(Request $request)
    {
        // Validate request
        $request->validate([
            'code' => 'required|string',
        ]);

        // Lấy code voucher từ request
        $code = $request->input('code');

        // Tìm voucher theo code
        $voucher = Voucher::where('code', $code)->first();

        if (!$voucher) {
            return response()->json(['message' => 'Voucher không hợp lệ.'], 400);
        }

        // Kiểm tra xem voucher có còn sử dụng được không
        if ($voucher->usage_limit <= 0) {
            return response()->json(['message' => 'Voucher đã hết lượt sử dụng.'], 400);
        }

        // Cập nhật số lượng usage_limit và used
        $voucher->usage_limit -= 1;
        $voucher->used += 1;
        $voucher->save();

        // Trả về phản hồi thành công
        return response()->json(['message' => 'Voucher áp dụng thành công.']);
    }
}
