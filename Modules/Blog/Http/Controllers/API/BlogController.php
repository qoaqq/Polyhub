<?php

namespace Modules\Blog\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Blog\Entities\Blog;
use Modules\Blog\Transformers\BlogResource;
use Modules\Category\Entities\Category;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 5); // Số lượng bài viết mỗi trang
        $page = $request->input('page', 1); // Trang hiện tại

        $blogs = Blog::latest('id')->paginate($perPage);

        return response()->json([
            'status' => true,
            'message' => 'Lấy danh sách thành công',
            'data' => $blogs->items(), // Danh sách blog
            'current_page' => $blogs->currentPage(), // Trang hiện tại
            'total_pages' => $blogs->lastPage(), // Tổng số trang
            'total' => $blogs->total(), // Tổng số bài viết
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
    public function show(string $id)
    {
        $blog = Blog::find($id);
        if (!$blog) {
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
            'data'=>$blog
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
    public function bloghome()
    {
    // Get the 3 most recent blog posts
    $blogs = Blog::orderBy('created_at', 'desc')->take(3)->get();
    return response()->json([
        'status' => true,
        'message' => 'Lấy danh sách thành công',
        'data' => $blogs,
    ], 200);
    }


     public function getLatestBlogs()
    {
        $latestBlogs = Blog::orderBy('created_at', 'desc')->take(3)->get();
        return response()->json([
            'status' => true,
            'message' => 'Lấy danh sách thành công',
            'data' => $latestBlogs,
        ], 200);
    }

    public function getBlogByCategory(Request $request, $categoryId)
    {
        $perPage = $request->input('per_page', 5); // Số lượng bài viết mỗi trang
        $page = $request->input('page', 1); // Trang hiện tại

        $blogs = Blog::where('categories_id', $categoryId) // Lọc theo danh mục
                     ->latest()
                     ->paginate($perPage);

        return response()->json([
            'status' => true,
            'message' => 'Lấy danh sách bài viết theo danh mục thành công',
            'data' => $blogs->items(), // Danh sách blog
            'current_page' => $blogs->currentPage(), // Trang hiện tại
            'total_pages' => $blogs->lastPage(), // Tổng số trang
            'total' => $blogs->total(), // Tổng số bài viết
        ], 200);
    }


    public function getAllCategory()
    {
        $categories = Category::withCount('blogs')->get();
        $allBlogs = Blog::count();
        return response()->json([
            'status' => true,
            'message' => 'Lấy danh sách thành công',
            'data' => $categories,
            'allBlogs' => $allBlogs
        ], 200);
    }

    public function getTopBlogs(){
        $topBogs = Blog::with('category')->paginate(3);
        return response()->json([
           'status'=> true,
           'message'=>'Lấy danh sách thành công',
           'data' => $topBogs,
        ], 200);
    }
    public function getYearsAndCounts()
    {
        $years = Blog::selectRaw('YEAR(created_at) as year')
                    ->groupBy('year')
                    ->orderBy('year', 'desc')
                    ->get();

        $yearlyCounts = [];
        foreach ($years as $year) {
            $count = Blog::whereYear('created_at', $year->year)->count();
            $yearlyCounts[] = [
                'year' => $year->year,
                'count' => $count
            ];
        }

        return response()->json([
            'status' => true,
            'message' => 'Lấy danh sách năm và số lượng bài viết thành công',
            'data' => $yearlyCounts
        ], 200);
    }

    public function getBlogsByYear(Request $request, $year)
    {
        $page = $request->query('page', 1);
        $perPage = $request->query('per_page', 5);

        $blogsQuery = Blog::whereYear('created_at', $year);

        $total = $blogsQuery->count();
        $blogs = $blogsQuery->orderBy('created_at', 'desc')
                            ->skip(($page - 1) * $perPage)
                            ->take($perPage)
                            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Lấy danh sách bài viết theo năm thành công',
            'data' => [
                'blogs' => $blogs,
                'total' => $total,
                'current_page' => $page,
                'per_page' => $perPage,
                'total_pages' => ceil($total / $perPage),
            ]
        ], 200);
    }

    public function searchBlogs(Request $request)
    {
        $searchTerm = $request->query('search', '');
        $page = $request->query('page', 1);
        $perPage = $request->query('per_page', 5);

        // Tìm kiếm bài viết theo tên
        $blogsQuery = Blog::where('title', 'like', '%' . $searchTerm . '%');

        // Phân trang
        $total = $blogsQuery->count();
        $blogs = $blogsQuery->orderBy('created_at', 'desc')
                            ->skip(($page - 1) * $perPage)
                            ->take($perPage)
                            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Tìm kiếm bài viết thành công',
            'data' => [
                'blogs' => $blogs,
                'total' => $total,
                'current_page' => $page,
                'per_page' => $perPage,
                'total_pages' => ceil($total / $perPage),
            ]
        ], 200);
    }
}
