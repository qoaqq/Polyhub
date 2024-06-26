<?php

namespace Modules\Movie\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Director\Entities\Director;
use Modules\Movie\Entities\Movie;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $title = "list Movies";
        $director = Director::all();
        
        // Truy vấn phim với điều kiện lọc theo đạo diễn nếu có
        $query = Movie::with('director');
        
        if ($request->filled('director_id')) {
            $query->where('director_id', $request->director_id);
        }

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }
        
        $movie = $query->latest('id')->paginate(5);
        
        return view('movie::index', compact('movie', 'director', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {   
        $title = "Add Movies";
        $director = Director::query()->pluck('name','id')->all();
        return view('movie::create',compact('title','director'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'duration' => 'required|numeric|min:60|max:240',
            'premiere_date' => 'required|date',
        ]);
    
        // Nếu dữ liệu không hợp lệ, trả về thông báo lỗi và dữ liệu đã nhập trước đó
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        Movie::query()->create($request->all());
        return redirect('/admin/movie')->with('success', 'Movie created successfully.');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $title = "Detail Movie";
        $movie = Movie::find($id);
        return view('movie::show', compact('movie','title'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $title = "Edit Movie";
        $movie = Movie::find($id);
        $director = Director::query()->pluck('name','id')->all();
        return view('movie::edit', compact('movie','title','director'));
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
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'duration' => 'required|numeric|min:60|max:240',
            'premiere_date' => 'required|date',
        ]);
    
        // Nếu dữ liệu không hợp lệ, trả về thông báo lỗi và dữ liệu đã nhập trước đó
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $movie = Movie::find($id);
        $movie ->update($request->all());
        $movie->save();
        return redirect('/admin/movie')->with('success', 'Updated Movie Successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $movie = Movie::find($id);
        $movie -> delete();
        return redirect('/admin/movie')->with('success', 'Deleted successfully !');
    }
}
