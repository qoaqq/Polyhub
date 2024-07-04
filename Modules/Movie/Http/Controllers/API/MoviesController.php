<?php

namespace Modules\Movie\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Movie\Entities\Movie;

class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $movie = Movie::all();
        // return KhachHangResource::collection($khachHangs);
        return response()->json([
            'status'=>true,
            'message'=>'Lấy danh sách thành công',
            'data' => $movie,
        ],200);
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
        $movie = Movie::find($id);
        if (!$movie) {
            $arr = [
                'status'=>false,
                'message'=>'Không tìm thấy bài viết này',
                'data'=>[]
            ];
            return response()->json($arr,200);
        }
        $arr = [
            'status'=>true,
            'message'=>'Thông tin chi tiết bài viết',
            'data'=>$movie
        ];
        return response()->json($arr,200);
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
}
