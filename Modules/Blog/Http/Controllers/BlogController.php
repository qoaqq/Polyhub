<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Modules\Blog\Entities\Blog;
use Modules\Category\Entities\Category;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $title = "List Blog";
        $category = Category::all();
        
        // Truy vấn phim với điều kiện lọc theo đạo diễn nếu có
        $query = Blog::with('category');
        
        if ($request->filled('categories_id')) {
            $query->where('categories_id', $request->categories_id);
        }

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where('title', 'like', '%' . $searchTerm . '%');
        }
        
        $blog = $query->latest('id')->paginate(5);
        return view('blog::index',compact('blog','title','category'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {   
        $title = "Add Blogs";
        $categories = Category::all();
        return view('blog::create',compact('title','categories'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);
    

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
    
        $blog = $request->except('image');
        $pathFile = Storage::putFile('blogs', $request->file('image'));
        $blog['image'] = 'storage/' . $pathFile;
        Blog::query()->create($blog);
        return redirect('/admin/blog')->with('success', 'Add Blog Successfully!');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $title = "Detail Blog";
        $blog = Blog::find($id);
        return view('blog::show', compact('title','blog'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $blog = Blog::find($id);
        $title = "Edit Blog";
        $category = Category::query()->pluck('name','id')->all();
        return view('blog::edit',compact('title','blog','category'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);
    

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $blogId = Blog::find($id);
        $blog = $request->except('image');

        if($request->hasFile('image')){
            $pathFile = Storage::putFile('blogs',$request->file('image'));
            $blog['image'] = 'storage/' . $pathFile;
        }

        $currentImage = $blogId->image;

        
        $blogId->update($blog);
        
        if($request->hasFile('image')
        && $currentImage
        && file_exists(public_path($currentImage)) 
        ) {
            unlink(public_path($currentImage));
        } 

        return redirect('/admin/blog')->with('success', 'Blog Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $blog = Blog::find($id);
        $blog -> delete();
        return redirect('/admin/blog')->with('success', 'Deleted Blog Successfully!');
    }
}
