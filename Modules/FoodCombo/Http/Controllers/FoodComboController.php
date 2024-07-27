<?php

namespace Modules\FoodCombo\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Modules\FoodCombo\Entities\FoodCombo;
use Modules\FoodCombo\Http\Requests\CreateFoodComboRequest;
use Modules\FoodCombo\Http\Requests\UpdateFoodComboRequest;

class FoodComboController extends Controller
{
    public function index(Request $request)
    {
        $title = "FoodCombo";
        $searchTerm = $request->input('search');
        $sortField = $request->input('sort_field', 'id'); 
        $sortDirection = $request->input('sort_direction', 'desc'); 

        $foodCombos = FoodCombo::search($searchTerm)->orderBy($sortField, $sortDirection)->paginate(8);

        return view('foodcombo::index', compact('foodCombos','searchTerm','sortField','sortDirection','title'));
    }

    public function create()
    {
        $title = "FoodCombo Create";
        return view('foodcombo::create', compact('title'));
    }

    public function store(CreateFoodComboRequest $request)
    {
    $foodComboData = $request->except(['avatar']);
    $pathFile = Storage::putFile('foodcombos', $request->file('avatar'));
    $foodComboData['avatar'] = 'storage/' . $pathFile;
    $foodCombo = FoodCombo::create($foodComboData);
    return redirect()->route('foodcombos.index')->with('success', 'Thêm thành công');
    }

    public function show($id)
    {
        $foodCombo = FoodCombo::find($id);
        $title = "FoodCombos Show";
        return view('foodcombo::show', compact('foodCombo'));
    }

    public function edit($id)
    {
        $foodCombo = FoodCombo::find($id);
        $title = "FoodCombo Edit";
        return view('foodcombo::edit', compact('foodCombo','title'));
    }

    public function update(UpdateFoodComboRequest $request, $id)
    {
        $foodCombo = FoodCombo::findOrFail($id);
        $foodComboData = $request->except(['avatar']);
        
        if ($request->hasFile('avatar')) {
            $pathFile = Storage::putFile('foodcombos', $request->file('avatar'));
            $foodComboData['avatar'] = 'storage/' . $pathFile;
        }
    
        $foodCombo->update($foodComboData);
        return redirect()->route('foodcombos.index')->with('success', 'Cập nhật thành công');
    }
    public function destroy($id)
    {
        $foodCombo = FoodCombo::find($id);
        $foodCombo->delete();
        return redirect()->route('foodcombos.index')->with('success', 'Xóa thành công!');
    }
}
