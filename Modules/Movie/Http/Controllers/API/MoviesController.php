<?php

namespace Modules\Movie\Http\Controllers\API;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Category\Entities\Category;
use Modules\Movie\Entities\Movie;

class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $movie = Movie::with('director', 'attributes', 'categories')->paginate(9);
        // return KhachHangResource::collection($khachHangs);
        return response()->json([
            'status'=> true,
            'message'=>'Lấy danh sách thành công',
            'data' => $movie,
        ], 200);
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
        $movie = Movie::with('category', 'director', 'attributes.attributeValues', 'actors')->find($id);
        if (!$movie) {
            $arr = [
                'status'=> false,
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

    public function search(Request $request)
    {
        $title = $request->get('title');
        if(empty($title)){
            $movie = Movie::with('director', 'attributes', 'category')->paginate(9);
        }else{
            $movies = Movie::with('director', 'attributes', 'category')->where('name', 'LIKE', '%'.$title.'%')->paginate(9);
        }
        return response()->json([
           'status'=> true,
           'message'=>'Tìm kiếm thành công',
           'data' => $movies,
           'title' => $title
        ], 200);
    }

    public function getMovieByCategory($categoryId)
    {
        $movies = Movie::with('director', 'attributes', 'category')->where('category_id', $categoryId)->paginate(9);
        return response()->json([
           'status'=> true,
           'message'=>'Lấy danh sách thành công',
           'data' => $movies
        ], 200);
    }

    public function getAllCategory()
    {
        $categories = Category::withCount('movies')->get();
        $allMovies = Movie::get()->count();
        return response()->json([
           'status'=> true,
           'message'=>'Lấy danh sách thành công',
           'data' => $categories,
           'allMovies' => $allMovies
        ], 200);
    }

    public function getTopMovies(){
        $currentMonth = Carbon::now()->month;

        // Truy vấn để lấy 7 phim có số lượng vé bán nhiều nhất trong tháng
        $topSellingMovies = Movie::select('movies.*', 'categories.name as cate_name',  DB::raw('count(tickets.id) as total_quantity'))
            ->join('tickets', 'movies.id', '=', 'tickets.movie_id')
            ->leftJoin('categories', 'movies.category_id', '=', 'categories.id')
            ->whereMonth('tickets.created_at', $currentMonth)
            ->groupBy('movies.id')
            ->orderBy('total_quantity', 'desc')
            ->take(7)
            ->get();

            return response()->json([
                'status'=> true,
                'message'=>'Lấy danh sách thành công',
                'data' => $topSellingMovies,
             ], 200);
    }

    public function home()
    {
        $currentDate = now(); // Lấy ngày và thời gian hiện tại
        $tenDaysAgo = now()->subDays(10); // Lấy ngày và thời gian của 10 ngày trước
    
        $movies = Movie::with('director', 'attributes', 'categories')
                    ->where('premiere_date', '<', $currentDate)
                    ->where('premiere_date', '>=', $tenDaysAgo)
                    ->paginate(8);
    
        return response()->json([
            'status'=> true,
            'message'=>'Lấy danh sách thành công',
            'data' => $movies,
        ], 200);
    }   
public function image()
    {
        $movie = Movie::with('director', 'attributes', 'categories')->paginate(6);
        
        // return KhachHangResource::collection($khachHangs);
        return response()->json([
            'status'=> true,
            'message'=>'Lấy danh sách thành công',
            'data' => $movie,
        ], 200);
    }
    public function upcoming()
    {
        $currentDate = now(); // Lấy ngày và thời gian hiện tại
    $currentDatePlus10Days = now()->addDays(10); // Lấy ngày hiện tại cộng thêm 10 ngày

    $movies = Movie::with('director', 'attributes', 'categories')
                ->where('premiere_date', '>', $currentDate)
                ->where('premiere_date', '<=', $currentDatePlus10Days)
                ->paginate(8);

    return response()->json([
        'status'=> true,
        'message'=>'Lấy danh sách thành công',
        'data' => $movies,
    ], 200);
    }
}
