<?php

namespace Modules\FoodCombo\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FoodCombo\Entities\FoodCombo;
use Modules\FoodCombo\Http\Requests\CreateFoodComboRequest;
use Modules\FoodCombo\Http\Requests\UpdateFoodComboRequest;

class FoodComboController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
        $sortField = $request->input('sort_field', 'id'); 
        $sortDirection = $request->input('sort_direction', 'desc'); 

        $foodCombos = FoodCombo::search($searchTerm)->orderBy($sortField, $sortDirection)->paginate(8);

        return view('foodcombo::index', compact('foodCombos','searchTerm','sortField','sortDirection'));
    }

    public function create()
    {
        return view('foodcombo::create');
    }

    public function store(CreateFoodComboRequest $request)
    {
        FoodCombo::create($request->all());
        return redirect()->route('foodcombos.index')->with('success', 'Thêm thành công');
    }

    public function show($id)
    {
        $foodCombo = FoodCombo::find($id);
        return view('foodcombo::show', compact('foodCombo'));
    }

    public function edit($id)
    {
        $foodCombo = FoodCombo::find($id);
        return view('foodcombo::edit', compact('foodCombo'));
    }

    public function update(UpdateFoodComboRequest $request, $id)
    {
        $foodCombo = FoodCombo::find($id);
        $foodCombo->update($request->all());
        return redirect()->route('foodcombos.index')->with('success', 'Cập nhật thành công');
    }
    public function destroy($id)
    {
        $foodCombo = FoodCombo::find($id);
        $foodCombo->delete();
        return redirect()->route('foodcombos.index')->with('success', 'Xóa thành công!');
    }
}
