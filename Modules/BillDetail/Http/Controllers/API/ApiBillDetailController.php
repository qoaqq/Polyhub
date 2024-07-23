<?php

namespace Modules\BillDetail\Http\Controllers\API;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\BillDetail\Entities\BillDetail;

class ApiBillDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $bill_details = BillDetail::all();
        return response()->json([
            'status' => true,
            'message' => 'Lấy danh sách thành công',
            'data' => $bill_details,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('billdetail::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
        $bill_detail = BillDetail::create($request->all());
        return response()->json($bill_detail, 201);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $bill_detail = BillDetail::find($id);
        if (!$bill_detail) {
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
            'data' => $bill_detail
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
        return view('billdetail::edit');
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
        $bill_detail = BillDetail::findOrFail($id);
        $bill_detail->update($request->all());
        return response()->json($bill_detail);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
        BillDetail::destroy($id);
        return response()->json(null, 204);
    }
}
