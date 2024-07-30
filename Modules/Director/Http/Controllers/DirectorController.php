<?php

namespace Modules\Director\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Director\Entities\Director;

class DirectorController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $title = "List Dirctor";

        $query = Director::query();

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        $director = $query->latest('id')->paginate(6);
        return view('director::index', compact('director','title'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {   
        $title = "Add Director";
        return view('director::create',compact('title'));
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
            'age' => 'required|numeric|min:18|max:90',
            'date_of_birth' => 'required|date',
        ]);
    
        // Nếu dữ liệu không hợp lệ, trả về thông báo lỗi và dữ liệu đã nhập trước đó
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        Director::query()->create($request->all());
        return redirect('/admin/director')->with('success', 'Director created successfully.');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {   
        $title = "Detail Director";
        $director = Director::find($id);
        return view('director::show', compact('title','director'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {   
        $title = "Edit Director";
        $director = Director::find($id);
        return view('director::edit',compact('director','title'));
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
            'age' => 'required|numeric|min:18|max:90',
            'date_of_birth' => 'required|date',
        ]);
    
        // Nếu dữ liệu không hợp lệ, trả về thông báo lỗi và dữ liệu đã nhập trước đó
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $director = Director::find($id);
        $director->name = $request->input('name');
        $director->age = $request->input('age');
        $director->date_of_birth = $request->input('date_of_birth');
        $director->save();
        return redirect('/admin/director')->with('success', 'Director Edit Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $director = Director::find($id);
        $director -> delete();
        return redirect('/admin/director')->with('success', 'Deleted Director Successfully!');
    }
}
