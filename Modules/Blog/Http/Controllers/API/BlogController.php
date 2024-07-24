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
    public function index()
    {
        $blog = Blog::latest()->take(3)->get();
        return response()->json([
            'status'=>true,
            'message'=>'Lấy danh sách thành công',
            'data' => $blog,
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


    public function getBlogByCategory($categoryId)
    {
        $blogs = Blog::all()->where('categories_id', $categoryId);
        return response()->json([
           'status'=> true,
           'message'=>'Lấy danh sách thành công',
           'data' => $blogs
        ], 200);
    }

    public function getAllCategory()
    {
        $categories = Category::withCount('blogs')->get();
        $allBlogs = Blog::get()->count();
        return response()->json([
           'status'=> true,
           'message'=>'Lấy danh sách thành công',
           'data' => $categories,
           'allBlogs' => $allBlogs // Sửa lại thành allBlogs
        ], 200);
    }
}
